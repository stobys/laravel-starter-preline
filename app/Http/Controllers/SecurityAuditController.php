<?php

namespace App\Http\Controllers;

use App\Console\Commands\SecurityAudit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SecurityAuditController extends Controller
{
    public function index(Request $request)
    {
        $severity = $request->get('severity');
        $search   = $request->get('search');

        // Wczytaj plik JSON
        $auditData     = $this->readAuditFile();
        $scannedAt     = $auditData['scanned_at'] ?? null;
        $vulnerabilities = SecurityAudit::parseVulnerabilities($auditData['raw'] ?? []);

        // Filtry (po stronie PHP, bo dane są już w pamięci)
        if ($severity) {
            $vulnerabilities = $vulnerabilities->filter(fn($v) => $v['severity'] === $severity);
        }
        if ($search) {
            $s = strtolower($search);
            $vulnerabilities = $vulnerabilities->filter(
                fn($v) => str_contains(strtolower($v['package_name']), $s)
                    || str_contains(strtolower($v['title']), $s)
                    || str_contains(strtolower($v['cve_id'] ?? ''), $s)
            );
        }

        $allVulnerabilities = SecurityAudit::parseVulnerabilities($auditData['raw'] ?? []);
        $by = $allVulnerabilities->groupBy('severity');

        $stats = [
            'total'    => $allVulnerabilities->count(),
            'critical' => $by->get('critical', collect())->count(),
            'high'     => $by->get('high', collect())->count(),
            'medium'   => $by->get('medium', collect())->count(),
            'low'      => $by->get('low', collect())->count(),
            'packages' => $allVulnerabilities->pluck('package_name')->unique()->count(),
        ];

        return view('security.index', compact(
            'vulnerabilities',
            'stats',
            'scannedAt',
            'severity',
            'search',
        ));
    }

    /**
     * Uruchamia audyt przez AJAX i odświeża plik.
     */
    public function runAudit()
    {
        try {
            Artisan::call('security:audit');
            return response()->json(['success' => true, 'message' => 'Audyt zakończony.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function readAuditFile(): array
    {
        if (! Storage::exists(SecurityAudit::OUTPUT_FILE)) {
            return [];
        }

        $content = Storage::get(SecurityAudit::OUTPUT_FILE);
        return json_decode($content, true) ?? [];
    }
}
