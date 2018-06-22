<!DOCTYPE html>
<!-- 
Template Name: Mangalore City Corporation - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.0.0
Author: Rinu Madathil
Website: http://www.glowtouch.com/
Contact: rinu.mv@glowtouch.com 
Like: www.facebook.com/rinu6200 
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js">
    <![endif]-->
<!--[if IE 9]>
    <html lang="en" class="ie9 no-js">
        <![endif]-->
<!--[if !IE]>
<!-->
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8" />
        <title>Mangalore City Corporation</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />	
        <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/simple-line-icons/simple-line-icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/select2/select2-bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-wizard/custom.css" rel="stylesheet">

        <!-- END PAGE LEVEL PLUGIN STYLES -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/simple-line-icons/simple-line-icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/select2/select2-bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-wizard/custom.css" rel="stylesheet">

        <!-- END PAGE LEVEL PLUGIN STYLES -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
        <!-- END THEME STYLES -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/js/mcc.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/custom.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->

    <body class="page-header-fixed page-quick-sidebar-over-content">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="<?php echo base_url(); ?>home">
                        Mangalore City <span>Corporation</span>
                    </a>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-left-menu top-menu hidden-sm hidden-xs">
                    <ul class="nav navbar-nav pull-left">
                        <li class="sidebar-toggler-wrapper">
                            <a class="sidebar-toggler" href="#">
                                <i class="icon-logout"></i>
                            </a>
                        </li> 
                        <li>
                            <a href="#" class="go-full-screen">
                                <i class="icon-size-fullscreen"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown dropdown-user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="<?php echo base_url(); ?>/assets/img/avatar01.jpg" />
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="account_img"><img alt="" class="img-circle" src="<?php echo base_url(); ?>/assets/img/avatar01.jpg" /></div>
                                    <div class="account_right">
                                        <h3><?php echo $username; ?></h3>
                                    </div>
                                    <div class="account_footer">
                                        <a href="<?php echo base_url(); ?>changepassword" class="pull-left"> Change Password</a> <a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-power-off"></i> Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <div class="clearfix"></div>

        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse" id="cssmenu">			
                    <!-- BEGIN SIDEBAR PROFILE -->
                    <div class="page-sidebar-profile">
                        <div class="page-sidebar-img"><img alt="" class="img-circle" src="<?php echo base_url(); ?>/assets/img/avatar01.jpg" /></div>
                        <h3><?php echo $username; $is_super = $this->session->userdata('is_super_admin');?></h3>
                        <ul>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="active"><i class="fa fa-circle"></i></span> <?php echo $username; ?> <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>home/logout">Logout </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- END SIDEBAR PROFILE -->
                    <!-- BEGIN SIDEBAR MENU -->
                    <ul class="page-sidebar-menu">
					
                        <?php if ($role == 'Admin') { ?>
                            <li class="start">
                                <a href="<?php echo base_url(); ?>home">
                                    <i class="fa fa-home"></i>
                                    <span class="title">Dashboard</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($role == 'Admin') { ?>                            
                            <li>
                                <a href="javascript:;"><i class="fa fa-database"></i><span class="title">Property Owners General Info</span><span class="arrow "></span></a>
                                <ul class="sub-menu">
                                                                <li><a href="<?php echo base_url(); ?>sasdetails/generalInfo">Add Owner Information</a></li>
                                                                <li><a href="<?php echo base_url(); ?>sasdetails/editgeneralInfo">Edit Owner Information</a></li>							
                                </ul>
                            </li>

                            
                            <li><a href="javascript:;"><i class="fa fa-edit"></i><span class="title">Self Assessment Property Tax</span><span class="arrow "></span></a>                       
                                <ul class="sub-menu">                                    
                                    <li><a href="<?php echo base_url(); ?>sasdetails/buildingtaxcalInfo">Property/Building/Tax Calculation</a></li>

                                    <li><a href="<?php echo base_url(); ?>payment">Payment Details</a></li>
                                </ul>
                            </li>




                        <?php } ?>
                        <?php if ($role == 'Editor') { ?> 
                            <li><a href="javascript:;"><i class="fa fa-edit"></i><span class="title">Self Assessment Property Tax</span><span class="arrow "></span></a>                       
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url(); ?>payment">Payment Details</a></li>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($role == 'Admin') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>sas">
                                    <i class="fa fa-book"></i>
                                    <span class="title">VIEW SAS Details</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($is_super == '1') { ?>
                            <li >
                                <a href="javascript:;">
                                    <i class="fa fa-calculator"></i>
                                    <span class="title">Manage Masters</span>
                                    <span class="arrow "></span>
                                    <span class="selected"></span>
                                </a>

                                <ul class="sub-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>proptype">
                                            Property Type
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>swmcess">
                                            SWM Cess Masters
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>depreciation">
                                            Depreciation
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>enhance">
                                            Enhance %
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>cess">
                                            CESS%
                                        </a>
                                    </li>                                    
                                    <li>
                                        <a href="<?php echo base_url(); ?>ward">
                                            ward
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>guidance">
                                            Guidance Value
                                        </a>
                                    </li>
                                    <li>
                                <a href="<?php echo base_url();?>constratecity">
                                    Construction Rate (City)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>constraterural">
                                    Construction Rate(Rural)
                                </a>
                            </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($role == 'Viewer' || $is_super == '1' || $role == 'Admin') { ?>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-file-text-o"></i>
                                    <span class="title">Manage Reports</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ($role == 'Viewer' || $is_super == '1' || $role == 'Admin') { ?>
                                    <li>
                                        <a href="<?php echo base_url(); ?>demandreport">
                                            Demand Collection Report
                                        </a>
                                    </li> 
                                    <?php } ?>
                                    <?php if ($role == 'Viewer' || $is_super == '1') { ?>
                                    <li>
                                        <a href="<?php echo base_url(); ?>defaultreport">
                                            Defaulters List
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($is_super == '1') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>usermanage">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Manage Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>importdata">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Import Data</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>importdata/importGuidance">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Import Guidance</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>usermanage/userlogs">
                                    <i class="fa fa-bars"></i>
                                    <span class="title">User Log</span>
                                </a>
                            </li>
                            <?php } ?>
                             <?php if ($role == 'Viewer' || $is_super == '1' || $role == 'Admin') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>generatereport">
                                    <i class="fa fa-bars"></i>
                                    <span class="title">Generate Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>generatereport/countReport">
                                    <i class="fa fa-bars"></i>
                                    <span class="title">Generate Count Report</span>
                                </a>
                            </li>
                            <?php } ?>                        
                    </ul>

                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
			