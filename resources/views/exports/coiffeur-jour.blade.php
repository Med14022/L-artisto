<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; color:#1a1a1a; background:#fff; }

    .header { background:#09090f; color:#D4AF37; padding:20px 28px; margin-bottom:24px; }
    .header-top { display:flex; justify-content:space-between; align-items:flex-start; }
    .brand { font-size:22px; font-weight:700; letter-spacing:2px; color:#D4AF37; }
    .brand-sub { font-size:10px; color:#7a7060; text-transform:uppercase; letter-spacing:1px; margin-top:2px; }
    .header-right { text-align:right; font-size:11px; color:#7a7060; }
    .header-right strong { display:block; font-size:14px; color:#D4AF37; margin-bottom:2px; }
    .gold-line { height:3px; background:linear-gradient(90deg,#B8860B,#FFD700,#B8860B); margin-bottom:4px; }

    .doc-title { font-size:16px; font-weight:700; color:#1a1a1a; margin-bottom:4px; padding:0 28px; }
    .doc-sub   { font-size:11px; color:#6b7280; margin-bottom:20px; padding:0 28px; }

    .summary { display:flex; gap:12px; margin:0 28px 20px; }
    .stat-box { flex:1; border:1px solid #e5e7eb; border-radius:8px; padding:12px 14px; text-align:center; }
    .stat-num  { font-size:24px; font-weight:700; color:#1a1a1a; }
    .stat-lbl  { font-size:10px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px; }

    table { width:calc(100% - 56px); margin:0 28px; border-collapse:collapse; }
    thead tr { background:#f9fafb; }
    th { padding:9px 12px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#6b7280; border-bottom:2px solid #e5e7eb; }
    td { padding:10px 12px; font-size:11.5px; border-bottom:1px solid #f3f4f6; vertical-align:top; }
    tr:last-child td { border-bottom:none; }
    tr:nth-child(even) { background:#fafafa; }

    .badge { display:inline-block; padding:2px 8px; border-radius:20px; font-size:10px; font-weight:700; }
    .b-pending   { background:#fef3c7; color:#92400e; }
    .b-confirmed { background:#d1fae5; color:#065f46; }
    .b-done      { background:#ede9fe; color:#4c1d95; }
    .b-cancelled { background:#fee2e2; color:#991b1b; }

    .time { font-weight:700; color:#B8860B; font-size:13px; }
    .empty { text-align:center; color:#9ca3af; padding:40px; font-style:italic; }

    .footer { margin-top:28px; padding:12px 28px; border-top:1px solid #e5e7eb; font-size:10px; color:#9ca3af; display:flex; justify-content:space-between; }
</style>
</head>
<body>

<div class="gold-line"></div>
<div class="header">
    <div class="header-top">
        <div>
            <div class="brand">L'ARTISTO</div>
            <div class="brand-sub">Barbershop Premium</div>
        </div>
        <div class="header-right">
            <strong>Planning du jour</strong>
            {{ $dateLabel }}
        </div>
    </div>
</div>

<div class="doc-title">Planning de {{ $coiffeur->name }}</div>
<div class="doc-sub">Rendez-vous du {{ $dateLabel }}</div>

<div class="summary">
    <div class="stat-box">
        <div class="stat-num">{{ $rdvs->count() }}</div>
        <div class="stat-lbl">Total</div>
    </div>
    <div class="stat-box">
        <div class="stat-num" style="color:#065f46;">{{ $rdvs->where('etat','confirmé')->count() }}</div>
        <div class="stat-lbl">Confirmés</div>
    </div>
    <div class="stat-box">
        <div class="stat-num" style="color:#92400e;">{{ $rdvs->where('etat','en attente')->count() }}</div>
        <div class="stat-lbl">En attente</div>
    </div>
    <div class="stat-box">
        <div class="stat-num" style="color:#991b1b;">{{ $rdvs->where('etat','annulé')->count() }}</div>
        <div class="stat-lbl">Annulés</div>
    </div>
</div>

@if($rdvs->isEmpty())
    <p class="empty">Aucun rendez-vous pour cette journée.</p>
@else
<table>
    <thead>
        <tr>
            <th>Heure</th>
            <th>Client</th>
            <th>Service(s)</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rdvs as $rdv)
        @php $badges = ['en attente'=>'b-pending','confirmé'=>'b-confirmed','terminé'=>'b-done','annulé'=>'b-cancelled']; @endphp
        <tr>
            <td><span class="time">{{ substr($rdv->heure,0,5) }}</span></td>
            <td style="font-weight:600;">{{ $rdv->client->name ?? '— Invité —' }}</td>
            <td style="color:#4b5563;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
            <td><span class="badge {{ $badges[$rdv->etat] ?? '' }}">{{ ucfirst($rdv->etat) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div class="footer">
    <span>L'ARTISTO Barbershop</span>
    <span>Généré le {{ now()->format('d/m/Y à H:i') }}</span>
</div>

</body>
</html>
