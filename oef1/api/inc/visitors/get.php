<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Specifieke bezoeker
    if (!$stmt = $conn->prepare("SELECT id, first_name, last_name, birth_date, email FROM visitors WHERE id=?")) {
        die(json_encode(["error" => "Prepare failed", "mysqlError" => $conn->error, "status" => "fail"]));
    }
// bind en execute
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $r = $stmt->get_result();
    // als ik geen resultaat heb
    if ($r->num_rows === 0) {// geen resultaat
        die(json_encode(["error" => "Visitor not found", "status" => 404]));
    }
    // bezoeker ophalen
    $visitor = $r->fetch_assoc();
    $stmt->close();

    // Tickets voor deze bezoeker ophalen
    $sqlT = "SELECT t.id AS ticket_id, c.artist, c.venue, c.date, t.qty
             FROM tickets t JOIN concerts c ON t.concert_id = c.id
             WHERE t.visitor_id = $id
             ORDER BY c.date";
             // ik haal alle tickets op voor deze bezoeker
    $resT = $conn->query($sqlT);
    $tickets = [];
    while ($row = $resT->fetch_assoc()) $tickets[] = $row;
// sluit resultaat
    die(json_encode(["data" => ["visitor" => $visitor, "tickets" => $tickets], "status" => 200]));
} else {
    // Alle bezoekers
    $sql = "SELECT id, first_name, last_name, birth_date, email FROM visitors ORDER BY last_name";
    $res = $conn->query($sql);
    $list = [];
    while ($r = $res->fetch_assoc()) $list[] = $r;
    $res->close();

    die(json_encode(["data" => $list, "status" => 200]));
}
?>