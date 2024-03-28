CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (firstname, lastname, username, email, pwd, role) VALUES ('John', 'Doe', 'admin0', 'johndoe@gmail.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'admin');


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