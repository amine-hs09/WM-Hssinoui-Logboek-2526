<?php
require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id<=0) fail("Missing id",400);

$in = get_json_body();
require_fields($in, ["artist","date","time","venue","price"]);

$stmt = $conn->prepare("UPDATE concerts SET artist=?, date=?, time=?, venue=?, price=? WHERE id=?");
if(!$stmt) fail("Prepare failed: ".$conn->error,500);
$stmt->bind_param("ssssdi",$in["artist"],$in["date"],$in["time"],$in["venue"],$in["price"],$id);
if(!$stmt->execute()) fail("Update failed: ".$stmt->error,500);

$stmt->close(); $conn->close();
ok(["updated"=>true]);
