@extends('dashboard.layouts.master')

@section('css')
<link href="{{ URL::asset('assets/dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/dashboard/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
<style>
    .stat-card { border-radius: 10px; padding: 1.2rem 1.5rem; color: #fff; position: relative; overflow: hidden; }
    .stat-card .stat-icon { font-size: 2.5rem; opacity: .25; position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); }
    .stat-card h2 { font-size: 2rem; font-weight: 700; margin: 0; }
    .stat-card p  { margin: 0; font-size: .85rem; opacity: .9; }
    .stat-pending  { background: linear-gradient(135deg, #f6a821, #f0750a); }
    .stat-approved { background: linear-gradient(135deg, #28c76f, #0f9b4e); }
    .stat-rejected { background: linear-gradient(135deg, #ea5455, #c0392b); }
    .stat-total    { background: linear-gradient(135deg, #7367f0, #4e3ecf); }
    .badge-pending  { background:#f6a821; color:#fff; }
    .badge-approved { background:#28c76f; color:#fff; }
    .badge-rejected { background:#ea5455; color:#fff; }
    .badge-needs_modification { background:#17a2b8; color:#fff; }
    .filter-tabs .btn { border-radius: 20px; font-size:.82rem; padding: 4px 14px; margin-right:4px; }
    .car-thumb { width:60px; height:45px; object-fit:cover; border-radius:6px; }
    .car-thumb-placeholder { width:60px; height:45px; border-radius:6px; background:#f0f1f5;
        display:inline-flex; align-items:center; justify-content:center; color:#aaa; font-size:1.2rem; }
    .action-btns .btn { padding: 3px 10px; font-size:.78rem; }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Car Sale Requests</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Manage Requests</span>
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

{{-- ── Stats ── --}}
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-card stat-total">
            <h2>{{ $stats['total'] }}</h2>
            <p>Total Requests</p>
            <span class="stat-icon">📋</span>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-card stat-pending">
            <h2>{{ $stats['pending'] }}</h2>
            <p>Pending Review</p>
            <span class="stat-icon">⏳</span>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-card stat-approved">
            <h2>{{ $stats['approved'] }}</h2>
            <p>Approved</p>
            <span class="stat-icon">✅</span>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-card stat-rejected">
            <h2>{{ $stats['rejected'] }}</h2>
            <p>Rejected</p>
            <span class="stat-icon">❌</span>
        </div>
    </div>
</div>

{{-- ── Table ── --}}
<div class="row row-sm">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="card-title mg-b-0">Sale Requests</h4>
                    <div class="filter-tabs">
                        <a href="{{ route('car-sale-requests.index') }}"
                           class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
                        <a href="{{ route('car-sale-requests.index', ['status'=>'pending']) }}"
                           class="btn btn-sm {{ request('status')=='pending' ? 'btn-warning' : 'btn-outline-warning' }}">Pending</a>
                        <a href="{{ route('car-sale-requests.index', ['status'=>'approved']) }}"
                           class="btn btn-sm {{ request('status')=='approved' ? 'btn-success' : 'btn-outline-success' }}">Approved</a>
                        <a href="{{ route('car-sale-requests.index', ['status'=>'rejected']) }}"
                           class="btn btn-sm {{ request('status')=='rejected' ? 'btn-danger' : 'btn-outline-danger' }}">Rejected</a>
                        <a href="{{ route('car-sale-requests.index', ['status'=>'needs_modification']) }}"
                           class="btn btn-sm {{ request('status')=='needs_modification' ? 'btn-info' : 'btn-outline-info' }}">Needs Edit</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Car</th>
                                <th>Customer</th>
                                <th>Price</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>
                                    @php $imgs = $req->images ?? []; @endphp
                                    @if(count($imgs))
                                        <img src="{{ asset('storage/'.$imgs[0]) }}" class="car-thumb" alt="car">
                                    @else
                                        <div class="car-thumb-placeholder">🚗</div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $req->brand }} {{ $req->model }}</strong><br>
                                    <small class="text-muted">{{ $req->year }} · {{ $req->mileage }} km</small>
                                </td>
                                <td>
                                    {{ $req->customer->name ?? '—' }}<br>
                                    <small class="text-muted">{{ $req->customer->email ?? '' }}</small>
                                </td>
                                <td><strong>${{ number_format($req->price, 2) }}</strong></td>
                                <td>
                                    <span class="badge {{ $req->condition === 'new' ? 'badge-primary' : 'badge-secondary' }}">
                                        {{ ucfirst($req->condition) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $req->status }} px-2 py-1">
                                        {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                    </span>
                                </td>
                                <td><small>{{ $req->created_at->format('d M Y') }}</small></td>
                                <td class="action-btns">
                                    <a href="{{ route('car-sale-requests.show', $req->id) }}"
                                       class="btn btn-sm btn-outline-info mb-1">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($req->status === 'pending' || $req->status === 'needs_modification')
                                        {{-- Quick Approve --}}
                                        <form action="{{ route('car-sale-requests.approve', $req->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success mb-1"
                                                    onclick="return confirm('Approve this request?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        {{-- Quick Reject --}}
                                        <button class="btn btn-sm btn-danger mb-1"
                                                data-toggle="modal"
                                                data-target="#rejectModal{{ $req->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- Reject Modal --}}
                            <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Reject Request #{{ $req->id }}</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <form action="{{ route('car-sale-requests.reject', $req->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <label class="form-label font-weight-bold">Reason for rejection <span class="text-danger">*</span></label>
                                                <textarea name="admin_notes" class="form-control" rows="4"
                                                          placeholder="Explain why this request is being rejected..." required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-car fa-2x mb-2 d-block"></i>
                                    No car sale requests found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $requests->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ URL::asset('assets/dashboard/js/flash-toast.js') }}"></script>
@endsection
