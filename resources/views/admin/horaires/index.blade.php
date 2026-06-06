@extends('admin.layout')

@section('title', 'Horaires')
@section('page-title', 'Gestion des Horaires')

@section('content')

{{-- ── SÉLECTEUR DE COIFFEUR ────────────────────────────────────────────────── --}}
<div class="card" style="margin-bottom:20px;">
    <form method="GET" action="{{ route('admin.horaires.index') }}" style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
        <label style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);white-space:nowrap;">
            Coiffeur
        </label>
        <select name="coiffeur_id" onchange="this.form.submit()"
            style="padding:9px 14px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:8px;color:var(--text);font-family:'Inter',sans-serif;font-size:13px;min-width:220px;">
            @foreach($coiffeurs as $c)
                <option value="{{ $c->id }}" {{ $c->id == $coiffeurId ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        @if($coiffeurSelectionne)
        <span style="font-size:12px;color:var(--text-muted);">
            {{ $horaires->count() }} jour(s) planifié(s)
        </span>
        @endif
    </form>
</div>

<div style="display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start;">

    {{-- ── LISTE DES JOURS PLANIFIÉS ──────────────────────────────────────── --}}
    <div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Planning de {{ $coiffeurSelectionne?->name ?? '—' }}</div>
            </div>

            @if($horaires->isEmpty())
                <p style="text-align:center;color:var(--text-muted);padding:40px 20px;">
                    Aucun jour planifié. Utilisez le formulaire ci-contre pour en ajouter.
                </p>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Jour</th>
                        <th>Créneaux</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horaires as $h)
                    <tr>
                        <td style="font-weight:600;">{{ \Carbon\Carbon::parse($h->date)->format('d/m/Y') }}</td>
                        <td style="color:var(--gold);font-size:13px;">
                            {{ \Carbon\Carbon::parse($h->date)->locale('fr')->isoFormat('dddd') }}
                        </td>
                        <td>
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                @foreach($h->segments as $seg)
                                    <span style="padding:3px 10px;background:rgba(212,175,55,0.1);border:1px solid rgba(212,175,55,0.25);border-radius:20px;font-size:12px;color:var(--gold);font-weight:600;white-space:nowrap;">
                                        {{ $seg['start'] }} – {{ $seg['end'] }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button onclick="openEdit({{ $h->id }}, '{{ $h->horaire_jour }}')"
                                    class="btn btn-ghost btn-sm">✏️</button>
                                <form method="POST" action="{{ route('admin.horaires.destroy', $h) }}"
                                    onsubmit="return confirm('Supprimer cette journée ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    {{-- ── FORMULAIRE D'AJOUT ──────────────────────────────────────────────── --}}
    <div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter des jours</div>
            </div>
            <form method="POST" action="{{ route('admin.horaires.store') }}" id="addForm">
                @csrf
                <input type="hidden" name="id_coiffeur" value="{{ $coiffeurId }}">

                <div class="form-group">
                    <label>Dates de travail *</label>
                    <p style="font-size:11px;color:var(--text-muted);margin-bottom:8px;">Sélectionnez une ou plusieurs dates</p>
                    <div id="dateList" style="display:flex;flex-direction:column;gap:6px;margin-bottom:8px;"></div>
                    <button type="button" onclick="addDateField()" class="btn btn-ghost btn-sm" style="width:100%;">+ Ajouter une date</button>
                </div>

                <div class="form-group">
                    <label>Créneaux horaires *</label>
                    <p style="font-size:11px;color:var(--text-muted);margin-bottom:8px;">Matin, après-midi, soirée…</p>
                    <div id="segmentList" style="display:flex;flex-direction:column;gap:8px;margin-bottom:8px;"></div>
                    <button type="button" onclick="addSegment()" class="btn btn-ghost btn-sm" style="width:100%;">+ Ajouter un créneau</button>
                </div>

                @if($errors->any())
                    <div class="alert alert-error" style="margin-bottom:12px;">
                        @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                    </div>
                @endif

                <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;margin-top:4px;">
                    ✓ Enregistrer
                </button>
            </form>
        </div>
    </div>

</div>

{{-- ── MODAL EDIT ───────────────────────────────────────────────────────────── --}}
<div id="editOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:200;align-items:center;justify-content:center;">
    <div style="background:#0c0c14;border:1px solid var(--border);border-radius:14px;padding:28px;width:420px;max-width:90vw;">
        <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:600;color:var(--text);margin-bottom:20px;">
            Modifier les créneaux
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PATCH')
            <div id="editSegmentList" style="display:flex;flex-direction:column;gap:8px;margin-bottom:12px;"></div>
            <button type="button" onclick="addEditSegment()" class="btn btn-ghost btn-sm" style="width:100%;margin-bottom:16px;">+ Ajouter un créneau</button>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-gold" style="flex:1;justify-content:center;">Enregistrer</button>
                <button type="button" onclick="closeEdit()" class="btn btn-ghost" style="flex:1;justify-content:center;">Annuler</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Formulaire ajout : dates ───────────────────────────────────────────────────
function addDateField(val = '') {
    const row = document.createElement('div');
    row.style.cssText = 'display:flex;gap:6px;align-items:center;';
    row.innerHTML = `
        <input type="date" name="dates[]" value="${val}" required min="{{ date('Y-m-d') }}"
            style="flex:1;padding:9px 12px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:8px;color:var(--text);font-family:Inter,sans-serif;font-size:13px;">
        <button type="button" onclick="this.parentNode.remove()" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;border-radius:6px;padding:6px 10px;cursor:pointer;font-size:14px;">✕</button>
    `;
    document.getElementById('dateList').appendChild(row);
}

// ── Formulaire ajout : créneaux ───────────────────────────────────────────────
function addSegment(start = '09:00', end = '13:00') {
    const idx = document.querySelectorAll('#segmentList .seg-row').length;
    const row = document.createElement('div');
    row.className = 'seg-row';
    row.style.cssText = 'display:grid;grid-template-columns:1fr auto 1fr auto;gap:6px;align-items:center;';
    row.innerHTML = segmentHtml('segments', idx, start, end);
    document.getElementById('segmentList').appendChild(row);
}

function segmentHtml(prefix, idx, start, end) {
    const inp = (name, val) => `<input type="time" name="${prefix}[${idx}][${name}]" value="${val}" required
        style="padding:9px 12px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:8px;color:var(--text);font-family:Inter,sans-serif;font-size:13px;width:100%;">`;
    return `
        ${inp('start', start)}
        <span style="color:var(--text-muted);font-size:12px;padding:0 2px;">→</span>
        ${inp('end', end)}
        <button type="button" onclick="this.parentNode.remove()" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;border-radius:6px;padding:6px 10px;cursor:pointer;font-size:14px;">✕</button>
    `;
}

// ── Modal édition ─────────────────────────────────────────────────────────────
function openEdit(id, horaireJour) {
    document.getElementById('editForm').action = `/admin/horaires/${id}`;
    document.getElementById('editSegmentList').innerHTML = '';
    const segs = horaireJour.split('/').filter(Boolean);
    segs.forEach(seg => {
        const [s, e] = seg.split('-');
        addEditSegment(s?.trim(), e?.trim());
    });
    document.getElementById('editOverlay').style.display = 'flex';
}

function closeEdit() {
    document.getElementById('editOverlay').style.display = 'none';
}

function addEditSegment(start = '09:00', end = '13:00') {
    const idx = document.querySelectorAll('#editSegmentList .seg-row').length;
    const row = document.createElement('div');
    row.className = 'seg-row';
    row.style.cssText = 'display:grid;grid-template-columns:1fr auto 1fr auto;gap:6px;align-items:center;';
    row.innerHTML = segmentHtml('segments', idx, start, end);
    document.getElementById('editSegmentList').appendChild(row);
}

// Initialisation : 1 date + 2 créneaux par défaut
addDateField();
addSegment('09:00', '13:00');
addSegment('14:00', '18:00');
</script>
@endpush
