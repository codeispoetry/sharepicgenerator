

		<h3>Text</h3>
		<div class="text list-group-item list-group-item-action flex-column align-items-start">
			
			<div class="list-group-item-content">
				<div class="d-none justify-content-end">
					<i class="fa fa-align-left text-align me-2" data-align="left" title="linksbündig"></i>
					<i class="fa fa-align-center text-align me-2" data-align="middle" title="zentrieren"></i>
					<i class="fa fa-align-right text-align" data-align="end" title="rechtsbündig"></i>
				</div>
				<div class="d-flex">
					<textarea placeholder="Text 1" name="textbefore" id="textbefore" value="" class="form-control">Egal: Wie
Du lebst.</textarea>
					<input type="hidden" name="textbeforecolor" id="textbeforecolor" value="<?php getColorAtIndex( 1 ); ?>">
					<span 
						class="colorpicker ms-1 change-text"  
						id="textbeforecolorpicker" 
						data-colors="<?php getColorAtIndex(); ?>" 
						data-action="floating.draw()" 
						data-field="#textbeforecolor" 
						title="Farbe wechseln"></span> 
				</div>
				<div class="d-flex">
					<textarea placeholder="Text 2" name="text" id="text" class="form-control">Nicht egal:
Wie du wählst.</textarea>
					<input type="hidden" name="textcolor" id="textcolor" value="<?php getColorAtIndex( 2 ); ?>">
					<span 
						class="colorpicker ms-1 change-text"  
						id="textcolorpicker" 
						data-colors="<?php getColorAtIndex(); ?>" 
						data-action="floating.draw()" 
						data-field="#textcolor" 
						title="Farbe wechseln"></span> 
				</div>
				<div class="d-none align-items-lg-center">
					<textarea placeholder="Text unter der Linie" name="textafter" id="textafter" value="" class="form-control h-1em"></textarea>
					<input type="hidden" name="textaftercolor" id="textaftercolor" value="<?php getColorAtIndex( 2 ); ?>">
					<span 
						class="colorpicker ms-1 change-text"  
						id="textaftercolorpicker" 
						data-colors="<?php getColorAtIndex(); ?>" 
						data-action="floating.draw()" 
						data-field="#textaftercolor" 
						title="Farbe wechseln"></span> 
				</div>
				<div class="d-none justify-content-between">
					<div class="">
						<input type="text" placeholder="Claim" name="claimtext" id="claimtext" value="" class="form-control">
					</div>    
					<div>
						<input type="hidden" name="claimcolor" id="claimcolor" value="#ffe100">
						<span class="colorpicker ms-1"  id="claimcolorpicker" data-colors="#ffe100,#FF495D" data-action="floating.draw()" data-field="#claimcolor" title="Farbe wechseln"></span>
					</div>    
				</div>

				<div class="mb-1 mt-2">
					<div class="d-flex justify-content-between">
						<div class="slider">
							<small>klein</small>
							<input type="range" class="form-range" name="textsize" id="textsize" min="1" max="100">
							<small>groß</small>
						</div>
					</div> 
					</div>

			   
			</div>
		</div>
		<input type="hidden" name="iconfile" id="iconfile">
		<input type="hidden" name="textX" id="textX">
		<input type="hidden" name="textY" id="textY">
		<input type="hidden" name="textColor" id="textColor" value="0">
		<input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
