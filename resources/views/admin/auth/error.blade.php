@extends('layouts.auth', ['title' => 'Login'])
@section('title')
<title>Login | Task management</title>
@endsection
@section('css')
@endsection

@section('content')
    <!-- Begin Wrapper -->
    <div class="main-wrapper">

        <div class="container">

            <!-- start row -->
            <div class="row justify-content-center align-items-center vh-100">

                <div class="col-md-8 d-flex align-items-center justify-content-center mx-auto">
                    <div>
                        <div class="error-img p-4">
                            <img src="{{asset('assets/img/authentication/error-404.png')}}" class="img-fluid" alt="Img">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-3">Oops, something went wrong</h2>
                            <p class="mb-3">Error 404 Page not found. Sorry the page you looking for <br> doesn’t exist or has been moved</p>
                            <div class="pb-4">
                                <a href="{{ route('login') }}" class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="ti ti-chevron-left me-1"></i>Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>
            <!-- end row -->
            
        </div>

    </div>
    <!-- End Wrapper -->
@endsection

@section('script')
@endsection