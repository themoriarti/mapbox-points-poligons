<?php
/**
 * Index of app.
 * Moriarti Engine 3.
 * Start at 2016-12-25 00:12:05 GMT+2.
 * @auhor Moriarti <mor.moriarti@gmail.com>
 * @
 */
error_reporting(E_ALL);
// Charsets.
header("Content-type: text/html; charset=utf8");

// Load global config.
require_once("../config/main.php");

// Autoload new classes.
require_once("../classes/Autoload.php");

// Init registry.
$registry = new Registry;
//$registry->set('BASEDIR',BASEDIR);

// Start ErrorSupervisor.
$errorSuper = new ErrorSupervisor($registry);
$registry->set('errorSuper',$errorSuper);

// Input data.
$Input = new Input;
$registry->set('Input',$Input);

// Run router.
$router = new Router($registry);
