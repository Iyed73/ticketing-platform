<?php

/*
   The cron job periodically removes expired reservations and adds the reserved tickets back to available ones.
 */

function updateEventAvailability(): void {
    require_once "Database/dbConnection.php";
    $db = dbConnection::getConnection();

    // Retrieve event ids for expired reservations with quantity sum
    $query = "SELECT event_id, SUM(quantity) AS total_quantity 
          FROM reservation 
          WHERE expiration_date < NOW() 
          GROUP BY event_id";

    $response = $db->prepare($query);
    $response->execute();
    $expiredReservations = $response->fetchAll(PDO::FETCH_ASSOC);

    $db->beginTransaction();

    try {
        foreach ($expiredReservations as $reservation) {
            $eventId = $reservation['event_id'];
            $quantity = $reservation['total_quantity'];

            $query = "UPDATE events SET available_tickets = available_tickets + ? WHERE id = ?";
            $response = $db->prepare($query);
            $response->execute([$quantity, $eventId]);
        }
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        throw $e;
    }
}


try {
    updateEventAvailability();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

