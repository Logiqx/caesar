--
-- Emulator Tables
--

DROP TABLE IF EXISTS emulator;
RENAME TABLE tmp_emulator TO emulator;

DROP TABLE IF EXISTS emulator_homepage;
RENAME TABLE tmp_emulator_homepage TO emulator_homepage;

DROP TABLE IF EXISTS emulator_author_link;
RENAME TABLE tmp_emulator_author_link TO emulator_author_link;

DROP TABLE IF EXISTS emulator_library_link;
RENAME TABLE tmp_emulator_library_link TO emulator_library_link;

DROP TABLE IF EXISTS emulator_tool_link;
RENAME TABLE tmp_emulator_tool_link TO emulator_tool_link;

DROP TABLE IF EXISTS emulator_features;
RENAME TABLE tmp_emulator_features TO emulator_features;

DROP TABLE IF EXISTS emulator_controller;
RENAME TABLE tmp_emulator_controller TO emulator_controller;

DROP TABLE IF EXISTS emulator_relative_link;
RENAME TABLE tmp_emulator_relative_link TO emulator_relative_link;

DROP TABLE IF EXISTS emulator_file;
RENAME TABLE tmp_emulator_file TO emulator_file;

DROP TABLE IF EXISTS emulator_contents;
RENAME TABLE tmp_emulator_contents TO emulator_contents;

DROP TABLE IF EXISTS emulator_contents_emulator_link;
RENAME TABLE tmp_emulator_contents_emulator_link TO emulator_contents_emulator_link;

DROP TABLE IF EXISTS emulator_old_name;
RENAME TABLE tmp_emulator_old_name TO emulator_old_name;

