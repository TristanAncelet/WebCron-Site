total_count=0
declare -a crontab_dirs=(
    /etc/cron.d
    /etc/cron.daily
    /etc/cron.hourly
    /etc/cron.weekly 
    /var/spool/cron
)

for dir in ${crontab_dirs[@]}; do
    count=0;
    for file in $dir/*; do
        count=` ls -1 $dir | wc -l `
    done
    echo "- $dir: $count<br>"
    total_count=$(( $count + $total_count ))
done

echo "Total: $total_count"