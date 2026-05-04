<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;background:#f4f4f5;color:#18181b}
.wrap{max-width:660px;margin:0 auto;padding:32px 16px}
.card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.head{padding:28px 32px;background:linear-gradient(135deg,#1e1b4b,#4338ca)}
.head small{display:block;color:#a5b4fc;font-size:11px;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px}
.head h1{color:#fff;font-size:20px;font-weight:700}
.head p{color:#c7d2fe;font-size:13px;margin-top:6px}
.stats{display:flex;border-bottom:1px solid #f1f5f9}
.stat{flex:1;padding:18px 12px;text-align:center;border-right:1px solid #f1f5f9}
.stat:last-child{border-right:none}
.stat b{display:block;font-size:26px;font-weight:800;line-height:1}
.stat span{display:block;font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#71717a;margin-top:3px}
.c-total b{color:#18181b} .c-crit b{color:#dc2626} .c-high b{color:#ea580c} .c-med b{color:#d97706} .c-low b{color:#2563eb}
.banner{padding:12px 32px;font-size:13px;font-weight:500}
.banner-crit{background:#fef2f2;color:#991b1b;border-bottom:1px solid #fecaca}
.banner-high{background:#fff7ed;color:#9a3412;border-bottom:1px solid #fed7aa}
.section{padding:24px 32px}
.section h2{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.6px;color:#71717a;margin-bottom:14px}
.item{border:1px solid #e4e4e7;border-radius:8px;padding:14px 16px;margin-bottom:10px}
.item:last-child{margin-bottom:0}
.item-head{display:flex;align-items:flex-start;justify-content:space-between;gap:8px;margin-bottom:6px}
.item-title{font-size:14px;font-weight:600;color:#09090b}
.badge{display:inline-block;padding:2px 9px;border-radius:999px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;white-space:nowrap}
.b-critical{background:#fee2e2;color:#b91c1c}
.b-high{background:#ffedd5;color:#c2410c}
.b-medium{background:#fef9c3;color:#a16207}
.b-low{background:#dbeafe;color:#1d4ed8}
.b-unknown{background:#f4f4f5;color:#52525b}
.meta{font-size:11px;color:#71717a}
.meta span{margin-right:12px}
.link{display:inline-block;margin-top:6px;font-size:11px;color:#4f46e5;text-decoration:none}
.foot{padding:20px 32px;background:#fafafa;border-top:1px solid #f1f5f9}
.foot p{font-size:11px;color:#a1a1aa;line-height:1.7}
.foot a{color:#6366f1}
code{background:#f1f5f9;padding:1px 5px;border-radius:4px;font-size:10px}
</style>
</head>
<body>
<div class="wrap">
<div class="card">

  <div class="head">
    <small>{{ config('app.name') }} · Security Audit</small>
    <h1>⚠️ {{ $stats['total'] }} {{ $stats['total'] === 1 ? 'luka bezpieczeństwa' : 'luki bezpieczeństwa' }}</h1>
    <p>Skan z dnia {{ \Carbon\Carbon::parse($scannedAt)->format('d.m.Y \o H:i') }}</p>
  </div>

  @if($stats['critical'] > 0)
    <div class="banner banner-crit">🔴 Wykryto {{ $stats['critical'] }} krytyczn{{ $stats['critical'] === 1 ? 'ą lukę' : 'e luki' }} — wymagana natychmiastowa reakcja.</div>
  @elseif($stats['high'] > 0)
    <div class="banner banner-high">🟠 Wykryto luki o wysokim priorytecie — zalecana szybka aktualizacja.</div>
  @endif

  <div class="stats">
    <div class="stat c-total"><b>{{ $stats['total'] }}</b><span>Łącznie</span></div>
    <div class="stat c-crit"><b>{{ $stats['critical'] }}</b><span>Krytyczne</span></div>
    <div class="stat c-high"><b>{{ $stats['high'] }}</b><span>Wysokie</span></div>
    <div class="stat c-med"><b>{{ $stats['medium'] }}</b><span>Średnie</span></div>
    <div class="stat c-low"><b>{{ $stats['low'] }}</b><span>Niskie</span></div>
  </div>

  <div class="section">
    <h2>Szczegóły luk</h2>

    @foreach($vulnerabilities as $v)
      <div class="item">
        <div class="item-head">
          <div class="item-title">{{ $v['title'] }}</div>
          <span class="badge b-{{ $v['severity'] ?? 'unknown' }}">{{ strtoupper($v['severity'] ?? 'unknown') }}</span>
        </div>
        <div class="meta">
          <span>📦 {{ $v['package_name'] }} v{{ $v['package_version'] }}</span>
          @if($v['cve_id']) <span>🔖 {{ $v['cve_id'] }}</span> @endif
        </div>
        @if($v['link'])
          <a href="{{ $v['link'] }}" class="link">🔗 Zobacz advisory →</a>
        @endif
      </div>
    @endforeach
  </div>

  <div class="foot">
    <p>
      Raport wygenerowany automatycznie przez <strong>{{ config('app.name') }}</strong>.<br>
      Panel bezpieczeństwa: <a href="{{ config('app.url') }}/admin/security">{{ config('app.url') }}/admin/security</a><br>
      Aby zaktualizować pakiet: <code>composer update &lt;pakiet&gt;</code>
    </p>
  </div>

</div>
</div>
</body>
</html>
