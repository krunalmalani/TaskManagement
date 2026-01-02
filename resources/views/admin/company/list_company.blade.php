@extends('layouts.master', ['title' => 'Company Management'])
@section('css')
@endsection
@section('content')
<!-- Start Content -->
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div>
            <h4 class="mb-1">Companies<span class="badge badge-soft-primary ms-2">125</span></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Companies</li>
                </ol>
            </nav>
        </div>
        <div class="gap-2 d-flex align-items-center flex-wrap">
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-package-export me-2"></i>Export</a>
                <div class="dropdown-menu  dropdown-menu-end">
                    <ul>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-pdf me-1"></i>Export as
                                PDF</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Export as
                                Excel </a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
        </div>
    </div>                
    <!-- End Page Header -->
    
    <!-- card start -->
    <div class="card border-0 rounded-0">
        <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <div class="input-icon input-icon-start position-relative">
                <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
            </div>
            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Company</a>
        </div>
        <div class="card-body">

            <!-- table header -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-sort-ascending-2 me-2"></i>Sort By</a>
                        <div class="dropdown-menu">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Newest</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Oldest</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="reportrange" class="reportrange-picker d-flex align-items-center shadow">
                        <i class="ti ti-calendar-due text-dark fs-14 me-1"></i><span class="reportrange-picker-field">9 Jun 25 - 9 Jun 25</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">                                
                        <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-light shadow px-2" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="ti ti-filter me-2"></i>Filter<i class="ti ti-chevron-down ms-2"></i></a>
                        <div class="filter-dropdown-menu dropdown-menu dropdown-menu-lg p-0">
                            <div class="filter-header d-flex align-items-center justify-content-between border-bottom">
                                <h6 class="mb-0"><i class="ti ti-filter me-1"></i>Filter</h6>
                                <button type="button" class="btn-close close-filter-btn" data-bs-dismiss="dropdown-menu" aria-label="Close"></button>
                            </div>
                            <div class="filter-set-view p-3">                                            
                                <div class="accordion" id="accordionExample">
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="companies-list.html#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Owner</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse show" id="collapseTwo" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-2">
                                                    <div class="input-icon-start input-icon position-relative">
                                                        <span class="input-icon-addon fs-12">
                                                            <i class="ti ti-search"></i>
                                                        </span>
                                                        <input type="text" class="form-control form-control-md" placeholder="Search">
                                                    </div>
                                                </div>
                                                <ul class="mb-0">
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-06.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Elizabeth Morgan
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-40.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Katherine Brooks
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-05.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Sophia Lopez
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-10.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>John Michael
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-15.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Natalie Brooks
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-01.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>William Turner
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-13.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Ava Martinez
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-12.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Nathan Reed
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-03.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Lily Anderson
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{ asset('assets/img/users/user-18.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Ryan Coleman
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="link-primary text-decoration-underline p-2 d-flex">Load More</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="companies-list.html#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Tags</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Collab
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Promotion
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            VIP
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="companies-list.html#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Location</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="collapseFive" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-1">
                                                    <div class="input-icon-start input-icon position-relative">
                                                        <span class="input-icon-addon fs-12">
                                                            <i class="ti ti-search"></i>
                                                        </span>
                                                        <input type="text" class="form-control form-control-md" placeholder="Search">
                                                    </div>
                                                </div>
                                                <ul class="mb-0">
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{ asset('assets/img/flags/us.svg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>USA
                                                        </label>
                                                    </li>
                                                        <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{ asset('assets/img/flags/ae.svg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>UAE
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{ asset('assets/img/flags/de.svg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Germany
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{ asset('assets/img/flags/fr.svg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>France
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                                             
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="companies-list.html#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Rating</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="collapseOne" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                                <span class="rating">
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <span class="ms-1">5.0</span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                                <span class="rating">
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <span class="ms-1">4.0</span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                                <span class="rating">
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <span class="ms-1">3.0</span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                                <span class="rating">
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <span class="ms-1">2.0</span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                                <span class="rating">
                                                                <i class="ti ti-star-filled text-warning"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <i class="ti ti-star-filled"></i>
                                                                <span class="ms-1">1.0</span>
                                                            </span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="companies-list.html#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#Status" aria-expanded="false" aria-controls="Status">Status</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="Status" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Active
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Inactive
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                                             
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="javascript:void(0);" class="btn btn-outline-light w-100">Reset</a>
                                    <a href="companies-list.html" class="btn btn-primary w-100">Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn bg-soft-indigo px-2 border-0"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside"><i
                                class="ti ti-columns-3 me-2"></i>Manage Columns</a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-md p-3">
                            <ul>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Name</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Phone</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Email</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Tags</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Location</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Rating</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Owner</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Contact</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch">     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center mb-2">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Status</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                                <li class="gap-1 d-flex align-items-center">       
                                    <i class="ti ti-columns me-1"></i>                                     
                                    <div class="form-check form-switch w-100 ps-0">
                                                                                            
                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                            <span>Action</span>   
                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex align-items-center shadow p-1 rounded border view-icons bg-white">
                        <a href="companies-list.html" class="btn btn-sm p-1 border-0 fs-14 active"><i class="ti ti-list-tree"></i></a>
                        <a href="companies.html" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14"><i class="ti ti-grid-dots"></i></a>
                    </div>
                </div>
            </div>
            <!-- table header -->

            <!-- Contact List -->
            <div class="table-responsive custom-table">
                <table class="table table-nowrap" id="companieslist">
                    <thead class="table-light">
                        <tr>
                            <th class="no-sort">
                                <div class="form-check form-check-md">
                                    <input class="form-check-input" type="checkbox" id="select-all">
                                </div>
                            </th>
                            <th class="no-sort"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tags</th>
                            <th>Owner</th>
                            <th>Contact </th>
                            <th>Status</th>
                            <th class="text-end no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="datatable-length"></div>
                </div>
                <div class="col-md-6">
                    <div class="datatable-paginate"></div>
                </div>
            </div>
            <!-- /Contact List -->
                
        </div>
    </div>
    <!-- card end -->

</div>
<!-- End Content -->

<!-- Add offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Add New Company</h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <form action="companies-list.html">
            <div class="accordion accordion-bordered" id="main_accordion">
                <!-- Basic Info -->
                <div class="accordion-item rounded mb-3">
                    <div class="accordion-header">
                        <a href="companies-list.html#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#basic">
                            <span class="avatar avatar-md rounded me-1"><i
                            class="ti ti-user-plus"></i></span>
                            Basic Info
                        </a>
                    </div>
                    <div class="accordion-collapse collapse show" id="basic" data-bs-parent="#main_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                            <div class="position-relative d-flex align-items-center">
                                                <i class="ti ti-photo text-dark fs-16"></i>
                                            </div>
                                        </div>
                                        <div class="d-inline-flex flex-column align-items-start">
                                            <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                <i class="ti ti-file-broken me-1"></i>Upload file
                                                <input type="file" class="form-control image-sign" multiple="">
                                            </div>
                                            <span>JPG, GIF or PNG. Max size of 800K</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Company Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label">Email <span
                                                    class="text-danger ms-1">*</span></label>
                                            <div class="form-check form-switch mb-1">                                                                                                     
                                                <label class="form-check-label d-flex align-items-center gap-2">
                                                    <span>Email Opt Out</span>   
                                                    <input class="form-check-input form-check-input-sm switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone 1</label>
                                        <input type="text" class="form-control phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone 2</label>
                                        <input type="text" class="form-control phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Fax</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Reviews </label>
                                        <div class="input-group w-auto input-group-flat">													
                                            <input type="text" class="form-control">
                                            <span class="input-group-text"><i class="ti ti-star"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Owner</label>
                                        <select class="select2" data-toggle="select2">
                                            <option>Select</option>
                                            <option>Hendry Milner</option>
                                            <option>Guilory Berggren</option>
                                            <option>Jami Carlile</option>
                                            <option>Theresa Nelson</option>
                                            <option>Smith Cooper</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tags </label>
                                        <input class="input-tags form-control border-0 h-100" data-choices data-choices-limit="infinite" data-choices-removeItem type="text" value="Collab, VIP">
                                        <span class="fs-13">Enter value separated by comma</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <label class="form-label">Deals</label>
                                            <a href="companies-list.html#" class="label-add link-primary mb-1" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_add_2"><i
                                                    class="ti ti-plus me-1"></i>Add New</a>
                                        </div>
                                        <select class="select2" data-toggle="select2">
                                            <option>Select</option>
                                            <option>Collins</option>
                                            <option>Konopelski</option>
                                            <option>Adams</option>
                                            <option>Schumm</option>
                                            <option>Wisozk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Source <span
                                                class="text-danger">*</span></label>
                                        <select class="select2" data-toggle="select2">
                                            <option>Select</option>
                                            <option>Phone Calls</option>
                                            <option>Social Media</option>
                                            <option>Referral Sites</option>
                                            <option>Web Analytics</option>
                                            <option>Previous Purchases</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Industry <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Retail Industry</option>
                                            <option>Banking</option>
                                            <option>Hotels</option>
                                            <option>Financial Services</option>
                                            <option>Insurance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contacts <span class="text-danger">*</span></label>
                                        <select class="multiple-img" multiple="multiple" data-toggle=" multiple">
                                            <option data-image="{{ asset('assets/img/profiles/avatar-19.jpg') }}" selected>Darlee Robertson
                                            </option>
                                            <option data-image="{{ asset('assets/img/users/user-01.jpg') }}">Sharon Roy</option>
                                            <option data-image="{{ asset('assets/img/profiles/avatar-21.jpg') }}">Vaughan Lewis</option>
                                            <option data-image="{{ asset('assets/img/profiles/avatar-23.jpg') }}">Jessica Louise</option>
                                            <option data-image="{{ asset('assets/img/profiles/avatar-16.jpg') }}">Carol Thomas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Currency <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Dollar</option>
                                            <option>Euro</option>
                                            <option>Pound</option>
                                            <option>Rupee</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Language <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>English</option>
                                            <option>Arabic</option>
                                            <option>French</option>
                                            <option>German</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Basic Info -->

                <!-- Address Info -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="companies-list.html#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#address">
                            <span class="avatar avatar-md rounded me-1"><i
                                    class="ti ti-map-pin-cog"></i></span>
                            Address Info
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="address" data-bs-parent="#main_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Street Address </label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>USA</option>
                                            <option>Canada</option>
                                            <option>Germany</option>
                                            <option>France</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">State / Province </label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>California</option>
                                            <option>New York</option>
                                            <option>Texas</option>
                                            <option>Florida</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label">City </label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Los Angeles</option>
                                            <option>San Diego</option>
                                            <option>Fresno</option>
                                            <option>San Francisco</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Zipcode </label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Address Info -->

                <!-- Social Profile -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="companies-list.html#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#social">
                            <span class="avatar avatar-md rounded me-1"><i
                                    class="ti ti-social"></i></span>
                            Social Profile
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="social" data-bs-parent="#main_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Skype </label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Linkedin </label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Twitter</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label">Whatsapp</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Social Profile -->

                <!-- Access -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="companies-list.html#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#access-info">
                            <span class="avatar avatar-md rounded me-1"><i
                                    class="ti ti-accessible"></i></span>
                            Access
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="access-info" data-bs-parent="#main_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Visibility</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            <div class="form-check">
                                                <input type="radio" id="customRadio1" name="customRadio" class="form-check-input">
                                                <label class="form-check-label" for="customRadio1">Public</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" id="customRadio2" name="customRadio" class="form-check-input">
                                                <label class="form-check-label" for="customRadio2">Private</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" id="customRadio3" name="customRadio" class="form-check-input" checked>
                                                <label class="form-check-label" for="customRadio3">Select Pepole</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Access -->
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#create_success">Create New</button>
            </div>
        </form>
    </div>
</div>
<!-- /Add offcanvas -->
@endsection
@section('script')
@endsection