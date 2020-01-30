<div id="templates" class="overlay">
        <div class="container-fluid">
            <a href="#" class="close text-danger">
                <i class="fas fa-times"></i>
            </a>
            <div class="row pt-2 mt-1">
                <div class="col-12 text-center">
                    <h2>Vorlagen</h2>
                </div>
            </div>

            <div class="col-12 p-5">
                <div class="row">
                <?php
                    $files = glob("templates/*.jpg");
                    $templates = parse_ini_file('templates.ini', TRUE);
       
                    foreach($files AS $file){
                        if( isset($templates[ basename($file) ] ) ){
                            $data = '';
                            foreach($templates[ basename($file) ] AS $key => $value ){
                                $data .= sprintf('data-%s="%s"', $key, $value);
                            }
                        };

                        $data .= sprintf('data-url="%s/%s"', $tenant, $file);

                ?>
                    <div class="col-12 col-md-3">
                        <img src="<?php echo $file;?>" <?php echo $data; ?> class="img-fluid templatepic cursor-pointer">
                    </div>
                <?php
                    }
                ?>
                </div>
            </div>
        </div>

    </div>