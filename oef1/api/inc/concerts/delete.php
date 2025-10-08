<?php
// --- "delete" een concert
check_required_fields(["id"]);

if (!$stmt = $conn->prepare("DELETE FROM concerts WHERE id=?")) {
  die('{"error":"Prepared Statement failed on prepare","errNo":' . json_encode($conn->errno) . ',"mysqlError":' . json_encode($conn->error) . ',"status":"fail"}');
}

if (!$stmt->bind_param("i", $postvars['id'])) {
  die('{"error":"Prepared Statement bind failed on bind","errNo":' . json_encode($conn->errno) . ',"mysqlError":' . json_encode($conn->error) . ',"status":"fail"}');
}

$stmt->execute();
$rows = $conn->affected_rows;
$stmt->close();

die('{"data":"ok","message":"Record deleted","status":200,"deleted":' . $rows . '}');
