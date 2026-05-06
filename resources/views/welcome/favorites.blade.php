@extends('welcome.layout')

@section('title', 'My Favorites')

@section('content')

    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4">My Favorites</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
                <li class="breadcrumb-item active text-primary">My Favorites</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">

            @if($favorites->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                    <p class="text-muted fs-5">You have no favorite cars yet.</p>
                    <a href="{{ route('welcome.buycar') }}" class="btn btn-primary rounded-pill px-4">
                        Browse Cars
                    </a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($favorites as $fav)
                        @php $car = $fav->vehicle; @endphp

                        @if($car)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="categories-item p-4 h-100">
                                <div class="categories-item-inner h-100 d-flex flex-column">

                                    <div class="categories-img rounded-top">
                                        <img src="{{ asset('storage/' . $car->img) }}"
                                             class="img-fluid w-100 rounded-top"
                                             style="height: 200px; object-fit: cover;"
                                             alt="{{ $car->name }}">
                                    </div>

                                    <div class="categories-content rounded-bottom p-4 d-flex flex-column flex-grow-1">

                                        <h4>{{ $car->brand->name ?? '' }} {{ $car->name }}</h4>

                                        <div class="mb-4">
                                            <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">
                                                ${{ number_format($car->price) }}
                                            </h4>
                                        </div>

                                        <div class="row gy-2 gx-0 text-center mb-4">
                                            <div class="col-4 border-end border-white">
                                                <i class="fa fa-car text-dark"></i>
                                                <span class="text-body ms-1">{{ $car->transmission_type }}</span>
                                            </div>
                                            <div class="col-4 border-end border-white">
                                                <i class="fa fa-calendar text-dark"></i>
                                                <span class="text-body ms-1">{{ $car->menufacturing_year }}</span>
                                            </div>
                                            <div class="col-4">
                                                <i class="fa fa-tag text-dark"></i>
                                                <span class="text-body ms-1">{{ $car->body_type }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-auto d-flex flex-column gap-2">

                                            {{-- Remove from Favorites --}}
                                            <form action="{{ route('welcome.favorites.toggle', $car->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger rounded-pill w-25 py-2">
                                                    <i class="fas fa-heart-broken me-1"></i>
                                                </button>
                                            </form>

                                            {{-- Buy/Rent --}}
                                            @if($car->status == 1)
                                                <a href="{{ route('welcome.booking.show', $car->id) }}"
                                                   class="btn btn-primary rounded-pill py-3 text-center">
                                                    {{ $car->body_type == 'BUY' ? 'Buy Now' : 'Rent Now' }}
                                                </a>
                                            @else
                                                <button class="btn btn-secondary rounded-pill py-3 w-100" disabled>
                                                    Not Available
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>
    </div>

@endsection
