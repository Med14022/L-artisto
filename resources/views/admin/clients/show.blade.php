@extends('admin.layout')

@section('title', 'Profil — ' . $user->name)
@section('page-title', 'Profil Client')

@section('topbar-actions')
    <a href="{{ route('admin.clients.index') }}" class="btn btn-ghost btn-sm">← Retour</a>
@endsection

@section('content')

{{-- ── EN-TÊTE CLIENT ────────────────────────────────────────────────────────── --}}
<div class="client-header card" style="display:flex;align-items:center;gap:24px;margin-bottom:20px;">
    <div class="client-avatar-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    <div style="flex:1;">
        <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--text);margin-bottom:4px;">
            {{ $user->name }}
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:16px;color:var(--text-muted);font-size:13px;">
            <span>✉ {{ $user->email }}</span>
            @if($user->phone)  <span>📞 {{ $user->phone }}</span> @endif
            @if($user->address)<span>📍 {{ $user->address }}</span>@endif
            <span>📅 Membre depuis le {{ $user->created_at->format('d/m/Y') }}</span>
        </div>
    </div>
</div>

{{-- ── MINI STATS ────────────────────────────────────────────────────────────── --}}
<div class="stats-grid" style="grid-template-columns:repeat(5,1fr);margin-bottom:20px;">
    <div class="stat-card">
        <div class="stat-icon gold">📋</div>
        <div>
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Total RDV</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">🏁</div>
        <div>
            <div class="stat-number">{{ $stats['termines'] }}</div>
            <div class="stat-label">Terminés</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div>
            <div class="stat-number">{{ $stats['confirmes'] }}</div>
            <div class="stat-label">Confirmés</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">⏳</div>
        <div>
            <div class="stat-number">{{ $stats['en_attente'] }}</div>
            <div class="stat-label">En attente</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(239,68,68,0.1);">❌</div>
        <div>
            <div class="stat-number">{{ $stats['annules'] }}</div>
            <div class="stat-label">Annulés</div>
        </div>
    </div>
</div>

{{-- ── PRÉFÉRENCES ───────────────────────────────────────────────────────────── --}}
@if($servicesFavori || $coiffeurFavori)
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    @if($servicesFavori)
    <div class="card" style="display:flex;align-items:center;gap:16px;padding:18px 22px;">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(212,175,55,0.12);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">✂️</div>
        <div>
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:4px;">Service favori</div>
            <div style="font-weight:700;color:var(--text);font-size:15px;">{{ $servicesFavori->name }}</div>
            <div style="font-size:12px;color:var(--gold);">{{ $servicesFavori->total }} fois réservé</div>
        </div>
    </div>
    @endif

    @if($coiffeurFavori)
    <div class="card" style="display:flex;align-items:center;gap:16px;padding:18px 22px;">
        <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#B8860B,#FFD700);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;color:#0a0a0a;flex-shrink:0;">
            {{ strtoupper(substr($coiffeurFavori->name, 0, 1)) }}
        </div>
        <div>
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:4px;">Coiffeur préféré</div>
            <div style="font-weight:700;color:var(--text);font-size:15px;">{{ $coiffeurFavori->name }}</div>
        </div>
    </div>
    @endif

</div>
@endif

{{-- ── HISTORIQUE COMPLET ────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Historique des Rendez-vous</div>
        <span style="font-size:12px;color:var(--text-muted);">{{ $rdvs->count() }} au total</span>
    </div>

    @if($rdvs->isEmpty())
        <p style="text-align:center;color:var(--text-muted);padding:40px;">Aucun rendez-vous pour ce client.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Coiffeur</th>
                <th>Service(s)</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rdvs as $rdv)
            @php $badges = ['en attente'=>'badge-pending','confirmé'=>'badge-confirmed','terminé'=>'badge-done','annulé'=>'badge-cancelled']; @endphp
            <tr>
                <td style="font-weight:600;">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</td>
                <td style="color:var(--gold);font-weight:600;">{{ substr($rdv->heure, 0, 5) }}</td>
                <td>{{ $rdv->coiffeur->name ?? '—' }}</td>
                <td style="color:var(--text-muted);font-size:12px;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
                <td><span class="badge {{ $badges[$rdv->etat] ?? '' }}">{{ $rdv->etat }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection

@push('styles')
<style>
    .client-avatar-lg {
        width: 72px; height: 72px; border-radius: 50%;
        background: linear-gradient(135deg, #B8860B, #FFD700);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; font-weight: 700; color: #0a0a0a;
        flex-shrink: 0;
        box-shadow: 0 0 24px rgba(212,175,55,0.3);
    }
</style>
@endpush
