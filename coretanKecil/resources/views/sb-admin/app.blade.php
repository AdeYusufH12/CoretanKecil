
<!DOCTYPE html>
<html lang="en">

{{-- head --}}
@include('sb-admin/head')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('sb-admin/sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('sb-admin/topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('sb-admin/footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    @include('sb-admin/logout-modal')

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/vendor/sb-admin/js/sb-admin-2.min.js"></script>

    {{-- ck--editor --}}
    @yield('ck-editor')

    {{-- sweet alert --}}
    @include('sweetalert::alert')

    @yield('javascript')
</body>

</html>