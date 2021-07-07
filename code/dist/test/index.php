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
    $img = $_GET['img'];
    list($w, $h ) = getimagesize($img);
?>
<body class="h-100">

<a href="https://github.com/svgdotjs/svg.filter.js?files=1" target="_blank">Mögliche SVG-Filter</a>
<a href="http://andresgalante.com/RGBAtoFeColorMatrix/">create matrix</a>
<div class="d-flex">
    <img src="<?php echo $img;?>" style="width: <?php echo $w;?>px; height: <?php echo $h;?>px">
    <div id="canvas" style="margin-left:1px;border:0;box-shadow:none" >
    </div>
</div>


    

<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.js/dist/svg.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.filter.js/dist/svg.filter.min.js"></script>


<script>
const draw = SVG().addTo('#canvas');
draw.size(<?php echo "$w,$h";?>)

const pistazie = draw.image('pistazie.png', () => {
    pistazie.size(<?php echo "$w,$h";?>).hide();
});

const image = draw.image('<?php echo $img;?>', () => {
   image.size(<?php echo "$w,$h";?>);
   doSepia();
});

function doMultiply(){
    image.filterWith(function(add) {
        add.colorMatrix('saturate', 0).blend(pistazie,'multiply');
    });
}

function doSepia(){
    image.filterWith(function(add) {
        const contrast = 330;
        add
            .colorMatrix('saturate', 0)
            .componentTransfer({
                type: 'linear',
                slope: contrast,
                intercept: -(0.5 * contrast) + 0.5
            })
            .colorMatrix('matrix', [ 
                0.359, 0, 0, 0, 0
                , 0, 0.585, 0, 0, 0
                , 0, 0, 0.129, 0, 0
                , 0, 0, 0, 1, 0
            ]);
    });
}

    
</script>

</body>
</html>
