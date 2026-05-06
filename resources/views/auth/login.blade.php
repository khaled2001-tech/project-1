<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login - Cental Car Rental</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #e32636;
            --primary-dark: #b71c1c;
            --dark: #1a1a2e;
            --darker: #0f0f1a;
            --light: #f8f9fa;
            --gray: #6c757d;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background: var(--darker);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Animated background */
        .bg-animated {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            z-index: 0;
        }
        .bg-animated::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(227,38,54,0.15) 0%, transparent 70%);
            top: -200px; right: -200px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }
        .bg-animated::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(227,38,54,0.08) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite reverse;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        /* Car silhouette decoration */
        .car-deco {
            position: fixed;
            bottom: -20px;
            left: -50px;
            font-size: 280px;
            color: rgba(227,38,54,0.04);
            z-index: 0;
            transform: scaleX(-1);
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }

        /* Brand */
        .brand-logo {
            text-align: center;
            margin-bottom: 32px;
            animation: fadeDown 0.6s ease;
        }
        .brand-logo a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }
        .brand-logo i {
            font-size: 36px;
            color: var(--primary);
            filter: drop-shadow(0 0 12px rgba(227,38,54,0.5));
        }
        .brand-logo span {
            font-family: 'Montserrat', sans-serif;
            font-size: 36px;
            font-weight: 900;
            color: #fff;
            letter-spacing: -1px;
        }
        .brand-logo span em {
            color: var(--primary);
            font-style: normal;
        }

        /* Card */
        .auth-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            animation: fadeUp 0.6s ease 0.1s both;
        }

        .auth-card h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 26px;
            color: #fff;
            margin-bottom: 6px;
        }
        .auth-card p.subtitle {
            color: rgba(255,255,255,0.4);
            font-size: 14px;
            margin-bottom: 32px;
        }

        /* Form */
        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 14px;
            transition: color 0.3s;
        }
        .input-wrap input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 14px 16px 14px 44px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s;
            outline: none;
        }
        .input-wrap input:focus {
            border-color: var(--primary);
            background: rgba(227,38,54,0.05);
            box-shadow: 0 0 0 3px rgba(227,38,54,0.1);
        }
        .input-wrap input:focus + i,
        .input-wrap input:focus ~ i { color: var(--primary); }
        .input-wrap input::placeholder { color: rgba(255,255,255,0.25); }

        /* Fix icon ordering for absolute positioning */
        .input-wrap input { order: 1; }
        .input-wrap i { order: 0; }

        /* Remember & forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .remember-me input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }
        .remember-me span {
            color: rgba(255,255,255,0.5);
            font-size: 14px;
        }
        .forgot-link {
            color: var(--primary);
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        .forgot-link:hover { opacity: 0.8; color: var(--primary); }

        /* Button */
        .btn-login {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-login:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(227,38,54,0.4); }
        .btn-login:hover::before { opacity: 1; }
        .btn-login:active { transform: translateY(0); }

        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
            color: rgba(255,255,255,0.2);
            font-size: 13px;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .register-link {
            text-align: center;
            color: rgba(255,255,255,0.4);
            font-size: 14px;
        }
        .register-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }
        .register-link a:hover { text-decoration: underline; }

        /* Error */
        .alert-danger-custom {
            background: rgba(227,38,54,0.1);
            border: 1px solid rgba(227,38,54,0.3);
            border-radius: 10px;
            padding: 12px 16px;
            color: #ff6b7a;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .field-error {
            color: #ff6b7a;
            font-size: 12px;
            margin-top: 6px;
        }

        /* Back to home */
        .back-home {
            text-align: center;
            margin-top: 20px;
        }
        .back-home a {
            color: rgba(255,255,255,0.3);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-home a:hover { color: rgba(255,255,255,0.6); }
        .back-home i { margin-right: 6px; font-size: 11px; }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="bg-animated"></div>
<div class="car-deco"><i class="fas fa-car-alt"></i></div>

<div class="login-wrapper">

    <div class="brand-logo">
        <a href="{{ route('welcome.index') }}">
            <i class="fas fa-car-alt"></i>
            <span>Cen<em>tal</em></span>
        </a>
    </div>

    <div class="auth-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Sign in to your account to continue</p>

        @if (session('status'))
            <div class="alert-danger-custom">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrap">
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="you@example.com" required autofocus autocomplete="email">
                    <i class="fas fa-envelope"></i>
                </div>
                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <input type="password" name="password"
                           placeholder="••••••••" required autocomplete="current-password">
                    <i class="fas fa-lock"></i>
                </div>
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Sign In
            </button>
        </form>

        @if (Route::has('register'))
        <div class="divider">or</div>
        <div class="register-link">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
        @endif
    </div>

    <div class="back-home">
        <a href="{{ route('welcome.index') }}"><i class="fas fa-arrow-left"></i> Back to Home</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
