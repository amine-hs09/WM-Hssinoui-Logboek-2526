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
    // Deze functie geeft een willekeurige css kleur terug    
}

function randomKleurArray() {
    // Deze functie geeft een array terug met 3 getallen tussen 0 en 255
}
function getKleurVariant() {
    // Deze functie geeft een donkerdere of lichtere variant terug van een
    // kleur die je meegeeft (tip: je moet getallen hebben, dus een array met getallen werkt ;-) )
    // Je zal vermoedelijk nog 2 andere parameters nodig hebben : het hoeveelste item in de lijn is dit, en hoeveel items heb je in deze lijn?

    // signatuur en functie volledig naar keuze ;-)
}


function tekenReeks(&$getallen){
    // merk op dat $getallen hier binnen komt als &$getallen
    // dit is een parameter die by reference wordt doorgegeven,
    // waardoor de static array $getallen in berekenFib() niet 
    // gedupliceerd wordt.

    // Deze functie neemt de waarden uit een array en echo't deze naar de html pagina.
    
    $line = "<p>";
    // loop door $getallen en voeg ze toe

    // Einde loop

    // Sluit p af
    $line .= "</p>";

    // naar de client
    echo $line;
}

function berekenFib($to){
    // static array om de reeks getallen bij te houden
    // Zie https://www.w3schools.com/php/php_variables_scope.asp voor meer info ivm static scoped variables
    static $getallen = array();

    // https://nl.wikipedia.org/wiki/Rij_van_Fibonacci

    
    
}

// bereken dit tot een reeks van 40 getallen
berekenFib(40);
?>

<h2>Geen idee wat te doen qua opmaak? Kijk eens naar de <a href="https://stevenop.be/wm/les1/php/fibi-opl.php">mogelijke oplossing</a></p>
</body>
</html>