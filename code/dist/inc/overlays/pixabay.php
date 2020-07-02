<div id="pixabay" class="overlay">
        <div class="container">
            <a href="#" class="close text-danger">
                <i class="fas fa-times"></i>
            </a>
            <div class="row pt-2 mt-1">
                <div class="col-12 text-center">
                    <h2>Bilder suchen</h2>
                </div>
                <div class="col-12 col-md-4 offset-md-4">
                    <form id="pixabay-form">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-images"></i></div>
                            </div>
                            <input type="text" class="form-control q" placeholder="z.B. Berge oder Sonnenblume">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text btn-primary pixabay-picture">suchen</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-1">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="images-tab" data-toggle="tab" href="#pixabay-images" role="tab" aria-controls="images" aria-selected="false">Bilder</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="videos-tab" data-toggle="tab" href="#pixabay-videos" role="tab" aria-controls="videos" aria-selected="false">Videos</a>
                    </li>
                </ul>
            </div>
            <div class="row mt-2">
                <div class="tab-content">
                    <div class="tab-pane active" id="pixabay-images" role="tabpanel" aria-labelledby="images-tab">
                        <div class="pixabay-hint">
                            <a href="https://pixabay.com/" target="_blank" id="pixabay-link">
                                Die Bilder stammen von
                                <img src="/assets/img/pixabay.svg" alt="Pixabay">
                            </a>
                        </div>
                        <div class="pb-5 results">
                            <h2>Bilder suchen</h2>
                            <p>
                                Hier kannst Du Bilder von <a href="https://pixabay.com" target="_blank">Pixabay</a> suchen. 
                                Du darfst sie kostenlos und ohne Quellenangabe nutzen. Allerdings keine Bilder, auf denen einzelne 
                                Menschen zu erkennen sind.
                            </p>
                            <p>
                                Bitte gib oben Deinen Suchbegriff ein.
                            </p>
                        </div>
                    </div>
                    <div class="tab-pane" id="pixabay-videos" role="tabpanel" aria-labelledby="videos-tab">
                        <div class="row pb-5 results">
                            <h2>Videos suchen</h2>
                            <p>
                                Hier kannst Du Vidoes von <a href="https://pixabay.com" target="_blank">Pixabay</a> suchen. 
                                Du darfst sie kostenlos und ohne Quellenangabe nutzen. Allerdings keine Bilder, auf denen einzelne 
                                Menschen zu erkennen sind.
                            </p>
                            <p>
                                Bitte gib oben Deinen Suchbegriff ein.
                            </p>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>