@extends('admin.layout')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')

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
                <td style="font-weight:600;">{{ $rdv->client->name ?? '—' }}</td>
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
