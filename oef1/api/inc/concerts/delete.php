<?php
//  hier delet ik een concert bij het deleten van een concert wordt de id verwijdert 
check_required_fields(["id"]);
// als de volgende waarden niet aanwezig zijn krijk ik eror 
if (!$stmt = $conn->prepare("DELETE FROM concerts WHERE id=?")) {
  die('{"error":"Prepared Statement failed on prepare","errNo":' . json_encode($conn->errno) . ',"mysqlError":' . json_encode($conn->error) . ',"status":"fail"}');
}
//hier bind ik de par met string 
if (!$stmt->bind_param("i", $postvars['id'])) {
  die('{"error":"Prepared Statement bind failed on bind","errNo":' . json_encode($conn->errno) . ',"mysqlError":' . json_encode($conn->error) . ',"status":"fail"}');
}
//sluiten van statement met db 
$stmt->execute();
$rows = $conn->affected_rows;
$stmt->close();
// json format 
die('{"data":"ok","message":"Record deleted","status":200,"deleted":' . $rows . '}');
?>