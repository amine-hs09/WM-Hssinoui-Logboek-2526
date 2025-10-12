<?php
// hier pas ik de tickketen aan 
check_required_fields(["id", "qty"]);
//indien ik ticket verander moet ik de aantal aanpassen
if (!$stmt = $conn->prepare("UPDATE tickets SET qty=? WHERE id=?")) {
    die('{"error":"Prepared Statement failed on prepare","status":"fail"}');
}
//indien ik ticket verander moet ik de aantal aanpassen
if (!$stmt->bind_param("ii", $postvars['qty'], $postvars['id'])) {
    die('{"error":"Prepared Statement bind failed","status":"fail"}');
}

$stmt->execute();
$rows = $stmt->affected_rows;
$stmt->close();
$conn->close();
// sluit verbinding
die('{"data":"ok","message":"Ticket updated","status":200,"updated":' . $rows . '}');
?>