@extends('welcome.layout')

@section('title', 'Cental - Rent-Car')

@section('content')

<!-- Header / Breadcrumb Start -->
<div class="container-fluid bg-breadcrumb mb-5">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Rent-Vehicles</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-primary">Rent-Vehicles</li>
        </ol>
    </div>
</div>
<!-- Header End -->


<!-- Car Categories Start -->
<div class="container-fluid categories py-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h1 class="display-5 text-capitalize mb-3">Cars For <span class="text-primary">RENT</span></h1>
            <p class="mb-0">Browse our available cars for Rent.</p>
        </div>
<!-- Filter Section Start -->
<div class="container-fluid py-4 bg-light mb-4">
    <div class="container">
        <form method="GET" action="{{ url()->current() }}">
            <div class="row g-3 align-items-end">

                {{-- Name --}}
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fw-semibold">Car Name</label>
                    <input type="text"
                           name="name"
                           value="{{ request('name') }}"
                           class="form-control rounded-pill"
                           placeholder="Search name...">
                </div>

                {{-- Brand --}}
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fw-semibold">Brand</label>
                    <select name="brand_id" class="form-select rounded-pill">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Model --}}
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fw-semibold">Model</label>
                    <select name="model_id" class="form-select rounded-pill">
                        <option value="">All Models</option>
                        @foreach($models as $model)
                            <option value="{{ $model->id }}" {{ request('model_id') == $model->id ? 'selected' : '' }}>
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Min Price --}}
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fw-semibold">Min Price ($)</label>
                    <input type="number"
                           name="min_price"
                           value="{{ request('min_price') }}"
                           class="form-control rounded-pill"
                           placeholder="0"
                           min="0">
                </div>

                {{-- Max Price --}}
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label fw-semibold">Max Price ($)</label>
                    <input type="number"
                           name="max_price"
                           value="{{ request('max_price') }}"
                           class="form-control rounded-pill"
                           placeholder="Any"
                           min="0">
                </div>

                {{-- Buttons --}}
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 w-100">
                        <i class="fa fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary rounded-pill px-3">
                        <i class="fa fa-times"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- Filter Section End -->

        {{-- Results Count --}}
        @if(request()->hasAny(['name', 'brand_id', 'model_id', 'min_price', 'max_price']))
        <div class="mb-4">
            <span class="badge bg-primary fs-6 rounded-pill px-4 py-2">
                {{ $cars->count() }} Result(s) Found
            </span>
            <a href="{{ url()->current() }}" class="ms-2 text-muted small">Clear filters</a>
        </div>
        @endif

        <div class="row g-4">
            @forelse($cars as $car)
            <div class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="categories-item p-4 h-100">
                    <div class="categories-item-inner h-100 d-flex flex-column">

                        {{-- Image --}}
                        <div class="categories-img rounded-top">
                            <img src="{{ asset('storage/' . $car->img) }}"
                                 class="img-fluid w-100 rounded-top"
                                 style="height: 200px; object-fit: cover;"
                                 alt="{{ $car->name }}">
                        </div>

                        <div class="categories-content rounded-bottom p-4 d-flex flex-column flex-grow-1">

                            {{-- Title --}}
                            <h4>{{ $car->brand->name ?? '' }} {{ $car->name }}</h4>

                            {{-- Model Badge --}}
                            @if($car->model)
                            <span class="badge bg-light text-dark mb-2">{{ $car->model->name }}</span>
                            @endif

                            {{-- Stars --}}
                            <div class="categories-review mb-4">
                                <div class="d-flex justify-content-center text-secondary">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i > 4 ? ' text-body' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="mb-4">
                                <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">
                                    ${{ number_format($car->price) }}/Day
                                </h4>
                            </div>

                            {{-- Specs --}}
                            <div class="row gy-2 gx-0 text-center mb-4">
                                <div class="col-4 border-end border-white">
                                    <i class="fa fa-cogs text-dark"></i>
                                    <span class="text-body ms-1">{{ $car->transmission_type }}</span>
                                </div>
                                <div class="col-4 border-end border-white">
                                    <i class="fa fa-calendar text-dark"></i>
                                    <span class="text-body ms-1">{{ $car->menufacturing_year }}</span>
                                </div>
                                <div class="col-4">
                                    <i class="fa fa-door-open text-dark"></i>
                                    <span class="text-body ms-1">{{ $car->number_doors }}D</span>
                                </div>
                            </div>

                            {{-- Status Badge --}}
                            <div class="mb-3">
                                @if($car->status == 1)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-secondary">Not Available</span>
                                @endif
                            </div>
{{-- Favorite + Buy Button --}}
<div class="mt-auto">

    {{-- زر المفضلة --}}
    @auth
        <form action="{{ route('welcome.favorites.toggle', $car->id) }}" method="POST" class="mb-2">
            @csrf
            <button type="submit"
                class="btn w-5 rounded-pill py-2 {{ in_array($car->id, $userFavorites) ? 'btn-danger' : 'btn-outline-danger' }}">
                <i class="fas fa-heart me-1"></i>
                {{ in_array($car->id, $userFavorites) ? 'Re' : 'Add' }}
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill w-100 py-2 mb-2">
            <i class="fas fa-heart me-1"></i> Add to Favorites
        </a>
    @endauth

    {{-- زر الشراء الموجود أصلاً --}}
    @if($car->status == 1)
        <a href="{{ route('welcome.booking.show', $car->id) }}"
           class="btn btn-primary rounded-pill d-flex justify-content-center py-3">
            Buy Now
        </a>
    @else
        <button class="btn btn-secondary rounded-pill d-flex justify-content-center py-3 w-100" disabled>
            Not Available
        </button>
    @endif

</div>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="col-12 text-center py-5">
                <i class="fa fa-car fa-3x text-muted mb-3 d-block"></i>
                <p class="text-muted fs-5">No Cars Found matching your filters.</p>
                <a href="{{ url()->current() }}" class="btn btn-outline-primary rounded-pill mt-2">
                    Clear Filters
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>
<!-- Car Categories End -->

@endsection
