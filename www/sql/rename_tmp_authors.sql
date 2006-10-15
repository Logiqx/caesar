--
-- Author Tables
--

DROP TABLE IF EXISTS author;
RENAME TABLE tmp_author TO author;

DROP TABLE IF EXISTS author_email;
RENAME TABLE tmp_author_email TO author_email;

DROP TABLE IF EXISTS author_homepage;
RENAME TABLE tmp_author_homepage TO author_homepage;

DROP TABLE IF EXISTS author_emulator_link;
RENAME TABLE tmp_author_emulator_link TO author_emulator_link;

DROP TABLE IF EXISTS author_library_link;
RENAME TABLE tmp_author_library_link TO author_library_link;

DROP TABLE IF EXISTS author_tool_link;
RENAME TABLE tmp_author_tool_link TO author_tool_link;
