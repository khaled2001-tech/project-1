@extends('welcome.layout')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header">
    <h1 class="display-3 text-uppercase text-white mb-3">Booking Confirmed</h1>
</div>
<!-- Page Header End -->

<!-- Success Message Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <i class="fa fa-check-circle text-primary" style="font-size: 80px;"></i>
                    <h1 class="display-4 text-uppercase mt-4">Booking Successful!</h1>
                    <p class="lead">Thank you for choosing our service. Your booking request has been received.</p>
                </div>

                <div class="bg-secondary p-5">
                    <h3 class="text-primary mb-4">Booking Details</h3>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Booking ID:</strong>
                        </div>
                        <div class="col-6">
                            #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Customer Name:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->customer->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->customer->email }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Phone:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->customer->phone }}
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Car:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->car->brand->name }} {{ $reservation->car->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Pickup Date:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->pickup_date->format('M d, Y h:i A') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Return Date:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->return_date->format('M d, Y h:i A') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Rental Days:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->rental_days }} {{ $reservation->rental_days > 1 ? 'days' : 'day' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Total Price:</strong>
                        </div>
                        <div class="col-6">
                            <h5 class="text-primary mb-0">${{ number_format($reservation->total_price, 2) }}</h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Payment Method:</strong>
                        </div>
                        <div class="col-6">
                            {{ ucfirst(str_replace('_', ' ', $reservation->payment_method)) }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-6">
                            <span class="badge badge-{{ $reservation->statusBadge }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>
                    </div>

                    @if($reservation->pickup_location)
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Pickup Location:</strong>
                        </div>
                        <div class="col-6">
                            {{ $reservation->pickup_location }}
                        </div>
                    </div>
                    @endif

                    @if($reservation->notes)
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Special Requests:</strong>
                            <p class="mt-2">{{ $reservation->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <hr class="my-4">

                    <div class="alert alert-info">
                        <strong>Next Steps:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Our team will review your booking request within 24 hours</li>
                            <li>You will receive a confirmation email once approved</li>
                            <li>Please check your email regularly for updates</li>
                            <li>Bring your driver's license and payment on pickup day</li>
                        </ul>
                    </div>

                    {{-- <div class="text-center mt-4">
                        <a href="{{ route('front.cars') }}" class="btn btn-primary px-5 py-3 mr-2">
                            Browse More Cars
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-primary px-5 py-3">
                            Back to Home
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Success Message End -->
@endsection
