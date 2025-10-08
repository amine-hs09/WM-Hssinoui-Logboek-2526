<?php
// --- "add" een concert
// hier kan ik een nieuwe concert toevoegen aan de db 
// controleer of de nodige velden meegegeven zijn in json vorm 
check_required_fields(["artist", "date", "time", "venue", "price"]);

// Variables locales om warnings te vermijden
$artist = htmlentities($postvars['artist']);
$date = htmlentities($postvars['date']);
$time = htmlentities($postvars['time']);
$venue = htmlentities($postvars['venue']);
$price = $postvars['price'];

// create prepared statement  de instert query wordt voorbereid
// sql injectie voor een veilige query
if (!$stmt = $conn->prepare("INSERT INTO concerts (artist, date, time, venue, price) VALUES (?,?,?,?,?)")) {
    //als de query niet kan worden voorbereid dan krijg je eror 
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
// dit is de id van nieuwe concert
$id = $conn->insert_id;
// sluit de statement uit en verbinding met db
$stmt->close();
$conn->close();

// Réponse clean in json voor postman 
die(json_encode([
    "data" => "ok",
    "message" => "Record added successfully",
    "status" => 200,
    "id" => $id
]));
