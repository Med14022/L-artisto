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
        <span class="welcome-text">Bienvenue, {{ Auth::user()->name }}</span>
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
          <p>Bienvenue, Bougacha — aperçu rapide de vos rendez‑vous</p>
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
                    <div class="time">{{ \Carbon\Carbon::parse($rdv->heure)->format('H:i') }}</div>
                    <div class="meta">
                      <div class="client">{{ $rdv->client->name }}</div>
                      <div class="service">@foreach ($rdv->services as $service)
                        {{ $service->name }} — {{ $service->duration }} min<br>
                      @endforeach
                      </div>
                      <div class="muted">Téléphone: {{ $rdv->client->phone }}</div>
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
            <button class="btn btn-primary" onclick="takeForSelf()">Prendre RDV pour moi</button>
            <button class="btn btn-ghost" onclick="takeForSomeone()">Prendre RDV pour quelqu'un</button>
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
              <div style="display:flex;justify-content:space-between">
                <div><strong>16:30</strong>
                  <div class="muted" style="font-size:13px">Youssef — Coupe</div>
                </div>
                <div class="muted">Demain</div>
              </div>
              <div style="display:flex;justify-content:space-between">
                <div><strong>11:00</strong>
                  <div class="muted" style="font-size:13px">Safa — Barbe</div>
                </div>
                <div class="muted">2j</div>
              </div>
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
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ date: date })
      })
        .then(response => response.json())
        .then(data => {
          // 🔹 Mettre à jour le titre
          document.getElementById('rdv-title').textContent = 'Rendez-vous du ' + date;

          // 🔹 Construire le HTML des rdvs
          let html = '';
          if (data.length === 0) {
            html = '<div style="text-align:center; color:#666; margin-top:20px">Aucun rendez-vous pour cette date.</div>';
          } else {
            data.forEach(rdv => {
              html += `
            <div class="appt" data-id="${rdv.id}">
              <div class="time">${rdv.heure.slice(0,5)}</div>
              <div class="meta">
                <div class="client">${rdv.client.name}</div>
                <div class="service">
                  ${rdv.services.map(s => `${s.name} — ${s.duration} min`).join('<br>')}
                </div>
                <div class="muted">Téléphone: ${rdv.client.phone}</div>
              </div>
              <div class="actions">
                <button class="btn btn-ghost" onclick="markDone(this,${rdv.id})">Terminé</button>
                <button class="btn btn-primary" onclick="openTake(${rdv.id})">Voir</button>
              </div>
            </div>
          `;
            });
          }

          // 🔹 Injecter dans le DOM
          document.getElementById('rdv-list').innerHTML = html;
        })
        
    }


  </script>
</body>

</html>