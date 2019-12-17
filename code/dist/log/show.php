<?php

$files = glob("../tmp/shpic*\.png");

foreach($files AS $file){
    printf('<img src="%s" width="300"/>', $file);
}