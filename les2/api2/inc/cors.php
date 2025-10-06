<?php
// CORS = Cross-Origin Resource Sharing
// Dit bestand laat toe dat de webapp (die op een andere locatie staat)
// toch toegang krijgt tot jouw API.

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

?>
    