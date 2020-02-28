<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['backend'] = 'backend/dashboard';
$route['backend/login'] = 'backend/user/login';
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
