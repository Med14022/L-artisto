<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Coiffeur — L'ARTISTO</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
        :root {
            --gold:       #D4AF37;
            --gold-light: #FFD700;
            --gold-dark:  #B8860B;
            --bg:         #09090f;
            --bg-card:    rgba(255,255,255,0.04);
            --bg-card2:   rgba(255,255,255,0.07);
            --border:     rgba(212,175,55,0.15);
            --text:       #e2ddd5;
            --text-muted: #7a7060;
            --radius:     14px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }

        /* ── HEADER ── */
        .header {
            background: rgba(9,9,15,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            position: sticky; top:0; z-index:50;
        }
        .header::before {
            content:''; display:block; height:3px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-dark));
        }
        .header-inner {
            max-width:1200px; margin:0 auto;
            padding:14px 28px;
            display:flex; justify-content:space-between; align-items:center;
        }
        .brand { display:flex; align-items:center; gap:12px; }
        .brand-icon {
            width:42px; height:42px; border-radius:10px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display:flex; align-items:center; justify-content:center;
            font-size:20px;
            box-shadow: 0 0 16px rgba(212,175,55,0.3);
        }
        .brand-name {
            font-family:'Playfair Display',serif;
            font-size:22px; font-weight:700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
            letter-spacing:1.5px;
        }
        .brand-badge {
            padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;
            background: rgba(212,175,55,0.1); border:1px solid rgba(212,175,55,0.2);
            color: var(--gold);
        }
        .header-right { display:flex; align-items:center; gap:16px; }
        .user-chip {
            display:flex; align-items:center; gap:10px;
            padding:8px 14px; border-radius:20px;
            background: var(--bg-card); border:1px solid var(--border);
        }
        .user-avatar {
            width:30px; height:30px; border-radius:50%;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display:flex; align-items:center; justify-content:center; font-size:14px;
        }
        .user-name { font-size:13px; font-weight:600; color:var(--text); }
        .logout-btn {
            padding:8px 18px; border-radius:8px;
            background:transparent; border:1px solid rgba(239,68,68,0.2);
            color:#f87171; font-family:'Inter',sans-serif; font-size:12px; font-weight:600;
            cursor:pointer; transition:all 0.2s;
        }
        .logout-btn:hover { background:rgba(239,68,68,0.1); }

        /* ── CONTAINER ── */
        .container { max-width:1200px; margin:0 auto; padding:32px 28px; }

        /* ── DATE BANNER ── */
        .date-banner {
            display:flex; align-items:center; justify-content:space-between;
            background: linear-gradient(135deg, rgba(212,175,55,0.1), rgba(255,215,0,0.05));
            border:1px solid rgba(212,175,55,0.2); border-radius:var(--radius);
            padding:16px 24px; margin-bottom:28px;
        }
        .date-text { font-family:'Playfair Display',serif; font-size:18px; color:var(--gold); }
        .date-sub  { font-size:12px; color:var(--text-muted); margin-top:3px; }
        .today-count {
            font-size:28px; font-weight:700; color:var(--text);
            text-align:right;
        }
        .today-count span { display:block; font-size:11px; color:var(--text-muted); font-weight:400; }

        /* ── SECTION ── */
        .section-heading {
            font-family:'Playfair Display',serif;
            font-size:20px; font-weight:600; color:var(--text);
            margin-bottom:16px;
            display:flex; align-items:center; gap:10px;
        }
        .section-heading .dot { width:5px; height:5px; background:var(--gold); border-radius:50%; box-shadow:0 0 8px var(--gold); }
        .section-heading::after { content:''; flex:1; height:1px; background:linear-gradient(90deg,var(--border),transparent); }

        /* ── CARDS ── */
        .card { background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius); padding:24px; margin-bottom:24px; }
        .today-card { border-color:rgba(212,175,55,0.3); background: linear-gradient(135deg, rgba(212,175,55,0.04), rgba(9,9,15,0.8)); }

        /* ── APPOINTMENT ROWS ── */
        .appt-row {
            display:flex; align-items:center; gap:16px;
            padding:14px 16px; border-radius:10px;
            margin-bottom:8px; border:1px solid transparent;
            transition:all 0.2s;
        }
        .appt-row:hover { background:var(--bg-card2); border-color:var(--border); }
        .appt-time {
            font-size:18px; font-weight:700; color:var(--gold);
            min-width:52px; font-family:'Playfair Display',serif;
        }
        .appt-divider { width:1px; height:40px; background:var(--border); flex-shrink:0; }
        .appt-info { flex:1; }
        .appt-client { font-weight:600; font-size:14px; color:var(--text); margin-bottom:3px; }
        .appt-services { font-size:12px; color:var(--text-muted); }
        .appt-action form { display:flex; align-items:center; }
        .status-select {
            padding:6px 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius:8px; color:var(--text);
            font-family:'Inter',sans-serif; font-size:12px; font-weight:500;
            cursor:pointer; transition:border 0.2s;
        }
        .status-select:focus { outline:none; border-color:var(--gold); }

        /* ── BADGES ── */
        .badge { padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; letter-spacing:0.3px; }
        .badge-pending   { background:rgba(212,175,55,0.12); color:var(--gold); border:1px solid rgba(212,175,55,0.25); }
        .badge-confirmed { background:rgba(34,197,94,0.1);  color:#4ade80; border:1px solid rgba(34,197,94,0.2); }
        .badge-done      { background:rgba(99,102,241,0.1); color:#818cf8; border:1px solid rgba(99,102,241,0.2); }
        .badge-cancelled { background:rgba(239,68,68,0.1);  color:#f87171; border:1px solid rgba(239,68,68,0.2); }

        .empty-msg { text-align:center; color:var(--text-muted); padding:32px; font-size:13px; }

        /* ── TABLE ── */
        table { width:100%; border-collapse:collapse; }
        th { text-align:left; padding:10px 14px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-muted); border-bottom:1px solid var(--border); }
        td { padding:12px 14px; font-size:13.5px; border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(255,255,255,0.02); }

        /* ── ALERT ── */
        .alert-success { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.2); color:#4ade80; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:20px; }

        /* ── FULLCALENDAR OVERRIDES ── */
        .fc { font-family:'Inter',sans-serif; }
        .fc-theme-standard td, .fc-theme-standard th, .fc-theme-standard .fc-scrollgrid { border-color: rgba(212,175,55,0.12); }
        .fc-col-header-cell-cushion { color:var(--text-muted); font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; text-decoration:none; }
        .fc-daygrid-day-number { color:var(--text-muted); font-size:13px; text-decoration:none; }
        .fc-day-today { background:rgba(212,175,55,0.05) !important; }
        .fc-day-today .fc-daygrid-day-number { color:var(--gold); font-weight:700; }
        .fc-toolbar-title { font-family:'Playfair Display',serif; font-size:18px; color:var(--text); }
        .fc-button-primary { background:rgba(255,255,255,0.06) !important; border-color:var(--border) !important; color:var(--text-muted) !important; font-family:'Inter',sans-serif !important; font-size:12px !important; padding:6px 14px !important; border-radius:8px !important; }
        .fc-button-primary:hover { background:rgba(212,175,55,0.1) !important; border-color:rgba(212,175,55,0.3) !important; color:var(--gold) !important; }
        .fc-button-active { background:rgba(212,175,55,0.15) !important; border-color:rgba(212,175,55,0.3) !important; color:var(--gold) !important; }
        .fc-event { border-radius:6px !important; font-size:12px !important; padding:2px 6px !important; cursor:pointer; border:none !important; }
        .fc-event-title { font-weight:600; }
        .fc-daygrid-event-dot { display:none; }

        /* ── POPUP DÉTAIL ── */
        .rdv-popup {
            display:none; position:fixed; inset:0; z-index:300;
            background:rgba(0,0,0,0.65); align-items:center; justify-content:center;
        }
        .rdv-popup.open { display:flex; }
        .rdv-popup-inner {
            background:#0c0c14; border:1px solid var(--border);
            border-radius:16px; padding:28px; width:360px; max-width:90vw;
            position:relative;
        }
        .popup-close {
            position:absolute; top:14px; right:16px;
            background:none; border:none; color:var(--text-muted);
            font-size:20px; cursor:pointer; line-height:1;
        }
        .popup-title { font-family:'Playfair Display',serif; font-size:18px; font-weight:700; color:var(--text); margin-bottom:16px; }
        .popup-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.05); font-size:13px; }
        .popup-row:last-of-type { border-bottom:none; }
        .popup-label { color:var(--text-muted); font-weight:500; }
        .popup-value { color:var(--text); font-weight:600; text-align:right; max-width:200px; }
    </style>
</head>
<body>

<header class="header">
    <div class="header-inner">
        <div class="brand">
            <div class="brand-icon">✂️</div>
            <span class="brand-name">L'ARTISTO</span>
            <span class="brand-badge">Coiffeur</span>
        </div>
        <div class="header-right">
            <div class="user-chip">
                <div class="user-avatar">👨</div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
    </div>
</header>

<div class="container">

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    <!-- Date Banner -->
    <div class="date-banner">
        <div>
            <div class="date-text">{{ now()->isoFormat('dddd D MMMM YYYY') }}</div>
            <div class="date-sub">Votre planning du jour</div>
        </div>
        <div class="today-count">
            {{ $rdvs_today->count() }}
            <span>RDV aujourd'hui</span>
        </div>
    </div>

    <!-- ── CALENDRIER ── -->
    <div class="section-heading"><span class="dot"></span> Calendrier</div>
    <div class="card" style="margin-bottom:28px;padding:20px 24px;">

        {{-- Légende --}}
        <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:16px;">
            @foreach(['en attente'=>['#D4AF37','#0a0a0a'],'confirmé'=>['#4ade80','#fff'],'terminé'=>['#818cf8','#fff'],'annulé'=>['#f87171','#fff']] as $statut=>[$bg,$fg])
            <span style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
                <span style="width:12px;height:12px;border-radius:3px;background:{{ $bg }};display:inline-block;"></span>
                {{ ucfirst($statut) }}
            </span>
            @endforeach
        </div>

        <div id="coiffeurCalendar"></div>
    </div>

    <!-- ── POPUP DÉTAIL RDV ── -->
    <div class="rdv-popup" id="rdvPopup">
        <div class="rdv-popup-inner">
            <button class="popup-close" onclick="closePopup()">✕</button>
            <div class="popup-title">Détail du rendez-vous</div>
            <div class="popup-row"><span class="popup-label">Client</span>     <span class="popup-value" id="popClient">—</span></div>
            <div class="popup-row"><span class="popup-label">Service(s)</span> <span class="popup-value" id="popServices">—</span></div>
            <div class="popup-row"><span class="popup-label">Heure</span>      <span class="popup-value" id="popHeure">—</span></div>
            <div class="popup-row"><span class="popup-label">Statut</span>     <span class="popup-value" id="popStatut">—</span></div>
            <div id="popActions" style="margin-top:18px;"></div>
        </div>
    </div>

    <!-- ── AUJOURD'HUI ── -->
    <div class="section-heading"><span class="dot"></span> Rendez-vous d'Aujourd'hui</div>
    <div class="card today-card">
        @if($rdvs_today->isEmpty())
            <p class="empty-msg">✓ Aucun rendez-vous planifié aujourd'hui.</p>
        @else
            @foreach($rdvs_today as $rdv)
            @php $badges = ['en attente'=>'badge-pending','confirmé'=>'badge-confirmed','terminé'=>'badge-done','annulé'=>'badge-cancelled']; @endphp
            <div class="appt-row">
                <div class="appt-time">{{ substr($rdv->heure,0,5) }}</div>
                <div class="appt-divider"></div>
                <div class="appt-info">
                    <div class="appt-client">{{ $rdv->client->name ?? '—' }}</div>
                    <div class="appt-services">{{ $rdv->services->pluck('name')->join(' · ') ?: 'Service non spécifié' }}</div>
                </div>
                <span class="badge {{ $badges[$rdv->etat] ?? '' }}" style="margin-right:12px;">{{ $rdv->etat }}</span>
                <div class="appt-action">
                    <form method="POST" action="{{ route('coiffeur.rendez-vous.update-status', $rdv) }}">
                        @csrf @method('PATCH')
                        <select name="etat" class="status-select" onchange="this.form.submit()">
                            @foreach(['confirmé','terminé','annulé'] as $etat)
                                <option value="{{ $etat }}" {{ $rdv->etat === $etat ? 'selected' : '' }}>{{ ucfirst($etat) }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <!-- ── À VENIR ── -->
    <div class="section-heading"><span class="dot"></span> Prochains Rendez-vous</div>
    <div class="card">
        @if($rdvs_upcoming->isEmpty())
            <p class="empty-msg">Aucun rendez-vous à venir.</p>
        @else
        <table>
            <thead>
                <tr><th>Date</th><th>Heure</th><th>Client</th><th>Service(s)</th><th>Statut</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($rdvs_upcoming as $rdv)
                @php $badges = ['en attente'=>'badge-pending','confirmé'=>'badge-confirmed','terminé'=>'badge-done','annulé'=>'badge-cancelled']; @endphp
                <tr>
                    <td style="font-weight:600;">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</td>
                    <td style="color:var(--gold);font-weight:600;">{{ substr($rdv->heure,0,5) }}</td>
                    <td>{{ $rdv->client->name ?? '—' }}</td>
                    <td style="color:var(--text-muted);font-size:12px;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
                    <td><span class="badge {{ $badges[$rdv->etat] ?? '' }}">{{ $rdv->etat }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('coiffeur.rendez-vous.update-status', $rdv) }}" style="display:flex;">
                            @csrf @method('PATCH')
                            <select name="etat" class="status-select" onchange="this.form.submit()">
                                @foreach(['confirmé','terminé','annulé'] as $etat)
                                    <option value="{{ $etat }}" {{ $rdv->etat === $etat ? 'selected' : '' }}>{{ ucfirst($etat) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- ── HISTORIQUE ── -->
    <div class="section-heading"><span class="dot"></span> Historique (20 derniers)</div>
    <div class="card">
        @if($rdvs_history->isEmpty())
            <p class="empty-msg">Aucun historique disponible.</p>
        @else
        <table>
            <thead>
                <tr><th>Date</th><th>Heure</th><th>Client</th><th>Service(s)</th><th>Statut</th></tr>
            </thead>
            <tbody>
                @foreach($rdvs_history as $rdv)
                @php $badges = ['en attente'=>'badge-pending','confirmé'=>'badge-confirmed','terminé'=>'badge-done','annulé'=>'badge-cancelled']; @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</td>
                    <td style="color:var(--text-muted);">{{ substr($rdv->heure,0,5) }}</td>
                    <td>{{ $rdv->client->name ?? '—' }}</td>
                    <td style="color:var(--text-muted);font-size:12px;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
                    <td><span class="badge {{ $badges[$rdv->etat] ?? '' }}">{{ $rdv->etat }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/locales/fr.global.min.js"></script>
<script>
const events = @json($rdvs_calendar);

document.addEventListener('DOMContentLoaded', function () {
    const cal = new FullCalendar.Calendar(document.getElementById('coiffeurCalendar'), {
        locale: 'fr',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listWeek',
        },
        buttonText: { today:'Aujourd\'hui', month:'Mois', week:'Semaine', list:'Liste' },
        height: 520,
        events: events,
        eventClick: function (info) {
            const p = info.event.extendedProps;
            document.getElementById('popClient').textContent   = p.client;
            document.getElementById('popServices').textContent = p.services;
            document.getElementById('popHeure').textContent    = p.heure;

            const statutColors = {
                'en attente':'#D4AF37','confirmé':'#4ade80','terminé':'#818cf8','annulé':'#f87171'
            };
            const color = statutColors[p.etat] ?? '#7a7060';
            document.getElementById('popStatut').innerHTML =
                `<span style="background:${color}22;border:1px solid ${color}55;color:${color};padding:3px 12px;border-radius:20px;font-size:12px;">${p.etat}</span>`;

            // Bouton changer statut (uniquement si pas terminé/annulé)
            const actionsEl = document.getElementById('popActions');
            if (!['terminé','annulé'].includes(p.etat)) {
                actionsEl.innerHTML = `
                    <form method="POST" action="/coiffeur/rendez-vous/${p.rdv_id}/status" style="display:flex;gap:10px;flex-wrap:wrap;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                        ${['confirmé','terminé','annulé'].map(e =>
                            `<button type="submit" name="etat" value="${e}"
                                style="flex:1;padding:9px 10px;border-radius:8px;border:1px solid rgba(255,255,255,0.1);
                                background:rgba(255,255,255,0.04);color:var(--text);font-family:Inter,sans-serif;
                                font-size:12px;font-weight:600;cursor:pointer;"
                                onmouseover="this.style.borderColor='${statutColors[e]??'#fff'}'"
                                onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'"
                            >${e.charAt(0).toUpperCase()+e.slice(1)}</button>`
                        ).join('')}
                    </form>`;
            } else {
                actionsEl.innerHTML = '';
            }

            document.getElementById('rdvPopup').classList.add('open');
        },
        eventDidMount: function(info) {
            info.el.title = info.event.extendedProps.client + ' — ' + info.event.extendedProps.heure;
        },
    });
    cal.render();
});

function closePopup() {
    document.getElementById('rdvPopup').classList.remove('open');
}
// Clic hors popup
document.getElementById('rdvPopup').addEventListener('click', function(e) {
    if (e.target === this) closePopup();
});
</script>
</body>
</html>
