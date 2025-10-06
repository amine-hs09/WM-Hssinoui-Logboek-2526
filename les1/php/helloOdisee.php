<?php
/* 
    PHP scripts starten met <?php en eindigen met ?>

*/


// Iedere lijn met een commando moet je eindigen met een ; (zoals in Javascript in strict mode)

// variabelen beginnen met een $ 
$variabele = "<h1>Hallo Odisee!</h1>";

// met echo kan je output naar een webpagina sturen :
echo "1 :<h1>Hallo Odisee!</h1>";
// je kan variabelen rechtstreeks ingeven in een string, als deze double quotes heeft :
echo "2 :$variabele";
// je kan 2 strings concateneren met . 
// De operator + wordt voorzien om getallen op te tellen, niet op tekst te concateneren
echo "3 :".$variabele;
echo "4 :";
echo $variabele;
echo "test :".(22/7);
// wat gebeurt er als met single-quotes werkt en een variabele ggebruikt?
echo '<br>5:$variabele';

// een php blok sluit je met ? gevolgd door >
?>
<!-- Dit is html commentaar. Vind je deze terug in de dev-tools?  -->
<p>Hier kan je gewoon je html code opbouwen zoals je gewoon bent.</p>
<p>Je kan er wel php stukjes tussen zetten als je daar zin in hebt:</p>
<?php echo $variabele ?>


<p>Let op : hoewel keywoorden zoals if, else, while of echo niet hoofdlettergevoelig zijn, zijn variabelen en functies die jij aanmaakt wel degelijk hoofdlettergevoelig.</p>
<?php
// Vind je deze PHP-commentaar terug in de dev-tools? 

// Er zijn verschillende super global variabelen zoals $_GET en $_POST
$test = $_GET["test"];
if($test){
    echo "test = $test";
}
$kleur = $_GET["kleur"];
if(!$kleur){
    $kleur = "green";
}
?>
<p style="color:<?php echo $kleur;?>">Mijn lievelingskleur is <?php echo $kleur;?></p>
<p style="color:<?php echo $KLEUR;?>">Mijn lievelingskleur is <?php echo $KLEUR;?></p>
<p style="color:<?php echo $Kleur;?>">Mijn lievelingskleur is <?php echo $Kleur;?></p>

<?php

// variabelen buiten functies gedeclareerd zijn beschikbaar in global scope
// variabelen binnen functies gedeclareerd zijn beschikbaar binnen die specifieke functie
// globale variabelen zijn enkel bruikbaar binnen een functie als je er eerst het keyword global voor plaatst

// globale variabelen
$operator1 = 20;
$operator2 = 100;

function telOp(){
    // maak deze 2 operatoren bruikbaar binnen deze functie
    global $operator1, $operator2;

    return $operator1 + $operator2 ;
}

function hangSamen(){
    // Deze functie maakt deze globale variabelen niet beschikbaar.
    // Merk op dat je editor mogelijk al via intellisense meldt dat deze variabelen onbekend zijn.
    return  $operator1 . $operator2 ;
}

echo "<p>Opgeteld : ".telOp()."</p>";
echo "<p>Samengezet : ".hangSamen()."</p>";



?>