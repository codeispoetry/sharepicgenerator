<h3><i class="fas fa-image"></i> Eigenes Bild</h3>
<div class="picture  list-group-item list-group-item-action flex-column align-items-start">
	<div class="mb-1 d-flex justify-content-between">
		<span class="btn btn-cockpit cursor-pointer uploadfileclicker">
			<i class="fa fa-upload"></i> Bild hochladen
		</span>

		<div>
			<span class="cursor-pointer backgroundDelete" title="Hintergrundbild löschen">
				<i class="fas fa-trash"></i>
			</span>

			<?php if ( $tenant == 'free' ) { ?>
				<input type="color" name="backgroundcolor" id="backgroundcolor" value="#85d0ff">
			<?php } else { ?>
			<input type="hidden" name="backgroundcolor" id="backgroundcolor" value="<?php getColorAtIndex( 'background' ); ?>">
			<span 
				class="colorpicker ms-1" 
				data-colors="<?php getColorAtIndex(); ?>" 
				data-action="background.drawColor()" 
				data-field="#backgroundcolor" 
				title="Hintergrundfarbe setzen"></span> 
			<?php } ?>
		</div>
	</div>
	<div>
		<small><em>Auch per Drag-and-Drop</em></small>
	</div>
 </div>

 <h3><i class="fas fa-image"></i> <?php _e( 'Search image' ); ?></h3>
 <div class="picture  list-group-item list-group-item-action flex-column align-items-start">  
	<div>
		<div class="input-group">
			<input type="text" class="form-control" id="imagedb-direct-search-q" placeholder="Suchbegriff">
			<button type="button" class="input-group-text btn-group imagedb-direct-search">suchen</button>
		</div>
	</div>
</div>

<h3 class="picture-only d-none"><i class="fas fa-image"></i> Einstellungen</h3>
<div class="picture picture-only d-none list-group-item list-group-item-action flex-column align-items-start">

	<div class="mt-2 mb-1 list-group-item-content show preferences-pic">
		<div class="slider">
			<small>klein</small>
			<input type="range" class="form-range" name="backgroundsize" id="backgroundsize" min="1"
					max="1500" value="1200">
			<small>groß</small>
		</div>

		<div class="slider">
			<small>schwarzweiß</small>
			<input type="range" class="form-range" name="saturate" id="saturate" min="0"
				max="1" value="1" step="0.05">
			<small>farbig</small>
		</div>

		<div class="slider d-none">
			<small>scharf</small>
			<input type="range" class="form-range" name="blur" id="blur" min="0"
				max="1" value="1" step="0.05">
			<small>unscharf</small>
		</div>
 
		<div>
			<small class="btn btn-sm btn-outline-cockpit cursor-pointer me-1" id="backgroundflip"><i class="fas fa-exchange-alt"></i>
				spiegeln
			</small>
			<small class="btn btn-sm btn-outline-cockpit cursor-pointer" id="backgroundreset"><i class="fas fa-undo"></i>
				zurücksetzen
			</small>
		</div>      
	</div>
	<div class="align-items-lg-center show-copyright d-none">
		<div class="d-flex align-items-center">

			<input type="text" placeholder="Bildnachweise" name="copyright" id="copyright" value="" class="form-control">
			<span class="colorpicker ms-1" data-colors="#ffffff,#000000,#009571,#46962b,#E6007E,#FEEE00" 
				data-action="copyright.draw()" data-field="#copyrightcolor" title="Farbe wechseln"></span> 
		</div>
	</div>

</div>   

<?php $color = configValue( $tenant, 'colorMatrixLabel' ) ?: 'Gr&uuml;n'; ?>

<h3 class="picture-only d-none"><i class="fas fa-image"></i> <?php echo ucFirst( $color ); ?>färbung</h3>
<div class="picture-only d-none list-group-item">
		<label>
			<input type="checkbox" class="form-check-input" name="greenify" id="greenify"> Bild <?php echo strToLower( $color ); ?> einfärben
		</label>

		<div class="slider">
			<small>Helligkeit</small>
			<input type="range" class="form-range" name="greenifybrightness" id="greenifybrightness" min="0.5"
				max="10" value="2.5" step="0.5">
		</div>

		<div class="slider">
			<small>Kontrast</small>
			<input type="range" class="form-range" name="greenifycontrast" id="greenifycontrast" min="0"
				max="0.8" value="0.05" step="0.005">
		</div>
		<small class="text-cockpit cursor-pointer greenifyreset">
			<i class="fas fa-undo"></i> Helligkeit und Kontrast zurücksetzen
		</small>
</div>

<?php if ( $matrix = configValue( $tenant, 'colorMatrix' ) ) { ?>
	<script>
		const greenifyMatrix = [<?php echo $matrix; ?> ];
	</script>
<?php } ?>

<input type="hidden" name="backgroundX" id="backgroundX">
<input type="hidden" name="backgroundY" id="backgroundY">
<input type="hidden" name="backgroundURL" id="backgroundURL">
<input type="hidden" name="backgroundFlipped" id="backgroundFlipped" value="false">
<input type="hidden" name="fullBackgroundName" id="fullBackgroundName">
<input type="hidden" name="copyrightcolor" id="copyrightcolor" value="white">
<input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,.heic">
