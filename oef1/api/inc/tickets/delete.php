<?php
// "delete" een ticket
check_required_fields(["id"]);
//als ik ticket verwijder moet ik de id aanpassen
if (!$stmt = $conn->prepare("DELETE FROM tickets WHERE id=?")) {
    die('{"error":"Prepared Statement failed on prepare","status":"fail"}');
}
// indien ik ticket verwijder moet ik de id aanpassen
if (!$stmt->bind_param("i", $postvars['id'])) {
    die('{"error":"Prepared Statement bind failed","status":"fail"}');
}
// execute de statement
$stmt->execute();
$rows = $stmt->affected_rows;
$stmt->close();
$conn->close();
// sluit verbinding
die('{"data":"ok","message":"Ticket deleted","status":200,"deleted":' . $rows . '}');
?>