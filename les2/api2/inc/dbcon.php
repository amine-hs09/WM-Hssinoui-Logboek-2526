<?php
if (!defined('INDEX')) {
   header("HTTP/1.1 404 Not Found");
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL /wm/api2/inc/dbcon.php was not found on this server.</p>
</body></html>');
}
// Create connection strings
$servername = "ID477568_mohamedaminehs.db.webhosting.be";
$username = "ID477568_mohamedaminehs"; // username (zie Hosting)
$password = "Soumsoum147"; // paswoord DATABANK (zie hosting)
$dbname = "ID477568_mohamedaminehs"; // naam databank (zie hosting ; zelf gekozen)

$conn = mysqli_connect($servername, $username, $password, $dbname) or die(mysqli_connect_error());
mysqli_set_charset($conn, 'utf8mb4'); // mysqli extension
// de 2e parameter is de collation voor de connectie : op welke 

?>