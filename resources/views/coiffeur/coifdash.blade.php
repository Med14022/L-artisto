<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard Coiffeur - L'ARTISTO</title>
  <style>
    :root {
      --gold: #d4af37;
      --dark: #222;
      --muted: #f5f5f6;
      --card: #ffffff;
      --round: 18px;
    }

    body {
      font-family: Inter, system-ui, Arial;
      margin: 0;
      background-color: #f0e7a8e7;
    }

    .wrap {
      max-width: 1100px;
      margin: 24px auto;
      padding: 20px;
    }

    .panel {
      background: var(--card);
      border-radius: 16px;
      padding: 18px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, .25);
    }

    /* header */
    .hero {
      background: linear-gradient(90deg, var(--gold), #c79a10);
      color: #111;
      padding: 28px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px
    }

    .hero h1 {
      margin: 0;
      font-size: 22px
    }

    .hero p {
      margin: 0;
      opacity: .9
    }

    /* stats */
    .stats {
      display: flex;
      gap: 14px;
      margin-top: 18px;
      flex-wrap: wrap
    }

    .stat {
      flex: 1;
      min-width: 160px;
      background: linear-gradient(180deg, #fff, #fbfbfb);
      border-radius: 12px;
      padding: 14px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center
    }

    .stat .num {
      font-size: 22px;
      font-weight: 700;
      color: var(--dark)
    }

    .stat .label {
      font-size: 13px;
      color: #666;
      margin-top: 6px
    }

    /* main layout */
    .grid {
      display: grid;
      grid-template-columns: 1fr 360px;
      gap: 18px;
      margin-top: 18px
    }

    @media (max-width:900px) {
      .grid {
        grid-template-columns: 1fr
      }
    }

    /* appointments list / calendar-like */
    .appts {
      padding: 14px;
      border-radius: 12px;
      background: var(--muted);
      min-height: 320px;

      /* 🔥 Nouvelle partie ajoutée 🔥 */
      max-height: 420px;
      /* limite d’environ 4 rendez-vous visibles */
      overflow-y: auto;
      /* scroll vertical activé */
      scrollbar-width: thin;
      /* pour Firefox */
    }

    .appts::-webkit-scrollbar {
      width: 6px;
    }

    .appts::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.25);
      border-radius: 10px;
    }

    .appts .section-title {
      font-weight: 700;
      margin-bottom: 12px
    }

    .appt {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      border-radius: 10px;
      background: #fff;
      margin-bottom: 10px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, .04)
    }

    .appt .time {
      width: 64px;
      font-weight: 700;
      color: var(--gold)
    }

    .appt .meta {
      flex: 1
    }

    .appt .meta .client {
      font-weight: 700
    }

    .appt .meta .service {
      font-size: 13px;
      color: #666
    }

    .appt .actions {
      display: flex;
      flex-direction: column;
      gap: 8px
    }

    .btn {
      border: 0;
      padding: 10px 14px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 700
    }

    .btn-primary {
      background: var(--gold);
      color: #111
    }

    .btn-ghost {
      background: #f3f3f3;
      color: #222
    }

    /* calendar small box for today's appointments */
    .today-box {
      background: #fff;
      border-radius: 12px;
      padding: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, .06)
    }

    .today-title {
      font-weight: 700;
      margin-bottom: 8px
    }

    .small-cal {
      display: flex;
      gap: 8px;
      flex-wrap: wrap
    }

    .cal-item {
      width: 72px;
      height: 72px;
      border-radius: 10px;
      background: linear-gradient(180deg, #fff, #fafafa);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      font-weight: 700
    }

    .cal-item.today {
      border: 2px solid var(--gold)
    }

    /* footer actions */
    .actions-row {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 12px
    }

    .muted {
      color: #666;
      font-size: 13px
    }

    /* completed state */
    .appt.completed {
      opacity: .6;
      text-decoration: line-through
    }

    .header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 15px 0;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #D4AF37, #FFD700, #B8860B);
    }

    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo-section {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo {
      font-size: 28px;
    }

    .brand-name {
      font-size: 24px;
      font-weight: bold;
      color: var(--dark);
      margin: 0;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .welcome-text {
      font-size: 16px;
      color: var(--dark);
    }

    .logout-btn {
      background: var(--gold);
      color: #111;
      border: none;
      padding: 8px 16px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 700;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class="header">
    <div class="header-content">
      <div class="logo-section">
        <div class="logo">
          <span class="crown">👑</span>
        </div>
        <h1 class="brand-name">L'ARTISTO</h1>
      </div>

      <div class="user-info">
        <span class="welcome-text">Bienvenue, {{ optional(Auth::user())->name ?? '—' }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
      </div>
    </div>
  </header>

  <div class="wrap">
    <div class="panel">
      <div class="hero">
        <div>
          <h1>📅 Tableau de bord — Coiffeur</h1>
          <p>Bienvenue, {{ optional(Auth::user())->name ?? '—' }} — aperçu rapide de vos rendez‑vous</p>
        </div>
        <div style="text-align:right">
          <div style="font-weight:800;font-size:18px">Aujourd'hui</div>
          <div class="muted">{{ now()->todateString() }}</div>
        </div>
      </div>

      <div class="stats">
        <div class="stat">
          <div class="num">{{ $rdv_enattente->where('date', now()->toDateString())->count() }}</div>
          <div class="label">Rendez‑vous aujourd'hui</div>
        </div>
        <div class="stat">
          <div class="num">{{ $rdv_terminer->count() }}</div>
          <div class="label">Rendez‑vous terminés</div>
        </div>
        <div class="stat">
          <div class="num">
            {{ $rdv_enattente->whereBetween('date', [now()->toDateString(), now()->addDays(7)->toDateString()])->count() }}
          </div>
          <div class="label">Rendez‑vous à venir (7j)</div>
        </div>
      </div>

      <div class="grid">
        <!-- left: liste des rendez-vous -->
        <div>
          <div class="appts">
            <div class="section-title" id="rdv-title">
              @if (isset($data))
                Rendez-vous du {{ \Carbon\Carbon::parse($data[0]->date)->translatedFormat('d F Y') }}
              @else
                Rendez-vous d'aujourd'hui ({{ now()->translatedFormat('d F Y') }})
              @endif
            </div>

            <!-- static example appointments -->
            <div id="rdv-list">
              <?php $rdvs = $data ?? $rdv_enattente->where('date', now()->toDateString()); ?>
              @if (isset($rdvs) && count($rdvs) == 0)
                <div style="text-align:center; color:#666; margin-top:20px">
                  Aucun rendez-vous pour cette date.
                </div>
              @else
                @foreach($rdvs as $rdv)
                  <div class="appt" data-id="{{ $rdv->id }}">
                    <div class="time">{{ !empty($rdv->heure) ? \Carbon\Carbon::parse($rdv->heure)->format('H:i') : '-' }}
                    </div>
                    <div class="meta">
                      <div class="client">{{ optional($rdv->client)->name ?? 'Client supprimé' }}</div>
                      <div class="service">
                        @foreach ($rdv->services ?? [] as $service)
                          {{ $service->name ?? '-' }} — {{ $service->duration ?? '-' }} min<br>
                        @endforeach
                      </div>
                      <div class="muted">Téléphone: {{ optional($rdv->client)->phone ?? '-' }}</div>
                    </div>
                    <div class="actions">
                      <button class="btn btn-ghost" onclick="markDone(this,{{ $rdv->id }})">Terminé</button>
                      <button class="btn btn-primary" onclick="openTake({{ $rdv->id }})">Voir</button>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>

          </div>

          <!-- bouton rapide -->
          <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
            <button id="btnTakeSelf" class="btn btn-primary">Prendre RDV pour moi</button>
            <button id="btnTakeSomeone" class="btn btn-outline">Prendre RDV pour quelqu'un</button>
          </div>
        </div>

        <!-- right: petit calendrier + résumé -->
        <aside>
          <div class="today-box">
            <div class="today-title">Mini calendrier</div>
            <div class="small-cal" style="margin-bottom:10px">
              @for ($i = 0; $i < 14; $i++)
                <?php  $date = now()->addDays($i)->toDateString(); ?>
                <div id="{{ $i }}" class="cal-item" onclick="highlightDate('{{ $i }}'); rdvParDate('{{ $date }}')">
                  {{ now()->addDays($i)->format('d') }}<br>
                  <span style="font-size:12px;color:#888">
                    {{ now()->addDays($i)->translatedFormat('M') }}
                  </span>
                </div>
              @endfor

            </div>

            <div style="font-weight:700;margin-bottom:8px">Prochains rendez‑vous</div>
            <div style="display:flex;flex-direction:column;gap:10px">
              @foreach ($rdv_prochain as $rdv)
                <div style="display:flex;justify-content:space-between">
                  + <div>
                    + <strong>{{ !empty($rdv->heure) ? \Carbon\Carbon::parse($rdv->heure)->format('H:i') : '-' }}</strong>
                    + <div class="muted" style="font-size:13px">
                      + {{ optional($rdv->client)->name ?? '—' }} —
                      {{ optional($rdv->service)->name ?? optional($rdv->services->first())->name ?? '—' }}
                      +
                    </div>
                    + </div>
                  + <div class="muted">{{ $rdv->date ?? '-' }}</div>
                </div>
              @endforeach

            </div>
          </div>

          <div class="today-box" style="margin-top:12px">
            <div style="font-weight:700;margin-bottom:8px">Statistiques rapides</div>
            <div style="display:flex;gap:8px;flex-direction:column">
              <div>Terminés aujourd'hui:
                <strong>{{ $rdv_terminer->where('date', now()->toDateString())->count() }}</strong>
              </div>
              <div>Terminés cette semaine:
                <strong>{{ $rdv_terminer->whereBetween('date', [now()->subDays(7)->toDateString(), now()->toDateString()])->count() }}
                </strong>
              </div>
              <div>Annulés: <strong>inutile </strong></div>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>

  <!-- Modal / Wizard pour prise de RDV par le coiffeur -->
  <div id="takeModal"
    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);align-items:center;justify-content:center;z-index:9999">
    <div
      style="width:760px;max-width:95%;background:#fff;border-radius:12px;padding:18px;box-shadow:0 12px 40px rgba(0,0,0,.4)">
      <h3 id="wizard-title">Prendre un rendez‑vous</h3>

      <form id="takeForm" onsubmit="event.preventDefault(); submitTakeForm();" novalidate>
        <input type="hidden" id="coiffeur_id" name="coiffeur_id" value="{{ Auth::id() }}">

        <!-- Step 1 : infos client -->
        <div class="wizard-step" data-step="1">
          <h4>1 — Informations client</h4>
          <div style="display:flex;gap:8px;flex-wrap:wrap">
            <div style="flex:1;min-width:160px">
              <label>Nom *</label><br>
              <input id="client_name" name="client_name" type="text" style="width:100%;padding:8px" required>
            </div>
            <div style="flex:1;min-width:160px">
              <label>Téléphone *</label><br>
              <input id="client_phone" name="client_phone" type="text" style="width:100%;padding:8px" required>
            </div>
            <div style="flex:1;min-width:160px">
              <label>Email</label><br>
              <input id="client_email" name="client_email" type="email" style="width:100%;padding:8px">
            </div>
            <div style="flex:1;min-width:160px">
              <label>Adresse</label><br>
              <input id="client_address" name="client_address" type="text" style="width:100%;padding:8px">
            </div>
          </div>
        </div>

        <!-- Step 2 : service -->
        <div class="wizard-step" data-step="2" style="display:none">
          <h4>2 — Choisir le service</h4>
          <input type="hidden" id="service_id" name="service_id" value="">
          <div id="servicesList" style="display:flex;flex-direction:column;gap:8px;margin-top:8px">
            @if(isset($services) && $services->count())
              @foreach($services as $s)
                @php
                  $price = $s->price ?? $s->cost ?? $s->cout ?? $s->tarif ?? null;
                @endphp
                <label class="service-card" data-id="{{ $s->id }}" onclick="selectService('{{ $s->id }}')"
                  style="display:flex;justify-content:space-between;align-items:center;padding:10px;border-radius:8px;border:1px solid #eee;cursor:pointer">
                  <div style="display:flex;flex-direction:column">
                    <strong style="font-size:15px">{{ $s->name ?? '—' }}</strong>
                    <span class="muted" style="font-size:13px">{{ $s->description ?? '' }}</span>
                  </div>
                  <div style="text-align:right">
                    <div style="font-weight:700">{{ $s->duration ?? '—' }} min</div>
                    <div class="muted">{{ $price !== null ? $price . ' €' : '—' }}</div>
                  </div>
                  <input type="radio" id="svc{{ $s->id }}" name="svc_radio" value="{{ $s->id }}" style="display:none">
                </label>
              @endforeach
            @else
              <div class="muted">Aucun service disponible.</div>
            @endif
          </div>
        </div>

        <!-- Step 3 : coiffeur (par défaut le coiffeur connecté) -->
        <div class="wizard-step" data-step="3" style="display:none">
          <h4>3 — Coiffeur</h4>
          <div>
            <label>Coiffeur *</label><br>
            <select id="select_coiffeur" name="coiffeur_id_select" style="width:100%;padding:8px" required>
              <option value="{{ Auth::id() }}">{{ optional(Auth::user())->name ?? '—' }} (par défaut)</option>
              @if(isset($coiffeurs))
                @foreach($coiffeurs as $c)
                  <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>

        <!-- Step 4 : date & heure (select remplis depuis la BDD via HoraireController::hours) -->
        <div class="wizard-step" data-step="4" style="display:none">
          <h4>4 — Date et heure</h4>

          <label>Date *</label><br>
          <select id="date" name="date" style="width:100%;padding:8px" required
            onchange="fetchAvailableHours(this.value)">
            <option value="">-- sélectionnez --</option>
            @if(isset($available_dates) && count($available_dates))
              @foreach($available_dates as $d)
                <option value="{{ $d->date }}">
                  {{ \Carbon\Carbon::parse($d->date)->translatedFormat('d F Y') }}
                  @if(isset($d->slots_count)) — {{ $d->slots_count }} créneau(s) @endif
                </option>
              @endforeach
            @endif
          </select>

          <div style="height:8px"></div>

          <label>Heure *</label><br>
          <select id="heure" name="heure" style="width:100%;padding:8px" required>
            <option value="">-- choisissez une date d'abord --</option>
          </select>
        </div>

        <!-- Step 5 : résumé -->
        <div class="wizard-step" data-step="5" style="display:none">
          <h4>5 — Résumé</h4>
          <div id="summaryBox" style="background:#f7f7f7;padding:12px;border-radius:8px"></div>
        </div>

        <!-- Controls -->
        <div style="display:flex;justify-content:space-between;margin-top:12px">
          <div>
            <button type="button" id="prevBtn" onclick="prevStep()" class="btn btn-ghost" style="display:none">←
              Précédent</button>
          </div>
          <div style="display:flex;gap:8px">
            <button type="button" onclick="closeTakeModal()" class="btn btn-ghost">Annuler</button>
            <button type="button" id="nextBtn" onclick="nextStep()" class="btn btn-primary">Suivant →</button>
            <button type="submit" id="submitBtn" class="btn btn-primary" style="display:none">Confirmer</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    // petites interactions statiques pour la preview design
    function markDone(el, id) {
      const node = document.querySelector('.appt[data-id="' + id + '"]');
      if (!node) return;
      node.classList.toggle('completed');
      el.textContent = node.classList.contains('completed') ? 'Annuler' : 'Terminé';
    }
    function openTake(id) {
      alert('Voir détail Rendez‑vous #' + id + ' (vue statique)');
    }
    function takeForSelf() {
      alert('Formulaire statique: prendre RDV pour vous (ex: ouvert)');
    }
    function takeForSomeone() {
      alert('Formulaire statique: prendre RDV pour quelqu\'un d\'autre');
    }
    function highlightDate(index) {
      // Réinitialiser toutes les dates
      const items = document.querySelectorAll('.cal-item');
      items.forEach(item => item.classList.remove('today'));

      // Mettre en surbrillance la date sélectionnée
      const selectedItem = document.getElementById(index);
      if (selectedItem) {
        selectedItem.classList.add('today');
      }
    }
    window.onload = function () {
      highlightDate('0');
    };
    function rdvParDate(date) {
      fetch('/coiffeur/rdv_par_date', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ date: date })
      })
        .then(response => {
          console.log('rdv_par_date status', response.status, response.url);
          return response.text().then(text => {
            const ct = response.headers.get('content-type') || '';
            if (ct.includes('application/json')) {
              try { return JSON.parse(text); } catch (e) { console.error('JSON parse error', e); return []; }
            }
            // si serveur renvoie HTML, loguer et retourner tableau vide
            console.warn('rdv_par_date response not JSON:', text.slice(0, 200));
            return [];
          });
        })
        .then(data => {
          // mise à jour du titre
          document.getElementById('rdv-title').textContent = 'Rendez-vous du ' + date;

          // construire le HTML des rdvs
          let html = '';
          if (!data || data.length === 0) {
            html = '<div style="text-align:center; color:#666; margin-top:20px">Aucun rendez-vous pour cette date.</div>';
          } else {
            data.forEach(rdv => {
              html += `
            <div class="appt" data-id="${rdv.id}">
              <div class="time">${(rdv.heure || '').slice(0, 5)}</div>
              <div class="meta">
                <div class="client">${rdv.client?.name ?? '-'}</div>
                <div class="service">
                  ${(rdv.services || []).map(s => `${s.name} — ${s.duration} min`).join('<br>')}
                </div>
                <div class="muted">Téléphone: ${rdv.client?.phone ?? '-'}</div>
              </div>
              <div class="actions">
                <button class="btn btn-ghost" onclick="markDone(this,${rdv.id})">Terminé</button>
                <button class="btn btn-primary" onclick="openTake(${rdv.id})">Voir</button>
              </div>
            </div>
          `;
            });
          }

          // injecter dans le DOM
          document.getElementById('rdv-list').innerHTML = html;
        })
        .catch(err => {
          console.error('rdvParDate fetch error', err);
          document.getElementById('rdv-list').innerHTML = '<div style="text-align:center;color:#c00;margin-top:20px">Erreur réseau</div>';
        });
    }


    // wizard state
    let currentStep = 1;
    const totalSteps = 5;

    function openTakeForSelf() {
      // prefill coiffeur default and clear client fields
      document.getElementById('coiffeur_id').value = '{{ Auth::id() }}';
      if (document.getElementById('select_coiffeur')) {
        document.getElementById('select_coiffeur').value = '{{ Auth::id() }}';
      }
      document.getElementById('client_name').value = '';
      document.getElementById('client_phone').value = '';
      document.getElementById('client_email').value = '';
      document.getElementById('client_address').value = '';
      showWizard(1);
    }

    function openTakeForSomeone() {
      // clear fields, allow choosing coiffeur
      document.getElementById('coiffeur_id').value = '{{ Auth::id() }}';
      showWizard(1);
    }

    function showWizard(step) {
      currentStep = step;
      document.getElementById('takeModal').style.display = 'flex';
      document.querySelectorAll('.wizard-step').forEach(el => el.style.display = 'none');
      const el = document.querySelector('.wizard-step[data-step="' + step + '"]');
      if (el) el.style.display = 'block';
      document.getElementById('prevBtn').style.display = step > 1 ? 'inline-block' : 'none';
      document.getElementById('nextBtn').style.display = step < totalSteps ? 'inline-block' : 'none';
      document.getElementById('submitBtn').style.display = step === totalSteps ? 'inline-block' : 'none';

      // update summary when entering last step
      if (step === totalSteps) buildSummary();
    }

    function nextStep() {
      // minimal validation per step
      if (currentStep === 1) {
        const name = document.getElementById('client_name').value.trim();
        const phone = document.getElementById('client_phone').value.trim();
        if (!name || !phone) { alert('Nom et téléphone requis.'); return; }
      }
      if (currentStep === 2) {
        const sid = document.getElementById('service_id').value;
        if (!sid) { alert('Choisissez un service.'); return; }
      }
      if (currentStep === 4) {
        const date = document.getElementById('date').value;
        const heure = document.getElementById('heure').value;
        if (!date || !heure) { alert('Date et heure requises.'); return; }
      }
      if (currentStep < totalSteps) showWizard(currentStep + 1);
    }

    function prevStep() {
      if (currentStep > 1) showWizard(currentStep - 1);
    }

    function closeTakeModal() {
      document.getElementById('takeModal').style.display = 'none';
    }

    function buildSummary() {
      const s = document.getElementById('summaryBox');
      const name = document.getElementById('client_name').value;
      const phone = document.getElementById('client_phone').value;
      const email = document.getElementById('client_email').value;
      const addr = document.getElementById('client_address').value;
      // service_id est un input hidden — on récupère le texte depuis la card sélectionnée
      const serviceId = document.getElementById('service_id') ? document.getElementById('service_id').value : '';
      let serviceText = '';
      if (serviceId) {
        const card = document.querySelector('.service-card[data-id="' + serviceId + '"]');
        if (card) {
          const strong = card.querySelector('strong');
          serviceText = strong ? strong.textContent.trim() : '';
        }
      }
      const coif = document.getElementById('select_coiffeur');
      const coifText = coif ? coif.options[coif.selectedIndex]?.text : '';
      const date = document.getElementById('date').value;
      const heure = document.getElementById('heure').value;
      s.innerHTML = `
        <strong>${name}</strong><br>
        ${phone} ${email ? ' — ' + email : ''}<br>
        ${addr ? addr + '<br>' : ''}
        Service: ${serviceText}<br>
        Coiffeur: ${coifText}<br>
        Date: ${date} — ${heure}
      `;
    }

    async function submitTakeForm() {
      // sync hidden coiffeur_id with select (au cas où)
      const sel = document.getElementById('select_coiffeur');
      if (sel) document.getElementById('coiffeur_id').value = sel.value;

      const submitBtn = document.getElementById('submitBtn');
      if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Envoi…'; }

      // read and normalize values: send null for empty optional fields
      const clientName = document.getElementById('client_name').value.trim();
      const clientPhone = document.getElementById('client_phone').value.trim();
      const clientEmailRaw = document.getElementById('client_email').value.trim();
      const clientEmail = clientEmailRaw === '' ? null : clientEmailRaw;
      const clientAddressRaw = document.getElementById('client_address').value.trim();
      const clientAddress = clientAddressRaw === '' ? null : clientAddressRaw;
      const serviceId = document.getElementById('service_id').value;
      const date = document.getElementById('date').value;
      const heure = document.getElementById('heure').value;
      const coiffeurId = (document.getElementById('select_coiffeur') ? document.getElementById('select_coiffeur').value : document.getElementById('coiffeur_id').value);

      const payload = {
        client_name: clientName,
        client_phone: clientPhone,
        client_email: clientEmail,
        client_address: clientAddress,
        service_id: serviceId,
        date: date,
        heure: heure,
        coiffeur_id: coiffeurId ? parseInt(coiffeurId, 10) : null
      };

      // validate minimal
      if (!payload.client_name || !payload.client_phone || !payload.service_id || !payload.date || !payload.heure || !payload.coiffeur_id) {
        alert('Remplissez les champs obligatoires (nom, téléphone, service, date, heure, coiffeur).');
        if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = 'Confirmer'; }
        return;
      }

      try {
        console.log('payload', payload);
        const res = await fetch('{{ route("coifdash.rdv_guest") }}', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(payload)
        });

        console.log('fetch done', res.status, res.url);
        const text = await res.text();
        console.log('response text (snippet):', text.slice(0, 1000));
        let json = null;
        const ct = res.headers.get('content-type') || '';
        if (ct.includes('application/json')) {
          try { json = JSON.parse(text); } catch (e) { console.error('JSON parse failed', e); }
        }

        if (res.ok && json && json.success) {
          alert('Rendez‑vous créé (id: ' + (json.rdv_id || '-') + ').');
          closeTakeModal();
          location.reload();
          return;
        }

        if (res.status === 419) {
          alert('Session expirée / token CSRF invalide. Rechargez la page.');
        } else if (res.status === 422 && json) {
          const errors = json.errors || json;
          let msg = 'Erreurs:\n';
          if (typeof errors === 'object') {
            for (const k in errors) msg += (errors[k].join ? errors[k].join(', ') : errors[k]) + '\n';
          } else msg += JSON.stringify(errors);
          alert(msg);
        } else {
          alert(json?.message || 'Erreur création rendez‑vous — voir console et onglet Network.');
        }
      } catch (err) {
        console.error('submitTakeForm error', err);
        alert('Erreur réseau — voir console (F12).');
      } finally {
        if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = 'Confirmer'; }
      }
    }

    // Exposer les fonctions globalement (au cas où elles sont définies plus haut)
    if (typeof openTakeForSelf === 'function') window.openTakeForSelf = openTakeForSelf;
    if (typeof openTakeForSomeone === 'function') window.openTakeForSomeone = openTakeForSomeone;
    if (typeof submitTakeForm === 'function') window.submitTakeForm = submitTakeForm;

    // Attacher event listeners si boutons existent
    document.addEventListener('DOMContentLoaded', function () {
      const b1 = document.getElementById('btnTakeSelf');
      const b2 = document.getElementById('btnTakeSomeone');
      if (b1) b1.addEventListener('click', () => { window.openTakeForSelf ? window.openTakeForSelf() : console.warn('openTakeForSelf missing'); });
      if (b2) b2.addEventListener('click', () => { window.openTakeForSomeone ? window.openTakeForSomeone() : console.warn('openTakeForSomeone missing'); });
    });

    function selectService(id) {
      // met à jour le champ caché
      const h = document.getElementById('service_id');
      if (h) h.value = id;
      // met à jour l'état visuel
      document.querySelectorAll('.service-card').forEach(el => el.style.borderColor = '#eee');
      const sel = document.querySelector('.service-card[data-id="' + id + '"]');
      if (sel) sel.style.borderColor = 'var(--gold)';
      // coche le radio (au cas où)
      const r = document.getElementById('svc' + id);
      if (r) r.checked = true;
    }

    // si tu veux préselectionner le premier service automatiquement :
    document.addEventListener('DOMContentLoaded', function () {
      const first = document.querySelector('.service-card');
      if (first && !document.getElementById('service_id').value) {
        selectService(first.getAttribute('data-id'));
      }
    });

    async function fetchAvailableHours(date) {
      const heureSelect = document.getElementById('heure');
      heureSelect.innerHTML = '<option>Chargement…</option>';
      if (!date) { heureSelect.innerHTML = '<option value="">-- choisissez une date d\'abord --</option>'; return; }

      // récupérer le coiffeur sélectionné ou le coiffeur connecté
      const coifEl = document.getElementById('select_coiffeur');
      const stylistId = coifEl ? coifEl.value : '{{ Auth::id() }}';

      // optionnel : durée du service (si tu veux filtrer)
      const serviceId = document.getElementById('service_id') ? document.getElementById('service_id').value : null;
      let serviceDuration = null;
      @if(isset($services) && $services->count())
        // map duration côté client si nécessaire (simple fallback)
        const svcMap = @json($services->mapWithKeys(function ($s) {
          return [$s->id => $s->duration ?? null];
        }));
        if (serviceId && svcMap[serviceId]) serviceDuration = svcMap[serviceId];
      @else
        const svcMap = {};
      @endif

      try {
        const res = await fetch('{{ route("horaire.hours") }}', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            stylist_id: parseInt(stylistId),
            date: date,
            service_duration: serviceDuration
          })
        });

        if (!res.ok) {
          console.error('horaire.hours status', res.status);
          heureSelect.innerHTML = '<option value="">Erreur de chargement</option>';
          return;
        }

        const payload = await res.json();
        const times = payload.times || [];
        if (times.length === 0) {
          heureSelect.innerHTML = '<option value="">Aucun créneau disponible</option>';
          return;
        }

        heureSelect.innerHTML = '<option value="">-- sélectionnez une heure --</option>';
        times.forEach(t => {
          const opt = document.createElement('option');
          opt.value = t;
          opt.text = t;
          heureSelect.appendChild(opt);
        });
      } catch (err) {
        console.error('fetchAvailableHours error', err);
        heureSelect.innerHTML = '<option value="">Erreur réseau</option>';
      }
    }

    // token CSRF
    const _csrf = '{{ csrf_token() }}';

    // quand on change le coiffeur dans le wizard -> charger jours disponibles
    document.addEventListener('DOMContentLoaded', function () {
      const coifEl = document.getElementById('select_coiffeur');
      if (coifEl) {
        coifEl.addEventListener('change', function () {
          const id = this.value;
          if (id) fetchWorkingDays(id);
        });

        // si coiffeur par défaut est déjà sélectionné, charger ses jours
        if (coifEl.value) fetchWorkingDays(coifEl.value);
      }

      // si l'utilisateur change de service, on peut recharger heures plus tard si besoin
      const svc = document.getElementById('service_id');
      if (svc) svc.addEventListener('change', function () {
        // si une date est déjà choisie, recharger heures pour le coiffeur actuel
        const date = document.getElementById('date').value;
        const coif = document.getElementById('select_coiffeur') ? document.getElementById('select_coiffeur').value : document.getElementById('coiffeur_id').value;
        if (date) fetchAvailableHours(date);
      });

      // si on change la date (select), charger heures pour le coiffeur choisi
      const dateSelect = document.getElementById('date');
      if (dateSelect) {
        dateSelect.addEventListener('change', function () {
          const date = this.value;
          const coif = document.getElementById('select_coiffeur') ? document.getElementById('select_coiffeur').value : document.getElementById('coiffeur_id').value;
          if (date) fetchAvailableHours(date);
        });
      }
    });

    // suppression des appels fetch côté days/hours — on utilise la map fournie par le controller
    const horaireMap = @json($horaire_map ?? []);

    // parse helpers (réutilisables)
    function parseTimeToMinutes(t) {
      const [h, m] = (t || '').split(':').map(Number);
      return (isNaN(h) ? 0 : h * 60) + (isNaN(m) ? 0 : m);
    }
    function minutesToTime(min) {
      const h = Math.floor(min / 60).toString().padStart(2, '0');
      const m = (min % 60).toString().padStart(2, '0');
      return `${h}:${m}`;
    }
    function parseHoraireJourToSlots(horaire_jour, step = 30) {
      if (!horaire_jour) return [];
      const parts = horaire_jour.split('/').map(p => p.trim()).filter(Boolean);
      const slots = [];
      for (const p of parts) {
        if (p.includes('-')) {
          const [start, end] = p.split('-').map(s => s.trim());
          const sMin = parseTimeToMinutes(start);
          const eMin = parseTimeToMinutes(end);
          if (isNaN(sMin) || isNaN(eMin) || eMin <= sMin) { slots.push(p); continue; }
          for (let t = sMin; t < eMin; t += step) slots.push(minutesToTime(t));
        } else {
          slots.push(p);
        }
      }
      return Array.from(new Set(slots)).sort();
    }

    function filterSlotsByServiceDuration(slots, horaire_jour, serviceDuration) {
      if (!serviceDuration || serviceDuration <= 0) return slots;

      const parts = horaire_jour.split('/').map(p => p.trim()).filter(Boolean);
      const validSlots = [];

      for (const slot of slots) {
        const slotMinutes = parseTimeToMinutes(slot);
        if (isNaN(slotMinutes)) { validSlots.push(slot); continue; }

        const endMinutes = slotMinutes + serviceDuration;
        let canFit = false;

        // Check each segment to see if the appointment can fit
        for (const seg of parts) {
          if (!seg.includes('-')) continue;
          const [start, end] = seg.split('-').map(s => s.trim());
          const segStart = parseTimeToMinutes(start);
          const segEnd = parseTimeToMinutes(end);

          if (!isNaN(segStart) && !isNaN(segEnd) && slotMinutes >= segStart && endMinutes <= segEnd) {
            canFit = true;
            break;
          }
        }

        if (canFit) validSlots.push(slot);
      }

      return validSlots;
    }

    // timesByDate temporaire (pour coiffeur courant)
    let timesByDate = {};

    function fillHoursSelect(times) {
      const heureEl = document.getElementById('heure');
      if (!heureEl) return;
      if (!times || times.length === 0) {
        heureEl.innerHTML = '<option value="">Aucun créneau disponible</option>';
        return;
      }
      heureEl.innerHTML = '<option value="">-- sélectionnez --</option>';
      times.forEach(t => {
        const opt = document.createElement('option');
        opt.value = t;
        opt.text = t;
        heureEl.appendChild(opt);
      });
    }

    // Remplit le select #date en utilisant horaireMap (pas de fetch)
    function fetchWorkingDays(stylistId) {
      const dateEl = document.getElementById('date');
      if (!dateEl) return;
      dateEl.innerHTML = '<option>Chargement…</option>';

      const entries = horaireMap[stylistId] || [];
      if (!entries.length) {
        dateEl.innerHTML = '<option value="">Aucun jour disponible</option>';
        timesByDate = {};
        const heureEl = document.getElementById('heure');
        if (heureEl) heureEl.innerHTML = '<option value="">-- choisissez une date d\'abord --</option>';
        return;
      }

      // build timesByDate for this stylist
      timesByDate = {};
      dateEl.innerHTML = '<option value="">-- sélectionnez --</option>';
      entries.forEach(it => {
        const d = it.date;
        const horaireStr = it.horaire_jour || null;
        if (horaireStr) {
          let slots = parseHoraireJourToSlots(horaireStr, 30);
          // Get service duration if a service is selected
          const serviceId = document.getElementById('service_id') ? document.getElementById('service_id').value : null;
          @if(isset($services) && $services->count())
            const svcMap = @json($services->mapWithKeys(function ($s) {
              return [$s->id => $s->duration ?? null];
            }));
            const serviceDuration = serviceId && svcMap[serviceId] ? svcMap[serviceId] : null;
            if (serviceDuration) slots = filterSlotsByServiceDuration(slots, horaireStr, serviceDuration);
          @endif
          timesByDate[d] = slots;
        }
        const opt = document.createElement('option');
        opt.value = d;
        opt.textContent = new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' });
        dateEl.appendChild(opt);
      });

      // sélection automatique du premier jour
      const first = dateEl.querySelector('option[value]:not([value=""])');
      if (first) {
        dateEl.value = first.value;
        if (timesByDate[first.value] && timesByDate[first.value].length) fillHoursSelect(timesByDate[first.value]);
        else document.getElementById('heure').innerHTML = '<option value="">Aucun créneau disponible</option>';
      }
    }

    // appelé par onchange de la liste Date dans le form
    function fetchAvailableHours(date) {
      if (!date) {
        document.getElementById('heure').innerHTML = '<option value="">-- choisissez une date d\'abord --</option>';
        return;
      }
      let times = timesByDate[date] || [];

      // Re-filter by service duration if service is selected
      const serviceId = document.getElementById('service_id') ? document.getElementById('service_id').value : null;
      @if(isset($services) && $services->count())
        const svcMap = @json($services->mapWithKeys(function ($s) {
          return [$s->id => $s->duration ?? null];
        }));
        const serviceDuration = serviceId && svcMap[serviceId] ? svcMap[serviceId] : null;
        if (serviceDuration) {
          // Find the original horaire_jour for this date
          const coifEl = document.getElementById('select_coiffeur');
          const stylistId = coifEl ? coifEl.value : document.getElementById('coiffeur_id').value;
          const entries = horaireMap[stylistId] || [];
          const entry = entries.find(e => e.date === date);
          if (entry && entry.horaire_jour) {
            times = filterSlotsByServiceDuration(times, entry.horaire_jour, serviceDuration);
          }
        }
      @endif

      fillHoursSelect(times);
    }

    // synchronization coiffeur select -> hidden + initial load
    function initCoiffeurSync() {
      const sel = document.getElementById('select_coiffeur');
      const hidden = document.getElementById('coiffeur_id');
      const initial = (sel && sel.value) ? sel.value : (hidden ? hidden.value : null);
      if (hidden && !hidden.value && initial) hidden.value = initial;
      if (sel) {
        if (initial) fetchWorkingDays(initial);
        sel.addEventListener('change', () => {
          if (hidden) hidden.value = sel.value;
          fetchWorkingDays(sel.value);
        });
      } else if (initial) {
        fetchWorkingDays(initial);
      }
    }

    document.addEventListener('DOMContentLoaded', initCoiffeurSync);
  </script>
</body>

</html>