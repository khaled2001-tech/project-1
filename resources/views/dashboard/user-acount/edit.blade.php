@extends('dashboard.layouts.master')

@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Account Manager</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit Account</span>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">

            {{-- Card Header --}}
            <div class="card-header bg-dark text-white d-flex align-items-center">
                <i class="fas fa-user-edit mr-2"></i>
                <h5 class="mb-0">Edit Account — <span class="font-weight-light">{{ $user->name }}</span></h5>
            </div>

            <div class="card-body p-4">

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Full Name --}}
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label font-weight-bold">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="Enter full name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label font-weight-bold">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="example@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Password --}}
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label font-weight-bold">
                                New Password
                            </label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Leave blank to keep current password">
                            <small class="text-muted">Leave blank if you don't want to change the password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label font-weight-bold">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('role') is-invalid @enderror"
                                    id="role"
                                    name="role"
                                    required>
                                <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="employee" {{ old('role', $user->role) === 'employee' ? 'selected' : '' }}>Employee</option>
                                <option value="manager"  {{ old('role', $user->role) === 'manager'  ? 'selected' : '' }}>Manager</option>
                                <option value="admin"    {{ old('role', $user->role) === 'admin'    ? 'selected' : '' }}>Admin</option>
                                <option value="driver"   {{ old('role', $user->role) === 'driver'   ? 'selected' : '' }}>Driver</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Status --}}
                        <div class="col-md-6 mb-4">
                            <label for="status" class="form-label font-weight-bold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('status') is-invalid @enderror"
                                    id="status"
                                    name="status"
                                    required>
                                <option value="active"  {{ old('status', $user->status) === 'active'  ? 'selected' : '' }}>Active</option>
                                <option value="blocked" {{ old('status', $user->status) === 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Current Status Badge --}}
                    <div class="mb-4">
                        <small class="text-muted">Current Status:</small>
                        @if($user->status === 'active')
                            <span class="badge badge-success ml-1">Active</span>
                        @else
                            <span class="badge badge-danger ml-1">
                                <i class="fas fa-ban mr-1"></i> Blocked
                            </span>
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-save mr-1"></i> Update Account
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
