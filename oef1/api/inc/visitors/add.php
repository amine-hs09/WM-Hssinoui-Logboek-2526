<?php
// Nieuwe bezoeker toevoegen
check_required_fields(["first_name", "last_name", "birth_date", "email"]);
//convert special characters to HTML entities
$first = htmlentities($postvars['first_name']);
$last = htmlentities($postvars['last_name']);
$birth = htmlentities($postvars['birth_date']);
$email = htmlentities($postvars['email']);
// als ik een nieuwe bezoeker toevoeg moet ik de id aanpassen
if (!$stmt = $conn->prepare("INSERT INTO visitors (first_name, last_name, birth_date, email) VALUES (?,?,?,?)")) {
  die(json_encode(["error" => "Prepare failed", "mysqlError" => $conn->error, "status" => "fail"]));
}

if (!$stmt->bind_param("ssss", $first, $last, $birth, $email)) {
  die(json_encode(["error" => "Bind failed", "mysqlError" => $conn->error, "status" => "fail"]));
}

if (!$stmt->execute()) {
  die(json_encode(["error" => "Execute failed", "mysqlError" => $stmt->error, "status" => "fail"]));
}

$id = $conn->insert_id;
$stmt->close();
$conn->close();
// sluit verbinding op deze manier
die(json_encode(["data" => "ok", "message" => "Visitor added successfully", "status" => 200, "id" => $id]));
?>