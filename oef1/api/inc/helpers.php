<?php
function setCors() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json; charset=utf-8");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
}
function deliver($data=null, int $code=200) {
    http_response_code($code);
    echo json_encode([
        "code"   => $code === 200 ? 1 : 0,
        "status" => $code,
        "data"   => $data
    ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    exit;
}
function getJsonBody(): array {
    $raw = file_get_contents("php://input");
    if (!$raw) return [];
    $j = json_decode($raw, true);
    return is_array($j) ? $j : [];
}
function requireFields(array $src, array $fields) {
    foreach ($fields as $f) {
        if (!isset($src[$f]) || $src[$f]==="") {
            deliver(["error"=>"Missing field: $f","required"=>$fields], 400);
        }
    }
}
?>