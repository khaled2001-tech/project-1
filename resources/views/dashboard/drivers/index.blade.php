@extends('dashboard.layouts.master')

@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Drivers</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Driver List</span>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- Flash Toast --}}
@if(session('success'))
    <div data-toast="success" style="display:none">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div data-toast="danger" style="display:none">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div data-toast="danger" style="display:none">{{ implode(' | ', $errors->all()) }}</div>
@endif

<div class="row row-sm">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mg-b-0">Drivers Table</h4>
                    {{-- Add: Modal فقط --}}
                    <a class="modal-effect btn btn-outline-primary"
                       data-effect="effect-scale"
                       data-toggle="modal"
                       href="#addModal">
                        <i class="fas fa-plus mr-1"></i> Add Driver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($drivers as $driver)
                            <tr>
                                <td>{{ $driver->id }}</td>
                                <td>
                                    @if($driver->photo)
                                        <img src="{{ asset('storage/' . $driver->photo) }}"
                                             class="rounded-circle" width="40" height="40"
                                             style="object-fit:cover;" alt="photo">
                                    @else
                                        <div class="rounded-circle bg-secondary d-inline-flex
                                                    align-items-center justify-content-center"
                                             style="width:40px;height:40px;">
                                            <span class="text-white font-weight-bold">
                                                {{ strtoupper(substr($driver->name ?? 'D', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $driver->name ?? '—' }}</td>
                                <td>{{ $driver->email ?? '—' }}</td>
                                <td>{{ $driver->gender ? 'Male' : 'Female' }}</td>
                                <td>${{ number_format($driver->salary ?? 0, 2) }}</td>
                                <td>
                                    @if($driver->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- View --}}
                                    <a href="{{ route('drivers.show', $driver->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    {{-- Edit → صفحة منفصلة --}}
                                    <a href="{{ route('drivers.edit', $driver->id) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Delete → صفحة منفصلة --}}
                                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete {{  $driver->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-trigger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No drivers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ════════════════ ADD MODAL ════════════════ --}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Driver</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Birthdate</label>
                            <input type="date" name="birthdate" class="form-control"
                                   value="{{ old('birthdate') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="1" {{ old('gender','1') == '1' ? 'selected' : '' }}>Male</option>
                                <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status','1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" class="form-control"
                                   step="0.01" min="0" value="{{ old('salary', 0) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Driver</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ URL::asset('assets/dashboard/js/flash-toast.js') }}"></script>
@endsection
