<?php
// phpcs:ignoreFile -- mainly html, ignore it
?>

<form id="pic" class="cockpit-vertical h-100">
<div class="d-flex h-100">
  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="v-pills-home-tab" title="Bild" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
        <i class="fas fa-image"></i></button>
    <button class="nav-link" id="v-pills-profile-tab" title="Text" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
        <i class="fas fa-font"></i></button>
  </div>
  <div class="tab-content w-100 h-100 bg-cockpitbg" id="v-pills-tabContent">
    <div class="tab-pane show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <?php
            require_once('cockpit/picture.php');
            require_once('cockpit/picture-size.php');
        ?>
    </div>
    <div class="tab-pane" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
        <?php 
            require_once('cockpit/text.php');
            require_once('cockpit/logo.php');
        ?>
    </div>  
  </div>
</div>
    <input type="hidden" name="copyrightPosition" id="copyrightPosition"  value="bottomRight">
</form>
