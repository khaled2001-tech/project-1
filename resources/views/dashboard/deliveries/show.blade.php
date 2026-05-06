@extends('dashboard.layouts.master')

@section('title', 'Delivery #' . str_pad($delivery->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="row row-sm">

    {{-- Back Button --}}
    {{-- <div class="col-12 mb-3">
        <a href="{{ route('driver.deliveries.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Deliveries
        </a>
    </div> --}}

    {{-- ── Status Banner ── --}}
    @php
        $statusConfig = [
            'pending'     => ['bg' => 'warning',  'text' => 'dark',  'icon' => 'clock',          'label' => 'Pending — Waiting for driver to accept'],
            'accepted'    => ['bg' => 'info',     'text' => 'white', 'icon' => 'check-circle',    'label' => 'Accepted — Driver is preparing'],
            'in_progress' => ['bg' => 'primary',  'text' => 'white', 'icon' => 'truck',           'label' => 'In Progress — Car is on the way'],
            'delivered'   => ['bg' => 'success',  'text' => 'white', 'icon' => 'flag-checkered',  'label' => 'Delivered — Completed successfully'],
            'rejected'    => ['bg' => 'danger',   'text' => 'white', 'icon' => 'times-circle',    'label' => 'Rejected — Needs reassignment'],
        ];
        $sc = $statusConfig[$delivery->status] ?? ['bg'=>'secondary','text'=>'white','icon'=>'question','label'=>ucfirst($delivery->status)];
    @endphp

    <div class="col-12 mb-4">
        <div class="alert alert-{{ $sc['bg'] }} text-{{ $sc['text'] }} d-flex align-items-center mb-0 py-3">
            <i class="fas fa-{{ $sc['icon'] }} fa-lg me-3"></i>
            <div>
                <strong>Delivery #{{ str_pad($delivery->id, 6, '0', STR_PAD_LEFT) }}</strong>
                — {{ $sc['label'] }}
            </div>
            @if($delivery->status === 'rejected')
                <button type="button" class="btn btn-danger btn-sm ms-auto"
                        data-bs-toggle="modal" data-bs-target="#reassignModal">
                    <i class="fas fa-redo me-1"></i> Reassign Driver
                </button>
            @endif
        </div>
    </div>

    {{-- ── Left Column ── --}}
    <div class="col-lg-8">

        {{-- Reservation Info --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-calendar-check text-primary"></i>
                <h6 class="mb-0 fw-bold">Reservation Details</h6>
                <a href="{{ route('reservations.show', $delivery->reservation_id) }}"
                   class="ms-auto btn btn-sm btn-outline-primary">
                    View Reservation
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Reservation ID</small>
                        <strong>#{{ str_pad($delivery->reservation_id, 6, '0', STR_PAD_LEFT) }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Reservation Status</small>
                        <span class="badge bg-{{ $delivery->reservation->status === 'approved' ? 'success' : 'secondary' }}">
                            {{ ucfirst($delivery->reservation->status) }}
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Pickup Date</small>
                        <strong>{{ $delivery->reservation->pickup_date?->format('M d, Y H:i') ?? '—' }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Return Date</small>
                        <strong>{{ $delivery->reservation->return_date?->format('M d, Y H:i') ?? '—' }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Rental Days</small>
                        <strong>{{ $delivery->reservation->rental_days ?? '—' }} days</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Total Price</small>
                        <strong class="text-success">${{ number_format($delivery->reservation->total_price ?? 0, 2) }}</strong>
                    </div>
                    @if($delivery->reservation->notes)
                    <div class="col-12">
                        <small class="text-muted d-block mb-1">Notes</small>
                        <p class="mb-0 small">{{ $delivery->reservation->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Car Info --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-car text-warning"></i>
                <h6 class="mb-0 fw-bold">Car Details</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Brand</small>
                        <strong>{{ $delivery->reservation->car->brand->name ?? '—' }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Model</small>
                        <strong>{{ $delivery->reservation->car->name ?? '—' }}</strong>
                    </div>
                    @if($delivery->reservation->car->plate_number ?? false)
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Plate Number</small>
                        <strong>{{ $delivery->reservation->car->plate_number }}</strong>
                    </div>
                    @endif
                    @if($delivery->reservation->car->color ?? false)
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Color</small>
                        <strong>{{ $delivery->reservation->car->color }}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Delivery Info --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-map-marker-alt text-danger"></i>
                <h6 class="mb-0 fw-bold">Delivery Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <small class="text-muted d-block mb-1">Delivery Address</small>
                        <strong>{{ $delivery->delivery_address ?: '—' }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Assigned At</small>
                        <strong>{{ $delivery->created_at->format('M d, Y H:i') }}</strong>
                    </div>
                    @if($delivery->accepted_at)
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Accepted At</small>
                        <strong>{{ \Carbon\Carbon::parse($delivery->accepted_at)->format('M d, Y H:i') }}</strong>
                    </div>
                    @endif
                    @if($delivery->delivered_at)
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Delivered At</small>
                        <strong class="text-success">{{ \Carbon\Carbon::parse($delivery->delivered_at)->format('M d, Y H:i') }}</strong>
                    </div>
                    @endif
                    @if($delivery->driver_notes)
                    <div class="col-12">
                        <small class="text-muted d-block mb-1">Driver Notes</small>
                        <div class="alert alert-light border mb-0 small">
                            <i class="fas fa-comment me-1 text-muted"></i>
                            {{ $delivery->driver_notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ── Right Column ── --}}
    <div class="col-lg-4">

        {{-- Customer Card --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-user text-info"></i>
                <h6 class="mb-0 fw-bold">Customer</h6>
            </div>
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold mx-auto mb-3"
                     style="width:60px;height:60px;font-size:22px">
                    {{ strtoupper(substr($delivery->reservation->customer->name ?? '?', 0, 1)) }}
                </div>
                <h6 class="fw-bold mb-1">{{ $delivery->reservation->customer->name ?? 'N/A' }}</h6>
                @if($delivery->reservation->customer->email ?? false)
                    <p class="text-muted small mb-1">
                        <i class="fas fa-envelope me-1"></i>{{ $delivery->reservation->customer->email }}
                    </p>
                @endif
                @if($delivery->reservation->customer->phone ?? false)
                    <p class="text-muted small mb-0">
                        <i class="fas fa-phone me-1"></i>{{ $delivery->reservation->customer->phone }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Driver Card --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-id-badge text-warning"></i>
                <h6 class="mb-0 fw-bold">Assigned Driver</h6>
            </div>
            <div class="card-body text-center">
                @if($delivery->driver)
                    <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold mx-auto mb-3"
                         style="width:60px;height:60px;font-size:22px">
                        {{ strtoupper(substr($delivery->driver->name, 0, 1)) }}
                    </div>
                    <h6 class="fw-bold mb-1">{{ $delivery->driver->name }}</h6>
                    @if($delivery->driver->phone ?? false)
                        <p class="text-muted small mb-1">
                            <i class="fas fa-phone me-1"></i>{{ $delivery->driver->phone }}
                        </p>
                    @endif
                    @if($delivery->driver->license_number ?? false)
                        <p class="text-muted small mb-0">
                            <i class="fas fa-id-card me-1"></i>{{ $delivery->driver->license_number }}
                        </p>
                    @endif
                @else
                    <p class="text-muted">No driver assigned</p>
                @endif
            </div>
        </div>

        {{-- Assigned By --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-user-tie text-secondary"></i>
                <h6 class="mb-0 fw-bold">Assigned By</h6>
            </div>
            <div class="card-body">
                <p class="mb-0 fw-semibold">
                    {{ $delivery->assignedBy->name ?? 'N/A' }}
                </p>
                <small class="text-muted">{{ $delivery->created_at->format('M d, Y H:i') }}</small>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-history text-primary"></i>
                <h6 class="mb-0 fw-bold">Timeline</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0" style="border-left:2px solid #dee2e6;padding-left:16px">
                    <li class="mb-3 position-relative">
                        <div class="position-absolute bg-secondary rounded-circle"
                             style="width:10px;height:10px;left:-21px;top:4px"></div>
                        <small class="text-muted d-block">{{ $delivery->created_at->format('M d, Y H:i') }}</small>
                        <span class="fw-semibold small">Delivery assigned</span>
                    </li>
                    @if($delivery->accepted_at)
                    <li class="mb-3 position-relative">
                        <div class="position-absolute bg-info rounded-circle"
                             style="width:10px;height:10px;left:-21px;top:4px"></div>
                        <small class="text-muted d-block">{{ \Carbon\Carbon::parse($delivery->accepted_at)->format('M d, Y H:i') }}</small>
                        <span class="fw-semibold small">Driver accepted</span>
                    </li>
                    @endif
                    @if($delivery->status === 'in_progress')
                    <li class="mb-3 position-relative">
                        <div class="position-absolute bg-primary rounded-circle"
                             style="width:10px;height:10px;left:-21px;top:4px"></div>
                        <small class="text-muted d-block">In progress</small>
                        <span class="fw-semibold small">Car is being delivered</span>
                    </li>
                    @endif
                    @if($delivery->delivered_at)
                    <li class="mb-3 position-relative">
                        <div class="position-absolute bg-success rounded-circle"
                             style="width:10px;height:10px;left:-21px;top:4px"></div>
                        <small class="text-muted d-block">{{ \Carbon\Carbon::parse($delivery->delivered_at)->format('M d, Y H:i') }}</small>
                        <span class="fw-semibold small text-success">Delivered successfully</span>
                    </li>
                    @endif
                    @if($delivery->status === 'rejected')
                    <li class="position-relative">
                        <div class="position-absolute bg-danger rounded-circle"
                             style="width:10px;height:10px;left:-21px;top:4px"></div>
                        <small class="text-muted d-block">Rejected</small>
                        <span class="fw-semibold small text-danger">Driver rejected the request</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
</div>

{{-- ── Reassign Modal ── --}}
@if($delivery->status === 'rejected')
<div class="modal fade" id="reassignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-redo me-2"></i>Reassign Driver
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('deliveries.reassign', $delivery->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-danger py-2 small mb-3">
                        <strong>{{ $delivery->driver->name ?? 'Driver' }}</strong> rejected this delivery.
                        @if($delivery->driver_notes)
                            <br>Reason: "{{ $delivery->driver_notes }}"
                        @endif
                    </div>
                    <label class="form-label fw-semibold">Select New Driver <span class="text-danger">*</span></label>
                    <select name="driver_id" class="form-select" required>
                        <option value="">-- Select Driver --</option>
                        @foreach(\App\Models\Driver::where('status', true)->get() as $drv)
                            <option value="{{ $drv->id }}">
                                {{ $drv->name }}@if($drv->phone) — {{ $drv->phone }}@endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fas fa-paper-plane me-1"></i> Reassign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
