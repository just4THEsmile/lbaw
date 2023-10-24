create schema if not exists lbaw2357;

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
DROP TABLE IF EXISTS Tags CASCADE;
DROP TABLE IF EXISTS QuestionTags CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;
DROP TABLE IF EXISTS AnswerNotification CASCADE;
DROP TABLE IF EXISTS CommentNotification CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Vote CASCADE;


CREATE TABLE AppUser (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    username VARCHAR UNIQUE NOT NULL,
    email VARCHAR UNIQUE NOT NULL,
    password VARCHAR NOT NULL,
    bio TEXT,
    points INTEGER CHECK (points >= 0) DEFAULT 0,
    nquestion INTEGER CHECK (nquestion >= 0) DEFAULT 0,
    nanswer INTEGER CHECK (nanswer >= 0) DEFAULT 0,
    profilepicture VARCHAR,
    paylink VARCHAR UNIQUE
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
    date DATE NOT NULL,
    PRIMARY KEY (user_id, badge_id),
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (badge_id) REFERENCES Badge(id),
    CHECK (date <= CURRENT_DATE)
);

CREATE TABLE UnblockRequest (
    id1 SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    title VARCHAR NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES AppUser(id)
);

CREATE TABLE Content (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    reports INTEGER CHECK (reports >= 0) DEFAULT 0,
    date DATE NOT NULL CHECK (date <= CURRENT_DATE),
    edited BOOLEAN DEFAULT false,
    FOREIGN KEY (user_id) REFERENCES AppUser(id)
);

CREATE TABLE Commentable (
    content_id INTEGER PRIMARY KEY,
    FOREIGN KEY (content_id) REFERENCES Content(id)
);

CREATE TABLE Question (
    commentable_id INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    votes INTEGER DEFAULT 0,
    correct_answer_id INTEGER,
    FOREIGN KEY (commentable_id) REFERENCES Content(id)
);

CREATE TABLE Answer (
    commentable_id INTEGER PRIMARY KEY,
    question_id INTEGER NOT NULL,
    votes INTEGER DEFAULT 0,
    FOREIGN KEY (commentable_id) REFERENCES Content(id),
    FOREIGN KEY (question_id) REFERENCES Question(commentable_id)
);

CREATE TABLE Comment (
    content_id INTEGER,
    commentable_id INTEGER NOT NULL,
    PRIMARY KEY (content_id),
    FOREIGN KEY (content_id) REFERENCES Content(id),
    FOREIGN KEY (commentable_id) REFERENCES Commentable(content_id)
);

CREATE TABLE Tags (
    id SERIAL PRIMARY KEY,
    title VARCHAR UNIQUE NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE QuestionTags (
    question_id INTEGER,
    tag_id INTEGER,
    PRIMARY KEY (question_id, tag_id),
    FOREIGN KEY (question_id) REFERENCES Question(commentable_id),
    FOREIGN KEY (tag_id) REFERENCES Tags(id)
);

CREATE TABLE Notification (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    date DATE NOT NULL CHECK (date <= CURRENT_DATE),
    viewed BOOLEAN DEFAULT false,
    FOREIGN KEY (user_id) REFERENCES AppUser(id)
);

CREATE TABLE AnswerNotification (
    notification_id INTEGER PRIMARY KEY,
    question_id INTEGER NOT NULL,
    answer_id INTEGER NOT NULL,
    FOREIGN KEY (notification_id) REFERENCES Notification(id),
    FOREIGN KEY (question_id) REFERENCES Question(commentable_id),
    FOREIGN KEY (answer_id) REFERENCES Answer(commentable_id)
);

CREATE TABLE CommentNotification (
    notification_id INTEGER PRIMARY KEY,
    comment_id INTEGER NOT NULL,
    FOREIGN KEY (notification_id) REFERENCES Notification(id),
    FOREIGN KEY (comment_id) REFERENCES Comment(content_id)
);

CREATE TABLE Report (
    user_id INTEGER NOT NULL,
    comment_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, comment_id),
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (comment_id) REFERENCES Comment(content_id)
);

CREATE TABLE Vote (
    user_id INTEGER NOT NULL,
    content_id INTEGER NOT NULL,
    vote BOOLEAN NOT NULL,
    PRIMARY KEY (user_id, content_id),
    FOREIGN KEY (user_id) REFERENCES AppUser(id),
    FOREIGN KEY (content_id) REFERENCES Content(id)
);

ALTER TABLE Question
  ADD FOREIGN KEY (correct_answer_id) REFERENCES answer(commentable_id) ON UPDATE CASCADE;
  