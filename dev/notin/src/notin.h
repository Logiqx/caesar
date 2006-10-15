/* --------------------------------------------------------------------------
 * NotIn - Written by Logiqx (http://www.logiqx.com/)
 *
 * Support script for CAESAR
 * -------------------------------------------------------------------------- */

/* --- NotIn structures --- */

struct game_map
{
	struct game *game;
	struct game *map;
	char type;
};

/* --- Function prototypes --- */

int check_non_mame(char *mame_fn, char *non_mame_fn);
int verify_non_mame(struct dat *mame_dat, struct dat *non_mame_dat, char *log_fn);

int process_dats(char *mame_fn, char *non_mame_fn, int dat_check);
int verify_mame_rominfo(struct dat *mame_dat);
int verify_dir(char *dir, struct dat *mame_dat, struct dat *non_mame_dat, int dat_check);
int verify_local_rominfo(struct dat *local_dat, char *basename);
struct game_map *load_map(struct dat *mame_dat, struct dat *non_mame_dat, struct dat *dat_info, char *map_fn, char *log_fn);
struct game_map *free_map(struct game_map *map);
int verify_roms(struct dat *mame_dat, struct dat *curr_dat, struct game_map *curr_map, char *base_fn, int dat_check);

int clean_log_dir(void);
