@extends('admin.layout')

@section('title', 'Clients')
@section('page-title', 'Gestion des Clients')

@section('content')

<div class="card">
    <div class="table-wrap"><table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Inscrit le</th>
                <th>Total RDV</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td style="color:var(--text-muted);font-size:12px;">#{{ $client->id }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#B8860B,#FFD700);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#0a0a0a;flex-shrink:0;">
                            {{ strtoupper(substr($client->name, 0, 1)) }}
                        </div>
                        <span style="font-weight:600;">{{ $client->name }}</span>
                    </div>
                </td>
                <td style="color:var(--text-muted);">{{ $client->email }}</td>
                <td style="color:var(--text-muted);">{{ $client->phone ?? '—' }}</td>
                <td style="font-size:12px;color:var(--text-muted);">{{ $client->created_at->format('d/m/Y') }}</td>
                <td>
                    <span style="font-weight:700;color:var(--gold);">{{ $client->total_rdv }}</span>
                    <span style="font-size:11px;color:var(--text-muted);"> RDV</span>
                </td>
                <td>
                    <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-ghost btn-sm">Voir profil →</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">Aucun client inscrit.</td></tr>
            @endforelse
        </tbody>
    </table></div>
    <div class="pagination" style="margin-top:20px;">{{ $clients->links() }}</div>
</div>

@endsection
