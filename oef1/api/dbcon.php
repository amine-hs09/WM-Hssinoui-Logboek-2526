<?php
require_once __DIR__."/base.php";

/** Combell MySQL */
$host = "ID477568_Restfulapi.db.webhosting.be";
$user = "ID477568_Restfulapi";
$pass = "Soumsoum147";      
$db   = "ID477568_Restfulapi";

$conn = @new mysqli($host,$user,$pass,$db);
if ($conn->connect_error) {
  deliver_response(0, 500, "DB connection failed: ".$conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>