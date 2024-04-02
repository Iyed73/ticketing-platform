<?php
require_once "Repo.php";

class EventReservationModel extends Repo {
    public int $reservationPeriod = 20;


    public function __construct() {
        parent::__construct("reservation");
    }

    // todo: add total price
    public function reserveTickets($eventId, $userId, $quantity): bool|string {
        try {
            $this->db->beginTransaction();

            if ($this->isReservationOngoing($eventId, $userId)) {
                return "There is already an ongoing reservation.";
            }

            $availableTickets = $this->getAvailableTickets($eventId);
            if ($availableTickets < $quantity) {
                return "Insufficient tickets available.";
            }
            $this->updateAvailableTickets($eventId, $availableTickets - $quantity);

            $expirationDate = date('Y-m-d H:i:s', strtotime("+$this->reservationPeriod minutes"));

            $reservationData = array(
                "user_id" => $userId,
                "event_id" => $eventId,
                "quantity" => $quantity,
                "expiration" => $expirationDate
            );
            $this->insert($reservationData);

            $this->db->commit();

            return true;


        } catch (Exception $e) {
            $this->db->rollBack();

            return "An error occurred";
        }
    }

    // Users can have only 1 ongoing reservation at a time for a specific event.
    public function isReservationOngoing($eventId, $userId): bool {
        $query = "SELECT COUNT(*) FROM {$this->tableName} WHERE event_id = ? AND user_id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$eventId, $userId]);
        $count = $response->fetchColumn();
        return $count > 0;
    }


    private function getAvailableTickets($eventId) {
        $query = "SELECT availableTickets FROM events WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$eventId]);
        return $response->fetchColumn();
    }

    private function updateAvailableTickets($eventId, $newAvailableTickets): void {
        $query = "UPDATE events SET availableTickets = ? WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$newAvailableTickets, $eventId]);
    }

    public function getReservationId($eventId, $userId) {
        $query = "SELECT id FROM {$this->tableName} WHERE user_id = ? AND event_id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$userId, $eventId]);
        $reservationId = $response->fetchColumn();

        return $reservationId ?: null;
    }

    public function getReservationQuantity($reservationId) {
        $query = "SELECT quantity FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$reservationId]);
        return $response->fetchColumn();
    }

    public function isValidReservation($userId, $reservationId): bool {
        $query = "SELECT COUNT(*) FROM {$this->tableName} WHERE id = ? AND user_id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$reservationId, $userId]);
        $count = $response->fetchColumn();
        return $count > 0;
    }


    private function deleteReservation($reservationId): void {
        $query = "DELETE FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$reservationId]);
    }

    public function isReservationExpiredWithDelete($reservationId): ?bool {
        try {
            $this->db->beginTransaction();

            $query = "SELECT expiration FROM {$this->tableName} WHERE id = ?";
            $response = $this->db->prepare($query);
            $response->execute([$reservationId]);
            $expirationDate = $response->fetchColumn();

            $this->deleteReservation($reservationId);

            $this->db->commit();
            $currentDateTime = new DateTime();
            return $expirationDate > $currentDateTime;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return null;
        }
    }

    public function isReservationExpired($reservationId): bool {
        $query = "SELECT expiration FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$reservationId]);
        $expirationDate = $response->fetchColumn();

        return strtotime($expirationDate) < time();
    }

    public function getEventIdForReservation($reservationId): ?int {
        $query = "SELECT event_id FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$reservationId]);
        $eventId = $response->fetchColumn();
        return $eventId ? (int)$eventId : null;
    }

    public function increaseAvailableTickets($eventId, $quantity): void {
        $query = "UPDATE events SET availableTickets = availableTickets + ? WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$quantity, $eventId]);
    }


    public function cancelReservation($reservationId): bool|string {
        try {
            $this->db->beginTransaction();

            $quantity = $this->getReservationQuantity($reservationId);

            $eventId = $this->getEventIdForReservation($reservationId);

            $this->increaseAvailableTickets($eventId, $quantity);

            $this->deleteReservation($reservationId);

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }

}
