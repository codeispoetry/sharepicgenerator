<?php
$uniqid = uniqid('md2html');
$uniqid = "1";
$filename = 'tmp/' . $uniqid . '.html';
$filenamePic = 'tmp/' . $uniqid . '.png';

$html = $_POST['html'];
$width = (int) $_POST['width'];
$height = (int) $_POST['height'];

file_put_contents($filename, sprintf("<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"../styles.css\"><link rel=\"stylesheet\" type=\"text/css\" href=\"../../assets/css/styles.css\"></head><body>%s</body></html>",$html));

exec("type chromium", $output);
$browser = ( strpos($output[0],'not found') ) ? 'chromium-browser' : 'chromium';

$command = sprintf("%s --headless --screenshot=%s --disable-gpu -default-background-color=0 --no-sandbox --window-size=%d,%d %s 2>&1", $browser, $filenamePic, $width, $height, $filename);
exec( $command, $output );

$command = sprintf("chmod 755 %s", $filenamePic);
exec( $command, $output );

$return = [];
$return['basename'] = basename($filenamePic, 'png');
$return['error'] = $output;
echo json_encode($return);
