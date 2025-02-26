<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Boat';

$route['admin'] = 'AuthController/login';
$route['do_login'] = 'AuthController/do_login';
$route['dashboard'] = 'DashboardController';
$route['logout'] = 'DashboardController/logout';

$route['add']='BoatController/boat_add';
$route['boat/store']='BoatController/store';
$route['list']='BoatController/boat_list';
$route['edit/(:any)']='BoatController/edit/$1';
$route['delete/(:any)']='BoatController/boat_delete/$1';
$route['update-status']='BoatController/update_status';
$route['update']='BoatController/update_boat';
/*Booking Backend */
$route['booking/list']='BookingController/booking_list';
$route['booking/delete']='BookingController/booking_delete';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
