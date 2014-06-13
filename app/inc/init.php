<?php
use raveren\klint;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// We always work with UTF8 encoding
mb_internal_encoding('UTF-8');

// Make sure we have a timezone set
date_default_timezone_set('Europe/Paris');

// We store the application and TMX paths in an ini file shared with Python
$server_config = parse_ini_file(__DIR__ . '/../config/config.ini');

// Load all constants for the application
require_once __DIR__ . '/constants.php';

// Autoloading of classes (both /vendor and /classes)
require_once INSTALL_ROOT . 'vendor/autoload.php';

// Load all global variables for the application
require_once __DIR__ . '/variables.php';

// For debugging
if (DEBUG) {
    error_reporting(E_ALL);
    kint::enabled(true);
} else {
    kint::enabled(false);
}

// Logging
$logger = new Logger(VERSION);
$logger->pushHandler(new StreamHandler(__DIR__ . '/transvision.log', Logger::DEBUG));

// Dispatch urls, use it only in web context
if (php_sapi_name() != 'cli') {
    require_once INC . 'dispatcher.php';
}