CREATE DATABASE Tickety;

USE Tickety;


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

