<!DOCTYPE html>
<html lang="pl" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Budget Dashboard — Hermes</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300..700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root,[data-theme="light"]{
  --color-bg:#f7f6f2;--color-surface:#f9f8f5;--color-surface-2:#fbfbf9;
  --color-surface-offset:#f3f0ec;--color-surface-dynamic:#e6e4df;--color-divider:#dcd9d5;--color-border:#d4d1ca;
  --color-text:#28251d;--color-text-muted:#7a7974;--color-text-faint:#bab9b4;--color-text-inverse:#f9f8f4;
  --color-primary:#01696f;--color-primary-hover:#0c4e54;--color-primary-highlight:#cedcd8;
  --color-success:#437a22;--color-success-highlight:#d4dfcc;
  --color-warning:#964219;--color-warning-highlight:#ddcfc6;
  --color-error:#a12c7b;--color-error-highlight:#e0ced7;
  --color-gold:#d19900;--color-gold-highlight:#e9e0c6;
  --color-blue:#006494;--color-blue-highlight:#c6d8e4;
  --color-orange:#da7101;
  --radius-sm:.375rem;--radius-md:.5rem;--radius-lg:.75rem;--radius-xl:1rem;--radius-full:9999px;
  --transition-interactive:180ms cubic-bezier(0.16,1,0.3,1);
  --shadow-sm:0 1px 2px oklch(0.2 0.01 80/.06);--shadow-md:0 4px 12px oklch(0.2 0.01 80/.08);
  --shadow-lg:0 12px 32px oklch(0.2 0.01 80/.12);
  --font-body:'Inter','Helvetica Neue',sans-serif;--font-mono:'JetBrains Mono',monospace;
  --text-xs:clamp(.75rem,.7rem + .25vw,.875rem);--text-sm:clamp(.875rem,.8rem + .35vw,1rem);
  --text-base:clamp(1rem,.95rem + .25vw,1.125rem);--text-lg:clamp(1.125rem,1rem + .75vw,1.5rem);
  --text-xl:clamp(1.5rem,1.2rem + 1.25vw,2.25rem);
  --space-1:.25rem;--space-2:.5rem;--space-3:.75rem;--space-4:1rem;--space-5:1.25rem;
  --space-6:1.5rem;--space-8:2rem;--space-10:2.5rem;--space-12:3rem;--space-16:4rem;
  --content-wide:1200px;
}
[data-theme="dark"]{
  --color-bg:#171614;--color-surface:#1c1b19;--color-surface-2:#201f1d;
  --color-surface-offset:#1d1c1a;--color-surface-dynamic:#2d2c2a;--color-divider:#262523;--color-border:#393836;
  --color-text:#cdccca;--color-text-muted:#797876;--color-text-faint:#5a5957;--color-text-inverse:#2b2a28;
  --color-primary:#4f98a3;--color-primary-hover:#227f8b;--color-primary-highlight:#313b3b;
  --color-success:#6daa45;--color-success-highlight:#3a4435;
  --color-warning:#bb653b;--color-warning-highlight:#564942;
  --color-error:#d163a7;--color-error-highlight:#4c3d46;
  --color-gold:#e8af34;--color-gold-highlight:#4d4332;
  --color-blue:#5591c7;--color-blue-highlight:#3a4550;
  --color-orange:#fdab43;
  --shadow-sm:0 1px 2px oklch(0 0 0/.2);--shadow-md:0 4px 12px oklch(0 0 0/.3);
  --shadow-lg:0 12px 32px oklch(0 0 0/.4);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{-webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility;scroll-behavior:smooth}
body{min-height:100dvh;font-family:var(--font-body);font-size:var(--text-base);color:var(--color-text);background:var(--color-bg);line-height:1.6}
img{display:block;max-width:100%}
button{cursor:pointer;background:none;border:none;font:inherit;color:inherit}
table{border-collapse:collapse;width:100%}
a,button,[role="button"]{transition:color var(--transition-interactive),background var(--transition-interactive),border-color var(--transition-interactive),box-shadow var(--transition-interactive)}
:focus-visible{outline:2px solid var(--color-primary);outline-offset:3px;border-radius:var(--radius-sm)}

/* Layout */
.app{display:grid;grid-template-columns:220px 1fr;min-height:100dvh}
.sidebar{background:var(--color-surface);border-right:1px solid var(--color-border);display:flex;flex-direction:column;position:sticky;top:0;height:100dvh;overflow-y:auto}
.sidebar-logo{padding:var(--space-6) var(--space-5);display:flex;align-items:center;gap:var(--space-3);border-bottom:1px solid var(--color-border)}
.sidebar-logo svg{flex-shrink:0}
.logo-text{font-size:var(--text-sm);font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--color-primary)}
.sidebar-nav{padding:var(--space-4) var(--space-3);flex:1}
.nav-section{margin-bottom:var(--space-6)}
.nav-label{font-size:var(--text-xs);font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--color-text-faint);padding:0 var(--space-2) var(--space-2)}
.nav-item{display:flex;align-items:center;gap:var(--space-3);padding:var(--space-2) var(--space-3);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-text-muted);text-decoration:none;cursor:pointer}
.nav-item:hover{background:var(--color-surface-dynamic);color:var(--color-text)}
.nav-item.active{background:var(--color-primary-highlight);color:var(--color-primary);font-weight:500}
.nav-item svg{flex-shrink:0;opacity:.7}
.nav-item.active svg{opacity:1}

.main{display:flex;flex-direction:column;min-width:0}
.topbar{display:flex;align-items:center;justify-content:space-between;padding:var(--space-4) var(--space-8);border-bottom:1px solid var(--color-border);background:var(--color-surface);position:sticky;top:0;z-index:10}
.topbar-title{font-size:var(--text-lg);font-weight:600}
.topbar-actions{display:flex;align-items:center;gap:var(--space-3)}
.btn{display:inline-flex;align-items:center;gap:var(--space-2);padding:var(--space-2) var(--space-4);border-radius:var(--radius-md);font-size:var(--text-sm);font-weight:500;cursor:pointer;border:none;transition:all var(--transition-interactive)}
.btn-primary{background:var(--color-primary);color:var(--color-text-inverse)}
.btn-primary:hover{background:var(--color-primary-hover)}
.btn-ghost{background:transparent;color:var(--color-text-muted);border:1px solid var(--color-border)}
.btn-ghost:hover{background:var(--color-surface-dynamic);color:var(--color-text)}

.content{padding:var(--space-8);flex:1;max-width:var(--content-wide)}

/* KPI Cards */
.kpi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(220px,100%),1fr));gap:var(--space-4);margin-bottom:var(--space-8)}
.kpi-card{background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:var(--space-5);box-shadow:var(--shadow-sm);position:relative;overflow:hidden}
.kpi-card::before{content:'';position:absolute;inset:0;opacity:.04;background:linear-gradient(135deg,var(--kpi-accent),transparent)}
.kpi-label{font-size:var(--text-xs);font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--color-text-muted);margin-bottom:var(--space-2)}
.kpi-value{font-size:var(--text-xl);font-weight:700;font-variant-numeric:tabular-nums lining-nums;color:var(--color-text);line-height:1;margin-bottom:var(--space-2)}
.kpi-sub{font-size:var(--text-xs);color:var(--color-text-muted);display:flex;align-items:center;gap:var(--space-1)}
.kpi-badge{display:inline-flex;align-items:center;gap:2px;padding:2px var(--space-2);border-radius:var(--radius-full);font-size:var(--text-xs);font-weight:600}
.badge-up{background:var(--color-success-highlight);color:var(--color-success)}
.badge-down{background:var(--color-error-highlight);color:var(--color-error)}
.badge-neutral{background:var(--color-surface-dynamic);color:var(--color-text-muted)}
.kpi-icon{position:absolute;top:var(--space-4);right:var(--space-4);width:32px;height:32px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;background:var(--kpi-accent-bg)}
.kpi-icon svg{opacity:.8}

/* Charts grid */
.charts-grid{display:grid;grid-template-columns:2fr 1fr;gap:var(--space-4);margin-bottom:var(--space-8)}
.chart-card{background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:var(--space-6);box-shadow:var(--shadow-sm)}
.chart-card.full{grid-column:1/-1}
.chart-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:var(--space-6)}
.chart-title{font-size:var(--text-base);font-weight:600;color:var(--color-text)}
.chart-subtitle{font-size:var(--text-xs);color:var(--color-text-muted);margin-top:2px}
.chart-body{position:relative;height:260px}

/* Table */
.table-card{background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;box-shadow:var(--shadow-sm);margin-bottom:var(--space-8)}
.table-header{display:flex;align-items:center;justify-content:space-between;padding:var(--space-5) var(--space-6);border-bottom:1px solid var(--color-border)}
.table-title{font-size:var(--text-base);font-weight:600}
.data-table th{font-size:var(--text-xs);font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--color-text-muted);padding:var(--space-3) var(--space-6);text-align:left;border-bottom:1px solid var(--color-border);background:var(--color-surface-offset)}
.data-table td{padding:var(--space-4) var(--space-6);font-size:var(--text-sm);border-bottom:1px solid var(--color-divider);font-variant-numeric:tabular-nums}
.data-table tr:last-child td{border-bottom:none}
.data-table tr:hover td{background:var(--color-surface-dynamic)}
.progress-bar{height:6px;background:var(--color-surface-dynamic);border-radius:var(--radius-full);overflow:hidden;min-width:80px}
.progress-fill{height:100%;border-radius:var(--radius-full);transition:width .6s cubic-bezier(0.16,1,0.3,1)}
.state-badge{display:inline-flex;align-items:center;gap:var(--space-1);padding:2px var(--space-2);border-radius:var(--radius-full);font-size:var(--text-xs);font-weight:500}
.state-dot{width:6px;height:6px;border-radius:50%}

/* Theme toggle */
.theme-toggle{width:36px;height:36px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:var(--color-text-muted)}
.theme-toggle:hover{background:var(--color-surface-dynamic);color:var(--color-text)}

/* Year selector */
.year-tabs{display:flex;gap:var(--space-1);background:var(--color-surface-offset);border-radius:var(--radius-lg);padding:3px}
.year-tab{padding:var(--space-1) var(--space-3);border-radius:var(--radius-md);font-size:var(--text-xs);font-weight:500;color:var(--color-text-muted);cursor:pointer;transition:all var(--transition-interactive)}
.year-tab.active{background:var(--color-surface-2);color:var(--color-text);box-shadow:var(--shadow-sm)}

/* Section divider */
.section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:var(--space-4)}
.section-title{font-size:var(--text-base);font-weight:600;color:var(--color-text-muted)}

/* Utilization bar */
.util-wrap{display:flex;align-items:center;gap:var(--space-3)}
.util-pct{font-size:var(--text-xs);font-weight:600;font-variant-numeric:tabular-nums;min-width:2.5rem;text-align:right}

/* Responsive */
@media(max-width:768px){
  .app{grid-template-columns:1fr}
  .sidebar{display:none}
  .charts-grid{grid-template-columns:1fr}
  .content{padding:var(--space-4)}
  .topbar{padding:var(--space-4)}
}
</style>
</head>
<body>
<div class="app">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <svg width="28" height="28" viewBox="0 0 28 28" fill="none" aria-label="Hermes logo">
        <rect width="28" height="28" rx="7" fill="var(--color-primary)" opacity=".15"/>
        <path d="M7 10h14M7 14h10M7 18h6" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round"/>
        <circle cx="20" cy="18" r="3" stroke="var(--color-primary)" stroke-width="1.5" fill="none"/>
        <path d="M22.5 20.5L25 23" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      <span class="logo-text">Hermes</span>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-section">
        <div class="nav-label">Szkolenia</div>
        <a class="nav-item" href="#">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
          Przegląd
        </a>
        <a class="nav-item" href="#">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1z"/></svg>
          Szkolenia
        </a>
        <a class="nav-item active" href="#">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="2" x2="12" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 1 0 0 7h5a3.5 3.5 0 1 1 0 7H6"/></svg>
          Budżety
        </a>
        <a class="nav-item" href="#">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Uczestnicy
        </a>
      </div>
      <div class="nav-section">
        <div class="nav-label">Administracja</div>
        <a class="nav-item" href="#">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          Działy
        </a>
        <a class="nav-item" href="#">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M12 2v2m0 16v2"/></svg>
          Ustawienia
        </a>
      </div>
    </nav>
  </aside>

  <!-- Main -->
  <div class="main">
    <header class="topbar">
      <div class="topbar-title">Dashboard budżetowy</div>
      <div class="topbar-actions">
        <div class="year-tabs" id="yearTabs">
          <div class="year-tab" data-year="2024">2024</div>
          <div class="year-tab active" data-year="2025">2025</div>
          <div class="year-tab" data-year="2026">2026</div>
        </div>
        <button class="theme-toggle" data-theme-toggle aria-label="Przełącz motyw">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>
      </div>
    </header>

    <main class="content">
      <!-- KPI row -->
      <div class="kpi-grid" id="kpiGrid"></div>

      <!-- Charts -->
      <div class="charts-grid">
        <div class="chart-card">
          <div class="chart-header">
            <div>
              <div class="chart-title">Wykorzystanie budżetu per kwartał</div>
              <div class="chart-subtitle">Planowany koszt szkoleń vs. budżet łączny (FY2025)</div>
            </div>
          </div>
          <div class="chart-body"><canvas id="quarterChart"></canvas></div>
        </div>
        <div class="chart-card">
          <div class="chart-header">
            <div>
              <div class="chart-title">Stany szkoleń</div>
              <div class="chart-subtitle">Rozkład wg statusu (FY2025)</div>
            </div>
          </div>
          <div class="chart-body"><canvas id="stateChart"></canvas></div>
        </div>
        <div class="chart-card full">
          <div class="chart-header">
            <div>
              <div class="chart-title">Trend uczestnictwa w szkoleniach</div>
              <div class="chart-subtitle">Liczba przeszkolonych (z powtórzeniami) — 3 lata</div>
            </div>
          </div>
          <div class="chart-body"><canvas id="trendChart"></canvas></div>
        </div>
      </div>

      <!-- Budget table -->
      <div class="table-card">
        <div class="table-header">
          <div class="table-title">Zestawienie budżetów rocznych</div>
          <button class="btn btn-ghost">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Eksport CSV
          </button>
        </div>
        <div style="overflow-x:auto">
          <table class="data-table" id="budgetTable">
            <thead>
              <tr>
                <th>Rok fiskalny</th>
                <th>Budżet (PLN)</th>
                <th>Koszt planowany</th>
                <th>Koszt rzeczywisty</th>
                <th>Szkolenia</th>
                <th>Przeszkoleni</th>
                <th>Unikalni</th>
                <th>Wykorzystanie</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="budgetTableBody"></tbody>
          </table>
        </div>
      </div>

      <!-- Top trainings -->
      <div class="table-card">
        <div class="table-header">
          <div class="table-title">Top 5 — najdroższe szkolenia (FY2025)</div>
        </div>
        <div style="overflow-x:auto">
          <table class="data-table" id="topTrainingsTable">
            <thead>
              <tr>
                <th>Tytuł</th>
                <th>Dostawca</th>
                <th>Uczestnicy</th>
                <th>Koszt planowany</th>
                <th>Koszt/uczestnik</th>
                <th>Stan</th>
              </tr>
            </thead>
            <tbody id="topTrainingsBody"></tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<script>
// ── Mock data ──────────────────────────────────────────────────────────
const budgetsData = {
  2024: { budget: 120000, planned_cost: 98400, actual_cost: 91200, trainings_count: 18, participants_count: 67, unique_participants: 43 },
  2025: { budget: 150000, planned_cost: 127500, actual_cost: 89200, trainings_count: 24, participants_count: 91, unique_participants: 58 },
  2026: { budget: 160000, planned_cost: 48300, actual_cost: 0,      trainings_count: 9,  participants_count: 27, unique_participants: 22 },
};

const quarterData = {
  labels: ['Q1 2025','Q2 2025','Q3 2025','Q4 2025'],
  planned: [28000, 42000, 35000, 22500],
  budget_share: [37500, 37500, 37500, 37500],
};

const stateData = {
  labels: ['Zaplanowane','W trakcie','Zakończone','Anulowane'],
  values: [5, 3, 14, 2],
};

const trendData = {
  labels: ['Q1 24','Q2 24','Q3 24','Q4 24','Q1 25','Q2 25','Q3 25','Q4 25','Q1 26'],
  participants: [12, 18, 21, 16, 19, 27, 29, 16, 27],
};

const topTrainings = [
  { title: 'Akademia Liderów', provider: 'House of Skills', participants: 8, planned_cost: 24000, state: 'Zakończone', state_key: 'done' },
  { title: 'Excel dla zaawansowanych', provider: 'Altkom Akademia', participants: 12, planned_cost: 18600, state: 'Zakończone', state_key: 'done' },
  { title: 'Szkolenie BHP specjalistyczne', provider: 'BHP Expert', participants: 6, planned_cost: 14400, state: 'W trakcie', state_key: 'active' },
  { title: 'Zarządzanie projektami PRINCE2', provider: 'PM Academy', participants: 4, planned_cost: 12800, state: 'Zakończone', state_key: 'done' },
  { title: 'Komunikacja i negocjacje', provider: 'Skillup', participants: 9, planned_cost: 11250, state: 'Zaplanowane', state_key: 'planned' },
];

const stateColors = {
  planned: { bg: 'var(--color-gold-highlight)', color: 'var(--color-gold)', dot: '#e8af34' },
  active:  { bg: 'var(--color-blue-highlight)', color: 'var(--color-blue)', dot: '#5591c7' },
  done:    { bg: 'var(--color-success-highlight)', color: 'var(--color-success)', dot: '#6daa45' },
  cancelled:{ bg: 'var(--color-error-highlight)', color: 'var(--color-error)', dot: '#d163a7' },
};

// ── Helpers ────────────────────────────────────────────────────────────
const fmt = n => new Intl.NumberFormat('pl-PL').format(Math.round(n));
const pct = n => Math.round(n * 10) / 10;
const isDark = () => document.documentElement.getAttribute('data-theme') === 'dark';
const textColor = () => isDark() ? '#cdccca' : '#28251d';
const mutedColor = () => isDark() ? '#797876' : '#7a7974';
const borderColor = () => isDark() ? '#393836' : '#d4d1ca';
const surfaceColor = () => isDark() ? '#201f1d' : '#fbfbf9';

// ── KPI Cards ──────────────────────────────────────────────────────────
let currentYear = 2025;

function renderKPIs(year) {
  const d = budgetsData[year];
  const prevYear = year - 1;
  const prev = budgetsData[prevYear];
  const util = d.planned_cost / d.budget * 100;
  const costPerPart = d.participants_count > 0 ? d.actual_cost / d.participants_count : 0;
  const avgPerTraining = d.trainings_count > 0 ? d.planned_cost / d.trainings_count : 0;

  const kpis = [
    {
      label: 'Budżet roczny',
      value: fmt(d.budget) + ' zł',
      sub: prev ? (d.budget > prev.budget ? `+${fmt(d.budget - prev.budget)} vs ${prevYear}` : `=${prevYear}`) : '',
      badge: null,
      icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="2" x2="12" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 1 0 0 7h5a3.5 3.5 0 1 1 0 7H6"/></svg>`,
      accent: 'var(--color-primary)', accentBg: 'var(--color-primary-highlight)',
    },
    {
      label: 'Planowany koszt',
      value: fmt(d.planned_cost) + ' zł',
      sub: `${pct(util)}% budżetu`,
      badge: util > 90 ? { type: 'down', text: 'Wysoki' } : util > 60 ? { type: 'neutral', text: 'Normalny' } : { type: 'up', text: 'Niski' },
      icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>`,
      accent: 'var(--color-gold)', accentBg: 'var(--color-gold-highlight)',
    },
    {
      label: 'Liczba szkoleń',
      value: d.trainings_count,
      sub: prev ? `${d.trainings_count > prev.trainings_count ? '+' : ''}${d.trainings_count - (prev?.trainings_count||0)} vs ${prevYear}` : '',
      badge: prev ? (d.trainings_count > (prev?.trainings_count||0) ? { type: 'up', text: `+${d.trainings_count - (prev?.trainings_count||0)}` } : { type: 'neutral', text: '—' }) : null,
      icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>`,
      accent: 'var(--color-blue)', accentBg: 'var(--color-blue-highlight)',
    },
    {
      label: 'Przeszkoleni (razem)',
      value: d.participants_count,
      sub: `${d.unique_participants} unikalnych pracowników`,
      badge: null,
      icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`,
      accent: 'var(--color-success)', accentBg: 'var(--color-success-highlight)',
    },
    {
      label: 'Koszt / uczestnik',
      value: d.participants_count > 0 ? fmt(costPerPart) + ' zł' : '—',
      sub: 'na podstawie kosztu realnego',
      badge: null,
      icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>`,
      accent: 'var(--color-orange)', accentBg: 'var(--color-warning-highlight)',
    },
    {
      label: 'Śr. koszt szkolenia',
      value: d.trainings_count > 0 ? fmt(avgPerTraining) + ' zł' : '—',
      sub: 'planowany',
      badge: null,
      icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>`,
      accent: 'var(--color-primary)', accentBg: 'var(--color-primary-highlight)',
    },
  ];

  const grid = document.getElementById('kpiGrid');
  grid.innerHTML = kpis.map(k => `
    <div class="kpi-card" style="--kpi-accent:${k.accent};--kpi-accent-bg:${k.accentBg}">
      <div class="kpi-icon" style="background:${k.accentBg};color:${k.accent}">${k.icon}</div>
      <div class="kpi-label">${k.label}</div>
      <div class="kpi-value">${k.value}</div>
      <div class="kpi-sub">
        ${k.badge ? `<span class="kpi-badge badge-${k.badge.type}">${k.badge.text}</span>` : ''}
        ${k.sub ? `<span>${k.sub}</span>` : ''}
      </div>
    </div>
  `).join('');
}

// ── Budget Table ───────────────────────────────────────────────────────
function renderBudgetTable() {
  const tbody = document.getElementById('budgetTableBody');
  tbody.innerHTML = Object.entries(budgetsData).sort((a,b) => b[0]-a[0]).map(([yr, d]) => {
    const util = d.planned_cost / d.budget * 100;
    const utilColor = util > 90 ? 'var(--color-error)' : util > 70 ? 'var(--color-gold)' : 'var(--color-primary)';
    const isCurrentYear = parseInt(yr) <= 2025;
    return `<tr>
      <td style="font-weight:600;font-variant-numeric:tabular-nums">${yr}</td>
      <td>${fmt(d.budget)} zł</td>
      <td>${fmt(d.planned_cost)} zł</td>
      <td>${d.actual_cost > 0 ? fmt(d.actual_cost) + ' zł' : '<span style="color:var(--color-text-faint)">—</span>'}</td>
      <td>${d.trainings_count}</td>
      <td>${d.participants_count}</td>
      <td>${d.unique_participants}</td>
      <td>
        <div class="util-wrap">
          <div class="progress-bar" style="flex:1"><div class="progress-fill" style="width:${Math.min(util,100)}%;background:${utilColor}"></div></div>
          <span class="util-pct" style="color:${utilColor}">${pct(util)}%</span>
        </div>
      </td>
      <td>
        <span class="state-badge" style="background:${parseInt(yr) < 2026 ? 'var(--color-success-highlight)' : 'var(--color-gold-highlight)'};color:${parseInt(yr) < 2026 ? 'var(--color-success)' : 'var(--color-gold)'}">
          <span class="state-dot" style="background:${parseInt(yr) < 2026 ? '#6daa45' : '#e8af34'}"></span>
          ${parseInt(yr) < 2026 ? 'Zamknięty' : 'Aktywny'}
        </span>
      </td>
    </tr>`;
  }).join('');
}

// ── Top Trainings ──────────────────────────────────────────────────────
function renderTopTrainings() {
  const tbody = document.getElementById('topTrainingsBody');
  tbody.innerHTML = topTrainings.map(t => {
    const s = stateColors[t.state_key];
    const cpp = t.participants > 0 ? Math.round(t.planned_cost / t.participants) : 0;
    return `<tr>
      <td style="font-weight:500">${t.title}</td>
      <td style="color:var(--color-text-muted)">${t.provider}</td>
      <td>${t.participants}</td>
      <td>${fmt(t.planned_cost)} zł</td>
      <td style="font-family:var(--font-mono);font-size:var(--text-xs)">${fmt(cpp)} zł</td>
      <td>
        <span class="state-badge" style="background:${s.bg};color:${s.color}">
          <span class="state-dot" style="background:${s.dot}"></span>
          ${t.state}
        </span>
      </td>
    </tr>`;
  }).join('');
}

// ── Charts ─────────────────────────────────────────────────────────────
let quarterChartInst, stateChartInst, trendChartInst;

function chartDefaults() {
  return {
    color: textColor(),
    plugins: {
      legend: { labels: { color: mutedColor(), font: { family: "'Inter'" }, boxWidth: 12, padding: 16 } },
      tooltip: { backgroundColor: surfaceColor(), titleColor: textColor(), bodyColor: mutedColor(), borderColor: borderColor(), borderWidth: 1, padding: 10 }
    },
    scales: {
      x: { ticks: { color: mutedColor(), font: { family: "'Inter'", size: 11 } }, grid: { color: borderColor() } },
      y: { ticks: { color: mutedColor(), font: { family: "'Inter'", size: 11 }, callback: v => fmt(v) + ' zł' }, grid: { color: borderColor() } }
    }
  };
}

function buildCharts() {
  const cd = chartDefaults();

  // Quarter bar chart
  if (quarterChartInst) quarterChartInst.destroy();
  quarterChartInst = new Chart(document.getElementById('quarterChart'), {
    type: 'bar',
    data: {
      labels: quarterData.labels,
      datasets: [
        { label: 'Limit kwartalny', data: quarterData.budget_share, backgroundColor: isDark() ? 'rgba(79,152,163,.15)' : 'rgba(1,105,111,.1)', borderColor: isDark() ? 'rgba(79,152,163,.4)' : 'rgba(1,105,111,.3)', borderWidth: 1, borderRadius: 4, type: 'bar' },
        { label: 'Koszt planowany', data: quarterData.planned, backgroundColor: isDark() ? 'rgba(79,152,163,.7)' : 'rgba(1,105,111,.75)', borderRadius: 4, type: 'bar' },
      ]
    },
    options: { ...cd, responsive: true, maintainAspectRatio: false, plugins: { ...cd.plugins, legend: { ...cd.plugins.legend, position: 'top' } } }
  });

  // State doughnut
  if (stateChartInst) stateChartInst.destroy();
  stateChartInst = new Chart(document.getElementById('stateChart'), {
    type: 'doughnut',
    data: {
      labels: stateData.labels,
      datasets: [{
        data: stateData.values,
        backgroundColor: ['rgba(232,175,52,.75)','rgba(85,145,199,.75)','rgba(109,170,69,.75)','rgba(209,99,167,.75)'],
        borderColor: isDark() ? '#1c1b19' : '#f9f8f5',
        borderWidth: 2,
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false, cutout: '65%',
      plugins: { ...cd.plugins, legend: { ...cd.plugins.legend, position: 'bottom' } }
    }
  });

  // Trend line
  if (trendChartInst) trendChartInst.destroy();
  trendChartInst = new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
      labels: trendData.labels,
      datasets: [{
        label: 'Przeszkoleni pracownicy',
        data: trendData.participants,
        borderColor: isDark() ? '#4f98a3' : '#01696f',
        backgroundColor: isDark() ? 'rgba(79,152,163,.1)' : 'rgba(1,105,111,.08)',
        borderWidth: 2,
        fill: true,
        tension: .35,
        pointRadius: 4,
        pointHoverRadius: 6,
        pointBackgroundColor: isDark() ? '#4f98a3' : '#01696f',
      }]
    },
    options: {
      ...cd, responsive: true, maintainAspectRatio: false,
      scales: {
        x: { ticks: { color: mutedColor(), font: { family: "'Inter'", size: 11 } }, grid: { color: borderColor() } },
        y: { ticks: { color: mutedColor(), font: { family: "'Inter'", size: 11 }, stepSize: 5 }, grid: { color: borderColor() } }
      },
      plugins: { ...cd.plugins, legend: { display: false } }
    }
  });
}

// ── Init & Events ──────────────────────────────────────────────────────
renderKPIs(2025);
renderBudgetTable();
renderTopTrainings();
buildCharts();

document.getElementById('yearTabs').addEventListener('click', e => {
  const tab = e.target.closest('[data-year]');
  if (!tab) return;
  document.querySelectorAll('.year-tab').forEach(t => t.classList.remove('active'));
  tab.classList.add('active');
  currentYear = parseInt(tab.dataset.year);
  renderKPIs(currentYear);
});

// Theme toggle
(function(){
  const t = document.querySelector('[data-theme-toggle]');
  const r = document.documentElement;
  let d = 'dark';
  t && t.addEventListener('click', () => {
    d = d === 'dark' ? 'light' : 'dark';
    r.setAttribute('data-theme', d);
    t.innerHTML = d === 'dark'
      ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>'
      : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>';
    setTimeout(() => buildCharts(), 50);
  });
})();
</script>
</body>
</html>
