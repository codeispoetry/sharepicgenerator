<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
	<style>
		.graphCanvas{
			display: flex;
    		align-items: baseline;
		}
		.graph{
			background: #46962b;
			width: 10px;
			margin-right: 1px;
		}
	</style>
</head>
<body>
<?php readLogs(); ?>
<div class="container-fluid">
    <div class="row">
		<div class="col-12 text-center">
			<h2>Statistiken</h2>
		</div>
		<div class="col-12 text-center mb-3">
			<a href="show.php" class="btn btn-primary btn-sm"><i class="fas fa-images"></i> Zeige die jüngsten Sharepics</a>
		</div>
        <div class="col-6 col-md-6 col-lg-3">
			<dl>
				<dt><i class="fas fa-users"></i> User</dt>
				<dd>
					gesamt:
						<?php echo number_format(getUsers(),0,',','.'); ?>
						<br>
					Logzeit seit 
						<?php echo number_format(getLoggingPeriodInDays(),0,',','.'); ?> Tagen 
						<br>
					täglich:
						<?php printf("%d", getAverageUserPerDay()); ?>
                        <br>
                    Telegram-User
                        <?php echo getTelegramUser(); ?>
                        <br>
                    mit Zwischenspeicherung:
                        <?php echo getUserWithSaving(); ?>
                        <br>
                    mit eigenem Logo:
                        <?php echo getUserWithCustomLogo(); ?>
                        <br>

					
				</dd>
			</dl>
		</div>
		<div class="col-6 col-md-6 col-lg-3">
			<dl>
				<dt><i class="fas fa-download"></i> Downloads</dt>
				<dd>
					gesamt: 
						<?php echo number_format(getDownloads(),0,',','.'); ?>
					<br>
					mit Pixabay: 
						<?php echo number_format(getPixabay(),0,',','.'); ?>
						(<?php printf('%02d', 100*getPixabay()/getDownloads()); ?>%)
					<br>

					für Social Media: 
						<?php echo number_format(getSocialMedia(),0,',','.'); ?>
						(<?php printf('%02d', 100*getSocialMedia()/getDownloads()); ?>%)

				</dd>
			</dl>
		</div>
		<div class="col-6 col-md-6 col-lg-3">
			<dl>
				<dt><i class="fas fa-bullhorn"></i> Social Media</dt>
				<dd>
					<ul>
						<?php showSocialMedia(); ?>
					</ul>
				</dd>
			</dl>
		</div>
		<div class="col-6 col-md-6 col-lg-3 d-none">
			<dl>
				<dt><i class="fas fa-sitemap"></i>> Bundesländer</dt>
				<dd><?php echo showProvinces(); ?></dd>
			</dl>
		</div>
		<div class="col-6 col-md-6 col-lg-3">
			<dl>
				<dt><i class="fas fa-sitemap"></i> Mandanten</dt>
				<dd><?php echo showTenants(); ?></dd>
			</dl>
		</div>
		<div class="col-6 col-md-6 col-lg-3 d-none">
			<dl>
				<dt><i class="fas fa-clock"></i> Uhrzeiten</dt>
				<dd><?php echo showHours(); ?></dd>
			</dl>
		</div>
		<div class="col-6 col-md-6 col-lg-3 d-none">
			<dl>
				<dt><i class="fas fa-church"></i> Wochentage</dt>
				<dd><?php echo showWeekdays(); ?></dd>
			</dl>
		</div>

		<div class="col-12">
			<dl>
                <dt><i class="fas fa-chart-line"></i> Entwicklung</i></dt>
                <dd class="graphCanvas"><?php echo drawTimeline(); ?></dd>
			</dl>
		</div>

        <div class="col-12 d-none">
            <i class="fab fa-telegram"></i> Telegram</i>
            <div class="row"><?php /* echo showTelegramPics(); */?></div>
        </div>
	</div>
</div>
</body>
</html>



<?php


function readLogs(){
	global $info;

	$lines = file('log.log');

	$info = array(
		'socialmedia' => array()
	);
	

	foreach( $lines AS $line ){
		list( $time, $user, $action, $payload1, $payload2 ) = explode("\t", trim($line) );

        if( floor(time()/86400) == floor($time/86400) ){
            // do not evaluate data from today
            // break;
        }

		$day =  date('l, d.m.',  $time );
		$hour =  date('G',  $time ) / 6;
		$weekday =  date('w',  $time );


		switch( $action ){
			case "login":
				$info['logins'][ $day ][] =  $user;
				$info['users'][] = $user;
				$info['hours'][ $hour ][] = $user;
				$info['weekdays'][ $weekday ][] = $user;
				$info['provinces'][ $payload1 ][] = $user;
				$info['tenants'][ $payload2 ][] = $user;

			break;
			case "download":
				$info['downloads']++;
				if( $payload1 ){
					$info['pixabay']++;
				}
				if( $payload2 ){
					 $info['socialmedia'][ $payload2 ] = $info['socialmedia'][ $payload2 ] + 1 ?: 1;
				}
			break;
		
			default:
				echo("error for line: " . $line );
		}

	}
}

function getUsers(){
	global $info;
	return count(array_unique($info['users']));
}

function getDownloads(){
	global $info;
	return $info['downloads'];
}

function getPixabay(){
	global $info;
	return $info['pixabay'];
}

function showSocialMedia(){
	global $info;
	arsort( $info['socialmedia'] );
	foreach( $info['socialmedia'] AS $platform => $counter){
		printf('<li>%s: %d</li>', $platform, $counter);
	}
}

function getSocialMedia(){
	global $info;
	return array_sum( $info['socialmedia'] );
}

function getTelegramUser(){
	$telegram = glob('../api/user/*', GLOB_ONLYDIR);
	return count($telegram);
}

function showTelegramPics(){
    $telegram = glob('../api/user/*', GLOB_ONLYDIR);
    foreach( $telegram AS $dir){
        printf('<div class="col-2"><img src="%s/sharepic.jpg" class="img-fluid"></div>', $dir);
    }
}



function getLoggingPeriodInDays(){
	global $info;
	return count ($info['logins']);
}

function showTimeline(){
	global $info;

	$i = 0;
	foreach( array_reverse($info['logins']) AS $day => $users){
		printf('<li>%s: %d</li>', $day, count(array_unique($users)));
		$i++;

		if( $i == 7 ){
			return;
		}
	}
}

function showHours(){
	global $info;
	$totalUsers = 0 ;
	foreach( $info['hours'] AS $hour => $users){
		$totalUsers += count(array_unique($users));
	}

	ksort($info['hours']);

	$hours = array('0 bis 6', '6 bis 12', '12 bis 18', '18 bis 24');


	foreach( $info['hours'] AS $hour => $users){
		printf('<li>%s: %.1f%%</li>', $hours[ $hour ], 100*count(array_unique($users))/$totalUsers);

	}
}

function showWeekdays(){
	global $info;

	ksort($info['weekdays']);
	$days = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');

	foreach( $info['weekdays'] AS $weekday => $users){
		printf('<li>%s: %d</li>', $days[$weekday], count(array_unique($users)));

	}
}

function showProvinces(){
	global $info;
	$totalUsers = getUsers();

	ksort($info['provinces']);
	$provinces = array('offbyone','Baden-Württemberg', 'Bayern', 'Berlin', 'Brandenburg', 'Bremen', 'Hamburg', 'Hessen',
						'Mecklenburg-Vorpommern','Niedersachsen','Nordrhein-Westfalen','Rheinland-Pfalz','Saarland',
					'Sachsen','Sachen-Anhalt','Schleswig-Holstein','Thürigen');
	foreach( $info['provinces'] AS $province => $users){
		printf('<li>%s: %.1f%%</li>', $provinces[ $province ], 100*count(array_unique($users))/$totalUsers);

	}
}

function showTenants(){
	global $info;
	
	foreach( $info['tenants'] AS $tenant => $users){
		printf('<li>%s: %s</li>', $tenant, number_format(count(array_unique($users)),0,',','.'));

	}
}

function drawTimeline(){
	global $info;

	$i = 0;
	echo array_keys($info['logins'])[0];
	foreach( $info['logins'] AS $day => $users){
		printf('<span class="graph" style="height:%dpx" title="%1$d am %2$s"></span>', count(array_unique($users)), $day);
	}
	echo end(array_keys($info['logins']));
}

function getAverageUserPerDay(){
    global $info;

    $days = array();

    foreach( $info['logins'] AS $day => $users){
         $days[ $day ] = count(array_unique($users));
    }

    return array_sum($days) / count( $days );
}

function getUserWithSaving(){
    exec('find ../persistent/user/ -name save.txt | wc -l', $output);
    return $output[0];
}

function getUserWithCustomLogo(){
    exec('find ../persistent/user/ -name logo.png | wc -l', $output);
    return $output[0];
}
