{{-- @extends('dashboard.layouts.master')

@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Employees</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Employee List</span>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- Flash Messages --}}
{{-- @if(session('success'))
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
                    <h4 class="card-title mg-b-0">Employees Table</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus mr-1"></i> Add Employee
                    </button>
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
                                <th>Job</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>
                                    @if($employee->photo)
                                        <img src="{{ asset('storage/' . $employee->photo) }}"
                                             class="rounded-circle" width="40" height="40" alt="photo">
                                    @else
                                        <div class="rounded-circle bg-secondary d-inline-flex
                                                    align-items-center justify-content-center"
                                             style="width:40px;height:40px;">
                                            <span class="text-white font-weight-bold">
                                                {{ strtoupper(substr($employee->user->name ?? 'E', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $employee->user->name ?? '—' }}</td>
                                <td>{{ $employee->user->email ?? '—' }}</td>
                                <td>{{ $employee->job ?? '—' }}</td>
                                <td>
                                    @if($employee->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>


                                    {{-- Edit button --}}
                                    {{-- <button class="btn btn-sm btn-outline-primary btn-edit-trigger"
                                        data-id="{{ $employee->id }}"
                                        data-name="{{ $employee->user->name ?? '' }}"
                                        data-email="{{ $employee->user->email ?? '' }}"
                                        data-job="{{ $employee->job ?? '' }}"
                                        data-birthdate="{{ $employee->birthdate ?? '' }}"
                                        data-gender="{{ $employee->gender }}"
                                        data-salary="{{ $employee->salary }}"
                                        data-commission="{{ $employee->commission ?? '' }}"
                                        data-phone="{{ $employee->phone ?? '' }}"
                                        data-status="{{ $employee->status }}"
                                        data-toggle="modal" data-target="#editModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    {{-- Delete button --}}
                                    {{-- <button class="btn btn-sm btn-outline-danger btn-delete-trigger"
                                        data-id="{{ $employee->id }}"
                                        data-name="{{ $employee->user->name ?? 'this employee' }}"
                                        data-toggle="modal" data-target="#deleteModal">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No employees found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> --}}
            {{-- </div>
        </div>
    </div>
</div> --}} --}}


{{-- ════════════════════════════════════════
     ADD MODAL
════════════════════════════════════════ --}}
{{-- <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Employee</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" name="job" class="form-control" value="{{ old('job') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Birthdate</label>
                            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="1" {{ old('gender','1')=='1'?'selected':'' }}>Male</option>
                                <option value="0" {{ old('gender')=='0'?'selected':'' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status','1')=='1'?'selected':'' }}>Active</option>
                                <option value="0" {{ old('status')=='0'?'selected':'' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" class="form-control" step="0.01" value="{{ old('salary',0) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Commission</label>
                            <input type="number" name="commission" class="form-control" step="0.01" value="{{ old('commission') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Employee</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


{{-- ════════════════════════════════════════
     EDIT MODAL
════════════════════════════════════════ --}}
{{-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            {{-- action set by JS | method POST + @method('PUT') = Laravel reads it as PUT --}}
            {{-- <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <small class="text-muted">(blank = keep current)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" name="job" id="edit_job" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Birthdate</label>
                            <input type="date" name="birthdate" id="edit_birthdate" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select  name="gender" id="edit_gender" class="form-control" required>
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" id="edit_salary" class="form-control" step="0.01">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Commission</label>
                            <input type="number" name="commission" id="edit_commission" class="form-control" step="0.01">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Employee</button>
                </div>
            </form>
        </div>
    </div>
</div> --}} --}}

{{-- ════════════════════════════════════════
     DELETE MODAL
     KEY: @method('DELETE') inside a POST form is how Laravel handles delete.
     The form action is set dynamically by JS.
════════════════════════════════════════ --}}
{{-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Employee</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="delete_name"></strong>?</p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
 --}}


{{-- @section('js') --}}
{{-- <script>
    // ─── EDIT modal: fill all fields from data-* attributes ───────────────
    $(document).ready(function () {

    // ─── EDIT modal ───────────────────────────────────────────────────────
    $('.btn-edit-trigger').on('click', function () {
        var btn  = $(this);
        var id   = btn.attr('data-id');           // ← استخدم attr بدل data()
        var base = '{{ url("/dashboard/employees") }}';

        $('#editForm').attr('action', base + '/' + id);

        $('#edit_name').val(btn.attr('data-name'));
        $('#edit_email').val(btn.attr('data-email'));
        $('#edit_job').val(btn.attr('data-job'));
        $('#edit_birthdate').val(btn.attr('data-birthdate'));
        $('#edit_salary').val(btn.attr('data-salary'));
        $('#edit_commission').val(btn.attr('data-commission'));
        $('#edit_phone').val(btn.attr('data-phone'));

        $('#edit_gender').val(btn.attr('data-gender'));   // ← attr بدل data()
        $('#edit_status').val(btn.attr('data-status'));   // ← attr بدل data()
    });

    // ─── DELETE modal ─────────────────────────────────────────────────────
    $('.btn-delete-trigger').on('click', function () {
        var id   = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        var base = '{{ url("/dashboard/employees") }}';

        $('#deleteForm').attr('action', base + '/' + id);
        $('#delete_name').text(name);
    });

});
</script> --}}

{{-- <!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/dashboard/plugins/select2/js/select2.min.js')}}"></script>
 --}}
@extends('dashboard.layouts.master')

@section('css')
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Employees</h4>
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
                    <h4 class="card-title mg-b-0">Employees Table</h4>
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
                            @forelse($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>
                                    @if($employee->photo)
                                        <img src="{{ asset('storage/' . $employee->photo) }}"
                                             class="rounded-circle" width="40" height="40"
                                             style="object-fit:cover;" alt="photo">
                                    @else
                                        <div class="rounded-circle bg-secondary d-inline-flex
                                                    align-items-center justify-content-center"
                                             style="width:40px;height:40px;">
                                            <span class="text-white font-weight-bold">
                                                {{ strtoupper(substr($employee->name ?? 'D', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $employee->name ?? '—' }}</td>
                                <td>{{ $employee->email ?? '—' }}</td>
                                <td>{{ $employee->gender ? 'Male' : 'Female' }}</td>
                                <td>${{ number_format($employee->salary ?? 0, 2) }}</td>
                                <td>
                                    @if($employee->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- View --}}
                                    <a href="{{ route('employees.show', $employee->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    {{-- Edit → صفحة منفصلة --}}
                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Delete → صفحة منفصلة --}}
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete {{  $employee->name }}?')">
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
                                <td colspan="8" class="text-center py-4 text-muted">No Employees found.</td>
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
                <h5 class="modal-title">Add Employees</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
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
