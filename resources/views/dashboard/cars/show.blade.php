@extends('dashboard.layouts.master')

@section('title', 'Car Details')

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Cars</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Car Details</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row row-sm">

    {{-- ===== TOP ACTION BAR ===== --}}
    <div class="col-md-12 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-0">{{ $car->name }}</h3>
                <small class="text-muted">ID: #{{ $car->id }}</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

    {{-- ===== CAR IMAGE + MAIN INFO ===== --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-body text-center p-3">
                @if($car->img)
                    <img src="{{ asset('storage/' . $car->img) }}"
                         alt="{{ $car->name }}"
                         class="img-fluid rounded"
                         style="max-height: 350px; width: 100%; object-fit: cover;">
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center bg-light rounded"
                         style="height: 250px;">
                        <i class="fas fa-car fa-4x text-muted mb-2"></i>
                        <span class="text-muted">No Image Available</span>
                    </div>
                @endif
            </div>

            {{-- Rating Summary under image --}}
            <div class="card-footer text-center py-3">
                @php $avg = $car->ratings->count() ? round($car->ratings->avg('rating'), 1) : 0; @endphp
                <div class="mb-1">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= round($avg) ? '' : '-o' }} text-warning fs-5"></i>
                    @endfor
                </div>
                <span class="fw-bold fs-5 text-warning">{{ $avg }}</span>
                <span class="text-muted">/ 5</span>
                <small class="d-block text-muted">{{ $car->ratings->count() }} rating(s) &nbsp;|&nbsp; {{ $car->comments->count() }} comment(s)</small>
            </div>
        </div>
    </div>

    {{-- ===== CAR DETAILS ===== --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Car Information</h5>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Car Name</label>
                        <p class="mb-0">{{ $car->name }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Brand</label>
                        <p class="mb-0">{{ $car->brand->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Model</label>
                        <p class="mb-0">{{ $car->model->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Type</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $car->body_type == 'rent' ? 'info' : 'success' }}">
                                {{ ucfirst($car->body_type) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Price</label>
                        <p class="mb-0 text-success fw-bold fs-5">${{ number_format($car->price, 2) }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Discount</label>
                        <p class="mb-0">
                            @if($car->discount > 0)
                                <span class="text-danger fw-bold">{{ $car->discount }}%</span>
                                <small class="d-block text-success">
                                    After: ${{ number_format($car->price - ($car->price * $car->discount / 100), 2) }}
                                </small>
                            @else
                                <span class="text-muted">No Discount</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Color</label>
                        <p class="mb-0">{{ $car->color ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Manufacturing Year</label>
                        <p class="mb-0">{{ $car->menufacturing_year ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Engine Capacity</label>
                        <p class="mb-0">{{ $car->engine_capacity ? $car->engine_capacity . ' CC' : 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Transmission</label>
                        <p class="mb-0">{{ $car->transmission_type ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Number of Doors</label>
                        <p class="mb-0">{{ $car->number_doors ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Available Count</label>
                        <p class="mb-0">{{ $car->count ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Contact Phone</label>
                        <p class="mb-0">{{ $car->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Status</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $car->status ? 'success' : 'danger' }}">
                                {{ $car->status ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($car->created_by)
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Created By</label>
                        <p class="mb-0">{{ $car->creator->name ?? 'N/A' }}</p>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Created At</label>
                        <p class="mb-0">{{ $car->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <div class="col-6">
                        <label class="tx-11 text-muted fw-bold text-uppercase">Last Updated</label>
                        <p class="mb-0">{{ $car->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== RESERVATIONS ===== --}}
    @if($car->reservation && $car->reservation->count() > 0)
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i>
                    Reservations
                    <span class="badge bg-white text-info ms-2">{{ $car->reservation->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($car->reservation->take(5) as $reservation)
                            <tr>
                                <td>{{ $reservation->customer_name ?? 'N/A' }}</td>
                                <td>{{ $reservation->reservation_date ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $reservation->status ?? 'N/A' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== RATINGS ===== --}}
    <div class="col-md-6 mt-3">
        <div class="card h-100">
            <div class="card-header" style="background-color: #f6c23e;">
                <h5 class="mb-0 text-dark">
                    <i class="fas fa-star me-2"></i>
                    Ratings
                    <span class="badge bg-dark ms-2">{{ $car->ratings->count() }}</span>
                </h5>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">

                @if($car->ratings->count())
                    {{-- Average Summary --}}
                    <div class="text-center mb-3 pb-3 border-bottom">
                        <span class="display-5 fw-bold text-warning">{{ $avg }}</span>
                        <span class="text-muted fs-5">/ 5</span>
                        <div class="my-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= round($avg) ? '' : '-o' }} text-warning fs-5"></i>
                            @endfor
                        </div>
                        <small class="text-muted">Based on {{ $car->ratings->count() }} rating(s)</small>
                    </div>

                    {{-- Individual Ratings --}}
                    @foreach($car->ratings as $rating)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>
                                        <i class="fas fa-user-circle me-1 text-muted"></i>
                                        {{ $rating->user->name ?? 'Unknown User' }}
                                    </strong>
                                    <div class="mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $rating->rating ? '' : '-o' }} text-warning"></i>
                                        @endfor
                                        <span class="badge bg-warning text-dark ms-1">{{ $rating->rating }}/5</span>
                                    </div>
                                    @if($rating->review)
                                        <p class="text-muted mt-1 mb-0 small">
                                            <i class="fas fa-quote-left me-1"></i>{{ $rating->review }}
                                        </p>
                                    @endif
                                </div>
                                <small class="text-muted text-nowrap ms-3">
                                    {{ $rating->created_at->format('Y-m-d') }}
                                </small>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-star fa-3x mb-3 d-block" style="opacity:0.2;"></i>
                        No ratings yet.
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ===== COMMENTS ===== --}}
    <div class="col-md-6 mt-3">
        <div class="card h-100">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i>
                    Comments
                    <span class="badge bg-light text-dark ms-2">{{ $car->comments->count() }}</span>
                </h5>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">

                @if($car->comments->count())
                    @foreach($car->comments as $comment)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <strong>
                                        <i class="fas fa-user-circle me-1 text-secondary"></i>
                                        {{ $comment->customer->name ?? 'Unknown User' }}
                                    </strong>
                                    <p class="mb-0 mt-1 text-dark">{{ $comment->comment }}</p>
                                </div>
                                <small class="text-muted text-nowrap ms-3">
                                    {{ $comment->created_at->format('Y-m-d H:i') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-comments fa-3x mb-3 d-block" style="opacity:0.2;"></i>
                        No comments yet.
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>
@endsection
