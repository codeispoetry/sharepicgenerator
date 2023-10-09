<?php
deleteFilesInPathOlderThanHours( __DIR__ . '/tmp/*', null, 2 * 24 );
deleteFilesInPathOlderThanHours( __DIR__ . '/tmp/*.mp4', null, 6 );
deleteFilesInPathOlderThanHours( __DIR__ . '/tmp/*.zip', null, 6 );
deleteFilesInPathOlderThanHours( __DIR__ . '/tmp/qrcode_*', null, 2 );
deleteFilesInPathOlderThanHours( __DIR__ . '/tmp/work*', null, 6 );
deleteFilesInPathOlderThanHours( __DIR__ . '/tmp/fonts/*', null, 6 );

function deleteFilesInPathOlderThanHours( $path, $exclude, $hours ) {
	$cmd = sprintf( 'find %s ! -name "%s" -mmin +%d -delete', $path, $exclude, $hours * 60 );
	file_put_contents( __DIR__ . '/last-cronjob.txt', time() );
	exec( $cmd, $output );
}
