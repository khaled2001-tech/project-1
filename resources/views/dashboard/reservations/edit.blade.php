@extends('back.empty')

@section('title', 'Edit Reservation')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                    <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>View Details
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Main Form Card -->
            <div class="col-lg-8">
                <!-- Customer Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $reservation->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-car me-2"></i>Vehicle Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
                                <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $reservation->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="model_id" class="form-label">Model <span class="text-danger">*</span></label>
                                <select name="model_id" id="model_id" class="form-select @error('model_id') is-invalid @enderror" required>
                                    <option value="">Select Model</option>
                                    @foreach($models as $model)
                                        <option value="{{ $model->id }}" {{ old('model_id', $reservation->model_id) == $model->id ? 'selected' : '' }}>
                                            {{ $model->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('model_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="car_id" class="form-label">Car <span class="text-danger">*</span></label>
                                <select name="car_id" id="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
                                    <option value="">Select Car</option>
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}" {{ old('car_id', $reservation->car_id) == $car->id ? 'selected' : '' }}>
                                            {{ $car->plate_number ?? $car->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Reservation Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_date" class="form-label">Pickup Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local"
                                       name="pickup_date"
                                       id="pickup_date"
                                       class="form-control @error('pickup_date') is-invalid @enderror"
                                       value="{{ old('pickup_date', $reservation->pickup_date?->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('pickup_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="return_date" class="form-label">Return Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local"
                                       name="return_date"
                                       id="return_date"
                                       class="form-control @error('return_date') is-invalid @enderror"
                                       value="{{ old('return_date', $reservation->return_date?->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('return_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="rental_days" class="form-label">Rental Days</label>
                                <input type="number"
                                       name="rental_days"
                                       id="rental_days"
                                       class="form-control @error('rental_days') is-invalid @enderror"
                                       value="{{ old('rental_days', $reservation->rental_days) }}"
                                       readonly>
                                @error('rental_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="total_price" class="form-label">Total Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number"
                                           name="total_price"
                                           id="total_price"
                                           class="form-control @error('total_price') is-invalid @enderror"
                                           value="{{ old('total_price', $reservation->total_price) }}"
                                           step="0.01"
                                           required>
                                    @error('total_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes"
                                          id="notes"
                                          rows="4"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Enter any additional notes...">{{ old('notes', $reservation->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status & Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="approved" {{ old('status', $reservation->status) == 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>
                                <option value="rejected" {{ old('status', $reservation->status) == 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                                <option value="completed" {{ old('status', $reservation->status) == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                <!-- Reservation Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Record Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Reservation ID</label>
                            <p class="fw-bold mb-2">#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Created At</label>
                            <p class="mb-2">{{ $reservation->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="mb-0">
                            <label class="text-muted small">Last Updated</label>
                            <p class="mb-0">{{ $reservation->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                                Update Reservation
                            </a>
                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calculate rental days automatically
    const pickupDate = document.getElementById('pickup_date');
    const returnDate = document.getElementById('return_date');
    const rentalDays = document.getElementById('rental_days');

    function calculateDays() {
        if (pickupDate.value && returnDate.value) {
            const pickup = new Date(pickupDate.value);
            const returnD = new Date(returnDate.value);
            const diffTime = Math.abs(returnD - pickup);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            rentalDays.value = diffDays;
        }
    }

    pickupDate.addEventListener('change', calculateDays);
    returnDate.addEventListener('change', calculateDays);

    // Brand/Model/Car cascade
    const brandSelect = document.getElementById('brand_id');
    const modelSelect = document.getElementById('model_id');
    const carSelect = document.getElementById('car_id');

    brandSelect.addEventListener('change', function() {
        // Add your AJAX logic here to filter models by brand
        console.log('Brand changed:', this.value);
    });

    modelSelect.addEventListener('change', function() {
        // Add your AJAX logic here to filter cars by model
        console.log('Model changed:', this.value);
    });
});
</script>
@endpush
@endsection
