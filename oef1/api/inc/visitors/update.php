<?php
//een bezoeker aanpassen 
check_required_fields(["id","first_name","last_name","birth_date","email"]);

$first = htmlentities($postvars['first_name']);
$last  = htmlentities($postvars['last_name']);
$birth = htmlentities($postvars['birth_date']);
$email = htmlentities($postvars['email']);
$id    = $postvars['id'];

if (!$stmt = $conn->prepare("UPDATE visitors SET first_name=?, last_name=?, birth_date=?, email=? WHERE id=?")) {
    die(json_encode(["error" => "Prepare failed", "mysqlError" => $conn->error, "status" => "fail"]));
}

if (!$stmt->bind_param("ssssi", $first, $last, $birth, $email, $id)) {
    die(json_encode(["error" => "Bind failed", "mysqlError" => $conn->error, "status" => "fail"]));
}

$stmt->execute();
$rows = $stmt->affected_rows;
$stmt->close();
$conn->close();

die(json_encode(["data" => "ok", "message" => "Visitor updated", "status" => 200, "updated" => $rows]));
?>