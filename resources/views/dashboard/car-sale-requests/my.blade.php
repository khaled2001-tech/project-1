@extends('welcome.layout')

@section('css')
<style>
.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: .75rem;
    font-weight: 600;
}
.badge-pending   { background: #fff3cd; color: #856404; }
.badge-approved  { background: #d1e7dd; color: #0a3622; }
.badge-rejected  { background: #f8d7da; color: #842029; }
.badge-needs_modification { background: #cff4fc; color: #055160; }

.car-thumb {
    width: 70px; height: 52px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #f0f0f0;
}
.car-thumb-placeholder {
    width: 70px; height: 52px;
    border-radius: 8px;
    background: #f5f5f5;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
}
.empty-state .empty-icon {
    font-size: 4rem;
    margin-bottom: 16px;
    opacity: .25;
}
.empty-state h5 { color: #555; margin-bottom: 8px; }
.empty-state p  { color: #aaa; font-size: .9rem; margin-bottom: 20px; }

.stat-mini {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #f0f0f0;
    padding: 16px 20px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.stat-mini h3 { font-size: 1.8rem; font-weight: 700; margin: 0; }
.stat-mini p  { font-size: .78rem; color: #888; margin: 0; }
.admin-note {
    background: #fff8e1;
    border-left: 3px solid #ffc107;
    border-radius: 0 6px 6px 0;
    padding: 8px 12px;
    font-size: .78rem;
    color: #666;
    margin-top: 4px;
}
.admin-note.rejected { background: #fff0f0; border-color: #dc3545; }
.admin-note.approved { background: #f0fff4; border-color: #28a745; }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">My Sale Requests</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ My Submissions</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <a href="{{ route('welcome.car-sale-requests.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> New Request
        </a>
    </div>
</div>
@endsection

@section('content')

@if(session('success'))
    <div data-toast="success" style="display:none">{{ session('success') }}</div>
@endif

{{-- ── Stats ── --}}
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-mini">
            <h3 class="text-secondary">{{ $requests->total() }}</h3>
            <p>Total</p>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-mini">
            <h3 style="color:#f6a821">{{ $requests->getCollection()->where('status','pending')->count() }}</h3>
            <p>Pending</p>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-mini">
            <h3 class="text-success">{{ $requests->getCollection()->where('status','approved')->count() }}</h3>
            <p>Approved</p>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-mini">
            <h3 class="text-danger">{{ $requests->getCollection()->where('status','rejected')->count() }}</h3>
            <p>Rejected</p>
        </div>
    </div>
</div>

{{-- ── Table ── --}}
<div class="row row-sm">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mg-b-0">My Car Sale Requests</h4>
            </div>
            <div class="card-body">

                @if($requests->isEmpty())
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">🚗</div>
                    <h5>No Requests Yet</h5>
                    <p>You haven't submitted any car sale requests yet.<br>Start by listing your car now!</p>
                    <a href="{{ route('welcome.car-sale-requests.create') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-plus mr-2"></i> Sell My Car
                    </a>
                </div>

                @else

                <div class="table-responsive">
                    <table class="table table-hover table-vcenter mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Car</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Note from Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $req)
                            <tr>
                                <td class="text-muted">{{ $req->id }}</td>

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
                                    <small class="text-muted">
                                        {{ $req->year }} ·
                                        {{ ucfirst($req->transmission) }} ·
                                        {{ number_format($req->mileage) }} km
                                    </small>
                                </td>

                                <td>
                                    <strong class="text-success">${{ number_format($req->price, 2) }}</strong>
                                </td>

                                <td>
                                    <span class="status-badge badge-{{ $req->status }}">
                                        @switch($req->status)
                                            @case('pending')           ⏳ Pending      @break
                                            @case('approved')          ✅ Approved     @break
                                            @case('rejected')          ❌ Rejected     @break
                                            @case('needs_modification') ✏️ Needs Edit  @break
                                        @endswitch
                                    </span>
                                </td>

                                <td>
                                    <small class="text-muted">{{ $req->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $req->created_at->diffForHumans() }}</small>
                                </td>

                                <td style="max-width: 200px;">
                                    @if($req->admin_notes)
                                        <div class="admin-note {{ $req->status }}">
                                            <i class="fas fa-comment-alt mr-1"></i>
                                            {{ $req->admin_notes }}
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size:.78rem;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $requests->links() }}
                </div>

                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ URL::asset('assets/dashboard/js/flash-toast.js') }}"></script>
@endsection
