<?php

ob_start();

http_response_code(201);

$method = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
$uri = $_SERVER['REQUEST_URI'] ?? ($_SERVER['SCRIPT_NAME'] ?? '');
$qs = $_SERVER['QUERY_STRING'] ?? '';
$proto = $_SERVER['SERVER_PROTOCOL'] ?? '';
if ($qs !== '') { $uri .= '?' . $qs; }
echo $method . ' ' . $uri . ' ' . $proto . "\n";


if (function_exists('getallheaders')) {
    foreach (getallheaders() as $name => $value) {
        echo $name . ': ' . $value . "\n";
    }
} else {
    foreach ($_SERVER as $k => $v) {
        if (strpos($k, 'HTTP_') === 0) {
            $name = ucwords(strtolower(str_replace('_', '-', substr($k, 5))), '-');
            echo $name . ': ' . $v . "\n";
        }
    }
}


header('X-TD8: NancyIUT');