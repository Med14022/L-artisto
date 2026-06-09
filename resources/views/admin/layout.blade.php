<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — L'ARTISTO</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold:         #D4AF37;
            --gold-light:   #FFD700;
            --gold-dark:    #B8860B;
            --sidebar-bg:   #07070d;
            --sidebar-w:    240px;
            --sidebar-mini: 64px;
            --bg:           #0c0c14;
            --bg-card:      rgba(255,255,255,0.04);
            --border:       rgba(212,175,55,0.15);
            --text:         #e2ddd5;
            --text-muted:   #7a7060;
            --radius:       12px;
            --transition:   0.25s cubic-bezier(0.4,0,0.2,1);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); display:flex; min-height:100vh; }

        /* ════════════════════════════════════════
           SIDEBAR
        ════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            transition: transform var(--transition), width var(--transition);
            overflow: hidden;
        }

        /* ── Mode réduit (desktop) ── */
        body.sidebar-collapsed .sidebar        { width: var(--sidebar-mini); }
        body.sidebar-collapsed .main           { margin-left: var(--sidebar-mini); }
        body.sidebar-collapsed .logo-text,
        body.sidebar-collapsed .nav-link-text,
        body.sidebar-collapsed .nav-label,
        body.sidebar-collapsed .sidebar-user-info,
        body.sidebar-collapsed .logout-btn-text { display: none; }
        body.sidebar-collapsed .nav-link       { justify-content: center; padding: 11px 0; }
        body.sidebar-collapsed .nav-icon       { width: auto; font-size: 20px; }
        body.sidebar-collapsed .sidebar-user   { justify-content: center; padding: 10px 0; }
        body.sidebar-collapsed .logout-btn     { justify-content: center; }
        body.sidebar-collapsed .sidebar-top    { justify-content: center; padding: 18px 0; }
        body.sidebar-collapsed .sidebar-logo   { display: none; }

        /* ── Tooltip desktop mode réduit ── */
        body.sidebar-collapsed .nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-mini) + 10px);
            top: 50%; transform: translateY(-50%);
            background: #1a1a2e; color: var(--text);
            font-size: 12px; font-weight: 600;
            padding: 6px 12px; border-radius: 8px;
            border: 1px solid var(--border);
            white-space: nowrap; opacity: 0;
            pointer-events: none; transition: opacity 0.15s; z-index: 300;
        }
        body.sidebar-collapsed .nav-link:hover::after { opacity: 1; }

        /* ── MOBILE : sidebar masquée par défaut ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w) !important;
                box-shadow: none;
            }
            body.mobile-open .sidebar {
                transform: translateX(0);
                box-shadow: 4px 0 32px rgba(0,0,0,0.6);
            }
            /* Reset collapsed sur mobile */
            body.sidebar-collapsed .sidebar        { width: var(--sidebar-w) !important; }
            body.sidebar-collapsed .logo-text,
            body.sidebar-collapsed .nav-link-text,
            body.sidebar-collapsed .nav-label,
            body.sidebar-collapsed .sidebar-user-info,
            body.sidebar-collapsed .logout-btn-text { display: unset; }
            body.sidebar-collapsed .nav-link  { justify-content: flex-start; padding: 10px 12px; }
            body.sidebar-collapsed .nav-icon  { width: 22px; font-size: 17px; }
            body.sidebar-collapsed .sidebar-user { justify-content: flex-start; padding: 10px 12px; }
            body.sidebar-collapsed .logout-btn { justify-content: flex-start; }
            body.sidebar-collapsed .sidebar-top { justify-content: space-between; padding: 20px 16px; }
            body.sidebar-collapsed .sidebar-logo { display: flex; }
            body.sidebar-collapsed .toggle-btn span:nth-child(1),
            body.sidebar-collapsed .toggle-btn span:nth-child(2),
            body.sidebar-collapsed .toggle-btn span:nth-child(3) { transform: none; opacity: 1; }
        }

        /* ── OVERLAY mobile ── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 190;
            backdrop-filter: blur(2px);
        }
        body.mobile-open .sidebar-overlay { display: block; }

        /* ── HEADER sidebar ── */
        .sidebar-top {
            padding: 20px 16px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; min-height: 70px; flex-shrink: 0;
        }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0; }
        .logo-icon {
            width: 36px; height: 36px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-size: 16px; box-shadow: 0 0 14px rgba(212,175,55,0.3);
        }
        .logo-text h2 {
            font-family: 'Playfair Display', serif; font-size: 15px; font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            letter-spacing: 1px; white-space: nowrap;
        }
        .logo-text p { font-size: 9px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 1px; }

        /* ── TOGGLE BTN ── */
        .toggle-btn {
            flex-shrink: 0; width: 34px; height: 34px;
            background: rgba(255,255,255,0.04); border: 1px solid var(--border);
            border-radius: 8px; cursor: pointer;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 4px; transition: all 0.2s; padding: 0;
        }
        .toggle-btn:hover { background: rgba(212,175,55,0.1); border-color: rgba(212,175,55,0.3); }
        .toggle-btn span {
            display: block; width: 14px; height: 2px;
            background: var(--text-muted); border-radius: 2px;
            transition: all var(--transition);
        }
        .toggle-btn:hover span { background: var(--gold); }
        /* Animation → X quand collapsed (desktop) */
        body.sidebar-collapsed .toggle-btn span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
        body.sidebar-collapsed .toggle-btn span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        body.sidebar-collapsed .toggle-btn span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

        /* ── NAV ── */
        .nav-section { padding: 16px 10px 0; flex: 1; overflow-y: auto; overflow-x: hidden; }
        .nav-label {
            font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px;
            color: var(--text-muted); padding: 0 10px; margin-bottom: 6px; white-space: nowrap;
        }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            color: var(--text-muted); text-decoration: none;
            font-size: 13px; font-weight: 500;
            transition: all 0.2s; margin-bottom: 2px;
            white-space: nowrap; position: relative;
        }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: var(--text); }
        .nav-link.active {
            background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(255,215,0,0.08));
            color: var(--gold); border: 1px solid rgba(212,175,55,0.2);
        }
        .nav-icon { font-size: 17px; width: 22px; text-align: center; flex-shrink: 0; }

        /* ── FOOTER sidebar ── */
        .sidebar-footer { padding: 12px 10px; border-top: 1px solid var(--border); flex-shrink: 0; }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            margin-bottom: 6px; background: rgba(255,255,255,0.03);
        }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display: flex; align-items: center; justify-content: center; font-size: 14px;
        }
        .sidebar-user-info .user-name { font-size: 12px; font-weight: 600; color: var(--text); }
        .sidebar-user-info .user-role  { font-size: 10px; color: var(--text-muted); }
        .logout-btn {
            width: 100%; padding: 9px 12px;
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15);
            border-radius: 8px; color: #f87171;
            font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; gap: 8px;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.15); }

        /* ════════════════════════════════════════
           MAIN
        ════════════════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1; display: flex; flex-direction: column; min-height: 100vh;
            transition: margin-left var(--transition);
            min-width: 0;
        }
        @media (max-width: 768px) {
            .main { margin-left: 0 !important; }
        }

        /* ── TOPBAR ── */
        .topbar {
            background: rgba(12,12,20,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 12px 20px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 40; gap: 12px;
        }
        .topbar::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-dark));
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }

        /* Hamburger mobile dans la topbar */
        .mobile-toggle {
            display: none;
            flex-shrink: 0; width: 36px; height: 36px;
            background: rgba(255,255,255,0.05); border: 1px solid var(--border);
            border-radius: 8px; cursor: pointer;
            flex-direction: column; align-items: center; justify-content: center; gap: 4px;
        }
        .mobile-toggle span { display: block; width: 16px; height: 2px; background: var(--text-muted); border-radius: 2px; }
        @media (max-width: 768px) {
            .mobile-toggle { display: flex; }
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 17px; font-weight: 600; color: var(--text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        @media (max-width: 480px) { .page-title { font-size: 15px; } }

        .topbar-right {
            display: flex; align-items: center; gap: 8px;
            flex-wrap: wrap; justify-content: flex-end;
        }
        @media (max-width: 480px) {
            .topbar-right { gap: 6px; }
            .topbar-right .btn-sm { padding: 5px 10px; font-size: 11px; }
            /* Cacher les filtres secondaires sur très petit écran */
            .topbar-right input[type=month] { max-width: 120px; }
        }

        /* ── CONTENT ── */
        .content { padding: 20px 24px; flex: 1; }
        @media (max-width: 768px) { .content { padding: 16px; } }
        @media (max-width: 480px) { .content { padding: 12px; } }

        /* ── ALERT ── */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; font-weight: 500; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #4ade80; }
        .alert-error   { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }

        /* ── BUTTONS ── */
        .btn { padding: 9px 18px; border-radius: 8px; font-family:'Inter',sans-serif; font-size:13px; font-weight:600; cursor:pointer; border:none; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s; white-space:nowrap; }
        .btn-gold    { background:linear-gradient(135deg,var(--gold-dark),var(--gold-light)); color:#0a0a0a; }
        .btn-gold:hover { box-shadow:0 6px 20px rgba(212,175,55,0.35); transform:translateY(-1px); }
        .btn-danger  { background:rgba(239,68,68,0.12); border:1px solid rgba(239,68,68,0.2); color:#f87171; }
        .btn-danger:hover { background:rgba(239,68,68,0.2); }
        .btn-ghost   { background:rgba(255,255,255,0.05); border:1px solid var(--border); color:var(--text-muted); }
        .btn-ghost:hover { color:var(--text); border-color:rgba(255,255,255,0.2); }
        .btn-sm { padding:6px 12px; font-size:12px; }

        /* ── CARD ── */
        .card { background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius); padding:20px; }
        @media (max-width: 480px) { .card { padding: 14px; } }
        .card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; padding-bottom:14px; border-bottom:1px solid var(--border); flex-wrap:wrap; gap:8px; }
        .card-title  { font-family:'Playfair Display',serif; font-size:16px; font-weight:600; color:var(--text); }

        /* ── TABLE responsive ── */
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width:100%; border-collapse:collapse; min-width: 480px; }
        thead tr { border-bottom:1px solid var(--border); }
        th { text-align:left; padding:9px 12px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-muted); }
        td { padding:11px 12px; font-size:13px; border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(255,255,255,0.02); }

        /* ── BADGES ── */
        .badge { padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; letter-spacing:0.3px; white-space:nowrap; }
        .badge-pending   { background:rgba(212,175,55,0.12); color:var(--gold); border:1px solid rgba(212,175,55,0.25); }
        .badge-confirmed { background:rgba(34,197,94,0.1);  color:#4ade80; border:1px solid rgba(34,197,94,0.2); }
        .badge-done      { background:rgba(99,102,241,0.1); color:#818cf8; border:1px solid rgba(99,102,241,0.2); }
        .badge-cancelled { background:rgba(239,68,68,0.1);  color:#f87171; border:1px solid rgba(239,68,68,0.2); }
        .badge-active    { background:rgba(34,197,94,0.1);  color:#4ade80; border:1px solid rgba(34,197,94,0.2); }
        .badge-inactive  { background:rgba(239,68,68,0.1);  color:#f87171; border:1px solid rgba(239,68,68,0.2); }

        /* ── FORM ── */
        .form-group { margin-bottom:18px; }
        label { display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); margin-bottom:6px; }
        input[type=text],input[type=number],input[type=email],input[type=file],input[type=month],input[type=date],textarea,select {
            width:100%; padding:11px 14px;
            background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.1);
            border-radius:8px; color:var(--text);
            font-family:'Inter',sans-serif; font-size:14px; transition:border 0.2s;
        }
        input:focus,textarea:focus,select:focus { outline:none; border-color:var(--gold); box-shadow:0 0 0 3px rgba(212,175,55,0.1); }
        select option { background:#1a1a28; color:var(--text); }
        textarea { resize:vertical; }
        .error-msg { color:#f87171; font-size:12px; margin-top:4px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        @media (max-width: 560px) { .form-row { grid-template-columns:1fr; } }
        .form-actions { display:flex; gap:10px; margin-top:8px; flex-wrap:wrap; }

        /* ── STAT GRID ── */
        .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
        @media (max-width: 768px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
        @media (max-width: 420px) { .stats-grid { grid-template-columns:1fr 1fr; gap:10px; } }
        .stat-card {
            background:var(--bg-card); border:1px solid var(--border);
            border-radius:var(--radius); padding:16px 18px;
            display:flex; align-items:center; gap:14px; transition:border-color 0.2s;
        }
        .stat-card:hover { border-color:rgba(212,175,55,0.3); }
        .stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
        .stat-icon.gold   { background:rgba(212,175,55,0.12); }
        .stat-icon.green  { background:rgba(34,197,94,0.1); }
        .stat-icon.purple { background:rgba(99,102,241,0.1); }
        .stat-icon.blue   { background:rgba(59,130,246,0.1); }
        .stat-icon.amber  { background:rgba(251,191,36,0.1); }
        .stat-number { font-size:24px; font-weight:700; color:var(--text); line-height:1; }
        .stat-label  { font-size:11px; color:var(--text-muted); margin-top:3px; }
        @media (max-width: 420px) {
            .stat-icon { width:36px; height:36px; font-size:16px; }
            .stat-number { font-size:20px; }
        }

        /* PAGINATION */
        .pagination { margin-top:14px; }
        .pagination nav { display:flex; gap:4px; flex-wrap:wrap; }

        /* IMAGE preview */
        .current-img { width:56px; height:56px; border-radius:8px; border:1px solid var(--border); object-fit:cover; margin-bottom:8px; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Overlay mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar-top">
        <div class="sidebar-logo">
            <div class="logo-icon">👑</div>
            <div class="logo-text">
                <h2>L'ARTISTO</h2>
                <p>Administration</p>
            </div>
        </div>
        <button class="toggle-btn" id="sidebarToggle" title="Réduire le menu">
            <span></span><span></span><span></span>
        </button>
    </div>

    <nav class="nav-section">
        <div class="nav-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            data-tooltip="Tableau de bord">
            <span class="nav-icon">📊</span>
            <span class="nav-link-text">Tableau de bord</span>
        </a>
        <a href="{{ route('admin.services.index') }}"
            class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}"
            data-tooltip="Services">
            <span class="nav-icon">✂️</span>
            <span class="nav-link-text">Services</span>
        </a>
        <a href="{{ route('admin.rendez-vous.index') }}"
            class="nav-link {{ request()->routeIs('admin.rendez-vous*') ? 'active' : '' }}"
            data-tooltip="Rendez-vous">
            <span class="nav-icon">📅</span>
            <span class="nav-link-text">Rendez-vous</span>
        </a>
        <a href="{{ route('admin.clients.index') }}"
            class="nav-link {{ request()->routeIs('admin.clients*') ? 'active' : '' }}"
            data-tooltip="Clients">
            <span class="nav-icon">👥</span>
            <span class="nav-link-text">Clients</span>
        </a>
        <a href="{{ route('admin.horaires.index') }}"
            class="nav-link {{ request()->routeIs('admin.horaires*') ? 'active' : '' }}"
            data-tooltip="Horaires">
            <span class="nav-icon">🕐</span>
            <span class="nav-link-text">Horaires</span>
        </a>
        <div class="nav-label" style="margin-top:14px;">Accès rapide</div>
        <a href="{{ route('dashboard') }}" class="nav-link" data-tooltip="Vue Client">
            <span class="nav-icon">👤</span>
            <span class="nav-link-text">Vue Client</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">👑</div>
            <div class="sidebar-user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrateur</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <span>🚪</span>
                <span class="logout-btn-text">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="main" id="mainContent">

    <div class="topbar">
        <div class="topbar-left">
            <!-- Bouton hamburger visible uniquement sur mobile -->
            <button class="mobile-toggle" id="mobileToggle">
                <span></span><span></span><span></span>
            </button>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-right">@yield('topbar-actions')</div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script>
(function () {
    const STORAGE_KEY = 'artisto_sidebar_collapsed';
    const body        = document.body;
    const desktopBtn  = document.getElementById('sidebarToggle');
    const mobileBtn   = document.getElementById('mobileToggle');
    const overlay     = document.getElementById('sidebarOverlay');

    const isMobile = () => window.innerWidth <= 768;

    // ── Restaurer état desktop ──
    if (!isMobile() && localStorage.getItem(STORAGE_KEY) === '1') {
        body.classList.add('sidebar-collapsed');
    }

    // ── Toggle desktop (réduire/agrandir) ──
    desktopBtn.addEventListener('click', function () {
        if (isMobile()) {
            // Sur mobile, le bouton dans la sidebar ferme la sidebar
            body.classList.remove('mobile-open');
        } else {
            body.classList.toggle('sidebar-collapsed');
            localStorage.setItem(STORAGE_KEY, body.classList.contains('sidebar-collapsed') ? '1' : '0');
        }
    });

    // ── Toggle mobile (ouvrir depuis la topbar) ──
    mobileBtn.addEventListener('click', function () {
        body.classList.toggle('mobile-open');
    });

    // ── Clic overlay → fermer sidebar ──
    overlay.addEventListener('click', function () {
        body.classList.remove('mobile-open');
    });

    // ── Fermer la sidebar mobile après navigation ──
    document.querySelectorAll('.nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (isMobile()) body.classList.remove('mobile-open');
        });
    });

    // ── Adapter au resize ──
    window.addEventListener('resize', function () {
        if (!isMobile()) body.classList.remove('mobile-open');
    });
})();
</script>

@stack('scripts')
</body>
</html>
