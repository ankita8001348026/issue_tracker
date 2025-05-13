@php
    $segment = Request::segment(1);
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"
                onclick="sidebarCollapse()"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" onclick="fullScreen()">
                <i class="fas fa-expand-arrows-alt" id="add-fa-class"></i>
            </a>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="" alt="{{ config('app.name') }}" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <div class="sidebar">


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if ($segment == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item @if (in_array($segment, ['employee', 'user'])) menu-open @endif">
                    <a href="#" class="nav-link @if (in_array($segment, ['employee', 'user'])) active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Type
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('employee.index') }}"
                                class="nav-link @if ($segment == 'employee') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}"
                                class="nav-link @if ($segment == 'user') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('issue.index') }}"
                        class="nav-link @if ($segment == 'issue') active @endif">
                        <i class="nav-icon fa fa-cogs" aria-hidden="true"></i>
                        <p>Issue</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
