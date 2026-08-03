<?php

echo getenv('APP_NAME') . "\n";

$debug = filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN);

if ($debug) {
    ini_set('display_errors', $debug);

    error_reporting(E_ALL);
} else {
    ini_set('display_errors', $debug);

    error_reporting(0);
}

echo $name;