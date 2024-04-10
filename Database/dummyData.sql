/* both this users have 0000 as their password */
INSERT INTO users (firstname, lastname, email, pwd, role, is_verified) VALUES ('Ahmed', 'Ghali', 'ahmedghali@insat.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'admin', TRUE);
INSERT INTO users (firstname, lastname, email, pwd, role, is_verified) VALUES ('Mohamed', 'Jaziri', 'mohamedjaziri@insat.com', '$2y$12$WFzkKn9UtpBWS7HYXH8n/e/c0IornFVFDrNRpEXGx4RGR7KuxK5KG', 'customer', TRUE);


INSERT INTO categories (name)
VALUES
    ('Concerts'),
    ('Sports'),
    ('Festivals'),
    ('Theatre'),
    ('Comedy Shows'),
    ('Opera');


INSERT INTO events (name, venue, shortDescription, longDescription, organizer, totalTickets, availableTickets, startSellTime, eventDate, ticketPrice, imagePath, category)
VALUES
    ('Ziara', 'Carthage Amphitheatre', 'Ziara is a cultural show in Tunisia','Ziara is a captivating cultural show in Tunisia, showcasing traditional music, dance, and storytelling.',  'Sami Lajmi', 5000, 5000, '2024-04-01', '2024-06-15', 3000, 'Static/Images/image1.png', 'Concerts'),
    ('Lotfi Abdelli Show', 'Municipal Theater Tunis','Very funny!', 'Get ready to laugh till it hurts at Lotfi Abdelli Comedy Show! Tunisia''s favorite comedian brings his sharp wit and hilarious anecdotes for an evening of non-stop laughter.',  'Organizer', 300, 300, '2024-03-25', '2024-05-20', 2500, 'Static/Images/image2.png', 'Comedy Shows'),
    ('Spacetoon Songs', 'Carthage Amphitheatre', 'Amazing nostalgic music', 'Join Tarek Al Arabi and his children for an unforgettable family show filled with laughter, music, and magic!', 'Organizer', 4000, 399, '2024-03-20', '2024-06-25', 4000, 'Static/Images/image3.png', 'Concerts'),
    ('Tunis International Book Fair', 'Explore books related stuff','Tunis Exhibition Center', 'Celebrate literature and culture at the Tunis International Book Fair, where you can discover a wide range of books, attend author signings, and participate in literary discussions.',  'Ministry of Culture', 8000, 8000, '2024-04-01', '2024-04-30', 2000, 'Static/Images/image4.png', 'Festivals'),
    ('Tunisian Football Championship Final', 'Stade Olympique de Radès','Amazing match', 'Dont miss the thrilling climax of the Tunisian Football Championship as the top teams battle it out for glory in the final match.',  'Tunisian Football Federation', 25000, 25000,  '2024-04-01', '2024-05-30', 1500, 'Static/Images/image5.png', 'Sports'),
    ('Tunisian Opera Gala', 'Grand Theatre of Tunis', 'A night of breathtaking performances', 'Experience the grandeur of opera with the Tunisian Opera Gala, featuring spectacular performances by renowned opera singers from Tunisia and beyond.', 'Tunisian Opera House', 1500, 1500, '2024-06-10', '2024-06-20', 5000, 'Static/Images/image6.png', 'Opera'),
    ('Tunisian Jazz Festival', 'Habib Bourguiba Avenue', 'Jazz music under the stars', 'Immerse yourself in the soulful melodies of jazz at the Tunisian Jazz Festival, featuring talented musicians from around the world.', 'Tunis Jazz Association', 3000, 3000, '2024-07-01', '2024-07-10', 2500, 'Static/Images/image7.png', 'Concerts'),
    ('Carthage Summer Festival', 'Carthage Amphitheatre', 'A celebration of arts and culture', 'Join us for a vibrant celebration of arts and culture at the Carthage Summer Festival, featuring performances, exhibitions, and workshops.', 'Carthage Cultural Foundation', 5000, 5000, '2024-04-01', '2024-08-15', 3500, 'Static/Images/image8.png', 'Festivals'),
    ('Tunis Marathon', 'Downtown Tunis', 'Run for a cause!', 'Participate in the Tunis Marathon and experience the thrill of running through the historic streets of Tunis while supporting charitable causes.', 'Tunisian Athletics Federation', 10000, 10000, '2024-04-01', '2024-09-01', 1000, 'Static/Images/image9.png', 'Sports'),
    ('Yanni Live in Concert', 'Carthage Amphitheatre', 'Experience the magic of Yanni live!', 'Dont miss the legendary musician Yanni as he performs live in concert at the historic Carthage Amphitheatre. Prepare to be captivated by his mesmerizing melodies and spellbinding performances.', 'Event Productions', 8000, 8000,  '2024-04-01', '2024-08-20', 7000, 'Static/Images/image10.png', 'Concerts'),
    ('Romeo and Juliet', 'National Theatre of Tunis', 'Classic Shakespearean tragedy', 'Experience the timeless tale of love and tragedy with a production of Romeo and Juliet at the National Theatre of Tunis. Witness the passion, drama, and emotion unfold on stage in this iconic Shakespearean masterpiece.', 'Tunisian Theatre Company', 1500, 1500, '2024-04-01', '2024-07-15', 8000, 'Static/Images/image11.png', 'Theatre'),
    ('The Importance of Being Earnest', 'Carthage Amphitheatre', 'Witty comedy by Oscar Wilde', 'Indulge in the clever wit and comedic charm of Oscar Wilde s masterpiece, The Importance of Being Earnest, performed at the historic Carthage Amphitheatre. Join the eccentric characters on a hilarious journey filled with mistaken identities and absurd situations.', 'Carthage Theatre Company', 2000, 2000, '2024-08-01', '2024-08-15', 7500, 'Static/Images/image12.png', 'Theatre'),
    ('Les Misérables', 'Municipal Theatre Tunis', 'Epic musical adaptation', 'Immerse yourself in the epic tale of passion, sacrifice, and redemption with a spectacular production of Les Misérables at the Municipal Theatre Tunis. Featuring unforgettable music and powerful performances, this timeless musical will leave you deeply moved.', 'Tunisian Musical Theatre Association', 2500, 2500, '2024-09-01', '2024-09-15', 6000, 'Static/Images/image13.png', 'Theatre'),
    ('A Streetcar Named Desire', 'Grand Theatre of Tunis', 'Classic American drama', 'Explore the complexities of desire, desperation, and disillusionment with a gripping performance of Tennessee Williams A Streetcar Named Desire at the Grand Theatre of Tunis. Delve into the turbulent lives of the characters as they confront harsh realities and confrontations.', 'Tunisian Drama Guild', 1800, 1800, '2024-04-01', '2024-10-15', 6600, 'Static/Images/image14.png', 'Theatre'),
    ('Carmen', 'Opera House of Tunis', 'Passionate tale of love and jealousy', 'Experience the passion and drama of Georges Bizets Carmen, performed at the Opera House of Tunis. Follow the captivating story of the fiery gypsy Carmen and her tumultuous love affairs, set against the vibrant backdrop of 19th-century Spain.', 'Tunisian Opera Company', 1200, 1200, '2024-04-01', '2024-06-15', 5500, 'Static/Images/image15.png', 'Opera');


INSERT INTO notifications (sender, content, user_id, is_read, created_at)
VALUES
    ('Sender 1', 'Notification message 1', 2, 'unread', NOW()),
    ('Sender 2', 'Notification message 2', 2, 'unread', NOW()),
    ('Sender 3', 'Notification message 3', 2, 'read', NOW() - INTERVAL 1 DAY),
    ('Sender 4', 'Notification message 4', 2, 'unread', NOW()),
    ('Sender 5', 'Notification message 5', 2, 'read', NOW() - INTERVAL 2 DAY);

INSERT INTO form_submissions (name, subject, message, date)
VALUES
    ('John Doe', 'Inquiry', 'This is a sample message 1.', NOW()),
    ('Alice Smith', 'Feedback', 'This is a sample message 2.', NOW()),
    ('Bob Johnson', 'Support Request', 'This is a sample message 3.', NOW()),
    ('Emily Brown', 'Question', 'This is a sample message 4.', NOW()),
    ('Michael Lee', 'Comment', 'This is a sample message 5.', NOW()),
    ('Jessica Taylor', 'Complaint', 'This is a sample message 6.', NOW()),
    ('David Wilson', 'Inquiry', 'This is a sample message 7.', NOW()),
    ('Jennifer Anderson', 'Feedback', 'This is a sample message 8.', NOW()),
    ('Daniel Martinez', 'Support Request', 'This is a sample message 9.', NOW()),
    ('Sophia Garcia', 'Question', 'This is a sample message 10.', NOW()),
    ('Matthew Rodriguez', 'Comment', 'This is a sample message 11.', NOW()),
    ('Olivia Hernandez', 'Complaint', 'This is a sample message 12.', NOW()),
    ('Andrew Smith', 'Inquiry', 'This is a sample message 13.', NOW()),
    ('Isabella Johnson', 'Feedback', 'This is a sample message 14.', NOW()),
    ('Ethan Brown', 'Support Request', 'This is a sample message 15.', NOW()),
    ('Ava Lee', 'Question', 'This is a sample message 16.', NOW()),
    ('William Taylor', 'Comment', 'This is a sample message 17.', NOW()),
    ('Mia Wilson', 'Complaint', 'This is a sample message 18.', NOW()),
    ('James Garcia', 'Inquiry', 'This is a sample message 19.', NOW()),
    ('Charlotte Rodriguez', 'Feedback', 'This is a sample message 20.', NOW()),
    ('Benjamin Hernandez', 'Support Request', 'This is a sample message 21.', NOW()),
    ('Amelia Smith', 'Question', 'This is a sample message 22.', NOW()),
    ('Lucas Johnson', 'Comment', 'This is a sample message 23.', NOW()),
    ('Harper Brown', 'Complaint', 'This is a sample message 24.', NOW()),
    ('Alexander Martinez', 'Inquiry', 'This is a sample message 25.', NOW()),
    ('Evelyn Garcia', 'Feedback', 'This is a sample message 26.', NOW()),
    ('Daniel Rodriguez', 'Support Request', 'This is a sample message 27.', NOW()),
    ('Victoria Taylor', 'Question', 'This is a sample message 28.', NOW()),
    ('Michael Wilson', 'Comment', 'This is a sample message 29.', NOW()),
    ('Sophia Hernandez', 'Complaint', 'This is a sample message 30.', NOW());