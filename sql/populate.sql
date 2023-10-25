INSERT INTO AppUser (name, username, email, password, bio, points, nquestion, nanswer, profilepicture, usertype)
VALUES
    ('Linda Johnson', 'lindaj', 'linda@example.com', 'linda456', 'Art lover', 60, 2, 8, 'linda_profile.jpg', 'user'),
    ('Michael Wilson', 'michaelw', 'michael@example.com', 'mike123', 'Gamer and programmer', 90, 6, 15, 'michael_profile.jpg', 'user'),
    ('Sarah Brown', 'sarahb', 'sarah@example.com', 'sarah789', 'Graphic designer', 80, 4, 12, 'sarah_profile.jpg', 'user'),
    ('Tom Adams', 'toma', 'tom@example.com', 'tompass', 'Musician and songwriter', 70, 3, 10, 'tom_profile.jpg', 'user'),
    ('Olivia Smith', 'olivias', 'olivia@example.com', 'olivia22', 'Nature enthusiast', 110, 8, 20, 'olivia_profile.jpg', 'user'),
    ('David White', 'davidw', 'david@example.com', 'david55', 'Science lover', 95, 5, 14, 'david_profile.jpg', 'user'),
    ('Emily Clark', 'emilyc', 'emily@example.com', 'emily99', 'Traveler and photographer', 75, 4, 16, 'emily_profile.jpg', 'user'),
    ('William Harris', 'williamh', 'william@example.com', 'william33', 'Bookworm', 85, 6, 18, 'william_profile.jpg', 'user'),
    ('Mia Turner', 'miat', 'mia@example.com', 'miapass', 'Foodie and chef', 70, 3, 11, 'mia_profile.jpg', 'user'),
    ('Daniel Martin', 'danm', 'dan@example.com', 'dan678', 'Fitness enthusiast', 100, 7, 22, 'dan_profile.jpg', 'user'),
    ('John Doe', 'johndoe', 'john@example.com', 'password123', 'I love coding!', 100, 5, 20, 'john_profile.jpg', 'user'),
    ('Jane Smith', 'janesmith', 'jane@example.com', 'p@ssw0rd', 'Tech enthusiast', 50, 2, 15, 'jane_profile.jpg', 'user'),
    ('Admin User', 'admin', 'admin@example.com', 'secure_password', 'Administrator', 200, 10, 50, 'admin_profile.jpg', 'admin'),
    ('Moderator User', 'moderator', 'moderator@example.com', 'strong_password', 'Moderator', 150, 7, 30, 'moderator_profile.jpg', 'moderator'),
    ('Alice Johnson', 'alicej', 'alice@example.com', '12345', 'Curious learner', 80, 4, 10, 'alice_profile.jpg', 'user'),
    ('Bob Smith', 'bobsmith', 'bob@example.com', 'bob123', 'Coding enthusiast', 70, 3, 12, 'bob_profile.jpg', 'user'),
    ('Eve Davis', 'evedavis', 'eve@example.com', 'password456', 'Loves technology', 90, 6, 18, 'eve_profile.jpg', 'user'),
    ('Charlie Brown', 'charlieb', 'charlie@example.com', 'charlie789', 'Web developer', 120, 8, 25, 'charlie_profile.jpg', 'user'),
    ('Grace Adams', 'gracea', 'grace@example.com', 'securepass', 'AI enthusiast', 110, 7, 22, 'grace_profile.jpg', 'user'),
    ('Sam Wilson', 'samw', 'sam@example.com', 'sam1234', 'Software engineer', 130, 9, 28, 'sam_profile.jpg', 'user');


INSERT INTO Faq (question, answer)
VALUES
    ('What is the purpose of this application?', 'The application helps users find answers to their questions.'),
    ('How do I reset my password?', 'You can reset your password by clicking the "Forgot Password" link on the login page.'),
    ('Is there a mobile app available?', 'Yes, we have a mobile app for both iOS and Android.'),
    ('How can I contact customer support?', 'You can reach our customer support team by emailing support@example.com.'),
    ('What are the system requirements for this application?', 'The system requirements may vary depending on the platform. Please check our website for details.'),
    ('Can I change my username?', 'No, usernames are not changeable after registration.'),
    ('Is there a free trial available?', 'Yes, we offer a 7-day free trial for new users.'),
    ('How can I delete my account?', 'To delete your account, please contact customer support.'),
    ('What payment methods are accepted?', 'We accept Visa, MasterCard, and PayPal for payments.'),
    ('Are there any discounts for students?', 'Yes, we offer a 20% discount for students with a valid ID.'),
    ('How do I change my email address?', 'You can update your email address in the account settings section.'),
    ('What should I do if I forget my username?', 'If you forget your username, please contact our support team for assistance.'),
    ('Is there a referral program?', 'Yes, we have a referral program that offers rewards for referring new users.'),
    ('How do I report a bug or issue?', 'To report a bug or issue, use the "Report a Problem" feature within the application.'),
    ('Can I use the application offline?', 'Some features are available offline, but many require an internet connection.'),
    ('What is the privacy policy?', 'You can find our privacy policy on our website under the "Privacy" section.'),
    ('Are there in-app purchases?', 'Yes, the application offers in-app purchases for premium features and content.'),
    ('Do you have a community forum?', 'Yes, we have an online community forum where users can discuss various topics.'),
    ('How often are updates released?', 'We aim to release regular updates with new features and improvements.'),
    ('Is my data secure?', 'We take data security seriously and use encryption to protect user data.');

INSERT INTO Badge (name, description)
VALUES
    ('Beginner', 'Awarded to users who complete the onboarding process.'),
    ('Contributor', 'Given to users who actively contribute to the community.'),
    ('Expert', 'Awarded to users who demonstrate exceptional knowledge and skills.'),
    ('Supporter', 'Given to users who help others and provide support.'),
    ('Verified', 'Badge for verified user accounts.'),
    ('Top Contributor', 'Awarded to the most active and helpful contributors.'),
    ('Developer', 'For users who contribute to the development of the application.'),
    ('Beta Tester', 'Badge for beta testers who provide valuable feedback.'),
    ('Innovator', 'Given to users with innovative ideas and contributions.'),
    ('Moderator', 'Badge for users who help moderate the community.'),
    ('Loyal User', 'Awarded to long-time users who have been with us for years.'),
    ('Problem Solver', 'Badge for users who consistently provide solutions to complex problems.'),
    ('Early Adopter', 'Given to users who joined during the early stages of the application.'),
    ('Eager Learner', 'For users who actively seek knowledge and self-improvement.'),
    ('Content Creator', 'Badge for users who create valuable content for the community.'),
    ('Expert Moderator', 'Awarded to moderators who excel in maintaining a positive community environment.'),
    ('Frequent Poster', 'Given to users who frequently contribute to discussions and posts.'),
    ('Beta Release Participant', 'Badge for those who participate in testing beta releases.'),
    ('Community Leader', 'For users who lead and organize community events and activities.'),
    ('Mentor', 'Awarded to experienced users who mentor and assist newcomers.');    

INSERT INTO BadgeAttainment (user_id, badge_id, date)
VALUES
    (1, 1, NOW() - INTERVAL '7 days'),
    (2, 1, NOW() - INTERVAL '5 days'),
    (3, 2, NOW() - INTERVAL '10 days'),
    (4, 3, NOW() - INTERVAL '14 days'),
    (5, 2, NOW() - INTERVAL '3 days'),
    (6, 4, NOW() - INTERVAL '8 days'),
    (7, 5, NOW() - INTERVAL '12 days'),
    (8, 6, NOW() - INTERVAL '9 days'),
    (9, 7, NOW() - INTERVAL '6 days'),
    (10, 8, NOW() - INTERVAL '11 days'),
    (1, 4, NOW() - INTERVAL '5 days'),
    (2, 3, NOW() - INTERVAL '8 days'),
    (3, 5, NOW() - INTERVAL '12 days'),
    (4, 6, NOW() - INTERVAL '7 days'),
    (5, 8, NOW() - INTERVAL '10 days'),
    (6, 7, NOW() - INTERVAL '6 days'),
    (7, 9, NOW() - INTERVAL '9 days'),
    (8, 10, NOW() - INTERVAL '11 days'),
    (9, 4, NOW() - INTERVAL '4 days'),
    (10, 3, NOW() - INTERVAL '7 days');    


INSERT INTO UnblockRequest (user_id, title, description)
VALUES
    (1, 'Unblock Request 1', 'I would like to request an unblock for my account.'),
    (2, 'Account Access Request', 'Please unblock my account as I am unable to access it.'),
    (3, 'Need Account Access', 'I need access to my account; please unblock it.'),
    (4, 'Account Unblocking', 'Requesting an unblock for my account.'),
    (5, 'Access Request', 'I cannot access my account; requesting an unblock.'),
    (6, 'Unblock Account', 'Please unblock my account for access.'),
    (7, 'Access Restoration', 'Requesting access restoration for my account.'),
    (8, 'Account Recovery', 'Need assistance recovering my account access.'),
    (9, 'Unblock Request 2', 'I need my account to be unblocked.'),
    (10, 'Access Issue', 'Requesting unblocking of my account for login.'),
    (11, 'Request for Account Access', 'I am locked out of my account and need assistance to regain access.'),
    (12, 'Account Unblock Request', 'Please unblock my account; I am unable to log in.'),
    (13, 'Access Restoration Request', 'I need access to my account urgently; requesting an unblock.'),
    (14, 'Unblock My Account', 'Requesting an unblock for my account as I can\t access it.'),
    (15, 'Access Assistance Needed', 'I require assistance with account unblocking and access recovery.'),
    (16, 'Locked Account Recovery', 'My account is locked; I need help to recover access.'),
    (17, 'Urgent Unblock Request', 'I am facing issues accessing my account; please unblock it.'),
    (18, 'Account Access Issue', 'Requesting an unblock to resolve my account access problem.'),
    (19, 'Access Problem', 'Please unblock my account as I can\t sign in.'),
    (20, 'Account Unlock', 'I need my account unlocked to regain access.');


INSERT INTO Content (user_id, content, votes, reports, date, edited)
VALUES
    (1, 'This is the first post.', 10, 2, NOW() - INTERVAL '2 days', false),
    (2, 'A sample discussion topic.', 15, 1, NOW() - INTERVAL '3 days', true),
    (3, 'An interesting article.', 20, 0, NOW() - INTERVAL '4 days', false),
    (4, 'Question for the community.', 8, 3, NOW() - INTERVAL '5 days', true),
    (5, 'Sharing a helpful tip.', 12, 1, NOW() - INTERVAL '6 days', false),
    (6, 'My thoughts on a topic.', 18, 2, NOW() - INTERVAL '7 days', false),
    (7, 'Discussion about technology.', 14, 4, NOW() - INTERVAL '8 days', true),
    (8, 'A creative piece of content.', 11, 0, NOW() - INTERVAL '9 days', false),
    (9, 'Asking for advice.', 6, 2, NOW() - INTERVAL '10 days', false),
    (10, 'Sharing a coding project.', 17, 1, NOW() - INTERVAL '11 days', true),
    (1, 'Another interesting post.', 13, 1, NOW() - INTERVAL '12 days', false),
    (2, 'Discussion about current events.', 19, 3, NOW() - INTERVAL '13 days', true),
    (3, 'Sharing a new discovery.', 22, 0, NOW() - INTERVAL '14 days', false),
    (4, 'Seeking opinions on a topic.', 9, 2, NOW() - INTERVAL '15 days', true),
    (5, 'A helpful guide for beginners.', 14, 1, NOW() - INTERVAL '16 days', false),
    (6, 'My experience with a project.', 21, 2, NOW() - INTERVAL '17 days', false),
    (7, 'Discussion about travel tips.', 16, 4, NOW() - INTERVAL '18 days', true),
    (8, 'Creative writing piece.', 12, 0, NOW() - INTERVAL '19 days', false),
    (9, 'Seeking recommendations.', 7, 1, NOW() - INTERVAL '20 days', false),
    (10, 'Sharing a recipe.', 20, 1, NOW() - INTERVAL '21 days', true),
    (11, 'Sample content 1', 12, 0, NOW(), false),
    (12, 'Sample content 2', 5, 1, NOW(), true),
    (13, 'Sample content 3', 20, 2, NOW(), false),
    (14, 'Sample content 4', 8, 0, NOW(), false),
    (15, 'Sample content 5', 15, 3, NOW(), false),
    (16, 'Sample content 6', 3, 0, NOW(), true),
    (17, 'Sample content 7', 25, 0, NOW(), false),
    (18, 'Sample content 8', 7, 1, NOW(), true),
    (19, 'Sample content 9', 10, 0, NOW(), false),
    (20, 'Sample content 10', 6, 2, NOW(), false);

INSERT INTO Commentable (content_id)
VALUES
    (1),
    (2),
    (3),
    (4),
    (5),
    (6),
    (7),
    (8),
    (9),
    (10),
    (11),
    (12),
    (13),
    (14),
    (15),
    (16),
    (17),
    (18),
    (19),
    (20),
	(21),
    (22),
    (23),
    (24),
    (25),
    (26),
    (27),
    (28),
    (29),
    (30);   

INSERT INTO Tag (title, description)
VALUES
    ('Science', 'Tags related to various branches of science.'),
    ('Technology', 'Tags associated with technological topics and innovations.'),
    ('Programming', 'Tags for programming languages, coding, and software development.'),
    ('Travel', 'Tags for travel enthusiasts and destinations.'),
    ('Food', 'Tags related to culinary delights and cooking.'),
    ('Art', 'Tags for art lovers and creative expressions.'),
    ('Health', 'Tags related to physical and mental health and wellness.'),
    ('Music', 'Tags for music genres, artists, and musical discussions.'),
    ('Books', 'Tags for book lovers, authors, and literature.'),
    ('Sports', 'Tags for sports, athletes, and athletic events.'),
    ('History', 'Tags related to historical events, periods, and figures.'),
    ('Education', 'Tags for educational topics, schools, and learning resources.'),
    ('Nature', 'Tags for discussions about the natural world and environment.'),
    ('Fashion', 'Tags related to clothing, style, and fashion trends.'),
    ('Photography', 'Tags for photography techniques, equipment, and aesthetics.'),
    ('Gaming', 'Tags for video games, gaming platforms, and gaming culture.'),
    ('Film', 'Tags for movies, film directors, and cinematic discussions.'),
    ('Finance', 'Tags for financial topics, investments, and money management.'),
    ('Environment', 'Tags related to environmental conservation and sustainability.'),
    ('DIY', 'Tags for do-it-yourself projects and creative crafts.');

 

-- might work ALTER TABLE Question DISABLE TRIGGER question_minimum_tag_trigger; broken from here down

INSERT INTO Question (commentable_id, title, correct_answer_id)
VALUES
    (1, 'What is the capital of France?', NULL),
    (2, 'Who wrote "Romeo and Juliet?"', NULL),
    (3, 'What is the atomic number of hydrogen?', NULL),
    (4, 'What is the largest planet in our solar system?',NULL),
    (5, 'What is the boiling point of water in Celsius?', NULL),
    (6, 'What is the formula for the area of a rectangle?', NULL),
    (7, 'What is the tallest mountain in the world?', NULL),
    (8, 'What is the chemical symbol for gold?', NULL),
    (9, 'Who painted the Mona Lisa?', NULL),
    (10, 'What is the primary color of a banana?', NULL),
    (11, 'What is the largest desert in the world?', NULL),
    (12, 'Who is known as the "Father of Modern Physics?"', NULL),
    (13, 'How many continents are there on Earth?', NULL),
    (14, 'What is the chemical symbol for oxygen?', NULL),
    (15, 'Who wrote "To Kill a Mockingbird?"', NULL),
    (16, 'What is the capital of Japan?', NULL),
    (17, 'What is the process of photosynthesis?', NULL),
    (18, 'What is the formula for calculating the area of a circle?', NULL),
    (19, 'Who is the author of "1984?"', NULL),
    (20, 'What is the molecular formula for water?', NULL);  

-- might work ALTER TABLE Question ENABLE TRIGGER question_minimum_tag_trigger;

INSERT INTO QuestionTag (question_id, tag_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8),
    (9, 9),
    (10, 10),
    (11, 11),
    (12, 12),
    (13, 13),
    (14, 14),
    (15, 15),
    (16, 16),
    (17, 17),
    (18, 18),
    (19, 19),
    (20, 20);

INSERT INTO Answer (commentable_id, question_id)
VALUES
    (21, 1),
    (22, 2),
    (23, 3),
    (24, 4),
    (25, 5),
    (26, 6),
    (27, 7),
    (28, 8),
    (29, 9),
    (30, 10),
    (31, 11),
    (32, 12),
    (33, 13),
    (34, 14),
    (35, 15),
    (36, 16),
    (37, 17),
    (38, 18),
    (39, 19),
    (40, 20);       





INSERT INTO Comment (content_id, commentable_id)
VALUES
    (1, 21),
    (2, 22),
    (3, 23),
    (4, 24),
    (5, 25),
    (6, 26),
    (7, 27),
    (8, 28),
    (9, 29),
    (10, 30),
    (11, 21),
    (12, 22),
    (13, 23),
    (14, 24),
    (15, 25),
    (16, 26),
    (17, 27),
    (18, 28),
    (19, 29),
    (20, 30);





INSERT INTO Notification (user_id, date, viewed)
VALUES
    (1, NOW() - INTERVAL '1 day', true),
    (2, NOW() - INTERVAL '2 days', false),
    (3, NOW() - INTERVAL '3 days', true),
    (4, NOW() - INTERVAL '4 days', false),
    (5, NOW() - INTERVAL '5 days', true),
    (6, NOW() - INTERVAL '6 days', false),
    (7, NOW() - INTERVAL '7 days', true),
    (8, NOW() - INTERVAL '8 days', false),
    (9, NOW() - INTERVAL '9 days', true),
    (10, NOW() - INTERVAL '10 days', false),
    (1, NOW() - INTERVAL '11 days', true),
    (2, NOW() - INTERVAL '12 days', false),
    (3, NOW() - INTERVAL '13 days', true),
    (4, NOW() - INTERVAL '14 days', false),
    (5, NOW() - INTERVAL '15 days', true),
    (6, NOW() - INTERVAL '16 days', false),
    (7, NOW() - INTERVAL '17 days', true),
    (8, NOW() - INTERVAL '18 days', false),
    (9, NOW() - INTERVAL '19 days', true),
    (10, NOW() - INTERVAL '20 days', false),
    (1, NOW() - INTERVAL '21 days', true),
    (2, NOW() - INTERVAL '22 days', false),
    (3, NOW() - INTERVAL '23 days', true),
    (4, NOW() - INTERVAL '24 days', false),
    (5, NOW() - INTERVAL '25 days', true),
    (6, NOW() - INTERVAL '26 days', false),
    (7, NOW() - INTERVAL '27 days', true),
    (8, NOW() - INTERVAL '28 days', false),
    (9, NOW() - INTERVAL '29 days', true),
    (10, NOW() - INTERVAL '30 days', false),
    (1, NOW() - INTERVAL '21 days', true),
    (2, NOW() - INTERVAL '22 days', false),
    (3, NOW() - INTERVAL '23 days', true),
    (4, NOW() - INTERVAL '24 days', false),
    (5, NOW() - INTERVAL '25 days', true),
    (6, NOW() - INTERVAL '26 days', false),
    (7, NOW() - INTERVAL '27 days', true),
    (8, NOW() - INTERVAL '28 days', false),
    (9, NOW() - INTERVAL '29 days', true),
    (10, NOW() - INTERVAL '30 days', false);

INSERT INTO AnswerNotification (notification_id, question_id, answer_id)
VALUES
    (10, 10, 10),
    (11, 11, 11),
    (12, 12, 12),
    (13, 13, 13),
    (14, 14, 14),
    (15, 15, 15),
    (16, 16, 16),
    (17, 17, 17),
    (18, 18, 18),
    (19, 19, 19),
    (20, 20, 20);    

INSERT INTO CommentNotification (notification_id, comment_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8),
    (9, 9);

INSERT INTO Report (user_id, content_id)
VALUES
    (1, 11),
    (2, 12),
    (3, 13),
    (4, 14),
    (5, 15),
    (6, 16),
    (7, 17),
    (8, 18),
    (9, 19),
    (10, 10),
    (11, 1),
    (12, 2),
    (13, 3),
    (14, 4),
    (15, 5),
    (16, 6),
    (17, 7),
    (18, 8),
    (19, 9),
    (20, 20);

INSERT INTO Vote (user_id, content_id, vote)
VALUES
    (1, 11, true),
    (2, 12, false),
    (3, 13, true),
    (4, 14, true),
    (5, 15, false),
    (6, 16, true),
    (7, 17, false),
    (8, 18, true),
    (9, 19, true),
    (10, 20, false);      

INSERT INTO VoteNotification (notification_id, user_id, content_id, vote)
VALUES
    (21, 1, 11, true),
    (22, 2, 12, false),
    (23, 3, 13, true),
    (24, 4, 14, true),
    (25, 5, 15, false),
    (26, 6, 16, true),
    (27, 7, 17, false),
    (28, 8, 18, true),
    (29, 9, 19, true),
    (30, 10, 20, false);    

INSERT INTO BadgeAttainmentNotification (notification_id, user_id, badge_id)
VALUES
    (31, 1, 1),
    (32, 2, 2),
    (33, 3, 3),
    (34, 4, 4),
    (35, 5, 5),
    (36, 6, 6),
    (37, 7, 7),
    (38, 8, 8),
    (39, 9, 9),
    (40, 10, 10);

INSERT INTO FollowTag (user_id, tag_id)
VALUES
    (1, 11),
    (2, 12),
    (3, 13),
    (4, 14),
    (5, 15),
    (6, 16),
    (7, 17),
    (8, 18),
    (9, 19),
    (10, 20);

INSERT INTO FollowQuestion (user_id, question_id)
VALUES
    (1, 11),
    (2, 12),
    (3, 13),
    (4, 14),
    (5, 15),
    (6, 16),
    (7, 17),
    (8, 18),
    (9, 19),
    (10, 20);    
