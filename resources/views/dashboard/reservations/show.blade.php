@extends('back.empty')

@section('title', 'Reservation Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i>Reservation Details
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Information Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Reservation Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Reservation ID</label>
                            <p class="fw-bold">#{{ $reservation->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Date & Time</label>
                            <p class="fw-bold">
                                <i class="fas fa-calendar me-2"></i>
                                {{ \Carbon\Carbon::parse($reservation->name)->format('F d, Y - h:i A') }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Status</label>
                            <p>
                                @if($reservation->status)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Created At</label>
                            <p>{{ $reservation->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="text-muted small">Notes</label>
                            <div class="p-3 bg-light rounded">
                                {{ $reservation->notes ?: 'No notes available' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-car me-2"></i>Vehicle Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted small">Brand</label>
                            <p class="fw-bold">
                                {{ $reservation->brand->name ?? 'Not Specified' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Model</label>
                            <p class="fw-bold">
                                {{ $reservation->model->name ?? 'Not Specified' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Car</label>
                            <p class="fw-bold">
                                @if($reservation->car)
                                    <span class="badge bg-info">
                                        {{ $reservation->car->plate_number ?? $reservation->car->name }}
                                    </span>
                                @else
                                    Not Assigned
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($reservation->car)
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Car Details:</strong>
                            @if(isset($reservation->car->color))
                                Color: {{ $reservation->car->color }} |
                            @endif
                            @if(isset($reservation->car->year))
                                Year: {{ $reservation->car->year }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Customer Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                </div>
                <div class="card-body">
                    @if($reservation->customer)
                        <div class="text-center mb-3">
                            <div class="avatar-circle bg-success text-white mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px;">
                                {{ strtoupper(substr($reservation->customer->name, 0, 1)) }}
                            </div>
                            <h5 class="mb-1">{{ $reservation->customer->name }}</h5>
                        </div>

                        <ul class="list-unstyled mb-0">
                            @if(isset($reservation->customer->phone))
                                <li class="mb-2">
                                    <i class="fas fa-phone text-muted me-2"></i>
                                    <a href="tel:{{ $reservation->customer->phone }}">{{ $reservation->customer->phone }}</a>
                                </li>
                            @endif
                            @if(isset($reservation->customer->email))
                                <li class="mb-2">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <a href="mailto:{{ $reservation->customer->email }}">{{ $reservation->customer->email }}</a>
                                </li>
                            @endif
                            @if(isset($reservation->customer->address))
                                <li class="mb-2">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    {{ $reservation->customer->address }}
                                </li>
                            @endif
                        </ul>
                    @else
                        <p class="text-muted text-center">No customer assigned</p>
                    @endif
                </div>
            </div>

            <!-- Approval Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-user-check me-2"></i>Approval Status</h5>
                </div>
                <div class="card-body">
                    @if($reservation->employee)
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle bg-warning me-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                {{ strtoupper(substr($reservation->employee->name, 0, 1)) }}
                            </div>
                            <div>
                                <label class="text-muted small mb-0">Approved By</label>
                                <p class="fw-bold mb-0">{{ $reservation->employee->name }}</p>
                                @if(isset($reservation->employee->position))
                                    <small class="text-muted">{{ $reservation->employee->position }}</small>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fas fa-clock fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Pending Approval</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete Reservation
                        </button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list me-2"></i>All Reservations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this reservation?</p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
