@extends('dashboard.layouts.master')

@section('title', 'Edit Car — ' . $car->name)

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit: {{ $car->name }}</li>
        </ol>
    </nav>

    {{-- Header Row: title + Prev / Next --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-edit me-2 text-warning"></i>Edit Car</h2>

        <div class="d-flex align-items-center gap-2">
            {{-- Previous Car --}}
            @if($prevCar)
                <a href="{{ route('cars.edit', $prevCar->id) }}" class="btn btn-outline-secondary btn-sm" title="Previous: {{ $prevCar->name }}">
                    <i class="fas fa-chevron-left"></i> Previous
                    <span class="d-none d-md-inline ms-1 text-muted small">{{ $prevCar->name }}</span>
                </a>
            @else
                <button class="btn btn-outline-secondary btn-sm" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
            @endif

            <span class="text-muted small px-1">
                Car #{{ $car->id }}
            </span>

            {{-- Next Car --}}
            @if($nextCar)
                <a href="{{ route('cars.edit', $nextCar->id) }}" class="btn btn-outline-secondary btn-sm" title="Next: {{ $nextCar->name }}">
                    Next <i class="fas fa-chevron-right"></i>
                    <span class="d-none d-md-inline ms-1 text-muted small">{{ $nextCar->name }}</span>
                </a>
            @else
                <button class="btn btn-outline-secondary btn-sm" disabled>
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            @endif

            <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-sm ms-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ implode(' | ', $errors->all()) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Edit Form --}}
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark fw-semibold">
            <i class="fas fa-car me-2"></i>{{ $car->name }}
        </div>
        <div class="card-body">
            <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Car Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Car Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name', $car->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Brand --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Brand <span class="text-danger">*</span></label>
                        <select class="form-select @error('brand_id') is-invalid @enderror" name="brand_id" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Model --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Model</label>
                        <select class="form-select @error('model_id') is-invalid @enderror" name="model_id">
                            <option value="">Select Model</option>
                            @foreach($models as $model)
                                <option value="{{ $model->id }}"
                                    {{ old('model_id', $car->model_id) == $model->id ? 'selected' : '' }}>
                                    {{ $model->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('model_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Type --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('body_type') is-invalid @enderror" name="body_type" required>
                            <option value="">Select Type</option>
                            <option value="rent" {{ old('body_type', $car->body_type) == 'rent' ? 'selected' : '' }}>For Rent</option>
                            <option value="buy"  {{ old('body_type', $car->body_type) == 'buy'  ? 'selected' : '' }}>For Sale</option>
                        </select>
                        @error('body_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                               name="price" value="{{ old('price', $car->price) }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Discount --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" step="0.01" max="100" class="form-control @error('discount') is-invalid @enderror"
                               name="discount" value="{{ old('discount', $car->discount) }}">
                        @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Color --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror"
                               name="color" value="{{ old('color', $car->color) }}">
                        @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Manufacturing Year --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Manufacturing Year</label>
                        <input type="number" min="1900" max="{{ date('Y') + 1 }}"
                               class="form-control @error('menufacturing_year') is-invalid @enderror"
                               name="menufacturing_year" value="{{ old('menufacturing_year', $car->menufacturing_year) }}">
                        @error('menufacturing_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Engine Capacity --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Engine Capacity (CC)</label>
                        <input type="number" class="form-control @error('engine_capacity') is-invalid @enderror"
                               name="engine_capacity" value="{{ old('engine_capacity', $car->engine_capacity) }}">
                        @error('engine_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Transmission --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Transmission Type</label>
                        <select class="form-select @error('transmission_type') is-invalid @enderror" name="transmission_type">
                            <option value="">Select Transmission</option>
                            <option value="Manual"    {{ old('transmission_type', $car->transmission_type) == 'Manual'    ? 'selected' : '' }}>Manual</option>
                            <option value="Automatic" {{ old('transmission_type', $car->transmission_type) == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="CVT"       {{ old('transmission_type', $car->transmission_type) == 'CVT'       ? 'selected' : '' }}>CVT</option>
                        </select>
                        @error('transmission_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Number of Doors --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Number of Doors</label>
                        <input type="number" min="2" max="6" class="form-control @error('number_doors') is-invalid @enderror"
                               name="number_doors" value="{{ old('number_doors', $car->number_doors) }}">
                        @error('number_doors')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Count --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Available Count</label>
                        <input type="number" min="0" class="form-control @error('count') is-invalid @enderror"
                               name="count" value="{{ old('count', $car->count) }}">
                        @error('count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               name="phone" value="{{ old('phone', $car->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Car Image</label>
                        @if($car->img)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $car->img) }}" alt="{{ $car->name }}"
                                     class="img-thumbnail" style="height:80px;object-fit:cover;">
                                <small class="text-muted ms-2">Current image</small>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('img') is-invalid @enderror"
                               name="img" accept="image/*">
                        <div class="form-text">Leave empty to keep the current image.</div>
                        @error('img')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status">
                            <option value="1" {{ old('status', $car->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $car->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-warning me-2">
                            <i class="fas fa-save me-1"></i> Update Car
                        </button>
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>

                    {{-- Prev / Next at the bottom too --}}
                    <div class="d-flex gap-2">
                        @if($prevCar)
                            <a href="{{ route('cars.edit', $prevCar->id) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-chevron-left"></i> {{ Str::limit($prevCar->name, 20) }}
                            </a>
                        @endif
                        @if($nextCar)
                            <a href="{{ route('cars.edit', $nextCar->id) }}" class="btn btn-outline-secondary btn-sm">
                                {{ Str::limit($nextCar->name, 20) }} <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
