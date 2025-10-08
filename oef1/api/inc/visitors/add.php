<?php
require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";

header("Content-Type: application/json; charset=utf-8");
$postvars = json_decode(file_get_contents("php://input"), true);
if (!is_array($postvars)) { $postvars=[]; }

function check_required_fields($fields,$arr){
  foreach($fields as $f){ if(!isset($arr[$f]) || $arr[$f]===""){ die('{"error":"Missing field: '.$f.'","status":"fail"}'); } }
}

check_required_fields(["first_name","last_name","birth_date","email"], $postvars);

if(!$stmt = $conn->prepare("INSERT INTO visitors(first_name,last_name,birth_date,email) VALUES(?,?,?,?)")){
  die('{"error":"Prepared Statement failed on prepare","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
if(!$stmt->bind_param("ssss", $postvars["first_name"], $postvars["last_name"], $postvars["birth_date"], $postvars["email"])){
  die('{"error":"Prepared Statement bind failed on bind","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
$stmt->execute();

if($conn->affected_rows===0){
  $stmt->close();
  die('{"error":"Prepared Statement failed on execute : no rows affected","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}

$newId = $stmt->insert_id;
$stmt->close();
die('{"data":{"id":'.(int)$newId.'},"message":"Record added successfully","status":201}');
