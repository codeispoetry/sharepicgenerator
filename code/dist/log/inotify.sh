inotifywait -mq -e delete ../tmp/ -e create  ../tmp/ --format "%T %f %e" --timefmt %T | while read MESSAGE
do
    echo "$MESSAGE" >> inotify.log
done
