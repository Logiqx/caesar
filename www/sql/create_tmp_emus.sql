--
-- Emulator Tables
--

DROP TABLE IF EXISTS tmp_emulator;
CREATE TABLE tmp_emulator
(
	emulator_id		VARCHAR(30) NOT NULL,
	emulator_contents_id	VARCHAR(20) NOT NULL,
	dat			VARCHAR(60) NOT NULL,
	dat_type		VARCHAR(20),
	aspectx			SMALLINT UNSIGNED NULL,
	aspecty			SMALLINT UNSIGNED NULL,
	name			VARCHAR(80) NOT NULL,
	version			VARCHAR(20) NOT NULL,
	date			VARCHAR(20) NOT NULL,
	platform		VARCHAR(30) NOT NULL,
	emulates		VARCHAR(200) NOT NULL,
	comment			TEXT,
	status			VARCHAR(40) NOT NULL,
	PRIMARY KEY		(emulator_id),
	INDEX			(dat),
	INDEX			(name)
);

DROP TABLE IF EXISTS tmp_emulator_homepage;
CREATE TABLE tmp_emulator_homepage
(
	emulator_id	VARCHAR(30) NOT NULL,
	homepage	VARCHAR(80),
	status		VARCHAR(10),
	INDEX		(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_author_link;
CREATE TABLE tmp_emulator_author_link
(
	emulator_id	VARCHAR(30) NOT NULL,
	author_id	VARCHAR(30) NOT NULL,
	comment		TEXT,
	relationship	VARCHAR(20) NOT NULL,
	INDEX		(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_library_link;
CREATE TABLE tmp_emulator_library_link
(
	emulator_id	VARCHAR(30) NOT NULL,
	library_id	VARCHAR(30) NOT NULL,
	INDEX		(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_tool_link;
CREATE TABLE tmp_emulator_tool_link
(
	emulator_id	VARCHAR(30) NOT NULL,
	tool_id		VARCHAR(30) NOT NULL,
	INDEX		(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_features;
CREATE TABLE tmp_emulator_features
(
	emulator_id	VARCHAR(30) NOT NULL,
	sound		VARCHAR(20) NULL,
	source		VARCHAR(30) NULL,
	screendump	VARCHAR(20) NULL,
	hiscoresave	VARCHAR(20) NULL,
	savegame	VARCHAR(20) NULL,
	recordinput	VARCHAR(20) NULL,
	dips		VARCHAR(20) NULL,
	cheat		VARCHAR(20) NULL,
	autoframeskip	VARCHAR(20) NULL,
	throttle	VARCHAR(20) NULL,
	network		VARCHAR(20) NULL,
	recordsound	VARCHAR(20) NULL,
	rotate		VARCHAR(20) NULL,
	PRIMARY KEY	(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_controller;
CREATE TABLE tmp_emulator_controller
(
	emulator_id	VARCHAR(30) NOT NULL,
	controller	VARCHAR(10) NOT NULL,
	INDEX		(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_relative_link;
CREATE TABLE tmp_emulator_relative_link
(
	emulator_id	VARCHAR(30) NOT NULL,
	relative_id	VARCHAR(30) NOT NULL,
	relationship	VARCHAR(20) NOT NULL,
	INDEX		(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_file;
CREATE TABLE tmp_emulator_file
(
	emulator_id	VARCHAR(30) NOT NULL,
	description	VARCHAR(120) NOT NULL,
	name		VARCHAR(80) NOT NULL,
	INDEX		(emulator_id)
);

DROP TABLE IF EXISTS tmp_emulator_contents;
CREATE TABLE tmp_emulator_contents
(
	emulator_contents_id	VARCHAR(30) NOT NULL,
	title			VARCHAR(40) NOT NULL,
	comment			TEXT NOT NULL,
	PRIMARY KEY		(emulator_contents_id)
);

DROP TABLE IF EXISTS tmp_emulator_contents_emulator_link;
CREATE TABLE tmp_emulator_contents_emulator_link
(
	emulator_contents_id	VARCHAR(30) NOT NULL,
	emulator_id		VARCHAR(30) NOT NULL,
	INDEX			(emulator_contents_id)
);

DROP TABLE IF EXISTS tmp_emulator_old_name;
CREATE TABLE tmp_emulator_old_name
(
	emulator_id	VARCHAR(30) NOT NULL,
	name		VARCHAR(80) NOT NULL,
	INDEX		(emulator_id)
);
