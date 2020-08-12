<?php

$actionsdays = parse_ini_file('ini/actiondays.ini', TRUE);

function getNextActionDays( $count = 3){
    global $actionsdays;

    $remainingActionDays = array();

    $i = 0;
    foreach ($actionsdays AS $name => $day) {
        if (empty($day['strtotime'])) {
            continue;
        }

        $timestamp = strToTime($day['strtotime'] . " + 23 hours 59 minutes");
        if ($timestamp == 0) {
            continue;
        }
        if (time() < $timestamp) {
            array_push($remainingActionDays, $day['description']);
            $i++;
        }

        if( $i == $count ){
            break;
        }
    }
    return join(', ', $remainingActionDays);
}

function nextActionDay()
{
    global $actionsdays;

    foreach ($actionsdays AS $name => $day) {
        if (empty($day['strtotime'])) {
            continue;
        }

        $timestamp = strToTime($day['strtotime'] . " + 23 hours 59 minutes");
        if ($timestamp == 0) {
            continue;
        }
        if (time() > strToTime("- 1 week", $timestamp) AND time() < $timestamp) {
            switch (floor((($timestamp - time()) / 3600 / 24))) {
                case 0:
                    $remainingTimeText = "Heute ";
                    print_r($day);
                    break;
                case 1:
                    $remainingTimeText = "Morgen";
                    break;
                default:
                    $remainingTimeText = sprintf("Am kommenden %s ", strftime("%A", $timestamp));

            }
            break;
        }
    }

    if (isset($remainingTimeText)) {
        ?>


        <div class="col-12 text-center mb-5">
            <i class="far fa-hand-point-right"></i>
            Sharepic-Idee:
            <?php printf('%s ist <a href=#" class="overlay-opener" data-target="actiondays">%s</a>.', $remainingTimeText, $day['description']); ?>
        </div>

        <?php
    }
}
?>