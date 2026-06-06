<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation confirmée — L'ARTISTO</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --gold:#D4AF37; --gold-light:#FFD700; --gold-dark:#B8860B; --bg:#07070d; --border:rgba(212,175,55,0.15); --text:#e8e0d0; --text-muted:#8a8070; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
        .card {
            background:rgba(255,255,255,0.04); border:1px solid var(--border);
            border-radius:20px; padding:48px 40px; max-width:480px; width:100%; text-align:center;
        }
        .checkmark {
            width:72px; height:72px; border-radius:50%;
            background:linear-gradient(135deg,rgba(34,197,94,0.15),rgba(34,197,94,0.05));
            border:2px solid rgba(34,197,94,0.3);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 24px; font-size:32px;
        }
        h1 { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; margin-bottom:8px; }
        .sub { color:var(--text-muted); font-size:14px; margin-bottom:32px; line-height:1.6; }
        .recap {
            background:rgba(212,175,55,0.05); border:1px solid rgba(212,175,55,0.15);
            border-radius:12px; padding:20px 24px; text-align:left; margin-bottom:32px;
        }
        .recap-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid rgba(255,255,255,0.04); font-size:13px; }
        .recap-row:last-child { border-bottom:none; }
        .recap-label { color:var(--text-muted); }
        .recap-value { font-weight:600; color:var(--text); }
        .btn-home {
            display:inline-block; padding:13px 32px;
            background:linear-gradient(135deg,var(--gold-dark),var(--gold-light));
            color:#0a0a0a; font-weight:700; font-size:14px;
            border-radius:10px; text-decoration:none; letter-spacing:0.5px;
            transition:all 0.2s;
        }
        .btn-home:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(212,175,55,0.3); }
    </style>
</head>
<body>
<div class="card">
    <div class="checkmark">✓</div>
    <h1>Réservation effectuée !</h1>
    <p class="sub">
        Merci <strong>{{ session('rdv_nom') }}</strong>, votre demande a bien été enregistrée.<br>
        Nous vous confirmerons le rendez-vous très prochainement.
    </p>

    <div class="recap">
        <div class="recap-row">
            <span class="recap-label">Date</span>
            <span class="recap-value">{{ session('rdv_date') }}</span>
        </div>
        <div class="recap-row">
            <span class="recap-label">Heure</span>
            <span class="recap-value" style="color:var(--gold);">{{ session('rdv_heure') }}</span>
        </div>
        <div class="recap-row">
            <span class="recap-label">Coiffeur</span>
            <span class="recap-value">{{ session('rdv_coiffeur') }}</span>
        </div>
        <div class="recap-row">
            <span class="recap-label">Statut</span>
            <span class="recap-value" style="color:#fbbf24;">En attente de confirmation</span>
        </div>
    </div>

    <a href="{{ url('/') }}" class="btn-home">← Retour à l'accueil</a>
</div>
</body>
</html>
