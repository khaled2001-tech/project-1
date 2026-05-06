@php
    $user = Auth::user();
    $role = $user->role ?? null;

    $menuItems = [
        'manager' => [
            [
                'label' => 'Dashboard',
                'icon' => 'home',
                'url' => url('dashboard'),
            ],
            [
                'label' => 'Users',
                'icon' => 'users',
                'children' => [
                    [
                        'label' => 'Employees List',
                        'url' => url('dashboard/employees'),
                    ],
                    [
                        'label' => 'Drivers List',
                        'url' => url('dashboard/drivers'),
                    ],
                      // ✅ NEW
                [
                    'label' => 'Car Sale Requests',
                    'icon' => 'car',
                    'url' => url('dashboard/car-sale-requests'),
                ],
                ],
            ],
            [
                'label' => 'Brands',
                'icon' => 'bar-chart-2',
                'url' => url('dashboard/brands'),
            ],
             [
                'label' => 'Models',
                'icon' => 'bar-chart-2',
                'url' => url('dashboard/models'),
            ],
             [
                'label' => 'Accounts Managment',
                'icon' => 'bar-chart-2',
                'url' => url('dashboard/users'),
            ],
            [
                'label' => 'Schedule',
                'icon' => 'calendar',
                'url' => url('dashboard/schedule'),
            ],
            [
                'label' => 'Profile',
                'icon' => 'user',
                'url' => route('profile.edit'),
            ],
        ],

        'driver' => [
            [
                'label' => 'Dashboard',
                'icon' => 'home',
                'url' => url('dashboard/driver/dashboard'),
            ],
            [
                'label' => 'My Trips',
                'icon' => 'truck',
                'url' => url('dashboard/trips'),
            ],
            [
                'label' => 'Deliveries',
                'icon' => 'map-pin',
                'url' => url('dashboard/driver/deliveries'),
            ],
            [
                'label' => 'Schedule',
                'icon' => 'calendar',
                'url' => url('dashboard/schedule'),
            ],
            [
                'label' => 'Profile',
                'icon' => 'user',
                'url' => route('profile.edit'),
            ],
        ],

        'employee' => [
            [
                'label' => 'Dashboard',
                'icon' => 'home',
                'url' => url('dashboard'),
            ],
            [
                'label' => 'Cars',
                'icon' => 'check-square',
                'url' => url('dashboard/cars'),
            ],
            [
                'label' => 'Customers',
                'icon' => 'clock',
                'url' => url('dashboard/customers'),
            ],
            [
                'label' => 'Reservations',
                'icon' => 'message-square',
                'url' => url('dashboard/reservations'),
            ],
                [
                'label' => 'Contacts',
                'icon' => 'message-square',
                'url' => url('dashboard/contacts'),
            ],
            [
                'label' => 'Profile',
                'icon' => 'user',
                'url' => route('profile.edit'),
            ],
        ],

        'admin' => [
            [
                'label' => 'Dashboard',
                'icon' => 'home',
                'url' => url('dashboard'),
            ],
            [
                'label' => 'Managers',
                'icon' => 'briefcase',
                'url' => url('dashboard/managers'),
            ],
            [
                'label' => 'Add Users',
                'icon' => 'users',
                'children' => [
                    [
                        'label' => 'Employees',
                        'url' => url('dashboard/employees'),
                    ],
                    [
                        'label' => 'Drivers',
                        'url' => url('dashboard/drivers'),
                    ],
                ],
            ],
            [
                'label' => 'Profile',
                'icon' => 'user',
                'url' => route('profile.edit'),
            ],
        ],
    ];

    $roleMenu = $menuItems[$role] ?? [];

    $iconMap = [
        'home' => '<i class="fe fe-home side-menu__icon"></i>',
        'users' => '<i class="fe fe-users side-menu__icon"></i>',
        'bar-chart-2' => '<i class="fe fe-bar-chart-2 side-menu__icon"></i>',
        'calendar' => '<i class="fe fe-calendar side-menu__icon"></i>',
        'user' => '<i class="fe fe-user side-menu__icon"></i>',
        'truck' => '<i class="fe fe-truck side-menu__icon"></i>',
        'map-pin' => '<i class="fe fe-map-pin side-menu__icon"></i>',
        'check-square' => '<i class="fe fe-check-square side-menu__icon"></i>',
        'clock' => '<i class="fe fe-clock side-menu__icon"></i>',
        'message-square' => '<i class="fe fe-message-square side-menu__icon"></i>',
        'briefcase' => '<i class="fe fe-briefcase side-menu__icon"></i>',
        // ✅ NEW
        'car'            => '<i class="fe fe-truck side-menu__icon"></i>',

    ];
@endphp

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
    <div class="main-sidebar-header">
        <a class="desktop-logo logo-light active" href="{{ route('dashboard') }}">
            <img src="{{ URL::asset('assets/dashboard/img/brand/logo.png') }}" class="main-logo" alt="logo">
        </a>
        <a class="desktop-logo logo-dark active" href="{{ route('dashboard') }}">
            <img src="{{ URL::asset('assets/dashboard/img/brand/logo-white.png') }}" class="main-logo dark-theme" alt="logo">
        </a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ route('dashboard') }}">
            <img src="{{ URL::asset('assets/dashboard/img/brand/favicon.png') }}" class="logo-icon" alt="logo">
        </a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ route('dashboard') }}">
            <img src="{{ URL::asset('assets/dashboard/img/brand/favicon-white.png') }}" class="logo-icon dark-theme" alt="logo">
        </a>
    </div>

    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body text-center">
                <div class="user-pic">
                    <img alt="user-img" class="avatar-xl rounded-circle mx-auto d-block"
                        src="{{ URL::asset('assets/dashboard/img/faces/6.jpg') }}">
                </div>
                <div class="user-info mt-3">
                    <h4 class="font-weight-semibold mt-2 mb-0">{{ $user->name ?? 'User' }}</h4>
                    <span class="mb-0 text-muted">{{ ucfirst($role ?? 'guest') }}</span>
                </div>
            </div>
        </div>

        <ul class="side-menu">
            <li class="side-item side-item-category">Main</li>

            @foreach ($roleMenu as $item)
                @php
                    $hasChildren = isset($item['children']);
                    $isActive = false;

                    if ($hasChildren) {
                        foreach ($item['children'] as $child) {
                            if (request()->is(trim(parse_url($child['url'], PHP_URL_PATH), '/'))) {
                                $isActive = true;
                                break;
                            }
                        }
                    } else {
                        $itemPath = trim(parse_url($item['url'], PHP_URL_PATH), '/');
                        $isActive = request()->is($itemPath);
                    }
                @endphp

                <li class="slide {{ $isActive ? 'active is-expanded' : '' }}">
                    @if ($hasChildren)
                        <a href="javascript:void(0);" class="side-menu__item {{ $isActive ? 'active' : '' }}" data-toggle="slide">
                            {!! $iconMap[$item['icon']] ?? '' !!}
                            <span class="side-menu__label">{{ $item['label'] }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>

                        <ul class="slide-menu">
                            @foreach ($item['children'] as $child)
                                @php
                                    $childPath = trim(parse_url($child['url'], PHP_URL_PATH), '/');
                                    $isChildActive = request()->is($childPath);
                                @endphp

                                <li>
                                    <a href="{{ $child['url'] }}" class="slide-item {{ $isChildActive ? 'active' : '' }}">
                                        {{ $child['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a href="{{ $item['url'] }}" class="side-menu__item {{ $isActive ? 'active' : '' }}">
                            {!! $iconMap[$item['icon']] ?? '' !!}
                            <span class="side-menu__label">{{ $item['label'] }}</span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</aside>
