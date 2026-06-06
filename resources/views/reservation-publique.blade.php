<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Réserver — L'ARTISTO Barbershop</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold:       #D4AF37;
            --gold-light: #FFD700;
            --gold-dark:  #B8860B;
            --bg:         #07070d;
            --bg-card:    rgba(255,255,255,0.04);
            --border:     rgba(212,175,55,0.15);
            --text:       #e8e0d0;
            --text-muted: #8a8070;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }

        /* ── NAV ── */
        nav {
            position:fixed; top:0; left:0; right:0; z-index:100;
            background:rgba(7,7,13,0.85); backdrop-filter:blur(20px);
            border-bottom:1px solid var(--border);
        }
        nav::before { content:''; display:block; height:2px; background:linear-gradient(90deg,var(--gold-dark),var(--gold-light),var(--gold-dark)); }
        .nav-inner { max-width:1100px; margin:0 auto; padding:16px 32px; display:flex; justify-content:space-between; align-items:center; }
        .nav-logo { display:flex; align-items:center; gap:12px; text-decoration:none; }
        .nav-logo-icon { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,var(--gold-dark),var(--gold-light)); display:flex; align-items:center; justify-content:center; font-size:17px; }
        .nav-brand { font-family:'Playfair Display',serif; font-size:20px; font-weight:700; letter-spacing:2px; background:linear-gradient(135deg,var(--gold),var(--gold-light)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .nav-back { color:var(--text-muted); font-size:13px; text-decoration:none; padding:7px 16px; border:1px solid var(--border); border-radius:8px; transition:all 0.2s; }
        .nav-back:hover { color:var(--gold); border-color:rgba(212,175,55,0.3); }

        /* ── PAGE ── */
        .page { padding-top:80px; min-height:100vh; display:flex; align-items:center; justify-content:center; padding-bottom:60px; }
        .wrap { max-width:780px; width:100%; margin:0 auto; padding:40px 24px 0; }

        /* ── HERO ── */
        .page-title { font-family:'Playfair Display',serif; font-size:36px; font-weight:700; text-align:center; margin-bottom:8px; }
        .page-title span { background:linear-gradient(135deg,var(--gold),var(--gold-light)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .page-sub { text-align:center; color:var(--text-muted); font-size:15px; margin-bottom:40px; }

        /* ── FORM CARD ── */
        .form-card { background:var(--bg-card); border:1px solid var(--border); border-radius:20px; padding:36px 40px; }
        @media(max-width:600px){ .form-card{ padding:24px 18px; } }

        /* ── STEP HEADERS ── */
        .step-label { font-size:11px; text-transform:uppercase; letter-spacing:1.5px; color:var(--gold); font-weight:700; margin-bottom:18px; display:flex; align-items:center; gap:8px; }
        .step-label::after { content:''; flex:1; height:1px; background:var(--border); }

        /* ── FIELDS ── */
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        @media(max-width:560px){ .form-row{ grid-template-columns:1fr; } }
        .form-group { margin-bottom:18px; }
        label { display:block; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); margin-bottom:7px; }
        input, select { width:100%; padding:12px 16px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:var(--text); font-family:'Inter',sans-serif; font-size:14px; transition:border 0.2s; }
        input:focus, select:focus { outline:none; border-color:var(--gold); box-shadow:0 0 0 3px rgba(212,175,55,0.1); }
        input::placeholder { color:var(--text-muted); }
        select option { background:#1a1a28; color:var(--text); }
        .error-msg { color:#f87171; font-size:12px; margin-top:5px; }

        /* ── TIME SLOTS ── */
        .time-grid { display:flex; flex-wrap:wrap; gap:8px; margin-top:6px; }
        .time-btn {
            padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600;
            background:rgba(255,255,255,0.04); border:1px solid var(--border);
            color:var(--text-muted); cursor:pointer; transition:all 0.2s;
        }
        .time-btn:hover:not(.booked) { border-color:var(--gold); color:var(--gold); background:rgba(212,175,55,0.07); }
        .time-btn.selected { background:var(--gold); border-color:var(--gold); color:#0a0a0a; }
        .time-btn.booked { opacity:0.35; cursor:not-allowed; text-decoration:line-through; }
        .time-loading { color:var(--text-muted); font-size:13px; padding:8px 0; }
        input[type=hidden]#heure { display:none; }

        /* ── SUBMIT ── */
        .btn-submit {
            width:100%; padding:15px; margin-top:8px;
            background:linear-gradient(135deg,var(--gold-dark),var(--gold-light));
            color:#0a0a0a; font-family:'Inter',sans-serif; font-size:15px; font-weight:700;
            border:none; border-radius:12px; cursor:pointer;
            transition:all 0.3s; letter-spacing:0.5px;
        }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(212,175,55,0.35); }
        .btn-submit:disabled { opacity:0.4; cursor:not-allowed; transform:none; }

        /* ── SERVICE CARDS ── */
        .service-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:10px; margin-top:6px; }
        .service-opt {
            padding:14px; border-radius:10px; border:1px solid var(--border);
            background:rgba(255,255,255,0.02); cursor:pointer; transition:all 0.2s;
            display:flex; flex-direction:column; gap:4px;
        }
        .service-opt:hover { border-color:rgba(212,175,55,0.3); }
        .service-opt.selected { border-color:var(--gold); background:rgba(212,175,55,0.07); }
        .service-opt input { display:none; }
        .service-name { font-size:13px; font-weight:700; color:var(--text); }
        .service-meta { font-size:11px; color:var(--text-muted); }
        .service-price { font-size:15px; font-weight:700; color:var(--gold); margin-top:4px; }

        /* ── DIVIDER ── */
        .divider { border:none; border-top:1px solid var(--border); margin:28px 0; }
    </style>
</head>
<body>

<nav>
    <div class="nav-inner">
        <a href="{{ url('/') }}" class="nav-logo">
            <div class="nav-logo-icon">✂️</div>
            <span class="nav-brand">L'ARTISTO</span>
        </a>
        <a href="{{ url('/') }}" class="nav-back">← Retour à l'accueil</a>
    </div>
</nav>

<div class="page">
<div class="wrap">

    <h1 class="page-title">Réserver <span>sans compte</span></h1>
    <p class="page-sub">Remplissez le formulaire — c'est rapide, sans inscription requise.</p>

    @if($errors->any())
    <div style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#f87171;border-radius:12px;padding:14px 18px;margin-bottom:24px;font-size:13px;">
        @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
    </div>
    @endif

    <div class="form-card">
    <form method="POST" action="{{ route('reserver.store') }}" id="reservForm">
        @csrf

        {{-- ── ÉTAPE 1 : Vos coordonnées ──────────────────────────────── --}}
        <div class="step-label">1 — Vos coordonnées</div>
        <div class="form-row">
            <div class="form-group">
                <label>Nom complet *</label>
                <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Mohamed Ali" required>
                @error('nom') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Téléphone *</label>
                <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="+216 XX XXX XXX" required>
                @error('telephone') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Email <span style="font-weight:400;text-transform:none;">(optionnel — pour recevoir la confirmation)</span></label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com">
            @error('email') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <hr class="divider">

        {{-- ── ÉTAPE 2 : Choisir un service ───────────────────────────── --}}
        <div class="step-label">2 — Choisir un service</div>
        <div class="service-grid" id="serviceGrid">
            @foreach($services as $service)
            <label class="service-opt {{ old('service_id') == $service->id ? 'selected' : '' }}" onclick="selectService(this, {{ $service->id }})">
                <input type="radio" name="service_id" value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'checked' : '' }}>
                <span class="service-name">{{ $service->name }}</span>
                <span class="service-meta">{{ $service->duration }} min</span>
                <span class="service-price">{{ $service->price }} DT</span>
            </label>
            @endforeach
        </div>
        @error('service_id') <div class="error-msg" style="margin-top:8px;">{{ $message }}</div> @enderror

        <hr class="divider">

        {{-- ── ÉTAPE 3 : Coiffeur, date et heure ──────────────────────── --}}
        <div class="step-label">3 — Coiffeur, date & heure</div>

        <div class="form-row">
            <div class="form-group">
                <label>Coiffeur *</label>
                <select name="id_coiffeur" id="coiffeurSelect" onchange="loadSlots()" required>
                    <option value="">— Choisir —</option>
                    @foreach($coiffeurs as $c)
                        <option value="{{ $c->id }}" {{ old('id_coiffeur') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('id_coiffeur') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Date *</label>
                <input type="date" name="date" id="dateInput" value="{{ old('date', date('Y-m-d')) }}"
                    min="{{ date('Y-m-d') }}" onchange="loadSlots()" required>
                @error('date') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Heure *</label>
            <div id="slotsWrap">
                <p class="time-loading" id="slotsHint" style="color:var(--text-muted);font-size:13px;padding:8px 0;">
                    ← Sélectionnez un coiffeur et une date pour voir les créneaux disponibles.
                </p>
                <div class="time-grid" id="timeGrid"></div>
            </div>
            <input type="hidden" name="heure" id="heureInput" value="{{ old('heure') }}">
            @error('heure') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-submit" id="submitBtn">
            Confirmer ma réservation →
        </button>

    </form>
    </div>

    <p style="text-align:center;margin-top:20px;font-size:13px;color:var(--text-muted);">
        Vous avez un compte ?
        <a href="{{ route('login') }}" style="color:var(--gold);text-decoration:none;font-weight:600;">Se connecter →</a>
    </p>

</div>
</div>

<script>
const ALL_SLOTS = ['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30',
                   '14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30'];

function selectService(label, id) {
    document.querySelectorAll('.service-opt').forEach(l => l.classList.remove('selected'));
    label.classList.add('selected');
    label.querySelector('input').checked = true;
}

function loadSlots() {
    const coiffeurId = document.getElementById('coiffeurSelect').value;
    const date       = document.getElementById('dateInput').value;
    const grid       = document.getElementById('timeGrid');
    const hint       = document.getElementById('slotsHint');

    if (!coiffeurId || !date) {
        grid.innerHTML = '';
        hint.style.display = 'block';
        hint.textContent = '← Sélectionnez un coiffeur et une date pour voir les créneaux disponibles.';
        return;
    }

    hint.style.display = 'block';
    hint.textContent = 'Chargement des créneaux…';
    grid.innerHTML   = '';

    fetch(`{{ route('rendez-vous.available-times') }}?coiffeur_id=${coiffeurId}&date=${date}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(booked => {
        hint.style.display = 'none';
        grid.innerHTML = '';
        const prevSelected = document.getElementById('heureInput').value;

        ALL_SLOTS.forEach(slot => {
            const isBooked = booked.includes(slot);
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = slot;
            btn.className = 'time-btn' + (isBooked ? ' booked' : '') + (slot === prevSelected && !isBooked ? ' selected' : '');
            if (!isBooked) {
                btn.onclick = () => {
                    document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    document.getElementById('heureInput').value = slot;
                };
            }
            grid.appendChild(btn);
        });

        if (grid.children.length === 0) {
            hint.style.display = 'block';
            hint.textContent = 'Aucun créneau disponible pour cette date.';
        }
    })
    .catch(() => {
        hint.style.display = 'block';
        hint.textContent = 'Erreur lors du chargement. Réessayez.';
    });
}

// Charger les créneaux si old() values existent
window.addEventListener('DOMContentLoaded', () => {
    const c = document.getElementById('coiffeurSelect').value;
    const d = document.getElementById('dateInput').value;
    if (c && d) loadSlots();

    // Reselectionner le service si old()
    document.querySelectorAll('.service-opt input:checked').forEach(r => {
        r.closest('.service-opt').classList.add('selected');
    });
});
</script>
</body>
</html>
