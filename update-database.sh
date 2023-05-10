#!/usr/bin/bash
set -e

declare -a crontab_dirs=(
    /etc/cron.d
    /etc/cron.daily
    /etc/cron.hourly
    /etc/cron.weekly 
    /var/spool/cron
)

declare -a crontabs_in_db

sqlite_cmd='sqlite3 ../webcron.db'


for name in $( $sqlite_cmd <<< "SELECT crontab_path FROM crontabs;"); do
    crontabs_in_db+=( "$name" )
done

# This will go through and count the number of files in each directory (to determine if they need to be checked)
for dir in ${crontab_dirs[@]}; do
    # If the directory has less than 1 crontab (aka empty) it will be skipped
    if [[ $( ls -1 $dir | wc -l ) -ge 1 ]]; then
        for file in $dir/* ; do
            # For each file in the directory it will check to see if the current file
            # path is already stored in the DB
            # if not it will create one and it will be be indexed in the DB
            if [[ -f $file ]] && [[ ! "${crontabs_in_db[@]}" == *$file* ]]; then
                $sqlite_cmd <<< "
                INSERT INTO crontabs (crontab_path, crontab_data) VALUES
                    ('$file',
                    '$(<$file)')
                "
            fi
        done
    fi
done

# This will request all of the information from the db relating to all of the indexed crontab's
IFS='|'
while read crontab_id crontab_path; do 
    # It will initially request the id and path of the file, and then will load in the actual data of the 
    # file to be compared to the file content's on disk.
    data=`sqlite3 ../webcron.db <<< "SELECT crontab_data FROM crontabs WHERE crontab_id = $crontab_id"`

    # this will check to make sure that the file exists on disk and 
    # will compare the disk and db versions of the file to make sure if a change is needed to be 
    # loaded into the db.
    if [[ -f $crontab_path ]] && [[ ! "$data" == "$(<$crontab_path)" ]]; then
        sqlite3 ../webcron.db <<<"
        UPDATE crontabs SET crontab_data = '$(<$crontab_path)' WHERE crontab_id = $crontab_id 
        "
    fi

done <<< ` sqlite3 ../webcron.db <<< "
SELECT crontab_id crontab_name, crontab_path FROM crontabs;
" ` 
unset IFS