--
-- Dat/Map Tables
--

DROP TABLE IF EXISTS tmp_game;
CREATE TABLE tmp_game
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	runnable	CHAR(3) NULL,
	game_sourcefile	VARCHAR(20) NULL,
	cloneof		VARCHAR(20) NULL,
	romof		VARCHAR(20) NULL,
	sampleof	VARCHAR(20) NULL,
	description	VARCHAR(120) NOT NULL,
	year		VARCHAR(10) NULL, -- NOT NULL IN LISTXML
	manufacturer	VARCHAR(80) NULL, -- NOT NULL IN LISTXML
	history		TEXT NULL,
	rebuildto	VARCHAR(20) NULL,
	board		VARCHAR(40) NULL,
	PRIMARY KEY	(dat, game_name),
	INDEX		(dat, description)
);

DROP TABLE IF EXISTS tmp_game_comment;
CREATE TABLE tmp_game_comment
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	comment		VARCHAR(100) NOT NULL,
	INDEX		(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_biosset;
CREATE TABLE tmp_game_biosset
(
	dat			VARCHAR(60) NOT NULL,
	game_name		VARCHAR(20) NOT NULL,
	biosset_name		VARCHAR(20) NOT NULL,
	biosset_description	VARCHAR(60) NOT NULL,
	biosset_default		CHAR(3) NULL,
	PRIMARY KEY		(dat, game_name, biosset_name)
);

DROP TABLE IF EXISTS tmp_game_rom;
CREATE TABLE tmp_game_rom
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	rom_name	VARCHAR(60) NOT NULL,
	merge		VARCHAR(60) NULL,
	bios		VARCHAR(20) NULL,
	size		INT UNSIGNED NOT NULL,
	crc		VARCHAR(8) NULL,
	sha1		VARCHAR(40) NULL,
	md5		VARCHAR(32) NULL,
	region		VARCHAR(16) NULL,
	status		VARCHAR(10) NULL,
	dispose		CHAR(3) NULL,
	soundonly	CHAR(3) NULL,
	offset		VARCHAR(7) NULL,
	INDEX		(dat, game_name, rom_name),
	INDEX		(crc, size)
);

DROP TABLE IF EXISTS tmp_game_disk;
CREATE TABLE tmp_game_disk
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	disk_name	VARCHAR(40) NOT NULL,
	merge		VARCHAR(40) NULL,
	sha1		VARCHAR(40) NULL,
	md5		VARCHAR(32) NULL,
	region		VARCHAR(10) NULL,
	status		VARCHAR(10) NULL,
	offset		VARCHAR(7) NULL,
	PRIMARY KEY	(dat, game_name, disk_name)
);

DROP TABLE IF EXISTS tmp_game_sample;
CREATE TABLE tmp_game_sample
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	sample_name	VARCHAR(40) NOT NULL,
	INDEX		(dat, game_name, sample_name)
);

DROP TABLE IF EXISTS tmp_game_chip;
CREATE TABLE tmp_game_chip
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	type		VARCHAR(10) NOT NULL,
	soundonly	CHAR(3) NULL,
	chip_name	VARCHAR(40) NOT NULL,
	clock		INT UNSIGNED NULL,
	INDEX		(dat, game_name, type, chip_name)
);

DROP TABLE IF EXISTS tmp_game_video;
CREATE TABLE tmp_game_video
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	screen		VARCHAR(6) NOT NULL,
	orientation	VARCHAR(10) NOT NULL,
	width		SMALLINT UNSIGNED NULL,
	height		SMALLINT UNSIGNED NULL,
	aspectx		SMALLINT UNSIGNED NULL,
	aspecty		SMALLINT UNSIGNED NULL,
	refresh		DECIMAL(8,6) NOT NULL,
	PRIMARY KEY	(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_display;
CREATE TABLE tmp_game_display
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	type		VARCHAR(6) NOT NULL,
	rotate		SMALLINT UNSIGNED NOT NULL,
	flipx		CHAR(3) NULL,
	width		SMALLINT UNSIGNED NULL,
	height		SMALLINT UNSIGNED NULL,
	refresh		DECIMAL(8,6) NOT NULL,
	KEY		(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_sound;
CREATE TABLE tmp_game_sound
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	channels	TINYINT UNSIGNED NOT NULL,
	PRIMARY KEY	(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_input;
CREATE TABLE tmp_game_input
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	players		TINYINT UNSIGNED NOT NULL,
	control		VARCHAR(20) NULL,
	buttons		TINYINT UNSIGNED NULL,
	coins		TINYINT UNSIGNED NULL,
	service		CHAR(3) NULL,
	tilt		CHAR(3) NULL,
	dipswitches	TINYINT UNSIGNED NULL,
	PRIMARY KEY	(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_control;
CREATE TABLE tmp_game_control
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	players		TINYINT UNSIGNED NOT NULL,
	type		VARCHAR(20) NULL,
	minimum		MEDIUMINT NULL,
	maximum		MEDIUMINT NULL,
	sensitivity	TINYINT UNSIGNED NULL,
	KEYDELTA	TINYINT UNSIGNED NULL,
	reverse		CHAR(3) NULL,
	INDEX		(dat, game_name, players)
);

DROP TABLE IF EXISTS tmp_game_dipswitch;
CREATE TABLE tmp_game_dipswitch
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	dipswitch_name	VARCHAR(60) NOT NULL,
	INDEX		(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_dipvalue;
CREATE TABLE tmp_game_dipvalue
(
	dat			VARCHAR(60) NOT NULL,
	game_name		VARCHAR(20) NOT NULL,
	dipswitch_name		VARCHAR(60) NOT NULL,
	dipvalue_name		VARCHAR(60) NOT NULL,
	dipvalue_default	CHAR(3) NULL,
	INDEX			(dat, game_name, dipswitch_name)
);

DROP TABLE IF EXISTS tmp_game_driver;
CREATE TABLE tmp_game_driver
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	status		VARCHAR(11) NOT NULL,
	emulation	VARCHAR(11) NULL,
	color		VARCHAR(11) NOT NULL,
	sound		VARCHAR(11) NULL,
	graphic		VARCHAR(11) NULL,
	cocktail	VARCHAR(11) NULL,
	protection	VARCHAR(11) NULL,
	palettesize	MEDIUMINT UNSIGNED NULL,
	colordeep	TINYINT UNSIGNED NULL,
	credits		VARCHAR(60) NULL,
	savestate	VARCHAR(11) NULL,
	PRIMARY KEY	(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_archive;
CREATE TABLE tmp_game_archive
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	archive_name	VARCHAR(60) NOT NULL,
	KEY		(dat, game_name)
);

DROP TABLE IF EXISTS tmp_game_map;
CREATE TABLE tmp_game_map
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	map_name	VARCHAR(20) NOT NULL,
	map_type	CHAR(1) NOT NULL,
	PRIMARY KEY	(dat, game_name),
	KEY		(dat, map_name)
);

