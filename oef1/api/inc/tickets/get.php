<?php
// vind alle ticket terug 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // hier vind ik de detail terug van de ticket 
    $sql = "SELECT t.id, v.first_name, v.last_name, c.artist, c.venue, t.qty, t.bought_at
            FROM tickets t
            JOIN visitors v ON v.id = t.visitor_id
            JOIN concerts c ON c.id = t.concert_id
            WHERE t.id = ?";
    if (!$stmt = $conn->prepare($sql)) {
        die('{"error":"Prepare failed","status":"fail"}');
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        die('{"error":"Ticket not found","status":404}');
    }

    $ticket = $res->fetch_assoc();
    $stmt->close();
    die(json_encode(["data" => $ticket, "status" => 200]));
} else {
    // hier is de request voor alle tickets te vinden 
    $sql = "SELECT t.id, v.first_name, v.last_name, c.artist, c.date, c.venue, t.qty
        FROM tickets t
            JOIN visitors v ON v.id = t.visitor_id
            JOIN concerts c ON c.id = t.concert_id
            ORDER BY t.bought_at DESC";
    $res = $conn->query($sql);
    if (!$res) {
        die('{"error":"Query failed","mysqlError":' . json_encode($conn->error) . ',"status":"fail"}');
    }

    $tickets = [];
    while ($row = $res->fetch_assoc()) {
        $tickets[] = $row;
    }
    $res->free();
    $conn->close();
// sluit verbinding
    die(json_encode(["data" => $tickets, "status" => 200]));
}
?>