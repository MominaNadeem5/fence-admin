
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #f3f6f4;
            font-family: Arial, sans-serif;
        }

        .card {
            background: white;
            padding: 35px;
            border-radius: 14px;
            width: min(420px, 92%);
            box-shadow: 0 8px 30px #00000012;
        }

        h1 { color: #183c2b; margin-top: 0; }

        label {
            display: block;
            margin: 16px 0 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 13px;
            border: 0;
            border-radius: 7px;
            background: #245b3c;
            color: white;
            cursor: pointer;
        }

        .error { color: #c62828; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Create Admin Account</h1>
        <p>Register an authorized administrator.</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/admin/register') }}">
            @csrf

            <label for="name">Full Name</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}" required>

            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   minlength="8" required>

            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password"
                   name="password_confirmation" minlength="8" required>

            <button type="submit">Create Account</button>
        </form>
    </div>
</body>
</html>
