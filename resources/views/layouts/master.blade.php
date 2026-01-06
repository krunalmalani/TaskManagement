<?php 
    $userData = Session::get('user');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('title')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Advanced Task Management Solutions">
	<meta name="keywords" content="Advanced Task Management Solutions">
	<meta name="author" content="Task Management">
	<meta name="robots" content="no-index, no-follow">
	
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">

    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="{{asset('assets/img/apple-icon.png')}}">

    <!-- Theme Config Js -->
    <script>
    const appAsset = "{{ asset('') }}";
    </script>
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <!-- Daterangepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables/css/dataTables.bootstrap5.min.css')}}">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.min.css')}}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{asset('assets/plugins/tabler-icons/tabler-icons.min.css')}}">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{asset('assets/plugins/simplebar/simplebar.min.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" id="app-style">
    @yield('css')
</head>

<body>
    <!-- Toast Container (Bootstrap Native) -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;" id="toastContainer" aria-live="polite" aria-atomic="true"></div>

    <!-- Begin Wrapper -->
    <div class="main-wrapper">

        <!-- Topbar/Header Start -->
        @include('layouts.partials.header')
        <!-- Topbar/Header End -->

        <!-- Sidebar -->
        <div id="sidebar-container">
            @include("layouts.partials.sidebar")
        </div>
        <!-- Sidenav Menu End -->

        <!-- ========================
			Start Page Content
		========================= -->
         
        <div class="page-wrapper">

            <!-- Start Content -->
            @yield('content')
            <!-- End Content -->            

            <!-- Start Footer -->
             @include("layouts.partials.footer")
            <!-- End Footer -->

        </div>

        <!-- ========================
			End Page Content
		========================= -->

    </div>
    <!-- End Wrapper -->


    <!-- jQuery -->
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script> 
    
    <!-- Daterangepikcer JS -->
	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Apexchart JS -->
	<script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>
	<script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>

	<!-- Chart JS -->
	<script src="{{asset('assets/plugins/peity/jquery.peity.min.js')}}"></script>
	<script src="{{asset('assets/plugins/peity/chart-data.js')}}"></script>
    
	<!-- Simplebar JS -->
	<script src="{{asset('assets/plugins/simplebar/simplebar.min.js')}}"></script>

    <!-- Select2 JS -->
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <!-- Flatpickr JS -->
    <script src="{{asset('assets/plugins/flatpickr/flatpickr.min.js')}}"></script>

    <!-- Datatable JS -->
    <script src="{{asset('assets/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/js/dataTables.bootstrap5.min.js')}}"></script>

    <!-- Axios for API calls -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
    <script src="{{asset('assets/js/axios.min.js')}}"></script>

    <!-- Common Utilities -->
    <script src="{{asset('assets/js/common.js')}}"></script>

    <!-- Custom Datatable & CRUD -->
    <script src="{{asset('assets/js/custom.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('assets/js/script.js')}}"></script>
    @yield('script')
    <script>
        // Get base URL
        const baseUrl = "{{ url('/') }}";
        // const token = localStorage.getItem('token');
        
        // Logout functionality
        // const logoutBtn = document.getElementById("logoutBtn");
        // if (logoutBtn) {
        //     logoutBtn.addEventListener("click", async (e) => {
        //         e.preventDefault();
        //         const token = localStorage.getItem("token");

        //         try {
        //             const response = await fetch(baseUrl + "/api/v1/logout", {
        //                 method: "POST",
        //                 headers: {
        //                     "Authorization": "Bearer " + token,
        //                     "Content-Type": "application/json",
        //                     "Accept": "application/json"
        //                 }
        //             });

        //             console.log('Logout response status:', response.status);
        //         } catch (error) {
        //             console.error('Logout error:', error);
        //         }
                
        //         // Clear token and redirect
        //         localStorage.removeItem("token");
        //         localStorage.removeItem("user");
        //         localStorage.removeItem("token_type");
        //         window.location.href = baseUrl + "/admin/login";
        //     });
        // }

        // $('#logoutBtn').on('click', function (e) {
        //     e.preventDefault();

        //     const token = localStorage.getItem('token');
        //     const csrfToken = "{{ csrf_token() }}";

        //     // Function to clear everything and redirect
        //     function clearAndRedirect() {
        //         // ✅ Clear all localStorage items
        //         localStorage.removeItem('token');
        //         localStorage.removeItem('token_type');
        //         localStorage.removeItem('user');
        //         localStorage.clear();

        //         // ✅ Redirect to login
        //         setTimeout(function() {
        //             window.location.href = "{{ url('/admin/login') }}";
        //         }, 300);
        //     }

        //     // AJAX call to logout API
        //     $.ajax({
        //         url: "{{ url('/api/v1/logout') }}",
        //         type: "POST",
        //         headers: {
        //             'Authorization': token ? 'Bearer ' + token : '',
        //             'X-CSRF-TOKEN': csrfToken,
        //             'Content-Type': 'application/json',
        //             'Accept': 'application/json'
        //         },
        //         data: JSON.stringify({}),
        //         complete: function (xhr) {
        //             // Call logout-session to clear server-side session
        //             $.ajax({
        //                 url: "{{ url('/api/v1/logout-session') }}",
        //                 type: "POST",
        //                 headers: {
        //                     'X-CSRF-TOKEN': csrfToken,
        //                     'Content-Type': 'application/json',
        //                     'Accept': 'application/json'
        //                 },
        //                 data: JSON.stringify({}),
        //                 complete: function () {
        //                     // Regardless of response, clear and redirect
        //                     clearAndRedirect();
        //                 }
        //             });
        //         }
        //     });
        // });

        // $('#logoutBtn').on('click', function ()
        // {
        //     $.ajax({
        //         url: "/admin/logout",
        //         type: "POST",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //             'Authorization': 'Bearer ' + localStorage.getItem('token')
        //         },
        //         success: function () {

        //             // Clear client storage
        //             localStorage.clear();
        //             sessionStorage.clear();

        //             // Redirect
        //             window.location.href = "/admin/login";
        //         }
        //     });
        // });
    </script>

    <!-- Common Delete Confirmation Modal -->
    <div class="modal fade" id="commonDeleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="commonDeleteMessage">Are you sure you want to delete this item? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="commonDeleteConfirmBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>