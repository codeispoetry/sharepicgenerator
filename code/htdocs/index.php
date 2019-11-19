<!DOCTYPE html>
<?php
  $info = [];
  $info['width'] = 400;
  $info['height'] = 400;

?>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sharepicgenerator Bayern</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
  </head>
  <body>

  <header>
    <button id="download">Download</button>
    <textarea id="text">Hier kannst Du
den Text ändern.
    </textarea>

  <input type="range" id="textfieldresize" min="1" max="<?php echo $info['width']; ?>">
  </header>

  <section>
    <div id="canvas"></div> 
  </section>


  <script>
      var info = {
        width: <?php echo $info['width']; ?>,
        height: <?php echo $info['height']; ?>,
        size: 200,
        x:<?php echo $info['width']/2 - 100; ?>,
        y:<?php echo $info['height']/2 - 100 ; ?>,
    }; 
  </script>
  <script src="./vendor/jquery-3.4.1.min.js"></script>
  <script src="./vendor/svg.min.js"></script>
  <script src="./vendor/svg.draggable.min.js"></script>
  <script src="./js/main.min.js"></script>
  </body>
</html>