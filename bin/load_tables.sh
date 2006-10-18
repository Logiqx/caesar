# Check that the correct number of parameters have been provided

if (( $# < 2 ))
then
	echo "Usage : $0 <dir> <group>"
	echo
	echo "You must supply the text directory and object group (e.g. 'txt' and 'authors')"
	exit 1
fi

# Generic function to run a piece of SQL and catch errors

run_sql()
{
	SQL=$1
	echo "Running mysql for ${SQL}... "

	mysql --batch --user=$CAESAR_DB_USER --password=$CAESAR_DB_PASS --execute="source ${SQL}" $CAESAR_DB_NAME
	ERRFLG=$(($ERRFLG+$?))
}

# Generic function to load data into a temporary table and catch errors

load_table()
{
	# Ready to go!

	TABLE=$1
	printf "Loading mysqlimport for ${TABLE}... "

	# Extract required record types from the temporary text file

	sed "s/^${TABLE}	//" ${TMP_DIR}/${TABLE}.tmp|d2u >${TMP_DIR}/tmp_${TABLE}.tmp

	# Run MySQL Import

	OUTPUT=$(mysqlimport --local --user=$CAESAR_DB_USER --password=$CAESAR_DB_PASS $CAESAR_DB_NAME ${TMP_DIR}/tmp_${TABLE}.tmp)
	ERRFLG=$(($ERRFLG+$?))

	# Check the output to identify errors, etc.

	if (( $ERRFLG == 0 ))
	then
		RECORDS=$(echo "$OUTPUT"|sed "s/.*Records: //;s/ Deleted:.*//")
		DELETED=$(echo "$OUTPUT"|sed "s/.*Deleted: //;s/ Skipped:.*//")
		SKIPPED=$(echo "$OUTPUT"|sed "s/.*Skipped: //;s/ Warnings:.*//")
		WARNINGS=$(echo "$OUTPUT"|sed "s/.*Warnings: //")

		if (( $RECORDS == 0 ))
		then
			echo "no records loaded!"
			ERRFLG=$(($ERRFLG+1))
		else
			echo "$RECORDS records loaded."
		fi

		if (( $DELETED != 0 ))
		then
			echo "   $DELETED deleted reported!"
		fi

		if (( $SKIPPED != 0 ))
		then
			echo "   $SKIPPED skipped reported!"
			ERRFLG=$(($ERRFLG+1))
		fi

		if (( $WARNINGS != 0 ))
		then
			echo "   $WARNINGS warnings reported!"
			ERRFLG=$((ERRFLG+1))
		fi
	fi

	# Clean up and return

	if (( $ERRFLG == 0 ))
	then
		rm -f ${TMP_DIR}/${TABLE}.tmp ${TMP_DIR}/tmp_${TABLE}.tmp
	else
		echo "Retry with: mysqlimport --local --user=$CAESAR_DB_USER --password=$CAESAR_DB_PASS $CAESAR_DB_NAME ${TMP_DIR}/tmp_${TABLE}.tmp"
	fi

	return $ERRFLG
}

# Group loaders

load_authors()
{
	for TABLE in author author_email author_homepage author_emulator_link author_library_link author_tool_link
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	return $ERRFLG
}

load_emus()
{
	for TABLE in emulator emulator_homepage emulator_author_link emulator_library_link emulator_tool_link emulator_features emulator_controller emulator_relative_link emulator_file
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*/*.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in emulator_contents emulator_contents_emulator_link emulator_old_name
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	return $ERRFLG
}

load_libs()
{
	for TABLE in library library_homepage library_author_link library_emulator_link library_tool_link library_file library_relative_link
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*/*.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in library_contents library_contents_library_link
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	return $ERRFLG
}

load_tools()
{
	for TABLE in tool tool_homepage tool_author_link tool_emulator_link tool_library_link tool_file
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*/*.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in tool_contents tool_contents_tool_link
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	return $ERRFLG
}

load_games()
{
	for TABLE in game game_comment game_biosset game_rom game_disk game_sample game_chip game_video game_display game_sound game_input game_control game_dipswitch game_dipvalue game_driver game_archive
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*/*.dat ${TXT_DIR}/${GROUP}/*.dat|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in game_map
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/*/*.txt >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	return $ERRFLG
}

load_files()
{
	for TABLE in image snap zip
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/${TABLE}s.txt >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	return $ERRFLG
}

load_misc()
{
	for TABLE in manufacturer
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/${TABLE}s.txt >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in rombuild
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/${TABLE}.txt >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in history_link history_text
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/history.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in mameinfo_link mameinfo_text
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/mameinfo.txt|grep "^${TABLE}	" >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	for TABLE in catver
	do
		if (( $ERRFLG == 0 ))
		then
			cat ${TXT_DIR}/${GROUP}/catver.txt >${TMP_DIR}/${TABLE}.tmp
			load_table ${TABLE}
			ERRFLG=$(($ERRFLG + $?))
		fi
	done

	return $ERRFLG
}

# Generic function to create the temporary tables, load the data then rename the tables

load_tables()
{
	if (( $ERRFLG == 0 ))
	then
		run_sql $SQL_DIR/create_tmp_${GROUP}.sql
		ERRFLG=$(($ERRFLG + $?))
	fi

	if (( $ERRFLG == 0 ))
	then
		load_${GROUP}
		ERRFLG=$(($ERRFLG + $?))
	fi

	if (( $ERRFLG == 0 ))
	then
		OUTPUT=$(mysqlcheck --user=$CAESAR_DB_USER  --password=$CAESAR_DB_PASS -a $CAESAR_DB_NAME)
		ERRFLG=$(($ERRFLG + $?))
	fi

	if (( $ERRFLG == 0 ))
	then
		run_sql $SQL_DIR/rename_tmp_${GROUP}.sql
		ERRFLG=$(($ERRFLG + $?))
	fi

	if (( $ERRFLG == 0 ))
	then
		OUTPUT=$(mysqlcheck --user=$CAESAR_DB_USER  --password=$CAESAR_DB_PASS -a $CAESAR_DB_NAME)
		ERRFLG=$(($ERRFLG + $?))
	fi

	if (( $ERRFLG == 0 ))
	then
		echo "Touching ${TXT_DIR}/${GROUP}.tag..."
		touch ${TXT_DIR}/${GROUP}.tag
		ERRFLG=$(($ERRFLG + $?))
	fi

	return $ERRFLG
}

# Main script simply calls the load_tables function

TXT_DIR=$1
TMP_DIR=tmp
GROUP=$2
ERRFLG=0

if [[ $HOSTNAME = "srv01.proto-host.com" ]]
then
	SQL_DIR=../www/caesar/sql
else
	SQL_DIR=www/sql
fi

if [[ ! -d ${TMP_DIR} ]]
then
	mkdir ${TMP_DIR}
fi

case "${GROUP}" in
	authors|emus|libs|tools|games|files|misc)
		load_tables ;;
	*)
		echo "${GROUP} is not a valid group!";
		ERRFLG=1 ;;
esac

exit $ERRFLG
