<?php
$in = getJsonInput();
check_required_fields(["first_name","last_name","birth_date","email"], $in);

$stmt = $conn->prepare("INSERT INTO visitors(first_name,last_name,birth_date,email) VALUES(?,?,?,?)");
if(!$stmt){ deliver_response(0,500,"Prepare failed: ".$conn->error); }
$stmt->bind_param("ssss", $in["first_name"], $in["last_name"], $in["birth_date"], $in["email"]);
$stmt->execute();
if($stmt->errno){ deliver_response(0,500,"Insert failed: ".$stmt->error); }
$id = $stmt->insert_id;
$stmt->close(); $conn->close();
deliverJSONresponse(["id"=>$id]);
