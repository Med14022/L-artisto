@extends('admin.layout')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')

{{-- ── STAT CARDS ──────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon gold">👤</div>
        <div>
            <div class="stat-number">{{ $stats['total_clients'] }}</div>
            <div class="stat-label">Clients inscrits</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold">✂️</div>
        <div>
            <div class="stat-number">{{ $stats['total_coiffeurs'] }}</div>
            <div class="stat-label">Coiffeurs</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">🎯</div>
        <div>
            <div class="stat-number">{{ $stats['total_services'] }}</div>
            <div class="stat-label">Services actifs</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">⏳</div>
        <div>
            <div class="stat-number">{{ $stats['rdv_en_attente'] }}</div>
            <div class="stat-label">RDV en attente</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div>
            <div class="stat-number">{{ $stats['rdv_confirmes'] }}</div>
            <div class="stat-label">RDV confirmés</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">🏁</div>
        <div>
            <div class="stat-number">{{ $stats['rdv_termines'] }}</div>
            <div class="stat-label">RDV terminés</div>
        </div>
    </div>
</div>

{{-- ── GRAPHIQUES LIGNE 1 : Activité mensuelle + Statuts ───────────────────── --}}
<div class="charts-row">

    {{-- Graphique 1 : RDV par mois --}}
    <div class="card chart-card">
        <div class="card-header">
            <div class="card-title">Activité mensuelle</div>
            <span style="font-size:11px;color:var(--text-muted);">6 derniers mois</span>
        </div>
        <div class="chart-wrap">
            <canvas id="chartMois"></canvas>
        </div>
    </div>

    {{-- Graphique 2 : Répartition statuts --}}
    <div class="card chart-card">
        <div class="card-header">
            <div class="card-title">Statuts des RDV</div>
            <span style="font-size:11px;color:var(--text-muted);">Répartition globale</span>
        </div>
        <div class="chart-wrap" style="display:flex;align-items:center;justify-content:center;">
            <canvas id="chartStatuts" style="max-width:220px;max-height:220px;"></canvas>
        </div>
        {{-- Légende custom --}}
        <div id="statutLegend" style="display:flex;flex-wrap:wrap;gap:10px;margin-top:16px;justify-content:center;"></div>
    </div>

</div>

{{-- ── GRAPHIQUES LIGNE 2 : Top services + RDV par coiffeur ───────────────── --}}
<div class="charts-row">

    {{-- Graphique 3 : Top services --}}
    <div class="card chart-card">
        <div class="card-header">
            <div class="card-title">Services les plus demandés</div>
            <span style="font-size:11px;color:var(--text-muted);">Top 5</span>
        </div>
        <div class="chart-wrap">
            <canvas id="chartServices"></canvas>
        </div>
    </div>

    {{-- Graphique 4 : RDV par coiffeur --}}
    <div class="card chart-card">
        <div class="card-header">
            <div class="card-title">RDV par coiffeur</div>
            <span style="font-size:11px;color:var(--text-muted);">Total cumulé</span>
        </div>
        <div class="chart-wrap">
            <canvas id="chartCoiffeurs"></canvas>
        </div>
    </div>

</div>

{{-- ── DERNIERS RDV ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Derniers Rendez-vous</div>
        <a href="{{ route('admin.rendez-vous.index') }}" class="btn btn-ghost btn-sm">Voir tout →</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Coiffeur</th>
                <th>Service(s)</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_rdvs as $rdv)
            @php $badges = ['en attente'=>'badge-pending','confirmé'=>'badge-confirmed','terminé'=>'badge-done','annulé'=>'badge-cancelled']; @endphp
            <tr>
                <td style="font-weight:600;">
                    {{ $rdv->client->name ?? $rdv->nom_client ?? '—' }}
                    @if(!$rdv->id_client && $rdv->telephone_client)
                        <div style="font-size:11px;color:var(--gold);">📞 {{ $rdv->telephone_client }}</div>
                    @endif
                </td>
                <td>{{ $rdv->coiffeur->name ?? '—' }}</td>
                <td style="color:var(--text-muted);">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</td>
                <td>{{ substr($rdv->heure,0,5) }}</td>
                <td><span class="badge {{ $badges[$rdv->etat] ?? '' }}">{{ $rdv->etat }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:32px;">Aucun rendez-vous pour l'instant.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('styles')
<style>
    .charts-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .chart-card { margin-bottom: 0; }
    .chart-wrap { position: relative; height: 240px; display: flex; align-items: center; justify-content: center; }
    @media (max-width: 900px) { .charts-row { grid-template-columns: 1fr; } }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const gold        = '#D4AF37';
const goldLight   = '#FFD700';
const goldAlpha   = 'rgba(212,175,55,0.15)';
const textMuted   = '#7a7060';
const gridColor   = 'rgba(255,255,255,0.05)';

Chart.defaults.color = textMuted;
Chart.defaults.font.family = 'Inter, sans-serif';
Chart.defaults.font.size   = 12;

// ── 1. RDV PAR MOIS (bar chart) ───────────────────────────────────────────────
const moisLabels = @json($rdvParMois->pluck('label'));
const moisData   = @json($rdvParMois->pluck('count'));

new Chart(document.getElementById('chartMois'), {
    type: 'bar',
    data: {
        labels: moisLabels,
        datasets: [{
            label: 'Rendez-vous',
            data: moisData,
            backgroundColor: moisData.map((_, i) => i === moisData.length - 1 ? gold : goldAlpha),
            borderColor: gold,
            borderWidth: 1,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: gridColor }, ticks: { color: textMuted } },
            y: { grid: { color: gridColor }, ticks: { color: textMuted, stepSize: 1 }, beginAtZero: true }
        }
    }
});

// ── 2. RÉPARTITION STATUTS (doughnut) ────────────────────────────────────────
const statutData = @json($rdvParStatut);
const statutColors = {
    'en attente': '#D4AF37',
    'confirmé':   '#4ade80',
    'terminé':    '#818cf8',
    'annulé':     '#f87171',
};
const statutLabels = Object.keys(statutData);
const statutValues = Object.values(statutData);

new Chart(document.getElementById('chartStatuts'), {
    type: 'doughnut',
    data: {
        labels: statutLabels,
        datasets: [{
            data: statutValues,
            backgroundColor: statutLabels.map(l => statutColors[l] ?? '#555'),
            borderColor: '#0c0c14',
            borderWidth: 3,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label} : ${ctx.raw} RDV`
                }
            }
        }
    }
});

// Légende custom pour le doughnut
const legendEl = document.getElementById('statutLegend');
statutLabels.forEach((label, i) => {
    const color = statutColors[label] ?? '#555';
    legendEl.innerHTML += `
        <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#e2ddd5;">
            <span style="width:10px;height:10px;border-radius:50%;background:${color};display:inline-block;flex-shrink:0;"></span>
            ${label.charAt(0).toUpperCase() + label.slice(1)}
            <strong style="color:${color};">${statutValues[i]}</strong>
        </div>`;
});

// ── 3. TOP SERVICES (horizontal bar) ─────────────────────────────────────────
const servicesData = @json($topServices);
new Chart(document.getElementById('chartServices'), {
    type: 'bar',
    data: {
        labels: servicesData.map(s => s.name),
        datasets: [{
            label: 'Demandes',
            data: servicesData.map(s => s.total),
            backgroundColor: [
                'rgba(212,175,55,0.85)',
                'rgba(212,175,55,0.65)',
                'rgba(212,175,55,0.45)',
                'rgba(212,175,55,0.30)',
                'rgba(212,175,55,0.18)',
            ],
            borderColor: gold,
            borderWidth: 1,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: gridColor }, ticks: { color: textMuted, stepSize: 1 }, beginAtZero: true },
            y: { grid: { display: false }, ticks: { color: '#e2ddd5', font: { weight: '500' } } }
        }
    }
});

// ── 4. RDV PAR COIFFEUR (bar chart) ──────────────────────────────────────────
const coifData = @json($rdvParCoiffeur);
new Chart(document.getElementById('chartCoiffeurs'), {
    type: 'bar',
    data: {
        labels: coifData.map(c => c.name),
        datasets: [{
            label: 'RDV',
            data: coifData.map(c => c.total),
            backgroundColor: 'rgba(129,140,248,0.3)',
            borderColor: '#818cf8',
            borderWidth: 1,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: gridColor }, ticks: { color: '#e2ddd5' } },
            y: { grid: { color: gridColor }, ticks: { color: textMuted, stepSize: 1 }, beginAtZero: true }
        }
    }
});
</script>
@endpush
