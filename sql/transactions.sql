--Transaction TRAN01
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

--Insert Content
INSERT INTO Content (user_id, content, date)
 VALUES ($user_id, $content ,  now());


-- Insert commentable
INSERT INTO Commentable (content_id)
 VALUES (currval('content_id_seq'));

-- Insert question
INSERT INTO Question (commentable_id, title,correct_answer_id)
 VALUES (currval('content_id_seq'), $title,NULL);

END TRANSACTION;

--Transaction TRAN02

BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

--Insert Content
INSERT INTO Content (user_id, content, date)
 VALUES ($user_id, $content ,  now());


-- Insert commentable
INSERT INTO Commentable (content_id)
 VALUES (currval('insert_answer_seq'));

-- Insert Answer
INSERT INTO Answer (id_commentable)
 VALUES (currval('insert_answer_seq'));

END TRANSACTION;

--Transaction TRAN03

BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

--Insert Content
INSERT INTO Notification (user_id,  date)
 VALUES ($user_id ,  now());


-- Insert commentable
INSERT INTO BageAttainementNotification (content_id)
 VALUES (currval('insert_question_seq'));

-- Insert question
INSERT INTO Question (notification_id, title)
 VALUES (currval('insert_question_seq'));

END TRANSACTION;
