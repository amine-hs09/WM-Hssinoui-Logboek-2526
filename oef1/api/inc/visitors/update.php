<?php
require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";

header("Content-Type: application/json; charset=utf-8");
$postvars = json_decode(file_get_contents("php://input"), true);
if (!is_array($postvars)) { $postvars=[]; }

function check_required_fields($fields,$arr){
  foreach($fields as $f){ if(!isset($arr[$f]) || $arr[$f]===""){ die('{"error":"Missing field: '.$f.'","status":"fail"}'); } }
}

if(!isset($_GET['id']) || (int)$_GET['id']<=0){ die('{"error":"Missing id","status":"fail"}'); }
$id = (int)$_GET['id'];

check_required_fields(["first_name","last_name","birth_date","email"], $postvars);

if(!$stmt = $conn->prepare("UPDATE visitors SET first_name=?, last_name=?, birth_date=?, email=? WHERE id=?")){
  die('{"error":"Prepared Statement failed on prepare","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
if(!$stmt->bind_param("ssssi", $postvars["first_name"], $postvars["last_name"], $postvars["birth_date"], $postvars["email"], $id)){
  die('{"error":"Prepared Statement bind failed on bind","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
$stmt->execute();
/* 0 row affected = mêmes valeurs possible, on renvoie ok */
$stmt->close();
die('{"data":"ok","message":"Record updated successfully","status":200}');
