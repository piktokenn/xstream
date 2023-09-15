<?php 
require_once PATH."/core/Autoloader.php";

// instantiate the loader
$loader = new Autoloader;

// register the autoloader
$loader->register();

// register the base directories for auto loading
$loader->addBaseDir(PATH.'/vendor');
$loader->addBaseDir(PATH.'/core');
$loader->addBaseDir(PATH.'/controller');
$loader->addBaseDir(PATH.'/model');


require_once PATH."/vendor/autoload.php";