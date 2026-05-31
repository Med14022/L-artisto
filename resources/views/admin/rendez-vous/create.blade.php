@extends('admin.layout')

@section('title', 'Nouveau Rendez-vous')
@section('page-title', 'Nouveau Rendez-vous')

@section('topbar-actions')
    <a href="{{ route('admin.rendez-vous.index') }}" class="btn btn-ghost btn-sm">← Retour</a>
@endsection

@section('content')

<div class="card" style="max-width:760px;">
    <form method="POST" action="{{ route('admin.rendez-vous.store') }}">
        @csrf

        {{-- ── CLIENT ────────────────────────────────────────── --}}
        <div class="form-group">
            <label>Client <span style="color:var(--text-muted);font-weight:400;text-transform:none;">(optionnel si invité)</span></label>
            <select name="id_client" id="clientSelect" onchange="toggleGuestName(this.value)">
                <option value="">— Invité / sans compte —</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('id_client') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} — {{ $client->email }}
                    </option>
                @endforeach
            </select>
            @error('id_client') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        {{-- ── COIFFEUR ───────────────────────────────────────── --}}
        <div class="form-group">
            <label>Coiffeur *</label>
            <select name="id_coiffeur" required>
                <option value="">— Sélectionner un coiffeur —</option>
                @foreach($coiffeurs as $coiffeur)
                    <option value="{{ $coiffeur->id }}" {{ old('id_coiffeur') == $coiffeur->id ? 'selected' : '' }}>
                        {{ $coiffeur->name }}
                    </option>
                @endforeach
            </select>
            @error('id_coiffeur') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        {{-- ── SERVICES ───────────────────────────────────────── --}}
        <div class="form-group">
            <label>Service(s) *</label>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;margin-top:4px;">
                @foreach($services as $service)
                <label class="service-checkbox-label" style="cursor:pointer;display:flex;align-items:center;gap:10px;padding:12px 14px;background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:10px;transition:border-color 0.2s;">
                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                        {{ in_array($service->id, old('service_ids', [])) ? 'checked' : '' }}
                        style="accent-color:var(--gold);width:16px;height:16px;flex-shrink:0;">
                    <span>
                        <span style="font-size:13px;font-weight:600;color:var(--text);display:block;">{{ $service->name }}</span>
                        <span style="font-size:11px;color:var(--text-muted);">{{ $service->duration }} min · {{ $service->price }} DT</span>
                    </span>
                </label>
                @endforeach
            </div>
            @error('service_ids') <div class="error-msg" style="margin-top:8px;">{{ $message }}</div> @enderror
        </div>

        {{-- ── DATE & HEURE ────────────────────────────────────── --}}
        <div class="form-row">
            <div class="form-group">
                <label>Date *</label>
                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required min="{{ date('Y-m-d') }}">
                @error('date') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Heure *</label>
                <select name="heure" required>
                    <option value="">— Choisir l'heure —</option>
                    @foreach(['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30'] as $h)
                        <option value="{{ $h }}" {{ old('heure') === $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
                @error('heure') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ── STATUT ──────────────────────────────────────────── --}}
        <div class="form-group">
            <label>Statut *</label>
            <select name="etat" required>
                @foreach(['en attente' => 'En attente', 'confirmé' => 'Confirmé', 'terminé' => 'Terminé', 'annulé' => 'Annulé'] as $val => $label)
                    <option value="{{ $val }}" {{ old('etat', 'en attente') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('etat') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-gold">✓ Créer le rendez-vous</button>
            <a href="{{ route('admin.rendez-vous.index') }}" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

@push('styles')
<style>
    .service-checkbox-label:has(input:checked) {
        border-color: rgba(212,175,55,0.5);
        background: rgba(212,175,55,0.06);
    }
</style>
@endpush

@endsection
