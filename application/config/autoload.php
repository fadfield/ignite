<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = array();
$autoload['libraries'] = array('database','session','form_validation','table','user_agent','upload', 'pagination');
$autoload['helper'] = array('directory','file','form', 'text', 'url', 'date', 'security', 'form', 'web');
$autoload['drivers'] = array();
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('auth_user_model');
