@extends('dashboard.layouts.master')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Drivers</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Delete Driver</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Delete Driver
                </h4>
            </div>
            <div class="card-body text-center py-4">
                {{-- Driver photo / avatar --}}
                @if($driver->photo)
                    <img src="{{ asset('storage/' . $driver->photo) }}"
                         class="rounded-circle mb-3"
                         width="80" height="80"
                         style="object-fit:cover; border: 3px solid #dc3545;"
                         alt="{{ $driver->name }}">
                @else
                    <div class="rounded-circle bg-secondary d-inline-flex
                                align-items-center justify-content-center mb-3"
                         style="width:80px;height:80px;border:3px solid #dc3545;">
                        <span class="text-white font-weight-bold" style="font-size:2rem;">
                            {{ strtoupper(substr($driver->name ?? 'D', 0, 1)) }}
                        </span>
                    </div>
                @endif

                <h5 class="font-weight-bold">{{ $driver->name }}</h5>
                <p class="text-muted mb-1">{{ $driver->email }}</p>

                <hr>

                <p class="text-danger font-weight-bold mb-1">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Are you sure you want to delete this driver?
                </p>
                <p class="text-muted small mb-4">This action cannot be undone.</p>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('drivers.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Cancel
                    </a>

                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Yes, Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
