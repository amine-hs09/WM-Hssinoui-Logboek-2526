<?php
// --- "delete" een product  

// Zijn de nodige parameters meegegeven in de request?
check_required_fields(["PR_ID"]);

if(!$stmt = $conn->prepare("delete from producten where PR_ID = ?")){ // " and PR_ID > 231" -> opzettelijke beperking in de versie op stevenop.be
	die('{"error":"Prepared Statement failed on prepare","errNo":' . json_encode($conn -> errno) .',"mysqlError":' . json_encode($conn -> error) .',"status":"fail"}');
}

// bind parameters ( s = string | i = integer | d = double | b = blob )
if(!$stmt -> bind_param("i", $postvars['PR_ID'])){
	die('{"error":"Prepared Statement bind failed on bind","errNo":' . json_encode($conn -> errno) .',"mysqlError":' . json_encode($conn -> error) .',"status":"fail"}');
}
$stmt -> execute();

if($conn->affected_rows == 0) {
	// add failed
	$stmt -> close();
	die('{"error":"Prepared Statement failed on execute : no rows affected","errNo":' . json_encode($conn -> errno) .',"mysqlError":' . json_encode($conn -> error) .',"status":"fail"}');
}
// added
$stmt -> close();
die('{"data":"ok","message":"Record deleted successfully","status":200}');
?>