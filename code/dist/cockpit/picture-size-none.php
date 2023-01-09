
<div class="d-none">
    <input type="number" class="form-control size" name="width" id="width" step="10">
    <input type="number" class="form-control size" name="height" id="height" step="10">
    <select class="form-select" id="sizepresets">
        <?php
        $inifile = ($tenant == 'vorort') ? 'ini/picturesizes-vorort.ini' : 'ini/picturesizes.ini';
        $sizes = parse_ini_file(getBasePath($inifile), true);
        foreach ($sizes as $name => $group) {
            printf('<optgroup label="%s">', $name);
            foreach ($group as $label => $size) {
                list($width, $height, $quality) = preg_split("/[^0-9]/", trim($size));
                $socialmediaplatform = preg_replace('/ /', '-', "$name-$label");
                printf('<option value="%d:%d" data-socialmediaplatform="%s" data-quality="%s">%s</option>', $width, $height, $socialmediaplatform, $quality, $label);
            }
            echo '</optgroup>';
        }
        ?>
    </select>
</div>