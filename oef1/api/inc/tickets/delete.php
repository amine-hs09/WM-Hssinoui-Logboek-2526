<?php
// --- "delete" een ticket
check_required_fields(["id"]);

if (!$stmt = $conn->prepare("DELETE FROM tickets WHERE id=?")) {
    die('{"error":"Prepared Statement failed on prepare","status":"fail"}');
}

if (!$stmt->bind_param("i", $postvars['id'])) {
    die('{"error":"Prepared Statement bind failed","status":"fail"}');
}

$stmt->execute();
$rows = $stmt->affected_rows;
$stmt->close();
$conn->close();

die('{"data":"ok","message":"Ticket deleted","status":200,"deleted":' . $rows . '}');
