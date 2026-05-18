@extends('admin.layout')

@section('title', 'Services')
@section('page-title', 'Gestion des Services')

@section('topbar-actions')
    <a href="{{ route('admin.services.create') }}" class="btn btn-gold">+ Nouveau service</a>
@endsection

@section('content')

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Durée</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>
                    @if($service->image)
                        <img src="{{ asset('storage/'.$service->image) }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid var(--border);">
                    @else
                        <div style="width:48px;height:48px;background:rgba(212,175,55,0.08);border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:20px;">✂️</div>
                    @endif
                </td>
                <td style="font-weight:600;color:var(--text);">{{ $service->name }}</td>
                <td style="color:var(--gold);font-weight:700;font-size:15px;">{{ number_format($service->price,2) }} DT</td>
                <td style="color:var(--text-muted);">{{ $service->duration }} min</td>
                <td style="color:var(--text-muted);max-width:180px;font-size:12px;">{{ Str::limit($service->description, 55) }}</td>
                <td>
                    <span class="badge {{ $service->state === 'active' ? 'badge-active' : 'badge-inactive' }}">
                        {{ $service->state === 'active' ? 'Actif' : 'Inactif' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-gold btn-sm">Modifier</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                              onsubmit="return confirm('Supprimer ce service ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">
                Aucun service enregistré. <a href="{{ route('admin.services.create') }}" style="color:var(--gold);">Créer le premier →</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination" style="margin-top:20px;">{{ $services->links() }}</div>
</div>

@endsection
