/* --------------------------------------------------------------------------
 * CrashTest - Written by Logiqx (http://www.logiqx.com/)
 *
 * Generates a CMPro data file for using CrashTest snaps within CAESAR.
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define CRASHTEST_VERSION "v1.1"
#define CRASHTEST_DATE "17 August 2004"


/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>


/* --- Dat library includes --- */

#include "datlib/src/datlib.h"
#include "datlib/src/macro.h"


/* --- Misc library includes --- */

#include "datlib/src/misc/getopt.h"


/* --- CrashTest definitions and macros --- */

#include "crashtest.h"


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main program
 * -------------------------------------------------------------------------- */

char *zips[]=
{
		"titles",
		"select",
		"versus",
		"wallpaper",
		"snap",
		0
};

int main(int argc, char **argv)
{
	char st[MAX_STRING_LENGTH];
	FILE *out=0;

	struct dat *mame=0, *crashtest=0;
	struct options *options=0;

	struct game *curr_mame_game=0;
	struct game *curr_crashtest_zip=0;
	struct rom *curr_crashtest_snap=0;
	struct game_idx *zip_match;
	struct rom_idx *rom_match;

	int i, j, image, errflg=0;

	/* --- Display version information --- */

	printf("===============================================================================\n");
	printf("CrashTest %s (%s) - using ", CRASHTEST_VERSION, CRASHTEST_DATE);
	display_datlib_version();
	printf("Written by Logiqx (http://www.logiqx.com/)\n");
	printf("===============================================================================\n");

	/* --- Allocate memory for user options --- */

	STRUCT_CALLOC(options, 1, sizeof(struct options))

	/* --- The user must specify either one or two dat files --- */

	if (argc!=3)
		errflg++;

	/* --- Display the help page if required --- */

	if (errflg)
	{
		printf("Usage: crashtest <mame dat> <crashtest dir>\n");
	}

	if (!errflg)
	{
		/* --- Always show a summary after loading --- */

		options->options|=OPTION_SHOW_SUMMARY;

		/* --- Initialise the mame dat --- */

		options->fn=argv[1];

		if (!errflg && (mame=init_dat(options))==0)
			errflg++;

		/* --- Initialise the crashtest dat --- */

		options->options=OPTION_LOAD_QUIETLY;

		options->fn=argv[2];

		if (!errflg && (crashtest=init_dat(options))==0)
			errflg++;

		/* --- Do the business --- */

		if (!errflg)
			FOPEN(out, "crashtest.dat", "w")

		if (!errflg)
		{
			fprintf(out, "clrmamepro (\n");
			fprintf(out, "\tname crashtest\n");
			fprintf(out, ")\n\n");

			fprintf(out, "game (\n");
			fprintf(out, "\tname mame\n");
			fprintf(out, "\tdescription \"MAME snaps\"\n");

			for (i=0, curr_mame_game=mame->games; i<mame->num_games; i++, curr_mame_game++)
			{
				image=1;

				for (j=0; !(curr_mame_game->game_flags & FLAG_RESOURCE_NAME) && zips[j]; j++)
				{
					if ((zip_match=bsearch((void *)zips[j], crashtest->game_name_idx, crashtest->num_games, sizeof(struct game_idx), find_game_by_name))!=0)
					{
						curr_crashtest_zip=zip_match->game;

						/* --- Search for game.png --- */

						sprintf(st, "%s.png", curr_mame_game->name);
						if ((rom_match=bsearch((void *)st, curr_crashtest_zip->rom_name_idx, curr_crashtest_zip->num_roms, sizeof(struct rom_idx), find_rom_by_name))!=0)
						{
							fprintf(out, "\trom ( name %s_%d.png size %lu crc %08lx )\n", curr_mame_game->name, image, (unsigned long) rom_match->rom->size, (unsigned long) rom_match->rom->crc);
							rom_match->rom->match=1;
							image++;

							/* --- Search for game*.png --- */

							while (rom_match>curr_crashtest_zip->rom_name_idx &&
								!strncmp(curr_mame_game->name, (rom_match-1)->rom->name, strlen(curr_mame_game->name)))
							{
								rom_match--;
							}
	
							while ( rom_match<curr_crashtest_zip->rom_name_idx+curr_crashtest_zip->num_roms &&
								!strncmp(curr_mame_game->name, rom_match->rom->name, strlen(curr_mame_game->name)))
							{
								/* --- Search for game-*.png --- */

								sprintf(st, "%s-", curr_mame_game->name);

								if (!strncmp(st, rom_match->rom->name, strlen(st)))
								{
									strncpy(st, rom_match->rom->name, strlen(rom_match->rom->name)-4);
									st[strlen(rom_match->rom->name)-4]='\0';

									if ((bsearch((void *)st, mame->game_name_idx, mame->num_games, sizeof(struct game_idx), find_game_by_name))==0)
									{
										fprintf(out, "\trom ( name %s_%d.png size %lu crc %08lx )\n", curr_mame_game->name, image, (unsigned long) rom_match->rom->size, (unsigned long) rom_match->rom->crc);
										rom_match->rom->match=1;
										image++;
									}
								}

								/* --- Search for game#*.png --- */

								sprintf(st, "%s#", curr_mame_game->name);

								if (!strncmp(st, rom_match->rom->name, strlen(st)))
								{
									strncpy(st, rom_match->rom->name, strlen(rom_match->rom->name)-4);
									st[strlen(rom_match->rom->name)-4]='\0';

									if ((bsearch((void *)st, mame->game_name_idx, mame->num_games, sizeof(struct game_idx), find_game_by_name))==0)
									{
										fprintf(out, "\trom ( name %s_%d.png size %lu crc %08lx )\n", curr_mame_game->name, image, (unsigned long) rom_match->rom->size, (unsigned long) rom_match->rom->crc);
										rom_match->rom->match=1;
										image++;
									}
								}

								rom_match++;
							}
						}
					}
				}
			}

			fprintf(out, ")\n");

			for (i=0; zips[i]; i++)
			{
				if ((zip_match=bsearch((void *)zips[i], crashtest->game_name_idx, crashtest->num_games, sizeof(struct game_idx), find_game_by_name))!=0)
				{
					printf("\nTesting %s...\n", zips[i]);

					curr_crashtest_zip=zip_match->game;

					for (j=0, curr_crashtest_snap=curr_crashtest_zip->roms; j<curr_crashtest_zip->num_roms; j++, curr_crashtest_snap++)
					{
						if (curr_crashtest_snap->match==0 && !strstr(curr_crashtest_snap->name, ".txt"))
						{
							printf("   Unknown: %s\n", curr_crashtest_snap->name);
						}
					}

					printf("Done!\n");
				}
			}
		}

		FCLOSE(out)

		/* --- Release dat(s) from memory --- */

		crashtest=free_dat(crashtest);

		mame=free_dat(mame);
	}

	if (datlib_debug)
	{
		printf("%-16s: ", "CrashTest.main");
		printf("Freeing memory of options...\n");
	}

	FREE(options);

	return(errflg);
}
