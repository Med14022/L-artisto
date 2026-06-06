<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rappel RDV</title>
</head>
<body style="margin:0;padding:0;background:#f4f1eb;font-family:'Helvetica Neue',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f1eb;padding:40px 20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

  {{-- Header --}}
  <tr>
    <td style="background:#09090f;padding:0;">
      <div style="height:4px;background:linear-gradient(90deg,#B8860B,#FFD700,#B8860B);"></div>
      <table width="100%" cellpadding="0" cellspacing="0" style="padding:28px 36px;">
        <tr>
          <td>
            <span style="font-family:Georgia,serif;font-size:24px;font-weight:700;color:#D4AF37;letter-spacing:2px;">L'ARTISTO</span>
            <span style="display:block;font-size:11px;color:#7a7060;text-transform:uppercase;letter-spacing:1.5px;margin-top:2px;">Barbershop Premium</span>
          </td>
          <td align="right">
            <span style="background:rgba(251,191,36,0.15);border:1px solid rgba(251,191,36,0.3);color:#fbbf24;font-size:11px;font-weight:600;padding:4px 12px;border-radius:20px;">⏰ Rappel J-1</span>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- Body --}}
  <tr>
    <td style="padding:36px;">

      <h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#1a1a1a;">N'oubliez pas votre rendez-vous demain !</h1>
      <p style="margin:0 0 28px;color:#6b7280;font-size:15px;">
        Bonjour <strong style="color:#1a1a1a;">{{ $rdv->client->name ?? 'cher client' }}</strong>, nous vous rappelons votre rendez-vous prévu demain chez L'ARTISTO.
      </p>

      {{-- Récap Card --}}
      <table width="100%" cellpadding="0" cellspacing="0" style="background:#faf9f6;border:1px solid #e8e0d0;border-radius:12px;overflow:hidden;margin-bottom:28px;">
        <tr>
          <td style="padding:24px;">
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50%" style="padding-bottom:16px;">
                  <span style="display:block;font-size:11px;text-transform:uppercase;letter-spacing:0.8px;color:#9ca3af;margin-bottom:4px;">Date</span>
                  <span style="font-size:16px;font-weight:700;color:#1a1a1a;">
                    {{ \Carbon\Carbon::parse($rdv->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                  </span>
                </td>
                <td width="50%" style="padding-bottom:16px;">
                  <span style="display:block;font-size:11px;text-transform:uppercase;letter-spacing:0.8px;color:#9ca3af;margin-bottom:4px;">Heure</span>
                  <span style="font-size:20px;font-weight:700;color:#B8860B;">{{ substr($rdv->heure, 0, 5) }}</span>
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <span style="display:block;font-size:11px;text-transform:uppercase;letter-spacing:0.8px;color:#9ca3af;margin-bottom:4px;">Votre coiffeur</span>
                  <span style="font-size:15px;font-weight:600;color:#1a1a1a;">{{ $rdv->coiffeur->name ?? '—' }}</span>
                </td>
                <td width="50%">
                  <span style="display:block;font-size:11px;text-transform:uppercase;letter-spacing:0.8px;color:#9ca3af;margin-bottom:4px;">Service(s)</span>
                  <span style="font-size:15px;font-weight:600;color:#1a1a1a;">{{ $rdv->services->pluck('name')->join(', ') ?: '—' }}</span>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <p style="margin:0 0 28px;color:#6b7280;font-size:14px;line-height:1.6;">
        Merci de vous présenter <strong>5 minutes avant</strong> l'heure prévue.<br>
        En cas d'empêchement, veuillez nous contacter dès que possible.
      </p>

      <table cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
        <tr>
          <td style="background:#D4AF37;border-radius:8px;padding:12px 28px;">
            <a href="{{ url('/dashboard') }}" style="color:#0a0a0a;font-weight:700;font-size:14px;text-decoration:none;display:block;">
              Voir mes rendez-vous →
            </a>
          </td>
        </tr>
      </table>

      <hr style="border:none;border-top:1px solid #e8e0d0;margin:0 0 24px;">
      <p style="margin:0;color:#9ca3af;font-size:12px;line-height:1.6;">
        Cet email a été envoyé automatiquement, merci de ne pas y répondre.<br>
        © {{ date('Y') }} L'ARTISTO Barbershop — Tous droits réservés.
      </p>

    </td>
  </tr>

</table>
</td></tr>
</table>

</body>
</html>
