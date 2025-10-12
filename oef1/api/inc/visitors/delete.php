<?php
// bezoeker deleten 
check_required_fields(["id"]);

$id = $postvars['id'];

if (!$stmt = $conn->prepare("DELETE FROM visitors WHERE id=?")) {
  die(json_encode(["error" => "Prepare failed", "mysqlError" => $conn->error, "status" => "fail"]));
}

if (!$stmt->bind_param("i", $id)) {
  die(json_encode(["error" => "Bind failed", "mysqlError" => $conn->error, "status" => "fail"]));
}

$stmt->execute();
$rows = $stmt->affected_rows;
$stmt->close();
$conn->close();

die(json_encode(["data" => "ok", "message" => "Visitor deleted", "status" => 200, "deleted" => $rows]));
?>