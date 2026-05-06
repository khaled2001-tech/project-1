@extends('back.empty')

@section('title', 'Add New Car')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                   <h4 class="mb-0">  <i class="menu-icon mdi mdi-car"></i> Create New Employee</h4>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Car Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Car Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Brand -->
                    <div class="col-md-6 mb-3">
                        <label for="brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
                        <select class="form-select @error('brand_id') is-invalid @enderror"
                                id="brand_id" name="brand_id" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Model -->
                    <div class="col-md-6 mb-3">
                        <label for="model_id" class="form-label">Model</label>
                        <select class="form-select @error('model_id') is-invalid @enderror"
                                id="model_id" name="model_id">
                            <option value="">Select Model</option>
                            @foreach($models as $model)
                                <option value="{{ $model->id }}" {{ old('model_id') == $model->id ? 'selected' : '' }}>
                                    {{ $model->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('model_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Body Type -->
                    <div class="col-md-6 mb-3">
                        <label for="body_type" class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('body_type') is-invalid @enderror"
                                id="body_type" name="body_type" required>
                            <option value="">Select Type</option>
                            <option value="rent" {{ old('body_type') == 'RENT' ? 'selected' : '' }}>For Rent</option>
                            <option value="buy" {{ old('body_type') == 'BUY' ? 'selected' : '' }}>For Sale</option>
                        </select>
                        @error('body_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                               id="price" name="price" value="{{ old('price', 0) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount -->
                    <div class="col-md-6 mb-3">
                        <label for="discount" class="form-label">Discount (%)</label>
                        <input type="number" step="0.01" max="100" class="form-control @error('discount') is-invalid @enderror"
                               id="discount" name="discount" value="{{ old('discount', 0) }}">
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div class="col-md-6 mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror"
                               id="color" name="color" value="{{ old('color') }}">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Manufacturing Year -->
                    <div class="col-md-6 mb-3">
                        <label for="menufacturing_year" class="form-label">Manufacturing Year</label>
                        <input type="number" min="1900" max="{{ date('Y') + 1 }}"
                               class="form-control @error('menufacturing_year') is-invalid @enderror"
                               id="menufacturing_year" name="menufacturing_year" value="{{ old('menufacturing_year') }}">
                        @error('menufacturing_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Engine Capacity -->
                    <div class="col-md-6 mb-3">
                        <label for="engine_capacity" class="form-label">Engine Capacity (CC)</label>
                        <input type="number" class="form-control @error('engine_capacity') is-invalid @enderror"
                               id="engine_capacity" name="engine_capacity" value="{{ old('engine_capacity') }}">
                        @error('engine_capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Transmission Type -->
                    <div class="col-md-6 mb-3">
                        <label for="transmission_type" class="form-label">Transmission Type</label>
                        <select class="form-select @error('transmission_type') is-invalid @enderror"
                                id="transmission_type" name="transmission_type">
                            <option value="">Select Transmission</option>
                            <option value="Manual" {{ old('transmission_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            <option value="Automatic" {{ old('transmission_type') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="CVT" {{ old('transmission_type') == 'CVT' ? 'selected' : '' }}>CVT</option>
                        </select>
                        @error('transmission_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Number of Doors -->
                    <div class="col-md-6 mb-3">
                        <label for="number_doors" class="form-label">Number of Doors</label>
                        <input type="number" min="2" max="6" class="form-control @error('number_doors') is-invalid @enderror"
                               id="number_doors" name="number_doors" value="{{ old('number_doors', 4) }}">
                        @error('number_doors')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Count -->
                    <div class="col-md-6 mb-3">
                        <label for="count" class="form-label">Available Count</label>
                        <input type="number" min="0" class="form-control @error('count') is-invalid @enderror"
                               id="count" name="count" value="{{ old('count') }}">
                        @error('count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="col-md-6 mb-3">
                        <label for="img" class="form-label">Car Image</label>
                        <input type="file" class="form-control @error('img') is-invalid @enderror"
                               id="img" name="img" accept="image/*">
                        @error('img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
             <div class="row">
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                         Save Car
                    </button>
                    <a href="{{ route('cars.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
