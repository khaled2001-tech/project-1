<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset Password - Cental Car Rental</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #e32636; --primary-dark: #b71c1c; --darker: #0f0f1a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Lato', sans-serif;
            background: var(--darker);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .bg-animated {
            position: fixed; inset: 0;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            z-index: 0;
        }
        .bg-animated::before {
            content: ''; position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(227,38,54,0.12) 0%, transparent 70%);
            top: -150px; right: -150px; border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        .car-deco { position: fixed; bottom: -20px; right: -30px; font-size: 250px; color: rgba(227,38,54,0.04); z-index: 0; }
        .wrapper { position: relative; z-index: 10; width: 100%; max-width: 460px; }
        .brand-logo { text-align: center; margin-bottom: 30px; animation: fadeDown 0.6s ease; }
        .brand-logo a { text-decoration: none; display: inline-flex; align-items: center; gap: 12px; }
        .brand-logo i { font-size: 32px; color: var(--primary); filter: drop-shadow(0 0 12px rgba(227,38,54,0.5)); }
        .brand-logo span { font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 900; color: #fff; letter-spacing: -1px; }
        .brand-logo span em { color: var(--primary); font-style: normal; }
        .auth-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px; padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            animation: fadeUp 0.6s ease 0.1s both;
        }
        .icon-circle {
            width: 72px; height: 72px;
            background: rgba(227,38,54,0.1);
            border: 2px solid rgba(227,38,54,0.3);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
        }
        .icon-circle i { font-size: 28px; color: var(--primary); }
        .auth-card h2 { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 24px; color: #fff; margin-bottom: 6px; text-align: center; }
        .auth-card p.subtitle { color: rgba(255,255,255,0.4); font-size: 14px; margin-bottom: 28px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: rgba(255,255,255,0.7); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); font-size: 14px; pointer-events: none; }
        .input-wrap input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 14px 14px 14px 42px;
            color: #fff; font-size: 14px;
            transition: all 0.3s; outline: none;
        }
        .input-wrap input:focus { border-color: var(--primary); background: rgba(227,38,54,0.05); box-shadow: 0 0 0 3px rgba(227,38,54,0.1); }
        .input-wrap input::placeholder { color: rgba(255,255,255,0.2); }
        .field-error { color: #ff6b7a; font-size: 12px; margin-top: 5px; }
        .btn-submit {
            width: 100%;
            background: var(--primary); color: #fff;
            border: none; border-radius: 10px;
            padding: 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px; font-weight: 700;
            cursor: pointer; transition: all 0.3s;
        }
        .btn-submit:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(227,38,54,0.4); }
        .back-home { text-align: center; margin-top: 16px; }
        .back-home a { color: rgba(255,255,255,0.2); font-size: 13px; text-decoration: none; }
        .back-home a:hover { color: rgba(255,255,255,0.5); }
        @keyframes fadeDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<div class="bg-animated"></div>
<div class="car-deco"><i class="fas fa-car-alt"></i></div>

<div class="wrapper">
    <div class="brand-logo">
        <a href="{{ route('welcome.index') }}">
            <i class="fas fa-car-alt"></i>
            <span>Cen<em>tal</em></span>
        </a>
    </div>
    <div class="auth-card">
        <div class="icon-circle"><i class="fas fa-shield-alt"></i></div>
        <h2>Reset Password</h2>
        <p class="subtitle">Create a new strong password for your account</p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="you@example.com" required>
                </div>
                @error('email')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>New Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Min. 8 characters" required autocomplete="new-password">
                </div>
                @error('password')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" placeholder="Repeat new password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-check-circle me-2"></i> Reset Password
            </button>
        </form>
    </div>
    <div class="back-home">
        <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
