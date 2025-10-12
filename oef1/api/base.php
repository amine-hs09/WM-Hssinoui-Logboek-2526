<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* base.php – helpers JSON + CORS + utilitaires (style prof) */
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Preflight (aucun body attendu)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

/* Réponse standardisée */
function deliver_response($code, $status, $data)
{
  http_response_code($status);
  echo json_encode([
    "code" => (int) $code,
    "status" => (int) $status,
    "data" => $data
  ], JSON_UNESCAPED_UNICODE);
  exit;
}

function ok($data, $status = 200)
{
  deliver_response(1, $status, $data);
}
function fail($message, $status = 400)
{
  deliver_response(0, $status, $message);
}

/* JSON input → array (si pas de body → []) */
function get_json_body()
{
  $raw = file_get_contents("php://input");
  if ($raw === false || $raw === "")
    return [];
  $arr = json_decode($raw, true);
  if (json_last_error() !== JSON_ERROR_NONE)
    fail("Invalid JSON body", 400);
  return $arr;
}

/* Vérifie présence de champs obligatoires */
function require_fields($arr, $fields)
{
  foreach ($fields as $f) {
    if (!isset($arr[$f]) || $arr[$f] === "")
      fail("Missing field: " . $f, 422);
  }
}

/* Convertit un mysqli_result en array associatif */
function rows(mysqli_result $res)
{
  $out = [];
  while ($r = $res->fetch_assoc()) {
    $out[] = $r;
  }
  return $out;
}

// --- Compatibilité avec l'ancien style du prof ---
$GLOBALS['postvars'] = (function () {
  $raw = file_get_contents('php://input');
  if ($raw === false || $raw === "")
    return [];
  $arr = json_decode($raw, true);
  return is_array($arr) ? $arr : [];
})();

$GLOBALS['missing_fields'] = [];
function check_required_field($value, $key)
{
  if (!array_key_exists($value, $GLOBALS['postvars'])) {
    $GLOBALS['missing_fields'][] = $value;
  }
}
function check_required_fields($required_fields)
{
  if (!isset($GLOBALS['postvars']) || !is_array($GLOBALS['postvars'])) {
    die('{"status":400,"ok":false,"message":"Fields missing in request. Send parameters as JSON in the body."}');
  }
  array_walk($required_fields, "check_required_field");
  if (count($GLOBALS['missing_fields']) > 0) {
    die('{"status":400,"ok":false,"message":"Fields missing in request","missing_fields":' . json_encode($GLOBALS['missing_fields']) . '}');
  }
}
// --- Compatibilité avec deliver_JSONresponse1 (ancien style du prof) ---
if (!function_exists('deliver_JSONresponse1')) {
  function deliver_JSONresponse1($response)
  {
    // $response attendu : ['code'=>..., 'status'=>..., 'data'=>...]
    $code = isset($response['code']) ? (int) $response['code'] : 1;
    $status = isset($response['status']) ? (int) $response['status'] : 200;
    $data = $response['data'] ?? null;

    http_response_code($status);
    echo json_encode([
      "code" => $code,
      "status" => $status,
      "data" => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
  }
}
?>