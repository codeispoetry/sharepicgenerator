        <?php if(configValue($tenant,'showGallery') AND isEditor()){ ?>
            <h3 class="collapsed" data-toggle="collapse" data-target=".gallery"><i class="fas fa-store"></i> 
                Vorlagen
            </h3>
            <div class="gallery collapse list-group-item list-group-item-action flex-column align-items-start">
                <div id="gallery-note" class="text-danger"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-info saveInGallery" id='saveInGallery'><i class="fas fa-save"></i> als Vorlage veröffentlichen</button>
                </div>
            </div>
        <?php } ?>