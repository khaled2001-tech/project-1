@extends('dashboard.layouts.master')

@section('title', 'Deliveries Management')
@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Drivers</h4>
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
    <div class="col-xl-12">

        {{-- Page Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">Deliveries</h4>
                <p class="text-muted mb-0 small">Track all car delivery assignments</p>
            </div>
            {{-- Stats Pills --}}
            <div class="d-flex gap-2 flex-wrap">
                @php
                    $counts = [
                        'pending'     => $deliveries->where('status','pending')->count(),
                        'accepted'    => $deliveries->where('status','accepted')->count(),
                        'in_progress' => $deliveries->where('status','in_progress')->count(),
                        'delivered'   => $deliveries->where('status','delivered')->count(),
                        'rejected'    => $deliveries->where('status','rejected')->count(),
                    ];
                @endphp
                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                    <i class="fas fa-clock me-1"></i>{{ $counts['pending'] }} Pending
                </span>
                <span class="badge rounded-pill bg-info px-3 py-2">
                    <i class="fas fa-check me-1"></i>{{ $counts['accepted'] }} Accepted
                </span>
                <span class="badge rounded-pill bg-primary px-3 py-2">
                    <i class="fas fa-truck me-1"></i>{{ $counts['in_progress'] }} In Progress
                </span>
                <span class="badge rounded-pill bg-success px-3 py-2">
                    <i class="fas fa-flag-checkered me-1"></i>{{ $counts['delivered'] }} Delivered
                </span>
                <span class="badge rounded-pill bg-danger px-3 py-2">
                    <i class="fas fa-times me-1"></i>{{ $counts['rejected'] }} Rejected
                </span>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Reservation</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Driver</th>
                                <th>Delivery Address</th>
                                <th>Status</th>
                                <th>Assigned At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deliveries as $delivery)
                                <tr>
                                    <td class="ps-3 text-muted small">{{ $delivery->id }}</td>

                                    <td>
                                        <a href="{{ route('reservations.show', $delivery->reservation_id) }}"
                                           class="text-primary fw-semibold text-decoration-none">
                                            #{{ str_pad($delivery->reservation_id, 6, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                                 style="width:34px;height:34px;font-size:13px;flex-shrink:0">
                                                {{ strtoupper(substr($delivery->reservation->customer->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold">{{ $delivery->reservation->customer->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="fw-semibold">{{ $delivery->reservation->car->brand->name ?? '' }}</span>
                                        <span class="text-muted">{{ $delivery->reservation->car->name ?? 'N/A' }}</span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold"
                                                 style="width:32px;height:32px;font-size:13px;flex-shrink:0">
                                                {{ strtoupper(substr($delivery->driver->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span>{{ $delivery->driver->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>

                                    <td class="text-muted small">
                                        {{ $delivery->delivery_address ? Str::limit($delivery->delivery_address, 30) : '—' }}
                                    </td>

                                    <td>
                                        @php
                                            $badgeMap = [
                                                'pending'     => ['bg' => 'warning',   'icon' => 'clock',            'text' => 'dark', 'label' => 'Pending'],
                                                'accepted'    => ['bg' => 'info',      'icon' => 'check',            'text' => 'white','label' => 'Accepted'],
                                                'in_progress' => ['bg' => 'primary',   'icon' => 'truck',            'text' => 'white','label' => 'In Progress'],
                                                'delivered'   => ['bg' => 'success',   'icon' => 'flag-checkered',   'text' => 'white','label' => 'Delivered'],
                                                'rejected'    => ['bg' => 'danger',    'icon' => 'times-circle',     'text' => 'white','label' => 'Rejected'],
                                            ];
                                            $badge = $badgeMap[$delivery->status] ?? ['bg'=>'secondary','icon'=>'question','text'=>'white','label'=>ucfirst($delivery->status)];
                                        @endphp
                                        <span class="badge bg-{{ $badge['bg'] }} text-{{ $badge['text'] }} px-2 py-1">
                                            <i class="fas fa-{{ $badge['icon'] }} me-1"></i>{{ $badge['label'] }}
                                        </span>
                                    </td>

                                    <td class="text-muted small">
                                        {{ $delivery->created_at->format('M d, Y') }}<br>
                                        <span class="text-muted">{{ $delivery->created_at->format('H:i') }}</span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('driver.del.show', $delivery->id) }}"
                                               class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($delivery->status === 'rejected')
                                                <button type="button"
                                                        class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reassignModal{{ $delivery->id }}"
                                                        title="Reassign Driver">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- ── Reassign Modal ── --}}
                                @if($delivery->status === 'rejected')
                                <div class="modal fade" id="reassignModal{{ $delivery->id }}" tabindex="-1" aria-hidden="true">
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
                                                    {{-- Rejection info --}}
                                                    <div class="alert alert-danger py-2 small">
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
                                                                {{ $drv->name }}
                                                                @if($drv->phone) — {{ $drv->phone }} @endif
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

                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="fas fa-truck fa-2x mb-2 d-block opacity-25"></i>
                                        No deliveries found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($deliveries->hasPages())
                    <div class="px-3 py-2 border-top">
                        {{ $deliveries->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
