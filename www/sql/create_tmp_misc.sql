--
-- Misc Tables
--

DROP TABLE IF EXISTS tmp_rombuild;
CREATE TABLE tmp_rombuild
(
	dat		VARCHAR(60) NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	rom_name	VARCHAR(40) NOT NULL,
	rom_size	INT UNSIGNED NOT NULL,
	rom_crc		VARCHAR(8) NOT NULL,
	INDEX		(dat, game_name, rom_name)
);

DROP TABLE IF EXISTS tmp_manufacturer;
CREATE TABLE tmp_manufacturer
(
	manufacturer	VARCHAR(60) NOT NULL,
	PRIMARY KEY	(manufacturer)
);

DROP TABLE IF EXISTS tmp_history_link;
CREATE TABLE tmp_history_link
(
	history_id	INT UNSIGNED NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	INDEX		(game_name)
);

DROP TABLE IF EXISTS tmp_history_text;
CREATE TABLE tmp_history_text
(
	history_type	VARCHAR(20) NULL,
	history_id	INT UNSIGNED NOT NULL,
	line_no		INT UNSIGNED NOT NULL,
	text		VARCHAR(4096) NOT NULL,
	PRIMARY KEY	(history_id, line_no)
);

DROP TABLE IF EXISTS tmp_mameinfo_link;
CREATE TABLE tmp_mameinfo_link
(
	mameinfo_id	INT UNSIGNED NOT NULL,
	game_name	VARCHAR(20) NOT NULL,
	INDEX		(game_name)
);

DROP TABLE IF EXISTS tmp_mameinfo_text;
CREATE TABLE tmp_mameinfo_text
(
	mameinfo_type	VARCHAR(20) NULL,
	mameinfo_id	INT UNSIGNED NOT NULL,
	line_no		INT UNSIGNED NOT NULL,
	text		VARCHAR(4096) NOT NULL,
	PRIMARY KEY	(mameinfo_id, line_no)
);

DROP TABLE IF EXISTS tmp_catver;
CREATE TABLE tmp_catver
(
	game_name	VARCHAR(20) NOT NULL,
	category	VARCHAR(40) NOT NULL,
	INDEX		(game_name)
);

