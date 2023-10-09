<h3><i class="fas fa-expand-arrows-alt"></i> 
	Größe
	<small class="ms-2">
		<i class="fab fa-instagram"></i>
		<i class="fab fa-facebook"></i>
		<i class="fab fa-twitter"></i>
		</small>
	</h3>
<div class="picturesize list-group-item list-group-item-action flex-column align-items-start">
	<div class="d-flex w-100 justify-content-between align-items-center">
		<div class="form-inline">
			<div class="d-flex sizecontainer">
				<input type="number" class="form-control size" name="width" id="width" step="10">
				<span class="mt-2 small">x</span>
				<input type="number" class="form-control size" name="height" id="height" step="10">
				<span class="mt-2 me-2 small">Px</span>
				<select class="form-select" id="sizepresets">
					<?php
					$inifile = ( $tenant == 'vorort' ) ? 'ini/picturesizes-vorort.ini' : 'ini/picturesizes.ini';
					$sizes   = parse_ini_file( getBasePath( $inifile ), true );
					foreach ( $sizes as $name => $group ) {
						printf( '<optgroup label="%s">', $name );
						foreach ( $group as $label => $size ) {
							@list($width, $height, $quality) = preg_split( '/[^0-9]/', trim( $size ) );
							$socialmediaplatform             = preg_replace( '/ /', '-', "$name-$label" );
							printf( '<option value="%d:%d" data-socialmediaplatform="%s" data-quality="%s">%s</option>', $width, $height, $socialmediaplatform, $quality, $label );
						}
						echo '</optgroup>';
					}
					?>
				</select>
			</div>
		</div>
	</div>
	<small class="btn btn-sm btn-outline-cockpit mt-1 cursor-pointer" id="sizereset"><i class="fas fa-undo-alt"></i> zurücksetzen</small>
</div>
