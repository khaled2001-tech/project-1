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
                        <i class="menu-icon mdi mdi-car-connected"></i> Edit Models
                    </h4>
                </div>
        <div class="card-body">
        <form action="{{ route('models.update', $model->id) }}" method="POST">
            @csrf
            @method('PUT')
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
                                       value="{{ $model->name }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                     <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                   id="description" name="description" value="{{ $model->description }}" required>
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
                                    <option value="1" {{ $model->status ? 'checked' : '' }}>Active</option>
                                    <option value="0" {{ $model->status ? 'checked' : '' }}>Invalid</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

     <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('models.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                              EDit Model
                            </button>
                        </div>
        </form>
    </div>
@endsection
