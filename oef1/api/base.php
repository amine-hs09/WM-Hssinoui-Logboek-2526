<?php
/* base.php – helpers JSON + CORS + utilitaires (style prof) */
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Preflight (aucun body attendu)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

/* Réponse standardisée */
function deliver_response($code, $status, $data){
  http_response_code($status);
  echo json_encode([
    "code"   => (int)$code,
    "status" => (int)$status,
    "data"   => $data
  ], JSON_UNESCAPED_UNICODE);
  exit;
}

function ok($data, $status=200){ deliver_response(1, $status, $data); }
function fail($message, $status=400){ deliver_response(0, $status, $message); }

/* JSON input → array (si pas de body → []) */
function get_json_body(){
  $raw = file_get_contents("php://input");
  if ($raw === false || $raw === "") return [];
  $arr = json_decode($raw, true);
  if (json_last_error() !== JSON_ERROR_NONE) fail("Invalid JSON body", 400);
  return $arr;
}

/* Vérifie présence de champs obligatoires */
function require_fields($arr, $fields){
  foreach($fields as $f){
    if(!isset($arr[$f]) || $arr[$f] === "") fail("Missing field: ".$f, 422);
  }
}

/* Convertit un mysqli_result en array associatif */
function rows(mysqli_result $res){
  $out = [];
  while($r = $res->fetch_assoc()){ $out[] = $r; }
  return $out;
}
