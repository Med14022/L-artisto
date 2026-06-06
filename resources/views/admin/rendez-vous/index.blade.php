@extends('admin.layout')

@section('title', 'Rendez-vous')
@section('page-title', 'Gestion des Rendez-vous')

@section('topbar-actions')
    @php $mois = request('mois', now()->format('Y-m')); @endphp
    <form method="GET" action="{{ route('admin.rendez-vous.index') }}" style="display:flex;align-items:center;gap:8px;">
        <input type="month" name="mois" value="{{ $mois }}"
            style="padding:6px 10px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:8px;color:var(--text);font-family:'Inter',sans-serif;font-size:12px;">
        <button type="submit" class="btn btn-ghost btn-sm">Filtrer</button>
    </form>
    <a href="{{ route('admin.export.pdf-mensuel', ['mois' => $mois]) }}" target="_blank" class="btn btn-sm" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;">📄 PDF</a>
    <a href="{{ route('admin.export.csv', ['mois' => $mois]) }}" class="btn btn-sm" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#4ade80;">📊 CSV</a>
    <a href="{{ route('admin.rendez-vous.create') }}" class="btn btn-gold btn-sm">+ Nouveau RDV</a>
@endsection

@section('content')

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Coiffeur</th>
                <th>Service(s)</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rdvs as $rdv)
            @php $badges = ['en attente'=>'badge-pending','confirmé'=>'badge-confirmed','terminé'=>'badge-done','annulé'=>'badge-cancelled']; @endphp
            <tr>
                <td style="color:var(--text-muted);font-size:12px;">#{{ $rdv->id }}</td>
                <td style="font-weight:600;">{{ $rdv->client->name ?? '—' }}</td>
                <td>{{ $rdv->coiffeur->name ?? '—' }}</td>
                <td style="color:var(--text-muted);font-size:12px;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</td>
                <td>{{ substr($rdv->heure,0,5) }}</td>
                <td><span class="badge {{ $badges[$rdv->etat] ?? '' }}">{{ $rdv->etat }}</span></td>
                <td>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <form method="POST" action="{{ route('admin.rendez-vous.update-status', $rdv) }}">
                            @csrf @method('PATCH')
                            <select name="etat" onchange="this.form.submit()"
                                style="padding:5px 10px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:6px;color:var(--text);font-family:'Inter',sans-serif;font-size:12px;cursor:pointer;">
                                @foreach(['en attente','confirmé','terminé','annulé'] as $etat)
                                    <option value="{{ $etat }}" {{ $rdv->etat === $etat ? 'selected' : '' }}>{{ ucfirst($etat) }}</option>
                                @endforeach
                            </select>
                        </form>
                        <form method="POST" action="{{ route('admin.rendez-vous.destroy', $rdv) }}"
                              onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">✕</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px;">Aucun rendez-vous enregistré.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination" style="margin-top:20px;">{{ $rdvs->links() }}</div>
</div>

@endsection
