<?php
// kopen van een ticket 
check_required_fields(["visitor_id", "concert_id", "qty"]);

if (!$stmt = $conn->prepare("INSERT INTO tickets (visitor_id, concert_id, qty) VALUES (?,?,?)")) {
    die('{"error":"Prepared Statement failed on prepare","errNo":' . json_encode($conn->errno) . ',"mysqlError":' . json_encode($conn->error) . ',"status":"fail"}');
}

if (!$stmt->bind_param("iii", $postvars['visitor_id'], $postvars['concert_id'], $postvars['qty'])) {
    die('{"error":"Prepared Statement bind failed on bind","errNo":' . json_encode($conn->errno) . ',"mysqlError":' . json_encode($conn->error) . ',"status":"fail"}');
}

$stmt->execute();

if ($conn->affected_rows == 0) {
    $stmt->close();
    die('{"error":"Prepared Statement failed on execute : no rows affected","status":"fail"}');
}
//een ticket gekocht
$id = $conn->insert_id;
// sluit verbinding
$stmt->close();
// sluit verbinding op deze manier
die('{"data":"ok","message":"Ticket purchased successfully","status":200,"id":' . $id . '}');
?>