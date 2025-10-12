<?php
// hier kan ik een nieuwe concert toevoegen aan het db bekijk als de nodige velden actie zijn . 
check_required_fields(["artist", "date", "time", "venue", "price"]);

// locale variabels die de warning gaan vermijden 
$artist = htmlentities($postvars['artist']);
$date = htmlentities($postvars['date']);
$time = htmlentities($postvars['time']);
$venue = htmlentities($postvars['venue']);
$price = $postvars['price'];

//  het aanmaken van een isnert statement voor de db van een concert 
if (!$stmt = $conn->prepare("INSERT INTO concerts (artist, date, time, venue, price) VALUES (?,?,?,?,?)")) {
    //je moet deze volgende waarden hebben om geen eror te hebben 
    die(json_encode([
        "error" => "Prepare failed",
        "errNo" => $conn->errno,
        "mysqlError" => $conn->error,
        "status" => "fail"
    ]));
}

// bind parameters met string 
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
// hier is de id vann de concert 
$id = $conn->insert_id;
// de statement is gesloten en vervind aan db 
$stmt->close();
$conn->close();

// via postman krijg je goede aantwoord in json 
die(json_encode([
    "data" => "ok",
    "message" => "Record added successfully",
    "status" => 200,
    "id" => $id
]));
?>