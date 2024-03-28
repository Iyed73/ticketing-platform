DROP TABLE IF EXISTS reservation;

/*
   The reservation table stores temporary reservations made by users.
   Unpaid reservations for events automatically expire after a specific time.
   A scheduled cron job then cleans up these expired reservations,
   freeing up the reserved tickets for others to purchase.
*/
CREATE TABLE reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    user_id INT,
    quantity INT,
    expiration DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
