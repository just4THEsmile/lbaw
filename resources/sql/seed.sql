create schema if not exists lbaw2357;

SET DateStyle TO European;

-----------------------------
-- Drop old schema
-----------------------------

DROP TABLE IF EXISTS AppUser CASCADE;
DROP TABLE IF EXISTS Faq CASCADE;
DROP TABLE IF EXISTS Badge CASCADE;
DROP TABLE IF EXISTS BadgeAttainment CASCADE;
DROP TABLE IF EXISTS UnblockRequest CASCADE;
DROP TABLE IF EXISTS Content CASCADE;
DROP TABLE IF EXISTS Commentable CASCADE;
DROP TABLE IF EXISTS Question CASCADE;
DROP TABLE IF EXISTS Answer CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS Tag CASCADE;
DROP TABLE IF EXISTS QuestionTag CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;
DROP TABLE IF EXISTS AnswerNotification CASCADE;
DROP TABLE IF EXISTS CommentNotification CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Vote CASCADE;
DROP TABLE IF EXISTS VoteNotification CASCADE;
DROP TABLE IF EXISTS BadgeAttainmentNotification CASCADE;
DROP TABLE IF EXISTS FollowTag CASCADE;
DROP TABLE IF EXISTS FollowQuestion CASCADE;

DROP FUNCTION IF EXISTS enforce_vote() CASCADE;
DROP FUNCTION IF EXISTS delete_content() CASCADE;
DROP FUNCTION IF EXISTS select_correct_answer() CASCADE;
DROP FUNCTION IF EXISTS update_nquestion() CASCADE;
DROP FUNCTION IF EXISTS update_nanswer() CASCADE;
DROP FUNCTION IF EXISTS update_content_votes() CASCADE;
DROP FUNCTION IF EXISTS delete_content_votes() CASCADE;
DROP FUNCTION IF EXISTS update_points() CASCADE;
DROP FUNCTION IF EXISTS add_beginner_badge() CASCADE;
DROP FUNCTION IF EXISTS add_novice_badge_to_new_user() CASCADE;
DROP FUNCTION IF EXISTS add_expert_badge() CASCADE;
DROP FUNCTION IF EXISTS add_admin_badge() CASCADE;
DROP FUNCTION IF EXISTS generate_answer_notification() CASCADE;
DROP FUNCTION IF EXISTS generate_comment_notification() CASCADE;
DROP FUNCTION IF EXISTS prevent_self_vote() CASCADE;
DROP FUNCTION IF EXISTS prevent_duplicate_reports() CASCADE;

DROP FUNCTION IF EXISTS tag_search_update() CASCADE;
DROP FUNCTION IF EXISTS question_search_update() CASCADE;
DROP FUNCTION IF EXISTS user_search_update() CASCADE;

DROP DOMAIN IF EXISTS Today;

-----------------------------
-- Domains
-----------------------------

CREATE DOMAIN Today AS TIMESTAMP DEFAULT now();

-----------------------------
-- Tables
-----------------------------

CREATE TABLE AppUser (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    username VARCHAR UNIQUE,
    email VARCHAR UNIQUE,
    password VARCHAR,
    bio TEXT,
    points INTEGER CHECK (points >= 0) DEFAULT 0,
    nquestion INTEGER CHECK (nquestion >= 0) DEFAULT 0,
    nanswer INTEGER CHECK (nanswer >= 0) DEFAULT 0,
    profilepicture VARCHAR,
    paylink VARCHAR UNIQUE,
    usertype VARCHAR NOT NULL CHECK (usertype IN ('user', 'moderator', 'admin')),
    remember_token VARCHAR
);

CREATE TABLE Faq (
    id SERIAL PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL
);


CREATE TABLE Badge (
    id SERIAL PRIMARY KEY,
    name VARCHAR UNIQUE NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE BadgeAttainment (
    user_id INTEGER,
    badge_id INTEGER,
    date TIMESTAMP NOT NULL CHECK (date <= now()),
    PRIMARY KEY (user_id, badge_id),
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (badge_id) REFERENCES Badge(id)
);

CREATE TABLE UnblockRequest (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    title VARCHAR NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES AppUser(id)
);

CREATE TABLE Content (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    votes INTEGER DEFAULT 0,
    reports INTEGER CHECK (reports >= 0) DEFAULT 0,
    date TIMESTAMP NOT NULL CHECK (date <= now()) DEFAULT now(),
    edited BOOLEAN DEFAULT false,
    deleted BOOLEAN DEFAULT false,
    blocked BOOLEAN DEFAULT false,
    FOREIGN KEY (user_id) REFERENCES AppUser(id)
);

CREATE TABLE Commentable (
    id INTEGER PRIMARY KEY,
    FOREIGN KEY (id) REFERENCES Content(id)
);

CREATE TABLE Question (
    id INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    correct_answer_id INTEGER,
    FOREIGN KEY (id) REFERENCES Commentable(id)
);

CREATE TABLE Answer (
    id INTEGER PRIMARY KEY,
    question_id INTEGER NOT NULL,
    FOREIGN KEY (id) REFERENCES Commentable(id),
    FOREIGN KEY (question_id) REFERENCES Question(id)
);

CREATE TABLE Comment (
    id INTEGER,
    commentable_id INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Content(id),
    FOREIGN KEY (commentable_id) REFERENCES Commentable(id)
);

CREATE TABLE Tag (
    id SERIAL PRIMARY KEY,
    title VARCHAR UNIQUE NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE QuestionTag (
    question_id INTEGER,
    tag_id INTEGER,
    PRIMARY KEY (question_id, tag_id),
    FOREIGN KEY (question_id) REFERENCES Question(id),
    FOREIGN KEY (tag_id) REFERENCES Tag(id)
);

CREATE TABLE Notification (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    date TIMESTAMP NOT NULL CHECK (date <= now()) DEFAULT now(),
    viewed BOOLEAN DEFAULT false,
    FOREIGN KEY (user_id) REFERENCES AppUser(id)
);

CREATE TABLE AnswerNotification (
    notification_id INTEGER PRIMARY KEY,
    question_id INTEGER NOT NULL,
    answer_id INTEGER NOT NULL,
    FOREIGN KEY (notification_id) REFERENCES Notification(id),
    FOREIGN KEY (question_id) REFERENCES Question(id),
    FOREIGN KEY (answer_id) REFERENCES Answer(id)
);

CREATE TABLE CommentNotification (
    notification_id INTEGER PRIMARY KEY,
    comment_id INTEGER NOT NULL,
    FOREIGN KEY (notification_id) REFERENCES Notification(id),
    FOREIGN KEY (comment_id) REFERENCES Comment(id)
);

CREATE TABLE Report (
    user_id INTEGER NOT NULL,
    content_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, content_id),
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (content_id) REFERENCES Content(id)
);

CREATE TABLE Vote (
    user_id INTEGER NOT NULL,
    content_id INTEGER NOT NULL,
    vote BOOLEAN NOT NULL,
    PRIMARY KEY (user_id, content_id),
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (content_id) REFERENCES Content(id)
);
-- delete notification when vote is changed
CREATE TABLE VoteNotification (
    notification_id INTEGER,
    user_id INTEGER,
    content_id INTEGER,
    vote BOOLEAN NOT NULL,
    PRIMARY KEY (notification_id),
    FOREIGN KEY (notification_id) REFERENCES Notification(id),
    FOREIGN KEY (user_id,content_id) REFERENCES Vote(user_id, content_id)
);

CREATE TABLE BadgeAttainmentNotification (
    notification_id INTEGER,
    user_id INTEGER,
    badge_id INTEGER,
    PRIMARY KEY (notification_id, user_id, badge_id),
    FOREIGN KEY (notification_id) REFERENCES Notification(id),
    FOREIGN KEY (user_id, badge_id) REFERENCES BadgeAttainment(user_id, badge_id)
);

CREATE TABLE FollowTag (
    user_id INTEGER,
    tag_id INTEGER,
    PRIMARY KEY (user_id, tag_id),
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (tag_id) REFERENCES Tag(id) -- or Tag(id) depending on your database structure
);

CREATE TABLE FollowQuestion (
    id SERIAL PRIMARY KEY,
    user_id INTEGER,
    question_id INTEGER,
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (question_id) REFERENCES Question(id)
);

ALTER TABLE Question
  ADD FOREIGN KEY (correct_answer_id) REFERENCES answer(id) ON UPDATE CASCADE;

-----------------------------
-- TRIGGERS
-----------------------------

CREATE FUNCTION enforce_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT 1
        FROM Vote
        WHERE user_id = NEW.user_id AND content_id = NEW.content_id
    ) THEN
        DELETE FROM Vote
        WHERE user_id = NEW.user_id AND content_id = NEW.content_id;
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER enforce_vote_trigger
BEFORE INSERT ON Vote
FOR EACH ROW
EXECUTE PROCEDURE enforce_vote();


CREATE FUNCTION update_nanswer() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE AppUser
	SET nanswer = nanswer + 1
		WHERE id = (
			SELECT Content.user_id
			FROM Answer
			JOIN Commentable ON Answer.id = Commentable.id
			JOIN Content ON Commentable.id = Content.id
			WHERE Answer.id = new.id
		);
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_nanswer_trigger
AFTER INSERT OR UPDATE ON Answer
FOR EACH ROW
EXECUTE PROCEDURE update_nanswer();



CREATE FUNCTION update_nquestion() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE AppUser
		SET nquestion = nquestion + 1
		WHERE id = (
			SELECT Content.user_id
			FROM Question
			JOIN Commentable ON Question.id = Commentable.id
			JOIN Content ON Commentable.id = Content.id
			WHERE Question.id = new.id
		);
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_nquestion_trigger
AFTER INSERT OR UPDATE ON Question
FOR EACH ROW
EXECUTE PROCEDURE update_nquestion();



CREATE FUNCTION delete_content() RETURNS TRIGGER AS 
$BODY$
BEGIN
    DECLARE
        report_count INTEGER;
        vote_count INTEGER;
    BEGIN
        SELECT COUNT(*)
        INTO report_count
        FROM Report
        WHERE content_id = NEW.content_id;

        SELECT COUNT(*) 
        INTO vote_count
        FROM Vote
        WHERE content_id = NEW.content_id AND vote = TRUE;

        IF report_count >= 5 + vote_count/4 THEN
            UPDATE Content
            SET blocked = TRUE
            WHERE id = NEW.content_id;
        END IF;
    END;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_content_trigger
AFTER INSERT ON Report
FOR EACH ROW
EXECUTE PROCEDURE delete_content();


/*
CREATE FUNCTION select_correct_answer() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF NEW.user_id <> OLD.user_id THEN
        RAISE EXCEPTION 'Only the creator of the question can select the correct answer.';
    END IF;

    IF NEW.correct_answer_id IS NOT NULL THEN
        RAISE EXCEPTION 'The question already has a correct answer.';
    END IF;

    IF NOT EXISTS (
        SELECT 1
        FROM Answer
        WHERE question_id = NEW.question_id
        AND answer_id = NEW.correct_answer_id
    ) THEN
        RAISE EXCEPTION 'The selected correct answer is not part of the answers of the question must.';
    END IF;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER select_correct_answer_trigger
BEFORE UPDATE ON Commentable
FOR EACH ROW
EXECUTE PROCEDURE select_correct_answer();
*/





CREATE FUNCTION update_content_votes() RETURNS TRIGGER AS
$BODY$
BEGIN
    -- Calculate the total votes for the content and update the votes column
    UPDATE Content
    SET votes = (
        SELECT COUNT(*)
        FROM Vote
        WHERE content_id = NEW.content_id AND vote = TRUE
    ) - (
        SELECT COUNT(*)
        FROM Vote
        WHERE content_id = NEW.content_id AND vote = FALSE
    )
    WHERE id = NEW.content_id;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_content_votes_trigger
AFTER INSERT OR UPDATE ON Vote
FOR EACH ROW
EXECUTE PROCEDURE update_content_votes();



CREATE FUNCTION delete_content_votes() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE Content
    SET votes = (
        SELECT COUNT(*)
        FROM Vote
        WHERE content_id = OLD.content_id AND vote = TRUE
    ) - (
        SELECT COUNT(*)
        FROM Vote
        WHERE content_id = OLD.content_id AND vote = FALSE
    )
    WHERE id = OLD.content_id;

    RETURN OLD;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_content_votes_trigger
AFTER DELETE ON Vote
FOR EACH ROW
EXECUTE PROCEDURE delete_content_votes();



CREATE FUNCTION update_points() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE AppUser
    SET points = (
        SELECT CASE
            WHEN SUM(votes) < 0 THEN 0
            ELSE SUM(votes)
        END
        FROM Content
        WHERE id = NEW.id
    )
    WHERE id = NEW.user_id;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_points_trigger
AFTER INSERT OR UPDATE ON Content
FOR EACH ROW
EXECUTE PROCEDURE update_points();



CREATE FUNCTION add_beginner_badge() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.points >= 5 AND NOT EXISTS (
        SELECT 1
        FROM BadgeAttainment
        WHERE user_id = NEW.id AND badge_id = 2
    ) THEN
        INSERT INTO BadgeAttainment (user_id, badge_id, date)
        VALUES (NEW.id, 2, now());
    END IF;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_beginner_badge_trigger
AFTER UPDATE ON AppUser
FOR EACH ROW
EXECUTE PROCEDURE add_beginner_badge();


CREATE FUNCTION add_novice_badge_to_new_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM BadgeAttainment
        WHERE user_id = NEW.id AND badge_id = 1
    ) THEN
        INSERT INTO BadgeAttainment (user_id, badge_id, date)
        VALUES (NEW.id, 1, now());
    END IF;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_novice_badge_to_new_user_trigger
AFTER INSERT ON AppUser
FOR EACH ROW
EXECUTE PROCEDURE add_novice_badge_to_new_user();






CREATE FUNCTION add_expert_badge() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.points >= 200 AND NOT EXISTS (
        SELECT 1
        FROM BadgeAttainment
        WHERE user_id = NEW.id AND badge_id = 3
    ) THEN
        INSERT INTO BadgeAttainment (user_id, badge_id, date)
        VALUES (NEW.id, 3, now());
    END IF;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_expert_badge_trigger
AFTER UPDATE ON AppUser
FOR EACH ROW
EXECUTE PROCEDURE add_expert_badge();

CREATE FUNCTION add_admin_badge() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.usertype = 'admin' AND NOT EXISTS (
        SELECT 1
        FROM BadgeAttainment
        WHERE user_id = NEW.id AND badge_id = 8
    ) THEN
        INSERT INTO BadgeAttainment (user_id, badge_id, date)
        VALUES (NEW.id, 8, now());
    END IF;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_admin_badge_trigger
AFTER INSERT ON AppUser
FOR EACH ROW
EXECUTE PROCEDURE add_admin_badge();


/*
CREATE FUNCTION generate_answer_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    question_author_id INTEGER;
BEGIN
    -- Get the author of the question
    SELECT user_id INTO question_author_id
    FROM Content
    WHERE id = (
        SELECT id
        FROM Answer
        WHERE id = NEW.id
    );

    -- Insert a new notification for the question author
    INSERT INTO Notification (user_id, date)
    VALUES (question_author_id, now());

    -- Insert a new answer notification for the notification
    INSERT INTO AnswerNotification (notification_id, answer_id)
    VALUES (currval('notification_id_seq'), NEW.id);

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER generate_answer_notification_trigger
AFTER INSERT ON Answer
FOR EACH ROW
EXECUTE PROCEDURE generate_answer_notification();*/

/*
CREATE FUNCTION generate_comment_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    answer_author_id INTEGER;
BEGIN
    -- Check if the commentable_id is for an answer
    IF NEW.commentable_id IN (SELECT id FROM Answer) THEN
        -- Get the author of the answer
        SELECT user_id
        FROM Content
        JOIN Answer ON Answer.id = Content.id
        WHERE Answer.id = NEW.commentable_id;

        -- Insert a new notification for the answer author
        INSERT INTO Notification (user_id, date)
        VALUES (answer_author_id, CURRENT_DATE);

        -- Insert a new comment notification for the notification
        INSERT INTO CommentNotification (notification_id, comment_id)
        VALUES (currval('notification_id_seq'), NEW.content_id);
    END IF;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER generate_comment_notification_trigger
AFTER INSERT ON Comment
FOR EACH ROW
EXECUTE PROCEDURE generate_comment_notification();
*/

CREATE FUNCTION prevent_self_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.user_id = (
        SELECT user_id
        FROM Content
        WHERE id = NEW.content_id
    ) THEN
        RAISE EXCEPTION 'A user cannot vote their own content';
    END IF;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER prevent_self_vote_trigger
BEFORE INSERT ON Vote
FOR EACH ROW
EXECUTE PROCEDURE prevent_self_vote();


CREATE FUNCTION prevent_duplicate_reports() RETURNS TRIGGER AS $$
BEGIN

    IF NEW.user_id = (
        SELECT user_id FROM Content WHERE id = NEW.content_id
    ) THEN
        RAISE EXCEPTION 'A user cannot report their own content';
    END IF;

    IF EXISTS (
        SELECT 1 FROM Report
        WHERE user_id = NEW.user_id AND content_id = NEW.content_id
    ) THEN
        RAISE EXCEPTION 'This user has already reported this content';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_duplicate_reports_trigger
BEFORE INSERT ON Report
FOR EACH ROW
EXECUTE PROCEDURE prevent_duplicate_reports();

/*
CREATE FUNCTION question_minimum_tag() RETURNS TRIGGER AS
$BODY$
BEGIN
    -- Checks if the question has one tag at minimum
    IF NOT EXISTS (
        SELECT 1
        FROM QuestionTag
        WHERE question_id = NEW.commentable_id
    ) THEN
        RAISE EXCEPTION 'A question must have at least one tag.';
    END IF;
    
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER question_minimum_tag_trigger
BEFORE INSERT OR UPDATE ON Question
FOR EACH ROW
EXECUTE PROCEDURE question_minimum_tag();
*/



--Populate

INSERT INTO Badge (name, description)
VALUES
    ('Novice', 'Awarded to users who complete the onboarding process.'),
    ('Beginner', 'Given to users who actively contribute to the community.'),
    ('Expert', 'Awarded to users who demonstrate exceptional knowledge and skills.'),
    ('Supporter', 'Given to users who help others and provide support.'),
    ('Verified', 'Badge for verified user accounts.'),
    ('Top Contributor', 'Awarded to the most active and helpful contributors.'),
    ('Developer', 'For users who contribute to the development of the application.'),
    ('Admin', 'Badge for administrator of the application.'),
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



INSERT INTO AppUser (name, username, email, password, bio, profilepicture, usertype)
VALUES
    ('Linda Johnson', 'pintailclowder', 'linda@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Art lover', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Michael Wilson', 'jerkdunnock', 'michael@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Gamer and programmer', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Sarah Brown', 'lastrada', 'sarah@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Graphic designer', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Tom Adams', 'croissant', 'tom@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Musician and songwriter', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Olivia Smith', 'tornado', 'olivia@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Nature enthusiast', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('David White', 'hanggliding', 'david@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Science lover', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Emily Clark', 'grapefruit', 'emily@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Traveler and photographer', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('William Harris', 'williamh', 'william@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Bookworm', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Mia Turner', 'hydra', 'mia@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Foodie and chef', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Daniel Martin', 'sn1987a', 'dan@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Fitness enthusiast', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('John Doe', 'prune', 'john@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'I love coding!', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Jane Smith', 'cattylover', 'jane@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Tech enthusiast', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Admin User','Admin' , 'admin@example.com', '$2y$10$ONfUdIrLOFfApp4VSIFvBOZL/ViR2t0HdbPa9xQmrsqvaAZtMVf2y', 'Administrator', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'admin'),
    ('Moderator User', 'moderator', 'moderator@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Moderator', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'moderator'),
    ('Alice Johnson', 'cabbage', 'alice@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Curious learner', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Bob Smith', 'pelican', 'bob@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Coding enthusiast', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Eve Davis', 'evedavis', 'eve@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Loves technology', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Charlie Brown', 'charlieb', 'charlie@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Web developer', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Grace Adams', 'SERMATIc', 'grace@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'AI enthusiast', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Sam Wilson', 'swEtterDock', 'sam@example.com', '$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2', 'Software engineer', 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png', 'user'),
    ('Rodrigo','Dragon29R','dragon29r@gmail.com','$2y$10$qnxRFeh6f3qrNzMsSbmecO7xMp0OUyqVoOib/CoU3BpvsE3duH5N2','eu gosto de jogar','KUeBmxZ5csM5NZpcgv2g7dds2uKeE7NGVEZIvTKx.jpg','admin');

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


INSERT INTO BadgeAttainment (user_id, badge_id, date)
VALUES
    (3, 2, NOW() - INTERVAL '10 days'),
    (4, 3, NOW() - INTERVAL '14 days'),
    (5, 2, NOW() - INTERVAL '3 days'),
    (6, 4, NOW() - INTERVAL '8 days'),
    (7, 5, NOW() - INTERVAL '12 days'),
    (8, 6, NOW() - INTERVAL '9 days'),
    (9, 7, NOW() - INTERVAL '6 days'),
    (1, 4, NOW() - INTERVAL '5 days'),
    (2, 3, NOW() - INTERVAL '8 days'),
    (3, 5, NOW() - INTERVAL '12 days'),
    (4, 6, NOW() - INTERVAL '7 days'),
    (6, 7, NOW() - INTERVAL '6 days'),
    (7, 9, NOW() - INTERVAL '9 days'),
    (8, 10, NOW() - INTERVAL '11 days'),
    (9, 4, NOW() - INTERVAL '4 days'),
    (10, 3, NOW() - INTERVAL '7 days'),
    (21, 7, NOW());    


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

INSERT INTO Content (user_id, content, votes, date, edited)
VALUES
    (1, 'France is famous for its cultural heritage and diverse cities. Often, visitors might encounter this question when faced with numerous French cities beauty and significance, not always immediately recognizing which city is the capital like Marseille, Lyon, and Nice.', 10,  NOW() - INTERVAL '2 days', false),
    (2, 'Romeo and Juliet, a timeless tragedy, has been part of various educational curricula and pop culture references.', 15, NOW() - INTERVAL '3 days', true),
    (3, 'The concept of atomic numbers is fundamental in understanding the arrangement of elements in the periodic table and their properties. Hydrogens atomic number signifies its significance as the simplest element.', 20,  NOW() - INTERVAL '4 days', false),
    (4, 'The vastness and intriguing features of Jupiter, including its moons and atmospheric phenomena, make it a fascinating subject for astronomical studies.', 8,  NOW() - INTERVAL '5 days', true),
    (5, 'Knowing the boiling point of water in Celsius aids in understanding basic principles of thermodynamics and has practical implications in various industries and everyday life.', 12,  NOW() - INTERVAL '6 days', false),
    (6, 'The geometric concepts related to finding the area of shapes, such as a rectangle, are fundamental in mathematical studies and real-world applications.', 18,  NOW() - INTERVAL '7 days', false),
    (7, 'The challenges associated with climbing Mount Everest and its significance in the realm of mountaineering and adventure draw attention to this question.', 14,  NOW() - INTERVAL '8 days', true),
    (8, 'Understanding chemical symbols contributes to scientific literacy and the understanding of elements and their properties, including the historical significance of gold.', 11,  NOW() - INTERVAL '9 days', false),
    (9, 'Appreciating the artistic mastery and historical context of the Mona Lisa requires knowledge of the renowned artist, Leonardo da Vinci, and his contributions to the art world.', 6,  NOW() - INTERVAL '10 days', false),
    (10, 'The visual changes in bananas as they ripen offer insights into fruit maturation processes and consumer preferences based on color.', 17, NOW() - INTERVAL '11 days', true),
    (1, 'Understanding how deserts are defined and categorized leads to discussions about the unique characteristics of the Antarctic Desert and its distinct environment.', 13, NOW() - INTERVAL '12 days', false),
    (2, 'Acknowledging the pivotal role of Albert Einstein in revolutionizing physics and shaping our understanding of the universe is crucial to the study of modern science.', 19, NOW() - INTERVAL '13 days', true),
    (3, 'The criteria used to define continents can lead to discussions about geographical, cultural, and geological perspectives.', 22, NOW() - INTERVAL '14 days', false),
    (4, 'The chemical representation of oxygen is significant in understanding its role in sustaining life and various chemical reactions.', 9, NOW() - INTERVAL '15 days', true),
    (5, 'Harper Lees novel "To Kill a Mockingbird" explores social issues and moral growth, making it an essential part of literary discussions and cultural reflections.', 14, NOW() - INTERVAL '16 days', false),
    (6, 'Exploring Tokyos blend of tradition and modernity provides insights into Japans culture, technology, and global significance.', 21, NOW() - INTERVAL '17 days', false),
    (7, 'Understanding photosynthesis involves the complex biochemical mechanisms crucial for sustaining life on Earth and the interconnectedness of organisms.', 16, NOW() - INTERVAL '18 days', true),
    (8, 'The mathematical formula for determining the area of a circle plays a role in various fields, including engineering, physics, and mathematics.', 12, NOW() - INTERVAL '19 days', false),
    (9, 'George Orwells dystopian novel "1984" raises significant questions about government surveillance, individual freedom, and societal control.', 7, NOW() - INTERVAL '20 days', false),
    (10, 'Exploring the molecular structure of water provides insights into its unique properties and importance in sustaining life.', 20, NOW() - INTERVAL '21 days', true),
    (11, 'Exploring the natural ripening process of bananas and their changing colors, from green to yellow to brown, serves as an example of chemical reactions and consumer preferences.', 12, NOW(), false),
    (12, 'The classification of the Antarctic Desert as the largest in the world leads to discussions about the diverse characteristics of deserts beyond arid sandy landscapes.', 5,  NOW(), true),
    (13, 'This question revolves around the serendipitous discovery of penicillin by Alexander Fleming in 1928, marking a significant milestone in the history of medicine and the development of antibiotics.', 2000,  NOW(), false),
    (14, 'What is your favorite book/movie/TV show and why?', 8, NOW(), false),
    (15, 'What are some ways to overcome writers block and find inspiration?', 15, NOW(), false),
    (16, 'What are your thoughts on the impact of social media on mental health?', 3, NOW(), true),
    (17, 'What are some must-read books for personal growth and self-improvement?', 25, NOW(), false),
    (18, 'How do you manage work-life balance and prevent burnout?', 7, NOW(), true),
    (19, 'What are some effective techniques for staying motivated and achieving goals?', 10, NOW(), false),
    (20, 'Share your favorite recipe for a homemade meal or dessert!', 6,  NOW(), false),
    (21, 'Vincent van Gogh created the iconic painting "Starry Night," showcasing his unique style and emotional expression in art.', 15,  NOW(), false);

INSERT INTO Commentable (id)
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
    (30),
    (31);   

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

INSERT INTO Question (id, title, correct_answer_id)
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

INSERT INTO Answer (id, question_id)
VALUES
    (21, 1),
    (22, 1),
    (23, 1),
    (24, 2),
    (25, 2),
    (26, 6),
    (27, 7),
    (28, 8),
    (29, 9),
    (30, 10),
    (31,10);
      





INSERT INTO Comment (id, commentable_id)
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

    (12, 12, 22),
    (13, 13, 23),
    (14, 14, 24),
    (15, 15, 25),
    (16, 16, 26),
    (17, 17, 27),
    (18, 18, 28),
    (19, 19, 29),
    (20, 20, 30);  
   

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
    (1, 2),
    (2, 3),
    (3, 4),
    (4, 5),
    (5, 6),
    (6, 7),
    (7, 8),
    (8, 9),
    (9, 10),
    (10, 11),
    (11, 12),
    (12, 13),
    (13, 14),
    (14, 15),
    (15, 16),
    (16, 17),
    (17, 18),
    (18, 19),
    (19, 20),
    (20, 1);

INSERT INTO Vote (user_id, content_id, vote)
VALUES
    (1, 10, true),
    (2, 11, false),
    (3, 12, true),
    (4, 13, true),
    (5, 14, false),
    (6, 15, true),
    (7, 16, false),
    (8, 17, true),
    (9, 18, true),
    (10, 19, false);      

INSERT INTO VoteNotification (notification_id, user_id, content_id, vote)
VALUES
    (21, 1, 10, true),
    (22, 2, 11, false),
    (23, 3, 12, true),
    (24, 4, 13, true),
    (25, 5, 14, false),
    (26, 6, 15, true),
    (28, 8, 17, true),
    (29, 9, 18, true),
    (30, 10, 19, false);    

INSERT INTO BadgeAttainmentNotification (notification_id, user_id, badge_id)
VALUES
    (31, 1, 1),
    (32, 2, 1),
    (33, 3, 2),
    (34, 4, 3),
    (35, 5, 2),
    (36, 6, 4),
    (37, 7, 5),
    (38, 8, 10),
    (39, 9, 4),
    (40, 10, 3);

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
    (10, 20),
    (21,20);    


-----------------------------
-- Indexes
-----------------------------

CREATE INDEX notification_user ON Notification USING btree(id);
CLUSTER Notification USING notification_user;

CREATE INDEX comment_commentable ON Comment USING btree(commentable_id);
CLUSTER Comment USING comment_commentable;

CREATE INDEX appuser_content ON Content USING btree(id);
CLUSTER Content USING appuser_content;


-----------------------------
-- Full Text Search Indexes
-----------------------------

-- Add column to work to store computed ts_vectors.
ALTER TABLE Tag
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
    CREATE FUNCTION tag_search_update() RETURNS TRIGGER AS $$
    BEGIN
    IF TG_OP = 'INSERT' THEN
            NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.title), 'A') ||
            setweight(to_tsvector('english', NEW.description), 'B')
            );
    END IF;
    IF TG_OP = 'UPDATE' THEN
            IF (NEW.title <> OLD.title OR NEW.description <> OLD.description) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.title), 'A') ||
                setweight(to_tsvector('english', NEW.description), 'B')
            );
            END IF;
    END IF;
    RETURN NEW;
    END $$
    LANGUAGE plpgsql;

    -- Create a trigger before insert or update on work.
    CREATE TRIGGER tag_search_update
    BEFORE INSERT OR UPDATE ON Tag
    FOR EACH ROW
    EXECUTE PROCEDURE tag_search_update();


    -- Finally, create a GIN index for ts_vectors.
    CREATE INDEX Tag_search_idx ON Tag USING GIN (tsvectors);



-- Add column to work to store computed ts_vectors.
ALTER TABLE Question
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION question_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors =to_tsvector('english', NEW.title);

 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title) THEN
           NEW.tsvectors =to_tsvector('english', NEW.title);

         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on work.
CREATE TRIGGER question_search_update
 BEFORE INSERT OR UPDATE ON Question
 FOR EACH ROW
 EXECUTE PROCEDURE question_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX Question_search_idx ON Question USING GIN (tsvectors);



-- Add column to work to store computed ts_vectors.
ALTER TABLE AppUser
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
    CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
    BEGIN
    IF TG_OP = 'INSERT' THEN
            NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.name), 'A') ||
            setweight(to_tsvector('english', NEW.username), 'B')
            );
    END IF;
    IF TG_OP = 'UPDATE' THEN
            IF (NEW.name <> OLD.name OR NEW.username <> OLD.username) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.name), 'A') ||
                setweight(to_tsvector('english', NEW.username), 'B')
            );
            END IF;
    END IF;
    RETURN NEW;
    END $$
    LANGUAGE plpgsql;

-- Create a trigger before insert or update on work.
CREATE TRIGGER user_search_update
 BEFORE INSERT OR UPDATE ON AppUser
 FOR EACH ROW
 EXECUTE PROCEDURE user_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX User_search_idx ON AppUser USING GIN (tsvectors);