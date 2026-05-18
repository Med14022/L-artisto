<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - L'ARTISTO Barbershop</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold:        #D4AF37;
            --gold-light:  #FFD700;
            --gold-dark:   #B8860B;
            --bg:          #09090f;
            --bg-card:     rgba(255,255,255,0.04);
            --bg-card2:    rgba(255,255,255,0.07);
            --border:      rgba(212,175,55,0.18);
            --text:        #e8e0d0;
            --text-muted:  #8a8070;
            --radius:      16px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(212,175,55,0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(212,175,55,0.04) 0%, transparent 50%);
            min-height: 100vh;
            color: var(--text);
        }

        /* ── HEADER ────────────────────────────────── */
        .header {
            background: rgba(9,9,15,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-dark));
        }
        .header-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-section { display: flex; align-items: center; gap: 14px; }
        .logo {
            width: 46px; height: 46px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 20px rgba(212,175,55,0.35);
            font-size: 22px;
        }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
        }
        .user-info { display: flex; align-items: center; gap: 18px; }
        .welcome-text { color: var(--text-muted); font-size: 14px; font-weight: 400; }
        .welcome-text strong { color: var(--gold); font-weight: 600; }
        .logout-btn {
            padding: 8px 20px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s;
        }
        .logout-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(212,175,55,0.08);
        }

        /* ── LAYOUT ─────────────────────────────────── */
        .container { max-width: 1280px; margin: 0 auto; padding: 36px 28px; }

        /* ── SECTION TITLE ──────────────────────────── */
        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-heading::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border), transparent);
        }
        .gold-dot {
            width: 6px; height: 6px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--gold);
        }

        /* ── SERVICE CARDS ──────────────────────────── */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .service-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 20px;
            text-align: center;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(212,175,55,0.06), transparent);
            opacity: 0;
            transition: opacity 0.35s;
        }
        .service-card:hover {
            border-color: var(--gold);
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(212,175,55,0.12);
        }
        .service-card:hover::before { opacity: 1; }
        .service-icon {
            width: 80px; height: 80px;
            margin: 0 auto 16px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            background: rgba(212,175,55,0.08);
            font-size: 32px;
        }
        .service-icon img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .service-name {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
        }
        .service-price {
            font-size: 22px;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .service-price::after { content: ' DT'; font-size: 13px; font-weight: 500; opacity: 0.7; }
        .service-description {
            color: var(--text-muted);
            font-size: 12px;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: #0a0a0a;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(212,175,55,0.4);
        }
        .btn-book { width: 100%; margin-top: 4px; }

        /* ── DASHBOARD GRID ─────────────────────────── */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
        }
        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        /* ── BARBER ITEMS ───────────────────────────── */
        .barber-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: background 0.2s;
            border: 1px solid transparent;
        }
        .barber-item:hover {
            background: var(--bg-card2);
            border-color: var(--border);
        }
        .barber-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 0 14px rgba(212,175,55,0.25);
        }
        .barber-name { font-weight: 600; font-size: 14px; color: var(--text); }
        .barber-specialty { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ── APPOINTMENT ITEMS ──────────────────────── */
        .appointment-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            background: var(--bg-card2);
            border: 1px solid var(--border);
            transition: all 0.2s;
        }
        .appointment-item:hover { border-color: var(--gold); }
        .appointment-date { font-size: 11px; color: var(--text-muted); margin-bottom: 4px; }
        .appointment-service { font-size: 14px; font-weight: 600; color: var(--text); }
        .appointment-details { flex: 1; }
        .appointment-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }
        .status-confirmed  { background: rgba(34,197,94,0.12);  color: #4ade80; border: 1px solid rgba(34,197,94,0.25); }
        .status-pending    { background: rgba(251,191,36,0.12); color: var(--gold); border: 1px solid rgba(212,175,55,0.3); }
        .status-completed  { background: rgba(99,102,241,0.12); color: #818cf8; border: 1px solid rgba(99,102,241,0.25); }
        .empty-state { color: var(--text-muted); text-align: center; padding: 24px; font-size: 13px; }

        /* ── CTA ────────────────────────────────────── */
        .main-cta {
            text-align: center;
            margin: 44px 0 20px;
        }
        .cta-btn {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: #0a0a0a;
            border: none;
            padding: 18px 52px;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: all 0.35s;
            box-shadow: 0 8px 32px rgba(212,175,55,0.3);
        }
        .cta-btn:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 16px 48px rgba(212,175,55,0.45);
        }

        /* ── BOOKING OVERLAY ────────────────────────── */
        .booking-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(12px);
            z-index: 1000;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            overflow-y: auto;
        }
        .booking-popup {
            background: #111118;
            border: 1px solid rgba(212,175,55,0.25);
            border-radius: 24px;
            width: 100%;
            max-width: 760px;
            margin: auto;
            box-shadow: 0 40px 100px rgba(0,0,0,0.6), 0 0 0 1px rgba(212,175,55,0.1);
            animation: popupIn 0.45s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }
        @keyframes popupIn {
            from { opacity: 0; transform: translateY(50px) scale(0.94); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }
        .booking-header {
            background: linear-gradient(135deg, #1a1400, #2a1f00, #1a1400);
            border-bottom: 1px solid rgba(212,175,55,0.2);
            padding: 28px 32px;
            position: relative;
        }
        .booking-close {
            position: absolute;
            top: 20px; right: 24px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-muted);
            width: 38px; height: 38px;
            border-radius: 50%;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            transition: all 0.25s;
        }
        .booking-close:hover { background: rgba(255,255,255,0.12); color: var(--text); transform: rotate(90deg); }
        .booking-title {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--gold-light);
            margin-bottom: 6px;
        }
        .booking-subtitle { color: var(--text-muted); font-size: 14px; margin-bottom: 26px; }

        /* ── PROGRESS ───────────────────────────────── */
        .progress-wrapper { position: relative; }
        .progress-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 12px;
        }
        .progress-line {
            position: absolute;
            top: 50%; left: 0; right: 0;
            height: 3px;
            background: rgba(255,255,255,0.08);
            border-radius: 2px;
            transform: translateY(-50%);
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light));
            border-radius: 2px;
            transition: width 0.7s cubic-bezier(0.4,0,0.2,1);
            width: 0%;
            box-shadow: 0 0 8px rgba(212,175,55,0.6);
        }
        .progress-step {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            font-weight: 600;
            position: relative; z-index: 2;
            transition: all 0.4s;
            font-size: 14px;
        }
        .progress-step.active {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            border-color: transparent;
            color: #0a0a0a;
            box-shadow: 0 0 20px rgba(212,175,55,0.5);
            transform: scale(1.15);
        }
        .progress-step.completed {
            background: rgba(212,175,55,0.15);
            border-color: var(--gold);
            color: var(--gold);
        }
        .step-labels {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── BOOKING CONTENT ─────────────────────────── */
        .booking-content {
            padding: 32px;
            min-height: 460px;
            display: flex;
            flex-direction: column;
        }
        .step-content { display: none; animation: stepIn 0.4s ease-out; flex: 1; }
        .step-content.active { display: flex; flex-direction: column; }
        @keyframes stepIn {
            from { opacity: 0; transform: translateX(24px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .step-title {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 600;
            color: var(--text);
            text-align: center;
            margin-bottom: 28px;
        }

        /* ── SELECTION GRIDS ────────────────────────── */
        .service-selection, .stylist-selection {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }
        .service-option, .stylist-option {
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 22px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255,255,255,0.03);
            color: var(--text);
        }
        .service-option:hover, .stylist-option:hover {
            border-color: rgba(212,175,55,0.5);
            background: rgba(212,175,55,0.06);
            transform: translateY(-4px);
        }
        .service-option.selected, .stylist-option.selected {
            border-color: var(--gold);
            background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(255,215,0,0.08));
            box-shadow: 0 0 20px rgba(212,175,55,0.15), inset 0 0 0 1px rgba(212,175,55,0.3);
        }
        .stylist-avatar {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2a1f00, #3d2e00);
            border: 2px solid rgba(212,175,55,0.25);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            font-size: 28px;
        }
        .stylist-option.selected .stylist-avatar {
            border-color: var(--gold);
            box-shadow: 0 0 14px rgba(212,175,55,0.35);
        }

        /* ── DATE / TIME ────────────────────────────── */
        .date-selection {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin: 16px 0;
        }
        .date-option {
            aspect-ratio: 1;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.25s;
            background: rgba(255,255,255,0.03);
            font-size: 12px;
            color: var(--text);
        }
        .date-option:hover:not(.disabled) {
            border-color: var(--gold);
            background: rgba(212,175,55,0.08);
        }
        .date-option.selected {
            border-color: var(--gold);
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: #0a0a0a;
            box-shadow: 0 4px 16px rgba(212,175,55,0.35);
        }
        .date-option.disabled { opacity: 0.25; cursor: not-allowed; }

        .time-selection {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin: 16px 0;
        }
        .time-option {
            padding: 14px 10px;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s;
            background: rgba(255,255,255,0.03);
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }
        .time-option:hover:not(.disabled) {
            border-color: var(--gold);
            background: rgba(212,175,55,0.08);
            color: var(--gold);
        }
        .time-option.selected {
            border-color: var(--gold);
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: #0a0a0a;
        }
        .time-option.disabled { opacity: 0.25; cursor: not-allowed; }

        /* ── SUMMARY ────────────────────────────────── */
        .summary-card {
            background: linear-gradient(135deg, rgba(212,175,55,0.1), rgba(255,215,0,0.05));
            border: 1px solid rgba(212,175,55,0.25);
            border-radius: 16px;
            padding: 24px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .summary-item:last-child { border-bottom: none; }
        .summary-label { font-size: 13px; color: var(--text-muted); font-weight: 500; }
        .summary-value { font-size: 15px; font-weight: 700; color: var(--text); }

        /* ── BUTTONS ────────────────────────────────── */
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 28px;
            gap: 16px;
        }
        .btn {
            padding: 13px 28px;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s;
            font-size: 14px;
            flex: 1;
            max-width: 200px;
            letter-spacing: 0.3px;
        }
        .btn-secondary {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-muted);
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); color: var(--text); }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: #0a0a0a;
            font-weight: 700;
        }
        .btn-gold:hover { box-shadow: 0 8px 24px rgba(212,175,55,0.4); transform: translateY(-2px); }
        .btn-success {
            background: linear-gradient(135deg, #166534, #22c55e);
            color: #fff;
            font-weight: 700;
        }
        .btn-success:hover { box-shadow: 0 8px 24px rgba(34,197,94,0.3); transform: translateY(-2px); }
        .btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

        /* ── LOADING ────────────────────────────────── */
        .loading-state { display: none; text-align: center; padding: 48px 20px; }
        .spinner {
            border: 3px solid rgba(255,255,255,0.06);
            border-top: 3px solid var(--gold);
            border-radius: 50%;
            width: 48px; height: 48px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── RESPONSIVE ─────────────────────────────── */
        @media (max-width: 768px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .header-content { flex-direction: column; gap: 12px; }
            .date-selection { grid-template-columns: repeat(4, 1fr); }
            .booking-popup { border-radius: 16px; }
            .booking-content { padding: 20px; }
            .service-selection, .stylist-selection { grid-template-columns: 1fr 1fr; }
            .brand-name { font-size: 20px; }
            .nav-buttons { flex-direction: column; }
            .btn { max-width: none; }
        }

        /* ── ANIMATIONS ─────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .service-card { animation: fadeUp 0.5s ease-out both; }
        .service-card:nth-child(1) { animation-delay: 0.05s; }
        .service-card:nth-child(2) { animation-delay: 0.1s; }
        .service-card:nth-child(3) { animation-delay: 0.15s; }
        .service-card:nth-child(4) { animation-delay: 0.2s; }
        .service-card:nth-child(5) { animation-delay: 0.25s; }
        .service-card:nth-child(6) { animation-delay: 0.3s; }
        .card { animation: fadeUp 0.5s ease-out 0.2s both; }
    </style>
</head>

<body>
    <!-- ── HEADER ── -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">👑</div>
                <h1 class="brand-name">L'ARTISTO</h1>
            </div>
            <div class="user-info">
                <span class="welcome-text">Bonjour, <strong>{{ Auth::user()->name }}</strong></span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">

        <!-- ── SERVICES ── -->
        <div class="section-heading">
            <span class="gold-dot"></span>
            Nos Services &amp; Tarifs
        </div>

        <div class="services-grid">
            @foreach ($services as $service)
            <div class="service-card">
                <div class="service-icon">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                    @else
                        ✂️
                    @endif
                </div>
                <div class="service-name">{{ $service->name }}</div>
                <div class="service-price">{{ $service->price }}</div>
                <div class="service-description">{{ $service->description }}</div>
                <button class="btn-primary btn-book"
                    onclick="openBooking('{{ $service->id }}', '{{ $service->name }}', '{{ $service->price }}')">
                    Réserver
                </button>
            </div>
            @endforeach
        </div>

        <!-- ── GRILLE ── -->
        <div class="dashboard-grid">
            <!-- Coiffeurs -->
            <div class="card">
                <h2 class="card-title">✂️ Nos Coiffeurs</h2>
                @forelse ($users as $user)
                    <div class="barber-item">
                        <div class="barber-avatar">👨</div>
                        <div class="barber-info">
                            <div class="barber-name">{{ $user->name }}</div>
                            <div class="barber-specialty">{{ $user->address }}</div>
                        </div>
                    </div>
                @empty
                    <p class="empty-state">Aucun coiffeur disponible.</p>
                @endforelse
            </div>

            <!-- RDV en cours -->
            <div class="card">
                <h2 class="card-title">📅 Rendez-vous en Cours</h2>
                @forelse ($rdvs->filter(fn($r) => in_array($r->etat, ['en attente','confirmé'])) as $rdv)
                    <div class="appointment-item">
                        <div class="appointment-details">
                            <div class="appointment-date">
                                {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}
                                à {{ substr($rdv->heure, 0, 5) }}
                            </div>
                            <div class="appointment-service">
                                @foreach ($rdv->services as $service)
                                    {{ $service->name }}@if (!$loop->last), @endif
                                @endforeach
                            </div>
                        </div>
                        <span class="appointment-status {{ $rdv->etat == 'confirmé' ? 'status-confirmed' : 'status-pending' }}">
                            {{ $rdv->etat }}
                        </span>
                    </div>
                @empty
                    <p class="empty-state">Aucun rendez-vous en cours.</p>
                @endforelse
            </div>
        </div>

        <!-- ── HISTORIQUE ── -->
        <div class="card" style="margin-bottom:24px;">
            <h2 class="card-title">📋 Historique des Rendez-vous</h2>
            @forelse ($rdvs->filter(fn($r) => $r->etat === 'terminé') as $rdv)
                <div class="appointment-item">
                    <div class="appointment-details">
                        <div class="appointment-date">
                            {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}
                            à {{ substr($rdv->heure, 0, 5) }}
                        </div>
                        <div class="appointment-service">
                            @foreach ($rdv->services as $service)
                                {{ $service->name }}@if (!$loop->last), @endif
                            @endforeach
                        </div>
                    </div>
                    <span class="appointment-status status-completed">Terminé</span>
                </div>
            @empty
                <p class="empty-state">Aucun historique disponible.</p>
            @endforelse
        </div>

        <!-- ── CTA ── -->
        <div class="main-cta">
            <button class="cta-btn" onclick="openBooking()">
                Prendre un Rendez-vous
            </button>
        </div>
    </div>

    <!-- ── POPUP RÉSERVATION ── -->
    <div id="bookingOverlay" class="booking-overlay">
        <div class="booking-popup">
            <div class="booking-header">
                <button class="booking-close" onclick="closeBooking()">&times;</button>
                <div class="booking-title">Réserver un Rendez-vous</div>
                <div class="booking-subtitle">Suivez ces étapes pour choisir votre créneau</div>
                <div class="progress-wrapper">
                    <div class="progress-bar">
                        <div class="progress-line">
                            <div id="progressFill" class="progress-fill"></div>
                        </div>
                        <div id="step1" class="progress-step active">1</div>
                        <div id="step2" class="progress-step">2</div>
                        <div id="step3" class="progress-step">3</div>
                        <div id="step4" class="progress-step">4</div>
                        <div id="step5" class="progress-step">5</div>
                    </div>
                    <div class="step-labels">
                        <span>Service</span>
                        <span>Coiffeur</span>
                        <span>Date</span>
                        <span>Heure</span>
                        <span>Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="booking-content">
                <!-- Étape 1 -->
                <div id="stepContent1" class="step-content active">
                    <div class="step-title">Choisissez votre service</div>
                    <div class="service-selection">
                        @foreach ($services as $service)
                        <div class="service-option"
                            data-service="{{ $service->id }}"
                            data-name="{{ $service->name }}"
                            data-price="{{ $service->price }}">
                            <div style="font-size:40px;margin-bottom:12px;">✂️</div>
                            <div style="font-size:15px;font-weight:700;margin-bottom:6px;color:var(--text);">{{ $service->name }}</div>
                            <div style="font-size:20px;color:var(--gold);font-weight:700;">{{ $service->price }} DT</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Étape 2 -->
                <div id="stepContent2" class="step-content">
                    <div class="step-title">Choisissez votre coiffeur</div>
                    <div id="loadingStylist" class="loading-state">
                        <div class="spinner"></div>
                        <p style="color:var(--text-muted);">Chargement...</p>
                    </div>
                    <div id="stylistSelection" class="stylist-selection" style="display:none;">
                        @foreach ($users as $user)
                            <div class="stylist-option" data-stylist="{{ $user->id }}" data-name="{{ $user->name }}">
                                <div class="stylist-avatar">👨</div>
                                <div style="font-size:15px;font-weight:700;margin-bottom:6px;color:var(--text);">{{ $user->name }}</div>
                                <div style="color:var(--text-muted);font-size:12px;">{{ $user->address }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Étape 3 -->
                <div id="stepContent3" class="step-content">
                    <div class="step-title">Choisissez votre date</div>
                    <div id="loadingDate" class="loading-state">
                        <div class="spinner"></div>
                        <p style="color:var(--text-muted);">Chargement...</p>
                    </div>
                    <div id="dateSelection" class="date-selection" style="display:none;"></div>
                </div>

                <!-- Étape 4 -->
                <div id="stepContent4" class="step-content">
                    <div class="step-title">Choisissez votre heure</div>
                    <div id="loadingTime" class="loading-state">
                        <div class="spinner"></div>
                        <p style="color:var(--text-muted);">Chargement...</p>
                    </div>
                    <div id="timeSelection" class="time-selection" style="display:none;"></div>
                </div>

                <!-- Étape 5 -->
                <div id="stepContent5" class="step-content">
                    <div class="step-title">Confirmez votre réservation</div>
                    <div class="summary-card">
                        <div class="summary-item">
                            <span class="summary-label">Service</span>
                            <span id="summaryService" class="summary-value">—</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Coiffeur</span>
                            <span id="summaryStylist" class="summary-value">—</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Date</span>
                            <span id="summaryDate" class="summary-value">—</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Heure</span>
                            <span id="summaryTime" class="summary-value">—</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Prix</span>
                            <span id="summaryPrice" class="summary-value" style="color:var(--gold);font-size:18px;">—</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="nav-buttons">
                    <button id="prevBtn" class="btn btn-secondary" onclick="changeStep(-1)" style="display:none;">
                        ← Précédent
                    </button>
                    <button id="nextBtn" class="btn btn-gold" onclick="changeStep(1)" disabled>
                        Suivant →
                    </button>
                    <button id="confirmBtn" class="btn btn-success" onclick="confirmBooking()" style="display:none;">
                        ✓ Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let bookingData = { service: null, stylist: null, date: null, time: null };

        function openBooking(serviceId = null, serviceName = null, servicePrice = null) {
            document.getElementById('bookingOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            if (serviceId && serviceName && servicePrice) {
                selectService(serviceId, serviceName, servicePrice);
            }
            updateProgress();
        }

        function closeBooking() {
            document.getElementById('bookingOverlay').style.display = 'none';
            document.body.style.overflow = 'auto';
            resetBooking();
        }

        function resetBooking() {
            currentStep = 1;
            bookingData = { service: null, stylist: null, date: null, time: null };
            document.querySelectorAll('.service-option, .stylist-option, .date-option, .time-option').forEach(el => el.classList.remove('selected'));
            updateProgress(); updateStepContent(); updateNavigationButtons();
        }

        function changeStep(direction) {
            const newStep = currentStep + direction;
            if (newStep >= 1 && newStep <= 5) {
                if (direction > 0 && !validateCurrentStep()) return;
                currentStep = newStep;
                updateProgress(); updateStepContent(); updateNavigationButtons();
                if (currentStep === 2) loadStylists();
                if (currentStep === 3) loadDates();
                if (currentStep === 4) loadTimes();
                if (currentStep === 5) updateSummary();
            }
        }

        function validateCurrentStep() {
            switch (currentStep) {
                case 1: return bookingData.service !== null;
                case 2: return bookingData.stylist !== null;
                case 3: return bookingData.date !== null;
                case 4: return bookingData.time !== null;
                default: return true;
            }
        }

        function updateProgress() {
            document.getElementById('progressFill').style.width = ((currentStep - 1) * 25) + '%';
            for (let i = 1; i <= 5; i++) {
                const el = document.getElementById(`step${i}`);
                el.classList.remove('active', 'completed');
                if (i < currentStep) { el.classList.add('completed'); el.innerHTML = '✓'; }
                else if (i === currentStep) { el.classList.add('active'); el.innerHTML = i; }
                else { el.innerHTML = i; }
            }
        }

        function updateStepContent() {
            document.querySelectorAll('.step-content').forEach(c => c.classList.remove('active'));
            document.getElementById(`stepContent${currentStep}`).classList.add('active');
        }

        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const confirmBtn = document.getElementById('confirmBtn');
            prevBtn.style.display = currentStep > 1 ? 'block' : 'none';
            if (currentStep < 5) {
                nextBtn.style.display = 'block'; confirmBtn.style.display = 'none';
                nextBtn.disabled = !validateCurrentStep();
            } else {
                nextBtn.style.display = 'none'; confirmBtn.style.display = 'block';
            }
        }

        function selectService(serviceId, serviceName, servicePrice) {
            bookingData.service = { id: serviceId, name: serviceName, price: servicePrice };
            document.querySelectorAll('.service-option').forEach(o => o.classList.remove('selected'));
            const sel = document.querySelector(`[data-service="${serviceId}"]`);
            if (sel) sel.classList.add('selected');
            updateNavigationButtons();
        }

        function selectStylist(stylistId, stylistName) {
            bookingData.stylist = { id: stylistId, name: stylistName };
            document.querySelectorAll('.stylist-option').forEach(o => o.classList.remove('selected'));
            document.querySelector(`[data-stylist="${stylistId}"]`).classList.add('selected');
            updateNavigationButtons();
        }

        function selectDate(dateValue, dateDisplay) {
            bookingData.date = { value: dateValue, display: dateDisplay };
            document.querySelectorAll('.date-option').forEach(o => o.classList.remove('selected'));
            document.querySelector(`[data-date="${dateValue}"]`).classList.add('selected');
            updateNavigationButtons();
        }

        function selectTime(timeValue) {
            bookingData.time = timeValue;
            document.querySelectorAll('.time-option').forEach(o => o.classList.remove('selected'));
            document.querySelector(`[data-time="${timeValue}"]`).classList.add('selected');
            updateNavigationButtons();
        }

        function loadStylists() {
            const loading = document.getElementById('loadingStylist');
            const selection = document.getElementById('stylistSelection');
            loading.style.display = 'block'; selection.style.display = 'none';
            setTimeout(() => { loading.style.display = 'none'; selection.style.display = 'grid'; }, 600);
        }

        function loadDates() {
            const loading = document.getElementById('loadingDate');
            const selection = document.getElementById('dateSelection');
            loading.style.display = 'block'; selection.style.display = 'none';
            setTimeout(() => { generateDates(); loading.style.display = 'none'; selection.style.display = 'grid'; }, 600);
        }

        function generateDates() {
            const dateSelection = document.getElementById('dateSelection');
            dateSelection.innerHTML = '';
            const today = new Date();
            for (let i = 0; i < 14; i++) {
                const date = new Date(today);
                date.setDate(today.getDate() + i);
                const dayName = date.toLocaleDateString('fr-FR', { weekday: 'short' });
                const dayNumber = date.getDate();
                const monthName = date.toLocaleDateString('fr-FR', { month: 'short' });
                const isDisabled = date.getDay() === 2;
                const dateOption = document.createElement('div');
                dateOption.className = `date-option ${isDisabled ? 'disabled' : ''}`;
                dateOption.setAttribute('data-date', date.toISOString().split('T')[0]);
                if (!isDisabled) {
                    dateOption.onclick = () => selectDate(date.toISOString().split('T')[0], `${dayName} ${dayNumber} ${monthName}`);
                }
                dateOption.innerHTML = `<div style="font-size:10px;opacity:0.6;">${dayName}</div><div style="font-size:15px;font-weight:700;">${dayNumber}</div><div style="font-size:10px;opacity:0.5;">${monthName}</div>`;
                dateSelection.appendChild(dateOption);
            }
        }

        function loadTimes() {
            const loading = document.getElementById('loadingTime');
            const selection = document.getElementById('timeSelection');
            loading.style.display = 'block'; selection.style.display = 'none';
            const coiffeurId = bookingData.stylist ? bookingData.stylist.id : null;
            const date = bookingData.date ? bookingData.date.value : null;
            if (!coiffeurId || !date) {
                generateTimes([]); loading.style.display = 'none'; selection.style.display = 'grid'; return;
            }
            fetch(`/rendez-vous/available-times?coiffeur_id=${coiffeurId}&date=${date}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(booked => { generateTimes(booked); loading.style.display = 'none'; selection.style.display = 'grid'; })
            .catch(() => { generateTimes([]); loading.style.display = 'none'; selection.style.display = 'grid'; });
        }

        function generateTimes(bookedTimes) {
            const timeSelection = document.getElementById('timeSelection');
            timeSelection.innerHTML = '';
            const times = ['09:00','09:30','10:00','10:30','11:00','11:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30'];
            times.forEach(time => {
                const isDisabled = bookedTimes.includes(time);
                const el = document.createElement('div');
                el.className = `time-option ${isDisabled ? 'disabled' : ''}`;
                el.setAttribute('data-time', time);
                el.textContent = isDisabled ? time + ' ✗' : time;
                if (!isDisabled) el.onclick = () => selectTime(time);
                timeSelection.appendChild(el);
            });
        }

        function updateSummary() {
            document.getElementById('summaryService').textContent = `${bookingData.service.name}`;
            document.getElementById('summaryStylist').textContent = bookingData.stylist.name;
            document.getElementById('summaryDate').textContent = bookingData.date.display;
            document.getElementById('summaryTime').textContent = bookingData.time;
            document.getElementById('summaryPrice').textContent = bookingData.service.price + ' DT';
        }

        function confirmBooking() {
            const confirmBtn = document.getElementById('confirmBtn');
            const orig = confirmBtn.innerHTML;
            confirmBtn.innerHTML = '<span style="display:inline-block;width:18px;height:18px;border:2px solid rgba(255,255,255,0.3);border-top:2px solid #fff;border-radius:50%;animation:spin 1s linear infinite;"></span>';
            confirmBtn.disabled = true;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/rendez-vous', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ service_id: bookingData.service.id, id_coiffeur: bookingData.stylist.id, date: bookingData.date.value, heure: bookingData.time }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeBooking(); showNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 1800);
                } else {
                    showNotification('Une erreur est survenue.', 'error');
                    confirmBtn.innerHTML = orig; confirmBtn.disabled = false;
                }
            })
            .catch(() => { showNotification('Erreur réseau. Veuillez réessayer.', 'error'); confirmBtn.innerHTML = orig; confirmBtn.disabled = false; });
        }

        function showNotification(message, type) {
            const n = document.createElement('div');
            const isOk = type === 'success';
            n.style.cssText = `position:fixed;top:24px;right:24px;z-index:9999;padding:16px 24px;border-radius:12px;font-weight:600;font-size:14px;font-family:'Inter',sans-serif;box-shadow:0 12px 40px rgba(0,0,0,0.4);border:1px solid ${isOk ? 'rgba(34,197,94,0.3)' : 'rgba(239,68,68,0.3)'};background:${isOk ? 'rgba(20,40,20,0.95)' : 'rgba(40,10,10,0.95)'};color:${isOk ? '#4ade80' : '#f87171'};backdrop-filter:blur(10px);`;
            n.textContent = (isOk ? '✓ ' : '✗ ') + message;
            document.body.appendChild(n);
            setTimeout(() => n.style.opacity = '0', 2700);
            setTimeout(() => n.remove(), 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                if (e.target.closest('.service-option')) {
                    const o = e.target.closest('.service-option');
                    selectService(o.dataset.service, o.dataset.name, o.dataset.price);
                }
                if (e.target.closest('.stylist-option')) {
                    const o = e.target.closest('.stylist-option');
                    selectStylist(o.dataset.stylist, o.dataset.name);
                }
            });
            document.getElementById('bookingOverlay').addEventListener('click', function(e) {
                if (e.target === this) closeBooking();
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && document.getElementById('bookingOverlay').style.display === 'flex') closeBooking();
            });
            updateNavigationButtons();
        });
    </script>
</body>
</html>
