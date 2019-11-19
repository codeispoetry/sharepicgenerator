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
    <input type='file' id="uploadfile" accept='image/*'>

    <button id="download">Download</button>
    <textarea id="text">Hier kannst Du
!den Text ändern.
Auch noch in der dritten und
sogar 4. Zeile. äöüß</textarea>

  <input type="range" id="textfieldresize" min="1" max="<?php echo $info['width']; ?>">

  <input type="text" id="subline" value="gruene-bayern.de">
  </header>

  <section>
    <div id="canvas"></div> 
  </section>


  <script>
      var info = {
        width: <?php echo $info['width']; ?>,
        height: <?php echo $info['height']; ?>,
        size: <?php echo $info['width']; ?>,
        x: 15,
        y: 50,
    }; 
  </script>
  <script src="./vendor/jquery-3.4.1.min.js"></script>
  <script src="./vendor/svg.min.js"></script>
  <script src="./vendor/svg.draggable.min.js"></script>
  <script src="./js/main.min.js"></script>
  </body>
</html>