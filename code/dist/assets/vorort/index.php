<?php
require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/user_functions.php' );
useLocale( 'de_DE' );

session_start();
readConfig();

$landesverband = 0;
$user          = 'generic';
$tenant        = 'vorort';

$user = do_saml_login();

$accesstoken               = createAccessToken( $user );
$_SESSION['accesstoken']   = $accesstoken;
$_SESSION['user']          = $user;
$_SESSION['landesverband'] = $landesverband;
$_SESSION['tenant']        = $tenant;


$csrf             = uniqid();
$_SESSION['csrf'] = $csrf;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
	<style>
		img.celebrity{
			height: 150px;
			margin: 0 20px 20px 0;
			border: 1px solid white;
			border-radius: 7px;
			padding: 8px;
		}
		img.celebrity:hover{
			border-color: #145f32;
			background: #145f32;
		}
	   </style> 
</head>
<?php


if ( isset( $_GET['delete'] ) ) {
	if ( ! isset( $_GET['sure'] ) ) {
		printf(
			'Bist Du sicher? Soll die Datei %s wirklich gelöscht werden?<br> <a href="index.php?sure=1&delete=%s">Ja</a> - <a href="index.php">Nein</a>',
			$_GET['delete'],
			$_GET['delete']
		);

		die();
	}
	$filename = basename( preg_replace( '/[^a-z]/', '', $_GET['delete'] ), '.png' ) . '.png';
	unlink( 'celebrities/' . $filename );
}


if ( isset( $_POST['filename'] ) and $_FILES['file']['error'] === 0 ) {
	$filename = preg_replace( '/[^a-z.]/', '', $_POST['filename'] );
	move_uploaded_file( $_FILES['file']['tmp_name'], 'celebrities/' . $filename );
}


if ( isset( $_POST['celebrities'] ) ) {
	$content = $_POST['celebrities'];
	$file    = getBasePath( '/tmp/celebrities.txt' );

	file_put_contents( $file, $content );

	if ( ! @parse_ini_file( $file ) ) {
		unlink( $file );
		die( 'Die Datei ist fehlerhaft. Fehlt evtl. ein Anführungszeichen o. ä.?' );
	}

	rename( 'celebrities/celebrities.ini', 'celebrities/celebrities' . time() . '.tmp' );
	rename( $file, 'celebrities/celebrities.ini' );

}
?>
<body>
	<div class="container">
		<div class="row">
			<div class="col-8 offset-2">
				<h2>Infos bearbeiten</h2>   
				<form method="post">
					<div class="form-outline mb-4">
						<textarea class="form-control" id="celebrities" rows="10" name="celebrities"><?php echo file_get_contents( 'celebrities/celebrities.ini' ); ?></textarea>
					</div>
					<div>
						<small>Format:
							<pre>
								[Dateiname]
								name = Name im Dropdown
								description = Text mit Einrückung im Bild
							</pre>
						</small>
					</div>
					<button type="submit" class="btn btn-primary btn-block mb-4">speichern</button>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-8 offset-2">
				<h2>Bild hochladen</h2>   
				<form method="post" enctype="multipart/form-data">
					<div class="form-outline mb-4">
						<input placeholder="Dateiname (nur Kleinbuchstaben, mit .png)" required class="form-control" id="filename" name="filename" pattern="[a-z.]+">
						<small>Vorhandene Dateinamen werden überschrieben. Mit Dateiendung .png. Nur Kleinbuchstaben.</small>
					</div>
					<div class="form-outline mb-4">
						<input class="form-control d-block" id="file" required type="file" name="file" accept="image/png">
					</div>
					<button type="submit" class="btn btn-primary btn-block mb-4">hochladen</button>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-8 offset-2">
				<h2>Bilder</h2>   
				<small>Bild anklicken zum Löschen</small><br>
				<?php
					$images = glob( 'celebrities/*.png' );
				foreach ( $images as $image ) {
					printf(
						'<a href="index.php?delete=%s"><img src="%s" title="%s" class="celebrity"></a>',
						basename( $image, '.png' ),
						$image,
						basename( $image )
					);
				}
				?>
			</div>
		</div>
	</div>

</body>
</html>
