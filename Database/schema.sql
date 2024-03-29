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