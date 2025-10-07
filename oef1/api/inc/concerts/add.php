<?php

require_once __DIR__ . "/../../base.php";
require_once __DIR__ . "/../../dbcon.php";


$in = get_json_body();
// controle of de belangrijke velden er zijn 

require_fields($in, ["artist","date","time","venue","price"]);

// sql instuctie om concert toe te voegen 
$stmt = $conn->prepare("INSERT INTO concerts(artist,date,time,venue,price) VALUES(?,?,?,?,?)");
if(!$stmt) fail("Prepare failed: ".$conn->error,500);
// parameters om te kopellen 
$stmt->bind_param("ssssd",$in["artist"],$in["date"],$in["time"],$in["venue"],$in["price"]);
// voer dit uit 
if(!$stmt->execute()) fail("Insert failed: ".$stmt->error,500);

// haal het id van de nieyuwe concert op)--
$id = $stmt->insert_id;
// sluit alles op 
$stmt->close(); $conn->close();
// geef nieuwe id terug 
ok(["id"=>$id],201);
