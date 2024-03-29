CREATE DATABASE Tickety;

CREATE TABLE form_submissions (
  id INT AUTO_INCREMENT,
  name VARCHAR(255),
  email VARCHAR(255),
  subject VARCHAR(255),
  message TEXT,
  date DATETIME,
  status ENUM('pending', 'resolved', 'dismissed'),
  PRIMARY KEY (id)
);

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
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
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
  ticketPrice INT NOT NULL

  FOREIGN KEY (category) REFERENCES categories(name),
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  totalPrice INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  FOREIGN KEY (userID) REFERENCES users(id)
);

CREATE tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  FOREIGN KEY (eventID) REFERENCES events(id),
  FOREIGN KEY (orderID) REFERENCES orders(id)
);

INSERT INTO users (firstname, lastname, username, email, pwd, role) VALUES ('John', 'Doe', 'admin0', 'johndoe@gmail.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'admin');
