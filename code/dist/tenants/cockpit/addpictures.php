<h3><i class="fas fa-images"></i> Vordergrundbilder</h3>
<?php
	define( 'COUNT_ADD_PICS', 5 );
?>
<div class="addpictures list-group-item list-group-item-action flex-column align-items-start">
	<div class="flex-column align-items-start">
		<?php for ( $i = 1; $i <= COUNT_ADD_PICS; $i++ ) { ?>
		<div class="add-pic-section add-pic-section-<?php echo $i; ?> <?php echo ( $i !== 1 ) ? 'd-none' : ''; ?> ">
			<input type="hidden" name="addpicfile<?php echo $i; ?>" id="addpicfile<?php echo $i; ?>">
			<input type="hidden" name="addPic<?php echo $i; ?>x" id="addPic<?php echo $i; ?>x">
			<input type="hidden" name="addPic<?php echo $i; ?>y" id="addPic<?php echo $i; ?>y">
			<input type="file" class="custom-file-input upload-file" id="uploadaddpic<?php echo $i; ?>" accept="image/*">
	 
			<div class="add-pic-clicker<?php echo $i; ?>">
				<span class="text-cockpit cursor-pointer addpicclicker<?php echo $i; ?>">
					<i class="fa fa-upload"></i> <?php echo $i; ?>. Bild hochladen
				</span>
			</div>
			<div class="add-pic-tools-<?php echo $i; ?> d-none">
				<div>
					<label class="me-4"><input type="checkbox" name="addpicrounded<?php echo $i; ?>" id="addpicrounded<?php echo $i; ?>" class="me-1">rund</label>
					<label><input type="checkbox" name="addpicroundedborder<?php echo $i; ?>"  id="addpicroundedborder<?php echo $i; ?>" class="me-1">mit Rand</label>
				</div>
				<div class="slider">
					<small>klein</small>
						<input type="range" class="form-range" name="addPicSize<?php echo $i; ?>" id="addPicSize<?php echo $i; ?>" min="1" max="800" value="90">
					<small>groß</small>
				</div>
			   
				<div class="d-flex align-items-baseline justify-content-between">
					<input type="text" id="addPicCaption<?php echo $i; ?>" name="addPicCaption<?php echo $i; ?>" class="form-control form-control-sm" placeholder="Bildbeschreibung">
					<div>
						<input type="hidden" name="addPicCaptionColor<?php echo $i; ?>" id="addPicCaptionColor<?php echo $i; ?>" class="change-text"  value="<?php getColorAtIndex( 'addpictext' ); ?>">
						<span class="colorpicker ms-1" data-colors="<?php getColorAtIndex(); ?>" data-action="window['addPic<?php echo $i; ?>'].setCaption()" data-field="#addPicCaptionColor<?php echo $i; ?>" title="Farbe wechseln"></span>
					</div>   
					<i class="fa-solid fa-location-dot ms-1 cursor-pointer addPicCaptionPositionButton<?php echo $i; ?>" title="drunter oder daneben"></i>
					<input type="hidden" name="addPicCaptionPosition<?php echo $i; ?>" id="addPicCaptionPosition<?php echo $i; ?>" value="bottom"> 
				</div>
				 <div class="add-pic-buttons">
					 <span class="to-front" data-target="addPic<?php echo $i; ?>" title="Bild nach vorne">
						<i class="fas fa-layer-group text-cockpit"></i>
					</span>
					<span class="addpicdelete<?php echo $i; ?>">
						<i class="fas fa-trash" title="löschen"></i>
					</span>
					<?php if ( $i >= 2 ) { ?>
						<span id="addpic-same-x-<?php echo $i; ?>">
							<i class="fas fa-caret-left" title="Gleiche x-Position wie Bild 1"></i>
						</span>
						<span id="addpic-same-y-<?php echo $i; ?>">
							<i class="fas fa-caret-up" title="Gleiche y-Position wie Bild 1"></i>
						</span>
						<span class="text-cockpit cursor-pointer addpic-same-height-<?php echo $i; ?>">
							<i class="fas fa-arrows-alt-v" title="gleiche Höhe wie Bild 1"></i>
						</span>
						<span class="text-cockpit cursor-pointer addpic-same-width-<?php echo $i; ?>">
							<i class="fas fa-arrows-alt-h" title="gleiche Breite wie Bild 1"></i>
						</span>
					<?php } ?>
				</div>
			</div>

		</div>
		<?php } ?>
	
	</div>
</div>
