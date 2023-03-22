<h3>Illustrationen</h3>
<div class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content illustrations">
    <?php
        $files = glob("../assets/sh/illustrations/*.*");

        // get URL from this server
        $path = sprintf('%s://%s/assets/sh/illustrations/', $_SERVER['REQUEST_SCHEME'], $_SERVER['SERVER_NAME']);

        foreach($files as $file){
           printf('<img src="../assets/sh/illustrations/%1$s" alt="%3$s" title="%3$s" data-url="%2$s%1$s" class="illustration add-pic-by-url">', 
            basename($file), 
            $path,
            basename($file, '.png'));
        }
    ?>
       
    </div>
</div>
