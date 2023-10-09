<?php

require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/log_functions.php' );

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8"/>
	<meta name="theme-color" content="#46962b">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logs</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
	<style>
		scroll-container {
			scroll-behavior: smooth;
		}
	</style>
</head>
<body style="background: white">
<scroll-container>
<div class="container-fluid">
	<div class="row mt-3">
		<div class="col-12 text-center">
			<a href="index.php" class="btn btn-primary btn-md ms-2">Statistik</a>
		</div>
		<div class="col-12 text-center">
			Uhrzeit: <?php echo date( 'l, m.d, h:i \U\h\r' ); ?><br>
		</div>
	</div>

	<div class="row">
		<?php
		$dir   = '../tmp/';
		$files = array_reverse( glob( $dir . 'log*\.jpg' ), GLOB_NOSORT );

		array_multisort( array_map( 'filemtime', $files ), SORT_NUMERIC, SORT_DESC, $files );

		foreach ( $files as $file ) {
			$id      = substr( basename( $file, '.jpg' ), 4 );
			$svg     = $dir . basename( $id, '.jpg' ) . '.svg';
			$caption = '';

			printf(
				'<div class="col-6 col-md-3 col-lg-2">
                    <figure>
                        <a href="show_single_sharepic.php?id=%1$s"><img src="%2$s" class="img-fluid"/></a>
                        <figcaption><a href="">%3$s</a></figcaption>
                </div>',
				$id,
				$file,
				$caption
			);
		}
		?>
	</div>

</div>
</scroll-container>
</html>
