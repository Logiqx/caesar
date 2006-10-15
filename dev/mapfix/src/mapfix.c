/* --------------------------------------------------------------------------
 * MapFix - Tool for quickly updating CAESAR map files after a MAME release
 * Written by Logiqx, http://www.logiqx.com
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define MAPFIX_VERSION "v1.0"
#define MAPFIX_DATE "15 February 2005"


/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <dirent.h>
#include <sys/stat.h>


/* --- Dat library includes --- */

#include "datlib/src/datlib.h"
#include "datlib/src/macro.h"


/* --- Misc library includes --- */

#include "datlib/src/misc/getopt.h"


/* --- MapFix definitions and macros --- */

#include "mapfix.h"


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main() function just cycles through the sections in the INI file
 * -------------------------------------------------------------------------- */

int main(int argc, char **argv)
{
	/* --- For getopt function --- */

	extern char *optarg;
	extern int optind;
	char c;

	int options=0;
	int errflg = 0;

	printf("===============================================================================\n");
	printf("MapFix %s (%s) - using ", MAPFIX_VERSION, MAPFIX_DATE);
	display_datlib_version();
	printf("Written by Logiqx (http://www.logiqx.com)\n");
	printf("===============================================================================\n");

	if (argc<2)
	{
		printf("Usage: mapfix [-t] [-m | -n]\n\n");
		errflg++;
	}

	/* --- Get the options specified on the command line --- */

	while (!errflg && (c = getopt(argc, argv, "mnt")) != EOF)
	switch (c)
	{
		/* --- Saving --- */
		case 'm':
			options|=FIX_MAME;
			break;
		case 'n':
			options|=FIX_NONMAME;
			break;
		case 't':
			options|=TEST_MODE;
			break;
	}

	if (!(options & (FIX_MAME|FIX_NONMAME)))
	{
		fprintf(stderr, "You must specify either -m or -n as a option!\n");
		errflg++;
	}

	if (!errflg)
		errflg=fix_maps("mamediff.out", options);

	return(errflg);
}

/* --------------------------------------------------------------------------
 * Function to load name_changes file into memory (datlib.out)
 * -------------------------------------------------------------------------- */

int name_change_idx_sort_function(const void *idx1, const void *idx2)
{
	return(strcmp(((struct name_change_idx *)idx1)->name_change->old_name, ((struct name_change_idx *)idx2)->name_change->old_name));
}

int find_name_change(const void *st, const void *name_change_idx)
{
	return(strcmp((char *)st, ((struct name_change_idx *)name_change_idx)->name_change->old_name));
}

int fix_maps(char *fn, int options)
{
	DIR *dirp=0, *sdirp=0;                                    
	struct dirent *direntp, *sdirentp;                       
	struct stat buf;

	char st[MAX_FILENAME_LENGTH+1];

	struct name_change *name_changes=0, *curr_name_change;
	struct name_change_idx *name_change_idx=0, *curr_name_change_idx;

	char *name_buffer=0, *ptr;

	int i, printed_header=0, fs=0, num_name_changes=0;

	int errflg = 0;

	/* --- Load the file into a buffer --- */

	if (stat(fn, &buf)!=0)
	{
		fprintf(stderr, "Error reading properties of '%s'\n", fn);
		errflg++;
	}
	else
	{
		fs=buf.st_size;
	}

	if (!errflg)
		BYTE_MALLOC(name_buffer, fs+1)

	if (!errflg)
		BYTE_READ(name_buffer, fs, fn)

	/* --- Count the name records and allocate memory for the structures --- */

	if (!errflg)
	{
		for (i=0, ptr=name_buffer; i<fs; i++, ptr++)
		{
			if (*ptr=='\r' || *ptr=='\n')
				*ptr='\0';
			if (i==0 || (*(ptr-1)==0 && *ptr!=0))
				num_name_changes++;
		}
		if (i==fs)
		{
			*ptr='\0';
		}

	}

	if (!errflg)
		STRUCT_CALLOC(name_changes, num_name_changes, sizeof(struct name_change))

	if (!errflg)
		STRUCT_CALLOC(name_change_idx, num_name_changes, sizeof(struct name_change_idx))

	/* --- Create name list and sort it for fast reference --- */

	if (!errflg)
	{
		for (i=0, ptr=name_buffer, curr_name_change=name_changes, curr_name_change_idx=name_change_idx; i<fs; i++, ptr++)
		{
			if (i==0 || (*(ptr-1)==0 && *ptr!=0))
			{
				curr_name_change->old_name=ptr;
				curr_name_change_idx++->name_change=curr_name_change++;
			}
		}

		for (i=0, curr_name_change=name_changes; i<num_name_changes; i++, curr_name_change++)
		{
			if (strrchr(curr_name_change->old_name, '\t'))
			{
				curr_name_change->new_name=strrchr(curr_name_change->old_name, '\t')+1;
				*strrchr(curr_name_change->old_name, '\t')='\0';
			}
			else
			{
				curr_name_change->new_name=curr_name_change->old_name+strlen(curr_name_change->old_name);
			}

			if (strcmp(curr_name_change->old_name, curr_name_change->new_name))
			{
				if (*curr_name_change->old_name!='\0' && *curr_name_change->new_name!='\0')
					curr_name_change->flags|=GAME_RENAMED;
				else if (*curr_name_change->old_name!='\0')
					curr_name_change->flags|=GAME_REMOVED;
				else if (*curr_name_change->new_name!='\0')
					curr_name_change->flags|=GAME_ADDED;
			}
		}

		qsort(name_change_idx, num_name_changes, sizeof(struct name_change_idx), name_change_idx_sort_function);
	}

	/* --- Scan current directory --- */

	if (!errflg && (dirp=opendir("."))==0)
		errflg++;

	while (!errflg && dirp && ((direntp = readdir(dirp)) != NULL))
	{
		if (stat(direntp->d_name, &buf) == 0)
		{
			if (buf.st_mode & S_IFDIR)
			{
				sdirp = opendir(direntp->d_name);

				while (!errflg && sdirp && ((sdirentp = readdir(sdirp)) != NULL))
				{
					sprintf(st, "%s/%s", direntp->d_name, sdirentp->d_name);

					if (stat(st, &buf) == 0)
					{
						if (!(buf.st_mode & S_IFDIR))
						{
							if (strrchr(st, '.') && !strcmp(strrchr(st, '.'), ".map"))
								errflg=fix_map(st, options, name_change_idx, num_name_changes);
						}
					}
					else
					{
						fprintf(stderr, "Error getting attributes of %s\n", sdirentp->d_name);
					}
				}

				if (sdirp)
					closedir(sdirp);                               
			}
		}
	}

	if (dirp)
		closedir(dirp);

	/* --- Summarise fixes --- */

	for (printed_header=i=0, curr_name_change=name_changes; i<num_name_changes; i++, curr_name_change++)
	{
		if (curr_name_change->flags==(GAME_RENAMED|PROCESSED))
		{
			if (printed_header++==0)
				printf("\nGame renames (100%% guaranteed):\n\n");

			printf("  %s -> %s\n", curr_name_change->old_name, curr_name_change->new_name);
		}
	}

	for (printed_header=i=0, curr_name_change=name_changes; i<num_name_changes; i++, curr_name_change++)
	{
		if (options & FIX_MAME)
		{
			if (curr_name_change->flags==(GAME_REMOVED|PROCESSED))
			{
				if (printed_header++==0)
					printf("\nGame removals (not guaranteed, better check them):\n\n");

				printf("  %s\n", curr_name_change->old_name);
			}
		}
		else if (options & FIX_NONMAME)
		{
			if (curr_name_change->flags==PROCESSED)
			{
				if (printed_header++==0)
					printf("\nNon-MAME -> MAME games (not guaranteed, better check them):\n\n");

				printf("  %s\n", curr_name_change->old_name);
			}
		}
	}

	/* --- Done! --- */

	FREE(name_changes)

	/* --- Return error code --- */

	return(errflg);
}

/* --------------------------------------------------------------------------
 * Function to fix a map file
 * -------------------------------------------------------------------------- */

#define DISPLAY_FILENAME \
{ \
	if (!printed_header) \
	{ \
		printf("%s:\n", fn); \
			printed_header++; \
	} \
};

int fix_map(char *fn, int options, struct name_change_idx *name_change_idx, int num_name_changes)
{
	FILE *out=0;

	struct stat buf;
	struct map *maps=0, *curr_map;
	struct name_change_idx *name_change_match;

	char *map_buffer=0, *ptr;
	int i, num_maps=0, fs=0, printed_header=0;

	int errflg = 0;

	/* --- Load the file into a buffer --- */

	if (stat(fn, &buf)!=0)
	{
		fprintf(stderr, "Error reading properties of '%s'\n", fn);
		errflg++;
	}
	else
	{
		fs=buf.st_size;
	}

	if (!errflg)
		BYTE_MALLOC(map_buffer, fs+1)

	if (!errflg)
		BYTE_READ(map_buffer, fs, fn)

	/* --- Count the map records and allocate memory for the structures --- */

	if (!errflg)
	{
		for (i=0, ptr=map_buffer; i<fs; i++, ptr++)
		{
			if (*ptr=='\r' || *ptr=='\n')
				*ptr='\0';
			if (i==0 || (*(ptr-1)==0 && *ptr!=0))
				num_maps++;
		}
		if (i==fs)
		{
			*ptr='\0';
		}
	}

	if (!errflg)
		STRUCT_CALLOC(maps, num_maps, sizeof(struct map))

	/* --- Create game selection list and sort it for fast reference --- */

	if (!errflg && num_maps>0)
	{
		for (i=0, ptr=map_buffer, curr_map=maps; i<fs; i++, ptr++)
		{
			if (i==0 || (*(ptr-1)==0 && *ptr!=0))
				curr_map++->game_name=ptr;
		}

		for (i=0, curr_map=maps; i<num_maps; i++, curr_map++)
		{
			if (strrchr(curr_map->game_name, ','))
			{
				curr_map->map_type=strrchr(curr_map->game_name, ',')+1;
				*strrchr(curr_map->game_name, ',')='\0';
			}
			else
			{
				curr_map->map_type=curr_map->game_name+strlen(curr_map->game_name);
			}

			if (strrchr(curr_map->game_name, ','))
			{
				curr_map->map_name=strrchr(curr_map->game_name, ',')+1;
				*strrchr(curr_map->game_name, ',')='\0';
			}
			else
			{
				curr_map->map_name=curr_map->game_name+strlen(curr_map->game_name);
			}
		}
	}

	/* --- Process the map --- */

	if (!errflg && num_maps>0)
	{
		for (i=0, curr_map=maps; i<num_maps; i++, curr_map++)
		{
			if (*curr_map->map_name!='\0' && (name_change_match=bsearch((void *)curr_map->map_name, name_change_idx, num_name_changes, sizeof(struct name_change_idx), find_name_change))!=0)
			{
				if (options & FIX_MAME && !strcmp(curr_map->map_type, "m"))
				{
					if (name_change_match->name_change->flags & GAME_REMOVED)
					{
						DISPLAY_FILENAME
						printf("  Removed %s,%s,%s\n", curr_map->game_name, curr_map->map_name, curr_map->map_type);
						curr_map->game_name=0;

						name_change_match->name_change->flags|=PROCESSED;
					}

					if (name_change_match->name_change->flags & GAME_RENAMED)
					{
						DISPLAY_FILENAME
						printf("  Changed %s,%s,%s to ", curr_map->game_name, curr_map->map_name, curr_map->map_type);
						curr_map->map_name=name_change_match->name_change->new_name;
						printf("%s,%s,%s\n", curr_map->game_name, curr_map->map_name, curr_map->map_type);

						name_change_match->name_change->flags|=PROCESSED;
					}
				}
				else if (options & FIX_NONMAME && !strcmp(curr_map->map_type, "n"))
				{
					if (name_change_match->name_change->flags==0 || name_change_match->name_change->flags==PROCESSED)
					{
						DISPLAY_FILENAME
						printf("  Changed %s,%s,%s to ", curr_map->game_name, curr_map->map_name, curr_map->map_type);
						curr_map->map_type="m";
						printf("%s,%s,%s\n", curr_map->game_name, curr_map->map_name, curr_map->map_type);

						name_change_match->name_change->flags|=PROCESSED;
					}

					if (name_change_match->name_change->flags & GAME_RENAMED)
					{
						DISPLAY_FILENAME
						printf("  Changed %s,%s,%s to ", curr_map->game_name, curr_map->map_name, curr_map->map_type);
						curr_map->map_name=name_change_match->name_change->new_name;
						curr_map->map_type="m";
						printf("%s,%s,%s\n", curr_map->game_name, curr_map->map_name, curr_map->map_type);

						name_change_match->name_change->flags|=PROCESSED;
					}
				}
			}
			else
			{
				if ((options & FIX_MAME && !strcmp(curr_map->map_type, "m")) ||
					(options & FIX_NONMAME && !strcmp(curr_map->map_type, "n")))
				{
					DISPLAY_FILENAME
					printf("  Removed %s,%s,%s\n", curr_map->game_name, curr_map->map_name, curr_map->map_type);
					curr_map->game_name=0;
				}
			}
		}
	}

	/* --- Save new map --- */

	if (!errflg && !(options & TEST_MODE) && printed_header>0)
	{
		FOPEN(out, fn, "w")

		for (i=0, curr_map=maps; !errflg && i<num_maps; i++, curr_map++)
		{
			if (curr_map->game_name)
				fprintf(out, "%s,%s,%s\n", curr_map->game_name, curr_map->map_name, curr_map->map_type);
		}

		FCLOSE(out)
	}

	/* --- Release the map from memory --- */

	FREE(map_buffer)

	/* --- Return error code --- */

	return(errflg);
}

