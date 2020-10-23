<?php
$config = '{"pixabay":{"apikey":"1309982-0e2df8b488eca18e61116743a"},"csrf":"5f92152393f06","user":"nosamlfile","tenant":"federal","pixabaySearchIn":"images","socialmediaplatform":"","noBackgroundDragAndDrop":false,"layout":"nolines"}';
$sharepic ='backgroundsize=800&graybackground=1&blurbackground=0&darklightlayer=0&greenlayer=0&copyrightPosition=bottomLeft&copyright=&layout=nolines&textbefore=Sharepicgenerator.de&text=Es%20beginnt%0D%0A%23mitdir.&textafter=Werde%20kreativ!&textsize=502&iconsize=1&addPicSize1=15&addPicSize2=15&logoselect=sonnenblume&logochapter=&logosize=10&pintext=&pintext=&addtextsize=20&width=1920&height=1080&cloudtoken=&code=&pinX=560&pinY=225&backgroundX=0&backgroundY=0&backgroundURL=%2Fassets%2Fbg_small.jpg&iconfile=&addpicfile1=&addpicfile2=&fullBackgroundName=..%2Fassets%2Fbg.jpg&textX=41&textY=172&addtextX=50&addtextY=400&addPic1x=&addPic1y=&addPic2x=&addPic2y=&textColor=0&eraser=';


parse_str($sharepic, $data);
$data = array_merge(json_decode($config, true), $data);
unset($data['pixabay']);
unset($data['csrf']);


$db = new SQLite3('logs/log.db');
$db->exec("DROP TABLE IF EXISTS downloads");


$sql = sprintf(
    'CREATE TABLE IF NOT EXISTS downloads(
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        %s)',
    join(' TEXT,', array_keys($data))
);

$db->exec($sql);

// create prepared statement
$cols = '';
$values = '';
foreach ($data as $variable => $value) {
    $cols .= "$variable,";
    $values .= ":$variable,";
}
echo '$smt = $db->prepare("INSERT INTO downloads (' . substr($cols, 0, -1). ') values (' . substr($values, 0, -1). ')");';



parse_str($sharepic, $data);
$data = array_merge(json_decode($config, true), $data);
unset($data['pixabay']);
unset($data['csrf']);
if ($data['eraser']) {
    $data['eraser'] = 'true';
};


$smt = $db->prepare("INSERT INTO downloads (user,tenant,pixabaySearchIn,socialmediaplatform,noBackgroundDragAndDrop,layout,backgroundsize,graybackground,blurbackground,darklightlayer,greenlayer,copyrightPosition,copyright,textbefore,text,textafter,textsize,iconsize,addPicSize1,addPicSize2,logoselect,logochapter,logosize,pintext,addtextsize,width,height,cloudtoken,code,pinX,pinY,backgroundX,backgroundY,backgroundURL,iconfile,addpicfile1,addpicfile2,fullBackgroundName,textX,textY,addtextX,addtextY,addPic1x,addPic1y,addPic2x,addPic2y,textColor,eraser) values (:user,:tenant,:pixabaySearchIn,:socialmediaplatform,:noBackgroundDragAndDrop,:layout,:backgroundsize,:graybackground,:blurbackground,:darklightlayer,:greenlayer,:copyrightPosition,:copyright,:textbefore,:text,:textafter,:textsize,:iconsize,:addPicSize1,:addPicSize2,:logoselect,:logochapter,:logosize,:pintext,:addtextsize,:width,:height,:cloudtoken,:code,:pinX,:pinY,:backgroundX,:backgroundY,:backgroundURL,:iconfile,:addpicfile1,:addpicfile2,:fullBackgroundName,:textX,:textY,:addtextX,:addtextY,:addPic1x,:addPic1y,:addPic2x,:addPic2y,:textColor,:eraser)");
$smt->bindValue(':time', time(), SQLITE3_TEXT);
foreach ($data as $variable => $value) {
    $smt->bindValue(':'.$variable, $value, SQLITE3_TEXT);
}
$smt->execute();
