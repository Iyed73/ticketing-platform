-- Drop existing database if exists
DROP DATABASE IF EXISTS tickety;

-- Create new database
CREATE DATABASE tickety;

-- Use the tickety database
USE tickety;

-- Define table for storing form submissions
CREATE TABLE form_submissions (
  id INT AUTO_INCREMENT,
  name VARCHAR(255),
  subject VARCHAR(255),
  message TEXT,
  date DATETIME,
  PRIMARY KEY (id)
);

-- Define table for storing users
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

-- Define table for storing unique tokens
CREATE TABLE unique_tokens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  selector VARCHAR(255) NOT NULL,
  hashed_validator VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  expiry DATETIME NOT NULL,
  CONSTRAINT fk_user_id1
      FOREIGN KEY (user_id)
          REFERENCES users (id) ON DELETE CASCADE
);

-- Define table for storing categories
CREATE TABLE categories (
  name VARCHAR(255) NOT NULL PRIMARY KEY
);

-- Define table for storing events
CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) UNIQUE NOT NULL,
  venue VARCHAR(255) NOT NULL,
  shortDescription VARCHAR(1000) NOT NULL,
  longDescription VARCHAR(10000) NOT NULL,
  organizer VARCHAR(255) NOT NULL,
  totalTickets INT NOT NULL,
  availableTickets INT NOT NULL CHECK (availableTickets >= 0),
  startSellTime DATE NOT NULL,
  eventDate DATE NOT NULL,
  ticketPrice INT NOT NULL,
  imagePath VARCHAR(255) NOT NULL,
  category VARCHAR(255) NOT NULL,
  FULLTEXT KEY(shortDescription, longDescription, name, venue, organizer),
  CONSTRAINT fk_category
      FOREIGN KEY (category) REFERENCES categories(name)
);

-- Define table for storing notifications
CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  user_id INT NOT NULL,
  is_read ENUM('read', 'unread') DEFAULT 'unread',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_user_id
      FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Define table for storing reservations
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

-- Define table for storing tickets
CREATE TABLE ticket (
    ticket_id CHAR(36) PRIMARY KEY,
    buyer_id INT,
    event_id INT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    phone_number VARCHAR(255),
    buy_date TIMESTAMP,
    price INT,
    is_notification_sent BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

