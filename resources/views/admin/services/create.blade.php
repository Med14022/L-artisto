@extends('admin.layout')

@section('title', 'Nouveau Service')
@section('page-title', 'Nouveau Service')

@section('topbar-actions')
    <a href="{{ route('admin.services.index') }}" class="btn btn-ghost btn-sm">← Retour</a>
@endsection

@section('content')

<div class="card" style="max-width:680px;">
    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nom du service *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex : Coupe homme classique">
            @error('name') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Prix (DT) *</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" placeholder="25.00">
                @error('price') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Durée (minutes) *</label>
                <input type="number" name="duration" value="{{ old('duration') }}" min="1" placeholder="30">
                @error('duration') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" placeholder="Description du service...">{{ old('description') }}</textarea>
            @error('description') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Statut *</label>
                <select name="state">
                    <option value="active"   {{ old('state') === 'active'   ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ old('state') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                </select>
                @error('state') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*">
                @error('image') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-gold">Enregistrer le service</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

@endsection
