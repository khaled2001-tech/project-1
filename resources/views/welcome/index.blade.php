@extends('welcome.layout')

@section('title', 'Cental - Car Rent Website | Home')

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


    <!-- Carousel Start -->
    <div class="header-carousel mb-5">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="First slide"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Second slide"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="{{  asset('assets/welcome/img/carousel-2.jpg') }}" class="img-fluid w-100" alt="First slide"/>
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="row g-5">
                                <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="bg-secondary rounded p-5">
                                        <h4 class="text-white mb-4">CONTINUE CAR RESERVATION</h4>
                                        <form>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Select Your Car type</option>
                                                        <option value="1">VW Golf VII</option>
                                                        <option value="2">Audi A1 S-Line</option>
                                                        <option value="3">Toyota Camry</option>
                                                        <option value="4">BMW 320 ModernLine</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                            <span class="fas fa-map-marker-alt"></span> <span class="ms-1">Pick Up</span>
                                                        </div>
                                                        <input class="form-control" type="text" placeholder="Enter a City or Airport" aria-label="Enter a City or Airport">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <a href="#" class="text-start text-white d-block mb-2">Need a different drop-off location?</a>
                                                    <div class="input-group">
                                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                            <span class="fas fa-map-marker-alt"></span><span class="ms-1">Drop off</span>
                                                        </div>
                                                        <input class="form-control" type="text" placeholder="Enter a City or Airport" aria-label="Enter a City or Airport">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                            <span class="fas fa-calendar-alt"></span><span class="ms-1">Pick Up</span>
                                                        </div>
                                                        <input class="form-control" type="date">
                                                        <select class="form-select ms-3">
                                                            <option selected>12:00AM</option>
                                                            <option value="1">1:00AM</option>
                                                            <option value="2">2:00AM</option>
                                                            <option value="3">3:00AM</option>
                                                            <option value="4">4:00AM</option>
                                                            <option value="5">5:00AM</option>
                                                            <option value="6">6:00AM</option>
                                                            <option value="7">7:00AM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                            <span class="fas fa-calendar-alt"></span><span class="ms-1">Drop off</span>
                                                        </div>
                                                        <input class="form-control" type="date">
                                                        <select class="form-select ms-3">
                                                            <option selected>12:00AM</option>
                                                            <option value="1">1:00AM</option>
                                                            <option value="2">2:00AM</option>
                                                            <option value="3">3:00AM</option>
                                                            <option value="4">4:00AM</option>
                                                            <option value="5">5:00AM</option>
                                                            <option value="6">6:00AM</option>
                                                            <option value="7">7:00AM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-light w-100 py-2">Book Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="text-start">
                                        <h1 class="display-5 text-white">Get 15% off your rental Plan your trip now</h1>
                                        <p>Treat yourself in USA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{  asset('assets/welcome/img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Second slide"/>
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="row g-5">
                                <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="bg-secondary rounded p-5">
                                        <h4 class="text-white mb-4">CONTINUE AAAAAAAAAAAAAAAA CAR RESERVATION</h4>
                                        <form>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <select class="form-select">
                                                        <option selected>Select Your Car type</option>
                                                        <option value="1">VW Golf VII</option>
                                                        <option value="2">Audi A1 S-Line</option>
                                                        <option value="3">Toyota Camry</option>
                                                        <option value="4">BMW 320 ModernLine</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                            <span class="fas fa-map-marker-alt"></span><span class="ms-1">Pick Up</span>
                                                        </div>
                                                        <input class="form-control" type="text" placeholder="Enter a City or Airport">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <a href="#" class="text-start text-white d-block mb-2">Need a different drop-off location?</a>
                                                    <div class="input-group">
                                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                            <span class="fas fa-map-marker-alt"></span><span class="ms-1">Drop off</span>
                                                        </div>
                                                        <input class="form-control" type="text" placeholder="Enter a City or Airport">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-light w-100 py-2">Book Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="text-start">
                                        <h1 class="display-5 text-white">Get 15% off your rental! Choose Your Model</h1>
                                        <p>Treat yourself in USA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->
{{-- scarssssss --}}
    <!-- About Start -->
    <div class="container-fluid overflow-hidden about py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-item">
                        <div class="pb-5">
                            <h1 class="display-5 text-capitalize">Cental <span class="text-primary">About</span></h1>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum, excepturi, quia tempora cupiditate!</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <img src="{{  asset('assets/welcome/img/about-icon-1.png') }}" class="img-fluid w-50 h-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">Our Vision</h5>
                                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <img src="{{  asset('assets/welcome/img/about-icon-2.png') }}" class="img-fluid h-50 w-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">Our Mission</h5>
                                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-item my-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, aliquam ipsum. Sed suscipit dolorem libero sequi aut natus debitis reprehenderit facilis quaerat similique.</p>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="text-center rounded bg-secondary p-4">
                                    <h1 class="display-6 text-white">17</h1>
                                    <h5 class="text-light mb-0">Years Of Experience</h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="rounded">
                                    <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Morbi tristique senectus</p>
                                    <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> A scelerisque purus</p>
                                    <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Dictumst vestibulum</p>
                                    <p class="mb-0"><i class="fa fa-check-circle text-primary me-1"></i> Dio aenean sed adipiscing</p>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex align-items-center">
                                <a href="{{ route('welcome.about') }}" class="btn btn-primary rounded py-3 px-5">More About Us</a>
                            </div>
                            <div class="col-lg-7">
                                <div class="d-flex align-items-center">
                                    <img src="{{  asset('assets/welcome/img/attachment-img.jpg') }}" class="img-fluid rounded-circle border border-4 border-secondary" style="width: 100px; height: 100px;" alt="Image">
                                    <div class="ms-4">
                                        <h4>William Burgess</h4>
                                        <p class="mb-0">Cental Founder</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="about-img">
                        <div class="img-1">
                            <img src="{{  asset('assets/welcome/img/about-img.jpg') }}" class="img-fluid rounded h-100 w-100" alt="">
                        </div>
                        <div class="img-2">
                            <img src="{{  asset('assets/welcome/img/about-img-1.jpg') }}" class="img-fluid rounded w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Car Categories Start -->
<div class="container-fluid categories py-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h1 class="display-5 text-capitalize mb-3">Our <span class="text-primary">Vehicles</span></h1>
            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum, excepturi, quia tempora cupiditate!</p>
        </div>

        <div class="categories-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">

            @forelse($cars as $car)
            <div class="categories-item p-4">
                <div class="categories-item-inner">

                    {{-- Image --}}
                    <div class="categories-img rounded-top">
                        <img src="{{ asset('storage/' . $car->img) }}"
                             class="img-fluid w-100 rounded-top"
                             style="height: 200px; object-fit: cover;"
                             alt="{{ $car->name }}">
                    </div>

                    <div class="categories-content rounded-bottom p-4">

                        {{-- Title --}}
                        <h4>{{ $car->brand->name }} {{ $car->name }}</h4>

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
                                <i class="fa fa-car text-dark"></i>
                                <span class="text-body ms-1">{{ $car->body_type }}</span>
                            </div>
                            <div class="col-4 border-end border-white">
                                <i class="fa fa-cogs text-dark"></i>
                                <span class="text-body ms-1">{{ $car->transmission_type }}</span>
                            </div>
                            <div class="col-4">
                                <i class="fa fa-road text-dark"></i>
                                <span class="text-body ms-1">{{ $car->menufacturing_year }}</span>
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <div class="mb-3">
                            @if($car->status == 1)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </div>
                            {{-- Favorite + Buy Button --}}
                            <div class="mt-auto">

                                {{-- زر المفضلة --}}
                                @auth
                                    @php
                                        $isFav = auth()->user()->favorites()
                                                    ->where('vehicle_id', $car->id)
                                                    ->exists();
                                    @endphp

                                    <form action="{{ route('welcome.favorites.toggle', $car->id) }}"
                                        method="POST"
                                        class="mb-2">
                                        @csrf
                                        <button type="submit"
                                                class="btn w-5 rounded-pill py-2
                                                    {{ $isFav ? 'btn-danger' : 'btn-outline-danger' }}">
                                            <i class="fas fa-heart me-1"></i>
                                            {{ $isFav ? 'Re' : 'Add' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                    class="btn btn-outline-danger rounded-pill w-100 py-2 mb-2">
                                        <i class="fas fa-heart me-1"></i> Add to Favorites
                                    </a>
                                @endauth

                                {{-- زر الشراء --}}
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
                         {{-- Button
                        @if($car->status == 1)
                            <a href="{{ route('welcome.booking.show', $car->id) }}" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">
                                Book Now
                            </a>
                        @else --}}
                            {{-- <button class="btn btn-secondary rounded-pill d-flex justify-content-center py-3 w-100" disabled>
                                Not Available
                            </button>
                        @endif --}}

                    </div>
                </div>
            </div>

            @empty
            <div class="text-center w-100">
                <p>No Cars Available</p>
            </div>
            @endforelse

        </div>
    </div>
</div>
<!-- Car Categories End -->

    <!-- Team Start -->
    <div class="container-fluid team py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Customer<span class="text-primary"> Support</span> Center</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum.</p>
            </div>
            <div class="row g-4">
                @php
                    $team = [
                        ['img' => 'team-1.jpg', 'name' => 'MARTIN DOE',  'role' => 'Profession', 'delay' => '0.1s'],
                        ['img' => 'team-2.jpg', 'name' => 'MARTIN DOE',  'role' => 'Profession', 'delay' => '0.3s'],
                        ['img' => 'team-3.jpg', 'name' => 'MARTIN DOE',  'role' => 'Profession', 'delay' => '0.5s'],
                        ['img' => 'team-4.jpg', 'name' => 'MARTIN DOE',  'role' => 'Profession', 'delay' => '0.7s'],
                    ];
                @endphp
                @foreach($team as $member)
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ $member['delay'] }}">
                    <div class="team-item p-4 pt-0">
                        <div class="team-img">
                            <img src="{{  asset('assets/welcome/img/' . $member['img']) }}" class="img-fluid rounded w-100" alt="{{ $member['name'] }}">
                        </div>
                        <div class="team-content pt-4">
                            <h4>{{ $member['name'] }}</h4>
                            <p>{{ $member['role'] }}</p>
                            <div class="team-icon d-flex justify-content-center">
                                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Team End -->

    <!-- Blog Start -->
    <div class="container-fluid blog py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Cental<span class="text-primary"> Blog & News</span></h1>
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum.</p>
            </div>
            <div class="row g-4">
                @php
                    $blogs = [
                        ['img' => 'blog-1.jpg', 'date' => '30 Dec 2025', 'title' => 'Rental Cars how to check driving fines?',   'delay' => '0.1s'],
                        ['img' => 'blog-2.jpg', 'date' => '25 Dec 2025', 'title' => 'Rental cost of sport and other cars',        'delay' => '0.3s'],
                        ['img' => 'blog-3.jpg', 'date' => '27 Dec 2025', 'title' => 'Document required for car rental',           'delay' => '0.5s'],
                    ];
                @endphp
                @foreach($blogs as $blog)
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="{{ $blog['delay'] }}">
                    <div class="blog-item">
                        <div class="blog-img">
                            <img src="{{  asset('assets/welcome/img/' . $blog['img']) }}" class="img-fluid rounded-top w-100" alt="Blog Image">
                        </div>
                        <div class="blog-content rounded-bottom p-4">
                            <div class="blog-date">{{ $blog['date'] }}</div>
                            <div class="blog-comment my-3">
                                <div class="small"><span class="fa fa-user text-primary"></span><span class="ms-2">Martin.C</span></div>
                                <div class="small"><span class="fa fa-comment-alt text-primary"></span><span class="ms-2">6 Comments</span></div>
                            </div>
                            <a href="#" class="h4 d-block mb-3">{{ $blog['title'] }}</a>
                            <p class="mb-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius libero soluta impedit eligendi?</p>
                            <a href="#">Read More <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Blog End -->

@endsection
