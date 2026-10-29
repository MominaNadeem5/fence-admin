<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | Fence Admin</title>
    <style>
        :root { --primary: #214780; --primary-dark: #173761; --ink: #172033; --muted: #78839a; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 20px;
            background: linear-gradient(160deg, #101a35 0%, #1d3560 100%);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: var(--ink);
        }
        .card {
            background: white;
            padding: 36px;
            border-radius: 16px;
            width: 100%;
            max-width: 410px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }
        .logo {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            background: #dbeafe;
            color: #173b79;
            display: grid;
            place-items: center;
            font-size: 24px;
            margin-bottom: 18px;
        }
        h1 { margin: 0 0 6px; font-size: 24px; letter-spacing: -.5px; }
        .sub { margin: 0 0 24px; color: var(--muted); font-size: 14px; }
        label { display: block; margin: 16px 0 7px; font-size: 12px; font-weight: 700; color: #34415b; }
        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dce3ef;
            border-radius: 9px;
            font: inherit;
            font-size: 14px;
            background: #fbfcff;
            outline: none;
        }
        input:focus { border-color: #537ec0; background: white; box-shadow: 0 0 0 3px rgba(83, 126, 192, .15); }
        .password-wrap { position: relative; }
        .password-wrap input { padding-right: 62px; }
        .toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            padding: 6px 8px;
            border-radius: 6px;
        }
        .toggle:hover { background: #edf2fb; }
        .remember { display: flex; align-items: center; gap: 8px; margin: 16px 0 0; font-size: 13px; font-weight: 500; color: #4a566e; }
        .remember input { width: 16px; height: 16px; accent-color: var(--primary); }
        .submit {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: 0;
            border-radius: 9px;
            background: var(--primary);
            color: white;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .submit:hover { background: var(--primary-dark); }
        .submit.is-loading { pointer-events: none; opacity: .8; }
        .submit.is-loading::after {
            content: "";
            width: 14px;
            height: 14px;
            border: 2px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .error {
            background: #fff0f0;
            border: 1px solid #f5cccc;
            color: #a32121;
            border-radius: 9px;
            padding: 11px 14px;
            font-size: 13px;
            margin-bottom: 4px;
        }
        .back { display: block; text-align: center; margin-top: 20px; font-size: 13px; color: var(--muted); }
        .back:hover { color: var(--primary); }
    </style>
</head>
<body>
    <main class="card">
        <div class="logo">⌂</div>
        <h1>Admin Login</h1>
        <p class="sub">Sign in to manage your website.</p>

        @if ($errors->any())
            <div class="error" role="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ url('/admin/login') }}" id="login-form">
            @csrf

            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   autocomplete="username" autofocus required>

            <label for="password">Password</label>
            <div class="password-wrap">
                <input id="password" type="password" name="password"
                       autocomplete="current-password" required>
                <button type="button" class="toggle" id="toggle-password" aria-controls="password" aria-pressed="false">Show</button>
            </div>

            <label class="remember">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Keep me signed in
            </label>

            <button type="submit" class="submit" id="submit">Sign in</button>
        </form>

        <a class="back" href="{{ url('/') }}">&larr; Back to website</a>
    </main>

    <script>
        (function () {
            var input = document.getElementById('password');
            var toggle = document.getElementById('toggle-password');
            toggle.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                toggle.textContent = show ? 'Hide' : 'Show';
                toggle.setAttribute('aria-pressed', show ? 'true' : 'false');
            });

            document.getElementById('login-form').addEventListener('submit', function () {
                var button = document.getElementById('submit');
                setTimeout(function () { button.classList.add('is-loading'); }, 0);
            });
            window.addEventListener('pageshow', function () {
                document.getElementById('submit').classList.remove('is-loading');
            });
        })();
    </script>
</body>
</html>
