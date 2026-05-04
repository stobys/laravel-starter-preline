<?php

namespace App\Console\Commands;

use App\Mail\SecurityAuditReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class SecurityAudit extends Command
{
    protected $signature = 'security:audit
                            {--notify : Wyślij e-mail jeśli wykryto luki}
                            {--force-notify : Wyślij e-mail nawet gdy brak luk}';

    protected $description = 'Uruchamia composer audit i zapisuje wynik do pliku JSON';

    /**
     * Ścieżka do pliku wynikowego (względem storage/app).
     */
    const OUTPUT_FILE = 'security/security-audit.json';

    public function handle(): int
    {
        $this->info('🔍 Uruchamianie composer audit...');

        // 1. Uruchom composer audit
        $process = new Process(
            ['composer', 'audit', '--format=json', '--no-interaction'],
            base_path(),
        );
        $process->setTimeout(120);
        $process->run();

        $exitCode = $process->getExitCode();

        // composer audit zwraca 0 = brak luk, 1 = są luki, >1 = błąd
        if ($exitCode > 1) {
            $this->error('❌ composer audit zakończył się błędem:');
            $this->line($process->getErrorOutput());
            return self::FAILURE;
        }

        // 2. Zapisz wynik do pliku
        $payload = [
            'scanned_at'  => now()->toIso8601String(),
            'exit_code'   => $exitCode,
            'raw'         => json_decode($process->getOutput(), true) ?? [],
            'error'       => $process->getErrorOutput() ?: null,
        ];

        Storage::put(self::OUTPUT_FILE, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('✅ Wynik zapisany do storage/app/' . self::OUTPUT_FILE);

        // 3. Podsumowanie w konsoli
        $vulnerabilities = $this->parseVulnerabilities($payload['raw']);
        $count           = $vulnerabilities->count();

        if ($count === 0) {
            $this->info('✅ Brak luk bezpieczeństwa.');
        } else {
            $this->newLine();
            $this->table(
                ['Pakiet', 'Wersja', 'Severity', 'CVE', 'Tytuł'],
                $vulnerabilities->map(fn($v) => [
                    $v['package_name'],
                    $v['package_version'],
                    strtoupper($v['severity']),
                    $v['cve_id'] ?? '–',
                    \Illuminate\Support\Str::limit($v['title'], 55),
                ])->toArray(),
            );
            $this->warn("⚠️  Znaleziono {$count} luk/ę bezpieczeństwa.");
        }

        // 4. E-mail
        $shouldNotify = $this->option('force-notify')
            || ($this->option('notify') && $count > 0);

        if ($shouldNotify) {
            $this->sendMail($vulnerabilities);
        }

        return $count === 0 ? self::SUCCESS : self::FAILURE;
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Parsuje surowy JSON z composer audit do flat collection.
     */
    public static function parseVulnerabilities(array $raw): \Illuminate\Support\Collection
    {
        $advisories = $raw['advisories'] ?? [];

        return collect($advisories)
            ->flatMap(function (array $list, string $packageName) {
                return collect($list)->map(fn($a) => [
                    'package_name'    => $packageName,
                    'package_version' => $a['installedVersion'] ?? 'unknown',
                    'advisory_id'     => $a['advisoryId'] ?? null,
                    'cve_id'          => $a['cve'] ?? null,
                    'title'           => $a['title'] ?? 'Unknown',
                    'severity'        => strtolower($a['severity'] ?? 'unknown'),
                    'affected'        => $a['affectedVersions'] ?? null,
                    'link'            => $a['link'] ?? null,
                ]);
            })
            ->sortByDesc(fn($v) => array_search($v['severity'], ['unknown', 'low', 'medium', 'high', 'critical']))
            ->values();
    }

    private function sendMail(\Illuminate\Support\Collection $vulnerabilities): void
    {
        $to = config('security.audit.notification_email', config('mail.from.address'));

        if (blank($to)) {
            $this->warn('⚠️  Brak adresu e-mail (SECURITY_AUDIT_EMAIL).');
            return;
        }

        try {
            Mail::to($to)->send(new SecurityAuditReport($vulnerabilities));
            $this->info("📧 Powiadomienie wysłane na {$to}");
        } catch (\Exception $e) {
            $this->error('❌ Błąd wysyłki: ' . $e->getMessage());
            Log::error('security:audit mail error', ['error' => $e->getMessage()]);
        }
    }
}
