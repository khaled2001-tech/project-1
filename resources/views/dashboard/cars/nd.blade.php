@extends('dashboard.layouts.master')

@section('title', 'Cars Management')

@section('css')
    <link href="{{URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/dashboard/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/dashboard/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/dashboard/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Cars</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Cars Management</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">CARS LIST</h4>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createCarModal">
                        <i class="fas fa-plus"></i> Add New Car
                    </button>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">Manage all cars — rent &amp; sale listings.</p>
            </div>

            <div class="card-body">

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

                {{-- Search & Filters --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="carSearch" class="form-control" placeholder="Search by name, brand, model...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select id="typeFilter" class="form-select">
                            <option value="">All Types</option>
                            <option value="rent">For Rent</option>
                            <option value="buy">For Sale</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="statusFilter" class="form-select">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <span class="text-muted small" id="recordCount"></span>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-hover" id="carsTable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Image</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Brand</th>
                                <th class="border-bottom-0">Model</th>
                                <th class="border-bottom-0">Type</th>
                                <th class="border-bottom-0">Price</th>
                                <th class="border-bottom-0">Year</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Rating</th>
                                <th class="border-bottom-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="carsBody">
                            @forelse($cars as $car)
                            <tr
                                data-name="{{ strtolower($car->name) }}"
                                data-brand="{{ strtolower($car->brand->name ?? '') }}"
                                data-model="{{ strtolower($car->model->name ?? '') }}"
                                data-type="{{ $car->body_type }}"
                                data-status="{{ (int) $car->status }}"
                            >
                                <td>{{ $car->id }}</td>
                                <td>
                                    @if($car->img)
                                        <img src="{{ asset('storage/' . $car->img) }}" alt="{{ $car->name }}"
                                             class="img-thumbnail" style="width:60px;height:60px;object-fit:cover;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $car->name }}</td>
                                <td>{{ $car->brand->name ?? 'N/A' }}</td>
                                <td>{{ $car->model->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $car->body_type == 'rent' ? 'info' : 'success' }}">
                                        {{ ucfirst($car->body_type) }}
                                    </span>
                                </td>
                                <td>${{ number_format($car->price, 2) }}</td>
                                <td>{{ $car->menufacturing_year ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $car->status ? 'success' : 'danger' }}">
                                        {{ $car->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    @php $avg = $car->ratings->avg('rating') ?? 0; @endphp
                                    <span class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= round($avg) ? '' : '-o' }}"></i>
                                        @endfor
                                    </span>
                                    <small class="text-muted">({{ $car->ratings->count() }})</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cars.edit', $car->id) }}"
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-secondary btn-reviews"
                                            data-id="{{ $car->id }}"
                                            data-name="{{ $car->name }}"
                                            data-bs-toggle="modal" data-bs-target="#reviewsModal"
                                            title="Ratings &amp; Comments">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $car->id }}"
                                            data-name="{{ $car->name }}"
                                            data-bs-toggle="modal" data-bs-target="#deleteCarModal"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="11" class="text-center py-4 text-muted">
                                    No cars found. Click "Add New Car" to get started.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3" id="paginationBar">
                    <div class="text-muted small" id="pageInfo"></div>
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm" id="prevBtn">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" id="nextBtn">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


{{-- ==================== CREATE MODAL ==================== --}}
<div class="modal fade" id="createCarModal" tabindex="-1" aria-labelledby="createCarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createCarLabel"><i class="fas fa-plus me-2"></i>Add New Car</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Car Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand <span class="text-danger">*</span></label>
                            <select class="form-select @error('brand_id') is-invalid @enderror" name="brand_id" required>
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Model</label>
                            <select class="form-select @error('model_id') is-invalid @enderror" name="model_id">
                                <option value="">Select Model</option>
                                @foreach($models as $model)
                                    <option value="{{ $model->id }}" {{ old('model_id') == $model->id ? 'selected' : '' }}>
                                        {{ $model->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('model_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('body_type') is-invalid @enderror" name="body_type" required>
                                <option value="">Select Type</option>
                                <option value="rent" {{ old('body_type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                                <option value="buy" {{ old('body_type') == 'buy' ? 'selected' : '' }}>For Sale</option>
                            </select>
                            @error('body_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                   name="price" value="{{ old('price', 0) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount (%)</label>
                            <input type="number" step="0.01" max="100" class="form-control @error('discount') is-invalid @enderror"
                                   name="discount" value="{{ old('discount', 0) }}">
                            @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                   name="color" value="{{ old('color') }}">
                            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Manufacturing Year</label>
                            <input type="number" min="1900" max="{{ date('Y') + 1 }}"
                                   class="form-control @error('menufacturing_year') is-invalid @enderror"
                                   name="menufacturing_year" value="{{ old('menufacturing_year') }}">
                            @error('menufacturing_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Engine Capacity (CC)</label>
                            <input type="number" class="form-control @error('engine_capacity') is-invalid @enderror"
                                   name="engine_capacity" value="{{ old('engine_capacity') }}">
                            @error('engine_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Transmission Type</label>
                            <select class="form-select @error('transmission_type') is-invalid @enderror" name="transmission_type">
                                <option value="">Select Transmission</option>
                                <option value="Manual" {{ old('transmission_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                <option value="Automatic" {{ old('transmission_type') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="CVT" {{ old('transmission_type') == 'CVT' ? 'selected' : '' }}>CVT</option>
                            </select>
                            @error('transmission_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Number of Doors</label>
                            <input type="number" min="2" max="6" class="form-control @error('number_doors') is-invalid @enderror"
                                   name="number_doors" value="{{ old('number_doors', 4) }}">
                            @error('number_doors')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Available Count</label>
                            <input type="number" min="0" class="form-control @error('count') is-invalid @enderror"
                                   name="count" value="{{ old('count') }}">
                            @error('count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   name="phone" value="{{ old('phone') }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Car Image</label>
                            <input type="file" class="form-control @error('img') is-invalid @enderror"
                                   name="img" accept="image/*">
                            @error('img')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Car</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ==================== DELETE MODAL ==================== --}}
<div class="modal fade" id="deleteCarModal" tabindex="-1" aria-labelledby="deleteCarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCarLabel"><i class="fas fa-trash me-2"></i>Delete Car</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteCarForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete car: <strong id="delete_car_name"></strong>?</p>
                    <p class="text-danger small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-1"></i> Confirm Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('js')
<!-- DataTables JS -->
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>

<script>
(function () {

    /* ─────────────────────────────────────────
       CONFIG
    ───────────────────────────────────────── */
    var ROWS_PER_PAGE = 10;

    /* ─────────────────────────────────────────
       ELEMENTS
    ───────────────────────────────────────── */
    var tbody        = document.getElementById('carsBody');
    var searchInput  = document.getElementById('carSearch');
    var typeFilter   = document.getElementById('typeFilter');
    var statusFilter = document.getElementById('statusFilter');
    var prevBtn      = document.getElementById('prevBtn');
    var nextBtn      = document.getElementById('nextBtn');
    var pageInfo     = document.getElementById('pageInfo');
    var recordCount  = document.getElementById('recordCount');

    /* All real data rows (only rows that carry data-name) */
    var allRows = Array.from(tbody.querySelectorAll('tr[data-name]'));

    /* State */
    var filteredRows = [];
    var currentPage  = 1;
    var totalPages   = 1;

    /* ─────────────────────────────────────────
       FILTER
    ───────────────────────────────────────── */
    function applyFilters() {

        var q      = searchInput.value.trim().toLowerCase();  // '' when empty
        var type   = typeFilter.value;                        // '' | 'rent' | 'buy'
        var status = statusFilter.value;                      // '' | '1'   | '0'

        filteredRows = allRows.filter(function (row) {

            /*
             * SEARCH — name / brand / model
             * Use (q === '') instead of !q so that the string '0'
             * is never treated as falsy and skips the filter.
             */
            var matchSearch = (q === '')
                || (row.dataset.name  || '').indexOf(q) !== -1
                || (row.dataset.brand || '').indexOf(q) !== -1
                || (row.dataset.model || '').indexOf(q) !== -1;

            /*
             * TYPE FILTER
             * Same strict check: (type === '') means "show all".
             */
            var matchType = (type === '') || (row.dataset.type === type);

            /*
             * STATUS FILTER
             * data-status is rendered as (int) $car->status in Blade
             * so it is always '0' or '1' — never null/empty/true/false.
             * (status === '') means "show all".
             */
            var matchStatus = (status === '') || (row.dataset.status === status);

            return matchSearch && matchType && matchStatus;
        });

        currentPage = 1;   // always reset to page 1 on any filter change
        render();
    }

    /* ─────────────────────────────────────────
       RENDER — visibility + pagination UI
    ───────────────────────────────────────── */
    function render() {
        var total = filteredRows.length;
        totalPages = Math.max(1, Math.ceil(total / ROWS_PER_PAGE));

        /* Clamp page to valid bounds */
        if (currentPage < 1)          currentPage = 1;
        if (currentPage > totalPages) currentPage = totalPages;

        var start = (currentPage - 1) * ROWS_PER_PAGE;
        var end   = start + ROWS_PER_PAGE;

        /* Hide every data row */
        allRows.forEach(function (r) { r.style.display = 'none'; });

        /* Show only the current-page slice of filtered rows */
        filteredRows.forEach(function (r, i) {
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });

        /* "No results" placeholder */
        var noRow = document.getElementById('noResultsRow');
        if (total === 0) {
            if (!noRow) {
                noRow    = document.createElement('tr');
                noRow.id = 'noResultsRow';
                noRow.innerHTML =
                    '<td colspan="11" class="text-center py-4 text-muted">' +
                    'No cars match your search / filter.</td>';
                tbody.appendChild(noRow);
            }
            noRow.style.display = '';
        } else if (noRow) {
            noRow.style.display = 'none';
        }

        /* Hide the server-side "table is empty" row (if the DB has no cars) */
        var emptyRow = document.getElementById('emptyRow');
        if (emptyRow) { emptyRow.style.display = 'none'; }

        /* Info text */
        var from = (total === 0) ? 0 : start + 1;
        var to   = Math.min(end, total);
        pageInfo.textContent    = 'Showing ' + from + '\u2013' + to + ' of ' + total;
        recordCount.textContent = total + ' record' + (total !== 1 ? 's' : '');

        /* Pagination buttons */
        prevBtn.disabled = (currentPage <= 1);
        nextBtn.disabled = (currentPage >= totalPages);
    }

    /* ─────────────────────────────────────────
       EVENTS — filters
    ───────────────────────────────────────── */
    searchInput .addEventListener('input',  applyFilters);
    typeFilter  .addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);

    /* ─────────────────────────────────────────
       EVENTS — pagination
    ───────────────────────────────────────── */
    prevBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            render();
        }
    });

    nextBtn.addEventListener('click', function () {
        /* Guard added: was unconditional ++, which allowed going
           past the last page and showing an empty view.          */
        if (currentPage < totalPages) {
            currentPage++;
            render();
        }
    });

    /* ─────────────────────────────────────────
       DELETE MODAL
    ───────────────────────────────────────── */
    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('delete_car_name').textContent = this.dataset.name;
            document.getElementById('deleteCarForm').action = '/cars/' + this.dataset.id;
        });
    });

    /* ─────────────────────────────────────────
       INIT
    ───────────────────────────────────────── */
    applyFilters();

})();
</script>
@endsection
