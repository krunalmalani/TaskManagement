<?php 
	$userData = Session::get('user');
?>
<div class="sidebar" id="sidebar">
	
	<!-- Start Logo -->
	<div class="sidebar-logo">
		<div>
			@if($userData['type'] == 'super_admin')
				<!-- Logo Normal -->
				<a href="{{ route('super-admin-dashboard')}}" class="logo logo-normal">
					<img src="{{asset('assets/img/logo.svg')}}" alt="Logo">
				</a>

				<!-- Logo Small -->
				<a href="{{ route('super-admin-dashboard')}}" class="logo-small">
					<img src="{{asset('assets/img/logo-small.svg')}}" alt="Logo">
				</a>

				<!-- Logo Dark -->
				<a href="{{ route('super-admin-dashboard')}}" class="dark-logo">
					<img src="{{asset('assets/img/logo-white.svg')}}" alt="Logo">
				</a>
			@elseif($userData['type'] == 'admin')
				<!-- Logo Normal -->	
				<a href="{{ route('dashboard')}}" class="logo logo-normal">
					<img src="{{asset('assets/img/logo.svg')}}" alt="Logo">
				</a>

				<!-- Logo Small -->
				<a href="{{ route('dashboard')}}" class="logo-small">
					<img src="{{asset('assets/img/logo-small.svg')}}" alt="Logo">
				</a>

				<!-- Logo Dark -->
				<a href="{{ route('dashboard')}}" class="dark-logo">
					<img src="{{asset('assets/img/logo-white.svg')}}" alt="Logo">
				</a>
			@endif
			
		</div>
		<button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn"> 
			<i class="ti ti-arrow-bar-to-left"></i>
		</button>

		<!-- Sidebar Menu Close -->
		<button class="sidebar-close">
			<i class="ti ti-x align-middle"></i>
		</button>                
	</div>
	<!-- End Logo -->

	<!-- Sidenav Menu -->
	<div class="sidebar-inner" data-simplebar>                
		<div id="sidebar-menu" class="sidebar-menu">
			@if($userData['type'] == 'super_admin')
				<ul>
					<li class="menu-title"><span>Main Menu</span></li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);" class="{{ Route::currentRouteName() === 'super-admin-dashboard' ? 'active subdrop' : '' }}">
									<i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="{{ route('super-admin-dashboard') }}" class="{{ Route::currentRouteName() === 'super-admin-dashboard' ? 'active' : '' }}">Dashboard</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);" class="{{ Route::currentRouteName() === 'super-admin-users-index' ? 'active subdrop' : '' }}">
									<i class="ti ti-dashboard"></i><span>User Management</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="{{ route('super-admin-users-index') }}" class="{{ Route::currentRouteName() === 'super-admin-users-index' ? 'active' : '' }}">User Management</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);" class="{{ Route::currentRouteName() === 'super-admin-countries-index' ? 'active subdrop' : '' }}">
									<i class="ti ti-dashboard"></i><span>Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="{{ route('super-admin-countries-index') }}" class="{{ Route::currentRouteName() === 'super-admin-countries-index' ? 'active' : '' }}">Country Management</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			@elseif($userData['type'] == 'admin')
				<ul>
					<li class="menu-title"><span>Main Menu</span></li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);" class="{{ Route::currentRouteName() === 'dashboard' ? 'active subdrop' : '' }}">
									<i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="{{ route('dashboard') }}" class="{{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">Dashboard</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);" class="{{ str_contains(Route::currentRouteName(), 'role') || str_contains(Route::currentRouteName(), 'permission') ? 'active subdrop' : '' }}">
									<i class="ti ti-dashboard"></i><span>Roles & Permissions</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li>
										<a href="{{ route('list_role') }}" class="{{ str_contains(Route::currentRouteName(), 'role') ? 'active' : '' }}"><i class="ti ti-ticket"></i><span>Role</span></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="{{ str_contains(Route::currentRouteName(), 'permission') ? 'active' : '' }}"><i class="ti ti-calendar"></i><span>Permission</span></a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);" class="{{ str_contains(Route::currentRouteName(), 'company') || str_contains(Route::currentRouteName(), 'branch') || str_contains(Route::currentRouteName(), 'department') ? 'active subdrop' : '' }}">
									<i class="ti ti-dashboard"></i><span>Company Data</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li>
										<a href="{{ route('list_company') }}" class="{{ str_contains(Route::currentRouteName(), 'company') ? 'active' : '' }}"><i class="ti ti-ticket"></i><span>Company</span></a>
									</li>
									<li>
										<a href="{{ route('list_branch') }}" class="{{ str_contains(Route::currentRouteName(), 'branch') ? 'active' : '' }}"><i class="ti ti-calendar"></i><span>Branch</span></a>
									</li>
									<li>
										<a href="{{ route('list_department') }}" class="{{ str_contains(Route::currentRouteName(), 'department') ? 'active' : '' }}"><i class="ti ti-calendar"></i><span>Department</span></a>
									</li>
								</ul>
							</li>
						</ul>
					</li>					
				</ul>
			@endif
		</div>
	</div>

</div>