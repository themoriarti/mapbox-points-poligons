#!/bin/bash
##############################################################################
#                                                                            #
#  Dump database to sql format.                                              #
#  Writen by Moriarti <mor.moriarti@gmail.com> at 2017-02-06 01:01:08 GMT+2  #
#                                                                            #
##############################################################################

# Get db params.

# Config options.
DBH='localhost'
DBU='mapbox'
DBP='pass'
DB='mapbox'

# Querys.
QueryTables='SELECT table_name FROM information_schema.tables WHERE table_schema="'${DB}'";'
# MySQL dump command
MYDUMP='mysqldump -h '${DBH}' -u '${DBU}' -p'${DBP}' --compact -d '${DB}' '

# Commands to mysql.
MY='mysql -h '${DBH}' -u '${DBU}' -p'${DBP}' '${DB}' -Ns -B'
MY1='mysql -h '${DBH}' -u '${DBU}' -p'${DBP}' '${DB}

# Processing loop.
while read -a row
    do
    echo "Dump table: ${row[0]} to file: /sql/tables/${row[0]}.sql"
    # Dump table to file.
    $MYDUMP ${row[0]} > ./sql/tables/${row[0]}.sql
done < <(echo $QueryTables | $MY)
