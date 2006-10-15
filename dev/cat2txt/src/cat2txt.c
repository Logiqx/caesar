/* --------------------------------------------------------------------------
 * Cat2Txt - Written by Logiqx (http://www.logiqx.com/)
 *
 * A simple little utility for converting CatVer to tab delimited format
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define CAT2TXT_VERSION "v1.0"
#define CAT2TXT_DATE "12 October 2005"


/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>


/* --- Dat library includes --- */

#include "datlib/src/macro.h"


/* --- Dat library includes --- */

#include "cat2txt.h"


/* --- Is DatLib debugging enabled? --- */

int datlib_debug=0;


/* --- Main function --- */

#define MAX_TEXT_LENGTH	4096

int main(int argc, char **argv)
{
	FILE *in=0, *out=0;
	char st[MAX_TEXT_LENGTH];
	int in_category=0, errflg=0;

	if (argc!=3)
	{
		fprintf(stderr, "Usage: %s <input> <output>\n", argv[0]);
		errflg++;
	}

	if (!errflg)
		FOPEN(in, argv[1], "r")

	if (!errflg)
		FOPEN(out, argv[2], "w")

	while (!errflg && fgets(st, MAX_TEXT_LENGTH, in)!=0)
	{
		REMOVE_CR_LF(st)

		if (*st=='[')
			in_category=0;

		if (!strcmp(st, "[Category]"))
			in_category++;

		if (in_category && strchr(st, '='))
		{
			fprintf(out, "%s\t", strtok(st, "="));
			fprintf(out, "%s\t\n", strtok(NULL, "="));
		}
	}

	FCLOSE(out)
	FCLOSE(in)

	return(errflg);
}
