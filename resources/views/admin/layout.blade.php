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
            --gold:       #D4AF37;
            --gold-light: #FFD700;
            --gold-dark:  #B8860B;
            --sidebar-bg: #07070d;
            --bg:         #0c0c14;
            --bg-card:    rgba(255,255,255,0.04);
            --border:     rgba(212,175,55,0.15);
            --text:       #e2ddd5;
            --text-muted: #7a7060;
            --radius:     14px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); display:flex; min-height:100vh; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
        }
        .sidebar-top {
            padding: 28px 20px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo {
            display: flex; align-items: center; gap: 12px;
        }
        .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 0 16px rgba(212,175,55,0.3);
            flex-shrink: 0;
        }
        .logo-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 1px;
        }
        .logo-text p { font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }

        .nav-section { padding: 20px 12px 0; flex: 1; }
        .nav-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); padding: 0 8px; margin-bottom: 8px; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: var(--text); }
        .nav-link.active {
            background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(255,215,0,0.08));
            color: var(--gold);
            border: 1px solid rgba(212,175,55,0.2);
        }
        .nav-icon { font-size: 16px; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 8px;
            background: rgba(255,255,255,0.03);
        }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; flex-shrink: 0;
        }
        .user-name { font-size: 12px; font-weight: 600; color: var(--text); }
        .user-role { font-size: 10px; color: var(--text-muted); }
        .logout-form form { width: 100%; }
        .logout-btn {
            width: 100%; padding: 9px 12px;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            border-radius: 8px;
            color: #f87171;
            font-family: 'Inter', sans-serif;
            font-size: 12px; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
            text-align: left;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.15); }

        /* ── MAIN ── */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* ── TOP BAR ── */
        .topbar {
            background: rgba(12,12,20,0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-dark));
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--text);
        }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        /* ── CONTENT ── */
        .content { padding: 28px 32px; flex: 1; }

        /* ── ALERT ── */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 500; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #4ade80; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.2);  color: #f87171; }

        /* ── BUTTONS ── */
        .btn { padding: 9px 20px; border-radius: 8px; font-family:'Inter',sans-serif; font-size:13px; font-weight:600; cursor:pointer; border:none; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s; }
        .btn-gold    { background:linear-gradient(135deg,var(--gold-dark),var(--gold-light)); color:#0a0a0a; }
        .btn-gold:hover { box-shadow:0 6px 20px rgba(212,175,55,0.35); transform:translateY(-1px); }
        .btn-danger  { background:rgba(239,68,68,0.12); border:1px solid rgba(239,68,68,0.2); color:#f87171; }
        .btn-danger:hover { background:rgba(239,68,68,0.2); }
        .btn-ghost   { background:rgba(255,255,255,0.05); border:1px solid var(--border); color:var(--text-muted); }
        .btn-ghost:hover { color:var(--text); border-color:rgba(255,255,255,0.2); }
        .btn-sm { padding:6px 14px; font-size:12px; }

        /* ── CARD ── */
        .card { background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius); padding:24px; }
        .card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid var(--border); }
        .card-title  { font-family:'Playfair Display',serif; font-size:17px; font-weight:600; color:var(--text); }

        /* ── TABLE ── */
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:1px solid var(--border); }
        th { text-align:left; padding:10px 14px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-muted); }
        td { padding:13px 14px; font-size:13.5px; border-bottom:1px solid rgba(255,255,255,0.03); vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(255,255,255,0.02); }

        /* ── BADGES ── */
        .badge { padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; letter-spacing:0.3px; }
        .badge-pending   { background:rgba(212,175,55,0.12); color:var(--gold); border:1px solid rgba(212,175,55,0.25); }
        .badge-confirmed { background:rgba(34,197,94,0.1);  color:#4ade80; border:1px solid rgba(34,197,94,0.2); }
        .badge-done      { background:rgba(99,102,241,0.1); color:#818cf8; border:1px solid rgba(99,102,241,0.2); }
        .badge-cancelled { background:rgba(239,68,68,0.1);  color:#f87171; border:1px solid rgba(239,68,68,0.2); }
        .badge-active    { background:rgba(34,197,94,0.1);  color:#4ade80; border:1px solid rgba(34,197,94,0.2); }
        .badge-inactive  { background:rgba(239,68,68,0.1);  color:#f87171; border:1px solid rgba(239,68,68,0.2); }

        /* ── FORM ── */
        .form-group { margin-bottom:20px; }
        label { display:block; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); margin-bottom:7px; }
        input[type=text],input[type=number],input[type=email],input[type=file],textarea,select {
            width:100%; padding:11px 14px;
            background:rgba(255,255,255,0.04);
            border:1px solid rgba(255,255,255,0.1);
            border-radius:8px;
            color:var(--text);
            font-family:'Inter',sans-serif; font-size:14px;
            transition:border 0.2s;
        }
        input:focus,textarea:focus,select:focus { outline:none; border-color:var(--gold); box-shadow:0 0 0 3px rgba(212,175,55,0.1); }
        select option { background:#1a1a28; color:var(--text); }
        textarea { resize:vertical; }
        .error-msg { color:#f87171; font-size:12px; margin-top:4px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .form-actions { display:flex; gap:12px; margin-top:8px; }

        /* ── STAT CARD ── */
        .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
        .stat-card {
            background:var(--bg-card); border:1px solid var(--border);
            border-radius:var(--radius); padding:20px 22px;
            display:flex; align-items:center; gap:16px;
            transition:border-color 0.2s;
        }
        .stat-card:hover { border-color:rgba(212,175,55,0.3); }
        .stat-icon {
            width:48px; height:48px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:22px; flex-shrink:0;
        }
        .stat-icon.gold   { background:rgba(212,175,55,0.12); }
        .stat-icon.green  { background:rgba(34,197,94,0.1); }
        .stat-icon.purple { background:rgba(99,102,241,0.1); }
        .stat-icon.blue   { background:rgba(59,130,246,0.1); }
        .stat-icon.amber  { background:rgba(251,191,36,0.1); }
        .stat-number { font-size:28px; font-weight:700; color:var(--text); line-height:1; }
        .stat-label  { font-size:12px; color:var(--text-muted); margin-top:4px; }

        /* PAGINATION */
        .pagination { margin-top:16px; }
        .pagination nav { display:flex; gap:6px; }

        /* IMAGE preview */
        .current-img { width:60px; height:60px; border-radius:8px; border:1px solid var(--border); object-fit:cover; margin-bottom:8px; }
    </style>
    @stack('styles')
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-logo">
            <div class="logo-icon">👑</div>
            <div class="logo-text">
                <h2>L'ARTISTO</h2>
                <p>Administration</p>
            </div>
        </div>
    </div>

    <nav class="nav-section">
        <div class="nav-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}"       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Tableau de bord
        </a>
        <a href="{{ route('admin.services.index') }}"   class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
            <span class="nav-icon">✂️</span> Services
        </a>
        <a href="{{ route('admin.rendez-vous.index') }}" class="nav-link {{ request()->routeIs('admin.rendez-vous*') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Rendez-vous
        </a>
        <a href="{{ route('admin.clients.index') }}" class="nav-link {{ request()->routeIs('admin.clients*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Clients
        </a>
        <a href="{{ route('admin.horaires.index') }}" class="nav-link {{ request()->routeIs('admin.horaires*') ? 'active' : '' }}">
            <span class="nav-icon">🕐</span> Horaires
        </a>
        <div class="nav-label" style="margin-top:16px;">Accès rapide</div>
        <a href="{{ route('dashboard') }}" class="nav-link">
            <span class="nav-icon">👤</span> Vue Client
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">👑</div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrateur</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">🚪 Déconnexion</button>
        </form>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="main">
    <div class="topbar">
        <div class="page-title">@yield('page-title', 'Dashboard')</div>
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

@stack('scripts')
</body>
</html>
