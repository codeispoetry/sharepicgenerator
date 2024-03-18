<?php
require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/log_show_functions.php' );

setlocale( LC_TIME, 'de_DE', 'de_DE.UTF-8', 'de_DE.utf8' );
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8"/>
	<meta name="theme-color" content="#46962b">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logs</title>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>
<body style="background:white">
<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center">
			<h2>Statistiken
				<?php
				if ( isset( $_GET['tenant'] ) ) {
					$tenant = preg_replace( '/[^a-zA-Z]/', '', $tenant );

					echo 'für ' . ucfirst( $tenant );
				}
				?>
			</h2>
		</div>
		<div class="col-12 text-center mb-3">
			<a href="show.php" class="btn btn-primary btn-sm"><i class="fas fa-images"></i> Zeige die jüngsten Sharepics</a>
			<a href="showai.php" class="btn btn-primary btn-sm"><i class="fas fa-images"></i> AI-Log</a>

		</div>
		<div class="col-12">
			<h4>Systemgesundheit</h4>
			Uhrzeit: <?php echo strftime( '%A, %d.%m, %H:%M', time() ); ?><br>
			Freier Festplattenplatz: <?php echo getFreeSpace(); ?>
		</div>
		<div class="col-12 pb-5">
			<?php 
			$tenant = preg_replace( '/[^a-zA-Z]/', '', $tenant );

			showLogGraph( $tenant ); 
			?>
		</div>
		<div class="col-6 col-md-6 col-lg-3">
			<dl>
				<dt><i class="fas fa-users"></i> User</dt>
				<dd>
					<?php
						$totalDownloads = getDownloads();
					?>
					gesamt: <?php echo number_format( getUsers(), 0, ',', '.' ); ?>
						<br>
					letzten 30 Tage: <?php echo number_format( getUsersLastDays( 30 ), 0, ',', '.' ); ?>
						<br>
					Logzeit seit ca.<?php echo number_format( getLoggingPeriodInDays() / 30, 0, ',', '.' ); ?> Monaten
						<br>
				</dd>
			</dl>
		</div>
		<div class="col-6 col-md-6 col-lg-3">
			<dl>
				<dt><i class="fas fa-download"></i> Downloads</dt>
				<dd>
					gesamt: <?php echo number_format( getDownloads(), 0, ',', '.' ); ?>
					<br>
					täglich (in letzten 30 Tagen): <?php echo @number_format( getDailyDownloadsLastDays( 30 ), 0, ',', '.' ); ?>
					<br>
					AI getested: <?php echo @number_format( getAI( 'tested' ), 0, ',', '.' ); ?>
					<br>
					AI genutzt: <?php echo @number_format( getAI( 'used' ), 0, ',', '.' ); ?>
			</dl>
		</div>
		
		<div class="col-6 col-md-6 col-lg-3">
			<dl>
				<dt><i class="fas fa-sitemap"></i> Tenants (>50)</dt>

				<dd><ul><?php echo showTenantsDownloads(); ?></ul></dd>

			</dl>
		</div>
	 
	</div>
</div>
</body>
</html>
