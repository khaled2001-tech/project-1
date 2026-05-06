@extends('dashboard.layouts.master')

@section('title', 'Reservations Management')

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
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Days</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $reservation)
                                    <tr>
                                        <td>#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <strong>{{ $reservation->customer->name ?? 'N/A' }}</strong><br>
                                            <small>{{ $reservation->customer->email ?? 'N/A'}}</small>
                                        </td>
                                        <td>
                                            {{ $reservation->car->brand->name ?? 'N/A' }}
                                            {{ $reservation->car->name ?? 'N/A' }}
                                        </td>
                                        <td>{{ $reservation->pickup_date->format('M d, Y H:i') }}</td>
                                        <td>{{ $reservation->return_date->format('M d, Y H:i') }}</td>
                                        <td>{{ $reservation->rental_days }}</td>
                                        <td>${{ number_format($reservation->total_price, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $reservation->statusBadge }}">
                                                {{ ucfirst($reservation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('reservations.show', $reservation->id) }}"
                                                   class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                               @if($reservation->status == 'pending')
                                                    {{-- Approve: يروح لصفحة الفورم مش submit مباشرة --}}
                                                    <a href="{{ route('reservations.approve.form', $reservation->id) }}"
                                                    class="btn btn-sm btn-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </a>

                                                    {{-- Reject: POST مباشرة --}}
                                                    <form action="{{ route('reservations.reject', $reservation->id) }}"
                                                        method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Reject this reservation?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('reservations.destroy', $reservation->id) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No reservations found</td>
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
@endsection
