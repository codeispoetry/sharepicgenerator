

<h3><i class="fas fa-text-width"></i> Person</h3>
<div class="text list-group-item list-group-item-action flex-column align-items-start">
	
	<div class="list-group-item-content">

		<select class="form-select celebrity" id="celebrity">         
			<option disabled selected hidden>bitte wählen</option>
			<?php
			   $celebrities = parse_ini_file( getBasePath( '/assets/vorort/celebrities/celebrities.ini' ), true );
			foreach ( $celebrities as $file => $info ) {
				printf(
					'<option value="%s" data-desc="%s">%s</option>',
					$file,
					$info['description'],
					$info['name']
				);
			}
			?>
		</select>
	
	
	
	</div>
</div>
