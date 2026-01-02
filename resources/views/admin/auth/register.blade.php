@extends('layouts.auth', ['title' => 'Register'])
@section('css')
    <style>
        .form-control.is-invalid {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: none;
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .input-group .form-control.is-invalid {
            border-color: #dc3545 !important;
        }
        
        .form-control.is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
    </style>
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
                                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="first_name" name="first_name" class="form-control">
                                        </div>                                        
                                        <small id="first_name_error" class="text-danger d-block"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="middle_name" name="middle_name" class="form-control">
                                        </div>                                        
                                        <small id="middle_name_error" class="text-danger"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="last_name" name="last_name" class="form-control">
                                        </div>                                        
                                        <small id="last_name_error" class="text-danger d-block"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="email" id="email" name="email" class="form-control">
                                        </div>                                        
                                        <small id="email_error" class="text-danger d-block"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="mobile" name="mobile" class="form-control">
                                        </div>                                        
                                        <small id="mobile_error" class="text-danger d-block"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="company_name" name="company_name" class="form-control">
                                        </div>
                                        <small id="company_name_error" class="text-danger d-block"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat pass-group">
                                            <input type="password" id="password" name="password" class="form-control pass-input">
                                        </div>                                        
                                        <small id="password_error" class="text-danger d-block"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat pass-group">
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pass-input">
                                        </div>
                                        <small id="password_confirmation_error" class="text-danger d-block"></small>
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

            // Remove error border and message on input focus/change
            $('#first_name, #middle_name, #last_name, #email, #mobile, #company_name, #password, #password_confirmation').on('input', function() {
                $(this).removeClass('is-invalid');
                $('#' + $(this).attr('id') + '_error').text('');
            });

            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                // Clear all errors
                $('#general_error').addClass('d-none').text('');
                $('#first_name_error').text('');
                $('#middle_name_error').text('');
                $('#last_name_error').text('');
                $('#email_error').text('');
                $('#mobile_error').text('');
                $('#company_name_error').text('');
                $('#password_error').text('');
                $('#password_confirmation_error').text('');
                
                // Remove all error borders
                $('#first_name, #middle_name, #last_name, #email, #mobile, #company_name, #password, #password_confirmation').removeClass('is-invalid');

                let formData = {
                    first_name: $('#first_name').val(),
                    middle_name: $('#middle_name').val(),
                    last_name: $('#last_name').val(),
                    email: $('#email').val(),
                    mobile: $('#mobile').val(),
                    company_name: $('#company_name').val(),
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
                                $('#first_name').addClass('is-invalid');
                                $('#first_name_error').text(errors.first_name[0]);
                            }
                            if (errors.middle_name) {
                                $('#middle_name').addClass('is-invalid');
                                $('#middle_name_error').text(errors.middle_name[0]);
                            }
                            if (errors.last_name) {
                                $('#last_name').addClass('is-invalid');
                                $('#last_name_error').text(errors.last_name[0]);
                            }
                            if (errors.email) {
                                $('#email').addClass('is-invalid');
                                $('#email_error').text(errors.email[0]);
                            }
                            if (errors.mobile) {
                                $('#mobile').addClass('is-invalid');
                                $('#mobile_error').text(errors.mobile[0]);
                            }
                            if (errors.company_name) {
                                $('#company_name').addClass('is-invalid');
                                $('#company_name_error').text(errors.company_name[0]);
                            }
                            if (errors.password) {
                                $('#password').addClass('is-invalid');
                                $('#password_error').text(errors.password[0]);
                            }
                            if (errors.password_confirmation) {
                                $('#password_confirmation').addClass('is-invalid');
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
        });
    </script>
@endsection