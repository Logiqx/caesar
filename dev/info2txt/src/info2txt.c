/* --------------------------------------------------------------------------
 * Info2Txt - Written by Logiqx (http://www.logiqx.com/)
 *
 * A simple little utility for MAMEInfo and History to tab delimited format
 * -------------------------------------------------------------------------- */

/* --- Version information --- */

#define INFO2TXT_VERSION "v1.0"
#define INFO2TXT_DATE "6 October 2005"


/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>


/* --- Dat library includes --- */

#include "datlib/src/macro.h"


/* --- Dat library includes --- */

#include "info2txt.h"


/* --- Is DatLib debugging enabled? --- */

int datlib_debug=0;


/* --- Main function --- */

#define MAX_TEXT_LENGTH	4096

int main(int argc, char **argv)
{
	FILE *in=0, *out=0;
	char st[MAX_TEXT_LENGTH], *st_ptr, *type=argv[1];
	int pk=1, line_no=1, max_len=0, errflg=0;
	int in_bio=0, in_mame=0, in_drv=0;

	if (argc!=4)
	{
		fprintf(stderr, "Usage: %s <type> <input> <output>\n", argv[0]);
		errflg++;
	}

	if (!errflg)
		FOPEN(in, argv[2], "r")

	if (!errflg)
		FOPEN(out, argv[3], "w")

	while (!errflg && fgets(st, MAX_TEXT_LENGTH, in)!=0)
	{
		REMOVE_CR_LF(st)

		/* --- Change tabs to spaces --- */

		for (st_ptr=st; *st_ptr; st_ptr++)
		{
			if (*st_ptr=='\t')
				*st_ptr=' ';
		}

		/* --- Remember the longest line --- */

		if (strlen(st)>max_len)
			max_len=strlen(st);

		if (!strncmp(st, "$info=", 6))
		{
			while (st[strlen(st)-1]==',')
				st[strlen(st)-1]='\0';

			strtok(st, "=");

			while ((st_ptr=strtok(NULL, ","))!=0)
			{
				if (*st_ptr)
					fprintf(out, "%s_link\t%d\t%s\t\n", type, pk, st_ptr);
			}
		}
		else if (!strncmp(st, "$bio", 4))
		{
			line_no=1;
			in_bio++;
		}
		else if (!strncmp(st, "$mame", 4))
		{
			line_no=1;
			in_mame++;
		}
		else if (!strncmp(st, "$drv", 4))
		{
			line_no=1;
			in_drv++;
		}
		else if (!strncmp(st, "$end", 4))
		{
			in_bio=in_mame=in_drv=0;
			pk++;
		}
		else if (in_bio)
		{
			fprintf(out, "%s_text\tbio\t%d\t%d\t%s\t\n", type, pk, line_no, st);
			line_no++;
		}
		else if (in_mame)
		{
			fprintf(out, "%s_text\tmame\t%d\t%d\t%s\t\n", type, pk, line_no, st);
			line_no++;
		}
		else if (in_drv)
		{
			fprintf(out, "%s_text\tdrv\t%d\t%d\t%s\t\n", type, pk, line_no, st);
			line_no++;
		}
	}

	if (max_len>=MAX_TEXT_LENGTH-1)
	{
		fprintf(stderr, "Maximum text length reached (%d).\n", MAX_TEXT_LENGTH);
		errflg++;
	}

	FCLOSE(out)
	FCLOSE(in)

	return(errflg);
}
