{{-- @extends('back.empty')
@section('style')

@endsection
@section('content')
 <div class="container mt-4">
        <h2>Customers</h2>
        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Create</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                   <td>{{ $customer->gender == 1 ? 'Male' : 'Female' }}</td>
                    <td>{{ $customer->email }}</td>
                     <td>
                                                <div class="btn-group" role="group">
                                                      <a href="{{ route('customers.edit', $customer) }}">
                                                   <i class="fas fa-edit" style="cursor: pointer; font-size: 20px;" >
                                                   </i>
                                                </a>
                                                    <form action="{{ route('customers.destroy',  $customer->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <i class="bi bi-trash text-danger"style="cursor: pointer; font-size: 20px;"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this employee?')) { this.closest('form').submit(); }">
                                                        </i>
                                                    </form>
                                                </div>
                                            </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection --}}
@extends('dashboard.layouts.master')

@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">customers</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ customers List</span>
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
                    <h4 class="card-title mg-b-0">customers Table</h4>
                    {{-- Add: Modal فقط --}}
                    <a class="modal-effect btn btn-outline-primary"
                       data-effect="effect-scale"
                       data-toggle="modal"
                       href="#addModal">
                        <i class="fas fa-plus mr-1"></i> Add Customer
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                 <th>photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                  <td>
                                    @if($customer->photo)
                                        <img src="{{ asset('storage/' . $customer->photo) }}"
                                             class="rounded-circle" width="40" height="40"
                                             style="object-fit:cover;" alt="photo">
                                    @else
                                        <div class="rounded-circle bg-secondary d-inline-flex
                                                    align-items-center justify-content-center"
                                             style="width:40px;height:40px;">
                                            <span class="text-white font-weight-bold">
                                                {{ strtoupper(substr($customer->name ?? 'D', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $customer->name ?? '—' }}</td>
                                <td>{{ $customer->email ?? '—' }}</td>
                                <td>{{ $customer->gender ? 'Male' : 'Female' }}</td>
                                <td>
                                    @if($customer->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                    <td>{{ $customer->email ?? '—' }}</td>
                                <td>
                                    {{-- View --}}
                                    <a href="{{ route('customers.show', $customer->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    {{-- Edit → صفحة منفصلة --}}
                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Delete → صفحة منفصلة --}}
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete {{  $customer->name }}?')">
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
                                <td colspan="8" class="text-center py-4 text-muted">No customers found.</td>
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
                <h5 class="modal-title">Add Customers</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   name="phone" value="{{ old('phone') }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ URL::asset('assets/dashboard/js/flash-toast.js') }}"></script>
@endsection
