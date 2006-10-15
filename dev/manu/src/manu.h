/* --------------------------------------------------------------------------
 * Manu - Written by Logiqx (http://www.logiqx.com/)
 *
 * Parses MAME listinfo and generates a list of all manufacturers with 10 or
 * more games. Clever bit is that it groups manufacturers into higher level
 * ones (e.g. Taito America and Taito Japan simply become Taito).
 *
 * Used to perform case-insensitive matches but this seems unnecessary nowadays
 * and also caused some daft problems; manufactureres AC and TCH have one game
 * each but because they are substrings of many other manufacturers, the other
 * manufacturers were removed and lumped under AC/TCH!
 * -------------------------------------------------------------------------- */

/* --- Structures --- */

struct manufacturer
{
	char *name;
	int count;
	int total;
};


/* --- Function prototypes --- */

int list_manufacturers(struct dat *dat);
int sort_manufacturers_by_name(const void *idx1, const void *idx2);
