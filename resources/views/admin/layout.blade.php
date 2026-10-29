<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin Panel') | Fence Admin</title>
    <style>
        :root {
            --navy: #101a35;
            --navy-soft: #263657;
            --primary: #214780;
            --primary-dark: #173761;
            --ink: #172033;
            --muted: #78839a;
            --line: #e8edf5;
            --bg: #f4f6fb;
            --danger: #b42318;
            --success: #17663b;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
            -webkit-text-size-adjust: 100%;
        }
        a { text-decoration: none; color: inherit; }
        :focus-visible { outline: 2px solid #537ec0; outline-offset: 2px; }
        .app { min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 255px;
            background: var(--navy);
            color: #cbd5e8;
            position: fixed;
            inset: 0 auto 0 0;
            padding: 25px 17px;
            display: flex;
            flex-direction: column;
            z-index: 30;
            overflow-y: auto;
            transition: transform .2s ease;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 9px 28px;
            color: white;
            font-size: 19px;
            font-weight: 800;
        }
        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: #dbeafe;
            color: #173b79;
            display: grid;
            place-items: center;
            font-size: 22px;
            flex: none;
        }
        .brand small {
            display: block;
            color: #8795b4;
            font-size: 11px;
            font-weight: 500;
            margin-top: 4px;
        }
        .nav-label {
            color: #7786a7;
            font-size: 10px;
            letter-spacing: 1.5px;
            font-weight: 800;
            padding: 12px 12px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin: 3px 0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: background .15s;
        }
        .nav-link:hover, .nav-link.active { background: var(--navy-soft); color: white; }
        .nav-icon { width: 20px; height: 20px; flex: none; }
        .sidebar-bottom {
            margin-top: auto;
            padding: 15px 8px 0;
            border-top: 1px solid #2a3550;
        }
        .sidebar-bottom p { font-size: 12px; color: #a8b5cd; overflow-wrap: anywhere; }
        .logout {
            width: 100%;
            border: 1px solid #384562;
            background: transparent;
            color: #fff;
            border-radius: 9px;
            padding: 11px;
            cursor: pointer;
            font-size: 13px;
        }
        .logout:hover { background: var(--navy-soft); }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(16, 26, 53, .55);
            z-index: 20;
        }

        /* Main */
        .main { margin-left: 255px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            height: 72px;
            background: white;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .topbar h2 { font-size: 15px; margin: 0; }
        .topbar small { color: #8791a5; font-size: 12px; }
        .menu-button {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: white;
            cursor: pointer;
            place-items: center;
            flex: none;
        }
        .profile { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; min-width: 0; }
        .profile span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            background: #e1eaff;
            color: #254a90;
            display: grid;
            place-items: center;
            font-weight: 800;
            flex: none;
        }
        .content { padding: 32px 35px; width: 100%; max-width: 1500px; margin: 0 auto; flex: 1; }
        .eyebrow { color: #5375b6; font-size: 11px; letter-spacing: 1.7px; font-weight: 800; text-transform: uppercase; }
        .page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 27px;
        }
        .page-heading h1 { font-size: clamp(24px, 3vw, 31px); margin: 8px 0; letter-spacing: -1px; }
        .page-heading p { margin: 0; color: var(--muted); font-size: 14px; line-height: 1.7; }

        /* Buttons */
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 9px;
            padding: 12px 17px;
            background: var(--primary);
            color: white;
            font: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            position: relative;
        }
        .button:hover { background: var(--primary-dark); }
        .button-light { background: #edf2fb; color: #244777; }
        .button-light:hover { background: #dfe8f7; }
        .button-danger { background: #fef3f2; color: var(--danger); }
        .button-danger:hover { background: #fee4e2; }
        .button-sm { padding: 8px 13px; font-size: 12px; }
        .button.is-loading { pointer-events: none; opacity: .75; }
        .button.is-loading::after {
            content: "";
            width: 14px;
            height: 14px;
            border: 2px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Cards */
        .stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; margin-bottom: 25px; }
        .stat, .panel, .welcome-card {
            background: white;
            border: 1px solid var(--line);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(20, 39, 75, .035);
        }
        .stat { padding: 22px; }
        .stat-top { display: flex; justify-content: space-between; align-items: center; }
        .stat-label { color: var(--muted); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
        .stat-icon { width: 39px; height: 39px; display: grid; place-items: center; border-radius: 11px; background: #edf3ff; color: var(--primary); }
        .stat-icon svg { width: 20px; height: 20px; }
        .stat h3 { font-size: 28px; margin: 16px 0 5px; }
        .stat p { color: #8b95a8; font-size: 12px; margin: 0; }
        .welcome-card {
            background: linear-gradient(120deg, #17335e, #28558f);
            color: white;
            padding: 29px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            overflow: hidden;
        }
        .welcome-card h2 { font-size: 23px; margin: 0 0 10px; }
        .welcome-card p { color: #d2def2; font-size: 13px; line-height: 1.8; margin: 0; }
        .panel { padding: 25px; margin-bottom: 23px; }
        .panel-header { display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px; }
        .panel-header h2 { font-size: 17px; margin: 0 0 5px; }
        .panel-header p { font-size: 12px; color: #8791a5; margin: 0; }
        .quick-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 15px; }
        .quick-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px;
            border: 1px solid var(--line);
            border-radius: 12px;
            transition: background .15s, border-color .15s;
        }
        .quick-link:hover { border-color: #a9c0e8; background: #f9fbff; }
        .quick-icon { width: 45px; height: 45px; border-radius: 12px; background: #edf3ff; color: var(--primary); display: grid; place-items: center; flex: none; }
        .quick-icon svg { width: 22px; height: 22px; }
        .quick-link strong { display: block; font-size: 13px; margin-bottom: 5px; }
        .quick-link small { color: #8490a5; font-size: 11px; }

        /* Forms */
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
        .field { min-width: 0; }
        .field.full { grid-column: 1 / -1; }
        .field label { display: block; margin-bottom: 9px; font-size: 12px; font-weight: 750; color: #34415b; }
        .field input:not([type="checkbox"]):not([type="file"]), .field textarea, .field select,
        .input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dce3ef;
            border-radius: 9px;
            background: #fbfcff;
            color: var(--ink);
            font: inherit;
            font-size: 13px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .field input:focus, .field textarea:focus, .field select:focus, .input:focus {
            border-color: #537ec0;
            background: white;
            box-shadow: 0 0 0 3px rgba(83, 126, 192, .12);
        }
        .field textarea { min-height: 110px; resize: vertical; line-height: 1.7; }
        .field .hint { color: #8791a5; font-size: 11px; margin-top: 7px; }
        .field .error-text { color: var(--danger); font-size: 12px; margin-top: 6px; display: block; }
        .field .is-invalid { border-color: #f1a9a3 !important; }
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding-top: 23px;
            margin-top: 23px;
            border-top: 1px solid #edf0f6;
        }
        .toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 14px 16px;
            border: 1px solid #dce3ef;
            border-radius: 10px;
            background: #fbfcff;
        }
        .toggle-row strong { display: block; font-size: 13px; }
        .toggle-row small { color: #8791a5; font-size: 11px; }
        .toggle-row input { width: 18px; height: 18px; accent-color: var(--primary); flex: none; }
        .image-preview { width: 96px; height: 96px; object-fit: cover; border-radius: 10px; border: 1px solid var(--line); margin-bottom: 10px; display: block; }

        /* Alerts */
        .alert { border-radius: 10px; padding: 14px 16px; font-size: 13px; margin-bottom: 20px; line-height: 1.6; }
        .alert ul { margin: 6px 0 0; padding-left: 18px; }
        .alert-success { background: #e8f8ef; border: 1px solid #bce8ce; color: var(--success); }
        .alert-error { background: #fff0f0; border: 1px solid #f5cccc; color: #a32121; }

        /* Tables */
        .toolbar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; }
        .toolbar .input { width: auto; min-width: 150px; }
        .toolbar .search { flex: 1 1 220px; }
        .table-wrap { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table th {
            text-align: left;
            padding: 12px 14px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--muted);
            background: #f8fafd;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }
        .table td { padding: 14px; border-bottom: 1px solid #f0f3f8; vertical-align: middle; }
        .table tr:last-child td { border-bottom: 0; }
        .table .actions { text-align: right; white-space: nowrap; }
        .table .actions form { display: inline-block; }
        .thumb { width: 52px; height: 52px; object-fit: cover; border-radius: 8px; border: 1px solid var(--line); display: block; }
        .thumb-empty { width: 52px; height: 52px; border-radius: 8px; background: #f1f4f9; color: #a0abc0; display: grid; place-items: center; font-size: 10px; }
        .cell-sub { color: var(--muted); font-size: 12px; margin-top: 3px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
        .badge-success { background: #e8f8ef; color: var(--success); }
        .badge-muted { background: #eef1f6; color: #5b6578; }
        .empty { text-align: center; padding: 44px 20px; color: var(--muted); }
        .empty strong { display: block; color: var(--ink); font-size: 15px; margin-bottom: 6px; }
        .empty p { margin: 0 0 16px; font-size: 13px; }

        /* Pagination */
        .pagination { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: 18px; font-size: 12px; color: var(--muted); }
        .pagination-links { display: flex; gap: 8px; flex-wrap: wrap; }
        .page-link { padding: 8px 13px; border: 1px solid var(--line); border-radius: 8px; background: white; color: var(--ink); font-weight: 600; }
        a.page-link:hover { background: #f4f7fc; }
        .page-link.disabled { color: #b4bccb; }
        .page-link.current { background: #f4f7fc; }

        .footer { color: #929bad; font-size: 11px; text-align: center; padding: 20px; }

        @media (max-width: 1100px) {
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            body.nav-open .sidebar { transform: none; box-shadow: 0 0 40px rgba(0, 0, 0, .3); }
            body.nav-open .sidebar-overlay { display: block; }
            .main { margin-left: 0; }
            .menu-button { display: grid; }
            .content { padding: 25px 20px; }
            .topbar { padding: 0 20px; }
        }
        @media (max-width: 620px) {
            .topbar { height: 62px; padding: 0 14px; }
            .topbar small, .profile span { display: none; }
            .content { padding: 22px 14px; }
            .page-heading { flex-direction: column; gap: 14px; }
            .page-heading .button { width: 100%; }
            .stats, .quick-grid, .form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
            .welcome-card { padding: 22px; }
            .panel { padding: 18px; }
            .form-footer { align-items: stretch; flex-direction: column-reverse; }
            .form-footer .button { width: 100%; }
            .toolbar .input, .toolbar .button { width: 100%; }
        }
    </style>
    @stack('head')
</head>
<body>
@php
    $adminName = auth()->user()?->name ?? 'Administrator';
    $icons = [
        'dashboard' => '<path d="M3 3h7v9H3zM14 3h7v5h-7zM14 12h7v9h-7zM3 16h7v5H3z"/>',
        'content'   => '<path d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/>',
        'category'  => '<path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>',
        'product'   => '<path d="M21 8l-9-5-9 5v8l9 5 9-5zM3 8l9 5 9-5M12 13v8"/>',
        'admin'     => '<path d="M12 3l8 3v6c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V6z"/>',
        'globe'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 010 18M12 3a14 14 0 000 18"/>',
    ];
    $icon = fn (string $name) => '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$icons[$name].'</svg>';
@endphp
<div class="app">
    <div class="sidebar-overlay" data-nav-close></div>

    <aside class="sidebar" id="sidebar" aria-label="Main navigation">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-icon">⌂</span>
            <span>FENCE ADMIN<small>MANAGEMENT PORTAL</small></span>
        </a>

        <div class="nav-label">WORKSPACE</div>
        <nav>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                {!! $icon('dashboard') !!} Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.website-content.*') ? 'active' : '' }}" href="{{ route('admin.website-content.edit') }}">
                {!! $icon('content') !!} Website Content
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                {!! $icon('category') !!} Categories
            </a>
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                {!! $icon('product') !!} Products
            </a>
            <a class="nav-link {{ request()->routeIs('admin.register') ? 'active' : '' }}" href="{{ route('admin.register') }}">
                {!! $icon('admin') !!} Add Admin
            </a>
            <a class="nav-link" href="{{ url('/') }}" target="_blank" rel="noopener">
                {!! $icon('globe') !!} View Website
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="nav-label">SIGNED IN AS</div>
            <p>{{ auth()->user()->email ?? 'Administrator' }}</p>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="logout" type="submit">Sign Out</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-button" type="button" data-nav-toggle aria-label="Open menu" aria-controls="sidebar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h2>@yield('topbar-title', 'Admin Dashboard')</h2>
                    <small>Manage your website in one place</small>
                </div>
            </div>
            <div class="profile">
                <div class="avatar">{{ strtoupper(mb_substr($adminName, 0, 1)) }}</div>
                <span>{{ $adminName }}</span>
            </div>
        </header>

        <section class="content">
            @include('admin.partials.flash')
            @yield('content')
        </section>

        <footer class="footer">© {{ date('Y') }} Fence Admin</footer>
    </main>
</div>

<script>
    (function () {
        var body = document.body;
        document.querySelectorAll('[data-nav-toggle]').forEach(function (el) {
            el.addEventListener('click', function () { body.classList.toggle('nav-open'); });
        });
        document.querySelectorAll('[data-nav-close]').forEach(function (el) {
            el.addEventListener('click', function () { body.classList.remove('nav-open'); });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') body.classList.remove('nav-open');
        });

        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (form.dataset.confirm && !window.confirm(form.dataset.confirm)) {
                e.preventDefault();
                return;
            }
            if (e.defaultPrevented) return;
            var button = form.querySelector('button[type="submit"]');
            if (button && !button.classList.contains('logout')) {
                // Defer so the form still submits, then block double-clicks.
                setTimeout(function () { button.classList.add('is-loading'); }, 0);
            }
        });

        // Restore buttons when returning via the browser's back button.
        window.addEventListener('pageshow', function () {
            document.querySelectorAll('.is-loading').forEach(function (b) { b.classList.remove('is-loading'); });
        });
    })();
</script>
@stack('scripts')
</body>
</html>
