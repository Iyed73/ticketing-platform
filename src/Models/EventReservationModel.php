<?php
require_once "Repo.php";

class EventReservationModel extends Repo {
    public function __construct() {
        parent::__construct("reservation");
    }

    public function reserveTickets($eventId, $userId, $quantity): bool|string {
        try {
            $this->db->beginTransaction();

            if ($this->isReservationOngoing($eventId, $userId)) {
                throw new Exception("There is already an ongoing reservation.");
            }

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

    private function isReservationOngoing($eventId, $userId): bool {
        $query = "SELECT COUNT(*) FROM reservation WHERE event_id = ? AND user_id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$eventId, $userId]);
        $count = $response->fetchColumn();
        return $count > 0;
    }

    private function getAvailableTickets($eventId) {
        $query = "SELECT available_tickets FROM events WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$eventId]);
        return $response->fetchColumn();
    }

    private function updateAvailableTickets($eventId, $newAvailableTickets): void {
        $query = "UPDATE events SET available_tickets = ? WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$newAvailableTickets, $eventId]);
    }

    // Users can have only 1 ongoing reservation at a time.
    public function getReservationIdForUser($userId) {
        $query = "SELECT id FROM {$this->tableName} WHERE user_id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$userId]);
        $reservationId = $response->fetchColumn();

        return $reservationId ? $reservationId : null; // Return reservation ID or null if not found
    }
}
