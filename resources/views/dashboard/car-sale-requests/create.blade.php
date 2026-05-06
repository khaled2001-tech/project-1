@extends('layouts.app')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Sell Your Car</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Submit Request</span>
        </div>
    </div>
</div>
@endsection

@section('content')

@if(session('success'))
    <div data-toast="success" style="display:none">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div data-toast="danger" style="display:none">{{ implode(' | ', $errors->all()) }}</div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-car mr-2"></i> Car Sale Request Form</h5>
                <small class="opacity-75">Fill in your car details and our team will review your request.</small>
            </div>

            <form action="{{ route('welcome.car-sale-requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    {{-- ── Basic Info ── --}}
                    <h6 class="font-weight-bold text-muted mb-3 border-bottom pb-2">
                        <i class="fas fa-info-circle mr-1"></i> Basic Information
                    </h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Brand <span class="text-danger">*</span></label>
                            <input type="text" name="brand"
                                   class="form-control @error('brand') is-invalid @enderror"
                                   value="{{ old('brand') }}" placeholder="e.g. Toyota" required>
                            @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" name="model"
                                   class="form-control @error('model') is-invalid @enderror"
                                   value="{{ old('model') }}" placeholder="e.g. Camry" required>
                            @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Year <span class="text-danger">*</span></label>
                            <input type="number" name="year"
                                   class="form-control @error('year') is-invalid @enderror"
                                   value="{{ old('year', date('Y')) }}"
                                   min="1990" max="{{ date('Y') + 1 }}" required>
                            @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" name="color"
                                   class="form-control @error('color') is-invalid @enderror"
                                   value="{{ old('color') }}" placeholder="e.g. Silver">
                            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Engine Capacity (cc)</label>
                            <input type="number" name="engine_capacity"
                                   class="form-control @error('engine_capacity') is-invalid @enderror"
                                   value="{{ old('engine_capacity') }}" placeholder="e.g. 2000" min="500" max="10000">
                            @error('engine_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Number of Doors <span class="text-danger">*</span></label>
                            <select name="number_doors" class="form-control @error('number_doors') is-invalid @enderror" required>
                                @foreach([2,3,4,5] as $d)
                                    <option value="{{ $d }}" {{ old('number_doors','4') == $d ? 'selected' : '' }}>{{ $d }} Doors</option>
                                @endforeach
                            </select>
                            @error('number_doors')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Technical Specs ── --}}
                    <h6 class="font-weight-bold text-muted mt-3 mb-3 border-bottom pb-2">
                        <i class="fas fa-cogs mr-1"></i> Technical Specs
                    </h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Transmission <span class="text-danger">*</span></label>
                            <select name="transmission" class="form-control @error('transmission') is-invalid @enderror" required>
                                <option value="manual"    {{ old('transmission')=='manual'    ? 'selected' : '' }}>Manual</option>
                                <option value="automatic" {{ old('transmission')=='automatic' ? 'selected' : '' }}>Automatic</option>
                            </select>
                            @error('transmission')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Fuel Type <span class="text-danger">*</span></label>
                            <select name="fuel_type" class="form-control @error('fuel_type') is-invalid @enderror" required>
                                <option value="petrol"   {{ old('fuel_type')=='petrol'   ? 'selected' : '' }}>Petrol</option>
                                <option value="diesel"   {{ old('fuel_type')=='diesel'   ? 'selected' : '' }}>Diesel</option>
                                <option value="electric" {{ old('fuel_type')=='electric' ? 'selected' : '' }}>Electric</option>
                                <option value="hybrid"   {{ old('fuel_type')=='hybrid'   ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            @error('fuel_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Condition <span class="text-danger">*</span></label>
                            <select name="condition" class="form-control @error('condition') is-invalid @enderror" required>
                                <option value="used" {{ old('condition','used')=='used' ? 'selected' : '' }}>Used</option>
                                <option value="new"  {{ old('condition')=='new'         ? 'selected' : '' }}>New</option>
                            </select>
                            @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Mileage (km) <span class="text-danger">*</span></label>
                            <input type="number" name="mileage"
                                   class="form-control @error('mileage') is-invalid @enderror"
                                   value="{{ old('mileage', 0) }}" min="0" required>
                            @error('mileage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Price & Description ── --}}
                    <h6 class="font-weight-bold text-muted mt-3 mb-3 border-bottom pb-2">
                        <i class="fas fa-dollar-sign mr-1"></i> Price & Details
                    </h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Asking Price ($) <span class="text-danger">*</span></label>
                            <input type="number" name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" min="0" step="0.01" placeholder="0.00" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Describe your car's condition, features, history..." required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Images ── --}}
                    <h6 class="font-weight-bold text-muted mt-3 mb-3 border-bottom pb-2">
                        <i class="fas fa-camera mr-1"></i> Photos
                    </h6>
                    <div class="mb-3">
                        <label class="form-label">Upload Car Photos (max 5 photos, JPG/PNG, 2MB each)</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                               class="form-control @error('images.*') is-invalid @enderror"
                               id="imageInput">
                        @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="imagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('welcome.car-sale-requests.my') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list mr-1"></i> My Requests
                    </a>
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-paper-plane mr-1"></i> Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ URL::asset('assets/dashboard/js/flash-toast.js') }}"></script>
<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function () {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    Array.from(this.files).slice(0, 5).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:80px;height:60px;object-fit:cover;border-radius:6px;border:2px solid #dee2e6';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
