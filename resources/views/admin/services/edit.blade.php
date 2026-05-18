@extends('admin.layout')

@section('title', 'Modifier Service')
@section('page-title', 'Modifier : ' . $service->name)

@section('topbar-actions')
    <a href="{{ route('admin.services.index') }}" class="btn btn-ghost btn-sm">← Retour</a>
@endsection

@section('content')

<div class="card" style="max-width:680px;">
    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Nom du service *</label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}">
            @error('name') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Prix (DT) *</label>
                <input type="number" name="price" value="{{ old('price', $service->price) }}" step="0.01" min="0">
                @error('price') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Durée (minutes) *</label>
                <input type="number" name="duration" value="{{ old('duration', $service->duration) }}" min="1">
                @error('duration') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3">{{ old('description', $service->description) }}</textarea>
            @error('description') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Statut *</label>
                <select name="state">
                    <option value="active"   {{ old('state', $service->state) === 'active'   ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ old('state', $service->state) === 'inactive' ? 'selected' : '' }}>Inactif</option>
                </select>
            </div>
            <div class="form-group">
                <label>Image</label>
                @if($service->image)
                    <img src="{{ asset('storage/'.$service->image) }}" class="current-img" alt="Image actuelle">
                @endif
                <input type="file" name="image" accept="image/*">
                @error('image') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-gold">Enregistrer les modifications</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

@endsection
