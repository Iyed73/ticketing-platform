<<<<<<< HEAD
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

=======
>>>>>>> signUpLoginLogoutSystem
CREATE TABLE users ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
<<<<<<< HEAD
    username VARCHAR(255) UNIQUE NOT NULL,
=======
>>>>>>> signUpLoginLogoutSystem
    email VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

<<<<<<< HEAD




INSERT INTO users (firstname, lastname, username, email, pwd, role) VALUES ('John', 'Doe', 'admin0', 'johndoe@gmail.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'admin');
=======
INSERT INTO users (firstname, lastname, email, pwd, role) VALUES ('John', 'Doe', 'johndoe@gmail.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'admin');
>>>>>>> signUpLoginLogoutSystem
