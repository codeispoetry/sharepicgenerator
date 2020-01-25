<style>
    img{
        height: 200px;
        width: auto;
        margin: 0 5px 5px 0;
    }
</style>

<a href="#bayern">zu Bayern</a><br>


<?php

deleteFilesInPathOlderThanDays(2, '../tmp/*');
deleteFilesInPathOlderThanDays(2, '../bayern/tmp/*');
deleteFilesInPathOlderThanDays(2, '../vintage/tmp/*');

echo '<a name="videos"><h2>Videos</h2></a>';
show_videos("../tmp/shpic*\.mp4");
show_videos("../bayern/tmp/shpic*\.mp4");

echo '<a name="vintage"><h2>Vintage</h2></a>';
show_images("../vintage/tmp/log*\.jpg");

echo '<a name="bund"><h2>Bund</h2></a>';
show_images("../tmp/log*\.jpg");

echo '<a name="bayern"><h2>Bayern</h2></a>';
show_images("../bayern/tmp/log*\.jpg");





function show_videos($dir)
{
    $files = array_reverse(glob($dir));

    echo '<ol>';
    foreach ($files AS $file) {
        printf('<li><a href="%s"/>%s</li>', $file, date("d. F Y, H:i", filemtime($file)));
    }
    echo '</ol>';
}

function show_images($dir)
{
    $files = array_reverse(glob( $dir ) );

    foreach ($files AS $file) {
        printf('<img src="%s"/>', $file);
    }
}


function deleteFilesInPathOlderThanDays($days, $path)
{
    $files = glob($path);
    $now = time();
    $counter = 0;

    foreach ($files AS $file) {
        if (is_file($file) AND $now - filemtime($file) >= 60 * 60 * 24 * $days) {
            $counter++;
            unlink($file);
        }
    }

    printf('%d Dateien gelöscht.<br>', $counter);
}
