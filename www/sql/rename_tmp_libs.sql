--
-- Library Tables
--

DROP TABLE IF EXISTS library;
RENAME TABLE tmp_library TO library;

DROP TABLE IF EXISTS library_homepage;
RENAME TABLE tmp_library_homepage TO library_homepage;

DROP TABLE IF EXISTS library_author_link;
RENAME TABLE tmp_library_author_link TO library_author_link;

DROP TABLE IF EXISTS library_emulator_link;
RENAME TABLE tmp_library_emulator_link TO library_emulator_link;

DROP TABLE IF EXISTS library_tool_link;
RENAME TABLE tmp_library_tool_link TO library_tool_link;

DROP TABLE IF EXISTS library_file;
RENAME TABLE tmp_library_file TO library_file;

DROP TABLE IF EXISTS library_relative_link;
RENAME TABLE tmp_library_relative_link TO library_relative_link;

DROP TABLE IF EXISTS library_contents;
RENAME TABLE tmp_library_contents TO library_contents;

DROP TABLE IF EXISTS library_contents_library_link;
RENAME TABLE tmp_library_contents_library_link TO library_contents_library_link;

