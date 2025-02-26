<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard </title>
    <link href="<?php echo base_url();?>assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/master.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/jquery.timepicker.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
</head>

<body>
    <div class="wrapper">
    <!-- class="active" -->
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <!-- <img src="<?php echo base_url();?>assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">          -->
                <h4 style="color:black">Admin Panel</h4>
            </div>
            <ul class="list-unstyled components text-secondary">
               
                <li>
                    <a href="<?php echo base_url('add'); ?>"><i class="fas fa-file-alt"></i> Boat</a>
                </li>
               
                <li>
                    <a href="<?php echo base_url('booking/list'); ?>"><i class="fas fa-chart-bar"></i> Booking</a>
                </li>
               
            </ul>
        </nav>
        <!-- class="active" -->
        <div id="body" class="">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                     
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span><?php echo $this->session->userdata('name'); ?></span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <!-- <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div> -->
                                        <li><a href="<?php echo base_url('logout'); ?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->