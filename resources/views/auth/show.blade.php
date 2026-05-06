@extends('layouts.app')

@section('title', 'My Profile - Cental')

@push('styles')
<style>
    :root {
        --primary: #e32636;
        --primary-dark: #b71c1c;
    }

    .profile-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 60px 0 80px;
        position: relative;
        overflow: hidden;
    }
    .profile-hero::before {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(227,38,54,0.12) 0%, transparent 70%);
        top: -100px; right: -100px;
        border-radius: 50%;
    }
    .profile-hero::after {
        content: '\f5e4';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        font-size: 300px;
        color: rgba(255,255,255,0.02);
        bottom: -80px; left: -50px;
    }

    .profile-avatar-wrap {
        position: relative;
        display: inline-block;
    }
    .profile-avatar {
        width: 110px; height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex; align-items: center; justify-content: center;
        font-size: 42px;
        color: #fff;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        border: 4px solid rgba(255,255,255,0.1);
        box-shadow: 0 8px 32px rgba(227,38,54,0.3);
    }
    .profile-badge {
        position: absolute;
        bottom: 6px; right: 0;
        background: var(--primary);
        color: #fff;
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid #1a1a2e;
    }
    .profile-hero h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }
    .profile-hero p { color: rgba(255,255,255,0.5); font-size: 15px; }

    /* Stats row */
    .profile-stats {
        display: flex;
        gap: 32px;
        margin-top: 20px;
    }
    .stat-item { text-align: center; }
    .stat-item .num { font-family: 'Montserrat', sans-serif; font-size: 22px; font-weight: 700; color: #fff; }
    .stat-item .lbl { font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.5px; }

    /* Cards */
    .profile-card {
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        border: 1px solid #f0f0f0;
    }
    .card-header-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    .card-icon {
        width: 44px; height: 44px;
        background: rgba(227,38,54,0.08);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }
    .card-icon i { font-size: 18px; color: var(--primary); }
    .card-header-custom h5 {
        font-family: 'Montserrat', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    .card-header-custom p { font-size: 12px; color: #999; margin: 0; }

    /* Info rows */
    .info-row {
        display: flex;
        align-items: flex-start;
        padding: 14px 0;
        border-bottom: 1px solid #f8f8f8;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label {
        width: 180px;
        flex-shrink: 0;
        font-size: 13px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-label i { color: var(--primary); font-size: 12px; width: 16px; }
    .info-value {
        flex: 1;
        font-size: 15px;
        color: #333;
        font-weight: 500;
    }

    /* Role badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
        letter-spacing: 0.3px;
    }
    .role-customer { background: rgba(0,123,255,0.1); color: #0056b3; }
    .role-driver { background: rgba(40,167,69,0.1); color: #155724; }
    .role-employee { background: rgba(255,193,7,0.1); color: #856404; }
    .role-manager { background: rgba(227,38,54,0.1); color: var(--primary); }

    /* Edit button */
    .btn-edit-profile {
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 28px;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-edit-profile:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(227,38,54,0.3); color: #fff; }

    .btn-outline-danger-custom {
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 10px;
        padding: 9px 24px;
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-outline-danger-custom:hover { background: var(--primary); color: #fff; }

    /* Alert */
    .success-alert {
        background: rgba(40,167,69,0.08);
        border: 1px solid rgba(40,167,69,0.2);
        border-left: 4px solid #28a745;
        border-radius: 10px;
        padding: 14px 18px;
        color: #155724;
        font-size: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .profile-stats { gap: 20px; }
        .info-row { flex-direction: column; gap: 4px; }
        .info-label { width: auto; }
    }
</style>
@endpush

@section('content')

<!-- Profile Hero -->
<div class="profile-hero">
    <div class="container">
        <div class="d-flex flex-wrap align-items-end gap-4">
            <div class="profile-avatar-wrap">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="profile-badge">{{ Auth::user()->role ?? 'Customer' }}</span>
            </div>
            <div class="flex-grow-1">
                <h2>{{ Auth::user()->name }}</h2>
                <p><i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}</p>
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="num">{{ Auth::user()->rentals_count ?? 0 }}</div>
                        <div class="lbl">Rentals</div>
                    </div>
                    <div class="stat-item">
                        <div class="num">{{ Auth::user()->created_at->diffInDays(now()) }}</div>
                        <div class="lbl">Days Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="num">{{ Auth::user()->reviews_count ?? 0 }}</div>
                        <div class="lbl">Reviews</div>
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Profile Content -->
<div class="container" style="margin-top: -30px; position: relative; z-index: 10; padding-bottom: 60px;">

    @if (session('status') === 'profile-updated')
        <div class="success-alert">
            <i class="fas fa-check-circle text-success"></i>
            Your profile has been updated successfully.
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">

            <!-- Personal Info -->
            <div class="profile-card">
                <div class="card-header-custom">
                    <div class="card-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <h5>Personal Information</h5>
                        <p>Your account details and personal info</p>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label"><i class="fas fa-id-badge"></i> Full Name</div>
                    <div class="info-value">{{ Auth::user()->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                    <div class="info-value">{{ Auth::user()->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-phone"></i> Phone</div>
                    <div class="info-value">{{ Auth::user()->phone ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-map-marker-alt"></i> Address</div>
                    <div class="info-value">{{ Auth::user()->address ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-user-tag"></i> Role</div>
                    <div class="info-value">
                        @php $role = Auth::user()->role ?? 'customer'; @endphp
                        <span class="role-badge role-{{ $role }}">
                            @if($role === 'customer') <i class="fas fa-user"></i>
                            @elseif($role === 'driver') <i class="fas fa-id-card"></i>
                            @elseif($role === 'employee') <i class="fas fa-user-tie"></i>
                            @elseif($role === 'manager') <i class="fas fa-user-shield"></i>
                            @endif
                            {{ ucfirst($role) }}
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-calendar"></i> Member Since</div>
                    <div class="info-value">{{ Auth::user()->created_at->format('F d, Y') }}</div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="profile-card">
                <div class="card-header-custom">
                    <div class="card-icon"><i class="fas fa-cog"></i></div>
                    <div>
                        <h5>Account Actions</h5>
                        <p>Manage your account settings</p>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn-edit-profile justify-content-center">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                    <a href="{{ route('profile.edit') }}#password" class="btn-outline-danger-custom justify-content-center">
                        <i class="fas fa-lock"></i> Change Password
                    </a>
                    @if(Auth::user()->role === 'customer')
                    <a href="{{ route('welcome.vehicle') }}" class="btn-outline-danger-custom justify-content-center" style="border-color: #0056b3; color: #0056b3;">
                        <i class="fas fa-car"></i> Browse Cars
                    </a>
                    @endif
                </div>
            </div>

            <!-- Email Verification -->
            @if(Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
            <div class="profile-card" style="border-left: 4px solid #ffc107;">
                <div class="d-flex gap-3 align-items-start">
                    <i class="fas fa-exclamation-triangle text-warning mt-1"></i>
                    <div>
                        <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 14px; color: #333;">Email Not Verified</h6>
                        <p style="font-size: 13px; color: #666; margin-bottom: 12px;">Please verify your email address.</p>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" style="background: #ffc107; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 700; cursor: pointer;">
                                Resend Email
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Logout -->
            <div class="profile-card">
                <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 15px; color: #333; margin-bottom: 8px;">
                    <i class="fas fa-sign-out-alt me-2 text-danger"></i>Sign Out
                </h6>
                <p style="font-size: 13px; color: #999; margin-bottom: 16px;">Securely log out from your account.</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-outline-danger-custom w-100 justify-content-center">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
