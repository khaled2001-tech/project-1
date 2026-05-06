@extends('layouts.app')

@section('title', 'Edit Profile - Cental')

@push('styles')
<style>
    :root { --primary: #e32636; --primary-dark: #b71c1c; }

    .page-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 50px 0;
        position: relative;
        overflow: hidden;
    }
    .page-hero::after {
        content: '\f4d3';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        font-size: 200px;
        color: rgba(255,255,255,0.02);
        bottom: -50px; right: -30px;
    }
    .page-hero h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 30px; font-weight: 800;
        color: #fff; margin-bottom: 6px;
    }
    .page-hero p { color: rgba(255,255,255,0.5); font-size: 15px; }
    .breadcrumb-custom { display: flex; gap: 8px; align-items: center; margin-top: 12px; }
    .breadcrumb-custom a { color: var(--primary); font-size: 13px; text-decoration: none; }
    .breadcrumb-custom span { color: rgba(255,255,255,0.2); font-size: 13px; }
    .breadcrumb-custom .current { color: rgba(255,255,255,0.5); font-size: 13px; }

    .edit-section {
        padding: 50px 0;
        background: #f8f9fa;
    }

    .edit-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #eee;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .edit-card-header {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        padding: 20px 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .edit-card-header .hicon {
        width: 40px; height: 40px;
        background: rgba(227,38,54,0.2);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .edit-card-header .hicon i { color: var(--primary); font-size: 16px; }
    .edit-card-header h5 { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 16px; color: #fff; margin: 0; }
    .edit-card-header p { font-size: 12px; color: rgba(255,255,255,0.4); margin: 0; }
    .edit-card-body { padding: 28px; }

    .form-group-edit { margin-bottom: 22px; }
    .form-group-edit label {
        display: block;
        font-size: 12px; font-weight: 700;
        color: #777;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .form-group-edit label span { color: var(--primary); }

    .input-field {
        width: 100%;
        border: 1.5px solid #e8e8e8;
        border-radius: 10px;
        padding: 13px 16px;
        font-size: 15px;
        color: #333;
        transition: all 0.3s;
        outline: none;
        background: #fff;
        font-family: 'Lato', sans-serif;
    }
    .input-field:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(227,38,54,0.08);
    }
    .input-field::placeholder { color: #bbb; }
    .input-with-icon { position: relative; }
    .input-with-icon i {
        position: absolute;
        right: 14px; top: 50%;
        transform: translateY(-50%);
        color: #ccc;
        font-size: 14px;
    }
    .input-with-icon .input-field { padding-right: 42px; }

    .field-error { color: var(--primary); font-size: 12px; margin-top: 6px; display: flex; gap: 5px; align-items: center; }
    .field-error i { font-size: 11px; }

    .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width: 576px) { .form-row-2 { grid-template-columns: 1fr; } }

    /* Password strength */
    .password-strength { margin-top: 8px; }
    .strength-bar { height: 4px; background: #eee; border-radius: 2px; overflow: hidden; }
    .strength-fill { height: 100%; width: 0; border-radius: 2px; transition: all 0.4s; }
    .strength-text { font-size: 11px; margin-top: 4px; color: #999; }

    /* Buttons */
    .btn-save {
        background: var(--primary); color: #fff;
        border: none; border-radius: 10px;
        padding: 13px 32px;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px; font-weight: 700;
        cursor: pointer; transition: all 0.3s;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-save:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(227,38,54,0.35); }

    .btn-cancel {
        background: transparent;
        color: #666; border: 1.5px solid #ddd;
        border-radius: 10px;
        padding: 11px 28px;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px; font-weight: 700;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s; cursor: pointer;
    }
    .btn-cancel:hover { border-color: #999; color: #333; }

    /* Delete zone */
    .danger-zone {
        border: 1.5px solid rgba(227,38,54,0.2);
        border-radius: 12px;
        padding: 20px 24px;
        background: rgba(227,38,54,0.02);
    }
    .danger-zone h6 { font-family: 'Montserrat', sans-serif; font-weight: 700; color: var(--primary); margin-bottom: 6px; }
    .danger-zone p { font-size: 13px; color: #999; margin-bottom: 14px; }

    /* Alerts */
    .alert-success-custom {
        background: rgba(40,167,69,0.06);
        border: 1px solid rgba(40,167,69,0.2);
        border-left: 4px solid #28a745;
        border-radius: 10px;
        padding: 14px 18px;
        color: #155724;
        font-size: 14px;
        margin-bottom: 20px;
        display: flex; align-items: center; gap: 10px;
    }
    .alert-error-custom {
        background: rgba(227,38,54,0.06);
        border: 1px solid rgba(227,38,54,0.2);
        border-left: 4px solid var(--primary);
        border-radius: 10px;
        padding: 14px 18px;
        color: #721c24;
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Sidebar nav */
    .profile-nav { position: sticky; top: 80px; }
    .nav-item-custom {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 4px;
        text-decoration: none;
        color: #666;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .nav-item-custom i { width: 18px; text-align: center; }
    .nav-item-custom:hover { background: rgba(227,38,54,0.06); color: var(--primary); }
    .nav-item-custom.active { background: rgba(227,38,54,0.08); color: var(--primary); }
    .nav-item-custom.active i { color: var(--primary); }
</style>
@endpush

@section('content')

<div class="page-hero">
    <div class="container">
        <h1><i class="fas fa-user-edit me-3" style="color: var(--primary);"></i>Edit Profile</h1>
        <p>Update your personal information and security settings</p>
        <div class="breadcrumb-custom">
            <a href="{{ route('welcome.index') }}">Home</a>
            <span>/</span>
            <a href="{{ route('profile.edit') }}">Profile</a>
            <span>/</span>
            <span class="current">Edit</span>
        </div>
    </div>
</div>

<div class="edit-section">
    <div class="container">
        <div class="row g-4">

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="profile-nav">
                    <div class="edit-card" style="overflow: visible;">
                        <div class="edit-card-body" style="padding: 16px;">
                            <div style="text-align: center; padding: 16px 0 20px;">
                                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 26px; font-weight: 700; color: #fff; font-family: 'Montserrat', sans-serif;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div style="font-weight: 700; color: #333; font-size: 15px;">{{ Auth::user()->name }}</div>
                                <div style="font-size: 12px; color: #999;">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="#profile-info" class="nav-item-custom active">
                                <i class="fas fa-user"></i> Personal Info
                            </a>
                            <a href="#password-section" class="nav-item-custom">
                                <i class="fas fa-lock"></i> Password
                            </a>
                            <a href="#danger-section" class="nav-item-custom">
                                <i class="fas fa-trash-alt"></i> Delete Account
                            </a>
                            <hr style="margin: 10px 0; border-color: #f0f0f0;">
                            <a href="{{ route('profile.edit') }}" class="nav-item-custom" style="color: #999;">
                                <i class="fas fa-eye"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">

                @if (session('status') === 'profile-updated')
                    <div class="alert-success-custom">
                        <i class="fas fa-check-circle"></i> Profile updated successfully!
                    </div>
                @endif
                @if (session('status') === 'password-updated')
                    <div class="alert-success-custom">
                        <i class="fas fa-check-circle"></i> Password changed successfully!
                    </div>
                @endif

                <!-- Personal Info Form -->
                <div class="edit-card" id="profile-info">
                    <div class="edit-card-header">
                        <div class="hicon"><i class="fas fa-user"></i></div>
                        <div>
                            <h5>Personal Information</h5>
                            <p>Update your name, email and contact details</p>
                        </div>
                    </div>
                    <div class="edit-card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-row-2">
                                <div class="form-group-edit">
                                    <label>Full Name <span>*</span></label>
                                    <div class="input-with-icon">
                                        <input type="text" name="name" class="input-field"
                                               value="{{ old('name', $user->name) }}"
                                               placeholder="Your full name" required>
                                        <i class="fas fa-user"></i>
                                    </div>
                                    @error('name')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                                </div>
                                <div class="form-group-edit">
                                    <label>Phone Number</label>
                                    <div class="input-with-icon">
                                        <input type="tel" name="phone" class="input-field"
                                               value="{{ old('phone', $user->phone ?? '') }}"
                                               placeholder="+1 234 567 890">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    @error('phone')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="form-group-edit">
                                <label>Email Address <span>*</span></label>
                                <div class="input-with-icon">
                                    <input type="email" name="email" class="input-field"
                                           value="{{ old('email', $user->email) }}"
                                           placeholder="your@email.com" required>
                                    <i class="fas fa-envelope"></i>
                                </div>
                                @error('email')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                            </div>

                            <div class="form-group-edit">
                                <label>Address</label>
                                <div class="input-with-icon">
                                    <input type="text" name="address" class="input-field"
                                           value="{{ old('address', $user->address ?? '') }}"
                                           placeholder="123 Street, City, Country">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                @error('address')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                            </div>

                            <div class="d-flex gap-3 flex-wrap">
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                                <a href="{{ route('profile.edit') }}" class="btn-cancel">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Form -->
                <div class="edit-card" id="password-section">
                    <div class="edit-card-header">
                        <div class="hicon"><i class="fas fa-lock"></i></div>
                        <div>
                            <h5>Change Password</h5>
                            <p>Use a strong, unique password for your account</p>
                        </div>
                    </div>
                    <div class="edit-card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group-edit">
                                <label>Current Password <span>*</span></label>
                                <div class="input-with-icon">
                                    <input type="password" name="current_password" class="input-field" placeholder="Your current password">
                                    <i class="fas fa-key"></i>
                                </div>
                                @error('current_password', 'updatePassword')
                                    <p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-row-2">
                                <div class="form-group-edit">
                                    <label>New Password <span>*</span></label>
                                    <div class="input-with-icon">
                                        <input type="password" name="password" id="newPassword" class="input-field" placeholder="Min. 8 characters">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="password-strength">
                                        <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                                        <div class="strength-text" id="strengthText">Enter a password</div>
                                    </div>
                                    @error('password', 'updatePassword')
                                        <p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group-edit">
                                    <label>Confirm New Password <span>*</span></label>
                                    <div class="input-with-icon">
                                        <input type="password" name="password_confirmation" class="input-field" placeholder="Repeat new password">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-save">
                                <i class="fas fa-shield-alt"></i> Update Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="edit-card" id="danger-section">
                    <div class="edit-card-header" style="background: linear-gradient(135deg, #2d0a0a, #1a0505);">
                        <div class="hicon" style="background: rgba(227,38,54,0.3);"><i class="fas fa-exclamation-triangle"></i></div>
                        <div>
                            <h5>Danger Zone</h5>
                            <p>Irreversible and destructive actions</p>
                        </div>
                    </div>
                    <div class="edit-card-body">
                        <div class="danger-zone">
                            <h6><i class="fas fa-trash-alt me-2"></i>Delete Account</h6>
                            <p>Once you delete your account, all data will be permanently removed. This action cannot be undone.</p>
                            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you absolutely sure? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <div class="form-group-edit" style="max-width: 320px; margin-bottom: 14px;">
                                    <label>Confirm with Password</label>
                                    <input type="password" name="password" class="input-field" placeholder="Enter your password to confirm">
                                    @error('password', 'userDeletion')
                                        <p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn-save" style="background: #8b0000;">
                                    <i class="fas fa-trash-alt"></i> Delete My Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Password strength indicator
document.getElementById('newPassword')?.addEventListener('input', function() {
    const val = this.value;
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;
    const colors = ['', '#e32636', '#ff9800', '#2196f3', '#28a745'];
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    fill.style.width = (strength * 25) + '%';
    fill.style.background = colors[strength];
    text.textContent = val ? labels[strength] : 'Enter a password';
    text.style.color = colors[strength] || '#999';
});

// Smooth scroll for nav links
document.querySelectorAll('.nav-item-custom[href^="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>
@endpush
