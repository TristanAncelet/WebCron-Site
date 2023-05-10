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

for dir in ${crontab_dirs[@]}; do
    if [[ $( ls -1 $dir | wc -l ) -ge 1 ]]; then
        for file in $dir/* ; do
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

IFS='|'
while read crontab_id crontab_path; do 
    data=`sqlite3 ../webcron.db <<< "SELECT crontab_data FROM crontabs WHERE crontab_id = $crontab_id"`

    if [[ -f $crontab_path ]] && [[ ! "$data" == "$(<$crontab_path)" ]]; then
        sqlite3 ../webcron.db <<<"
        UPDATE crontabs SET crontab_data = '$(<$crontab_path)' WHERE crontab_id = $crontab_id 
        "
    fi

done <<< ` sqlite3 ../webcron.db <<< "
SELECT crontab_id crontab_name, crontab_path FROM crontabs;
" ` 
unset IFS