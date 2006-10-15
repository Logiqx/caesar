/* --- A little utility to scan a directory for files and output their details --- */

/* --- The standard includes --- */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <dirent.h>
#include <sys/stat.h>


/* --- Although DJGPP has a getopt function, MinGW, CygWin and MSVC don't --- */

#if defined (__MINGW32_VERSION) || defined (__CYGWIN__) || defined (_MSC_VER)
#include "getopt.c"	// Same functions as in unistd library
#else
#include <unistd.h>
#endif


/* --- Constants --- */

#define PATH_LENGTH 256

#define PNG_FORMAT 1
#define JPG_FORMAT 2


/* --- Macros for common routines --- */

#define CALLOC(PTR, NUMBER, TYPE) \
if (!(PTR=calloc(NUMBER, sizeof(struct TYPE)))) \
{ \
	printf("Not enough memory\n"); \
	errflg++; \
}

#define CFREE(PTR) \
if (PTR) \
{ \
	free(PTR);\
}

#define FOPEN(PTR, FN, MODE) \
if (!(PTR=fopen(FN, MODE))) \
{ \
	printf("Error opening %s for mode '%s'\n", FN, MODE); \
	errflg++; \
}

#define FCLOSE(PTR) \
if (PTR) \
{ \
	fclose(PTR); \
	PTR=0; \
}

#define REMOVE_CR_LF(ST) \
while (ST[strlen(ST)-1]==10 || ST[strlen(ST)-1]==13) \
	ST[strlen(ST)-1]='\0';


/* --- Function prototypes --- */

int main(int argc, char **argv);
int scan_dir(char *dir, int);
int file_details(char *fn, struct stat *buf, int);


/* --- The main code --- */

int main(int argc, char **argv)
{
	int c, images=0, errflg=0;

	while (!errflg && (c = getopt(argc, argv, "i")) != EOF)
	switch (c)
	{
		case 'i':
			images++;
			break;
	}

	errflg=scan_dir(".", images);

	return(errflg);
}

int scan_dir(char *dir, int images)
{                                                  
	DIR *dirp;                                    
	struct dirent *direntp;                       
	struct stat buf;
	char fn[PATH_LENGTH+1];
	int errflg=0;

	if ((dirp=opendir(dir))==0)
		errflg++;

	while (!errflg && ((direntp = readdir(dirp)) != NULL))
	{
		sprintf(fn, "%s/%s", dir, direntp->d_name);
		if (stat(fn, &buf) == 0)
		{
			if (buf.st_mode & S_IFDIR)
			{
				if (direntp->d_name[0]!='.')
					errflg+=scan_dir(fn, images);
			}
			else
			{
				errflg+=file_details(fn, &buf, images);
			}
		}
		else
		{
			printf("Error getting attributes of %s\n", fn);
			errflg++;
		}
	}

	return(errflg);
}


int file_details(char *fn, struct stat *buf, int images)
{
	char st[PATH_LENGTH+1];

	int file_format=0;
	long width=0, height=0;
	unsigned char byte;
	int i;
	FILE *in=0;
	int errflg=0;

	strcpy(st, fn);
	*strrchr(st, '/')='\t';

	if (images)
	{
		if (!strcmp(&fn[strlen(fn)-4], ".png"))
			file_format=PNG_FORMAT;

		if (!strcmp(&fn[strlen(fn)-4], ".jpg"))
			file_format=JPG_FORMAT;
	}

	if (file_format!=0)
		FOPEN(in, fn, "rb")

	if (!errflg)
	{
		if (file_format==PNG_FORMAT)
		{
			fseek(in, 16, 0);
			for (i=0; i<4; i++)
			{
				width=width<<8;
				fread(&byte, 1, 1, in);
				width|=byte;
			}
			
			for (i=0; i<4; i++)
			{
				height=height<<8;
				fread(&byte, 1, 1, in);
				height|=byte;
			}

			if (st[1]=='\t')
				printf("%s\t%ld\t%ld\t%ld\n", st, buf->st_size, width, height);
			else
				printf("%s\t%ld\t%ld\t%ld\n", st+2, buf->st_size, width, height);
		}

		else if (file_format==JPG_FORMAT)
		{
			fseek(in, 163, 0);
			for (i=0; i<2; i++)
			{
				height=height<<8;
				fread(&byte, 1, 1, in);
				height|=byte;
			}
			
			for (i=0; i<2; i++)
			{
				width=width<<8;
				fread(&byte, 1, 1, in);
				width|=byte;
			}

			if (st[1]=='\t')
				printf("%s\t%ld\t%ld\t%ld\n", st, buf->st_size, width, height);
			else
				printf("%s\t%ld\t%ld\t%ld\n", st+2, buf->st_size, width, height);
		}

		else
		{
			if (st[1]=='\t')
				printf("%s\t%ld\n", st, buf->st_size);
			else
				printf("%s\t%ld\n", st+2, buf->st_size);
		}
	}

	FCLOSE(in)

	return(errflg);
}
