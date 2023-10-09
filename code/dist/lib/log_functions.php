<?php
function logDownload( $info = array() ) {
	$db = new SQLite3( getBasePath( 'log/logs/log.db' ) );
	if ( isAdmin() ) {
		$db->exec(
			'CREATE TABLE IF NOT EXISTS downloads(
                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP)'
		);
	}

	// define which data from sharepic is logged
	$valuesToLog = array_fill_keys( explode( ',', 'backgroundURL,text' ), false );
	parse_str( $_POST['sharepic'], $sharepic );
	$data = array_intersect_key( $sharepic, $valuesToLog );

	// get data from log
	$log = $_POST['log'];

	// here is all the data
	$data = array_merge( json_decode( $log, true ), $info, $data );

	// sanitize data
	$data['backgroundURL'] = basename( $data['backgroundURL'] );

	// add missing columns
	$columns = array();
	$results = $db->query( "PRAGMA table_info('downloads');" );
	while ( $row = $results->fetchArray() ) {
		// skip timestamp, as it is set automatically later
		if ( $row['name'] === 'timestamp' ) {
			continue;
		}
		$columns[] = $row['name'];
	}

	$newColumns = array_diff( array_keys( $data ), $columns );
	foreach ( $newColumns as $newColumn ) {
		$type = 'TEXT';
		$db->exec( "ALTER TABLE downloads ADD $newColumn $type" );
		$columns[] = $newColumn;
	}

	// do logging into download
	$smt = $db->prepare(
		sprintf(
			'INSERT INTO downloads (%s) values (:%s)',
			join( ',', $columns ),
			join( ',:', $columns )
		)
	);

	foreach ( $data as $variable => $value ) {
		$smt->bindValue( ':' . $variable, $value, SQLITE3_TEXT );
	}
	$smt->execute();
}

function logPicture( $filename ) {
	$afterFileBase = getBasePath( 'tmp/log_' . $filename );

	$command = sprintf(
		'convert -resize 800x800 -background white -flatten -quality 60  %s %s',
		getBasePath( 'tmp/' . $filename . '.png' ),
		$afterFileBase . '.jpg'
	);
	exec( $command );
}
