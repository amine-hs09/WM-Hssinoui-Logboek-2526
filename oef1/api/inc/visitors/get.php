<?php
require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";

/* GET visitors list or detail (id) – style prof */
header("Content-Type: application/json; charset=utf-8");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
  if(!$stmt = $conn->prepare("SELECT id, first_name, last_name, birth_date, email FROM visitors WHERE id = ?")){
    die('{"error":"Prepared Statement failed on prepare","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
  }
  if(!$stmt->bind_param("i", $id)){
    die('{"error":"Prepared Statement bind failed on bind","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
  }
  $stmt->execute();
  $res = $stmt->get_result();
  $rows = []; while($r=$res->fetch_assoc()){ $rows[]=$r; }
  $stmt->close();
  die(json_encode(["data"=>$rows,"status":200]));
} else {
  $sql = "SELECT id, first_name, last_name, birth_date, email
          FROM visitors
          ORDER BY last_name, first_name";
  $res = $conn->query($sql);
  if(!$res){
    die('{"error":"Query failed","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
  }
  $rows = []; while($r=$res->fetch_assoc()){ $rows[]=$r; }
  die(json_encode(["data"=>$rows,"status":200]));
}
