<?php
require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/log_functions.php' );
require_once getBasePath( 'lib/log_show_functions.php' );
require_once getBasePath( 'lib/user_functions.php' );

useLocale( 'de_DE' );

session_start();
readConfig();

$user = do_saml_login();

$tenant = @$_GET['tenant'] ?: false;

if ( empty( $tenant ) ) {
	die( '<p class="text-white">Kein Tenant angegeben</p>' );
}

$tenant = preg_replace( '/[^a-zA-Z]/', '', $tenant );

$accesstoken             = createAccessToken( $user );
$_SESSION['accesstoken'] = $accesstoken;
$_SESSION['user']        = $user;
$_SESSION['tenant']      = $tenant;

$csrf             = uniqid();
$_SESSION['csrf'] = $csrf;

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8"/>
	<meta name="theme-color" content="#46962b">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Neueste Sharepics</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
	<style>
		scroll-container {
			scroll-behavior: smooth;
		}
	</style>
</head>
<?php
if ( ! isEditor() ) {
	die( '<p class="text-white">Keine Berechtigung</p>' );
}
?>
<body style="background: white">
<scroll-container>
<div class="container-fluid">
	<div class="row text-center mt-3">
		<h1>Sharepics für <?php echo ucFirst( $tenant ); ?></h1>       
	</div>

	<div class="row">
		<div class="col-12">
			Bisher wurden 
				<?php echo number_format( getNumberOfDownloadsByTenant( $tenant ), 0, ',', '.' ); ?> 
			Sharepics von 
				<?php echo number_format( getNumberOfUsersByTenant( $tenant ), 0, ',', '.' ); ?> 
			unterschiedlichen User*innen erstellt.
			Tägliche Downloads:
		</div>
	</div>

	<div class="col-12 pb-5">
		<?php showLogGraph( $tenant ); ?>
	</div>

	<div class="col-12">
		<h2>Die neuesten Sharepics</h2>
	</div>

	<div class="row">
		<?php
			$results = getDownloadsByTenant( $tenant );

		while ( $row = $results->fetchArray() ) {
			$file = sprintf( 'tmp/log_%s.jpg', $row['sharepicid'] );

			if ( ! file_exists( $file ) ) {
				continue;
			}

			printf( '<div class="col-6 col-md-3 col-lg-2"><img src="%s" class="img-fluid me-1 mb-1"></div>', $file );
		}
		?>
	</div>

	<div class="row">
		<?php
		$dir   = 'tmp/btw*';
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
