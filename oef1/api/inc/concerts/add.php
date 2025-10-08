<?php
// --- "add" een concert

check_required_fields(["artist","date","time","venue","price"]);

// Variables locales (obligatoire pour éviter les warnings)
$artist = htmlentities($postvars['artist']);
$date   = htmlentities($postvars['date']);
$time   = htmlentities($postvars['time']);
$venue  = htmlentities($postvars['venue']);
$price  = $postvars['price'];

// create prepared statement
if (!$stmt = $conn->prepare("INSERT INTO concerts (artist, date, time, venue, price) VALUES (?,?,?,?,?)")) {
    die(json_encode([
        "error" => "Prepare failed",
        "errNo" => $conn->errno,
        "mysqlError" => $conn->error,
        "status" => "fail"
    ]));
}

// bind parameters (s = string, d = double)
if (!$stmt->bind_param("ssssd", $artist, $date, $time, $venue, $price)) {
    die(json_encode([
        "error" => "Bind failed",
        "errNo" => $conn->errno,
        "mysqlError" => $conn->error,
        "status" => "fail"
    ]));
}

if (!$stmt->execute()) {
    die(json_encode([
        "error" => "Execute failed",
        "errNo" => $stmt->errno,
        "mysqlError" => $stmt->error,
        "status" => "fail"
    ]));
}

$id = $conn->insert_id;
$stmt->close();
$conn->close();

// Réponse clean
die(json_encode([
    "data" => "ok",
    "message" => "Record added successfully",
    "status" => 200,
    "id" => $id
]));
