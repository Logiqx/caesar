/* --------------------------------------------------------------------------
 * Images - Written by Logiqx (http://www.logiqx.com/)
 *
 * Generates a CMPro data file for using images within CAESAR.
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define IMAGES_VERSION "v1.0"
#define IMAGES_DATE "17 August 2004"


/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>


/* --- Dat library includes --- */

#include "datlib/src/datlib.h"
#include "datlib/src/macro.h"


/* --- Misc library includes --- */

#include "datlib/src/misc/getopt.h"


/* --- Images definitions and macros --- */

#include "images.h"


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main program
 * -------------------------------------------------------------------------- */

char *zips[]=
{
	"cabinets",
	"flyers",
	"marquees",
	0
};

int main(int argc, char **argv)
{
	char st[MAX_STRING_LENGTH];
	FILE *out=0;

	struct dat *mame=0, *images=0;
	struct options *options=0;

	struct game *curr_images_zip=0;
	struct rom *curr_images_snap=0;
	struct game_idx *zip_match;

	int i, j, errflg=0;

	/* --- Display version information --- */

	printf("===============================================================================\n");
	printf("Images %s (%s) - using ", IMAGES_VERSION, IMAGES_DATE);
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
		printf("Usage: images <mame dat> <resources dir>\n");
	}

	if (!errflg)
	{
		/* --- Always show a summary after loading --- */

		options->options|=OPTION_SHOW_SUMMARY;

		/* --- Initialise the mame dat --- */

		options->fn=argv[1];

		if (!errflg && (mame=init_dat(options))==0)
			errflg++;

		/* --- Initialise the images dat --- */

		options->options=OPTION_LOAD_QUIETLY;

		/* --- Do the business --- */

		if (!errflg)
			FOPEN(out, "images.dat", "w")

		if (!errflg)
		{
			fprintf(out, "clrmamepro (\n");
			fprintf(out, "\tname images\n");
			fprintf(out, ")\n\n");

			for (i=0; zips[i]; i++)
			{
				sprintf(st, "%s/%s", argv[2], zips[i]);
				options->fn=st;

				if (!errflg && (images=init_dat(options))==0)
					errflg++;

				if (!errflg && (zip_match=bsearch((void *)zips[i], images->game_name_idx, images->num_games, sizeof(struct game_idx), find_game_by_name))!=0)
				{
					printf("\nTesting %s...\n", zips[i]);

					fprintf(out, "game (\n");
					fprintf(out, "\tname %s\n", zips[i]);
					fprintf(out, "\tdescription \"%s\"\n", zips[i]);

					curr_images_zip=zip_match->game;

					for (j=0, curr_images_snap=curr_images_zip->roms; j<curr_images_zip->num_roms; j++, curr_images_snap++)
					{
						strcpy(st, curr_images_snap->name);
						if (strstr(st, ".png"))
							*strstr(st, ".png")='\0';

						if ((zip_match=bsearch((void *)st, mame->game_name_idx, mame->num_games, sizeof(struct game_idx), find_game_by_name))!=0)
						{
							if (zip_match->game->game_flags & FLAG_RESOURCE_NAME)
								printf("   Resource: %s\n", curr_images_snap->name);
							else
								fprintf(out, "\trom ( name %s size %lu crc %08lx )\n", curr_images_snap->name, (unsigned long) curr_images_snap->size, (unsigned long) curr_images_snap->crc);
						}
						else
						{
							printf("   Unknown: %s\n", curr_images_snap->name);
						}
					}

					fprintf(out, ")\n\n");

					printf("Done!\n");
				}

				images=free_dat(images);
			}
		}

		FCLOSE(out)

		/* --- Release dat(s) from memory --- */

		mame=free_dat(mame);
	}

	if (datlib_debug)
	{
		printf("%-16s: ", "Images.main");
		printf("Freeing memory of options...\n");
	}

	FREE(options);

	return(errflg);
}
