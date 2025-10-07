<?php
require_once __DIR__."/base.php";
require_once __DIR__."/dbcon.php";

$m = $_SERVER['REQUEST_METHOD'];

if ($m==="GET"){
  $sql="SELECT id, artist, date, time, venue, price FROM concerts";
  if(isset($_GET['id']) && $_GET['id']!==""){ $sql.=" WHERE id=".(int)$_GET['id']; }
  $sql.=" ORDER BY date, time, artist";
  $res=$conn->query($sql);
  if(!$res) fail("Query failed: ".$conn->error,500);
  $data=rows($res); $res->close(); $conn->close(); ok($data);
}

if ($m==="POST"){
  $in=get_json_body(); require_fields($in,["artist","date","time","venue","price"]);
  $stmt=$conn->prepare("INSERT INTO concerts(artist,date,time,venue,price) VALUES(?,?,?,?,?)");
  if(!$stmt) fail("Prepare failed: ".$conn->error,500);
  $stmt->bind_param("ssssd",$in["artist"],$in["date"],$in["time"],$in["venue"],$in["price"]);
  if(!$stmt->execute()) fail("Insert failed: ".$stmt->error,500);
  $id=$stmt->insert_id; $stmt->close(); $conn->close(); ok(["id"=>$id],201);
}

if ($m==="PUT"){
  $id=isset($_GET['id'])?(int)$_GET['id']:0; if($id<=0) fail("Missing id",400);
  $in=get_json_body(); require_fields($in,["artist","date","time","venue","price"]);
  $stmt=$conn->prepare("UPDATE concerts SET artist=?,date=?,time=?,venue=?,price=? WHERE id=?");
  if(!$stmt) fail("Prepare failed: ".$conn->error,500);
  $stmt->bind_param("ssssdi",$in["artist"],$in["date"],$in["time"],$in["venue"],$in["price"],$id);
  if(!$stmt->execute()) fail("Update failed: ".$stmt->error,500);
  $stmt->close(); $conn->close(); ok(["updated"=>true]);
}

if ($m==="DELETE"){
  $id=isset($_GET['id'])?(int)$_GET['id']:0; if($id<=0) fail("Missing id",400);
  $conn->query("DELETE FROM tickets WHERE concert_id=".$id);
  if(!$conn->query("DELETE FROM concerts WHERE id=".$id)) fail("Delete failed: ".$conn->error,500);
  $conn->close(); ok(["deleted"=>true]);
}

fail("Method Not Allowed",405);
