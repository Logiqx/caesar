--
-- Dat/Map Tables
--

-- Add extra columns onto the game_display table

ALTER TABLE tmp_game_display
ADD (
	x_orientation	VARCHAR(10) NOT NULL,
	x_rotated_width	SMALLINT UNSIGNED NULL,
	x_rotated_height SMALLINT UNSIGNED NULL,
	x_aspectx	SMALLINT UNSIGNED NULL,
	x_aspecty	SMALLINT UNSIGNED NULL
);

UPDATE	tmp_game_display
SET	x_orientation = 'horizontal',
	x_rotated_width = width,
	x_rotated_height = height,
	x_aspectx = 4,
	x_aspecty = 3
WHERE	rotate IN (0, 180);

UPDATE	tmp_game_display
SET	x_orientation = 'vertical',
	x_rotated_width = height,
	x_rotated_height = width,
	x_aspectx = 3,
	x_aspecty = 4
WHERE	rotate IN (90, 270);

-- Add extra columns onto the game table

ALTER TABLE tmp_game
ADD (
	x_map_name	VARCHAR(20) NULL,
	x_nonmame_ind	TINYINT(1) NULL,
	x_hidden_ind	TINYINT(1) NULL,
	x_master_ind	TINYINT(1) NULL,
	x_group_name	VARCHAR(20) NOT NULL,
	x_size		INT UNSIGNED NOT NULL,
	x_multiscreen_ind TINYINT(1) NULL
);

ALTER TABLE tmp_game_rom
ADD (
	x_mame_ind	TINYINT(1) NULL,
	x_rombuild_ind	TINYINT(1) NULL
);


-- Index for populating x_game_group and looking up master group details (game_group.php)

ALTER TABLE tmp_game ADD KEY (x_master_ind, game_name);

-- Indices for non-mame searches and desc/manu/year searches (game_search.php)

ALTER TABLE tmp_game ADD KEY (x_master_ind, x_nonmame_ind);
ALTER TABLE tmp_game ADD KEY (x_master_ind, manufacturer, description, year);
ALTER TABLE tmp_game ADD KEY (x_master_ind, year, manufacturer, description);
ALTER TABLE tmp_game ADD KEY (x_master_ind, description, year, manufacturer);

-- Index for identifying the master games in a group (game_group.php)

ALTER TABLE tmp_game ADD KEY (x_master_ind, x_group_name);

-- Index for identifying each emulator supporting a game (game_group.php)

ALTER TABLE tmp_game ADD KEY (x_map_name);

-- Index for populating x_mame_ind

ALTER TABLE tmp_game_rom ADD KEY (crc);


-- Rename games named 'The XXX' to 'XXX, The'

UPDATE	tmp_game
SET	description=CONCAT(SUBSTR(description, 5), ', The')
WHERE	description LIKE 'The %';

-- Set unknown years to '????'

UPDATE	tmp_game
SET	year='????'
WHERE	year IS NULL;

-- Set unknown manufacturers to 'unknown'

UPDATE	tmp_game
SET	manufacturer='unknown'
WHERE	manufacturer IS NULL;


-- Populate x_map_name (simply taken from the game_map table)
-- MAME games should map to themselves, despite not having a game_map record

UPDATE	tmp_game, tmp_game_map
SET	tmp_game.x_map_name=tmp_game_map.map_name
WHERE	tmp_game.dat=tmp_game_map.dat AND
	tmp_game.game_name=tmp_game_map.game_name;

UPDATE	tmp_game
SET	x_map_name=game_name
WHERE	x_map_name IS NULL;

-- Populate x_nonmame_ind

UPDATE	tmp_game g1, tmp_game g2
SET	g1.x_nonmame_ind=1
WHERE	g1.x_map_name=g2.game_name AND
	g2.dat='nonmame';

-- Populate x_hidden_ind (resources should be hidden by default)

UPDATE	tmp_game, tmp_game_map
SET	tmp_game.x_hidden_ind=1
WHERE	tmp_game.dat=tmp_game_map.dat AND
	tmp_game.game_name=tmp_game_map.game_name AND
	map_type='h';

UPDATE	tmp_game
SET	x_hidden_ind=1
WHERE	runnable='no';

-- Populate x_master_ind (MAME and Non-MAME games that appear on group listings)

UPDATE	tmp_game
SET	x_master_ind=1
WHERE	EXISTS
	(
		SELECT	1
		FROM	emulator
		WHERE	emulator.dat=tmp_game.dat
		AND	emulator.emulator_id='mame'
	) OR
	dat='nonmame';

-- Populate x_group_name (i.e. the parent name of the mapped game)

UPDATE	tmp_game g1, tmp_game g2
SET	g1.x_group_name=IFNULL(g2.cloneof, g2.game_name)
WHERE	g1.x_map_name=g2.game_name
AND	g2.x_master_ind=1;

-- Populate x_size with the game size (taken from the ROMs)
-- This is slow and takes about 40 seconds on my PC.
-- The group by and sum() account for all of the time taken!

UPDATE	tmp_game
SET	tmp_game.x_size=
	(
		SELECT	sum(size)
		FROM	tmp_game_rom
		WHERE	tmp_game.dat=tmp_game_rom.dat AND
			tmp_game.game_name=tmp_game_rom.game_name
		GROUP BY tmp_game_rom.dat, tmp_game_rom.game_name
	)
WHERE 	EXISTS
	(
		SELECT	1
		FROM	tmp_game_rom
		WHERE	tmp_game.dat=tmp_game_rom.dat AND
			tmp_game.game_name=tmp_game_rom.game_name
	);

-- Populate x_mame_ind

-- A bit of a cheat (not checking emulator_id='mame') but quick at 9 seconds

UPDATE	tmp_game_rom
SET	tmp_game_rom.x_mame_ind=1
WHERE	dat LIKE 'MAME_v%';

-- Takes 10 minutes on my PC!

UPDATE	tmp_game_rom tgr1, tmp_game_rom tgr2
SET	tgr1.x_mame_ind=1
WHERE	tgr1.size=tgr2.size AND
	tgr1.crc=tgr2.crc AND
	tgr2.x_mame_ind=1;

-- Populate x_rombuild_ind (takes no time, slightly suprisingly)
-- Note: Both SQL statements must be commented out for the first database load

UPDATE	tmp_game_rom
SET	x_rombuild_ind=NULL
WHERE	x_rombuild_ind IS NOT NULL;

UPDATE	tmp_game_rom, rombuild
SET	tmp_game_rom.x_rombuild_ind=1
WHERE	tmp_game_rom.dat=rombuild.dat AND
	tmp_game_rom.game_name=rombuild.game_name AND
	tmp_game_rom.rom_name=rombuild.rom_name AND
	tmp_game_rom.size=rombuild.rom_size AND
	tmp_game_rom.crc=rombuild.rom_crc;

-- Populate x_multiscreen

UPDATE	tmp_game
SET	x_multiscreen_ind = 1
WHERE	EXISTS
	(
		SELECT	1
		FROM	tmp_game_display
		WHERE	tmp_game_display.dat = tmp_game.dat AND
			tmp_game_display.game_name = tmp_game.game_name
		GROUP BY dat, game_name
		HAVING	COUNT(*) > 1
	);

-- Rename temporary tables

DROP TABLE IF EXISTS game;
RENAME TABLE tmp_game TO game;

DROP TABLE IF EXISTS game_comment;
RENAME TABLE tmp_game_comment TO game_comment;

DROP TABLE IF EXISTS game_biosset;
RENAME TABLE tmp_game_biosset TO game_biosset;

DROP TABLE IF EXISTS game_rom;
RENAME TABLE tmp_game_rom TO game_rom;

DROP TABLE IF EXISTS game_disk;
RENAME TABLE tmp_game_disk TO game_disk;

DROP TABLE IF EXISTS game_sample;
RENAME TABLE tmp_game_sample TO game_sample;

DROP TABLE IF EXISTS game_chip;
RENAME TABLE tmp_game_chip TO game_chip;

DROP TABLE IF EXISTS game_video;
RENAME TABLE tmp_game_video TO game_video;

DROP TABLE IF EXISTS game_display;
RENAME TABLE tmp_game_display TO game_display;

DROP TABLE IF EXISTS game_sound;
RENAME TABLE tmp_game_sound TO game_sound;

DROP TABLE IF EXISTS game_input;
RENAME TABLE tmp_game_input TO game_input;

DROP TABLE IF EXISTS game_control;
RENAME TABLE tmp_game_control TO game_control;

DROP TABLE IF EXISTS game_dipswitch;
RENAME TABLE tmp_game_dipswitch TO game_dipswitch;

DROP TABLE IF EXISTS game_dipvalue;
RENAME TABLE tmp_game_dipvalue TO game_dipvalue;

DROP TABLE IF EXISTS game_driver;
RENAME TABLE tmp_game_driver TO game_driver;

DROP TABLE IF EXISTS game_archive;
RENAME TABLE tmp_game_archive TO game_archive;

DROP TABLE IF EXISTS game_map;
DROP TABLE IF EXISTS tmp_game_map;

