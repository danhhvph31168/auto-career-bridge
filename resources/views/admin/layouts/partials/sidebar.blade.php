<!-- Xác định đường dẫn hiện tại -->
@php
    $segment = request()->segment(1);
@endphp

<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        @php
            $dashboardRoute = '';
            if (Auth::check()) {
                if (Auth::user()->user_type === TYPE_ADMIN) {
                    $dashboardRoute = route('system-admin.dashboard');
                } elseif (Auth::user()->user_type === TYPE_ENTERPRISE) {
                    $dashboardRoute = route('enterprise.dashboard');
                } else {
                    $dashboardRoute = route('university.dashboard');
                }
            }
        @endphp

        <!-- Dark Logo -->
        <a href="{{ $dashboardRoute }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('theme/client/assets/images/logo.png') }}" alt="" height="15">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/client/assets/images/logo.png') }}" alt="" height="40">
            </span>
        </a>

        <!-- Light Logo -->
        <a href="{{ $dashboardRoute }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('theme/admin/assets/logo/logo-sm.png') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/admin/assets/logo/logo.png') }}" alt="" height="100">
            </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>


    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user"
                    src="{{ asset('theme/admin/html/master/assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome Anna!</h6>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat.html"><i
                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs.html"><i
                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance :
                    <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings.html"><span
                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock
                    screen</span></a>
            <a class="dropdown-item" href="auth-logout-basic.html"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                    data-key="t-logout">Logout</span></a>
        </div>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                @foreach (config('apps.sidebar.sidebar') as $index => $val)
                    @if (Auth::check())
                        @if (isset($val['roles']) && in_array(auth()->user()->user_type, $val['roles']))
                            @php
                                $isActive = false;
                                if (!empty($val['route']) && Route::currentRouteName() === $val['route']) {
                                    $isActive = true;
                                }
                                if (isset($val['subModule']) && is_array($val['subModule'])) {
                                    foreach ($val['subModule'] as $module) {
                                        if (Route::currentRouteName() === $module['route']) {
                                            $isActive = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            <li class="nav-item {{ $isActive ? 'active' : '' }}">
                                @if (auth()->user()->user_type === TYPE_ADMIN || auth()->user()->status === APPROVED)
                                    @if (!empty($val['route']) && empty($val['subModule']))
                                        <a href="{{ route($val['route']) }}"
                                            class="nav-link menu-link {{ $isActive ? 'active' : '' }}">
                                            <i class="{{ $val['icon'] }}"></i>
                                            <span data-key="t-dashboards">{{ $val['title'] }}</span>
                                        </a>
                                    @else
                                        <a class="nav-link menu-link {{ $isActive ? 'active' : '' }}"
                                            href="#menu-{{ $index }}" data-bs-toggle="collapse" role="button"
                                            aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                                            aria-controls="menu-{{ $index }}">
                                            <i class="{{ $val['icon'] }}"></i>
                                            <span data-key="t-dashboards">{{ $val['title'] }}</span>
                                        </a>
                                        @if (isset($val['subModule']) && is_array($val['subModule']) && count($val['subModule']) > 0)
                                            <div class="collapse menu-dropdown {{ $isActive ? 'show' : '' }}"
                                                id="menu-{{ $index }}">
                                                <ul class="nav nav-sm flex-column">
                                                    @foreach ($val['subModule'] as $module)
                                                        <li
                                                            class="nav-item {{ Route::currentRouteName() === $module['route'] ? 'active' : '' }}">
                                                            <a href="{{ route($module['route']) }}"
                                                                class="nav-link {{ Route::currentRouteName() === $module['route'] ? 'active' : '' }}"
                                                                data-key="t-analytics">
                                                                {{ $module['title'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <a href="javascript:void(0);" class="nav-link menu-link"
                                        onclick="alert('Bạn cần cập nhật thông tin và chờ hệ thống phê duyệt để sử dụng chức năng này.')">
                                        <i class="{{ $val['icon'] }}"></i>
                                        <span data-key="t-dashboards">{{ $val['title'] }}</span>
                                    </a>
                                @endif
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>


        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
