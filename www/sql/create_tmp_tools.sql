--
-- Tool Tables
--

DROP TABLE IF EXISTS tmp_tool;
CREATE TABLE tmp_tool
(
	tool_id			VARCHAR(30) NOT NULL,
	tool_contents_id	VARCHAR(20) NOT NULL,
	name			VARCHAR(50) NOT NULL,
	version			VARCHAR(20) NOT NULL,
	date			VARCHAR(20) NOT NULL,
	comment			TEXT NOT NULL,
	PRIMARY KEY		(tool_id)
);

DROP TABLE IF EXISTS tmp_tool_homepage;
CREATE TABLE tmp_tool_homepage
(
	tool_id		VARCHAR(30) NOT NULL,
	homepage	VARCHAR(80) NOT NULL,
	status		VARCHAR(10) NULL,
	INDEX		(tool_id)
);

DROP TABLE IF EXISTS tmp_tool_author_link;
CREATE TABLE tmp_tool_author_link
(
	tool_id		VARCHAR(30) NOT NULL,
	author_id	VARCHAR(30) NOT NULL,
	INDEX		(tool_id)
);

DROP TABLE IF EXISTS tmp_tool_emulator_link;
CREATE TABLE tmp_tool_emulator_link
(
	tool_id		VARCHAR(30) NOT NULL,
	emulator_id	VARCHAR(30) NOT NULL,
	INDEX		(tool_id)
);

DROP TABLE IF EXISTS tmp_tool_library_link;
CREATE TABLE tmp_tool_library_link
(
	tool_id		VARCHAR(30) NOT NULL,
	library_id	VARCHAR(30) NOT NULL,
	INDEX		(tool_id)
);

DROP TABLE IF EXISTS tmp_tool_file;
CREATE TABLE tmp_tool_file
(
	tool_id		VARCHAR(30) NOT NULL,
	file		VARCHAR(120) NOT NULL,
	name		VARCHAR(80) NOT NULL,
	INDEX		(tool_id)
);

DROP TABLE IF EXISTS tmp_tool_contents;
CREATE TABLE tmp_tool_contents
(
	tool_contents_id	VARCHAR(30) NOT NULL,
	title			VARCHAR(40) NOT NULL,
	comment			TEXT NOT NULL,
	PRIMARY KEY		(tool_contents_id)
);

DROP TABLE IF EXISTS tmp_tool_contents_tool_link;
CREATE TABLE tmp_tool_contents_tool_link
(
	tool_contents_id	VARCHAR(30) NOT NULL,
	tool_id			VARCHAR(30) NOT NULL,
	INDEX			(tool_contents_id)
);

