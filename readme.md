# Ticketing Platform Website 

This repository contains the source code for a ticketing platform website developed using native PHP. The platform allows users to buy event tickets, manage their tickets, and interact with administrators. Below is a guide detailing the features available to both administrators and customers.

## Features

### For Admins:

1. *Dashboard*: 
    - View all users, tickets, and events.
    - Access and manage contact form submissions from users.

2. *Events Management*:
    - Add, modify, or delete events.
    - Events include details such as name, venue, date, ticket availability, and price.

### For Customers:

1. *User Authentication*:
    - Register, login, and logout functionalities.
    - Account verification via email upon registration.
    - Forgot password feature with JWT token verification for password reset.
    - "Remember Me" feature using selector and validator method for cookie creation.

2. *Event Browsing*:
    - Browse through all displayed events.
    - Search for specific events using keywords.

3. *Ticket Purchase*:
    - Purchase tickets for desired events.
    - 20-minute window to fill in credentials for ticket purchase.
    - Generation of PDF ticket with QR code for display and download.
    - Ticket sent as attachment in an email after purchase.

4. *Contact Form Submission*:
    - Fill in a contact form, which is sent to administrators' dashboard and company email (tickety873@gmail.com).

5. *Ticket Management*:
    - View and download receipts for purchased tickets.
    - Manage tickets bought at any time.

6. *Notifications*:
    - Receive notifications for:
        - Upcoming events.

7. *Currency Settings*:
    - Set preferred currency for price display.
    - Currency conversion using online API with caching duration of one hour.

8. *Account Management*:
    - Modify account information.
    - Change passwords securely.

## Process of Buying Tickets

1. **Event Reservation Initiation**:
   - Logged-in customers can select the desired quantity of tickets for an event.
   - The system initiates an event reservation process, verifying ticket availability.

2. **Temporal Reservation**:
   - A temporary event reservation is made, securing the selected tickets for 20 minutes.
   - During this period, the reserved tickets are temporarily removed from availability.

3. **Payment Process**:
   - Upon successful reservation, users are redirected to the payment page.
   - They provide necessary client information for each ticket purchased.

4. **Ticket Generation**:
   - After successful payment within the reservation time, tickets are generated.
   - Users are redirected to the "View Tickets" page to manage their purchases.

5. **Event Reservation Management**:
   - If a user leaves the payment page, they can return without losing the reservation.
   - Users cannot initiate another reservation for the same event until the current one is completed or cancelled.

6. **Event Reservation Cleanup**:
   - A cron job runs every 5 minutes to manage expired reservations.
   - It removes any expired reservations from the system to keep the process efficient.
  
## Setting up the Cron Job

1. **Locate the PHP Script**:
   - The PHP script for the cron job is located in the `scripts` directory inside the project.

2. **Create a Cron Job**:
   - For Windows users, use the Windows Task Scheduler to create a new task that runs the PHP script at the desired intervals.
   - For Linux users, use the terminal to add a cron job that runs the PHP script at the desired intervals.

## Technologies Used

- PHP for server-side scripting.
- MySQL for database management.
- HTML, CSS, Bootstrap and JavaScript for frontend development.
- JWT for secure authentication.
- TCPDF for generating tickets in pdf format.
- SimpleCash for currency conversion API integration.

## Installation

1. Clone the repository to your local machine.
2. Navigate to the database folder and execute the SQL scripts `schema.sql` and `dummyData.sql` in your MySQL environment to set up the database schema and sample data.
3. Configure database credentials & SMTP server (Mailing service) credentials & API_KEY & Website Prefix in the `.env` file.
4. Navigate to the `.htaccess` file in the main project folder and edit it to replace `YourProjectFolderName` with the name of your project folder.
5. Run the website on your local server.
6. Make sure to run the command `composer install` to install dependencies.

## Composer Dependencies:

- `vlucas/phpdotenv`: "^5.6"
- `phpmailer/phpmailer`: "^6.9"
- `shieldon/simple-cache`: "^1.3"
- `tecnickcom/tcpdf`: "^6.7"
- `endroid/qrcode`: "^5.0"


## Environment Variables

The project utilizes a `.env` file for configuration. It contains sensitive data such as database credentials and API keys. Ensure the following variables are appropriately set in the `.env` file:

- SMTPhost
- SMTPusername
- SMTPpassword
- SMTPport
- prefix
- SECRET_KEY
- CURRENCY_CONVERTER_API_KEY
- DB_PASSWORD
- DB_USERNAME
- DB_SERVERNAME
- DATABASE_NAME
  
## Obtaining SMTP server Credentials and Currency Conversion API Key

- **SMTP Credentials:**
  You can obtain SMTP credentials from a mailer service provider like [MailerSend](https://www.mailersend.com) or any other service that offers SMTP servers.

- **Currency Conversion API Key:**
  You must get a free API key for currency conversion from the provider we are using: [Free Currency API](https://app.freecurrencyapi.com). 
  
## Contributors

- [Rayen Kasmi](https://github.com/RayenKasmi)
- [Dali Guerfali](https://github.com/DaliGuerfali)
- [Youssef Fadhloun](https://github.com/youssef358)
- [Seif Chouchane](https://github.com/seifshub)
- [Iyed Abdelli](https://github.com/ostrobogulous)
