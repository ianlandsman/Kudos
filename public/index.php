<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @version  2.0.7
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 * @link     http://laravel.com
 */

// --------------------------------------------------------------
// Tick... Tock... Tick... Tock...
// --------------------------------------------------------------
define('LARAVEL_START', microtime(true));

// --------------------------------------------------------------
// The path to the application directory.
// --------------------------------------------------------------
define('APP_PATH', realpath('../application').'/');

// --------------------------------------------------------------
// The path to the bundles directory.
// --------------------------------------------------------------
define('BUNDLE_PATH', realpath('../bundles').'/');

// --------------------------------------------------------------
// The path to the storage directory.
// --------------------------------------------------------------
define('STORAGE_PATH', realpath('../storage').'/');

// --------------------------------------------------------------
// The path to the Laravel directory.
// --------------------------------------------------------------
define('SYS_PATH', realpath('../laravel').'/');

// --------------------------------------------------------------
// The path to the public directory.
// --------------------------------------------------------------
define('PUBLIC_PATH', realpath(__DIR__).'/');

// --------------------------------------------------------------
// Launch Laravel.
// --------------------------------------------------------------
require SYS_PATH.'/laravel.php';