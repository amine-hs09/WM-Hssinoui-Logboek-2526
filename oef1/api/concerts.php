<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

define('INDEX', true);

require_once __DIR__ . '/base.php';
require_once __DIR__ . '/dbcon.php';

// CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Router
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require __DIR__ . '/inc/concerts/get.php';
        break;
    case 'POST':
        require __DIR__ . '/inc/concerts/add.php';
        break;
    case 'PUT':
        require __DIR__ . '/inc/concerts/update.php';
        break;
    case 'DELETE':
        require __DIR__ . '/inc/concerts/delete.php';
        break;
    default:
        echo json_encode(["error" => "Method not allowed"]);
        http_response_code(405);
        break;
}
?>