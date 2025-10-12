<?php
// een cincert modificeren

check_required_fields(["id", "artist", "date", "time", "venue", "price"]);

// locale variabels die de warning gaan vermijden
$id = (int) $postvars['id'];
$artist = htmlentities($postvars['artist']);
$date = htmlentities($postvars['date']);
$time = htmlentities($postvars['time']);
$venue = htmlentities($postvars['venue']);
$price = (float) $postvars['price'];

// Préparer la requête
if (!$stmt = $conn->prepare("UPDATE concerts SET artist=?, date=?, time=?, venue=?, price=? WHERE id=?")) {
    die(json_encode([
        "error" => "Prepare failed",
        "errNo" => $conn->errno,
        "mysqlError" => $conn->error,
        "status" => "fail"
    ]));
}

// Bind
if (!$stmt->bind_param("ssssdi", $artist, $date, $time, $venue, $price, $id)) {
    die(json_encode([
        "error" => "Bind failed",
        "errNo" => $conn->errno,
        "mysqlError" => $conn->error,
        "status" => "fail"
    ]));
}
// Execute werd niet goed uitgevoerd
if (!$stmt->execute()) {
    die(json_encode([
        "error" => "Execute failed",
        "errNo" => $stmt->errno,
        "mysqlError" => $stmt->error,
        "status" => "fail"
    ]));
}

$rows = $stmt->affected_rows;
$stmt->close();
$conn->close();
// die in json format indien alles goed is verlopen
die(json_encode([
    "data" => "ok",
    "message" => "Record updated",
    "status" => 200,
    "updated" => $rows
]));
?>