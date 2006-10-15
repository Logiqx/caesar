--
-- Author Tables
--

DROP TABLE IF EXISTS tmp_author;
CREATE TABLE tmp_author
(
	author_id	VARCHAR(30) NOT NULL,
	name		VARCHAR(80) NOT NULL,
	info		TEXT NULL,
	PRIMARY KEY	(author_id),
	INDEX		(name)
);

DROP TABLE IF EXISTS tmp_author_email;
CREATE TABLE tmp_author_email
(
	author_id	VARCHAR(30) NOT NULL,
	email		VARCHAR(40),
	INDEX		(author_id)
);

DROP TABLE IF EXISTS tmp_author_homepage;
CREATE TABLE tmp_author_homepage
(
	author_id	VARCHAR(30) NOT NULL,
	homepage	VARCHAR(80),
	status		VARCHAR(10),
	INDEX		(author_id)
);

DROP TABLE IF EXISTS tmp_author_emulator_link;
CREATE TABLE tmp_author_emulator_link
(
	author_id	VARCHAR(30) NOT NULL,
	emulator_id	VARCHAR(30) NOT NULL,
	relationship	VARCHAR(20) NOT NULL,
	INDEX		(author_id)
);

DROP TABLE IF EXISTS tmp_author_library_link;
CREATE TABLE tmp_author_library_link
(
	author_id	VARCHAR(30) NOT NULL,
	library_id	VARCHAR(30) NOT NULL,
	INDEX		(author_id)
);

DROP TABLE IF EXISTS tmp_author_tool_link;
CREATE TABLE tmp_author_tool_link
(
	author_id	VARCHAR(30) NOT NULL,
	tool_id		VARCHAR(30) NOT NULL,
	INDEX		(author_id)
);
