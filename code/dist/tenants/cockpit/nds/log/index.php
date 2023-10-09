<?php

require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/log_functions.php' );

session_start();
readConfig();
$tenant = 'nds';

if ( ! isEditor() ) {
	die( 'No access!' );
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8"/>
	<meta name="theme-color" content="#46962b">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logs</title>
	<link rel="stylesheet" type="text/css" href="../../../assets/css/styles.css">
	<style>
		scroll-container {
			scroll-behavior: smooth;
		}
	</style>
</head>
<body>
<scroll-container>
<div class="container-fluid">
	<div class="row mt-3">
		<div class="col-12 text-center">
			<h1>Zuletzt erzeugte Sharepics</h1>
		</div>
	</div>

	<div class="row">
		<?php
			show_images( getBasePath( "/tmp/log_{$tenant}*\.jpg" ) );
		?>
	</div>
</div>
</scroll-container>
</html>
