<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:10px; color:#1a1a1a; }
    .gold-line { height:3px; background:#D4AF37; }
    .header { background:#09090f; padding:16px 22px; margin-bottom:18px; display:flex; justify-content:space-between; align-items:center; }
    .brand { font-size:20px; font-weight:700; letter-spacing:2px; color:#D4AF37; }
    .brand-sub { font-size:9px; color:#7a7060; }
    .header-right { text-align:right; }
    .header-right strong { display:block; font-size:13px; color:#D4AF37; }
    .header-right span { font-size:10px; color:#7a7060; }

    .doc-title { font-size:15px; font-weight:700; padding:0 22px; margin-bottom:4px; }
    .doc-sub   { font-size:10px; color:#6b7280; padding:0 22px; margin-bottom:16px; }

    .stats-row { display:flex; gap:10px; margin:0 22px 18px; }
    .stat { flex:1; border:1px solid #e5e7eb; border-radius:6px; padding:10px; text-align:center; }
    .stat-n { font-size:22px; font-weight:700; }
    .stat-l { font-size:9px; color:#9ca3af; text-transform:uppercase; margin-top:2px; }

    table { width:calc(100% - 44px); margin:0 22px; border-collapse:collapse; }
    thead { background:#f9fafb; }
    th { padding:7px 9px; font-size:9px; font-weight:700; text-transform:uppercase; color:#6b7280; border-bottom:2px solid #e5e7eb; white-space:nowrap; }
    td { padding:7px 9px; font-size:10px; border-bottom:1px solid #f3f4f6; vertical-align:top; }
    tr:last-child td { border-bottom:none; }
    tr:nth-child(even) { background:#fafafa; }
    .time { font-weight:700; color:#B8860B; }
    .badge { display:inline-block; padding:1px 6px; border-radius:20px; font-size:9px; font-weight:700; }
    .b-pending   { background:#fef3c7; color:#92400e; }
    .b-confirmed { background:#d1fae5; color:#065f46; }
    .b-done      { background:#ede9fe; color:#4c1d95; }
    .b-cancelled { background:#fee2e2; color:#991b1b; }
    .empty { text-align:center; color:#9ca3af; padding:30px; font-style:italic; }
    .footer { margin-top:18px; padding:10px 22px; border-top:1px solid #e5e7eb; font-size:9px; color:#9ca3af; display:flex; justify-content:space-between; }
</style>
</head>
<body>
<div class="gold-line"></div>
<div class="header">
    <div><div class="brand">L'ARTISTO</div><div class="brand-sub">Barbershop Premium — Administration</div></div>
    <div class="header-right">
        <strong>Rapport mensuel</strong>
        <span>{{ ucfirst($moisLabel) }}</span>
    </div>
</div>

<div class="doc-title">Rapport des Rendez-vous — {{ ucfirst($moisLabel) }}</div>
<div class="doc-sub">Tous les rendez-vous enregistrés sur la période</div>

<div class="stats-row">
    <div class="stat"><div class="stat-n">{{ $stats['total'] }}</div><div class="stat-l">Total RDV</div></div>
    <div class="stat"><div class="stat-n" style="color:#065f46;">{{ $stats['termines'] }}</div><div class="stat-l">Terminés</div></div>
    <div class="stat"><div class="stat-n" style="color:#1d4ed8;">{{ $stats['confirmes'] }}</div><div class="stat-l">Confirmés</div></div>
    <div class="stat"><div class="stat-n" style="color:#991b1b;">{{ $stats['annules'] }}</div><div class="stat-l">Annulés</div></div>
</div>

@if($rdvs->isEmpty())
    <p class="empty">Aucun rendez-vous pour ce mois.</p>
@else
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Client</th>
            <th>Coiffeur</th>
            <th>Service(s)</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rdvs as $rdv)
        @php $badges=['en attente'=>'b-pending','confirmé'=>'b-confirmed','terminé'=>'b-done','annulé'=>'b-cancelled']; @endphp
        <tr>
            <td style="color:#9ca3af;">#{{ $rdv->id }}</td>
            <td style="font-weight:600;white-space:nowrap;">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</td>
            <td><span class="time">{{ substr($rdv->heure,0,5) }}</span></td>
            <td>{{ $rdv->client->name ?? '— Invité —' }}</td>
            <td>{{ $rdv->coiffeur->name ?? '—' }}</td>
            <td style="color:#4b5563;max-width:120px;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
            <td><span class="badge {{ $badges[$rdv->etat]??'' }}">{{ ucfirst($rdv->etat) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div class="footer">
    <span>L'ARTISTO Barbershop — Rapport confidentiel</span>
    <span>Généré le {{ now()->format('d/m/Y à H:i') }}</span>
</div>
</body>
</html>
