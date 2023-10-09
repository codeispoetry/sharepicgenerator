<?php

$fontDir = '../assets/typefaces/';

$fonts = glob( $fontDir . '*.{woff2}', GLOB_BRACE );

echo '<style>';
foreach ( $fonts as $font ) {
	printf(
		'@font-face {font-family: "%1$s";src: url("../assets/typefaces/%1$s.woff2") format("woff2");}',
		basename( $font, '.woff2' )
	);

	printf(
		".%s{font-family: '%s';font-weight: 500;}\n",
		strToLower( preg_replace( '/ /', '', basename( $font, '.woff2' ) ) ),
		basename( $font, '.woff2' )
	);
}
echo '</style>';
