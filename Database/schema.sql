DROP DATABASE IF EXISTS tickety;


CREATE DATABASE tickety;

USE tickety;


CREATE TABLE form_submissions (
  id INT AUTO_INCREMENT,
  name VARCHAR(255),
  subject VARCHAR(255),
  message TEXT,
  date DATETIME,
  PRIMARY KEY (id)
);

CREATE TABLE users ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_recovery_token_sent_at DATETIME DEFAULT NULL,
    is_verified BOOLEAN DEFAULT FALSE
);

CREATE TABLE unique_tokens
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  selector VARCHAR(255) NOT NULL,
  hashed_validator VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  expiry DATETIME NOT NULL,
  CONSTRAINT fk_user_id1
      FOREIGN KEY (user_id)
          REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE categories (
  name VARCHAR(255) NOT NULL PRIMARY KEY
);


CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) UNIQUE NOT NULL,
  venue VARCHAR(255) NOT NULL,
  shortDescription VARCHAR(1000) NOT NULL,
  longDescription VARCHAR(10000) NOT NULL,
  organizer VARCHAR(255) NOT NULL,
  totalTickets INT NOT NULL,
  availableTickets INT NOT NULL,

  startSellTime DATE NOT NULL,
  eventDate DATE NOT NULL,

  # Ticket Price is an integer in cents to prevent floating point errors
  ticketPrice INT NOT NULL,
  imagePath VARCHAR(255) NOT NULL,
  FULLTEXT KEY(shortDescription, longDescription, name, venue, organizer)
);


ALTER TABLE events ADD category VARCHAR(255) NOT NULL;
ALTER TABLE events ADD CONSTRAINT fk_category FOREIGN KEY (category) REFERENCES categories(name);


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
    phone_number VARCHAR(255),
    buy_date TIMESTAMP,
    price INT,
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);

INSERT INTO users (firstname, lastname, email, pwd, role, is_verified) VALUES ('John', 'Doe', 'johndoe@gmail.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'admin', TRUE);


INSERT INTO categories (name) VALUES
('Concerts'),
('Sports'),
('Theater');

INSERT INTO events (name, venue, shortDescription, longDescription, organizer, totalTickets, availableTickets, startSellTime, eventDate, ticketPrice, imagePath, category)
VALUES 
    ('Rock Concert', 'Arena Stadium', 'Rock concert with famous bands', 'A night of rock music featuring top bands from around the world.', 'Rock Events LLC', 1000, 500, '2024-04-01', '2024-05-15', 2500, 'rock_concert.jpg', 'Concerts'),
    ('Basketball Game', 'City Arena', 'Exciting basketball game', 'Watch two top teams battle it out on the court in an intense basketball game.', 'City Sports Association', 2000, 1000, '2024-03-25', '2024-04-20', 1500, 'basketball_game.jpg', 'Sports'),
    ('Shakespeare Play', 'Royal Theater', 'Classic Shakespearean play', 'Experience the timeless tale of love and tragedy in this Shakespearean masterpiece.', 'Royal Theater Company', 500, 300, '2024-05-01', '2024-06-10', 2000, 'shakespeare_play.jpg', 'Theater'),
    ('Concert', 'Gammarth', 
    'Experience the electrifying energy of live music at our concert! Immerse in the rhythm, lights, and the unforgettable atmosphere.',
    'Immerse yourself in the electrifying atmosphere of our live concert. Feel the rhythm pulsate through the crowd as the stage lights dance. Witness the raw energy of the performers, their music resonating in perfect harmony with the audience’s excitement. It’s not just a concert, it’s an unforgettable experience of a lifetime.',
    'Music Events LLC', 500, 336, '2023-03-09', '2024-05-09', '337', 'Static/Images/event-1.jpg', 'Concerts');
