<?php
require_once('base.php');
require_once(getBasePath("lib/functions.php"));
require_once(getBasePath("lib/save_functions.php"));
require_once(getBasePath("lib/gallery_functions.php"));

useDeLocale();

session_start();
readConfig();

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>  
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">

</head>
<?php
    $img = 'bettina.png';
    list($w, $h ) = getimagesize($img);
?>
<body class="h-100">

<a href="https://github.com/svgdotjs/svg.filter.js?files=1" target="_blank">Mögliche SVG-Filter</a>
<div class="d-flex">
    <img src="<?php echo $img;?>" style="width: <?php echo $w;?>px; height: <?php echo $h;?>px">
    <div id="canvas">
    </div>
</div>


    

<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/node_modules/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.js/dist/svg.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.draggable.js/dist/svg.draggable.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.filter.js/dist/svg.filter.min.js"></script>


<script>
const draw = SVG().addTo('#canvas');
draw.size(<?php echo "$w,$h";?>)

const pistazie = draw.image('pistazie.png', () => {
    pistazie.size(<?php echo "$w,$h";?>);
});

const image = draw.image('<?php echo $img;?>', () => {
    image.size(<?php echo "$w,$h";?>);
   doFilter();
});

function doFilter(){
   
}
    
</script>

</body>
</html>
