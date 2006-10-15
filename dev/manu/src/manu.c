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

/* --- Version information --- */

#define MANU_VERSION "v2.0"
#define MANU_DATE "24 August 2004"


/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>


/* --- Dat library includes --- */

#include "datlib/src/datlib.h"
#include "datlib/src/macro.h"


/* --- Misc library includes --- */

#include "datlib/src/misc/getopt.h"


/* --- Manu definitions and macros --- */

#include "manu.h"


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main program
 * -------------------------------------------------------------------------- */

int main(int argc, char **argv)
{
	/* --- For getopt function --- */

	extern int optind;

	struct dat *dat=0;
	struct options *options=0;

	int errflg=0;

	/* --- Display version information --- */

	printf("===============================================================================\n");
	printf("Manu %s (%s) - using ", MANU_VERSION, MANU_DATE);
	display_datlib_version();
	printf("Written by Logiqx (http://www.logiqx.com/)\n");
	printf("===============================================================================\n");

	/* --- Allocate memory for user options --- */

	STRUCT_CALLOC(options, 1, sizeof(struct options))

	/* --- The user must specify either one dat file --- */

	if (argc-optind!=1)
		errflg++;

	/* --- Display the help page if required --- */

	if (errflg)
	{
		printf("Usage: manu <datfile>\n");
	}

	if (!errflg)
	{
		/* --- Always show a summary after loading --- */

		options->options|=OPTION_SHOW_SUMMARY;

		/* --- User must have specified an input name --- */

		options->fn=argv[optind];

		/* --- Initialise the main dat --- */

		if (!errflg && (dat=init_dat(options))==0)
			errflg++;

		/* --- List manufacturers --- */

		if (!errflg)
			errflg=list_manufacturers(dat);

		/* --- Release dat(s) from memory --- */

		dat=free_dat(dat);
	}

	if (datlib_debug)
	{
		printf("%-16s: ", "Manu.main");
		printf("Freeing memory of options...\n");
	}

	FREE(options);

	return(errflg);
}

int list_manufacturers(struct dat *dat)
{
	FILE *out=0;
	char *match;
	//char c;

	struct manufacturer *manu;

	int i, j, num_manu=0, dups;
	int errflg=0;

	/* --- 0. Allocate memory for manufacturer list --- */

	STRUCT_CALLOC(manu, dat->num_games, sizeof(struct manufacturer))

	/* --- 1. Create array containing manufacturer names --- */

	for (i=0; !errflg && i<dat->num_games; i++)
		manu[i].name=dat->games[i].manufacturer;

	/* --- 2. Count number of instances of each unique manufacturers --- */

	if (!errflg)
		qsort(manu, dat->num_games, sizeof(struct manufacturer), sort_manufacturers_by_name);

	for (i=0; !errflg && i<dat->num_games; i++)
	{
		if (num_manu && !strcmp(manu[i].name, manu[num_manu-1].name))
		{
			manu[num_manu-1].count++;
		}
		else
		{
			manu[num_manu].name=manu[i].name;
			manu[num_manu].count=1;
			num_manu++;
		}
	}

	/* --- 3. Group manufacturers together --- */

	/* --- Clever bit is:
	       Ignore any manufacturer where another manufacturer is a substring.
	       e.g. Ignore Taito America and Taito Japan (because Taito exists). --- */

	for (i=0; !errflg && i<num_manu; i++)
	{
		manu[i].total=0; dups=0;

		for (j=0; j<num_manu; j++)
		{
			if (manu[i].count>1)
			{
				match=strstr(manu[j].name, manu[i].name);

				/*if (match)
				{
					c=match[strlen(manu[i].name)];
					if ((c>='a' && c<='z') || (c>='A' && c<='Z'))
					{
						printf("%s - %s (%c)\n", manu[j].name, manu[i].name, c);
						match=0;
					}
				}*/

				if (match)
				{
					manu[i].total+=manu[j].count;
				}

				if (strcmp(manu[i].name, manu[j].name) &&
					strstr(manu[i].name, manu[j].name) &&
					manu[j].count>1)
				{
					dups++;
				}

				if (dups) manu[i].total=0;
			}
		}
	}

	/* --- 4. Output a list of all manufacturer names with more than 10 games --- */

	if (!errflg)
		FOPEN(out, "manufacturers.txt", "w")

	for (i=0; !errflg && i<num_manu; i++)
	{
		if (manu[i].total>=10)
		{
			fprintf(out, "%s\n", manu[i].name);
		}
	}

	/* --- All done - clean up and exit --- */

	FCLOSE(out)

	FREE(manu)

	return(errflg);
}

int sort_manufacturers_by_name(const void *idx1, const void *idx2)
{
	return(strcmp(((struct manufacturer *)idx1)->name, ((struct manufacturer *)idx2)->name));
}

