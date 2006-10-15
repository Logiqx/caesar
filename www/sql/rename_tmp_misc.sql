--
-- Misc Tables
--

-- Populate x_rombuild_ind (takes no time, slightly suprisingly)

UPDATE	game_rom
SET	x_rombuild_ind=null
WHERE	x_rombuild_ind IS NOT NULL;

UPDATE	game_rom, tmp_rombuild
SET	game_rom.x_rombuild_ind=1
WHERE	game_rom.dat=tmp_rombuild.dat AND
	game_rom.game_name=tmp_rombuild.game_name AND
	game_rom.rom_name=tmp_rombuild.rom_name AND
	game_rom.size=tmp_rombuild.rom_size AND
	game_rom.crc=tmp_rombuild.rom_crc;

-- Rename tables

DROP TABLE IF EXISTS rombuild;
RENAME TABLE tmp_rombuild TO rombuild;

DROP TABLE IF EXISTS manufacturer;
RENAME TABLE tmp_manufacturer TO manufacturer;

DROP TABLE IF EXISTS history_link;
RENAME TABLE tmp_history_link TO history_link;

DROP TABLE IF EXISTS history_text;
RENAME TABLE tmp_history_text TO history_text;

DROP TABLE IF EXISTS mameinfo_link;
RENAME TABLE tmp_mameinfo_link TO mameinfo_link;

DROP TABLE IF EXISTS mameinfo_text;
RENAME TABLE tmp_mameinfo_text TO mameinfo_text;

DROP TABLE IF EXISTS catver;
RENAME TABLE tmp_catver TO catver;

