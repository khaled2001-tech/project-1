{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cental - Car Rental</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap & Libraries -->
    <link href="{{ asset('assets/welcome/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: #e31c25;
            --secondary: #1a1a2e;
            --dark: #0f0f1a;
            --light: #f8f9fa;
        }

        /* ── Topbar ── */
        .topbar { background: var(--secondary) !important; }

        /* ── Navbar ── */
        .nav-bar {
            background: #fff;
            box-shadow: 0 2px 20px rgba(0,0,0,.08);
        }
        .navbar-brand h1 { font-family: 'Montserrat', sans-serif; font-weight: 800; }
        .nav-link {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: .88rem;
            letter-spacing: .03em;
            color: #333 !important;
            padding: 1.6rem 1rem !important;
            transition: color .2s;
        }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }

        /* ── Auth Buttons in Nav ── */
        .nav-auth-btn {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: .82rem;
            letter-spacing: .04em;
            padding: .45rem 1.3rem;
            border-radius: 50px;
            transition: all .25s;
        }
        .nav-auth-btn.login-btn {
            border: 2px solid var(--primary);
            color: var(--primary) !important;
            background: transparent;
        }
        .nav-auth-btn.login-btn:hover {
            background: var(--primary);
            color: #fff !important;
        }
        .nav-auth-btn.register-btn {
            background: var(--primary);
            color: #fff !important;
            border: 2px solid var(--primary);
        }
        .nav-auth-btn.register-btn:hover {
            background: #c0151d;
            border-color: #c0151d;
        }

        /* ── If logged in: show user name ── */
        .nav-user-dropdown .dropdown-toggle {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: .85rem;
            color: var(--secondary);
        }
        .nav-user-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,.12);
            border-radius: 12px;
        }

        /* ── Footer ── */
        .footer { background: var(--dark); }
        .footer a { color: #aaa; text-decoration: none; transition: color .2s; margin-bottom: .5rem; display: inline-block; }
        .footer a:hover { color: var(--primary); }
        .footer h4 { font-family: 'Montserrat', sans-serif; font-weight: 700; }

        /* ── Copyright ── */
        .copyright { background: #0a0a14; }

        /* ── Back to Top ── */
        .back-to-top {
            background: var(--primary) !important;
            border: none;
            width: 44px; height: 44px;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── Spinner ── */
        #spinner { z-index: 9999; }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Spinner -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-danger" style="width:3rem;height:3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Topbar -->
    <div class="container-fluid topbar d-none d-xl-block w-100">
        <div class="container">
            <div class="row gx-0 align-items-center" style="height:45px;">
                <div class="col-lg-6 text-center text-lg-start">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#" class="text-muted small"><i class="fas fa-map-marker-alt text-danger me-1"></i>Find A Location</a>
                        <a href="tel:+01234567890" class="text-muted small"><i class="fas fa-phone-alt text-danger me-1"></i>+012 345 67890</a>
                        <a href="mailto:info@cental.com" class="text-muted small"><i class="fas fa-envelope text-danger me-1"></i>info@cental.com</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;padding:0;display:flex;align-items:center;justify-content:center;"><i class="fab fa-facebook-f text-white" style="font-size:.7rem;"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;padding:0;display:flex;align-items:center;justify-content:center;"><i class="fab fa-twitter text-white" style="font-size:.7rem;"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;padding:0;display:flex;align-items:center;justify-content:center;"><i class="fab fa-instagram text-white" style="font-size:.7rem;"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;padding:0;display:flex;align-items:center;justify-content:center;"><i class="fab fa-linkedin-in text-white" style="font-size:.7rem;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="" class="navbar-brand p-0">
                    <h1 class="display-6 text-danger mb-0">
                        <i class="fas fa-car-alt me-2"></i>Cental
                    </h1>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="" class="nav-item nav-link active">Home</a>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#vehicles" class="nav-item nav-link">Buy-Car</a>
                        <a href="#vehicles" class="nav-item nav-link">Rent-Car</a>
                        <a href="#blog" class="nav-item nav-link">Blog</a>
                        <a href="#contact" class="nav-item nav-link">Contact</a>
                    </div>

                    {{-- Auth Buttons --}}
                    @guest
                        <div class="d-flex gap-2 ms-2">
                            <a href="{{ route('login') }}" class="nav-auth-btn login-btn">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="nav-auth-btn register-btn">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </div>
                    @else
                        <div class="dropdown nav-user-dropdown ms-3">
                            <button class="btn btn-light dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1 text-danger"></i>
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2 text-muted"></i>My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-car me-2 text-muted"></i>My Bookings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    @yield('content')

    <!-- Footer -->
    <div class="container-fluid footer py-5 mt-5" id="contact">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-3">
                            <i class="fas fa-car-alt text-danger me-2"></i>Cental
                        </h4>
                        <p class="text-muted mb-4" style="font-size:.9rem;line-height:1.7;">
                            Your trusted partner for premium car rentals. Experience comfort, reliability and great value every time you drive with us.
                        </p>
                        <div class="position-relative">
                            <input class="form-control rounded-pill py-2 ps-4 pe-5 border-0 bg-white bg-opacity-10 text-white" type="text" placeholder="Your email address" style="outline:none;">
                            <button type="button" class="btn btn-danger rounded-pill position-absolute top-0 end-0 py-1 mt-1 me-1 px-3" style="font-size:.82rem;">Subscribe</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <h4 class="text-white mb-3">Quick Links</h4>
                    <div class="d-flex flex-column gap-2">
                        <a href="#"><i class="fas fa-angle-right me-2 text-danger"></i>About Us</a>
                        <a href="#"><i class="fas fa-angle-right me-2 text-danger"></i>Our Cars</a>
                        <a href="#"><i class="fas fa-angle-right me-2 text-danger"></i>Vehicle Types</a>
                        <a href="#"><i class="fas fa-angle-right me-2 text-danger"></i>Blog & News</a>
                        <a href="#"><i class="fas fa-angle-right me-2 text-danger"></i>Contact Us</a>
                        <a href="#"><i class="fas fa-angle-right me-2 text-danger"></i>Terms & Conditions</a>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <h4 class="text-white mb-3">Business Hours</h4>
                    <div class="d-flex flex-column gap-3" style="font-size:.9rem;">
                        <div>
                            <p class="text-muted mb-0">Mon – Friday</p>
                            <p class="text-white mb-0 fw-semibold">09:00 AM – 07:00 PM</p>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Saturday</p>
                            <p class="text-white mb-0 fw-semibold">10:00 AM – 05:00 PM</p>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Sunday</p>
                            <p class="text-white mb-0 fw-semibold">Closed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <h4 class="text-white mb-3">Contact Info</h4>
                    <div class="d-flex flex-column gap-2" style="font-size:.9rem;">
                        <a href="#"><i class="fas fa-map-marker-alt me-2 text-danger"></i>123 Street, New York, USA</a>
                        <a href="mailto:info@cental.com"><i class="fas fa-envelope me-2 text-danger"></i>info@cental.com</a>
                        <a href="tel:+012345678"><i class="fas fa-phone me-2 text-danger"></i>+012 345 67890</a>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(255,255,255,.1);color:#fff;"><i class="fab fa-facebook-f" style="font-size:.75rem;"></i></a>
                        <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(255,255,255,.1);color:#fff;"><i class="fab fa-twitter" style="font-size:.75rem;"></i></a>
                        <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(255,255,255,.1);color:#fff;"><i class="fab fa-instagram" style="font-size:.75rem;"></i></a>
                        <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(255,255,255,.1);color:#fff;"><i class="fab fa-linkedin-in" style="font-size:.75rem;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright py-3" style="background:#060610;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <span class="text-muted small">
                        <i class="fas fa-copyright text-danger me-1"></i>
                        {{ date('Y') }} <a href="#" class="text-white text-decoration-none">Cental</a>. All rights reserved.
                    </span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="text-muted small">Designed By <a href="https://htmlcodex.com" class="text-white text-decoration-none">HTML Codex</a></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn back-to-top rounded-circle position-fixed bottom-0 end-0 m-4" style="z-index:999;">
        <i class="fa fa-arrow-up text-white"></i>
    </a>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/welcome/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/js/main.js') }}"></script>

    <script>
        // Hide spinner after load
        $(window).on('load', function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show').fadeOut('slow');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
