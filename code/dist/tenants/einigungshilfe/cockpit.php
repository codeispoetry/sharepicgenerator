<?php
// phpcs:ignoreFile -- mainly html, ignore it

$defaultColor = '#5488C7';
?>

<form id="pic">
    <div class="mb-5">
    <?php
        if( isGuest() ){
            require_once(getBasePath('tenants/cockpit/basic/logo-guest.php'));
        }else{
            require_once(getBasePath('tenants/cockpit/basic/logo.php'));
        }

        require_once(getBasePath('tenants/cockpit/picture.php'));
        require_once(getBasePath('tenants/cockpit/picture-size.php'));
        require_once(getBasePath('tenants/cockpit/einigungshilfe/text.php'));

        require_once(getBasePath('tenants/cockpit/addpictures.php'));
        require_once(getBasePath('tenants/cockpit/basic/eyecatcher.php'));
        require_once(getBasePath('tenants/cockpit/basic/addtext.php'));
        require_once(getBasePath('tenants/cockpit/eraser.php'));
        require_once(getBasePath('tenants/cockpit/quality.php'));
        // require_once(getBasePath('tenants/cockpit/workfile.php'));
        // require_once(getBasePath('tenants/cockpit/gallery.php'));
        //require_once(getBasePath('tenants/cockpit/mail.php')); 
        require_once(getBasePath('tenants/cockpit/gridlines.php'));  
        require_once(getBasePath('tenants/cockpit/footer.php'));
    ?>
        <input type="hidden" name="layerColor" id="layerColor" value="#2d81c9">
    </div>
</form>
