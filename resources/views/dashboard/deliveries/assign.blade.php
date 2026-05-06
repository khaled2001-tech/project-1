@extends('dashboard.layouts.master')

@section('title', 'Assign Driver')

@section('content')
<div class="row row-sm">
    <div class="col-xl-8 offset-xl-2">

        {{-- Reservation Summary Card --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Reservation #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Customer</small>
                        <strong>{{ $reservation->customer->name }}</strong><br>
                        <small>{{ $reservation->customer->email }}</small>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Car</small>
                        <strong>{{ $reservation->car->brand->name ?? '' }} {{ $reservation->car->name }}</strong><br>
                        <small>${{ number_format($reservation->total_price, 2) }} — {{ $reservation->rental_days }} days</small>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Pickup → Return</small>
                        <strong>{{ $reservation->pickup_date->format('M d, Y') }}</strong><br>
                        <small>→ {{ $reservation->return_date->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Assign Driver Form --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-tie me-2 text-warning"></i>Assign Driver</h5>
            </div>
            <form action="{{ route('driver.deliveries.accept') }}" method="POST">
                @csrf
                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Select Driver <span class="text-danger">*</span></label>
                        @forelse($drivers as $driver)
                            <div class="form-check card mb-2 p-0 border {{ old('driver_id') == $driver->id ? 'border-primary' : '' }}">
                                <label class="form-check-label w-100 p-3 d-flex align-items-center gap-3" style="cursor:pointer">
                                    <input class="form-check-input" type="radio" name="driver_id"
                                           value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'checked' : '' }} required>
                                    <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold"
                                         style="width:42px;height:42px;flex-shrink:0;font-size:18px">
                                        {{ strtoupper(substr($driver->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $driver->name }}</div>
                                        <small class="text-muted">
                                            {{ $driver->phone ?? 'No phone' }}
                                            @if($driver->license_number)
                                                &nbsp;·&nbsp; License: {{ $driver->license_number }}
                                            @endif
                                        </small>
                                    </div>
                                    <span class="ms-auto badge bg-success">Available</span>
                                </label>
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No available drivers. Please add drivers or make existing ones available.
                            </div>
                        @endforelse
                        @error('driver_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delivery Address <small class="text-muted">(optional — defaults to pickup location)</small></label>
                        <input type="text" name="delivery_address" class="form-control"
                               value="{{ old('delivery_address', $reservation->pickup_location) }}"
                               placeholder="Enter delivery address...">
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    @if($drivers->isNotEmpty())
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-paper-plane me-1"></i> Assign Driver & Send Request
                        </button>
                    @endif
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
