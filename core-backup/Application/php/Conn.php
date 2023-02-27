<?php

@session_start();
@ob_start();
ini_set('display_errors', 1);
ini_set('log_errors', 0);
set_time_limit(0);

ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
date_default_timezone_set('Asia/Calcutta');
error_reporting(E_ALL & ~ E_NOTICE & ~E_WARNING);

$aModules = array(
    "property_regular_update" => true
);

if (!function_exists('debug')) {

    function debug($arg, $is_die = 0) {
        echo '<pre>';
        if (is_array($arg) || is_object($arg)) {
            print_r($arg);
        } else {
            echo $arg;
        }
        echo '</pre>';
        if ($is_die == '1') {
            exit;
        }
    }

}

function is_localhost() {
    return $_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
}

if (is_localhost()) {
    /* ===================( Local Host )================================== */
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASSWORD', '');
    define('DATABASE', 'product_rems_core');
    define('DBTYPE', 'mysqli');
    define('APPROOT', 'http://localhost/spsoni/product_real_estate_marketing/');
    define('APPTYPE', 'LOCAL');
} else {
    /* ===================( Online Application )================================== */
    define('HOST', 'localhost');
    define('USER', 'spitechw_rems_core');
    define('PASSWORD', 'i&Agq,4ph&w$');
    define('DATABASE', 'spitechw_rems_core');
    define('DBTYPE', 'mysqli');
    define('APPROOT', 'http://rems-core.spitechws.in/');
    define('APPTYPE', 'ONLINE');
}
?>