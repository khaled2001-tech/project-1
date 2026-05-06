@extends('welcome.layout')

@section('title', 'Cental - Our Team')

@section('content')

    <!-- Header / Breadcrumb Start -->
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Our Team</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-primary">Team</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <!-- Team Start -->
    <div class="container-fluid team py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Customer<span class="text-primary"> Support</span> Center</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum, excepturi, quia tempora cupiditate!</p>
            </div>
            <div class="row g-4">
                @php
                    $team = [
                        ['img' => 'team-1.jpg', 'name' => 'MARTIN DOE',  'role' => 'Profession', 'delay' => '0.1s'],
                        ['img' => 'team-2.jpg', 'name' => 'SARAH JONES', 'role' => 'Profession', 'delay' => '0.3s'],
                        ['img' => 'team-3.jpg', 'name' => 'JOHN SMITH',  'role' => 'Profession', 'delay' => '0.5s'],
                        ['img' => 'team-4.jpg', 'name' => 'EMMA WILSON', 'role' => 'Profession', 'delay' => '0.7s'],
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

@endsection
