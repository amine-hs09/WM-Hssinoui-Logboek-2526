<?php
// Nieuwe bezoeker toevoegen
check_required_fields(["first_name","last_name","birth_date","email"]);

$first = htmlentities($postvars['first_name']);
$last  = htmlentities($postvars['last_name']);
$birth = htmlentities($postvars['birth_date']);
$email = htmlentities($postvars['email']);

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

die(json_encode(["data" => "ok", "message" => "Visitor added successfully", "status" => 200, "id" => $id]));
