--
-- Library Tables
--

DROP TABLE IF EXISTS tmp_library;
CREATE TABLE tmp_library
(
	library_id		VARCHAR(30) NOT NULL,
	library_contents_id	VARCHAR(20) NOT NULL,
	name			VARCHAR(50) NOT NULL,
	version			VARCHAR(20) NOT NULL,
	date			VARCHAR(20) NOT NULL,
	status			VARCHAR(20) NULL,
	emulates		VARCHAR(200) NOT NULL,
	comment			TEXT NOT NULL,
	PRIMARY KEY		(library_id)
);

DROP TABLE IF EXISTS tmp_library_homepage;
CREATE TABLE tmp_library_homepage
(
	library_id	VARCHAR(30) NOT NULL,
	homepage	VARCHAR(80) NULL,
	status		VARCHAR(10) NULL,
	INDEX		(library_id)
);

DROP TABLE IF EXISTS tmp_library_author_link;
CREATE TABLE tmp_library_author_link
(
	library_id	VARCHAR(30) NOT NULL,
	author_id	VARCHAR(30) NOT NULL,
	INDEX		(library_id)
);

DROP TABLE IF EXISTS tmp_library_emulator_link;
CREATE TABLE tmp_library_emulator_link
(
	library_id	VARCHAR(30) NOT NULL,
	emulator_id	VARCHAR(30) NOT NULL,
	INDEX		(library_id)
);

DROP TABLE IF EXISTS tmp_library_tool_link;
CREATE TABLE tmp_library_tool_link
(
	library_id	VARCHAR(30) NOT NULL,
	tool_id		VARCHAR(30) NOT NULL,
	INDEX		(library_id)
);

DROP TABLE IF EXISTS tmp_library_file;
CREATE TABLE tmp_library_file
(
	library_id	VARCHAR(30) NOT NULL,
	file		VARCHAR(120) NOT NULL,
	name		VARCHAR(80) NOT NULL,
	INDEX		(library_id)
);

DROP TABLE IF EXISTS tmp_library_relative_link;
CREATE TABLE tmp_library_relative_link
(
	library_id	VARCHAR(30) NOT NULL,
	relative_id	VARCHAR(30) NOT NULL,
	relationship	VARCHAR(20) NOT NULL,
	INDEX		(library_id)
);

DROP TABLE IF EXISTS tmp_library_contents;
CREATE TABLE tmp_library_contents
(
	library_contents_id	VARCHAR(30) NOT NULL,
	title			VARCHAR(40) NOT NULL,
	comment			TEXT NOT NULL,
	PRIMARY KEY		(library_contents_id)
);

DROP TABLE IF EXISTS tmp_library_contents_library_link;
CREATE TABLE tmp_library_contents_library_link
(
	library_contents_id	VARCHAR(30) NOT NULL,
	library_id		VARCHAR(30) NOT NULL,
	INDEX			(library_contents_id)
);

