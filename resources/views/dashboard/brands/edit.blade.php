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
                        <i class="menu-icon mdi mdi-car-connected"></i>  Edit Brand
                    </h4>
                </div>
              <div class="card-body">

                <form action="{{ route('brands.update', $brand->id) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                      value="{{ $brand->name }}" required
                                       >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                     <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                   id="description" name="description" value="{{ $brand->description }}">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
       <!-- User -->
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Manager <span class="text-danger">*</span></label>
             <select class="form-select @error('created_by') is-invalid @enderror"
                    id="created_by"
                    name="created_by"
                    required>
                <option value="">Created by Manager</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ $brand->created_by == $user->id ? 'selected' : '' }}>
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
                                    <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Invalid</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                         <div class="d-flex justify-content-between">
                            <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                               Update Brand
                            </button>
                        </div>
                </form>

                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('متأكد من الحذف؟')">حذف</button>
                </form>
            </div>
@endsection
