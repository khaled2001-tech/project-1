@extends('welcome.layout')

@section('title', 'Cental - About Us')

@section('content')

    <!-- Header / Breadcrumb Start -->
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">About Us</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-primary">About</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <!-- About Start -->
    <div class="container-fluid overflow-hidden about py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-item">
                        <div class="pb-5">
                            <h1 class="display-5 text-capitalize">Cental <span class="text-primary">About</span></h1>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum, excepturi, quia tempora cupiditate! Adipisci facilis modi quisquam quia distinctio.</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <img src="{{ asset('assets/welcome/img/about-icon-1.png') }}" class="img-fluid w-50 h-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">Our Vision</h5>
                                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <img src="{{ asset('assets/welcome/img/about-icon-2.png') }}" class="img-fluid h-50 w-50" alt="Icon">
                                    </div>
                                    <h5 class="mb-3">Our Mission</h5>
                                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-item my-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, aliquam ipsum. Sed suscipit dolorem libero sequi aut natus debitis reprehenderit facilis quaerat similique, est at in eum.</p>
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
                                <a href="#" class="btn btn-primary rounded py-3 px-5">More About Us</a>
                            </div>
                            <div class="col-lg-7">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/welcome/img/attachment-img.jpg') }}" class="img-fluid rounded-circle border border-4 border-secondary" style="width: 100px; height: 100px;" alt="Image">
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
                            <img src="{{ asset('assets/welcome/img/about-img.jpg') }}" class="img-fluid rounded h-100 w-100" alt="">
                        </div>
                        <div class="img-2">
                            <img src="{{ asset('assets/welcome/img/about-img-1.jpg') }}" class="img-fluid rounded w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

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
                        ['img' => 'team-1.jpg', 'name' => 'MARTIN DOE', 'role' => 'Profession', 'delay' => '0.1s'],
                        ['img' => 'team-2.jpg', 'name' => 'MARTIN DOE', 'role' => 'Profession', 'delay' => '0.3s'],
                        ['img' => 'team-3.jpg', 'name' => 'MARTIN DOE', 'role' => 'Profession', 'delay' => '0.5s'],
                        ['img' => 'team-4.jpg', 'name' => 'MARTIN DOE', 'role' => 'Profession', 'delay' => '0.7s'],
                    ];
                @endphp
                @foreach($team as $member)
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ $member['delay'] }}">
                    <div class="team-item p-4 pt-0">
                        <div class="team-img">
                            <img src="{{ asset('assets/welcome/img/' . $member['img']) }}" class="img-fluid rounded w-100" alt="{{ $member['name'] }}">
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

@endsection
