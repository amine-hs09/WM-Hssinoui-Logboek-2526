<?php
require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT id, artist, date, time, venue, price FROM concerts";
if($id>0) $sql .= " WHERE id=".$id;
$sql .= " ORDER BY date, time, artist";

$res = $conn->query($sql);
if(!$res) fail("Query failed: ".$conn->error,500);
$data = rows($res);
$res->close(); $conn->close();
ok($data);
