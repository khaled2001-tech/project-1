@extends('welcome.layout')

@section('title', 'Cental - Blog & News')

@section('content')

    <!-- Header / Breadcrumb Start -->
    <div class="container-fluid bg-breadcrumb mb-5">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Blog & News</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-primary">Blog</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <!-- Blog Start -->
    <div class="container-fluid blog py-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Cental<span class="text-primary"> Blog & News</span></h1>
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum, excepturi, quia tempora cupiditate!</p>
            </div>
            <div class="row g-4">
                @php
                    $blogs = [
                        ['img' => 'blog-1.jpg', 'date' => '30 Dec 2025', 'title' => 'Rental Cars how to check driving fines?', 'delay' => '0.1s'],
                        ['img' => 'blog-2.jpg', 'date' => '25 Dec 2025', 'title' => 'Rental cost of sport and other cars',       'delay' => '0.3s'],
                        ['img' => 'blog-3.jpg', 'date' => '27 Dec 2025', 'title' => 'Document required for car rental',          'delay' => '0.5s'],
                        ['img' => 'blog-1.jpg', 'date' => '20 Dec 2025', 'title' => 'Top tips for first-time car renters',       'delay' => '0.1s'],
                        ['img' => 'blog-2.jpg', 'date' => '15 Dec 2025', 'title' => 'How to save money on car rentals',          'delay' => '0.3s'],
                        ['img' => 'blog-3.jpg', 'date' => '10 Dec 2025', 'title' => 'Best cars for road trips in 2025',          'delay' => '0.5s'],
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
                            <p class="mb-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius libero soluta impedit eligendi? Quibusdam, laudantium.</p>
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
