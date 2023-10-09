<h3>Illustrationen</h3>
<div class="list-group-item list-group-item-action flex-column align-items-start">
	
	<div class="illustration-tools d-flex mb-5 justify-content-between d-none">

		<div class="slider">
			<small>klein</small>
				<input type="range" class="form-range" name="addPicSize5" id="addPicSize5AltSlider" min="1" max="800" value="90">
			<small>groß</small>
		</div>
		
		<div class="add-pic-buttons">
			<span class="to-front" data-target="addPic5" title="Bild nach vorne">
			<i class="fas fa-layer-group text-cockpit"></i>
			</span>
			<span class="addpicdelete5">
				<i class="fas fa-trash" title="löschen"></i>
			</span>
		</div>
	</div>

	<div class="mb-1 list-group-item-content illustrations">
	<?php
		$files = glob( '../assets/sh/illustrations/*.*' );

		// get URL from this server
		$path = sprintf( '%s://%s/assets/sh/illustrations/', $_SERVER['REQUEST_SCHEME'], $_SERVER['SERVER_NAME'] );

	foreach ( $files as $file ) {
		printf(
			'<img src="../assets/sh/illustrations/%1$s" alt="%3$s" title="%3$s" data-i="5" data-url="%2$s%1$s" class="illustration add-pic-by-url">',
			basename( $file ),
			$path,
			basename( $file, '.png' )
		);
	}
	?>
	   
	</div>
</div>
