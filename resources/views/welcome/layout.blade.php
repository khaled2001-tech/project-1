{{--
════════════════════════════════════════════════════════════════
  resources/views/welcome/layout.blade.php  — النسخة المحدّثة
  التغييرات:
    1. أضفنا <meta name="csrf-token"> في <head>
    2. أضفنا زر AI في الـ Navbar
    3. أضفنا @include للشات بوت قبل </body>
════════════════════════════════════════════════════════════════
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Cental - Car Rent Website')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    {{-- ✅ مهم جداً للشات بوت --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/welcome/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/welcome/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/welcome/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid topbar bg-secondary d-none d-xl-block w-100">
        <div class="container">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-6 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-muted me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                        <a href="tel:+01234567890" class="text-muted me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+01234567890</a>
                        <a href="mailto:example@gmail.com" class="text-muted me-0"><i class="fas fa-envelope text-primary me-2"></i>Example@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-0"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="{{ route('welcome.index') }}" class="navbar-brand p-0">
                    <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i>Cental</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="{{ route('welcome.index') }}"   class="nav-item nav-link {{ request()->routeIs('welcome.index')   ? 'active' : '' }}">Home</a>
                        <a href="{{ route('welcome.about') }}"   class="nav-item nav-link {{ request()->routeIs('welcome.about')   ? 'active' : '' }}">About</a>
                        <a href="{{ route('welcome.buycar') }}"  class="nav-item nav-link {{ request()->routeIs('welcome.buycar')  ? 'active' : '' }}">Buy</a>
                        <a href="{{ route('welcome.rentcar') }}" class="nav-item nav-link {{ request()->routeIs('welcome.rentcar') ? 'active' : '' }}">Rent</a>
                        <a href="{{ route('welcome.team') }}"    class="nav-item nav-link {{ request()->routeIs('welcome.team')    ? 'active' : '' }}">Team</a>
                        <a href="{{ route('welcome.blog') }}"    class="nav-item nav-link {{ request()->routeIs('welcome.blog')    ? 'active' : '' }}">Blog</a>
                        <a href="{{ route('welcome.contact') }}" class="nav-item nav-link {{ request()->routeIs('welcome.contact') ? 'active' : '' }}">Contact</a>
                    </div>

                    {{-- ✅ زر AI في الـ Navbar --}}
                    <button onclick="document.getElementById('cb-toggle').click()"
                            class="btn btn-warning rounded-pill py-2 px-3 me-2 d-flex align-items-center gap-1"
                            style="font-size:.85rem; font-weight:600;">
                        <i class="fas fa-robot"></i>
                        <span class="d-none d-md-inline">AI Assistant</span>
                    </button>

                    @guest
                        <a href="{{ route('login') }}"    class="btn btn-primary rounded-pill py-2 px-4 me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill py-2 px-4">Register</a>
                    @endguest

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle rounded-pill py-2 px-4"
                                    type="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2 text-primary"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('welcome.favorites.index') }}">
                                        <i class="fas fa-heart me-2 text-danger"></i> My Favorites
                                    </a>
                                </li>
                                @if(Auth::user()->role === 'customer')
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item fw-bold" href="{{ route('welcome.sell-car') }}" style="color:#dc3545;">
                                        <i class="fas fa-car me-2"></i> Sell Your Car
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Page Content -->
    @yield('content')
    <!-- Page Content End -->

    <!-- Footer Start -->
    <div class="container-fluid footer py-5 mt-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">About Us</h4>
                            <p class="mb-3">Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        </div>
                        <div class="position-relative">
                            <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                            <button type="button" class="btn btn-secondary rounded-pill position-absolute top-0 end-0 py-2 mt-2 me-2">Subscribe</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Quick Links</h4>
                        <a href="{{ route('welcome.about') }}"><i class="fas fa-angle-right me-2"></i> About</a>
                        <a href="{{ route('welcome.vehicle') }}"><i class="fas fa-angle-right me-2"></i> Cars</a>
                        <a href="{{ route('welcome.team') }}"><i class="fas fa-angle-right me-2"></i> Team</a>
                        <a href="{{ route('welcome.contact') }}"><i class="fas fa-angle-right me-2"></i> Contact us</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Terms & Conditions</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Business Hours</h4>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Mon - Friday:</h6>
                            <p class="text-white mb-0">09.00 am to 07.00 pm</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Saturday:</h6>
                            <p class="text-white mb-0">10.00 am to 05.00 pm</p>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Vacation:</h6>
                            <p class="text-white mb-0">All Sunday is our vacation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <a href="#"><i class="fa fa-map-marker-alt me-2"></i> 123 Street, New York, USA</a>
                        <a href="mailto:info@example.com"><i class="fas fa-envelope me-2"></i> info@example.com</a>
                        <a href="tel:+01234567890"><i class="fas fa-phone me-2"></i> +012 345 67890</a>
                        <div class="d-flex mt-3">
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-facebook-f text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-twitter text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-instagram text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-0" href=""><i class="fab fa-linkedin-in text-white"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>Cental</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end text-body">
                    Designed By <a class="border-bottom text-white" href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/welcome/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('assets/dashboard/js/flash-toast.js') }}"></script>
    <script src="{{ asset('assets/welcome/js/main.js') }}"></script>

    @stack('scripts')

    {{-- ✅ الشات بوت — يجب أن يكون هنا بعد jQuery و Bootstrap --}}
    @include('welcome.chatbot')

</body>
</html>
