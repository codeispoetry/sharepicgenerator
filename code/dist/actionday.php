<?php

$actionsdays = parse_ini_file('ini/actiondays.ini', TRUE);
    foreach ($actionsdays AS $name => $day) {
        $timestamp = strToTime( $day['strtotime'] . " + 23 hours 59 minutes");
        if( $timestamp == 0 ){
            continue;
        }
        if( time() > strToTime( "- 1 week", $timestamp) AND time() < $timestamp){
            switch( floor( ( ($timestamp - time() )/3600/24))){
                case 0:
                    $remainingTimeText = "Heute ";
                    break;
                case 1:
                    $remainingTimeText = "Morgen";
                    break;
                default:
                    $remainingTimeText = sprintf("Am kommenden %s ", strftime("%A", $timestamp) );

            }
            break;
        }
    }

    if( isset($remainingTimeText) ){

?>


<div class="col-12 text-center mb-5">
    <i class="far fa-hand-point-right"></i>
    Sharepic-Idee:
    <?php printf('%s ist <a href="%s" target="_blank"><i class="fas fa-external-link-alt ml-2 mr-1 small"></i>%s</a>.', $remainingTimeText, $day['url'], $day['description']); ?>
</div>

<?php
}
?>