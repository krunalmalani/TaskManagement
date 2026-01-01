@extends('layouts.auth', ['title' => 'Register'])
@section('css')
@endsection

@section('content')
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <div class="overflow-hidden p-3 acc-vh">
            
            <!-- start row -->
            <div class="row vh-100 w-100 g-0"> 

                <div class="col-lg-6 vh-100  overflow-y-auto overflow-x-hidden">

                    <!-- start row -->
                    <div class="row">

                        <div class="col-md-10 mx-auto">
                            <form id="registerForm" class=" vh-100 d-flex justify-content-between flex-column p-4 pb-0">
                                <!-- General Error Alert -->
                                <div id="general_error" class="alert alert-danger d-none" role="alert" style="margin-top: 10px;"></div>
                                <div class="text-center mb-3 auth-logo">
                                    <img src="{{asset('assets/img/logo.svg')}}" class="img-fluid" alt="Logo">
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <h3 class="mb-2">Register</h3>
                                        <p class="mb-0">Create new CRMS account</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="first_name" name="first_name" class="form-control">
                                            <span class="input-group-text">
                                                <i class="ti ti-user"></i>
                                            </span>
                                        </div>                                        <small id="first_name_error" class="text-danger"></small>                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="middle_name" name="middle_name" class="form-control">
                                            <span class="input-group-text">
                                                <i class="ti ti-user"></i>
                                            </span>
                                        </div>                                        <small id="middle_name_error" class="text-danger"></small>                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="last_name" name="last_name" class="form-control">
                                            <span class="input-group-text">
                                                <i class="ti ti-user"></i>
                                            </span>
                                        </div>                                        <small id="last_name_error" class="text-danger"></small>                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <div class="input-group input-group-flat">
                                            <input type="email" id="email" name="email" class="form-control">
                                            <span class="input-group-text">
                                                <i class="ti ti-mail"></i>
                                            </span>
                                        </div>                                        <small id="email_error" class="text-danger"></small>                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="mobile" name="mobile" class="form-control">
                                            <span class="input-group-text">
                                                <i class="ti ti-phone"></i>
                                            </span>
                                        </div>                                        <small id="mobile_error" class="text-danger"></small>                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group input-group-flat pass-group">
                                            <input type="password" id="password" name="password" class="form-control pass-input">
                                            <span class="input-group-text toggle-password ">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>                                        <small id="password_error" class="text-danger"></small>                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group input-group-flat pass-group">
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pass-input">
                                            <span class="input-group-text toggle-password ">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>
                                        <small id="password_confirmation_error" class="text-danger"></small>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="form-check form-check-md d-flex align-items-center">
                                            <input class="form-check-input mt-0" type="checkbox" value="" id="checkebox-md" checked="">
                                            <label class="form-check-label ms-1" for="checkebox-md">I agree to the <a href="javascript:void(0);" class="text-primary link-hover">Terms & Privacy</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" id="registerBtn" class="btn btn-primary w-100">Sign Up</button>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0">Already have an account? <a href="{{route('login')}}" class="link-indigo fw-bold link-hover"> Sign In Instead</a></p>
                                    </div>
                                    {{-- <div class="or-login text-center position-relative mb-3">
                                        <h6 class="fs-14 mb-0 position-relative text-body">OR</h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 mb-3">
                                        <div class="text-center flex-fill">
                                            <a href="javascript:void(0);" class="p-2 btn btn-info d-flex align-items-center justify-content-center">
                                                <img class="img-fluid m-1" src="{{asset('assets/img/icons/facebook-logo.svg')}}" alt="Facebook">
                                            </a>
                                        </div>
                                        <div class="text-center flex-fill">
                                            <a href="javascript:void(0);" class="p-2 btn btn-outline-light d-flex align-items-center justify-content-center">
                                                <img class="img-fluid  m-1" src="{{asset('assets/img/icons/google-logo.svg')}}" alt="Facebook">
                                            </a>
                                        </div>
                                        <div class="text-center flex-fill">
                                            <a href="javascript:void(0);" class="p-2 btn btn-dark d-flex align-items-center justify-content-center">
                                                <img class="img-fluid  m-1" src="{{asset('assets/img/icons/apple-logo.svg')}}" alt="Apple">
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="text-center pb-4">
                                    <p class="text-dark mb-0">Copyright &copy; <script type="b750ab0c66b96dca8b714e70-text/javascript">document.write(new Date().getFullYear())</script> - Shreeda Consulting</p>
                                </div>
                            </form>
                        </div> 
                      

                    </div>
                    <!-- end row -->

                </div> 

                <div class="col-lg-6 account-bg-02"></div> 

            </div>
            <!-- end row -->

        </div>

    </div>
    <!-- End Wrapper -->
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                // Clear all errors
                $('#general_error').addClass('d-none').text('');
                $('#first_name_error').text('');
                $('#middle_name_error').text('');
                $('#last_name_error').text('');
                $('#email_error').text('');
                $('#mobile_error').text('');
                $('#password_error').text('');
                $('#password_confirmation_error').text('');

                let formData = {
                    first_name: $('#first_name').val(),
                    middle_name: $('#middle_name').val(),
                    last_name: $('#last_name').val(),
                    email: $('#email').val(),
                    mobile: $('#mobile').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                };

                $.ajax({
                    url: "{{ url('/api/v1/register') }}",
                    type: "POST",
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    beforeSend: function() {
                        $('#registerBtn').html("Please wait...");
                        $('#registerBtn').prop('disabled', true);
                    },
                    success: function(res) {

                        if (!res.data || !res.data.access_token) {
                            $('#general_error').removeClass('d-none')
                                .text('Invalid response from server');
                            $('#registerBtn').html("Sign Up").prop('disabled', false);
                            return;
                        }

                        // ✅ OPTIONAL: keep token for API usage
                        localStorage.setItem('token', res.data.access_token);
                        localStorage.setItem('token_type', res.data.token_type || 'Bearer');
                        localStorage.setItem('user', JSON.stringify(res.data.user));

                        // ✅ Session is ALREADY created by backend
                        const userType = res.data.user.type;

                        if (userType === 'super_admin') {
                            window.location.href = "{{ url('/admin/super-admin-dashboard') }}";
                        } else {
                            window.location.href = "{{ url('/admin/dashboard') }}";
                        }
                    },
                    error: function(xhr) {
                        $('#registerBtn').html("Sign Up");
                        $('#registerBtn').prop('disabled', false);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.first_name) {
                                $('#first_name_error').text(errors.first_name[0]);
                            }
                            if (errors.middle_name) {
                                $('#middle_name_error').text(errors.middle_name[0]);
                            }
                            if (errors.last_name) {
                                $('#last_name_error').text(errors.last_name[0]);
                            }
                            if (errors.email) {
                                $('#email_error').text(errors.email[0]);
                            }
                            if (errors.mobile) {
                                $('#mobile_error').text(errors.mobile[0]);
                            }
                            if (errors.password) {
                                $('#password_error').text(errors.password[0]);
                            }
                            if (errors.password_confirmation) {
                                $('#password_confirmation_error')
                                    .text(errors.password_confirmation[0]);
                            }
                            return;
                        }

                        $('#general_error').removeClass('d-none')
                            .text(xhr.responseJSON?.message || 'Something went wrong. Please try again.');
                    }
                });
            });

            // ❌ DO NOT rely only on localStorage for auth
            // ✅ Let Laravel session middleware handle redirects
        });

        // $(document).ready(function() {

        //     $('#registerForm').on('submit', function(e) {
        //         e.preventDefault();

        //         // Clear all errors
        //         $('#general_error').addClass('d-none').text('');
        //         $('#first_name_error').text('');
        //         $('#middle_name_error').text('');
        //         $('#last_name_error').text('');
        //         $('#email_error').text('');
        //         $('#mobile_error').text('');
        //         $('#password_error').text('');
        //         $('#password_confirmation_error').text('');

        //         let formData = {
        //             first_name: $('#first_name').val(),
        //             middle_name: $('#middle_name').val(),
        //             last_name: $('#last_name').val(),
        //             email: $('#email').val(),
        //             mobile: $('#mobile').val(),
        //             password: $('#password').val(),
        //             password_confirmation: $('#password_confirmation').val(),
        //         };

        //         $.ajax({
        //             url: "{{ url('/api/v1/register') }}",
        //             type: "POST",
        //             data: JSON.stringify(formData),
        //             contentType: 'application/json',
        //             beforeSend: function() {
        //                 $('#registerBtn').html("Please wait...");
        //                 $('#registerBtn').prop('disabled', true);
        //             },
        //             success: function(res) {
        //                 // Save user data
        //                 localStorage.setItem('user', JSON.stringify(res.data.user));

        //                 // Show success message and redirect
        //                 alert('Registration successful! Please log in.');
        //                 window.location.href = "{{ url('/admin/login') }}";
        //             },
        //             error: function(xhr) {
        //                 $('#registerBtn').html("Sign Up");
        //                 $('#registerBtn').prop('disabled', false);

        //                 // Validation errors (422)
        //                 if (xhr.status === 422) {
        //                     let errors = xhr.responseJSON.errors;

        //                     if (errors.first_name) {
        //                         $('#first_name_error').text(errors.first_name[0]);
        //                     }

        //                     if (errors.middle_name) {
        //                         $('#middle_name_error').text(errors.middle_name[0]);
        //                     }

        //                     if (errors.last_name) {
        //                         $('#last_name_error').text(errors.last_name[0]);
        //                     }

        //                     if (errors.email) {
        //                         $('#email_error').text(errors.email[0]);
        //                     }

        //                     if (errors.mobile) {
        //                         $('#mobile_error').text(errors.mobile[0]);
        //                     }

        //                     if (errors.password) {
        //                         $('#password_error').text(errors.password[0]);
        //                     }

        //                     if (errors.password_confirmation) {
        //                         $('#password_confirmation_error').text(errors.password_confirmation[0]);
        //                     }

        //                     return;
        //                 }

        //                 // Other errors
        //                 $('#general_error').removeClass('d-none').text(
        //                     xhr.responseJSON.message || 'Something went wrong. Please try again.'
        //                 );
        //             }
        //         });
        //     });

        //     // Redirect if already logged in
        //     const token = localStorage.getItem('token');
        //     if (token) {
        //         window.location.href = "{{ url('/admin/dashboard') }}";
        //     }
        // });
    </script>
@endsection