@extends('dashboard.layouts.master')

@section('title', 'Deliveries Management')

@section('content')
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4 class="card-title mb-1">DELIVERIES</h4>
                <p class="tx-12 tx-gray-500 mb-0">Track all car delivery assignments.</p>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover text-md-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reservation</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Driver</th>
                                <th>Delivery Address</th>
                                <th>Status</th>
                                <th>Assigned At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deliveries as $delivery)
                                <tr>
                                    <td>{{ $delivery->id }}</td>
                                    <td>
                                        <a href="{{ route('reservations.show', $delivery->reservation_id) }}" class="text-primary">
                                            #{{ str_pad($delivery->reservation_id, 6, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>
                                        <strong>{{ $delivery->reservation->customer->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        {{ $delivery->reservation->car->brand->name ?? '' }}
                                        {{ $delivery->reservation->car->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold"
                                                 style="width:32px;height:32px;font-size:14px;flex-shrink:0">
                                                {{ strtoupper(substr($delivery->driver->name ?? '?', 0, 1)) }}
                                            </div>
                                            {{ $delivery->driver->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($delivery->delivery_address, 30) ?: '—' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $delivery->statusBadge }}">
                                            {{ $delivery->statusLabel }}
                                        </span>
                                    </td>
                                    <td>{{ $delivery->created_at->format('M d, H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('deliveries.show', $delivery->id) }}"
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($delivery->status === 'rejected')
                                                <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reassignModal{{ $delivery->id }}"
                                                        title="Reassign Driver">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Reassign Modal --}}
                                @if($delivery->status === 'rejected')
                                <div class="modal fade" id="reassignModal{{ $delivery->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title"><i class="fas fa-redo me-2"></i>Reassign Driver</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('deliveries.reassign', $delivery->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <p class="text-muted small mb-3">
                                                        Driver <strong>{{ $delivery->driver->name }}</strong> rejected this delivery.
                                                        @if($delivery->driver_notes)
                                                            Reason: "{{ $delivery->driver_notes }}"
                                                        @endif
                                                    </p>
                                                    <label class="form-label">Select New Driver</label>
                                                    <select name="driver_id" class="form-select" required>
                                                        <option value="">-- Select Driver --</option>
                                                        @foreach(\App\Models\Driver::where('status', true)->get() as $driver)
                                                            <option value="{{ $driver->id }}">{{ $driver->name }} - {{ $driver->phone }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fas fa-paper-plane me-1"></i> Reassign
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">No deliveries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $deliveries->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
