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
								<a href="javascript:void(0);" class="active subdrop">
									<i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="">Dashboard</a></li>
								</ul>
							</li>
				
							{{-- <li>
								<a href="calendar.html"><i class="ti ti-calendar"></i><span>My Calendar</span></a>
							</li>
							<li class="submenu">
								<a href="dashboard.html#" class="subdrop">
									<i class="ti ti-user-star"></i><span>Leads</span>
									<span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="contacts.html">Lead Contacts</a></li>
									<li><a href="deals.html">Deals</a></li>
								</ul>
							</li>
							<li>
								<a href="calendar.html"><i class="ti ti-user"></i><span>Clients</span></a>
							</li>
							<li class="submenu">
								<a href="dashboard.html#" class="subdrop">
									<i class="ti ti-user-star"></i><span>HR</span>
									<span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="company.html">Employees</a></li>
									<li><a href="company.html">Leaves</a></li>
									<li><a href="company.html">Attendance</a></li>
									<li><a href="company.html">Holiday</a></li>
									<li><a href="company.html">Designation</a></li>
									<li><a href="company.html">Department</a></li>
						
								</ul>
							</li>
							<li class="submenu">
								<a href="dashboard.html#">
									<i class="ti ti-layout-grid"></i><span>Project Management</span>
									<span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="contracts.html">Contracts</a></li>
									<li><a href="projects.html">Projects</a></li>
									<li><a href="tasks.html">Tasks</a></li>
									<li><a href="company.html">Timesheet</a></li>
								
								</ul>
							</li> --}}
							
						</ul>
					</li>
					<li class="menu-title"><span>CRM</span></li>
					<li>
						<ul>
							<li>
								<a href="tickets.html"><i class="ti ti-ticket"></i><span>Tickets</span></a>
							</li>
							<li>
								<a href="calendar.html"><i class="ti ti-calendar"></i><span>Events</span></a>
							</li>
							<li>
								<a href="chat.html"><i class="ti ti-message"></i><span>Messages</span></a>
							</li>
							<li>
								<a href="contact-messages.html"><i class="ti ti-message"></i><span>Notice Board</span></a>
							</li>
							<li>
								<a href="invoice-list.html"><i class="ti ti-message"></i><span>Invoice</span></a>
							</li>
							
						</ul>
					</li>
					{{-- <li class="menu-title"><span>Reports</span></li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-report-analytics"></i><span>Reports</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="lead-reports.html">Lead Reports</a></li>
									<li><a href="deal-reports.html">Deal Reports</a></li>
									<li><a href="contact-reports.html">Contact Reports</a></li>
									<li><a href="company-reports.html">Company Reports</a></li>
									<li><a href="project-reports.html">Project Reports</a></li>
									<li><a href="task-reports.html">Task Reports</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="menu-title"><span>CRM Settings</span></li>
					<li>
						<ul>
							<li><a href="industry.html"><i class="ti ti-building-factory"></i><span>Industry</span></a></li>
							<li><a href="companies.html"><i class="ti ti-building-factory"></i><span>Company</span></a></li>
							<li><a href="branch.html"><i class="ti ti-building-factory"></i><span>Branch</span></a></li>
							<li><a href="department.html"><i class="ti ti-building-factory"></i><span>Department</span></a></li>
								<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-map-pin-pin"></i><span>Location</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="countries.html">Countries</a></li>
									<li><a href="states.html">States</a></li>
									<li><a href="cities.html">Cities</a></li>
								</ul>
							</li>       
							
						
						</ul>
					</li>
					<li class="menu-title"><span>User Management</span></li>
					<li>							
						<ul>
							<li><a href="manage-users.html"><i class="ti ti-users"></i><span>Manage Users</span></a></li>
							<li><a href="roles-permissions.html"><i class="ti ti-user-shield"></i><span>Roles & Permissions</span></a></li>
						</ul>
					</li>
					
					
					<li class="menu-title"><span>Support</span></li>
					<li>
						<ul>
							<li><a href="contact-messages.html"><i class="ti ti-message-check"></i><span>Contact Messages</span></a></li>
							<li><a href="tickets.html"><i class="ti ti-ticket"></i><span>Tickets</span></a></li>
						</ul>
					</li> --}}
					<li class="menu-title"><span>Settings</span></li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-settings-cog"></i><span>General Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="profile-settings.html">Profile</a></li>
									<li><a href="security-settings.html">Security</a></li>
									<li><a href="notifications-settings.html">Notifications</a></li>
									<li><a href="connected-apps.html">Connected Apps</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-world-cog"></i><span>Website Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="company-settings.html">Company Settings</a></li>
									<li><a href="localization-settings.html">Localization</a></li>
									<li><a href="prefixes-settings.html">Prefixes</a></li>
									<li><a href="preference-settings.html">Preference</a></li>
									<li><a href="appearance-settings.html">Appearance</a></li>
									<li><a href="language-settings.html">Language</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-apps"></i><span>App Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="invoice-settings.html">Invoice Settings</a></li>
									<li><a href="printers-settings.html">Printers</a></li>
									<li><a href="custom-fields-setting.html">Custom Fields</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-device-laptop"></i><span>System Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="email-settings.html">Email Settings</a></li>
									<li><a href="sms-gateways.html">SMS Gateways</a></li>
									<li><a href="gdpr-cookies.html">GDPR Cookies</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-moneybag"></i><span>Financial Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="payment-gateways.html">Payment Gateways</a></li>
									<li><a href="bank-accounts.html">Bank Accounts</a></li>
									<li><a href="tax-rates.html">Tax Rates</a></li>
									<li><a href="currencies.html">Currencies</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-settings-2"></i><span>Other Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="sitemap.html">Sitemap</a></li>
									<li><a href="clear-cache.html">Clear Cache</a></li>
									<li><a href="storage.html">Storage</a></li>
									<li><a href="cronjob.html">Cronjob</a></li>
									<li><a href="ban-ip-address.html">Ban IP Address</a></li>
									<li><a href="system-backup.html">System Backup</a></li>
									<li><a href="database-backup.html">Database Backup</a></li>
									<li><a href="system-update.html">System Update</a></li>
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
								<a href="javascript:void(0);" class="active subdrop">
									<i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="">Dashboard</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="menu-title"><span>Roles & Permissions</span></li>
					<li>
						<ul>
							<li>
								<a href="javascript:void(0);"><i class="ti ti-ticket"></i><span>Role</span></a>
							</li>
							<li>
								<a href="javascript:void(0);"><i class="ti ti-calendar"></i><span>Permission</span></a>
							</li>
						</ul>
					</li>
					{{-- <li class="menu-title"><span>CRM</span></li>
					<li>
						<ul>
							<li>
								<a href="tickets.html"><i class="ti ti-ticket"></i><span>Tickets</span></a>
							</li>
							<li>
								<a href="calendar.html"><i class="ti ti-calendar"></i><span>Events</span></a>
							</li>
							<li>
								<a href="chat.html"><i class="ti ti-message"></i><span>Messages</span></a>
							</li>
							<li>
								<a href="contact-messages.html"><i class="ti ti-message"></i><span>Notice Board</span></a>
							</li>
							<li>
								<a href="invoice-list.html"><i class="ti ti-message"></i><span>Invoice</span></a>
							</li>
							
						</ul>
					</li> --}}
					{{-- <li class="menu-title"><span>Reports</span></li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-report-analytics"></i><span>Reports</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="lead-reports.html">Lead Reports</a></li>
									<li><a href="deal-reports.html">Deal Reports</a></li>
									<li><a href="contact-reports.html">Contact Reports</a></li>
									<li><a href="company-reports.html">Company Reports</a></li>
									<li><a href="project-reports.html">Project Reports</a></li>
									<li><a href="task-reports.html">Task Reports</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="menu-title"><span>CRM Settings</span></li>
					<li>
						<ul>
							<li><a href="industry.html"><i class="ti ti-building-factory"></i><span>Industry</span></a></li>
							<li><a href="companies.html"><i class="ti ti-building-factory"></i><span>Company</span></a></li>
							<li><a href="branch.html"><i class="ti ti-building-factory"></i><span>Branch</span></a></li>
							<li><a href="department.html"><i class="ti ti-building-factory"></i><span>Department</span></a></li>
								<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-map-pin-pin"></i><span>Location</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="countries.html">Countries</a></li>
									<li><a href="states.html">States</a></li>
									<li><a href="cities.html">Cities</a></li>
								</ul>
							</li>       
							
						
						</ul>
					</li>
					<li class="menu-title"><span>User Management</span></li>
					<li>							
						<ul>
							<li><a href="manage-users.html"><i class="ti ti-users"></i><span>Manage Users</span></a></li>
							<li><a href="roles-permissions.html"><i class="ti ti-user-shield"></i><span>Roles & Permissions</span></a></li>
						</ul>
					</li>
					
					
					<li class="menu-title"><span>Support</span></li>
					<li>
						<ul>
							<li><a href="contact-messages.html"><i class="ti ti-message-check"></i><span>Contact Messages</span></a></li>
							<li><a href="tickets.html"><i class="ti ti-ticket"></i><span>Tickets</span></a></li>
						</ul>
					</li> --}}
					{{-- <li class="menu-title"><span>Settings</span></li>
					<li>
						<ul>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-settings-cog"></i><span>General Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="profile-settings.html">Profile</a></li>
									<li><a href="security-settings.html">Security</a></li>
									<li><a href="notifications-settings.html">Notifications</a></li>
									<li><a href="connected-apps.html">Connected Apps</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-world-cog"></i><span>Website Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="company-settings.html">Company Settings</a></li>
									<li><a href="localization-settings.html">Localization</a></li>
									<li><a href="prefixes-settings.html">Prefixes</a></li>
									<li><a href="preference-settings.html">Preference</a></li>
									<li><a href="appearance-settings.html">Appearance</a></li>
									<li><a href="language-settings.html">Language</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-apps"></i><span>App Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="invoice-settings.html">Invoice Settings</a></li>
									<li><a href="printers-settings.html">Printers</a></li>
									<li><a href="custom-fields-setting.html">Custom Fields</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-device-laptop"></i><span>System Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="email-settings.html">Email Settings</a></li>
									<li><a href="sms-gateways.html">SMS Gateways</a></li>
									<li><a href="gdpr-cookies.html">GDPR Cookies</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-moneybag"></i><span>Financial Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="payment-gateways.html">Payment Gateways</a></li>
									<li><a href="bank-accounts.html">Bank Accounts</a></li>
									<li><a href="tax-rates.html">Tax Rates</a></li>
									<li><a href="currencies.html">Currencies</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);">
									<i class="ti ti-settings-2"></i><span>Other Settings</span><span class="menu-arrow"></span>
								</a>
								<ul>
									<li><a href="sitemap.html">Sitemap</a></li>
									<li><a href="clear-cache.html">Clear Cache</a></li>
									<li><a href="storage.html">Storage</a></li>
									<li><a href="cronjob.html">Cronjob</a></li>
									<li><a href="ban-ip-address.html">Ban IP Address</a></li>
									<li><a href="system-backup.html">System Backup</a></li>
									<li><a href="database-backup.html">Database Backup</a></li>
									<li><a href="system-update.html">System Update</a></li>
								</ul>
							</li>
						</ul>
					</li> --}}					
				</ul>
			@endif
		</div>
	</div>

</div>