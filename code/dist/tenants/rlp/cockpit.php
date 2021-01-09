<?php
// phpcs:ignoreFile -- mainly html, ignore it

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/gallery_functions.php'));

useDeLocale();

session_start();
readConfig();

if (!isAllowed(false)) {
    header("Location: ". configValue("Main", "logoutTarget"));
    die();
}

?>

<form id="pic">
    <div class="mb-5">

    <?php
        require_once(getBasePath('tenants/cockpit/picture.php'));
        require_once(getBasePath('tenants/cockpit/picture-size.php'));
        require_once(getBasePath('tenants/cockpit/rlp/text.php'));
        require_once(getBasePath('tenants/cockpit/addpictures.php'));
        require_once(getBasePath('tenants/cockpit/logo-none.php'));
        require_once(getBasePath('tenants/cockpit/rlp/eyecatcher.php'));
        require_once(getBasePath('tenants/cockpit/url.php'));
        require_once(getBasePath('tenants/cockpit/addtext-none.php'));
        require_once(getBasePath('tenants/cockpit/eraser.php'));
        require_once(getBasePath('tenants/cockpit/quality.php'));
        require_once(getBasePath('tenants/cockpit/workfile.php'));
        require_once(getBasePath('tenants/cockpit/gallery.php'));
        require_once(getBasePath('tenants/cockpit/footer.php'));
    ?>
    </div>
</form>
