<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Issue Tracker
    </title>
    <link rel="icon" type="image/x-icon" href="javascrept:void(0)">

    @section('header')
        @include('backend.layouts.header')
    @show
    <style>
        tbody tr td img.type-1 {
            border-radius: 6px;
            width: 150px;
            height: 80px;
        }

        tbody tr td img.type-2 {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .form-group img.type-1 {
            border-radius: 6px;
            width: 150px;
            height: 90px;
        }

        .form-group img.type-2 {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .img-circle {
            border-radius: 0 !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed" id="main-body">
    <div class="wrapper">

        @include('backend.layouts.sidebar')

        @yield('sections')

        <footer class="main-footer text-center">
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}"
                    target="_blank">{{ config('app.name') }}</a>.</strong>
            All rights reserved.
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @include('backend.common.delete_modal')
    @section('footer')
        @include('backend.layouts.footer')
    @show

    @stack('scripts')
    <script>
        function getDeleteRoute($route) {
            document.getElementById("confirm_del").setAttribute("action", $route);
        }

        function fullScreen() {
            let fullscreen = localStorage.getItem("fullscreen");
            if (fullscreen === null) {
                localStorage.setItem("fullscreen", 'full');
            }
            if (fullscreen == 'full') {
                localStorage.setItem("fullscreen", 'normal');
            }
            if (fullscreen == 'normal') {
                localStorage.setItem("fullscreen", 'full');
            }
        }

        function sidebarCollapse() {
            let sidebar_collapse = localStorage.getItem("sidebar_collapse");
            if (sidebar_collapse === null) {
                localStorage.setItem("sidebar_collapse", 'hide');
            }
            if (sidebar_collapse == 'hide') {
                localStorage.setItem("sidebar_collapse", 'show');
            }
            if (sidebar_collapse == 'show') {
                localStorage.setItem("sidebar_collapse", 'hide');
            }
        }

        $(document).ready(() => {
            let sidebar_collapse = localStorage.getItem("sidebar_collapse");
            let fullscreen = localStorage.getItem("fullscreen");

            if (sidebar_collapse == 'hide') {
                $('#main-body').addClass('sidebar-collapse');
            }
            if (fullscreen == 'full') {
                $('#add-fa-class').removeClass('fa-expand-arrows-alt');
                $('#add-fa-class').addClass('fa-compress-arrows-alt');
            }
        });
    </script>
</body>

</html>
