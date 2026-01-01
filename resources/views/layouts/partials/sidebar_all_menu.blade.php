   <div class="sidebar" id="sidebar">
            
            <!-- Start Logo -->
            <div class="sidebar-logo">
                <div>
                    <!-- Logo Normal -->
                    <a href="index.html" class="logo logo-normal">
                        <img src="{{asset('assets/img/logo.svg')}}" alt="Logo">
                    </a>

                    <!-- Logo Small -->
                    <a href="index.html" class="logo-small">
                        <img src="{{asset('assets/img/logo-small.svg')}}" alt="Logo">
                    </a>

                    <!-- Logo Dark -->
                    <a href="index.html" class="dark-logo">
                        <img src="{{asset('assets/img/logo-white.svg')}}" alt="Logo">
                    </a>
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
                    <ul>
                        <li class="menu-title"><span>Main Menu</span></li>
						<li>
							<ul>
								<li class="submenu">
									<a href="javascript:void(0);">
										<i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
									</a>
									<ul>
										<li><a href="index.html">Deals Dashboard</a></li>
										<li><a href="leads-dashboard.html">Leads Dashboard</a></li>
										<li><a href="project-dashboard.html">Project Dashboard</a></li>
									</ul>
								</li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-brand-airtable"></i><span>Applications</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="chat.html">Chat</a></li>
										<li class="submenu submenu-two">
											<a href="javascript:void(0);">Call<span class="menu-arrow inside-submenu"></span></a>
											<ul>
												<li><a href="video-call.html">Video Call</a></li>
												<li><a href="audio-call.html">Audio Call</a></li>
												<li><a href="call-history.html">Call History</a></li>
											</ul>
										</li>
										<li><a href="calendar.html">Calendar</a></li>
										<li><a href="email.html">Email</a></li>
										<li><a href="todo.html">To Do</a></li>
										<li><a href="notes.html">Notes</a></li>
										<li><a href="file-manager.html">File Manager</a></li>
										<li><a href="social-feed.html">Social Feed</a></li>
										<li><a href="kanban-view.html">Kanban</a></li>
										<li><a href="invoice.html">Invoices</a></li>
									</ul>
								</li>
								<li class="submenu">
									<a href="dashboard.html#" class="active subdrop">
										<i class="ti ti-user-star"></i><span>Super Admin</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
										<li><a href="dashboard.html" class="active">Dashboard</a></li>
										<li><a href="company.html">Companies</a></li>
										<li><a href="subscription.html">Subscriptions</a></li>
										<li><a href="packages.html">Packages</a></li>
										<li><a href="domain.html">Domain</a></li>
										<li><a href="purchase-transaction.html">Purchase Transaction</a></li>
									</ul>
								</li>
                                <li class="submenu">
									<a href="dashboard.html#">
										<i class="ti ti-layout-grid"></i><span>Layouts</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
										<li><a href="layout-mini.html">Mini</a></li>
										<li><a href="layout-hoverview.html">Hover View</a></li>
										<li><a href="layout-hidden.html">Hidden</a></li>
										<li><a href="layout-fullwidth.html">Full Width</a></li>
										<li><a href="layout-rtl.html">RTL</a></li>
										<li><a href="layout-dark.html">Dark</a></li>
									</ul>
								</li>
							</ul>
						</li>
                        <li class="menu-title"><span>CRM</span></li>
						<li>
							<ul>
								<li>
									<a href="contacts.html"><i class="ti ti-user-up"></i><span>Contacts</span></a>
								</li>
								<li>
									<a href="companies.html"><i class="ti ti-building-community"></i><span>Companies</span></a>
								</li>
								<li>
									<a href="deals.html"><i class="ti ti-medal"></i><span>Deals</span></a>
								</li>
								<li>
									<a href="leads.html"><i class="ti ti-chart-arcs"></i><span>Leads</span></a>
								</li>
								<li>
									<a href="pipeline.html"><i class="ti ti-timeline-event-exclamation"></i><span>Pipeline</span></a>
								</li>
								<li>
									<a href="campaign.html"><i class="ti ti-brand-campaignmonitor"></i><span>Campaign</span></a>
								</li>
								<li>
									<a href="projects.html"><i class="ti ti-atom-2"></i><span>Projects</span></a>
								</li>
								<li>
									<a href="tasks.html"><i class="ti ti-list-check"></i><span>Tasks</span></a>
								</li>
								<li>
									<a href="proposals.html"><i class="ti ti-file-star"></i><span>Proposals</span></a>
								</li>
								<li>
									<a href="contracts.html"><i class="ti ti-file-check"></i><span>Contracts</span></a>
								</li>
								<li>
									<a href="estimations.html"><i class="ti ti-file-report"></i><span>Estimations</span></a>
								</li>
								<li>
									<a href="invoices.html"><i class="ti ti-file-invoice"></i><span>Invoices</span></a>
								</li>
								<li>
									<a href="payments.html"><i class="ti ti-report-money"></i><span>Payments</span></a>
								</li>
								<li>
									<a href="analytics.html"><i class="ti ti-chart-bar"></i><span>Analytics</span></a>
								</li>
								<li>
									<a href="activities.html"><i class="ti ti-bounce-right"></i><span>Activities</span></a>
								</li>
							</ul>
						</li>
                        <li class="menu-title"><span>Reports</span></li>
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
								<li><a href="sources.html"><i class="ti ti-artboard"></i><span>Sources</span></a></li>
								<li><a href="lost-reason.html"><i class="ti ti-message-exclamation"></i><span>Lost Reason</span></a></li>
								<li><a href="contact-stage.html"><i class="ti ti-steam"></i><span>Contact Stage</span></a></li>
								<li><a href="industry.html"><i class="ti ti-building-factory"></i><span>Industry</span></a></li>
								<li><a href="calls.html"><i class="ti ti-phone-check"></i><span>Calls</span></a></li>
							</ul>
						</li>
                        <li class="menu-title"><span>User Management</span></li>
						<li>							
							<ul>
								<li><a href="manage-users.html"><i class="ti ti-users"></i><span>Manage Users</span></a></li>
								<li><a href="roles-permissions.html"><i class="ti ti-user-shield"></i><span>Roles & Permissions</span></a></li>
								<li><a href="delete-request.html"><i class="ti ti-flag-question"></i><span>Delete Request</span></a></li>
							</ul>
						</li>
                        <li class="menu-title"><span>Membership</span></li>
						<li>
							<ul>
								<li class="submenu">
									<a href="javascript:void(0);">
										<i class="ti ti-brand-apple-podcast"></i><span>Membership</span><span class="menu-arrow"></span>
									</a>
									<ul>
										<li><a href="membership-plans.html">Membership Plans</a></li>
										<li><a href="membership-addons.html">Membership Addons</a></li>
										<li><a href="membership-transactions.html">Transactions</a></li>
									</ul>
								</li>
							</ul>
						</li>
                        <li class="menu-title"><span>Content</span></li>
						<li>
							<ul>
								<li><a href="pages.html"><i class="ti ti-page-break"></i><span>Pages</span></a></li>
								<li class="submenu">
									<a href="javascript:void(0);">
										<i class="ti ti-brand-blogger"></i><span>Blog</span><span class="menu-arrow"></span>
									</a>
									<ul>
										<li><a href="blogs.html">All Blogs</a></li>
										<li><a href="blog-categories.html">Blog Categories</a></li>
										<li><a href="blog-comments.html">Blog Comments</a></li>
                                        <li><a href="blog-tags.html">Blog Tags</a></li>
									</ul>
								</li>
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
								<li><a href="testimonials.html"><i class="ti ti-quote"></i><span>Testimonials</span></a></li>
								<li><a href="faq.html"><i class="ti ti-question-mark"></i><span>FAQ</span></a></li>
							</ul>
						</li>
                        <li class="menu-title"><span>Support</span></li>
						<li>
							<ul>
								<li><a href="contact-messages.html"><i class="ti ti-message-check"></i><span>Contact Messages</span></a></li>
								<li><a href="tickets.html"><i class="ti ti-ticket"></i><span>Tickets</span></a></li>
							</ul>
						</li>
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
                        <li class="menu-title"><span>Pages</span></li>
						<li>
							<ul>
								<li class="submenu">
									<a href="javascript:void(0);">
										<i class="ti ti-lock-square-rounded"></i><span>Authentication</span><span class="menu-arrow"></span>
									</a>
									<ul>
										<li><a href="login.html">Login</a></li>
										<li><a href="register.html">Register</a></li>
										<li><a href="forgot-password.html">Forgot Password</a></li>
										<li><a href="reset-password.html">Reset Password</a></li>
										<li><a href="email-verification.html">Email Verification</a></li>
										<li><a href="two-step-verification.html">2 Step Verification</a></li>
										<li><a href="lock-screen.html">Lock Screen</a></li>
									</ul>
								</li>
								<li class="submenu">
									<a href="javascript:void(0);">
										<i class="ti ti-error-404"></i><span>Error Pages</span><span class="menu-arrow"></span>
									</a>
									<ul>
										<li><a href="error-404.html">404 Error</a></li>
										<li><a href="error-500.html">500 Error</a></li>
									</ul>
								</li>
								<li><a href="blank-page.html"><i class="ti ti-file"></i><span>Blank Page</span></a></li>
								<li><a href="coming-soon.html"><i class="ti ti-inner-shadow-top-right"></i><span>Coming Soon</span></a></li>
								<li><a href="under-maintenance.html"><i class="ti ti-info-triangle"></i><span>Under Maintenance</span></a></li>
							</ul>
						</li>
						<li class="menu-title"><span>UI Interface</span></li>
                        <li>
                            <ul>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-hierarchy"></i><span>Base UI</span><span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="ui-accordion.html">Accordion</a></li>
                                        <li><a href="ui-alerts.html">Alerts</a></li>
                                        <li><a href="ui-avatar.html">Avatar</a></li>
                                        <li><a href="ui-badges.html">Badges</a></li>
                                        <li><a href="ui-breadcrumb.html">Breadcrumb</a></li>
                                        <li><a href="ui-buttons.html">Buttons</a></li>
                                        <li><a href="ui-buttons-group.html">Button Group</a></li>
                                        <li><a href="ui-cards.html">Card</a></li>
                                        <li><a href="ui-carousel.html">Carousel</a></li>
                                        <li><a href="ui-collapse.html">Collapse</a></li>
                                        <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                                        <li><a href="ui-ratio.html">Ratio</a></li>
                                        <li><a href="ui-grid.html">Grid</a></li>
                                        <li><a href="ui-images.html">Images</a></li>
                                        <li><a href="ui-links.html">Links</a></li>
                                        <li><a href="ui-list-group.html">List Group</a></li>
                                        <li><a href="ui-modals.html">Modals</a></li>
                                        <li><a href="ui-offcanvas.html">Offcanvas</a></li>
                                        <li><a href="ui-pagination.html">Pagination</a></li>
                                        <li><a href="ui-placeholders.html">Placeholders</a></li>
                                        <li><a href="ui-popovers.html">Popovers</a></li>
                                        <li><a href="ui-progress.html">Progress</a></li>
                                        <li><a href="ui-scrollspy.html">Scrollspy</a></li>
                                        <li><a href="ui-spinner.html">Spinner</a></li>
                                        <li><a href="ui-nav-tabs.html">Tabs</a></li>
                                        <li><a href="ui-toasts.html">Toasts</a></li>
                                        <li><a href="ui-tooltips.html">Tooltips</a></li>
                                        <li><a href="ui-typography.html">Typography</a></li>
                                        <li><a href="ui-utilities.html">Utilities</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-whirl"></i><span>Advanced UI</span><span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="ui-dragula.html">Dragula</a></li>
                                        <li><a href="ui-clipboard.html">Clipboard</a></li>
                                        <li><a href="ui-rangeslider.html">Range Slider</a></li>
                                        <li><a href="ui-sweetalerts.html">Sweet Alerts</a></li>
                                        <li><a href="ui-lightbox.html">Lightbox</a></li>
                                        <li><a href="ui-rating.html">Rating</a></li>
                                        <li><a href="ui-scrollbar.html">Scrollbar</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-forms"></i><span>Forms</span><span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li class="submenu submenu-two">
                                            <a href="javascript:void(0);">Form Elements<span class="menu-arrow inside-submenu"></span></a>
                                            <ul>
                                                <li><a href="form-basic-inputs.html">Basic Inputs</a></li>
                                                <li><a href="form-checkbox-radios.html">Checkbox & Radios</a></li>
                                                <li><a href="form-input-groups.html">Input Groups</a></li>
                                                <li><a href="form-grid-gutters.html">Grid & Gutters</a></li>
                                                <li><a href="form-mask.html">Input Masks</a></li>
                                                <li><a href="form-fileupload.html">File Uploads</a></li>
                                            </ul>
                                        </li>
                                        <li class="submenu submenu-two">
                                            <a href="javascript:void(0);">Layouts<span class="menu-arrow inside-submenu"></span></a>
                                            <ul>
                                                <li><a href="form-horizontal.html">Horizontal Form</a></li>
                                                <li><a href="form-vertical.html">Vertical Form</a></li>
                                                <li><a href="form-floating-labels.html">Floating Labels</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="form-validation.html">Form Validation</a></li>
                                        <li><a href="form-select.html">Form Select</a></li>
                                        <li><a href="form-wizard.html">Form Wizard</a></li>
                                        <li><a href="form-pickers.html">Form Picker</a></li>
                                        <li><a href="form-editors.html">Form Editors</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-table"></i><span>Tables</span><span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="tables-basic.html">Basic Tables </a></li>
                                        <li><a href="data-tables.html">Data Table </a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-chart-pie-3"></i><span>Charts</span><span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="chart-apex.html">Apex Charts</a></li>
                                        <li><a href="chart-c3.html">Chart C3</a></li>
                                        <li><a href="chart-js.html">Chart Js</a></li>
                                        <li><a href="chart-morris.html">Morris Charts</a></li>
                                        <li><a href="chart-flot.html">Flot Charts</a></li>
                                        <li><a href="chart-peity.html">Peity Charts</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-icons"></i><span>Icons</span><span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
                                        <li><a href="icon-tabler.html">Tabler Icons</a></li>
                                        <li><a href="icon-bootstrap.html">Bootstrap Icons</a></li>
                                        <li><a href="icon-remix.html">Remix Icons</a></li>
                                        <li><a href="icon-feather.html">Feather Icons</a></li>
                                        <li><a href="icon-ionic.html">Ionic Icons</a></li>
                                        <li><a href="icon-material.html">Material Icons</a></li>
                                        <li><a href="icon-pe7.html">Pe7 Icons</a></li>
                                        <li><a href="icon-simpleline.html">Simpleline Icons</a></li>
                                        <li><a href="icon-themify.html">Themify Icons</a></li>
                                        <li><a href="icon-weather.html">Weather Icons</a></li>
                                        <li><a href="icon-typicon.html">Typicon Icons</a></li>
                                        <li><a href="icon-flag.html">Flag Icons</a></li>
                                    </ul>
                                </li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-map-star"></i><span>Maps</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
										<li>
											<a href="maps-vector.html">Vector</a>
										</li>
										<li>
											<a href="maps-leaflet.html">Leaflet</a>
										</li>
									</ul>
								</li>
                            </ul>
                        </li>
                        <li class="menu-title"><span>Help</span></li>
						<li>
							<ul>
								<li><a href="javascript:void(0);"><i class="ti ti-file-stack"></i><span>Documentation</span></a></li>
								<li><a href="javascript:void(0);"><i class="ti ti-arrow-capsule"></i><span>Changelog v2.3.0</span></a></li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-menu-deep"></i><span>Multi Level</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="javascript:void(0);">Level 1.1</a></li>
										<li class="submenu submenu-two"><a href="javascript:void(0);">Level 1.2<span class="menu-arrow inside-submenu"></span></a>
											<ul>
												<li><a href="javascript:void(0);">Level 2.1</a></li>
												<li class="submenu submenu-two submenu-three"><a href="javascript:void(0);">Level 2.2<span class="menu-arrow inside-submenu inside-submenu-two"></span></a>
													<ul>
														<li><a href="javascript:void(0);">Level 3.1</a></li>
														<li><a href="javascript:void(0);">Level 3.2</a></li>
													</ul>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
                </div>
            </div>

        </div>