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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  totalPrice INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tickets (
  id INT AUTO_INCREMENT PRIMARY KEY
);

ALTER TABLE events ADD category VARCHAR(255) NOT NULL;
ALTER TABLE events ADD CONSTRAINT fk_category FOREIGN KEY (category) REFERENCES categories(name);

ALTER TABLE orders ADD userID INT NOT NULL;
ALTER TABLE orders ADD CONSTRAINT fk_userID FOREIGN KEY (userID) REFERENCES users(id);

ALTER TABLE tickets ADD eventID INT NOT NULL;
ALTER TABLE tickets ADD orderID INT NOT NULL;
ALTER TABLE tickets ADD CONSTRAINT fk_eventID FOREIGN KEY (eventID) REFERENCES events(id);
ALTER TABLE tickets ADD CONSTRAINT fk_orderID FOREIGN KEY (orderID) REFERENCES orders(id);

INSERT INTO users (firstname, lastname, email, pwd, role) VALUES ('John', 'Doe', 'johndoe@gmail.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'admin');


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
