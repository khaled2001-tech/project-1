@extends('welcome.layout')

@section('content')
<!-- Page Header -->
<div class="container-fluid page-header">
    <h1 class="display-3 text-uppercase text-white mb-3">Car Booking</h1>
</div>

<!-- Car Detail -->
<div class="container-fluid pt-5">
    <div class="container pt-5 pb-3">
        <h1 class="display-4 text-uppercase mb-5">
            {{ $car->brand->name }} {{ $car->name }}
        </h1>

        <div class="row align-items-center pb-2">
            <div class="col-lg-6 mb-4">
                <img class="img-fluid" src="{{ asset('storage/' . $car->img) }}" alt="{{ $car->name }}">
            </div>
            <div class="col-lg-6 mb-4">
                <h4 class="mb-2">${{ number_format($car->price, 2) }} / Day</h4>
                <div class="d-flex mb-3">
                    <h6 class="mr-2">Rating:</h6>
                    <div class="d-flex align-items-center mb-1">
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star-half-alt text-primary mr-1"></small>
                        <small>(250)</small>
                    </div>
                </div>
                <p>{{ $car->description ?? 'Experience luxury and comfort with this premium vehicle.' }}</p>
            </div>
        </div>

        <div class="row mt-n3 mt-lg-0 pb-4">
            <div class="col-md-3 col-6 mb-2">
                <i class="fa fa-car text-primary mr-2"></i>
                <span>{{ $car->body_type }}</span>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <i class="fa fa-cogs text-primary mr-2"></i>
                <span>{{ $car->menufacturing_year }}</span>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <i class="fa fa-road text-primary mr-2"></i>
                <span>{{ $car->engine_capacity }}</span>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <i class="fa fa-map-marker-alt text-primary mr-2"></i>
                <span>GPS Navigation</span>
            </div>
        </div>
    </div>
</div>

<!-- Booking Form -->
<div class="container-fluid pb-5">
    <div class="container">
        <form action="{{ route('welcome.booking.store', $car->id) }}" method="POST">
            @csrf
            <div class="row">

                {{-- ===== LEFT: Personal + Booking Details ===== --}}
                <div class="col-lg-8">

                    {{-- Personal Details --}}
                    <h2 class="mb-4">Personal Details</h2>
                    <div class="mb-5">
                        <div class="row">
                            <div class="col-12 form-group">
                                <input type="text" class="form-control p-4" name="customer_name"
                                    placeholder="Your Name" required
                                    value="{{ old('customer_name', auth()->user()->name) }}">
                                @error('customer_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <input type="email" class="form-control p-4" name="customer_email"
                                    placeholder="Your Email" required
                                    value="{{ old('customer_email', auth()->user()->email) }}">
                                @error('customer_email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <input type="text" class="form-control p-4" name="customer_phone"
                                    placeholder="Your Phone" required
                                    value="{{ old('customer_phone') }}">
                                @error('customer_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Booking Details --}}
                    <h2 class="mb-4">Booking Details</h2>
                    <div class="mb-5">
                        {{-- Pickup Date & Time --}}
                        <div class="row">
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Pickup Date</label>
                                <input type="date" class="form-control p-4" name="pickup_date"
                                    required value="{{ old('pickup_date') }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                @error('pickup_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Pickup Time</label>
                                <input type="time" class="form-control p-4" name="pickup_time"
                                    required value="{{ old('pickup_time', '09:00') }}">
                                @error('pickup_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Return Date & Time (RENT only) --}}
                        @if(strtoupper($car->body_type) === 'RENT')
                        <div class="row">
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Return Date</label>
                                <input type="date" class="form-control p-4" name="return_date"
                                    required value="{{ old('return_date') }}"
                                    min="{{ date('Y-m-d', strtotime('+2 days')) }}">
                                @error('return_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Return Time</label>
                                <input type="time" class="form-control p-4" name="return_time"
                                    required value="{{ old('return_time', '09:00') }}">
                                @error('return_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- Pickup Location --}}
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="font-weight-bold">Pickup Location <span class="text-muted font-weight-normal">(Optional)</span></label>
                                <input type="text" class="form-control p-4" name="pickup_location"
                                    placeholder="Enter pickup location"
                                    value="{{ old('pickup_location') }}">
                                @error('pickup_location')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Special Notes --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Special Requests <span class="text-muted font-weight-normal">(Optional)</span></label>
                            <textarea class="form-control py-3 px-4" rows="3" name="notes"
                                placeholder="Any special requests or notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- ===== Delivery Service ===== --}}
                    <h2 class="mb-4">Delivery Service</h2>
                    <div class="mb-5 p-4 border rounded">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="delivery_required"
                                name="delivery_required" value="1"
                                {{ old('delivery_required') ? 'checked' : '' }}
                                onchange="toggleDelivery(this)">
                            <label class="custom-control-label font-weight-bold" for="delivery_required">
                                <i class="fa fa-truck text-primary mr-2"></i>
                                Request Home Delivery
                            </label>
                        </div>
                        <p class="text-muted small mb-3">
                            Check this option if you want the car delivered to your address.
                            A driver will be assigned upon approval.
                        </p>

                        {{-- Delivery Address (hidden by default) --}}
                        <div id="delivery_address_section" style="display: {{ old('delivery_required') ? 'block' : 'none' }};">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold">Delivery Address</label>
                                <input type="text" class="form-control p-4" name="delivery_address"
                                    placeholder="Enter your full delivery address"
                                    value="{{ old('delivery_address') }}">
                                @error('delivery_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                {{-- ===== END LEFT ===== --}}

                {{-- ===== RIGHT: Booking Summary ===== --}}
                <div class="col-lg-4">
                    <div class="bg-secondary p-5 mb-5">
                        <h2 class="text-primary mb-4">Booking Summary</h2>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Car:</span>
                            <strong>{{ $car->brand->name }} {{ $car->name }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Type:</span>
                            <strong>{{ ucfirst(strtolower($car->body_type)) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Daily Rate:</span>
                            <strong class="text-primary">${{ number_format($car->price, 2) }}</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Delivery:</span>
                            <strong id="delivery_summary">Not Requested</strong>
                        </div>

                        <div class="alert alert-info small mt-3">
                            <i class="fa fa-info-circle mr-1"></i>
                            Total price will be calculated based on rental days after approval.
                        </div>

                        <button class="btn btn-primary btn-block mt-4 py-3" type="submit">
                            <i class="fa fa-check mr-2"></i> Book Now
                        </button>

                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-block mt-2 py-3">
                            Cancel
                        </a>
                    </div>
                </div>
                {{-- ===== END RIGHT ===== --}}

            </div>
        </form>
    </div>
</div>

<script>
function toggleDelivery(checkbox) {
    const section = document.getElementById('delivery_address_section');
    const summary = document.getElementById('delivery_summary');
    if (checkbox.checked) {
        section.style.display = 'block';
        summary.textContent   = 'Requested';
        summary.className     = 'text-success font-weight-bold';
    } else {
        section.style.display = 'none';
        summary.textContent   = 'Not Requested';
        summary.className     = '';
    }
}
</script>
@endsection
