@extends('admin.layout')

@section('title', 'Rendez-vous')
@section('page-title', 'Gestion des Rendez-vous')

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
