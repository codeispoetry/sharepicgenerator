<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Markdown 2 Image</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap4-toggle.min.css">
    <link rel="apple-touch-icon" sizes="57x57" href="../favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicons/favicon-16x16.png">
    <link rel="manifest" href="../favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="../favicons/ms-icon-144x144.png">
    <style type="text/css">
        #input{
            min-height: 10em;
            font-family: "Courier New", Courier, monospace;
        }
        #output{
           box-shadow: gray 3px 3px 8px;
        }
    </style>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center"><h2>Tabellen-Generator</h2></div>
       <div class="col-6">
           <h4>Input</h4>
           <small>
               <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">
                   in Markdown-Syntax. <i class="fab fa-markdown"></i> Hier gibt es Hilfe zu Markdown.
               </a>
           </small>
           <textarea class="form-control" id="input"><?php require_once("start.md");?></textarea>
           <div class="d-flex">

               <label for="width" class="col-sm-2 col-form-label">Breite</label>
               <input type="number" id="width" class="form-control size" value="500" min="200" max="1920">
               <label for="height" class="col-sm-2 col-form-label">Höhe</label>
               <input type="number" id="height" class="form-control size" value="250"  min="200" max="1080">

           </div>
       </div>

        <div class="col-6">
            <h4>Output</h4>
            <small>
                HTML-Output. Kann in den Developertools per Hand verändert werden.
            </small>
           <div id="output">

           </div>
       </div>

        <div class="col-12 text-center">
            <button class="btn btn-secondary btn-lg mt-3" id="download">
                <i class="fas fa-download"></i> Bild herunterladen
            </button>
        </div>
    </div>
</div>

<footer class="row bg-primary p-2 text-white">
    <div class="col-12 col-lg-6">
        <a href="/documentation/markdown/" target="_blank"><i class="fas fa-question-circle"></i> Anleitung</a>
        <a href="/federal/"><i class="fas fa-cog ml-3"></i> Zum Sharepicgenerator</a>
    </div>

    <div class="col-12 col-lg-6 text-lg-right">
        <a href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank"><i class="fas fa-comment-dots"></i> Feedback</a>
        <a href="https://github.com/codeispoetry/sharepicgenerator" target="_blank" class="ml-3"><i class="fab fa-github"></i> Quellcode</a>
        <a href="/imprint.php" target="_blank" class="ml-3"><i class="fas fa-balance-scale-right"></i> Impressum</a>
        <span class="ml-3">
            <i class="fas fa-spa text-yellow"></i> Programmiert von
            <a href="MAILTO:mail@tom-rose.de?subject=Sharepicgenerator">Tom Rose</a>.</span>
    </div>
</footer>

<script src="../vendor/jquery-3.4.1.min.js"></script>
<script src="../vendor/bootstrap.min.js"></script>
<script src="../vendor/bootstrap4-toggle.min.js"></script>
<script src="./vendor/markdown-it.min.js"></script>
<script>
    $( document ).ready(function() {
        let md = window.markdownit();

        function render() {
            let html = md.render( $('#input').val());
            $('#output').html(html);
        }
        render();
        $('#input').bind('input propertychange', render );

        function setSize(){
            let width = $('#width').val();
            let height = $('#height').val();
            $('#output').css({width: width, height: height});
            $('#input').css({height: height});
        }
        setSize();
        $('.size').bind('input propertychange', setSize );

        $('#download').click(function () {
            $(this).prop("disabled", true);
            let description = $(this).html();

            $.ajax({
                type: "POST",
                url: 'createpic.php',
                data: {html: $('#output').html(), width: $('#width').val(), height: $('#height').val()  },
                success: function (data, textStatus, jqXHR) {
                    let obj = JSON.parse(data);
                    $('#download').prop("disabled", false);
                    $('#download').html(description);
                    let downloadname = sanitizeDownloadname($('#input').val());

                    window.location.href = 'download.php?file=' + obj.basename + '&downloadname=' + downloadname;
                }
            });
        });

        function sanitizeDownloadname( input ) {
            let downloadname = input.toLowerCase();console.log(downloadname);

            downloadname = downloadname.replace(/[^a-zA-Z0-9]/g, '-');
            downloadname = downloadname.replace(/\-+/g, '-');
            downloadname = downloadname.replace(/^\-/g, '');
            downloadname = downloadname.replace(/\-$/g, '');

            downloadname = downloadname.substring(0, 20);
            return downloadname;
        }
    });
</script>

</body>
</html>
