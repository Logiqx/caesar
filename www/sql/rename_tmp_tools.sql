--
-- Tool Tables
--

DROP TABLE IF EXISTS tool;
RENAME TABLE tmp_tool TO tool;

DROP TABLE IF EXISTS tool_homepage;
RENAME TABLE tmp_tool_homepage TO tool_homepage;

DROP TABLE IF EXISTS tool_author_link;
RENAME TABLE tmp_tool_author_link TO tool_author_link;

DROP TABLE IF EXISTS tool_emulator_link;
RENAME TABLE tmp_tool_emulator_link TO tool_emulator_link;

DROP TABLE IF EXISTS tool_library_link;
RENAME TABLE tmp_tool_library_link TO tool_library_link;

DROP TABLE IF EXISTS tool_file;
RENAME TABLE tmp_tool_file TO tool_file;

DROP TABLE IF EXISTS tool_contents;
RENAME TABLE tmp_tool_contents TO tool_contents;

DROP TABLE IF EXISTS tool_contents_tool_link;
RENAME TABLE tmp_tool_contents_tool_link TO tool_contents_tool_link;

