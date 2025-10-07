<?php
require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id<=0) fail("Missing id",400);

$conn->query("DELETE FROM tickets WHERE concert_id=".$id);
if(!$conn->query("DELETE FROM concerts WHERE id=".$id))
  fail("Delete failed: ".$conn->error,500);

$conn->close();
ok(["deleted"=>true]);
