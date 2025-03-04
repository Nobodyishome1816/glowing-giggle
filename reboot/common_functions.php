<?php

function usr_error(&$session){
    if(isset($session['message'])) {
        $temp = $session['message'];
        unset($session['message']);
        return $temp;
    } else {
        return "";
    }
}

function get_ticket_types($conn) {
    try {
        $sql = "SELECT ticket_id, ticket_type FROM ticket";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    catch(PDOException $e) {
        error_log("database error in get ticket type: ",$e->getMessage());
    }
}
?>