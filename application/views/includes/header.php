 
	<!-- HK Wrapper -->
	

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-xl navbar-dark fixed-top hk-navbar">
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="<?php echo base_url()."assets/"; ?>"><span class="feather-icon"><i data-feather="menu"></i></span></a>
            <a class="navbar-brand" href="<?php echo site_url('home'); ?>">
                <img class="brand-img d-inline-block" src="https://www.fastcoo.online/logofolder/51215454698281563073975.png" width="70" alt="brand" />
            </a>
            <ul class="navbar-nav hk-navbar-content">
                <li class="nav-item">
                    <a id="navbar_search_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="search"></i></span></a>
                </li>
                <li class="nav-item">
                    <a id="settings_toggle_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="settings"></i></span></a>
                </li>
                <li class="nav-item dropdown dropdown-notifications">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="feather-icon"><i data-feather="bell"></i></span><span class="badge-wrap"><span class="badge badge-primary badge-indicator badge-indicator-sm badge-pill pulse"></span></span></a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <h6 class="dropdown-header">Notifications <a href="javascript:void(0);" class="">View all</a></h6>
                        <div class="notifications-nicescroll-bar">
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo base_url()."assets/"; ?>dist/img/avatar1.jpg" alt="user" class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text"><span class="text-dark text-capitalize">Evie Ono</span> accepted your invitation to join the team</div>
                                            <div class="notifications-time">12m</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo base_url()."assets/"; ?>dist/img/avatar2.jpg" alt="user" class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">New message received from <span class="text-dark text-capitalize">Misuko Heid</span></div>
                                            <div class="notifications-time">1h</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-primary rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-account font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">You have a follow up with<span class="text-dark text-capitalize"> head</span> on <span class="text-dark text-capitalize">friday, dec 19</span> at <span class="text-dark">10.00 am</span></div>
                                            <div class="notifications-time">2d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-success rounded-circle">
													<span class="initial-wrap"><span>A</span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Application of <span class="text-dark text-capitalize">Sarah Williams</span> is waiting for your approval</div>
                                            <div class="notifications-time">1w</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-warning rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-notifications font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Last 2 days left for the project</div>
                                            <div class="notifications-time">15d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-img-wrap">
                                <div class="avatar">
                                    <img src="<?php echo base_url()."assets/"; ?>dist/img/avatar12.jpg" alt="user" class="avatar-img rounded-circle">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>
                            <div class="media-body">
                                <span>Madelyn Shane<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <a class="dropdown-item" href="<?php echo site_url('my_profile'); ?>"><i class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></a>
                        <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-card"></i><span>My balance</span></a>
                        <a class="dropdown-item" href="inbox.html"><i class="dropdown-icon zmdi zmdi-email"></i><span>Inbox</span></a>
                     <!--   <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-settings"></i><span>Settings</span></a>-->
                        <div class="dropdown-divider"></div>
                        <div class="sub-dropdown-menu show-on-hover">
                            <a href="#" class="dropdown-toggle dropdown-item no-caret"><i class="zmdi zmdi-check text-success"></i>Online</a>
                            <div class="dropdown-menu open-left-side">
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-check text-success"></i><span>Online</span></a>
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-circle-o text-warning"></i><span>Busy</span></a>
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-minus-circle-outline text-danger"></i><span>Offline</span></a>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></a>
						
                    </div>
                </li>
            </ul>
        </nav>
        <form role="search" class="navbar-search">
            <div class="position-relative">
                <a href="javascript:void(0);" class="navbar-search-icon"><span class="feather-icon"><i data-feather="search"></i></span></a>
                <input type="text" name="example-input1-group2" class="form-control" placeholder="Type here to Search">
                <a id="navbar_search_close" class="navbar-search-close" href="#"><span class="feather-icon"><i data-feather="x"></i></span></a>
            </div>
        </form>
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
		
        <nav class="hk-nav hk-nav-light">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                <div class="navbar-nav-wrap">
                <ul class="navbar-nav flex-column">
				
                        <li class="nav-item">
                             <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#gen_setting_drp">
                                <span class="feather-icon"><i data-feather="zap"></i></span>
                                <span class="nav-link-text">General Setting</span>  
                            </a>
                            <ul id="gen_setting_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('company_details'); ?>">Company Details</a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('upload_app'); ?>">Upload Apps</a>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('social_details'); ?>">Social Details</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('smtp_configuration'); ?>">SMTP Configuration</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('payment_setting'); ?>">Payment Setting</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_testimonial'); ?>">Show Testimonial</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_about_us'); ?>">Show About Us</a>
                                        </li>
										</ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#operation_filter_drp">
                                <span class="feather-icon"><i data-feather="zap"></i></span>
                                <span class="nav-link-text">Operation Filter</span>
                            </a>
                            <ul id="operation_filter_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('ofd_issue'); ?>">OFD Issue</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('order_not_picked'); ?>">Order Not Picked</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('shipments_hold'); ?>">Shipments on Hold</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('csa_schedule_issue'); ?>">CSA/Schedule Issue</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('csa_location_issue'); ?>">CSA/Location Issue</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('driver_update'); ?>">Driver not Update(OFD)</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('future_update'); ?>">Reschedule for future Update</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('not_dispatch'); ?>">Schedule Not Dispatch</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#ship_mgmnt_drp">
                                <span class="feather-icon"><i data-feather="zap"></i></span>
                                <span class="nav-link-text">Shipment Management</span>
                            </a>
                            <ul id="ship_mgmnt_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('all_shipment'); ?>">All Shipment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('archive_shipment'); ?>">Archive Shipment</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_new_shipment'); ?>">Add New Shipment</a>
                                        </li>
										<!--<li class="nav-item">
                                            <a class="nav-link" href="<//?php echo site_url('return_orders'); ?>">Return Orders</a>
                                        </li>-->
										<!--<li class="nav-item">
                                            <a class="nav-link" href="<//?php echo site_url('delivered_shipment'); ?>">Delivered Shipment</a>
                                        </li>-->
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('deleted_shipment'); ?>">Deleted Shipment</a>
                                        </li>
										<!--<li class="nav-item">
                                            <a class="nav-link" href="<//?php echo site_url('scanned_not_listed'); ?>">In Transit/Scanned not Listed</a>
                                        </li>-->
										<!--<li class="nav-item">
                                            <a class="nav-link" href="<//?php echo site_url('schedule_shipment1'); ?>">Schedule Shipment</a>
                                        </li>-->
										<!--<li class="nav-item">
                                            <a class="nav-link" href="<//?php echo site_url('import_new_shipment'); ?>">Import New Shipment</a>
                                        </li>-->
										<!--<li class="nav-item">
                                            <a class="nav-link" href="<//?php echo site_url('import_return_shipment'); ?>">Import Return Shipment</a>
                                        </li>-->
										
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('bulk_update'); ?>">Bulk Update</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('assigning_shipments'); ?>">Assigning Shipments for CS</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('bulk_print'); ?>">Bulk Print</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('ready_delivery'); ?>">Ready For Delivery</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#bulk_drp">
                                <span class="feather-icon"><i data-feather="file-text"></i></span>
                                <span class="nav-link-text">Bulk Invoice Management</span>
                            </a>
                            <ul id="bulk_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_bulk_scan'); ?>">Add Bulk Scan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('cod_invoices'); ?>">COD Invoices</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('payable_invoices'); ?>">Payable Invoice</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('payable_invoice_cod'); ?>">Payable Invoice COD</a>
											</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
			            <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#audit_drp">
                                <span class="feather-icon"><i data-feather="layout"></i></span>
                                <span class="nav-link-text">Audit</span>
                            </a>
                            <ul id="audit_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('operation_audit'); ?>">Operation Audit</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('cs_audit'); ?>">CS Audit</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('view_audit'); ?>">View Audit</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_reason'); ?>">Add Reason</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('view_reason'); ?>">View Reason</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('call_record'); ?>">Call Record</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('personal_call_record'); ?>">Personal Call Record</a>
                                        </li>
                                        </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#pickup_drp">
                                <span class="feather-icon"><i data-feather="type"></i></span>
                                <span class="nav-link-text">Pickup Management</span>
                            </a>
                            <ul id="pickup_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('generate_pickup'); ?>">Generate Pickup</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('scan_new_pickup'); ?>">Scan New Pickup</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('bulk_pickup_update'); ?>">Bulk Pickup Update</a>
                                        </li>
										 <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('pickup_list'); ?>">Pickup List</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#inventory_drp">
                                <span class="feather-icon"><i data-feather="anchor"></i></span>
                                <span class="nav-link-text">Inventory Management</span>
                            </a>
                            <ul id="inventory_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('create_location'); ?>">Create Shelve Location</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('manage_location'); ?>">manage Shelve Location (warehouse)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('print_barcode'); ?>">Print4*6 Shelve Barcode</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_shelve'); ?>">Add Shelve</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_shelve'); ?>">Show Shelve</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('inventory'); ?>">Inventory</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#manifest_drp">
                                <span class="feather-icon"><i data-feather="server"></i></span>
                                <span class="nav-link-text">Manifest Management</span>
                            </a>
                            <ul id="manifest_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_manifest'); ?>">Add Multi Pieces Manifest</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_manifest'); ?>">Show Manifest</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('return_manifest'); ?>">Return Manifest</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('bulk_manifest'); ?>">Bulk Manifest</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('date_update1'); ?>">Verify Date Update</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('line_haul'); ?>">Line Haul</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#delivery_drp">
                                <span class="feather-icon"><i data-feather="file-minus"></i></span>    
                                <span class="nav-link-text">Delivery Run Sheet ddddd</span>
                            </a>
                            <ul id="delivery_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_drs'); ?>">Add DRS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('new_drs'); ?>">Scan New DRS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_drs'); ?>">Show DRS</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#warehouse_drp">
                                <span class="feather-icon"><i data-feather="pie-chart"></i></span>
                                <span class="nav-link-text">Warehouse management</span>
                            </a>
                            <ul id="warehouse_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('scan_shipment'); ?>">Scan Shipment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('hold_shipment'); ?>">Scan on Hold Shipment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('schedule_shipment'); ?>">Scan Schedule Shipment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('bound_shipment'); ?>">Scan in Bound Shipment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('inventory_report'); ?>">Show Inventory Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('security_check'); ?>">Security Check</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#routs_drp">
                                <span class="feather-icon"><i data-feather="map"></i></span>
                                <span class="nav-link-text">Routs management</span>
                            </a>
                            <ul id="routs_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_route'); ?>">Add Route</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_route'); ?>">Show Route</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#user_menu_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">User management</span>
                            </a>
                            <ul id="user_menu_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_user'); ?>">Show User</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#staff_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Staff Management</span>
                            </a>
                            <ul id="staff_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_staff'); ?>">Add Staff</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_staff'); ?>">Show Staff</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#customer_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Customer Management</span>
                            </a>
                            <ul id="customer_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_customer'); ?>">Add Customer</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_customer'); ?>">Show Customer</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('import_rates'); ?>">Import Rates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('account_verification'); ?>">Account Verification</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#courier_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Couriers Management</span>
                            </a>
                            <ul id="courier_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_couriers'); ?>">Add Couriers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_couriers'); ?>">Show Couriers</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('odometer_details'); ?>">Odometer Details</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#branch_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Branch Management</span>
                            </a>
                            <ul id="branch_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_branch'); ?>">Add New Branch</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_branch'); ?>">Show Branch</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#reports_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Reports</span>
                            </a>
                            <ul id="reports_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('supplier_report'); ?>">Supplier Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('shipment_report'); ?>">Shipment Report</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('transaction_report'); ?>">Transaction Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('payment_report'); ?>">Payment Report</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('client_report'); ?>">Sales By Client Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('hold_report'); ?>">On Hold Report</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#rto_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">RTO Management</span>
                            </a>
                            <ul id="rto_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('rto_list'); ?>">RTO List</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('pending_list'); ?>">Pending RTO List</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#cod_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">COD Management</span>
                            </a>
                            <ul id="cod_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('confirm_shipment'); ?>">Confirm COD Shipment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('pending_shipment'); ?>">Pending COD Shipment</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#coupon_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Coupon Management</span>
                            </a>
                            <ul id="coupon_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('new_coupon'); ?>">Generate New Coupon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('valid_coupon'); ?>">Valid Coupon</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('expire_coupon'); ?>">Expire Coupon</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('ofd_report'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">OFD Report</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('payment_details'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Payments Details</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#inv_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Invoice Management</span>
                            </a>
                            <ul id="inv_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('invoice_management'); ?>">New Invoice Managment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('cod_report'); ?>">COD Report</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#pro_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Product Type</span>
                            </a>
                            <ul id="pro_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_product_type'); ?>">Add Product Type</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_product_type'); ?>">Show Product Type</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('content_services'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Content Services</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('cms_pages'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">CMS Pages</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('tickets'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Tickets</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('newfeedback'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">New Feedback</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('showrating'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Show Rating</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#news_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">News</span>
                            </a>
                            <ul id="news_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_news'); ?>">Add News</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_news'); ?>">Show News</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#notifi_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Notification</span>
                            </a>
                            <ul id="notifi_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_notification'); ?>">Add Notification</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_notification'); ?>">Show Notification</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#pick_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Pickup Location</span>
                            </a>
                            <ul id="pick_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_location'); ?>">Show Pickup Location</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#email_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Email Templates</span>
                            </a>
                            <ul id="email_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('email_setting'); ?>">Email Setting</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('featured_partners'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Featured Partners</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('seo'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">SEO</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('category_list'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Product Category List</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('user_privilege'); ?>" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Set User Privilege</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#banner_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Home Banner Management</span>
                            </a>
                            <ul id="banner_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_banner'); ?>">Show Banner</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_banner'); ?>">Add Banner</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#out_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Outsource Management</span>
                            </a>
                            <ul id="out_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_supplier'); ?>">Show Supplier</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('generate_voice'); ?>">Generate In Voice</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_supplier'); ?>">Add Supplier</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#ams_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">AMS(Address Management System)</span>
                            </a>
                            <ul id="ams_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_address'); ?>">Show Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('shipment_address'); ?>">Shipment Address</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('new_address'); ?>">Add New Address</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#schedule_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">Schedule Management</span>
                            </a>
                            <ul id="schedule_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('cs_schedule'); ?>">CS Schedule</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('blind_schedule'); ?>">Blind Schedule</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('bulk_reschedule'); ?>">Bulk Reschedule</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('schedule_remove'); ?>">Bulk Schedule Remove</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('date_update1'); ?>">Verify Date Update</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('pending_schedule'); ?>">Pending Schedule</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#faq_drop">
                                <span class="feather-icon"><i data-feather="users"></i></span>
                                <span class="nav-link-text">FAQ</span>
                            </a>
                            <ul id="faq_drop" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('add_faq'); ?>">Add FAQ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('show_faq'); ?>">Show FAQ</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						
				</ul>
                    <hr class="nav-separator">
                </div>
            </div>
        </nav>
        
		
		<div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
