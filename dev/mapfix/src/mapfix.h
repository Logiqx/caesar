/* --------------------------------------------------------------------------
 * MapFix - Tool for quickly updating CAESAR map files after a MAME release
 * Written by Logiqx, http://www.logiqx.com
 * -------------------------------------------------------------------------- */

/* --- Structures --- */

struct name_change
{
	char *old_name;
	char *new_name;
	int flags;
};

struct name_change_idx
{
	struct name_change *name_change;
};

struct map
{
	char *game_name;
	char *map_name;
	char *map_type;
};


/* --- Function prototypes --- */

int fix_maps(char *fn, int options);
int fix_map(char *fn, int options, struct name_change_idx *name_change_idx, int num_name_changes);


/* --- Constants --- */

#define PROCESSED	0x01

#define GAME_RENAMED	0x10
#define GAME_ADDED	0x20
#define GAME_REMOVED	0x40

#define FIX_MAME	0x01
#define FIX_NONMAME	0x02
#define TEST_MODE	0x04

