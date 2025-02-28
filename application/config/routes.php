<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'BookingControllerFront';

$route['admin'] = 'AuthController/login';
$route['do_login'] = 'AuthController/do_login';
$route['dashboard'] = 'DashboardController';
$route['logout'] = 'DashboardController/logout';

$route['add']='BoatController/boat_add';
$route['store']='BoatController/store';
$route['list']='BoatController/boat_list';
$route['edit/(:any)']='BoatController/edit/$1';
$route['delete/(:any)']='BoatController/boat_delete/$1';
$route['update-status']='BoatController/update_status';
$route['update']='BoatController/update_boat';
/*Booking Backend */
$route['booking/list']='BookingController/booking_list';
$route['booking/delete']='BookingController/booking_delete';
/*Booking for Frontend */
$route['check-availability-type-time-acc-to-date']='BookingControllerFront/check_availability_type_time_acc_to_date';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
