<div class="col-12">
    <div id="pictureoverlay"  class="overlay" style="display:none">
        <a href="#" class="close closer text-danger">
            <i class="fas fa-times"></i>
        </a>
        <div class="">
            <div class="row">
                <div class="col-12 text-center pt-4 pb-3">
                    <h1 class="text-uppercase h2"><i class="fas fa-store"></i> Bilder </h1>
                </div>
            </div>
            <div class="row pb-5 mb-3">
                <?php
                    showPictures('pictures/img/');
                ?>
            </div>
        </div>
    </div>
</div>