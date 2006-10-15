/* --------------------------------------------------------------------------
 * MAP2TXT - The PHP and MySQL version of CAESAR!
 * Written by Logiqx, http://www.logiqx.com
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define MAP2TXT_VERSION "v1.0"
#define MAP2TXT_DATE "2 January 2005"


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


/* --- MAP2TXT definitions and macros --- */

#include "map2txt.h"


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main() function just cycles through the sections in the INI file
 * -------------------------------------------------------------------------- */

int main(int argc, char **argv)
{
	FILE *in=0, *out=0;
	char st[MAX_STRING_LENGTH];
	int errflg = 0;

	printf("===============================================================================\n");
	printf("MAP2TXT %s (%s) - using ", MAP2TXT_VERSION, MAP2TXT_DATE);
	display_datlib_version();
	printf("Written by Logiqx (http://www.logiqx.com)\n");
	printf("===============================================================================\n");

	if (argc!=3)
	{
		printf("Usage: map2txt <input> <output>\n\n");
		errflg++;
	}

	/* --- Open Files --- */

	if (!errflg)
		FOPEN(in, argv[1], "r")

	if (!errflg)
		FOPEN(out, argv[2], "w")

	/* --- Remove the .map extension from the input filename --- */

	if (!errflg && strstr(argv[1], ".map"))
		*strstr(argv[1], ".map")='\0';

	/* --- Process the input file --- */

	while(!errflg && fgets(st, MAX_STRING_LENGTH, in))
	{
		REMOVE_CR_LF(st)

		if (strchr(st, ',') != strrchr(st, ','))
		{
			if (strrchr(argv[1], '/'))
				fprintf(out, "%s\t", strrchr(argv[1], '/')+1);
			else
				fprintf(out, "%s\t", argv[1]);
			fprintf(out, "%s\t", strtok(st, ","));
			fprintf(out, "%s\t", strtok(NULL, ","));
			fprintf(out, "%s\t\n", strtok(NULL, ","));
		}
	}

	/* --- Close the output files --- */

	FCLOSE(in)
	FCLOSE(out)
	
	/* --- Done! --- */

	return(errflg);
}
