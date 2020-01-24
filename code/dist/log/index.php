<style>
    li{
        margin-bottom: 0.7em;
    }
</style>
<?php

$lines = file('log.log');

$logins = array();
$users = array();


foreach( $lines AS $line ){
	list( $time, $payload, $action ) = explode("\t", trim($line) );
	
	$day =  date('d.m.Y',  $time );

	switch( $action ){
		case "login":
			$logins[ $day ][] =  $payload;
			$users[] = $payload;
		break;
		case "download":
			$slogans[] = $payload;
		break;
		default:
			die("error for line: " . $line );
	}

}


echo '<h2>Users</h2>';
echo 'Total different users: ' . count(array_unique($users));

echo '<h2>Telegram-Users</h2>';
$telegram = glob('../api/user/*', GLOB_ONLYDIR);
echo 'Total telegram users: ' . count($telegram);

echo '<h2>Logins</h2>';
$totaluser = 0;
foreach($logins AS $day => $users){
	$count = count(array_unique($users));
	$totaluser += $count;
	printf("%s: %d<br>", $day, $count );
}
echo "Total logins: " . $totaluser;


echo '<h2>Slogans</h2>';
echo "<ol>";
foreach(  array_unique( $slogans ) AS $slogan ){
	echo "<li>$slogan</li>";
}
echo "</ol>";