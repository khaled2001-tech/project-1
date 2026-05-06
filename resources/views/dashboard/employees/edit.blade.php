@extends('dashboard.layouts.master')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Employees</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit Employee</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h4 class="mb-0 text-dark">
                    <i class="fas fa-user-edit mr-2"></i>Edit Employee
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('employees.update', $employees->id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ── Row 1: Name / Email ── --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $employees->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $employees->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Row 2: Password / Phone ── --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Password <small class="text-muted">(leave blank to keep current)</small>
                            </label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $employees->phone) }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Row 3: Job / Birthdate ── --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" name="job"
                                   class="form-control @error('job') is-invalid @enderror"
                                   value="{{ old('job', $employees->job) }}">
                            @error('job')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Birthdate</label>
                            <input type="date" name="birthdate"
                                   class="form-control @error('birthdate') is-invalid @enderror"
                                   value="{{ old('birthdate', $employees->birthdate) }}">
                            @error('birthdate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Row 4: Gender / Status / Photo ── --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender"
                                    class="form-control @error('gender') is-invalid @enderror" required>
                                <option value="1" {{ old('gender', $employees->gender) == 1 ? 'selected' : '' }}>Male</option>
                                <option value="0" {{ old('gender', $employees->gender) == 0 ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', $employees->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $employees->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Photo</label>
                            @if($employees->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $employees->photo) }}"
                                         alt="{{ $employees->name }}"
                                         class="img-thumbnail rounded-circle"
                                         width="60" height="60">
                                </div>
                            @endif
                            <input type="file" name="photo"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   accept="image/*">
                            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Row 5: Salary / Commission ── --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary"
                                   class="form-control @error('salary') is-invalid @enderror"
                                   step="0.01"
                                   value="{{ old('salary', $employees->salary) }}">
                            @error('salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Commission</label>
                            <input type="number" name="commission"
                                   class="form-control @error('commission') is-invalid @enderror"
                                   step="0.01"
                                   value="{{ old('commission', $employees->commission) }}">
                            @error('commission')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- ── Buttons ── --}}
                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i> Update Employee
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
