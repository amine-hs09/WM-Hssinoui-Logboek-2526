<?php
// --- "Get" alle producten  

$sql="select PR_ID, PR_CT_ID, PR_naam, PR_prijs, CT_OM FROM producten JOIN categorieen ON PR_CT_ID = CT_ID";

// geen prepared statement nodig, aangezien we geen parameters
// van de gebruiker verwerken.

$result = $conn -> query($sql);

if (!$result) {
	$response['code'] = 7;
	$response['status'] = $api_response_code[$response['code']]['HTTP Response'];
	$response['data'] = $conn->error;
	deliver_response($response);
}

// Vorm de resultset om naar een structuur die we makkelijk kunnen 
// doorgeven en stop deze in $response['data']
$response['data'] = getJsonObjFromResult($result); // -> fetch_all(MYSQLI_ASSOC)
// maak geheugen vrij op de server door de resultset te verwijderen
$result->free();
// sluit de connectie met de databank
$conn->close();
// Return Response to browser
deliver_JSONresponse($response);
//deliver_response($response);

exit;
?>