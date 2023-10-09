<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="utf-8" />
	<meta name="theme-color" content="#46962b">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logs</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
	<style>
		scroll-container {
			scroll-behavior: smooth;
		}

		dd{
			margin-left: 1em;
		}
	</style>
</head>

<body class="text-white">
	<?php
	$string = file_get_contents( 'logs/ai.log' );


	$lines = explode( "\n", $string );

	$lines = array_reverse( $lines );

	foreach ( $lines as $line ) {
		if ( $line == '' ) {
			continue;
		}

		list($before, $after) = explode( ' => ', $line );

		$after = substr( $after, 2, -2 );
		$after = preg_replace( '/[1-9]\./', '<br>', $after );
		$after = preg_replace( '/\\\"/', '', $after );

		$before = preg_replace( '/\\\n/', '<br>', $before );

		printf( '<dl><dt>%s</dt><dd>%s</dd></dl>', $before, $after );

		echo "<br>\n";
	}
	?>
</body>

</html>
