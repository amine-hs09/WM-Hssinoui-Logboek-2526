<?php
// --- "update" een ticket (aantal aanpassen)
check_required_fields(["id", "qty"]);

if (!$stmt = $conn->prepare("UPDATE tickets SET qty=? WHERE id=?")) {
    die('{"error":"Prepared Statement failed on prepare","status":"fail"}');
}

if (!$stmt->bind_param("ii", $postvars['qty'], $postvars['id'])) {
    die('{"error":"Prepared Statement bind failed","status":"fail"}');
}

$stmt->execute();
$rows = $stmt->affected_rows;
$stmt->close();
$conn->close();

die('{"data":"ok","message":"Ticket updated","status":200,"updated":' . $rows . '}');
