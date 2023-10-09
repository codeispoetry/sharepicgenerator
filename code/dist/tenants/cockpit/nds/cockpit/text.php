

		<h3><i class="fas fa-text-width"></i> Text</h3>
		<div class="text list-group-item list-group-item-action flex-column align-items-start">
			
			<div class="d-flex">
				 <label class="d-none">
					<input type="radio" class="form-check-input layout me-1" name="layout" value="floating" checked>Schwebend
				 </label>
				 <label class="me-1">
					<input type="radio" class="redraw-text form-check-input me-1" name="sublayout" value="floating">Schwebend
				</label>
				 <label class="me-1">
					<input type="radio" class="redraw-text form-check-input me-1" name="sublayout" value="background">Hintergrund
				</label>
				<label class="">
					<input type="radio" class="redraw-text form-check-input me-1" name="sublayout" value="bottom">Unten
				 </label>
				
			</div>

			<div class="list-group-item-content">
				<div class="d-none justify-content-end">
					<i class="fa fa-align-left text-align me-2 showonly floating" data-align="left" title="linksbündig"></i>
					<i class="fa fa-align-center text-align me-2 showonly floating" data-align="middle" title="zentrieren"></i>
					<i class="fa fa-align-right text-align showonly floating" data-align="end" title="rechtsbündig"></i>
				</div>
				<div class="d-none align-items-lg-center">
					<input type="text" placeholder="Text darüber" name="textbefore" id="textbefore" value="" class="form-control showonly area floating">
				</div>
				<div class="d-flex">
					<textarea placeholder="Haupttext" name="text" id="text" class="form-control">  Für einen 
Nahverkehr,
   der alle abholt.</textarea>
					<div class="linepickers-container">
					<?php for ( $i = 0; $i < 5; $i++ ) { ?>
						<div class="d-flex linepickers linepicker<?php echo $i; ?>">
							<?php echo $i + 1; ?>)
							<input type="hidden" name="line<?php echo $i; ?>color" id="line<?php echo $i; ?>color" value="#FFE100">
							<span class="colorpicker ms-1" data-colors="#FFE100,#F1912E,#FFFFFF" data-action="floating.draw()" data-field="#line<?php echo $i; ?>color" title="Farbe der <?php echo $i + 1; ?>. Zeile"></span> 

							<input type="hidden" name="line<?php echo $i; ?>size" id="line<?php echo $i; ?>size" value="10">
							<span class="sizepicker ms-1" data-sizes="10,15,20,25,30" data-action="floating.draw()" data-field="#line<?php echo $i; ?>size" title="Schriftgröße der <?php echo $i + 1; ?>. Zeile"></span> 
						</div>
					<?php } ?>
					</div>
				</div>
				<div class="mb-1 mt-2 small fst-italic">
					Einrückungen mit Leerzeichen erzeugen.<br>Farbe und Größe mit den Symbolen rechts vom Textfeld einstellen.
				</div>
				<div class="d-none align-items-lg-center">
					<textarea placeholder="Text unter der Linie" name="textafter" id="textafter" value="" class="form-control h-1em showonly showonly area floating"></textarea>
				</div>
				<div class="d-none justify-content-between">
					<div class="">
						<input type="text" placeholder="Claim" name="claimtext" id="claimtext" value="" class="form-control showonly area floating">
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
						<div class="d-none">
							<div class="me-3">
								<span class="cursor-pointer ms-3 text-cockpit align-center-text showonly floating">
									<i class="fab fa-centercode" title="Text in Bildmitte"></i></span>
							</div> 
							<div>
								<span class="to-front" data-target="text" title="Text nach vorne">
									<i class="fas fa-layer-group text-cockpit"></i>
								</span> 
							</div>
						</div>
					</div> 
				</div>


				<div class="d-none preferences-text">
					<div class="showonly floating">  
						 <label class="me-3">
							<input type="checkbox" class="form-check-input" name="textShadow" id="textShadow">
							Schatten hinter Text
						</label>
					</div>
				</div>

			</div>
		</div>
		<input type="hidden" name="iconfile" id="iconfile">
		<input type="hidden" name="textX" id="textX">
		<input type="hidden" name="textY" id="textY">
		<input type="hidden" name="textColor" id="textColor" value="0">
		<input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
