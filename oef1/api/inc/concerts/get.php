<?php
//hier krijg ik een get methode voor alle concerts in db 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// zoek via postman de gevraagde id door = id te gerbuiekn 

if ($id > 0) {
    // waar id is dans krijg je deze infomatie bij het opzoekne van get 
    if (!$stmt = $conn->prepare("SELECT id,artist,date,time,venue,price FROM concerts WHERE id=?")) {
        $response['code'] = 7;
        $response['status'] = 500;
        $response['data'] = $conn->error;
        deliver_response($response);
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        $response['code'] = 7;
        $response['status'] = 500;
        $response['data'] = $stmt->error;
        deliver_response($response);
    }
    $r = $stmt->get_result();
    if ($r->num_rows === 0) {
        $response['code'] = 8;
        $response['status'] = 404;
        $response['data'] = "Concert not found";
        deliver_response($response);
    }
    $concert = $r->fetch_assoc();
    $stmt->close();

    // welke visitor is aangegeven voor dit concert 
    $sqlV = "SELECT v.id, v.first_name, v.last_name, v.email, t.qty
             FROM tickets t JOIN visitors v ON v.id=t.visitor_id
             WHERE t.concert_id=$id ORDER BY v.last_name, v.first_name";
    $rv = $conn->query($sqlV);
    if (!$rv) {
        $response['code'] = 7;
        $response['status'] = 500;
        $response['data'] = $conn->error;
        deliver_response($response);
    }
    $visitors = [];
    while ($row = $rv->fetch_assoc())
        $visitors[] = $row;
    $rv->free();

    $response['code'] = 1;
    $response['status'] = 200;
    $response['data'] = ['concert' => $concert, 'visitors' => $visitors];
    $conn->close();
    deliver_JSONresponse1($response);
} else {
    // liste
    $sql = "SELECT id,artist,date,time,venue,price FROM concerts ORDER BY date, time";
    $res = $conn->query($sql);
    if (!$res) {
        $response['code'] = 7;
        $response['status'] = 500;
        $response['data'] = $conn->error;
        deliver_response($response);
    }

    $list = [];
    while ($row = $res->fetch_assoc())
        $list[] = $row;
    $res->free();

    $response['code'] = 1;
    $response['status'] = 200;
    $response['data'] = $list;
    $conn->close();
    deliver_JSONresponse1($response);
}
?>