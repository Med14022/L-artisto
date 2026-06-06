<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:11px; color:#1a1a1a; }
    .gold-line { height:3px; background:#D4AF37; }
    .header { background:#09090f; color:#D4AF37; padding:18px 24px; margin-bottom:20px; display:flex; justify-content:space-between; }
    .brand { font-size:20px; font-weight:700; letter-spacing:2px; color:#D4AF37; }
    .brand-sub { font-size:10px; color:#7a7060; }
    .header-right { text-align:right; font-size:11px; color:#7a7060; }
    .header-right strong { display:block; font-size:13px; color:#D4AF37; }
    .doc-title { font-size:15px; font-weight:700; padding:0 24px; margin-bottom:16px; }

    .day-block { margin:0 24px 16px; break-inside:avoid; }
    .day-label { background:#f9fafb; border-left:3px solid #D4AF37; padding:6px 12px; font-weight:700; font-size:12px; color:#1a1a1a; text-transform:capitalize; margin-bottom:6px; border-radius:0 6px 6px 0; }

    table { width:100%; border-collapse:collapse; margin-bottom:6px; }
    th { padding:6px 10px; font-size:9px; font-weight:700; text-transform:uppercase; color:#6b7280; border-bottom:1px solid #e5e7eb; }
    td { padding:7px 10px; font-size:11px; border-bottom:1px solid #f3f4f6; }
    .time { font-weight:700; color:#B8860B; }
    .badge { display:inline-block; padding:1px 7px; border-radius:20px; font-size:9px; font-weight:700; }
    .b-pending   { background:#fef3c7; color:#92400e; }
    .b-confirmed { background:#d1fae5; color:#065f46; }
    .b-done      { background:#ede9fe; color:#4c1d95; }
    .b-cancelled { background:#fee2e2; color:#991b1b; }
    .no-rdv { color:#9ca3af; font-style:italic; padding:8px 10px; }
    .footer { margin-top:20px; padding:10px 24px; border-top:1px solid #e5e7eb; font-size:9px; color:#9ca3af; display:flex; justify-content:space-between; }
</style>
</head>
<body>
<div class="gold-line"></div>
<div class="header">
    <div><div class="brand">L'ARTISTO</div><div class="brand-sub">Barbershop Premium</div></div>
    <div class="header-right">
        <strong>Planning semaine</strong>
        {{ $debut->locale('fr')->isoFormat('D MMM') }} – {{ $fin->locale('fr')->isoFormat('D MMM YYYY') }}
    </div>
</div>

<div class="doc-title">Planning de {{ $coiffeur->name }}</div>

@foreach(\Carbon\CarbonPeriod::create($debut, $fin) as $jour)
@php $dateStr = $jour->toDateString(); $joursRdvs = $rdvs->get($dateStr, collect()); @endphp
<div class="day-block">
    <div class="day-label">
        {{ $jour->locale('fr')->isoFormat('dddd D MMMM') }}
        <span style="color:#9ca3af;font-weight:400;font-size:10px;">({{ $joursRdvs->count() }} RDV)</span>
    </div>
    @if($joursRdvs->isEmpty())
        <div class="no-rdv">Aucun rendez-vous</div>
    @else
    <table>
        <thead><tr><th>Heure</th><th>Client</th><th>Service(s)</th><th>Statut</th></tr></thead>
        <tbody>
            @foreach($joursRdvs as $rdv)
            @php $badges=['en attente'=>'b-pending','confirmé'=>'b-confirmed','terminé'=>'b-done','annulé'=>'b-cancelled']; @endphp
            <tr>
                <td><span class="time">{{ substr($rdv->heure,0,5) }}</span></td>
                <td style="font-weight:600;">{{ $rdv->client->name ?? '— Invité —' }}</td>
                <td style="color:#4b5563;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</td>
                <td><span class="badge {{ $badges[$rdv->etat]??'' }}">{{ ucfirst($rdv->etat) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endforeach

<div class="footer">
    <span>L'ARTISTO Barbershop</span>
    <span>Généré le {{ now()->format('d/m/Y à H:i') }}</span>
</div>
</body>
</html>
