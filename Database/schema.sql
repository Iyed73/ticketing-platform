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

CREATE TABLE categories (
  name VARCHAR(255) NOT NULL PRIMARY KEY
);

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) UNIQUE NOT NULL,
  venue VARCHAR(255) NOT NULL,
  eventDate DATE NOT NULL,
  shortDescription VARCHAR(1000) NOT NULL,
  longDescription VARCHAR(10000) NOT NULL,
  organizer VARCHAR(255) NOT NULL,
  totalTickets INT NOT NULL,
  availableTickets INT NOT NULL,

  startSellTime DATE NOT NULL,
  endSellTime DATE NOT NULL,

  # Ticket Price is an integer in cents to prevent floating point errors
  ticketPrice INT NOT NULL,
  imagePath VARCHAR(255) NOT NULL
);


ALTER TABLE events ADD category VARCHAR(255) NOT NULL;
ALTER TABLE events ADD CONSTRAINT fk_category FOREIGN KEY (category) REFERENCES categories(name);


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

CREATE TABLE ticket (
    ticket_id CHAR(36) PRIMARY KEY,
    buyer_id INT,
    event_id INT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    buy_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email_sent BOOLEAN DEFAULT FALSE, -- Indicates whether the ticket has been sent via email to the holder
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);
