
@extends('back.empty')
@section('style')

@endsection
@section('content')
   <div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="menu-icon mdi mdi-car-connected"></i>  Create New Model
                    </h4>
                </div>
        <div class="card-body">
        <form action="{{ route('models.store') }}" method="POST">
            @csrf

           <div class="row">
                            <!-- Name -->
                            <div class="col-mb-3">
                                <label for="name" class="form-label">
                                   Name<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                     <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                   id="description" name="description" value="{{ old('description') }}" required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                     <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="">Choice Status</option>
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Invalid</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        <div class="mb-3">
                            <label>Choice Brands</label>
                            <select name="brand_id" class="form-control">
                                <option value="">Choice Brands</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
              </div>
     <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('models.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                               Create Models
                            </button>
                        </div>
        </form>
    </div>
@endsection
{{--
@extends('back.empty')


@section('style')

@endsection
@section('content')
  <div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="menu-icon mdi mdi-car-connected"></i>  Create New Brands
                    </h4>
                </div>
        <div class="card-body">
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
             <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                   Name<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                   id="description" name="description" value="{{ old('description') }}" required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

               <!-- Manager -->
                            <div class="col-md-6 mb-3">
                                <label for="created_by" class="form-label">Manager <span class="text-danger">*</span></label>
                                <select class="form-select @error('created_by') is-invalid @enderror"
                                        id="created_by"
                                        name="created_by"
                                        required>
                                    <option value="">Select Manager</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('created_by') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('created_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="">Choice Status</option>
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Invalid</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
     <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                               Create Brand
                            </button>
                        </div>
        </form>
    </div>
@endsection





--}}
