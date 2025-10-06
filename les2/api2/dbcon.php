<?php
// CORS = Cross-Origin Resource Sharing
// Dit bestand laat toe dat de webapp (die op een andere locatie staat)
// toch toegang krijgt tot jouw API.

// Headers voor alle responses
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Als het een preflight OPTIONS request is, stoppen we hier
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
?>
