<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibi</title>
    <style>
        body { font-family:monospace; }
        p { font-size:xx-small; margin:0; }
        h1{ float:right; text-align:right; }
    </style>
</head>
<body>
<h1>Fibi</h1>
<?php
// 
function randomKleur(){
    // maak dit random
    $rood = 128;
    $groen = 128;
    $blauw = 128;
    
    return "rgb($rood,$groen,$blauw)";
}

function randomKleurArray() {
    // maak dit random
    return array(128,128,128);
}
function getKleurVariant() {
    // signatuur en functie volledig naar keuze ;-)
}


function tekenReeks(&$getallen){
    // merk op dat $getallen hier binnen komt als &$getallen
    // dit is een parameter die by reference wordt doorgegeven,
    // waardoor de static array $getallen in berekenFib() niet 
    // gedupliceerd wordt.
    
    $line = "<p>";

    $max = count($getallen);

    for($i=1; $i < $max; $i++){
        $line .= "<span>".$getallen[$i] . "</span> ";
    }

    $line .= "</p>";
    echo $line;
}

function berekenFib($to){
    // staticarray om de getallen bij te houden
    static $getallen = array();
    $getal = 1;
    if(count($getallen) < $to ) {
        // shortcut : indien minder dan 2 getallen, moet de waarde 1 zijn.
        if(count($getallen) > 2) {
            // tel de 2 laatste getallen in de reeks op
            $getal = $getallen[count($getallen) -1] + $getallen[count($getallen) -2];
        } 
        // voeg nieuw getal toe aan de reeks getallen
        array_push($getallen, $getal);
        // voeg de reeks getallen toe aan de pagina
        tekenReeks($getallen);
        // bereken op nieuw een volgend getal
        berekenFib($to);
    }
}

// bereken dit tot een reeks van 40 getallen
berekenFib(40);
?>

<h2>Geen idee wat te doen qua opmaak? Kijk eens naar de <a href="https://stevenop.be/wm/les1/php/fibi-opl.php">mogelijke oplossing</a></p>
</body>
</html>