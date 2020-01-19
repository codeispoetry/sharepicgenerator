<?php

deleteFilesInPathOlderThanDays( 3, '../tmp/*');
deleteFilesInPathOlderThanDays( 3, '../bayern/tmp/*');
deleteFilesInPathOlderThanDays( 3, '../vintage/tmp/*');



show_videos( glob("../tmp/shpic*\.mp4") );
show_videos( glob("../bayern/tmp/shpic*\.mp4") );

echo '<a name="bayern"><h2>Vintage</h2></a>';
show_images( glob("../vintage/tmp/log*\.jpg") );

show_images( glob("../tmp/log*\.jpg") );
echo '<a name="bayern"><h2>Bayern</h2></a>';
show_images( glob("../bayern/tmp/log*\.jpg") );





function show_videos( $files ){
    echo '<ol>';
    foreach($files AS $file){
        printf('<li><a href="%s"/>%s</li>', $file, date ("d. F Y, H:i", filemtime($file)));
    }
    echo '</ol>';
}

function show_images( $files ){


    foreach($files AS $file){
        printf('<img src="%s" width="300"/>', $file);
    }
}


function deleteFilesInPathOlderThanDays( $days, $path)
{
    $files = glob( $path );
    $now = time();
    $counter = 0;

    foreach($files AS $file){
        if (is_file($file) AND $now - filemtime($file) >= 60 * 60 * $days){
            $counter++;
            unlink($file);
        }
    }

    printf('%d Dateien gelöscht.<br>', $counter);
}