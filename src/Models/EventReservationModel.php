<?php
require_once "Repo.php";

class EventReservationModel extends Repo {
    public function __construct() {
        parent::__construct("reservation");
    }

    public function reserveTickets($eventId, $userId, $quantity): bool|string {
        try {
            $this->db->beginTransaction();

            $availableTickets = $this->getAvailableTickets($eventId);
            if ($availableTickets < $quantity) {
                throw new Exception("Insufficient tickets available.");
            }
            $this->updateAvailableTickets($eventId, $availableTickets - $quantity);

            $expirationDate = date('Y-m-d H:i:s', strtotime('+20 minutes'));

            $reservationData = array(
                "user_id" => $userId,
                "event_id" => $eventId,
                "quantity" => $quantity,
                "expiration_date" => $expirationDate
            );
            $this->insert($reservationData);

            $this->db->commit();

            return true;


        } catch (Exception $e) {
            $this->db->rollBack();

            return $e->getMessage();
        }
    }

    private function getAvailableTickets($eventId) {
        $query = "SELECT available_tickets FROM events WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$eventId]);
        return $response->fetchColumn();
    }

    private function updateAvailableTickets($eventId, $newAvailableTickets): void {
        $query = "UPDATE events SET availab_tickets = ? WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$newAvailableTickets, $eventId]);
    }
}
