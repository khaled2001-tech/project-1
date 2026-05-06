@extends('dashboard.layouts.master')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Car Sale Requests</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Request #{{ $carSaleRequest->id }}</span>
        </div>
    </div>
</div>
@endsection

@section('content')

@if(session('success'))
    <div data-toast="success" style="display:none">{{ session('success') }}</div>
@endif

<div class="row">
    {{-- ── LEFT: Car Details ── --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    {{ $carSaleRequest->brand }} {{ $carSaleRequest->model }}
                    <span class="badge badge-{{ $carSaleRequest->status }} ml-2">
                        {{ ucfirst(str_replace('_',' ',$carSaleRequest->status)) }}
                    </span>
                </h5>
                <a href="{{ route('car-sale-requests.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
            <div class="card-body">

                {{-- Images --}}
                @php $imgs = $carSaleRequest->images ?? []; @endphp
                @if(count($imgs))
                <div class="row mb-4">
                    @foreach($imgs as $img)
                    <div class="col-4 mb-2">
                        <img src="{{ asset('storage/'.$img) }}"
                             class="img-fluid rounded"
                             style="height:160px; width:100%; object-fit:cover;"
                             alt="car image">
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4 text-muted mb-4" style="background:#f8f9fa; border-radius:8px;">
                    <i class="fas fa-image fa-3x mb-2"></i><br>No images uploaded
                </div>
                @endif

                {{-- Specs Grid --}}
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr><th class="text-muted" width="140">Brand</th><td>{{ $carSaleRequest->brand }}</td></tr>
                            <tr><th class="text-muted">Model</th><td>{{ $carSaleRequest->model }}</td></tr>
                            <tr><th class="text-muted">Year</th><td>{{ $carSaleRequest->year }}</td></tr>
                            <tr><th class="text-muted">Color</th><td>{{ $carSaleRequest->color ?? '—' }}</td></tr>
                            <tr><th class="text-muted">Condition</th>
                                <td><span class="badge {{ $carSaleRequest->condition === 'new' ? 'badge-primary' : 'badge-secondary' }}">
                                    {{ ucfirst($carSaleRequest->condition) }}</span></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr><th class="text-muted" width="140">Price</th>
                                <td><strong class="text-success">${{ number_format($carSaleRequest->price, 2) }}</strong></td></tr>
                            <tr><th class="text-muted">Mileage</th><td>{{ number_format($carSaleRequest->mileage) }} km</td></tr>
                            <tr><th class="text-muted">Transmission</th><td>{{ ucfirst($carSaleRequest->transmission) }}</td></tr>
                            <tr><th class="text-muted">Fuel Type</th><td>{{ ucfirst($carSaleRequest->fuel_type) }}</td></tr>
                            <tr><th class="text-muted">Doors</th><td>{{ $carSaleRequest->number_doors }}</td></tr>
                        </table>
                    </div>
                </div>

                <hr>
                <h6 class="font-weight-bold">Description</h6>
                <p class="text-muted">{{ $carSaleRequest->description }}</p>

                @if($carSaleRequest->admin_notes)
                <hr>
                <h6 class="font-weight-bold">Admin Notes</h6>
                <div class="alert alert-info mb-0">{{ $carSaleRequest->admin_notes }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Customer + Actions ── --}}
    <div class="col-lg-4">

        {{-- Customer Info --}}
        <div class="card mb-4">
            <div class="card-header"><h6 class="mb-0">Customer</h6></div>
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:56px;height:56px;">
                    <span class="text-white font-weight-bold" style="font-size:1.4rem;">
                        {{ strtoupper(substr($carSaleRequest->customer->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
                <h6 class="mb-0">{{ $carSaleRequest->customer->name ?? '—' }}</h6>
                <small class="text-muted">{{ $carSaleRequest->customer->email ?? '—' }}</small><br>
                <small class="text-muted">{{ $carSaleRequest->customer->phone ?? '' }}</small>
                <hr>
                <small class="text-muted">Submitted {{ $carSaleRequest->created_at->diffForHumans() }}</small>
            </div>
        </div>

        {{-- Actions --}}
        @if($carSaleRequest->status === 'pending' || $carSaleRequest->status === 'needs_modification')
        <div class="card mb-4">
            <div class="card-header"><h6 class="mb-0">Actions</h6></div>
            <div class="card-body">

                {{-- Approve --}}
                <form action="{{ route('car-sale-requests.approve', $carSaleRequest->id) }}" method="POST" class="mb-3">
                    @csrf
                    <label class="form-label font-weight-bold">Approve Note (optional)</label>
                    <textarea name="admin_notes" class="form-control mb-2" rows="2"
                              placeholder="Add a note for the customer..."></textarea>
                    <button type="submit" class="btn btn-success btn-block"
                            onclick="return confirm('Approve this request?')">
                        <i class="fas fa-check mr-1"></i> Approve Request
                    </button>
                </form>

                <hr>

                {{-- Needs Modification --}}
                <form action="{{ route('car-sale-requests.needs-modification', $carSaleRequest->id) }}" method="POST" class="mb-3">
                    @csrf
                    <label class="form-label font-weight-bold">Needs Modification Note <span class="text-danger">*</span></label>
                    <textarea name="admin_notes" class="form-control mb-2" rows="2"
                              placeholder="What should the customer change?" required></textarea>
                    <button type="submit" class="btn btn-info btn-block">
                        <i class="fas fa-edit mr-1"></i> Request Modification
                    </button>
                </form>

                <hr>

                {{-- Reject --}}
                <form action="{{ route('car-sale-requests.reject', $carSaleRequest->id) }}" method="POST">
                    @csrf
                    <label class="form-label font-weight-bold">Rejection Reason <span class="text-danger">*</span></label>
                    <textarea name="admin_notes" class="form-control mb-2" rows="2"
                              placeholder="Explain why you're rejecting this..." required></textarea>
                    <button type="submit" class="btn btn-danger btn-block"
                            onclick="return confirm('Reject this request?')">
                        <i class="fas fa-times mr-1"></i> Reject Request
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card mb-4">
            <div class="card-body text-center text-muted py-4">
                <i class="fas fa-check-circle fa-2x mb-2 {{ $carSaleRequest->isApproved() ? 'text-success' : 'text-danger' }}"></i><br>
                This request has been <strong>{{ $carSaleRequest->status }}</strong>.
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@section('js')
<script src="{{ URL::asset('assets/dashboard/js/flash-toast.js') }}"></script>
@endsection
