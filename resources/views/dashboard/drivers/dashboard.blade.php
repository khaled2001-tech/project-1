@extends('dashboard.layouts.master')

@section('title', 'My Deliveries')
@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"></h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Driver List</span>
        </div>
    </div>
</div>
@endsection

{{-- Flash Toast --}}
@if(session('success'))
    <div data-toast="success" style="display:none">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div data-toast="danger" style="display:none">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div data-toast="danger" style="display:none">{{ implode(' | ', $errors->all()) }}</div>
@endif
@section('content')
<div class="row row-sm">

    {{-- ── Header ── --}}
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-1">My Deliveries</h4>
        <p class="text-muted mb-0 small">Manage your assigned car deliveries</p>
    </div>

    {{-- ── Stats Cards ── --}}
    <div class="col-6 col-md-3 mb-4">
        <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body py-4">
                <div class="mb-2">
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
                <h2 class="fw-bold mb-0">{{ $pendingCount }}</h2>
                <small class="text-muted">Pending</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-4">
        <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body py-4">
                <div class="mb-2">
                    <i class="fas fa-check-circle fa-2x text-info"></i>
                </div>
                <h2 class="fw-bold mb-0">{{ $acceptedCount }}</h2>
                <small class="text-muted">Accepted</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-4">
        <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body py-4">
                <div class="mb-2">
                    <i class="fas fa-truck fa-2x text-primary"></i>
                </div>
                <h2 class="fw-bold mb-0">{{ $inProgressCount }}</h2>
                <small class="text-muted">In Progress</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-4">
        <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body py-4">
                <div class="mb-2">
                    <i class="fas fa-flag-checkered fa-2x text-success"></i>
                </div>
                <h2 class="fw-bold mb-0">{{ $deliveredCount }}</h2>
                <small class="text-muted">Delivered</small>
            </div>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- ── Pending Deliveries (action required) ── --}}
    @php $pendingDeliveries = $deliveries->where('status', 'pending'); @endphp
    @if($pendingDeliveries->count())
    <div class="col-12 mb-4">
        <div class="card border-warning border-2">
            <div class="card-header bg-warning bg-opacity-10 d-flex align-items-center gap-2">
                <i class="fas fa-bell text-warning"></i>
                <h6 class="mb-0 fw-bold text-warning">Action Required — New Requests ({{ $pendingDeliveries->count() }})</h6>
            </div>
            <div class="card-body p-0">
                @foreach($pendingDeliveries as $delivery)
                <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="row align-items-center g-3">

                        {{-- Car + Customer Info --}}
                        <div class="col-md-5">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                     style="width:48px;height:48px;font-size:18px">
                                    <i class="fas fa-car" style="font-size:18px"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">
                                        {{ $delivery->reservation->car->brand->name ?? '' }}
                                        {{ $delivery->reservation->car->name ?? 'N/A' }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $delivery->reservation->customer->name ?? 'N/A' }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-3">
                            <small class="text-muted d-block">Delivery Address</small>
                            <span class="small fw-semibold">{{ $delivery->delivery_address ?: '—' }}</span>
                        </div>

                        {{-- Assigned date --}}
                        <div class="col-md-2">
                            <small class="text-muted d-block">Assigned</small>
                            <span class="small">{{ $delivery->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- Actions --}}
                        <div class="col-md-2 d-flex gap-2 justify-content-md-end">
                            {{-- Accept --}}
                            <form action="{{ route('driver.delivery.accept', $delivery->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('Accept this delivery?')">
                                    <i class="fas fa-check me-1"></i> Accept
                                </button>
                            </form>
                            {{-- Reject --}}
                            <button type="button" class="btn btn-outline-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal{{ $delivery->id }}">
                                <i class="fas fa-times me-1"></i> Reject
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Reject Modal --}}
                <div class="modal fade" id="rejectModal{{ $delivery->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title fw-bold">
                                    <i class="fas fa-times-circle me-2"></i>Reject Delivery
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('driver.delivery.reject', $delivery->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <p class="text-muted small">
                                        Reject delivery for
                                        <strong>{{ $delivery->reservation->car->name ?? 'this car' }}</strong>?
                                        The employee will be notified to reassign.
                                    </p>
                                    <label class="form-label fw-semibold small">Reason (optional)</label>
                                    <textarea name="driver_notes" class="form-control form-control-sm"
                                              rows="3" placeholder="Explain why you're rejecting..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times me-1"></i> Confirm Reject
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ── Active Deliveries (accepted / in_progress) ── --}}
    @php $activeDeliveries = $deliveries->whereIn('status', ['accepted','in_progress']); @endphp
    @if($activeDeliveries->count())
    <div class="col-12 mb-4">
        <div class="card border-primary border-2">
            <div class="card-header bg-primary bg-opacity-10 d-flex align-items-center gap-2">
                <i class="fas fa-truck text-primary"></i>
                <h6 class="mb-0 fw-bold text-primary">Active Deliveries ({{ $activeDeliveries->count() }})</h6>
            </div>
            <div class="card-body p-0">
                @foreach($activeDeliveries as $delivery)
                <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="row align-items-center g-3">

                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                     style="width:44px;height:44px;font-size:16px">
                                    <i class="fas fa-car"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">
                                        {{ $delivery->reservation->car->brand->name ?? '' }}
                                        {{ $delivery->reservation->car->name ?? 'N/A' }}
                                    </h6>
                                    <small class="text-muted">{{ $delivery->reservation->customer->name ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted d-block">Address</small>
                            <span class="small fw-semibold">{{ $delivery->delivery_address ?: '—' }}</span>
                        </div>

                        <div class="col-md-2">
                            <span class="badge bg-{{ $delivery->status === 'in_progress' ? 'primary' : 'info' }} px-2 py-1">
                                <i class="fas fa-{{ $delivery->status === 'in_progress' ? 'truck' : 'check' }} me-1"></i>
                                {{ $delivery->status === 'in_progress' ? 'In Progress' : 'Accepted' }}
                            </span>
                        </div>

                        <div class="col-md-3 d-flex gap-2 justify-content-md-end flex-wrap">
                            @if($delivery->status === 'accepted')
                                <form action="{{ route('driver.delivery.start', $delivery->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm"
                                            onclick="return confirm('Start this delivery?')">
                                        <i class="fas fa-play me-1"></i> Start
                                    </button>
                                </form>
                            @endif

                            {{-- Mark Delivered --}}
                            <button type="button" class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deliveredModal{{ $delivery->id }}">
                                <i class="fas fa-flag-checkered me-1"></i> Mark Delivered
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Mark Delivered Modal --}}
                <div class="modal fade" id="deliveredModal{{ $delivery->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title fw-bold">
                                    <i class="fas fa-flag-checkered me-2"></i>Confirm Delivery
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('driver.delivery.delivered', $delivery->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="modal-body">
                                    <p class="text-muted small">
                                        Confirm delivery of
                                        <strong>{{ $delivery->reservation->car->name ?? 'this car' }}</strong>
                                        to <strong>{{ $delivery->reservation->customer->name ?? 'customer' }}</strong>?
                                        This will mark the reservation as completed.
                                    </p>
                                    <label class="form-label fw-semibold small">Notes (optional)</label>
                                    <textarea name="driver_notes" class="form-control form-control-sm"
                                              rows="2" placeholder="Any delivery notes..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check me-1"></i> Confirm Delivered
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ── History (delivered / rejected) ── --}}
    @php $historyDeliveries = $deliveries->whereIn('status', ['delivered','rejected']); @endphp
    @if($historyDeliveries->count())
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fas fa-history text-secondary"></i>
                <h6 class="mb-0 fw-bold">History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Car</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Date</th>
                                @if($historyDeliveries->where('driver_notes','!=',null)->count())
                                    <th>Notes</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyDeliveries as $delivery)
                            <tr>
                                <td class="ps-3 fw-semibold">
                                    {{ $delivery->reservation->car->brand->name ?? '' }}
                                    {{ $delivery->reservation->car->name ?? 'N/A' }}
                                </td>
                                <td>{{ $delivery->reservation->customer->name ?? 'N/A' }}</td>
                                <td class="text-muted small">{{ Str::limit($delivery->delivery_address, 30) ?: '—' }}</td>
                                <td>
                                    @if($delivery->status === 'delivered')
                                        <span class="badge bg-success">
                                            <i class="fas fa-flag-checkered me-1"></i>Delivered
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    {{ ($delivery->delivered_at ?? $delivery->updated_at)?->format('M d, Y') }}
                                </td>
                                @if($historyDeliveries->where('driver_notes','!=',null)->count())
                                <td class="text-muted small">{{ Str::limit($delivery->driver_notes, 40) ?: '—' }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Empty State --}}
    @if($deliveries->isEmpty())
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-truck fa-3x text-muted mb-3 d-block opacity-25"></i>
                <h5 class="text-muted">No deliveries assigned yet</h5>
                <p class="text-muted small">You'll see your delivery requests here once an employee assigns them to you.</p>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
