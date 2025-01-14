@extends(request()->segment(1) === 'system-admin' ? 'admin.layouts.master' : 'client.layouts.master')

@if (request()->segment(1) === 'system-admin')
    @section('content')
        <!-- auth-page wrapper -->
        <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
            <div class="bg-overlay"></div>
            <!-- auth-page content -->
            <div class="auth-page-content overflow-hidden pt-lg-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-5">
                            <div class="card overflow-hidden card-bg-fill galaxy-border-none">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <lord-icon class="avatar-xl" src="../../../etwtznjn.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c"></lord-icon>
                                        <h1 class="text-primary mb-4">Oops !</h1>
                                        <h4 class="text-uppercase">Sorry, Page not Found 😭</h4>
                                        <p class="text-muted mb-4">The page you are looking for not available!</p>
                                        <a href="{{ route('system-admin.dashboard') }}" class="btn btn-success"><i
                                                class="mdi mdi-home me-1"></i>Back
                                            to home</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->
        </div>
        <!-- end auth-page-wrapper -->
    @endsection
@else
    @section('content')
        <!-- Start Page Title Area -->
        <div class="page-title-area">
            <div class="container">
                <div class="page-title-content">
                    <h2>404 Error</h2>
                    <ul>
                        <li>
                            <a href="index.html">
                                Home
                            </a>
                        </li>
                        <li class="active">404 Error</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Page Title Area -->

        <!-- Start 404 Error -->
        <div class="error-area ptb-100">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="error-content">
                        <img src="{{ asset('theme/client/assets/images/404.jpg') }}" alt="Image">
                        <h3>Oops! Page Not Found</h3>
                        <p>The page you were looking for could not be found.</p>

                        <a href="{{ route('home') }}" class="default-btn two">
                            Return To Home Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End 404 Error -->
    @endsection
@endif
