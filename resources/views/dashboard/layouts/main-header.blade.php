<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left">
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icon fe fe-x"></i></a>
            </div>

            <div class="main-header-center mr-3 d-none d-lg-block">
                <input class="form-control" placeholder="Search for anything..." type="search">
                <button class="btn" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="main-header-right">
            <ul class="nav align-items-center">
                <li class="nav-item dropdown d-none d-md-flex">
                    <a href="#" class="d-flex nav-link pl-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
                        <span class="avatar country-Flag mr-0 align-self-center bg-transparent">
                            <img src="{{ URL::asset('assets/dashboard/img/flags/us_flag.jpg') }}" alt="img">
                        </span>
                        <div class="my-auto">
                            <strong class="mr-2 ml-2 my-auto">English</strong>
                        </div>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">English</a>
                        <a class="dropdown-item" href="#">Arabic</a>
                    </div>
                </li>
            </ul>

            <div class="nav nav-item navbar-nav-right ml-auto align-items-center">
                <div class="nav-link" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="dropdown nav-item main-header-message">
                    <a class="new nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span class="pulse-danger"></span>
                    </a>
                </div>

                <div class="dropdown nav-item main-header-notification">
                    <a class="new nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="pulse"></span>
                    </a>
                </div>

                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                        </svg>
                    </a>
                </div>

                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="#">
                        <img alt="user" src="{{ URL::asset('assets/dashboard/img/faces/6.jpg') }}">
                    </a>

                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user">
                                    <img alt="user" src="{{ URL::asset('assets/dashboard/img/faces/6.jpg') }}">
                                </div>
                                <div class="mr-3 my-auto">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>

                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user-circle"></i> Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bx bx-cog"></i> Edit Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="bx bxs-inbox"></i> Inbox
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-envelope"></i> Messages
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-slider-alt"></i> Account Settings
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-log-out"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="dropdown main-header-message right-toggle">
                    <a class="nav-link pr-0" href="#" data-toggle="sidebar-left" data-target=".sidebar-right">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
