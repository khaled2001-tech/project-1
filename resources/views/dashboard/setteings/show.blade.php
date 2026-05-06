@extends('back.empty')

@section('title', 'عرض الإعدادات')

@section('style')

@endsection
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                      Inforamation Website
                    </h4>
                    <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-edit me-1"></i>
                       Change Settings
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- شعار الموقع -->
                    @if($setting->logo)
                        <div class="text-center mb-4 pb-4 border-bottom">
                            <img src="{{ asset('storage/' . $setting->logo) }}"
                                 alt="شعار الموقع"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-width: 250px; max-height: 250px;">
                        </div>
                    @endif

                    <!-- اسم الموقع -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-building text-dark fs-5 me-2"></i>
                            <h6 class="text-muted mb-0">Title Website</h6>
                        </div>
                        <p class="fs-5 fw-bold text-dark ms-4">{{ $setting->name }}</p>
                    </div>

                    <!-- رقم الهاتف -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-phone text-dark fs-5 me-2"></i>
                            <h6 class="text-muted mb-0">Number Phone</h6>
                        </div>
                        <p class="fs-5 text-dark ms-4">
                            <a href="tel:{{ $setting->phone }}" class="text-decoration-none text-dark">
                                {{ $setting->phone }}
                            </a>
                        </p>
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-envelope text-dark fs-5 me-2"></i>
                            <h6 class="text-muted mb-0">Email</h6>
                        </div>
                        <p class="fs-5 text-dark ms-4">
                            <a href="mailto:{{ $setting->email }}" class="text-decoration-none text-dark">
                                {{ $setting->email }}
                            </a>
                        </p>
                    </div>

                    <!-- عن الموقع -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-info-circle text-dark fs-5 me-2"></i>
                            <h6 class="text-muted mb-0">About Website</h6>
                        </div>
                        <div class="card bg-light border-0 ms-4">
                            <div class="card-body">
                                <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $setting->about }}</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
