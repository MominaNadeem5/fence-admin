
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | Fence Admin</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: #f4f6fb;
            color: #172033;
        }
        a { text-decoration: none; color: inherit; }
        .app { min-height: 100vh; }
        .sidebar {
            width: 255px;
            background: #101a35;
            color: #cbd5e8;
            position: fixed;
            inset: 0 auto 0 0;
            padding: 25px 17px;
            display: flex;
            flex-direction: column;
            z-index: 10;
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
            padding: 13px 14px;
            margin: 3px 0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }
        .nav-link:hover, .nav-link.active {
            background: #263657;
            color: white;
        }
        .nav-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }
        .sidebar-bottom {
            margin-top: auto;
            padding: 15px 8px 0;
            border-top: 1px solid #2a3550;
        }
        .sidebar-bottom p {
            font-size: 12px;
            color: #a8b5cd;
            overflow-wrap: anywhere;
        }
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
        .main { margin-left: 255px; min-height: 100vh; }
        .topbar {
            height: 76px;
            background: white;
            border-bottom: 1px solid #e9edf5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
        }
        .topbar h2 { font-size: 15px; margin: 0; }
        .topbar small { color: #8791a5; font-size: 12px; }
        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 700;
        }
        .avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            background: #e1eaff;
            color: #254a90;
            display: grid;
            place-items: center;
            font-weight: 800;
        }
        .content { padding: 32px 35px; max-width: 1500px; margin: auto; }
        .eyebrow {
            color: #5375b6;
            font-size: 11px;
            letter-spacing: 1.7px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 27px;
        }
        .page-heading h1 {
            font-size: clamp(24px, 3vw, 31px);
            margin: 8px 0;
            letter-spacing: -1px;
        }
        .page-heading p { margin: 0; color: #78839a; font-size: 14px; line-height: 1.7; }
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 9px;
            padding: 12px 17px;
            background: #214780;
            color: white;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }
        .button:hover { background: #173761; }
        .button-light { background: #edf2fb; color: #244777; }
        .button-light:hover { background: #dfe8f7; }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }
        .stat, .panel, .welcome-card {
            background: white;
            border: 1px solid #e8edf5;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(20, 39, 75, .035);
        }
        .stat { padding: 23px; }
        .stat-top { display: flex; justify-content: space-between; align-items: center; }
        .stat-label { color: #78839a; font-size: 12px; font-weight: 600; }
        .stat-icon {
            width: 39px; height: 39px; display: grid; place-items: center;
            border-radius: 11px; background: #edf3ff; font-size: 18px;
        }
        .stat h3 { font-size: 25px; margin: 18px 0 5px; }
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
        .welcome-symbol { font-size: 65px; opacity: .85; }
        .panel { padding: 25px; margin-bottom: 23px; }
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .panel-header h2 { font-size: 17px; margin: 0 0 5px; }
        .panel-header p { font-size: 12px; color: #8791a5; margin: 0; }
        .quick-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 15px; }
        .quick-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px;
            border: 1px solid #e8edf5;
            border-radius: 12px;
            transition: .2s;
        }
        .quick-link:hover { border-color: #a9c0e8; background: #f9fbff; }
        .quick-icon {
            width: 45px; height: 45px; border-radius: 12px;
            background: #edf3ff; display: grid; place-items: center; font-size: 20px;
        }
        .quick-link strong { display: block; font-size: 13px; margin-bottom: 5px; }
        .quick-link small { color: #8490a5; font-size: 11px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
        .field { min-width: 0; }
        .field.full { grid-column: 1 / -1; }
        .field label { display: block; margin-bottom: 9px; font-size: 12px; font-weight: 750; color: #34415b; }
        .field input, .field textarea {
            width: 100%; padding: 13px 14px; border: 1px solid #dce3ef;
            border-radius: 9px; background: #fbfcff; color: #172033;
            font: inherit; font-size: 13px; outline: none; transition: .2s;
        }
        .field input:focus, .field textarea:focus {
            border-color: #537ec0; background: white;
            box-shadow: 0 0 0 3px rgba(83, 126, 192, .12);
        }
        .field textarea { min-height: 110px; resize: vertical; line-height: 1.7; }
        .field .hint { color: #8791a5; font-size: 11px; margin-top: 7px; }
        .form-footer {
            display: flex; justify-content: space-between; align-items: center;
            gap: 15px; padding-top: 23px; margin-top: 23px;
            border-top: 1px solid #edf0f6;
        }
        .alert { border-radius: 10px; padding: 14px 16px; font-size: 13px; margin-bottom: 20px; }
        .alert-success { background: #e8f8ef; border: 1px solid #bce8ce; color: #17663b; }
        .alert-error { background: #fff0f0; border: 1px solid #f5cccc; color: #a32121; }
        .footer { color: #929bad; font-size: 11px; text-align: center; padding: 20px; }
        @media (max-width: 900px) {
            .sidebar { width: 215px; }
            .main { margin-left: 215px; }
            .content { padding: 25px 20px; }
            .topbar { padding: 0 20px; }
            .stats { grid-template-columns: 1fr; }
        }
        @media (max-width: 620px) {
            .sidebar { position: static; width: 100%; padding: 15px; }
            .brand { padding-bottom: 12px; }
            .sidebar .nav-label, .sidebar-bottom { display: none; }
            .sidebar nav { display: flex; gap: 5px; overflow-x: auto; }
            .nav-link { white-space: nowrap; padding: 10px; font-size: 12px; }
            .main { margin-left: 0; }
            .topbar { height: 60px; padding: 0 16px; }
            .content { padding: 23px 15px; }
            .page-heading { flex-direction: column; }
            .welcome-card { padding: 22px; }
            .welcome-symbol { display: none; }
            .quick-grid, .form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
            .panel { padding: 18px; }
            .form-footer { align-items: stretch; flex-direction: column; }
            .form-footer .button { width: 100%; }
        }
    </style>
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-icon">⌂</span>
            <span>FENCE ADMIN<small>MANAGEMENT PORTAL</small></span>
        </a>

        <div class="nav-label">WORKSPACE</div>
        <nav>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <span class="nav-icon">▦</span> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.website-content.*') ? 'active' : '' }}"
               href="{{ route('admin.website-content.edit') }}">
                <span class="nav-icon">✎</span> Website Content
            </a>
            
<a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
   href="{{ route('admin.categories.index') }}">
    <span class="nav-icon">▤</span> Categories
</a>

<a href="{{ route('admin.products.index') }}">
    Products
</a>

            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <span class="nav-icon">↗</span> View Website
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="nav-label">SIGNED IN AS</div>
            <p>{{ auth()->user()->email ?? 'Administrator' }}</p>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="logout" type="submit">↪ &nbsp; Sign Out</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h2>@yield('topbar-title', 'Admin Dashboard')</h2>
                <small>Manage your website in one place</small>
            </div>
            <div class="profile">
                <div class="avatar">A</div>
                <span>Administrator</span>
            </div>
        </header>

        <section class="content">
            @yield('content')
        </section>

        <footer class="footer">© {{ date('Y') }} Fence Admin · Built for better management</footer>
    </main>
</div>
</body>
</html>
