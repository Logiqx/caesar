/* --------------------------------------------------------------------------
 * NotIn - Written by Logiqx (http://www.logiqx.com/)
 *
 * Support script for CAESAR
 * -------------------------------------------------------------------------- */

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


/* --- ROMBuild definitions and macros --- */

#include "rombuild/src/rombuild.h"


/* --- NotIn definitions and macros --- */

#include "notin.h"


/* --- The ROM manipulation definitions --- */

extern struct Emulator ems[];


/* --- Is DatLib debugging enabled? --- */

extern int datlib_debug;


/* --------------------------------------------------------------------------
 * The main() function just works out what the user wants to do then calls the
 * appropriate function.
 *
 * Uses the getopt() function from unistd to interpret command line options.
 * -------------------------------------------------------------------------- */

int main(int argc, char **argv)
{
	/* --- For getopt function --- */

	extern int optind;

	struct stat buf;

	char c;
	int dat_check=0, non_mame_check=0;
	int errflg=0;

	printf("===============================================================================\n");
	printf("NotIn - using ");
	display_datlib_version();
	printf("Written by Logiqx (http://www.logiqx.com/)\n");
	printf("===============================================================================\n");

	/* --- Get the options specified on the command line --- */

	while ((c = getopt(argc, argv, "dn?")) != EOF)
	switch (c)
	{
		case 'd':
			dat_check++;
			break;
		case 'n':
			non_mame_check++;
			break;
		case '?':
			errflg++;   /* User wants help! */
	}

	/* --- The user must specify either one or two dat files --- */

	if (argc-optind!=2)
		errflg++;

	/* --- Display the help page if required --- */

	if (errflg)
		printf("Usage: notin [-d|-n] <mame dat> <non-mame dat>\n");

	if (!errflg && stat("logs", &buf))
	{
		MKDIR("logs", S_IRWXU)
	}

	if (!errflg)
	{
		if (non_mame_check)
			errflg=check_non_mame(argv[optind], argv[optind+1]);
		else
			errflg=process_dats(argv[optind], argv[optind+1], dat_check);
	}

	/* --- All done --- */

	return(errflg);
}

/* --------------------------------------------------------------------------
 * Processing
 * -------------------------------------------------------------------------- */

int check_non_mame(char *mame_fn, char *non_mame_fn)
{
	struct dat *mame_dat=0, *non_mame_dat=0;
	struct options *options=0;

	int errflg=0;

	/* --- Allocate memory for user options --- */

	STRUCT_CALLOC(options, 1, sizeof(struct options))

	if (!errflg)
	{
		options->options=OPTION_SHOW_SUMMARY;
		options->fn=mame_fn;
	}

	if (!errflg && (mame_dat=init_dat(options))==0)
		errflg++;

	if (!errflg)
	{
		printf("\n");
		options->fn=non_mame_fn;
	}

	if (!errflg && (non_mame_dat=init_dat(options))==0)
		errflg++;

	if (!errflg)
	{
		printf("\n");
		errflg=verify_non_mame(mame_dat, non_mame_dat, "logs/nonmame.log");
	}

	clean_log_dir();

	free_dat(non_mame_dat);
	free_dat(mame_dat);

	FREE(options)

	printf("\nAll done!\n");

	return(errflg);
}

int process_dats(char *mame_fn, char *non_mame_fn, int dat_check)
{
	struct options *options=0;
	struct dat *mame_dat=0, *non_mame_dat=0;
	DIR *dirp;                                    
	struct dirent *direntp;                       
	struct stat buf;
	int errflg=0;

	/* --- Allocate memory for user options --- */

	STRUCT_CALLOC(options, 1, sizeof(struct options))

	if (!errflg)
	{
		options->options=OPTION_SHOW_SUMMARY;
		options->fn=mame_fn;
	}

	if (!errflg && (mame_dat=init_dat(options))==0)
		errflg++;

	if (!errflg)
	{
		printf("\n");
		errflg=verify_mame_rominfo(mame_dat);
		options->fn=non_mame_fn;
	}

	if (!errflg && (non_mame_dat=init_dat(options))==0)
		errflg++;

	if (!errflg)
	{
		printf("\n");
		errflg=verify_non_mame(mame_dat, non_mame_dat, "logs/nonmame.log");
	}

	if (!errflg)
	{
		dirp = opendir(".");

		while (!errflg && dirp && ((direntp = readdir(dirp)) != NULL))
		{
			if (strncmp(direntp->d_name, "logs", 4) &&
				strcmp(direntp->d_name, "..") &&
				strcmp(direntp->d_name, ".") &&
				!stat(direntp->d_name, &buf) &&
				(buf.st_mode & S_IFDIR))
			{
				errflg=verify_dir(direntp->d_name, mame_dat, non_mame_dat, dat_check);
			}
		}

		if (dirp) closedir(dirp);
	}

	clean_log_dir();

	free_dat(mame_dat);
	free_dat(non_mame_dat);

	FREE(options)

	printf("\nAll done!\n");

	return(errflg);
}

int verify_mame_rominfo(struct dat *mame_dat)
{
	FILE *out=0;

	struct Rom *roms;
	struct game_idx *game_match;

	int i=0, j, k, found;
	
	int errflg=0;

	FOPEN(out, "logs/rominfo.err", "w")

	if (!errflg)
		printf("Validating MAME details in ROMBuild...\n");

	while(!errflg && ems[i].descr)
	{
		roms=ems[i].roms;

		found=j=0;
		while (roms[j].local.game)
		{
			if (roms[j].type==BLOCK_FILL || !strcmp(roms[j].mame.game, "zzzzzzzz"))
			{	
				/* Ignore because it is a small ROM provided with ROMBuild */
			}
			else
			{
				if ((game_match=bsearch(roms[j].mame.game, mame_dat->game_name_idx, mame_dat->num_games, sizeof(struct game_idx), find_game_by_name)))
				{
					for (found=k=0; k<game_match->game->num_roms; k++)
					{
						if (!strcmp(roms[j].mame.rom, game_match->game->roms[k].name) && roms[j].mame.crc==game_match->game->roms[k].crc)
							found++;
					}

					if (!found)
						fprintf(out, "Not in MAME: %s/%s (%ld bytes, %08lx)\n", roms[j].mame.game, roms[j].mame.rom, (roms[j].mame.size), roms[j].mame.crc);
				}
				else
				{
						fprintf(out, "Not in MAME: %s\n", roms[j].mame.game);
				}
			}

			j++;
		}

		i++;
	}

	FCLOSE(out)

	return(errflg);
}

int verify_local_rominfo(struct dat *local_dat, char *basename)
{
	FILE *out=0;

	struct Rom *roms;
	struct game_idx *game_match;

	int i=0, j, k, found;
	int errflg=0;
	
	FOPEN(out, "logs/rominfo.err", "w+")

	while(ems[i].descr)
	{
		for (j=0; j<strlen(ems[i].descr); j++)
		{
			if (ems[i].descr[j]==' ')
				ems[i].descr[j]='_';
		}

		if (!strcmp(ems[i].descr, basename))
		{
			roms=ems[i].roms;

			found=j=0;
			while (roms[j].local.game)
			{
				if ((game_match=bsearch((void *)roms[j].local.game, local_dat->game_name_idx, local_dat->num_games, sizeof(struct game_idx), find_game_by_name)))
				{
					for (found=k=0; k<game_match->game->num_roms; k++)
					{
						if (!strcmp(roms[j].local.rom, game_match->game->roms[k].name) && roms[j].local.crc==game_match->game->roms[k].crc)
							found++;
					}
					if (!found)
						printf("ROM not in %s Dat: %s/%s (%ld bytes, %08lx)\n", ems[i].descr, roms[j].local.game, roms[j].local.rom, roms[j].local.size, roms[j].local.crc);
				}
				else
				{
					printf("Game not in %s Dat: %s\n", ems[i].descr, roms[j].local.game);
				}
	
				j++;
			}
		}

		i++;
	}

	FCLOSE(out)

	return(errflg);
}

int verify_non_mame(struct dat *mame_dat, struct dat *non_mame_dat, char *log_fn)
{
	FILE *log=0;
	int i=0, j=0, found;
	int errflg=0;

	FOPEN(log, log_fn, "w")

	if (!errflg)
	{
		for (i=0; i<non_mame_dat->num_games; i++)
		{	
			if (i && !strcmp(non_mame_dat->game_name_idx[i].game->name, non_mame_dat->game_name_idx[i-1].game->name))
			{
				fprintf(log, "Duplicate game in non-MAME dat: %s\n", non_mame_dat->game_name_idx[i].game->name);
			}

			if (bsearch((void *)non_mame_dat->game_name_idx[i].game->name, mame_dat->game_name_idx, mame_dat->num_games, sizeof(struct game_idx), find_game_by_name))
			{
				fprintf(log, "Name conflict with MAME dat: %s\n", non_mame_dat->game_name_idx[i].game->name);
			}

			if (non_mame_dat->game_name_idx[i].game->cloneof &&
				!bsearch((void *)non_mame_dat->game_name_idx[i].game->cloneof, mame_dat->game_name_idx, mame_dat->num_games, sizeof(struct game_idx), find_game_by_name) &&
				!bsearch((void *)non_mame_dat->game_name_idx[i].game->cloneof, non_mame_dat->game_name_idx, non_mame_dat->num_games, sizeof(struct game_idx), find_game_by_name))
			{
				fprintf(log, "Bad cloneof for %s name: %s\n", non_mame_dat->game_name_idx[i].game->name, non_mame_dat->game_name_idx[i].game->cloneof);
			}

			found=0;
			for (j=0; j<non_mame_dat->game_name_idx[i].game->num_roms; j++)
			{
				if (bsearch((const void *)&non_mame_dat->game_name_idx[i].game->roms[j].crc, mame_dat->rom_crc_idx, mame_dat->num_roms, sizeof(struct rom_idx), find_rom_by_crc))
					found++;
			}

			if (found)
				fprintf(log, "ROMs found for %12s: %02d/%02d (%s)\n", non_mame_dat->game_name_idx[i].game->name, found, non_mame_dat->game_name_idx[i].game->num_roms, found==non_mame_dat->game_name_idx[i].game->num_roms?"all":"partial");
		}
	}

	FCLOSE(log)

	return(errflg);
}

int verify_dir(char *dir, struct dat *mame_dat, struct dat *non_mame_dat, int dat_check)
{
	struct options *options=0;
	struct dat *curr_dat=0;
	struct game_map *curr_map=0;

	DIR *dirp;                                    
	struct dirent *direntp;                       

	char base_fn[MAX_FILENAME_LENGTH+1];
	char dat_fn[MAX_FILENAME_LENGTH+1];
	char map_fn[MAX_FILENAME_LENGTH+1];
	char log_fn[MAX_FILENAME_LENGTH+1];
	
	int errflg=0;

	dirp = opendir(dir);                          

	/* --- Allocate memory for user options --- */

	STRUCT_CALLOC(options, 1, sizeof(struct options))

	if (!errflg)
	{
		options->options=OPTION_LOAD_QUIETLY;
		options->fn=dat_fn;
	}

	printf("Verifying %s directory...\n", dir);

	while (!errflg && dirp && ((direntp = readdir(dirp)) != NULL))
	{
		if (strstr(direntp->d_name, ".dat") && strncmp("MAME", direntp->d_name, 4) && strcmp("dummy.dat", direntp->d_name))
		{
			strcpy(base_fn, direntp->d_name);
			*strstr(base_fn, ".dat")='\0';

			if (!errflg)
			{
				sprintf(dat_fn, "%s/%s.dat", dir, base_fn);
				if (!errflg && (curr_dat=init_dat(options))==0)
					errflg++;
			}

			if (!errflg)
				errflg=verify_local_rominfo(curr_dat, base_fn);

			if (!errflg)
			{
				sprintf(map_fn, "%s/%s.map", dir, base_fn);
				sprintf(log_fn, "logs/%s.map", base_fn);
				if ((curr_map=load_map(mame_dat, non_mame_dat, curr_dat, map_fn, log_fn))==0)
					errflg++;
			}

			if (!errflg)
			{
				errflg=verify_roms(mame_dat, curr_dat, curr_map, base_fn, dat_check);
			}

			free_map(curr_map);
			free_dat(curr_dat);
		}
	}

	if (dirp)
		closedir(dirp);    

	return(errflg);
}

int clean_log_dir(void)
{
	DIR *dirp;                                    
	struct dirent *direntp;                       
	struct stat buf;
	char fn[MAX_FILENAME_LENGTH+1];

	dirp = opendir("logs");                          

	printf("Cleaning log directory...\n");

	while (dirp && ((direntp = readdir(dirp)) != NULL))
	{
		sprintf(fn, "logs/%s", direntp->d_name);
		if (!stat(fn, &buf) && !buf.st_size)
			unlink(fn);
	}

	if (dirp)
		closedir(dirp);    

	return(0);
}

/* --------------------------------------------------------------------------
 * Loads map
 * -------------------------------------------------------------------------- */

struct game_map *load_map(struct dat *mame_dat, struct dat *non_mame_dat, struct dat *curr_dat, char *map_fn, char *log_fn)
{
	FILE *in=0, *out=0;

	char st[MAX_STRING_LENGTH+1], game_name[MAX_STRING_LENGTH+1];
	int i;

	struct game_map *game_maps=0;
	struct game_map *game_map=0;
	struct game_idx *game_match=0;

	int errflg=0;

	STRUCT_CALLOC(game_maps, curr_dat->num_games, sizeof(struct game_map))

	if (!errflg)
		for (i=0; i<curr_dat->num_games; i++)
			game_maps[i].game=curr_dat->game_name_idx[i].game;

	if (!errflg)
		FOPEN(in, map_fn, "r")

	if (!errflg)
		FOPEN(out, log_fn, "w")

	while (!errflg && fgets(st, MAX_STRING_LENGTH, in))
	{
		REMOVE_CR_LF(st)

		if (st[0])
		{
			strcpy(game_name, strtok(st, ","));
	
			if ((game_map=bsearch(&game_name, game_maps, curr_dat->num_games, sizeof(struct game_map), find_game_by_name)))
			{
				if (game_map->map)
					fprintf(out, "Duplicate local game: %s\n", game_name);

				strcpy(game_name, strtok(NULL, ","));
				game_map->type=*strtok(NULL, ",");

				if (game_map->type=='m')
				{
					if ((game_match=bsearch(game_name, mame_dat->game_name_idx, mame_dat->num_games, sizeof(struct game_idx), find_game_by_name)))
						game_map->map=game_match->game;
				}

				if (game_map->type=='n')
				{
					if ((game_match=bsearch(game_name, non_mame_dat->game_name_idx, non_mame_dat->num_games, sizeof(struct game_idx), find_game_by_name)))
						game_map->map=game_match->game;
				}

				if (game_map->type!='h' && game_map->map==0)
				{
					fprintf(out, "Invalid map for %s (%s - %c)\n", game_map->game->name, game_name, game_map->type);
				}
			}
			else
			{
				fprintf(out, "Invalid local game: %s\n", st);
			}
		}
	}

	for (i=0; !errflg && i<curr_dat->num_games; i++)
	{
		if (game_maps[i].type!='h' && !game_maps[i].game->game_flags & FLAG_RESOURCE_NAME && game_maps[i].map==0)
		{
			fprintf(out, "Missing map for game: %s\n", game_maps[i].game->name);
		}
	}

	FCLOSE(out)
	FCLOSE(in)

	if (errflg) free_map(game_maps);

	return(game_maps);
}

struct game_map *free_map(struct game_map *map)
{
	FREE(map)

	return(map);
}

int verify_roms(struct dat *mame_dat, struct dat *curr_dat, struct game_map *curr_map, char *base_fn, int dat_check)
{
	FILE *dat_out=0;

	char st[MAX_FILENAME_LENGTH+1];

	struct rom *roms;
	struct Rom *rominfo_roms=0;
	char *last_game=0;
	
	int i=0, j=0, k=0, found;
	int errflg=0;

	sprintf(st, "logs/%s.dat", base_fn);
	FOPEN(dat_out, st, "w")

	while(ems[i].descr)
	{
		if (!strcmp(ems[i].descr, base_fn))
			rominfo_roms=ems[i].roms;
		i++;
	}

	if (!errflg)
	{
		for (i=0; i<curr_dat->num_games; i++)
		{	
			roms=curr_map[i].game->roms;

			{
				for (j=0; j<curr_map[i].game->num_roms; j++)
				{
					found=0;

					if (!dat_check && (curr_map[i].game->game_flags & FLAG_RESOURCE_NAME || curr_map[i].type=='h'))
						found++;

					k=0;
					while (!found && curr_map[i].map && rominfo_roms && rominfo_roms[k].local.game)
					{
						if ((!strcmp(curr_map[i].map->name, rominfo_roms[k].mame.game) ||
							rominfo_roms[k].type==BLOCK_FILL ||
							!strcmp(rominfo_roms[k].mame.game, "zzzzzzzz"))
							&& rominfo_roms[k].local.crc==roms[j].crc)
							found++;
						k++;
					}

					k=0;
					while (!dat_check && !found && curr_map[i].map && (k<curr_map[i].map->num_roms))
					{
						if (curr_map[i].map->roms[k].crc==roms[j].crc)
							found++;
						k++;
					}

					k=0;
					while (!dat_check && !found && curr_map[i].map && (k<curr_map[i].map->num_roms))
					{
						if (curr_map[i].map->roms[k].crc==~roms[j].crc)
							found++;
						k++;
					}

					if (dat_check && !found && bsearch((const void *)&roms[j].crc, mame_dat->rom_crc_idx, mame_dat->num_roms, sizeof(struct rom_idx), find_rom_by_crc))
						found++;

					if (dat_check && !found && bsearch((const void *)&roms[j].crc, mame_dat->rom_crc_idx, mame_dat->num_roms, sizeof(struct rom_idx), find_rom_by_comp_crc))
						found++;

					if (!found && (!last_game || strcmp(last_game, curr_map[i].game->name)))
					{
						if (last_game)
							fprintf(dat_out, ")\n\n");
						fprintf(dat_out, "game (\n\tname %s\n\tdescription \"%s\"\n", curr_map[i].game->name, curr_map[i].game->description);
						last_game=curr_map[i].game->name;
					}

					if (!found)
						fprintf(dat_out, "\trom ( name %s size %ld crc %08lx )\n", roms[j].name, (unsigned long)roms[j].size, (unsigned long)roms[j].crc);
				}
			}
		}

		if (last_game)
			fprintf(dat_out, ")\n");
	}

	FCLOSE(dat_out)

	return(errflg);
}
