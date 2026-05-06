@extends('dashboard.layouts.master')

@section('css')
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Profile</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Account Settings</span>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row row-sm">

    <!-- LEFT SIDE (USER INFO) -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">

                <img class="rounded-circle mb-3"
                     src="{{ asset('assets/img/faces/6.jpg') }}"
                     width="120">

                <h5>{{ auth()->user()->name }}</h5>
                <p class="text-muted">{{ auth()->user()->email }}</p>

                <hr>

                <p class="text-muted">
                    Welcome to your profile dashboard. You can update your info here.
                </p>

            </div>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="col-lg-8">

        <div class="card">
            <div class="card-body">

                <!-- TABS -->
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#settings">Settings</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- SETTINGS TAB -->
                    <div class="tab-pane active" id="settings">

                        <!-- UPDATE PROFILE -->
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <h5 class="mb-3">Update Profile</h5>

                            <!-- Name -->
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', auth()->user()->name) }}"
                                       class="form-control">

                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', auth()->user()->email) }}"
                                       class="form-control">

                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button class="btn btn-primary mb-4">
                                Save Changes
                            </button>
                        </form>

                        <hr>

                        <!-- UPDATE PASSWORD -->
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <h5 class="mb-3">Change Password</h5>

                            <!-- Current -->
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" class="form-control">

                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- New -->
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control">

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm -->
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <button class="btn btn-warning mb-4">
                                Update Password
                            </button>
                        </form>

                        <hr>

                        <!-- DELETE ACCOUNT -->
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <h5 class="text-danger mb-3">Delete Account</h5>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password" class="form-control">

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button class="btn btn-danger">
                                Delete Account
                            </button>
                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

@endsection

@section('js')
@endsection
