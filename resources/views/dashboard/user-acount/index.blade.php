@extends('dashboard.layouts.master')
@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Account Manager</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Accounts List</span>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- Flash Messages --}}
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
                    <h4 class="card-title mg-b-0">Accounts Table</h4>
                    <button class="btn btn-dark" data-toggle="modal" data-target="#createUserModal">
                        <i class="fas fa-plus mr-1"></i> Add Account
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter text-nowrap mb-0">
                         <thead class="table-dark">
                            <tr class="py-4">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->role === 'manager')
                                                <span class="badge bg-secondary">Manager</span>
                                            @elseif($user->role === 'employee')
                                                <span class="badge bg-dark">Employee</span>
                                            @elseif($user->role === 'driver')
                                                <span class="badge bg-info">Driver</span>
                                            @else
                                                <span class="badge bg-primary">Customer</span>
                                            @endif
                                        </td>
                                        <td>
                                           @if($user->status === 'active')
                                                <span class="badge bg-secondary">Active</span>
                                            @else
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-ban mr-1"></i> Blocked
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-pencil"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                         <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════
     CREATE USER MODAL
════════════════════════════════════════ --}}
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus-fill mr-2"></i> Create New Account
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Enter full name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="example@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="At least 6 characters"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role"
                                    class="form-control @error('role') is-invalid @enderror"
                                    required>
                                <option value="" disabled selected>-- Select Role --</option>
                                <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                                <option value="manager"  {{ old('role') === 'manager'  ? 'selected' : '' }}>Manager</option>
                                <option value="admin"    {{ old('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
                                <option value="driver"   {{ old('role') === 'driver'   ? 'selected' : '' }}>Driver</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required>
                              <option value="active"   {{ old('status', 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                              <option value="blocked"  {{ old('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-check-circle mr-1"></i> Create Account
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@if($errors->any())
<script>
    $(document).ready(function () {
        $('#createUserModal').modal('show');
    });
</script>
@endif

@endsection
