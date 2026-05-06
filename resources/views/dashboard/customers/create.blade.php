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
                        <i class="fas fa-user-plus"></i>  Create New Customer
                    </h4>
                </div>
        <div class="card-body">
        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                            <!-- Password-->
                            <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                            <!-- Birthdate -->
                            <div class="col-md-6 mb-3">
                                <label for="birthdate" class="form-label">Birthday</label>
                                <input type="date"
                                       class="form-control @error('birthdate') is-invalid @enderror"
                                       id="birthdate"
                                       name="birthdate"
                                       value="{{ old('birthdate') }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender"
                                        name="gender"
                                        required>
                                    <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                     <!-- Photo -->
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Image</label>
                                <input type="file"
                                       class="form-control @error('photo') is-invalid @enderror"
                                       id="photo"
                                       name="photo"
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2" id="imagePreview"></div>
                            </div>

              <!-- User -->
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Manager <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror"
                                        id="user_id"
                                        name="user_id"
                                        required>
                                    <option value="">Createby Manager</option>
                                    @foreach( $users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
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
                                <input type="checkbox" name="fav_client" value="1"> Favoirte
                            </div>
     <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                               Create Customer
                            </button>
                        </div>
        </form>
    </div>
@endsection
{{--
@extends('back.empty')
@section('style')

@endsection


@section('title', 'إضافة موظف جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus"></i>  Create New Employee
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
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

                            <!-- National ID -->
                            <div class="col-md-6 mb-3">
                                <label for="national_id" class="form-label">National Number</label>
                                <input type="number"
                                       class="form-control @error('national_id') is-invalid @enderror"
                                       id="national_id"
                                       name="national_id"
                                       value="{{ old('national_id') }}">
                                @error('national_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birthdate -->
                            <div class="col-md-6 mb-3">
                                <label for="birthdate" class="form-label">Birthday</label>
                                <input type="date"
                                       class="form-control @error('birthdate') is-invalid @enderror"
                                       id="birthdate"
                                       name="birthdate"
                                       value="{{ old('birthdate') }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Job -->
                            <div class="col-md-6 mb-3">
                                <label for="job" class="form-label">job</label>
                                <input type="text"
                                       class="form-control @error('job') is-invalid @enderror"
                                       id="job"
                                       name="job"
                                       value="{{ old('job') }}">
                                @error('job')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">
                                    Gender <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender"
                                        name="gender"
                                        required>
                                    <option value="">Choice Gender</option>
                                    <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Salary -->
                            <div class="col-md-6 mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control @error('salary') is-invalid @enderror"
                                           id="salary"
                                           name="salary"
                                           value="{{ old('salary', '0.00') }}"
                                           step="0.01"
                                           min="0">
                                    <span class="input-group-text">$$</span>
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Commission -->
                            <div class="col-md-6 mb-3">
                                <label for="commission" class="form-label">Commission</label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control @error('commission') is-invalid @enderror"
                                           id="commission"
                                           name="commission"
                                           value="{{ old('commission', '0.00') }}"
                                           step="0.01"
                                           min="0"
                                           max="100">
                                    <span class="input-group-text">%</span>
                                    @error('commission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Photo -->
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Image</label>
                                <input type="file"
                                       class="form-control @error('photo') is-invalid @enderror"
                                       id="photo"
                                       name="photo"
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2" id="imagePreview"></div>
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

                            <!-- User -->
                            <div class="col-md-12 mb-3">
                                <label for="user_id" class="form-label">
                                     <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('user_id') is-invalid @enderror"
                                        id="user_id"
                                        name="user_id"
                                        required>
                                    <option value="">Choese User </option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}"
                         class="img-thumbnail"
                         style="max-width: 200px; max-height: 200px; object-fit: cover;">
                `;
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    }
</script>
@endpush

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endpush

 --}}
