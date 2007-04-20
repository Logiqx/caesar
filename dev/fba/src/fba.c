/* --------------------------------------------------------------------------
 * FBA - Written by Logiqx (http://www.logiqx.com/)
 *
 * Generates a CMPro data file for using FBA snaps within CAESAR.
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define FBA_VERSION "v1.0"
#define FBA_DATE "20 APril 2007"


/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>


/* --- Dat library includes --- */

#include "datlib/src/datlib.h"
#include "datlib/src/macro.h"


/* --- Misc library includes --- */

#include "datlib/src/misc/getopt.h"


/* --- FBA definitions and macros --- */

#include "fba.h"


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main program
 * -------------------------------------------------------------------------- */

char *zips[]=
{
		"titles",
		"previews",
		0
};

int main(int argc, char **argv)
{
	char st[MAX_STRING_LENGTH];
	FILE *out=0;

	struct dat *mame=0, *fba=0;
	struct options *options=0;

	struct game *curr_mame_game=0;
	struct game *curr_fba_zip=0;
	struct rom *curr_fba_snap=0;
	struct game_idx *zip_match;
	struct rom_idx *rom_match;

	int i, j, image, errflg=0;

	/* --- Display version information --- */

	printf("===============================================================================\n");
	printf("FBA %s (%s) - using ", FBA_VERSION, FBA_DATE);
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
		printf("Usage: fba <mame dat> <fba dir>\n");
	}

	if (!errflg)
	{
		/* --- Always show a summary after loading --- */

		options->options|=OPTION_SHOW_SUMMARY;

		/* --- Initialise the mame dat --- */

		options->fn=argv[1];

		if (!errflg && (mame=init_dat(options))==0)
			errflg++;

		/* --- Initialise the fba dat --- */

		options->options=OPTION_LOAD_QUIETLY;

		options->fn=argv[2];

		if (!errflg && (fba=init_dat(options))==0)
			errflg++;

		/* --- Do the business --- */

		if (!errflg)
			FOPEN(out, "fba.dat", "w")

		if (!errflg)
		{
			fprintf(out, "clrmamepro (\n");
			fprintf(out, "\tname fba\n");
			fprintf(out, ")\n\n");

			fprintf(out, "game (\n");
			fprintf(out, "\tname finalburnalpha\n");
			fprintf(out, "\tdescription \"FBA snaps\"\n");

			for (i=0, curr_mame_game=mame->games; i<mame->num_games; i++, curr_mame_game++)
			{
				image=1;

				for (j=0; !(curr_mame_game->game_flags & FLAG_RESOURCE_NAME) && zips[j]; j++)
				{
					if ((zip_match=bsearch((void *)zips[j], fba->game_name_idx, fba->num_games, sizeof(struct game_idx), find_game_by_name))!=0)
					{
						curr_fba_zip=zip_match->game;

						/* --- Search for game.png --- */

						sprintf(st, "%s.png", curr_mame_game->name);
						if ((rom_match=bsearch((void *)st, curr_fba_zip->rom_name_idx, curr_fba_zip->num_roms, sizeof(struct rom_idx), find_rom_by_name))!=0)
						{
							fprintf(out, "\trom ( name %s_%d.png size %lu crc %08lx )\n", curr_mame_game->name, image, (unsigned long) rom_match->rom->size, (unsigned long) rom_match->rom->crc);
							rom_match->rom->match=1;
							image++;

							/* --- Search for game*.png --- */

							while (rom_match>curr_fba_zip->rom_name_idx &&
								!strncmp(curr_mame_game->name, (rom_match-1)->rom->name, strlen(curr_mame_game->name)))
							{
								rom_match--;
							}
	
							while ( rom_match<curr_fba_zip->rom_name_idx+curr_fba_zip->num_roms &&
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
				if ((zip_match=bsearch((void *)zips[i], fba->game_name_idx, fba->num_games, sizeof(struct game_idx), find_game_by_name))!=0)
				{
					printf("\nTesting %s...\n", zips[i]);

					curr_fba_zip=zip_match->game;

					for (j=0, curr_fba_snap=curr_fba_zip->roms; j<curr_fba_zip->num_roms; j++, curr_fba_snap++)
					{
						if (curr_fba_snap->match==0 && !strstr(curr_fba_snap->name, ".txt"))
						{
							printf("   Unknown: %s\n", curr_fba_snap->name);
						}
					}

					printf("Done!\n");
				}
			}
		}

		FCLOSE(out)

		/* --- Release dat(s) from memory --- */

		fba=free_dat(fba);

		mame=free_dat(mame);
	}

	if (datlib_debug)
	{
		printf("%-16s: ", "FBA.main");
		printf("Freeing memory of options...\n");
	}

	FREE(options);

	return(errflg);
}

