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

                    <button type="button"class="modal-effect btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createCarModal">
                        <i class="fas fa-plus"></i> Add New Car
                    </button>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">Manage all cars — rent & sale listings.</p>
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
                                    data-status="{{ (string)$car->status }}"
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
                                    <span class="badge bg-{{ $car->body_type == 'rent' ? 'secondary' : 'success' }}">
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
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-secondary btn-reviews"

                                            title="Ratings & Comments">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                       <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete {{  $car->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-trigger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
  <div class="d-flex align-items-center gap-2">

    {{-- Previous Page --}}
    @if ($cars->onFirstPage())
        <button class="btn btn-outline-primary" disabled>
            <i class="fas fa-chevron-left"></i> Previous
        </button>
    @else
        <a href="{{ $cars->previousPageUrl() }}" class="btn btn-outline-primary">
            <i class="fas fa-chevron-left"></i> Previous
        </a>
    @endif

    {{-- Page Info --}}
    <span class="text-muted small">
        Page {{ $cars->currentPage() }} of {{ $cars->lastPage() }}
    </span>

    {{-- Next Page --}}
    @if ($cars->hasMorePages())
        <a href="{{ $cars->nextPageUrl() }}" class="btn btn-outline-primary">
            Next <i class="fas fa-chevron-right"></i>
        </a>
    @else
        <button class="btn btn-outline-secondary btn-sm" disabled>
            Next <i class="fas fa-chevron-right"></i>
        </button>
    @endif

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
                    <button type="submit" class="btn btn-primary"> Save Car</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection


