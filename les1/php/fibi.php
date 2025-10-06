<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibi – Fibonacci reeks</title>
    <style>
        body { font-family: monospace; background-color: #fafafa; }
        p { font-size: small; margin: 0; }
        h1 { float: right; text-align: right; color: darkblue; }
        span { display: inline-block; min-width: 30px; text-align: right; }
    </style>
</head>
<body>
<h1>Fibi</h1>

<?php
/*
=====================================================
  LES 1 – OEFENING FIBONACCI
  --------------------------
  But / Doel :
  - Leren werken met functies, arrays, loops, en static variabelen.
  - Resultaat: toon 40 Fibonacci-getallen, elk in een aparte kleur.
=====================================================
*/

// --------------------------------------------------
// 1️⃣ randomKleur() : geeft een willekeurige CSS kleur terug
// --------------------------------------------------
function randomKleur() {
    // Genereer drie willekeurige getallen tussen 0 en 255
    $rood = rand(0, 255);
    $groen = rand(0, 255);
    $blauw = rand(0, 255);

    // Maak een CSS kleurstring terug, bv. rgb(120,50,200)
    return "rgb($rood,$groen,$blauw)";
}

// --------------------------------------------------
// 2️⃣ randomKleurArray() : retourneert de kleur als array [r,g,b]
// --------------------------------------------------
function randomKleurArray() {
    // retourneer een array van 3 willekeurige waarden
    return array(rand(0,255), rand(0,255), rand(0,255));
}

// --------------------------------------------------
// 3️⃣ getKleurVariant() : maakt de kleur iets lichter of donkerder
// --------------------------------------------------
function getKleurVariant($kleurArray, $index, $totaal) {
    // On fait varier la luminosité selon la position
    // Plus l’index est élevé, plus la couleur devient claire
    $factor = ($index / $totaal) * 100; // valeur de 0 à 100
    $r = min(255, $kleurArray[0] + $factor);
    $g = min(255, $kleurArray[1] + $factor);
    $b = min(255, $kleurArray[2] + $factor);
    return "rgb($r,$g,$b)";
}

// --------------------------------------------------
// 4️⃣ tekenReeks() : toont la suite actuelle
// --------------------------------------------------
function tekenReeks(&$getallen) {
    // maak een willekeurige basiskleur
    $basisKleur = randomKleurArray();
    $max = count($getallen);
    
    echo "<p>";
    // loop door alle getallen en toon ze met kleurvariant
    for($i = 0; $i < $max; $i++) {
        $kleur = getKleurVariant($basisKleur, $i, $max);
        echo "<span style='color:$kleur'>{$getallen[$i]}</span> ";
    }
    echo "</p>";
}

// --------------------------------------------------
// 5️⃣ berekenFib() : berekent Fibonacci tot een limiet
// --------------------------------------------------
function berekenFib($to) {
    // Static array = onthoudt zijn waarden tussen functie-aanroepen
    static $getallen = array();

    // Als minder dan 2 getallen in de reeks → voeg 1 toe
    if (count($getallen) < 2) {
        $getallen[] = 1;
    }

    // Controleer of we nog niet aan de limiet zijn
    if (count($getallen) < $to) {
        // Bereken volgende getal : som van de laatste 2
        $laatste = $getallen[count($getallen) - 1];
        $voorlaatste = $getallen[count($getallen) - 2];
        $nieuw = $laatste + $voorlaatste;

        // Voeg toe aan de reeks
        $getallen[] = $nieuw;

        // Toon de huidige reeks
        tekenReeks($getallen);

        // Herhaal tot het einde
        berekenFib($to);
    }
}

// --------------------------------------------------
// 6️⃣ Uitvoering
// --------------------------------------------------
berekenFib(20); // Bereken 20 Fibonacci-getallen
?>

<h2>
    Geen idee wat te doen qua opmaak? <br>
    Kijk eens naar de 
    <a href="https://stevenop.be/wm/les1/php/fibi-opl.php">mogelijke oplossing van de docent</a>.
</h2>

</body>
</html>
