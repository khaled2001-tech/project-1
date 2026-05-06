<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register - Cental Car Rental</title>
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
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Lato', sans-serif;
            background: var(--darker);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }
        .bg-animated {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            z-index: 0;
        }
        .bg-animated::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(227,38,54,0.12) 0%, transparent 70%);
            top: -150px; right: -150px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }
        .bg-animated::after {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(227,38,54,0.06) 0%, transparent 70%);
            bottom: -80px; left: -80px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite reverse;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        .car-deco {
            position: fixed;
            bottom: -20px; right: -30px;
            font-size: 250px;
            color: rgba(227,38,54,0.04);
            z-index: 0;
        }
        .register-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
        }
        .brand-logo {
            text-align: center;
            margin-bottom: 28px;
            animation: fadeDown 0.6s ease;
        }
        .brand-logo a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }
        .brand-logo i { font-size: 32px; color: var(--primary); filter: drop-shadow(0 0 12px rgba(227,38,54,0.5)); }
        .brand-logo span { font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 900; color: #fff; letter-spacing: -1px; }
        .brand-logo span em { color: var(--primary); font-style: normal; }

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
            font-size: 24px;
            color: #fff;
            margin-bottom: 4px;
        }
        .auth-card p.subtitle {
            color: rgba(255,255,255,0.4);
            font-size: 14px;
            margin-bottom: 28px;
        }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media(max-width: 500px) { .form-row { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            color: rgba(255,255,255,0.7);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 13px;
            transition: color 0.3s;
            pointer-events: none;
        }
        .input-wrap input, .input-wrap select {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 13px 14px 13px 40px;
            color: #fff;
            font-size: 14px;
            transition: all 0.3s;
            outline: none;
            font-family: 'Lato', sans-serif;
        }
        .input-wrap select { appearance: none; cursor: pointer; }
        .input-wrap select option { background: #1a1a2e; color: #fff; }
        .input-wrap input:focus, .input-wrap select:focus {
            border-color: var(--primary);
            background: rgba(227,38,54,0.05);
            box-shadow: 0 0 0 3px rgba(227,38,54,0.1);
        }
        .input-wrap input::placeholder { color: rgba(255,255,255,0.2); }

        /* Role selector */
        .role-selector {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .role-option input[type="radio"] { display: none; }
        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 14px 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: none;
            letter-spacing: 0;
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
        }
        .role-option label i { font-size: 20px; color: rgba(255,255,255,0.3); transition: color 0.3s; }
        .role-option input:checked + label {
            background: rgba(227,38,54,0.12);
            border-color: var(--primary);
            color: #fff;
        }
        .role-option input:checked + label i { color: var(--primary); }
        .role-option label:hover { border-color: rgba(227,38,54,0.4); color: rgba(255,255,255,0.8); }

        .role-label {
            color: rgba(255,255,255,0.7);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .btn-register {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 4px;
        }
        .btn-register:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(227,38,54,0.4); }

        .divider {
            text-align: center;
            margin: 20px 0;
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

        .login-link { text-align: center; color: rgba(255,255,255,0.4); font-size: 14px; }
        .login-link a { color: var(--primary); font-weight: 700; text-decoration: none; }

        .back-home { text-align: center; margin-top: 18px; }
        .back-home a { color: rgba(255,255,255,0.3); font-size: 13px; text-decoration: none; transition: color 0.2s; }
        .back-home a:hover { color: rgba(255,255,255,0.6); }

        .field-error { color: #ff6b7a; font-size: 12px; margin-top: 5px; }

        @keyframes fadeDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<div class="bg-animated"></div>
<div class="car-deco"><i class="fas fa-car-alt"></i></div>

<div class="register-wrapper">
    <div class="brand-logo">
        <a href="{{ route('welcome.index') }}">
            <i class="fas fa-car-alt"></i>
            <span>Cen<em>tal</em></span>
        </a>
    </div>

    <div class="auth-card">
        <h2>Create Account</h2>
        <p class="subtitle">Join Cental and start renting today</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Role Selection -->
            <div class="mb-3">
                <div class="role-label">I am a:</div>
                <div class="role-selector">
                    <div class="role-option">
                        <input type="radio" name="role" id="role_customer" value="customer" {{ old('role', 'customer') == 'customer' ? 'checked' : '' }}>
                        <label for="role_customer">
                            <i class="fas fa-user"></i>
                            Customer
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" id="role_driver" value="driver" {{ old('role') == 'driver' ? 'checked' : '' }}>
                        <label for="role_driver">
                            <i class="fas fa-id-card"></i>
                            Driver
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" id="role_employee" value="employee" {{ old('role') == 'employee' ? 'checked' : '' }}>
                        <label for="role_employee">
                            <i class="fas fa-user-tie"></i>
                            Employee
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" id="role_manager" value="manager" {{ old('role') == 'manager' ? 'checked' : '' }}>
                        <label for="role_manager">
                            <i class="fas fa-user-shield"></i>
                            Manager
                        </label>
                    </div>
                </div>
                @error('role')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                    </div>
                    @error('first_name')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                    </div>
                    @error('last_name')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <div class="input-wrap">
                    <i class="fas fa-signature"></i>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                </div>
                @error('name')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required autocomplete="email">
                </div>
                @error('email')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Min. 8 chars" required autocomplete="new-password">
                    </div>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Repeat password" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <div class="input-wrap">
                    <i class="fas fa-phone"></i>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+1 234 567 890">
                </div>
                @error('phone')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus me-2"></i> Create Account
            </button>
        </form>

        <div class="divider">or</div>
        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>

    <div class="back-home">
        <a href="{{ route('welcome.index') }}"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
