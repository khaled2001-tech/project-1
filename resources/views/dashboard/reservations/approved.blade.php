@extends('dashboard.layouts.master')

@section('title', 'Approve Reservation #' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="row row-sm justify-content-center">
    <div class="col-xl-10">

        {{-- Back --}}
        <div class="mb-3">
            <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Reservations
            </a>
        </div>

        {{-- Page Title --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                 style="width:48px;height:48px;flex-shrink:0">
                <i class="fas fa-check-circle text-success fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Approve Reservation</h4>
                <small class="text-muted">#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</small>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">

            {{-- ══ LEFT: Reservation Summary ══ --}}
            <div class="col-lg-5">

                {{-- Car Info --}}
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center gap-2 py-2">
                        <i class="fas fa-car text-warning"></i>
                        <span class="fw-semibold small">Car</span>
                    </div>
                    <div class="card-body py-3">
                        @if($reservation->car->photo ?? false)
                            <img src="{{ asset('storage/' . $reservation->car->photo) }}"
                                 class="img-fluid rounded mb-3"
                                 style="max-height:140px;width:100%;object-fit:cover"
                                 alt="{{ $reservation->car->name }}">
                        @endif
                        <h5 class="fw-bold mb-1">
                            {{ $reservation->car->brand->name ?? '' }}
                            {{ $reservation->car->name }}
                        </h5>
                        @if($reservation->car->plate_number ?? false)
                            <small class="text-muted">
                                <i class="fas fa-hashtag me-1"></i>{{ $reservation->car->plate_number }}
                            </small>
                        @endif
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center gap-2 py-2">
                        <i class="fas fa-user text-info"></i>
                        <span class="fw-semibold small">Customer</span>
                    </div>
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                 style="width:42px;height:42px;font-size:16px">
                                {{ strtoupper(substr($reservation->customer->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $reservation->customer->name }}</div>
                                @if($reservation->customer->email ?? false)
                                    <small class="text-muted">{{ $reservation->customer->email }}</small>
                                @endif
                                @if($reservation->customer->phone ?? false)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>{{ $reservation->customer->phone }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reservation Details --}}
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center gap-2 py-2">
                        <i class="fas fa-calendar text-primary"></i>
                        <span class="fw-semibold small">Reservation Details</span>
                    </div>
                    <div class="card-body py-3">
                        <div class="row g-2 small">
                            <div class="col-6">
                                <div class="text-muted mb-1">Pickup Date</div>
                                <div class="fw-semibold">{{ $reservation->pickup_date->format('M d, Y') }}</div>
                                <div class="text-muted">{{ $reservation->pickup_date->format('H:i') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted mb-1">Return Date</div>
                                <div class="fw-semibold">{{ $reservation->return_date->format('M d, Y') }}</div>
                                <div class="text-muted">{{ $reservation->return_date->format('H:i') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted mb-1">Rental Days</div>
                                <div class="fw-semibold">{{ $reservation->rental_days }} days</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted mb-1">Total Price</div>
                                <div class="fw-bold text-success fs-6">
                                    ${{ number_format($reservation->total_price, 2) }}
                                </div>
                            </div>
                            @if($reservation->pickup_location)
                                <div class="col-12">
                                    <div class="text-muted mb-1">Pickup Location</div>
                                    <div class="fw-semibold">{{ $reservation->pickup_location }}</div>
                                </div>
                            @endif
                            @if($reservation->notes)
                                <div class="col-12">
                                    <div class="text-muted mb-1">Notes</div>
                                    <div class="small">{{ $reservation->notes }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Delivery Badge --}}
                @if($reservation->delivery_required)
                    <div class="alert alert-info d-flex align-items-start gap-2 py-2 small">
                        <i class="fas fa-truck mt-1"></i>
                        <div>
                            <strong>Delivery Required</strong>
                            @if($reservation->delivery_address)
                                <br>Address: {{ $reservation->delivery_address }}
                            @elseif($reservation->pickup_location)
                                <br>Address: {{ $reservation->pickup_location }}
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-secondary d-flex align-items-center gap-2 py-2 small">
                        <i class="fas fa-store"></i>
                        <span>Customer will pick up from branch — no delivery needed.</span>
                    </div>
                @endif

            </div>

            {{-- ══ RIGHT: Approval Form ══ --}}
            <div class="col-lg-7">

                {{-- ✅ POST إلى reservations.approve --}}
                <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST">
                    @csrf

                    {{-- ✅ Driver Selection — تظهر فقط لو delivery_required = true --}}
                    @if($reservation->delivery_required)
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center gap-2">
                                <i class="fas fa-id-badge text-warning"></i>
                                <h6 class="mb-0 fw-bold">
                                    Assign Driver <span class="text-danger">*</span>
                                </h6>
                            </div>
                            <div class="card-body">

                                @if($drivers->isEmpty())
                                    <div class="alert alert-warning mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No available drivers. Please add drivers first.
                                    </div>
                                @else
                                    <p class="text-muted small mb-3">
                                        Select the driver who will deliver the car to the customer.
                                    </p>

                                    <div class="d-flex flex-column gap-2" id="driverList">
                                        @foreach($drivers as $driver)
                                            <label class="driver-card d-flex align-items-center gap-3 p-3 border rounded-3
                                                          {{ old('driver_id') == $driver->id ? 'border-warning bg-warning bg-opacity-10' : '' }}"
                                                   style="cursor:pointer;transition:all .15s"
                                                   for="driver_{{ $driver->id }}">

                                                <input type="radio"
                                                       id="driver_{{ $driver->id }}"
                                                       name="driver_id"
                                                       value="{{ $driver->id }}"
                                                       class="d-none driver-radio"
                                                       {{ old('driver_id') == $driver->id ? 'checked' : '' }}
                                                       required>

                                                {{-- Avatar --}}
                                                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                                     style="width:44px;height:44px;font-size:17px">
                                                    {{ strtoupper(substr($driver->name, 0, 1)) }}
                                                </div>

                                                {{-- Info --}}
                                                <div class="flex-grow-1 min-w-0">
                                                    <div class="fw-semibold">{{ $driver->name }}</div>
                                                    <div class="text-muted small">
                                                        @if($driver->phone ?? false)
                                                            <i class="fas fa-phone me-1"></i>{{ $driver->phone }}
                                                        @endif
                                                        @if(($driver->phone ?? false) && ($driver->license_number ?? false))
                                                            &nbsp;·&nbsp;
                                                        @endif
                                                        @if($driver->license_number ?? false)
                                                            <i class="fas fa-id-card me-1"></i>{{ $driver->license_number }}
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Selected Indicator --}}
                                                <div class="selected-icon text-warning d-none">
                                                    <i class="fas fa-check-circle fa-lg"></i>
                                                </div>

                                            </label>
                                        @endforeach
                                    </div>

                                    @error('driver_id')
                                        <div class="text-danger small mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                @endif

                            </div>
                        </div>
                    @endif

                    {{-- ✅ Delivery Address — تظهر فقط لو delivery_required = true --}}
                    @if($reservation->delivery_required)
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center gap-2">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <h6 class="mb-0 fw-bold">Delivery Address</h6>
                            </div>
                            <div class="card-body">
                                <input type="text"
                                       name="delivery_address"
                                       class="form-control"
                                       value="{{ old('delivery_address', $reservation->delivery_address ?? $reservation->pickup_location) }}"
                                       placeholder="Enter delivery address...">
                                <small class="text-muted">Leave blank to use pickup location.</small>
                            </div>
                        </div>
                    @endif

                    {{-- Confirm Card --}}
                    <div class="card border-success border-2">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>Confirm Approval
                            </h6>
                            <p class="text-muted small mb-2">Approving this reservation will:</p>
                            <ul class="small text-muted mb-4">
                                <li>Change reservation status to <strong class="text-success">Approved</strong></li>
                                <li>Mark the car as <strong>unavailable</strong></li>
                                @if($reservation->delivery_required)
                                    <li>Send a <strong>delivery request</strong> to the selected driver</li>
                                    <li>Driver will need to <strong>accept or reject</strong> the request</li>
                                @endif
                            </ul>

                            <div class="d-flex gap-2">
                                {{-- ✅ زر submit يكون disabled لو delivery مطلوب ومافي drivers --}}
                                <button type="submit"
                                        class="btn btn-success flex-grow-1"
                                        @if($reservation->delivery_required && $drivers->isEmpty()) disabled @endif>
                                    <i class="fas fa-check me-2"></i>
                                    Confirm Approval
                                    @if($reservation->delivery_required)
                                        & Assign Driver
                                    @endif
                                </button>
                                <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>

                            @if($reservation->delivery_required && $drivers->isEmpty())
                                <p class="text-danger small mt-2 mb-0">
                                    <i class="fas fa-lock me-1"></i>Cannot approve — no available drivers.
                                </p>
                            @endif

                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

{{-- Driver card selection JS --}}
<script>
document.querySelectorAll('.driver-radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
        // Reset all cards
        document.querySelectorAll('.driver-card').forEach(function(card) {
            card.classList.remove('border-warning', 'bg-warning', 'bg-opacity-10');
            card.querySelector('.selected-icon')?.classList.add('d-none');
        });
        // Highlight selected card
        var label = document.querySelector('label[for="' + this.id + '"]');
        if (label) {
            label.classList.add('border-warning', 'bg-warning', 'bg-opacity-10');
            label.querySelector('.selected-icon')?.classList.remove('d-none');
        }
    });
});
</script>

@endsection
