<?php

function convertExoticExtensions( $filebasename, $extension ) {
	$filename = $filebasename . '.' . $extension;

	// convert webp to jpg, as inkscape cannot handle webp
	if ( strToLower( $extension ) == 'webp' ) {
		$newFilename = $filebasename . '.jpg';
		$command     = sprintf(
			'dwebp %s -o %s',
			$filename,
			$newFilename
		);
		exec( $command );
		$filename = $newFilename;

		return $newFilename;
	}

	// convert heic
	if ( strToLower( $extension ) == 'heic' ) {
		$newFilename = $filebasename . '.jpg';
		$command     = sprintf(
			'heif-convert %s %s',
			$filename,
			$newFilename
		);
		exec( $command );
		$filename = $newFilename;

		return $newFilename;
	}

	return $filebasename;
}

function handleBackgroundUpload( $extension ) {
	$filebasename = getBasePath( 'tmp/' . uniqid( 'upload', true ) );
	$filename     = $filebasename . '.' . $extension;

	$moved = move_uploaded_file( $_FILES['file']['tmp_name'], $filename );

	// convert webp to jpg, as inkscape cannot handle webp
	if ( in_array( strToLower( $extension ), array( 'webp', 'heic' ) ) ) {
		$filename  = convertExoticExtensions( $filebasename, $extension );
		$extension = 'jpg';
	}

	$filesJoin = join( ':', $_FILES['file'] );

	$filename_small = $filebasename . '_small.' . $extension;
	prepareFileAndSendInfo( $filename, $filename_small );
}

function handleAddPicUpload( $extension ) {
	$filebasename = getBasePath( 'tmp/' . uniqid( 'addpic' ) );
	$filename     = $filebasename . '.' . $extension;

	move_uploaded_file( $_FILES['file']['tmp_name'], $filename );

	$command = sprintf( 'mogrify -auto-orient %s', $filename );
	exec( $command );

	$return['addpicfile'] = '../' . $filename;
	$return['okay']       = true;

	echo json_encode( $return );
}

function handleAddPicUploadByUrl() {
	$url       = $_POST['url2copy'];
	$extension = pathinfo( parse_url( $_POST['url2copy'], PHP_URL_PATH ), PATHINFO_EXTENSION );

	$filebasename = getBasePath( 'tmp/' . uniqid( 'upload' ) );
	$filename     = $filebasename . '.' . $extension;

	if ( ! copy( $url, $filename ) ) {
		echo json_encode( array( 'error' => 'could not copy file' ) );
		die();
	}

	$return['addpicfile'] = '../' . $filename;
	$return['okay']       = true;

	echo json_encode( $return );
}

function handleUploadLogo( $extension ) {
	$userdir = getBasePath( 'persistent/user/' . getUser() );

	system( 'rm ' . $userdir . '/logo.*' );
	$filename = $userdir . '/logo.' . $extension;

	move_uploaded_file( $_FILES['file']['tmp_name'], $filename );

	$return['logo'] = $filename;
	$return['okay'] = true;

	echo json_encode( $return );
}

function isFileAllowed( $extension, $allowed ) {
	return in_array( strtolower( $extension ), $allowed );
}


function handleUploadByUrl() {
	$url       = $_POST['url2copy'];
	$extension = pathinfo( parse_url( $_POST['url2copy'], PHP_URL_PATH ), PATHINFO_EXTENSION );

	$filebasename   = getBasePath( 'tmp/' . uniqid( 'upload' ) );
	$filename       = $filebasename . '.' . $extension;
	$filename_small = $filebasename . '_small.' . $extension;

	if ( ! copy( $url, $filename ) ) {
		echo json_encode( array( 'error' => 'could not copy file' ) );
		die();
	}

	prepareFileAndSendInfo( $filename, $filename_small );
}

function prepareFileAndSendInfo( $filename, $filename_small ) {
	$command = sprintf(
		'mogrify -auto-orient %s',
		$filename
	);
	exec( $command );

	$command = sprintf(
		'convert %s[800x800] -resize 800x450 %s',
		$filename,
		$filename_small
	);
	exec( $command );

	$return['filename']                                 = '../' . $filename_small;
	list($width, $height, $type, $attr)                 = getimagesize( $filename_small );
	list($originalWidth, $originalHeight, $type, $attr) = getimagesize( $filename );

	$return['width']              = $width;
	$return['height']             = $height;
	$return['originalWidth']      = $originalWidth;
	$return['originalHeight']     = $originalHeight;
	$return['fullBackgroundName'] = $filename;

	echo json_encode( $return );
	die();
}
