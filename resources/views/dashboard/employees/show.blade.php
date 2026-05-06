@extends('dashboard.layouts.master')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Drivers</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Driver Profile</span>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- Flash Toast --}}
@if(session('success'))
    <div data-toast="success" style="display:none">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div data-toast="danger" style="display:none">{{ session('error') }}</div>
@endif

<div class="row">

    {{-- ── LEFT: Profile Card ── --}}
    <div class="col-md-4 col-lg-3 mb-4">
        <div class="card shadow-sm text-center">
            <div class="card-body pt-4 pb-3">

                @if($employees->photo)
                    <img src="{{ asset('storage/' . $employees->photo) }}"
                         alt="{{ $employees->name }}"
                         class="rounded-circle mb-3 border"
                         width="100" height="100"
                         style="object-fit:cover;">
                @else
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center
                                justify-content-center mb-3 mx-auto"
                         style="width:100px;height:100px;">
                        <span class="text-white font-weight-bold" style="font-size:2.2rem;">
                            {{ strtoupper(substr($employees->name ?? 'D', 0, 1)) }}
                        </span>
                    </div>
                @endif

                <h5 class="mb-1 font-weight-bold">{{ $employees->name ?? '—' }}</h5>
                <p class="text-muted mb-2">Driver</p>

                @if($employees->status)
                    <span class="badge badge-success px-3 py-1">Active</span>
                @else
                    <span class="badge badge-danger px-3 py-1">Inactive</span>
                @endif

                <hr>

                <p class="mb-1 text-muted small">
                    <i class="fas fa-{{ $employees->gender ? 'male' : 'female' }} mr-1"></i>
                    {{ $employees->gender ? 'Male' : 'Female' }}
                </p>
                <p class="mb-1 text-muted small">
                    <i class="fas fa-envelope mr-1"></i>
                    {{ $employees->email ?? '—' }}
                </p>

                <hr>

                {{-- Delete button فقط، التعديل من modal بالـ index --}}
                <button class="btn btn-danger btn-sm btn-block"
                    data-toggle="modal" data-target="#deleteModal">
                    <i class="fas fa-trash mr-1"></i> Delete Driver
                </button>

                <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-sm btn-block mt-2">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Details ── --}}
    <div class="col-md-8 col-lg-9">

        {{-- Personal Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-id-card mr-2 text-primary"></i>Personal Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <p class="text-muted small mb-1">Full Name</p>
                        <p class="mb-0 font-weight-bold">{{ $employees->name ?? '—' }}</p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <p class="text-muted small mb-1">Email Address</p>
                        <p class="mb-0">{{ $employees->email ?? '—' }}</p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <p class="text-muted small mb-1">Date of Birth</p>
                        <p class="mb-0">
                            @if($employees->birthdate)
                                {{ \Carbon\Carbon::parse($employees->birthdate)->format('d M Y') }}
                                <small class="text-muted">
                                    ({{ \Carbon\Carbon::parse($employees->birthdate)->age }} yrs)
                                </small>
                            @else
                                —
                            @endif
                        </p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <p class="text-muted small mb-1">Gender</p>
                        <p class="mb-0">{{ $employees->gender ? 'Male' : 'Female' }}</p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <p class="text-muted small mb-1">Status</p>
                        @if($employees->status)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Compensation --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-dollar-sign mr-2 text-success"></i>Compensation
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <p class="text-muted small mb-1">Salary</p>
                        <p class="mb-0 font-weight-bold text-success" style="font-size:1.3rem;">
                            ${{ number_format($employees->salary ?? 0, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delivery Stats --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-truck mr-2 text-warning"></i>Delivery Statistics
                </h5>
            </div>
            {{-- <div class="card-body">
                <div class="row text-center">
                    <div class="col-3">
                        <div class="p-3 rounded bg-light">
                            <h4 class="mb-1 font-weight-bold">{{ $stats['total'] ?? 0 }}</h4>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-3 rounded" style="background:#fff3cd;">
                            <h4 class="mb-1 font-weight-bold text-warning">{{ $stats['pending'] ?? 0 }}</h4>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-3 rounded" style="background:#d1ecf1;">
                            <h4 class="mb-1 font-weight-bold text-info">{{ $stats['accepted'] ?? 0 }}</h4>
                            <small class="text-muted">Accepted</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-3 rounded" style="background:#d4edda;">
                            <h4 class="mb-1 font-weight-bold text-success">{{ $stats['delivered'] ?? 0 }}</h4>
                            <small class="text-muted">Delivered</small>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        {{-- Record Meta --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clock mr-2 text-secondary"></i>Record Info
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-muted small mb-1">Created At</p>
                        <p class="mb-0">{{ $employees->created_at ? $employees->created_at->format('d M Y, h:i A') : '—' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-muted small mb-1">Last Updated</p>
                        <p class="mb-0">{{ $employees->updated_at ? $employees->updated_at->format('d M Y, h:i A') : '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


{{-- ════════════════ DELETE MODAL ════════════════ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Driver</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('drivers.destroy', $employees->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $employees->name }}</strong>?</p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ URL::asset('assets/js/flash-toast.js') }}"></script>
@endsection
