/* --------------------------------------------------------------------------
 * XML2TXT - The PHP and MySQL version of CAESAR!
 * Written by Logiqx, http://www.logiqx.com
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define XML2TXT_VERSION "v1.0"
#define XML2TXT_DATE "12 March 2005"


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


/* --- XML2TXT definitions and macros --- */

#include "xml2txt.h"


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main() function just cycles through the sections in the INI file
 * -------------------------------------------------------------------------- */

int main(int argc, char **argv)
{
	FILE *in=0, *out=0;
	char st[MAX_STRING_LENGTH];
	char *tmp_fn="xml2txt.tmp";
	char *c;
	int errflg = 0;

	printf("===============================================================================\n");
	printf("XML2TXT %s (%s) - using ", XML2TXT_VERSION, XML2TXT_DATE);
	display_datlib_version();
	printf("Written by Logiqx (http://www.logiqx.com)\n");
	printf("===============================================================================\n");

	if (argc!=5)
	{
		printf("Usage: xml2txt <exe> <xsl> <input> <output>\n\n");
		errflg++;
	}

	/* --- Run the Sablotron --- */

	if (!errflg)
	{
		sprintf(st, "%s %s %s %s", argv[1], argv[2], argv[3], tmp_fn);
		printf("Running '%s'...\n", st);
		errflg=system(st);
	}

	/* --- Open Files --- */

	if (!errflg)
		FOPEN(in, tmp_fn, "r")

	if (!errflg)
		FOPEN(out, argv[4], "w")

	/* --- Process the input file --- */

	if (!errflg)
		printf("Adding '\\N' into '%s' and saving as '%s'...\n", tmp_fn, argv[4]);

	while(!errflg && fgets(st, MAX_STRING_LENGTH, in))
	{
		REMOVE_CR_LF(st)

		for (c=st; *c; c++)
		{
			if (c>st && *c=='\t' && *(c-1)=='\t')
				fprintf(out, "\\N");

			fprintf(out, "%c", *c);
		}

		if (*(c-1)=='\t')
			fprintf(out, "\\N");

		fprintf(out, "\n");
	}

	/* --- Close the output files --- */

	FCLOSE(in)
	FCLOSE(out)
	
	/* --- Remove the temporary file --- */

	unlink(tmp_fn);

	/* --- Done! --- */

	return(errflg);
}
