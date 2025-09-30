<?php
// We reageren met een 404 als dit bestand rechtstreeks aangeroepen wordt.
// Als het rechtstreeks aangeroepen wordt, zal 'MySecr33t' nooit gedefinieerd zijn.
if (!defined('MySecr33t')) {
   header("HTTP/1.1 404 Not Found");
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL /wm/les1/php/db.php was not found on this server.</p>
</body></html>');
}
// Create connection strings
// pas deze gegevens aan op basis van de gegevens van je hosting (Combell in dit geval)
$servername = "ID477568_mohamedaminehs.db.webhosting.be";
$username = "ID477568_mohamedaminehs"; // username (zie Hosting)
$password = "Soumsoum147"; // paswoord DATABANK (zie hosting)
$dbname = "ID477568_mohamedaminehs"; // naam databank (zie hosting ; zelf gekozen)


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname) or die(mysqli_connect_error());

// die() served de parameter die je aan die() meegeeft,
// en zorgt dat de verdere verwerking van het php script stopt.
// je gebruikt dit wanneer er een probleem is in de code
// die verhindert dat de rest van de code correct uitgevoerd 
// kan worden. In dit geval geven we de mysqli foutcode mee wanneer 
// er geen connectie met de databank gemaakt kan worden.
// Werk je met Xampp, dan kan je dit testen door in je Xampp Control panel MySQL uit te schakelen
// en de pagina opnieuw te laden.
?>