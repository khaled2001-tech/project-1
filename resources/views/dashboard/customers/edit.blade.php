@extends('back.empty')
@section('style')

@endsection
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="menu-icon mdi mdi-account-multiple"></i>Edit Customer</h4>
                </div>
                <div class="card-body">

            <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

           <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name',  $customer->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email',  $customer->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date"
                                       class="form-control @error('birthdate') is-invalid @enderror"
                                       id="birthdate"
                                       name="birthdate"
                                       value="{{ old('birthdate',  $customer->birthdate) }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
             <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender"
                                        name="gender"
                                        required>
                                    <option value="1" {{ old('gender', $customer->gender) == '1' ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ old('gender', $customer->gender) == '0' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


            <div class="mb-3">
                <label>Image</label>
                @if($customer->photo)
                    <div><img src="{{ asset('storage/'.$customer->photo) }}" width="100"></div>
                @endif
                <input type="file" name="photo" class="form-control">
            </div>

             <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Manager <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror"
                                        id="user_id"
                                        name="user_id"
                                        required>
                                    <option value="">Select Manager</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $customer->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

             <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="1" {{ old('status',  $customer->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status',  $customer->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

            <div class="mb-3">
                <input type="checkbox" name="fav_client" value="1" {{ $customer->fav_client ? 'checked' : '' }}> مفضل
            </div>

            <div class="d-flex justify-content-between">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                               Update Employee
                            </button>
                        </div>
        </form>
    </div></div>
@endsection
{{--
@extends('back.empty')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="menu-icon mdi mdi-account-multiple"></i>Edit Employee</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $employee->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $employee->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <small>(Leave blank to keep current)</small></label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date"
                                       class="form-control @error('birthdate') is-invalid @enderror"
                                       id="birthdate"
                                       name="birthdate"
                                       value="{{ old('birthdate', $employee->birthdate) }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="job" class="form-label">Job Title</label>
                                <input type="text"
                                       class="form-control @error('job') is-invalid @enderror"
                                       id="job"
                                       name="job"
                                       value="{{ old('job', $employee->job) }}">
                                @error('job')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender"
                                        name="gender"
                                        required>
                                    <option value="1" {{ old('gender', $employee->gender) == '1' ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ old('gender', $employee->gender) == '0' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="number"
                                       class="form-control @error('salary') is-invalid @enderror"
                                       id="salary"
                                       name="salary"
                                       step="0.01"
                                       value="{{ old('salary', $employee->salary) }}">
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="commission" class="form-label">Commission</label>
                                <input type="number"
                                       class="form-control @error('commission') is-invalid @enderror"
                                       id="commission"
                                       name="commission"
                                       step="0.01"
                                       value="{{ old('commission', $employee->commission) }}">
                                @error('commission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Manager <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror"
                                        id="user_id"
                                        name="user_id"
                                        required>
                                    <option value="">Select Manager</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $employee->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="1" {{ old('status', $employee->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $employee->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            @if($employee->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $employee->photo) }}"
                                         alt="{{ $employee->name }}"
                                         class="img-thumbnail"
                                         width="100">
                                </div>
                            @endif
                            <input type="file"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   id="photo"
                                   name="photo"
                                   accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                               Update Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


--}}

