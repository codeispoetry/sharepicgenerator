<?php
// phpcs:ignoreFile -- mainly html, ignore it
?>


<form id="pic" class="cockpit-vertical h-100">
<div class="d-flex h-100">
  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
        <i class="fas fa-image"></i><small></small></button>
    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
        <i class="fas fa-font"></i><small></small></button>
    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">
        <i class="fas fa-plus-circle"></i><small></small></button>
    <button class="nav-link" id="v-pills-download-tab" data-bs-toggle="pill" data-bs-target="#v-pills-download" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
        <i class="fas fa-share-alt"></i><small></small>
    </button>
    <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
        <i class="fas fa-cog"></i><small></small>
    </button>
  </div>
  <div class="tab-content w-100 h-100 bg-cockpitbg" id="v-pills-tabContent">
    <div class="tab-pane show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <?php
            require_once(getBasePath('cockpit/picture.php'));
            require_once(getBasePath('cockpit/picture-size.php'));
        ?>
    </div>
    <div class="tab-pane" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
        <?php 
            require_once('cockpit/text.php');
            require_once('cockpit/logo.php');
            require_once('cockpit/eyecatcher.php');
        ?>
    </div>
    <div class="tab-pane" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
        <?php
            require_once(getBasePath('cockpit/addpictures.php'));
            require_once(getBasePath('cockpit/addtext.php'));

        ?>
    </div>
    <div class="tab-pane" id="v-pills-download" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    <?php
         require_once(getBasePath('cockpit/quality.php'));
         require_once(getBasePath('cockpit/mail.php'));
    ?>
    </div>
    <div class="tab-pane" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    <?php
         require_once(getBasePath('cockpit/preferences-province.php'));
    ?>
    </div>
  </div>
</div>



    <input type="hidden" name="copyrightPosition" id="copyrightPosition"  value="bottomRight">


</form>

