<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'ARTISTO — Barbershop Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold:       #D4AF37;
            --gold-light: #FFD700;
            --gold-dark:  #B8860B;
            --bg:         #07070d;
            --text:       #e8e0d0;
            --text-muted: #8a8070;
        }
        * { margin:0; padding:0; box-sizing:border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ── NAV ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(7,7,13,0.7);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(212,175,55,0.1);
        }
        nav::before {
            content:''; display:block; height:2px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-dark));
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 16px 32px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 12px;
        }
        .nav-logo-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 0 16px rgba(212,175,55,0.3);
        }
        .nav-brand {
            font-family: 'Playfair Display', serif;
            font-size: 22px; font-weight: 700; letter-spacing: 2px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .nav-links { display: flex; align-items: center; gap: 10px; }
        .nav-link {
            padding: 8px 18px; border-radius: 8px;
            font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
        }
        .nav-link-ghost {
            color: var(--text-muted); border: 1px solid rgba(255,255,255,0.08);
            background: transparent;
        }
        .nav-link-ghost:hover { color: var(--text); border-color: rgba(255,255,255,0.2); }
        .nav-link-gold {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: #0a0a0a; font-weight: 700;
        }
        .nav-link-gold:hover { box-shadow: 0 6px 20px rgba(212,175,55,0.35); transform: translateY(-1px); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 80px 32px;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 30% 20%, rgba(212,175,55,0.08) 0%, transparent 55%),
                radial-gradient(ellipse at 70% 80%, rgba(180,120,10,0.05) 0%, transparent 55%),
                radial-gradient(ellipse at 50% 50%, rgba(212,175,55,0.03) 0%, transparent 70%);
        }
        /* Lignes décoratives */
        .hero-lines {
            position: absolute; inset: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(212,175,55,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212,175,55,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 20%, transparent 80%);
        }
        .hero-content {
            position: relative; z-index: 2;
            text-align: center; max-width: 760px;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 16px; border-radius: 20px; margin-bottom: 28px;
            background: rgba(212,175,55,0.08);
            border: 1px solid rgba(212,175,55,0.2);
            font-size: 12px; font-weight: 600; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--gold);
        }
        .hero-eyebrow::before { content:'✦'; font-size:10px; }
        .hero-eyebrow::after  { content:'✦'; font-size:10px; }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(52px, 8vw, 90px);
            font-weight: 700;
            line-height: 1.05;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #fff 0%, var(--gold-light) 50%, var(--gold) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-title em {
            font-style: italic;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-sub {
            font-size: 16px; font-weight: 300;
            color: var(--text-muted); letter-spacing: 4px;
            text-transform: uppercase; margin-bottom: 24px;
        }
        .hero-desc {
            font-size: 17px; line-height: 1.8;
            color: rgba(232,224,208,0.6);
            max-width: 520px; margin: 0 auto 44px;
        }
        .hero-cta {
            display: flex; justify-content: center; gap: 14px;
            flex-wrap: wrap;
        }
        .cta-primary {
            padding: 16px 48px; border-radius: 50px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: #0a0a0a;
            font-family: 'Inter', sans-serif;
            font-size: 14px; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            text-decoration: none; border: none; cursor: pointer;
            transition: all 0.35s;
            box-shadow: 0 8px 32px rgba(212,175,55,0.3);
        }
        .cta-primary:hover { transform: translateY(-4px) scale(1.03); box-shadow: 0 16px 48px rgba(212,175,55,0.45); }
        .cta-secondary {
            padding: 16px 36px; border-radius: 50px;
            background: transparent;
            border: 1px solid rgba(212,175,55,0.3);
            color: var(--gold);
            font-family: 'Inter', sans-serif;
            font-size: 14px; font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .cta-secondary:hover { background: rgba(212,175,55,0.08); border-color: var(--gold); }

        /* Scroll indicator */
        .scroll-hint {
            position: absolute; bottom: 36px; left: 50%;
            transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            color: var(--text-muted); font-size: 11px; letter-spacing: 2px;
            text-transform: uppercase; animation: bounce 2s infinite;
        }
        .scroll-line {
            width: 1px; height: 36px;
            background: linear-gradient(var(--gold), transparent);
        }
        @keyframes bounce { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(8px)} }

        /* ── FEATURES ── */
        .features {
            padding: 100px 32px;
            max-width: 1200px; margin: 0 auto;
        }
        .section-label {
            text-align: center; margin-bottom: 60px;
        }
        .section-label h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 5vw, 52px);
            font-weight: 700;
            color: var(--text); margin-bottom: 14px;
        }
        .section-label p { color: var(--text-muted); font-size: 15px; }
        .gold-line {
            width: 60px; height: 2px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light));
            margin: 16px auto;
            border-radius: 2px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(212,175,55,0.1);
            border-radius: 20px;
            padding: 32px 28px;
            transition: all 0.35s;
            position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0; transition: opacity 0.35s;
        }
        .feature-card:hover { border-color: rgba(212,175,55,0.25); transform: translateY(-6px); box-shadow: 0 24px 60px rgba(0,0,0,0.3); }
        .feature-card:hover::before { opacity: 1; }
        .feature-icon {
            width: 56px; height: 56px; border-radius: 14px;
            background: rgba(212,175,55,0.08);
            border: 1px solid rgba(212,175,55,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 20px;
        }
        .feature-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px; font-weight: 600;
            color: var(--text); margin-bottom: 10px;
        }
        .feature-desc { color: var(--text-muted); font-size: 14px; line-height: 1.8; }

        /* ── SERVICES PREVIEW ── */
        .services-section {
            background: rgba(212,175,55,0.03);
            border-top: 1px solid rgba(212,175,55,0.08);
            border-bottom: 1px solid rgba(212,175,55,0.08);
            padding: 100px 32px;
        }
        .services-inner { max-width: 1200px; margin: 0 auto; }
        .services-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-top: 48px;
        }
        .service-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 24px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(212,175,55,0.1);
            border-radius: 14px;
            transition: all 0.25s;
        }
        .service-item:hover { border-color: rgba(212,175,55,0.25); background: rgba(212,175,55,0.04); }
        .service-item-name { font-size: 15px; font-weight: 600; color: var(--text); }
        .service-item-dur  { font-size: 12px; color: var(--text-muted); margin-top: 3px; }
        .service-item-price { font-size: 20px; font-weight: 700; color: var(--gold); }

        /* ── FOOTER ── */
        footer {
            padding: 48px 32px;
            text-align: center;
            border-top: 1px solid rgba(212,175,55,0.08);
        }
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 28px; font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            letter-spacing: 2px; margin-bottom: 10px;
        }
        .footer-copy { font-size: 12px; color: var(--text-muted); }

        /* Animations */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(24px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .hero-eyebrow { animation: fadeUp 0.6s ease-out 0.1s both; }
        .hero-title   { animation: fadeUp 0.6s ease-out 0.2s both; }
        .hero-sub     { animation: fadeUp 0.6s ease-out 0.3s both; }
        .hero-desc    { animation: fadeUp 0.6s ease-out 0.4s both; }
        .hero-cta     { animation: fadeUp 0.6s ease-out 0.5s both; }

        @media (max-width: 768px) {
            .features-grid { grid-template-columns: 1fr; }
            .services-list  { grid-template-columns: 1fr; }
            .hero-title { font-size: 52px; }
            .nav-link-ghost { display:none; }
        }
    </style>
</head>
<body>

<!-- ── NAV ── -->
<nav>
    <div class="nav-inner">
        <div class="nav-logo">
            <div class="nav-logo-icon">👑</div>
            <span class="nav-brand">L'ARTISTO</span>
        </div>
        <div class="nav-links">
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link nav-link-ghost">Mon espace</a>
                @else
                    <a href="{{ route('login') }}"    class="nav-link nav-link-ghost">Se connecter</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link nav-link-gold">Réserver →</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

<!-- ── HERO ── -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-lines"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">Barbershop Premium à Tunis</div>
        <h1 class="hero-title">L'Art du<br><em>Coiffeur</em></h1>
        <p class="hero-sub">Depuis 2020 — Excellence & Prestige</p>
        <p class="hero-desc">
            Une expérience de coiffure haut de gamme, alliant savoir-faire traditionnel
            et techniques modernes. Chaque visite est une cérémonie.
        </p>
        <div class="hero-cta">
            @auth
                <a href="{{ url('/dashboard') }}" class="cta-primary">Prendre rendez-vous</a>
            @else
                <a href="{{ route('register') }}" class="cta-primary">Réserver maintenant</a>
                <a href="{{ route('login') }}"    class="cta-secondary">J'ai un compte</a>
            @endauth
        </div>
    </div>
    <div class="scroll-hint">
        <div class="scroll-line"></div>
        <span>Découvrir</span>
    </div>
</section>

<!-- ── FEATURES ── -->
<section class="features">
    <div class="section-label">
        <h2>Une expérience unique</h2>
        <div class="gold-line"></div>
        <p>Trois piliers qui font notre réputation</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">✂️</div>
            <div class="feature-title">Expertise</div>
            <div class="feature-desc">
                Nos coiffeurs maîtrisent les techniques classiques et modernes.
                Chaque coupe est pensée pour sublimer votre personnalité.
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📅</div>
            <div class="feature-title">Réservation facile</div>
            <div class="feature-desc">
                Prenez rendez-vous en ligne en quelques secondes. Choisissez
                votre coiffeur, votre service et votre créneau préféré.
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👑</div>
            <div class="feature-title">Expérience Premium</div>
            <div class="feature-desc">
                Un cadre raffiné, des produits de qualité professionnelle,
                et une attention portée à chaque détail de votre passage.
            </div>
        </div>
    </div>
</section>

<!-- ── SERVICES ── -->
<section class="services-section">
    <div class="services-inner">
        <div class="section-label">
            <h2>Nos Prestations</h2>
            <div class="gold-line"></div>
            <p>Des services taillés pour l'excellence</p>
        </div>
        <div class="services-list">
            <div class="service-item">
                <div>
                    <div class="service-item-name">Coupe Homme</div>
                    <div class="service-item-dur">30 minutes</div>
                </div>
                <div class="service-item-price">15 DT</div>
            </div>
            <div class="service-item">
                <div>
                    <div class="service-item-name">Dégradé Américain</div>
                    <div class="service-item-dur">40 minutes</div>
                </div>
                <div class="service-item-price">20 DT</div>
            </div>
            <div class="service-item">
                <div>
                    <div class="service-item-name">Barbe & Rasage</div>
                    <div class="service-item-dur">25 minutes</div>
                </div>
                <div class="service-item-price">12 DT</div>
            </div>
            <div class="service-item">
                <div>
                    <div class="service-item-name">Coupe + Barbe</div>
                    <div class="service-item-dur">55 minutes</div>
                </div>
                <div class="service-item-price">25 DT</div>
            </div>
            <div class="service-item">
                <div>
                    <div class="service-item-name">Coloration Homme</div>
                    <div class="service-item-dur">60 minutes</div>
                </div>
                <div class="service-item-price">35 DT</div>
            </div>
            <div class="service-item">
                <div>
                    <div class="service-item-name">Soin Capillaire</div>
                    <div class="service-item-dur">45 minutes</div>
                </div>
                <div class="service-item-price">18 DT</div>
            </div>
        </div>
        <div style="text-align:center;margin-top:44px;">
            @auth
                <a href="{{ url('/dashboard') }}" class="cta-primary">Réserver une prestation</a>
            @else
                <a href="{{ route('register') }}" class="cta-primary">Créer un compte & réserver</a>
            @endauth
        </div>
    </div>
</section>

<!-- ── FOOTER ── -->
<footer>
    <div class="footer-brand">L'ARTISTO</div>
    <p class="footer-copy">© {{ date('Y') }} L'ARTISTO Barbershop — Tous droits réservés</p>
</footer>

</body>
</html>
