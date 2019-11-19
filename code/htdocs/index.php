<!DOCTYPE html>
<?php
  $info = [];
  $info['width'] = 800;
  $info['height'] = 450;

?>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sharepicgenerator Bayern</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
  </head>
  <body>

  <div id="content">
  
  <div id="canvas"></div> 
 
 
  <div id="cockpit">
    <div>
      <input type='file' id="uploadfile" accept='image/*'>
    </div>
    <div>
      <button id="download">Download</button>
    </div>
    <div>
        <textarea id="text">Hier der Text</textarea>
    </div>
    <div>
        <h6>Textgröße</h6>
        <div class="slider">
          <small>klein</small>
          <input type="range" id="textfieldresize" min="1" max="<?php echo $info['width']; ?>">
          <small>groß</small>
        </div>
    </div>
    <div>
        <h6>Pin</h6>
        <div class="slider">
          <small>klein</small>
          <input type="range" id="pinresize" min="1" max="<?php echo $info['width']; ?>">
          <small>groß</small>
        </div>
    </div>
    <div>
        <input type="text" id="subline" value="gruene-bayern.de">
    </div>
</div>
</div>

  <script>
      var info = {
        width: <?php echo $info['width']; ?>,
        height: <?php echo $info['height']; ?>,
        originalWidth: <?php echo $info['width']; ?>,
        originalHeight: <?php echo $info['height']; ?>,
        size: <?php echo $info['width'] / 1.3; ?>,
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