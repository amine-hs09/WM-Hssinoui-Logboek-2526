<?php
require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";

header("Content-Type: application/json; charset=utf-8");
if(!isset($_GET['id']) || (int)$_GET['id']<=0){ die('{"error":"Missing id","status":"fail"}'); }
$id = (int)$_GET['id'];

/* si pas de FK CASCADE, nettoyer d'abord tickets */
if(!$stmt = $conn->prepare("DELETE FROM tickets WHERE visitor_id=?")){
  die('{"error":"Prepared Statement failed on prepare (tickets)","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
if(!$stmt->bind_param("i", $id)){
  die('{"error":"Prepared Statement bind failed on bind (tickets)","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
$stmt->execute();
$stmt->close();

/* supprimer le visiteur */
if(!$stmt = $conn->prepare("DELETE FROM visitors WHERE id=?")){
  die('{"error":"Prepared Statement failed on prepare","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
if(!$stmt->bind_param("i", $id)){
  die('{"error":"Prepared Statement bind failed on bind","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
$stmt->execute();

if($conn->affected_rows==0){
  $stmt->close();
  die('{"error":"Prepared Statement failed on execute : no rows affected","errNo":'.json_encode($conn->errno).',"mysqlError":'.json_encode($conn->error).',"status":"fail"}');
}
$stmt->close();
die('{"data":"ok","message":"Record deleted successfully","status":200}');
