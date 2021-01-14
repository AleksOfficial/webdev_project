CREATE DATABASE webdev_project;

-- TODO: FIX THE INTEGER SHIT. and change it ids to an integer. 

-- Main Tables
/*
  MAIN - Tabellen:
  
  - person
  - tag
  - reaction_type
  - comments
  - images
  - post
  - type notification
*/
CREATE TABLE person(
  person_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  gender CHAR(1),
  first_name VARCHAR(60),
  last_name VARCHAR(60),
  password_hash VARCHAR(255),
  username VARCHAR(60),
  email VARCHAR(160)
);

CREATE TABLE tag(
  tag_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tag_text VARCHAR(255)
);

CREATE TABLE reaction_type(
  reaction_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  reaction_text VARCHAR(255),
  emoji_path VARCHAR(255)
);

CREATE TABLE comments(
  comment_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  comment_text VARCHAR(500),
  post_id INTEGER NOT NULL, -- Where it belongs to so it needs to be a foreign key
  person_id INTEGER NOT NULL  -- Who wrote it
);

CREATE TABLE images(
  filename VARCHAR(255) NOT NULL PRIMARY KEY, 
  file_path VARCHAR(255),
  thumbnail_path VARCHAR(255)
);

CREATE TABLE post(
  post_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  person_id INTEGER,
  privacy_status INTEGER,
  image_name VARCHAR(255)
  -- FKs: person_id
);

CREATE TABLE type_notification(
  notification_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  notification_text VARCHAR(255),
  icon_path VARCHAR(255)
);

-- Relationship tables
/*
  RS - Tabellen: 
  - all_reaction
  - msg
  - all_tags
  - all_notifications
  - friends
*/
CREATE TABLE messages (
  msg_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  from_id INTEGER NOT NULL,
  to_id INTEGER NOT NULL,
  content VARCHAR(255)
);

CREATE TABLE friends (
  status_request INTEGER(1) NOT NULL,
  from_id INTEGER NOT NULL,
  to_id INTEGER NOT NULL
  -- all of them are the primary key
);

CREATE TABLE all_tags(
  tag_id INTEGER,
  post_id INTEGER
  -- FKs: tag; post
);


CREATE TABLE all_reaction
(
  reaction_id INTEGER NOT NULL,
  post_id INTEGER NOT NULL,
  person_id INTEGER NOT NULL
  -- FKs: reaction; post; friends
);

CREATE TABLE all_notifications(
  notification_id INTEGER,
  notification_time TIMESTAMP,
  viewed INTEGER,
  from_id INTEGER,
  to_id INTEGER
  -- FKs: person, type_notification, 
);
/*
  RS - Tabellen: 
  - all_reaction
  - msg
  - all_tags
  - all_notifications
  - friends
*/


-- Creating Indexes

CREATE INDEX INDEX_person
  ON person(person_id);
CREATE INDEX INDEX_tag
  ON tag(tag_id);
CREATE INDEX INDEX_reaction_type
  ON reaction_type(reaction_id);
CREATE INDEX INDEX_comments
  ON comments(comment_id);
CREATE INDEX INDEX_images
  ON images(filename);
CREATE INDEX INDEX_post
  ON post(post_id);
CREATE INDEX INDEX_type_notification
  ON type_notification(notification_id);



  -- RS
/*
CREATE INDEX INDEX_all_reaction
CREATE INDEX INDEX_msg
CREATE INDEX INDEX_all_tags
CREATE INDEX INDEX_all_notifications
CREATE INDEX INDEX_friends
*/




-- Creating Foreign Keys

ALTER TABLE comments
  ADD CONSTRAINT FK_comments_person FOREIGN KEY (person_id) REFERENCES person(person_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT FK_comments_post FOREIGN KEY (post_id) REFERENCES post(post_id) ON DELETE CASCADE;

ALTER TABLE post
  ADD CONSTRAINT FK_post FOREIGN KEY (image_name) REFERENCES images (filename) ON DELETE CASCADE; 

ALTER TABLE messages
  ADD CONSTRAINT FK_messages_from FOREIGN KEY(from_id) REFERENCES person(person_id) ,
  ADD CONSTRAINT FK_messages_to FOREIGN KEY(to_id) REFERENCES person(person_id);

ALTER TABLE friends
  ADD CONSTRAINT PK_friends PRIMARY KEY(status_request,from_id,to_id),
  ADD CONSTRAINT FK_friends_from FOREIGN KEY(from_id) REFERENCES person(person_id),
  ADD CONSTRAINT FK_friends_to FOREIGN KEY(from_id) REFERENCES person(person_id);

ALTER TABLE all_tags
  ADD CONSTRAINT PK_all_tags PRIMARY KEY (tag_id,post_id),
  ADD CONSTRAINT FK_all_tags_tag FOREIGN KEY (tag_id) REFERENCES tag(tag_id),
  ADD CONSTRAINT FK_all_tags_post FOREIGN KEY (post_id) REFERENCES post(post_id);

ALTER TABLE all_reactions
  ADD CONSTRAINT PK_all_reaction PRIMARY KEY(reaction_id,post_id,person_id),
  ADD CONSTRAINT FK_all_reaction_post FOREIGN KEY(post_id) REFERENCES post(post_id),
  ADD CONSTRAINT FK_all_reaction_person FOREIGN KEY(person_id) REFERENCES person(person_id);

ALTER TABLE all_notifications
  ADD CONSTRAINT PK_all_notifications PRIMARY KEY (notification_time,notification_id,from_id,to_id),
  ADD CONSTRAINT FK_all_notifications_id FOREIGN KEY (notification_id) REFERENCES type_notification(notification_id),
  ADD CONSTRAINT FK_all_notifications_from FOREIGN KEY(from_id) REFERENCES person(person_id),
  ADD CONSTRAINT FK_all_notifications_to FOREIGN KEY (to_id) REFERENCES person(person_id);





