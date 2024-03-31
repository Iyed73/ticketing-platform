<?php

require_once "Repo.php";

class TicketManagementModel extends Repo
{
    public function __construct() {
        parent::__construct("ticket");
    }

    public function createTicket($buyerId, $eventId, $firstName, $lastName, $email): bool|string{
        $ticketId = $this->generateTicketId();
        $ticketData = array(
            "ticket_id" => $ticketId,
            "buyer_id" => $buyerId,
            "event_id" => $eventId,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email
        );
        $this->insert($ticketData);
        return true;
    }

    private function generateTicketId(): string {
        return uniqid();
    }
}


