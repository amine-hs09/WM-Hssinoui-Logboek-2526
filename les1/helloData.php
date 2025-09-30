<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallo, data!</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Hallo, data!</h1>       
    
<?php
// we zetten hier een 'secret' waarnaar we kijken in het bestand db.php
define ('MySecr33t', true);

// Om niet in elk script dat een verbinding legt met de databank opnieuw
// de connectie gegevens in te geven en een connectie naar de databank te schrijven,
// doen we dat 1 keer in een php bestand en importeren we dat bij de start van
// een script.
require 'inc/db.php';
// Dit maakt de variabele $conn beschikbaar


// Hier geen prepared statement noodzakelijk, aangezien we geen 
// parameters van de gebruiker verwerken in de query.

// Een query in een string
$sql = "SELECT * FROM testtabel";
// Die we hier uitvoeren. Merk op dat we de variabele $sql niet nodig hadden
// en hier rechtstreeks de string met de query konden opgeven
$result = $conn -> query($sql);

if (!$result) {
    // Er is geen $result,
    // stop met een foutboodschap
    die("
    <span class='rij'>Geen resultaten, query is niet gelukt : $conn->error</span>
    </body>
    </html>");
}

echo "<span class='rij kop'><span class='kolom1'>ID</span><span class='kolom2'>Omschrijving</span><span class='kolom3'>#</span></span>";

while ($row = $result -> fetch_assoc()) {
    // loop door alle resultaatrijen en haal de waarden er uit
    echo "<span class='rij'><span class='kolom1'>". $row["id"] ."</span><span class='kolom2'>".$row["omschrijving"]."</span><span class='kolom3'>".$row["aantal"]."</span></span>";
}
// maak geheugen vrij
mysqli_free_result($result);

// sluit de connectie met de databank
$conn->close();
?>

</body>
</html>