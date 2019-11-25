<?php

include_once ROOT.DS.'etc'.DS.'config.php';
include_once ROOT.DS.'etc'.DS.'functions.php';

error_reporting(E_ALL);
ini_set('display_errors', App\Core\Config::get('debug') ? 1 : 0);
