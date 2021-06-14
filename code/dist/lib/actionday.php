<?php

function getNextActionDays($count = 3)
{
    $actionsdays = parse_ini_file(getBasePath('/ini/actiondays.ini'), true);

    $remainingActionDays = array();

    $i = 0;
    foreach ($actionsdays as $name => $day) {
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

        if ($i == $count) {
            break;
        }
    }
    return join(', ', $remainingActionDays);
}

function nextActionDay()
{
    $actionsdays = parse_ini_file(BASEDIR.'/ini/actiondays.ini', true);

    foreach ($actionsdays as $name => $day) {
        if (empty($day['strtotime'])) {
            continue;
        }

        $timestamp = strToTime($day['strtotime'] . " + 23 hours 59 minutes");
        if ($timestamp == 0) {
            continue;
        }
        if (time() > strToTime("- 1 week", $timestamp) and time() < $timestamp) {
            switch (floor((($timestamp - time()) / 3600 / 24))) {
                case 0:
                    $remainingTimeText = "Heute ist";
                    break;
                case 1:
                    $remainingTimeText = "Morgen ist";
                    break;
                default:
                    $remainingTimeText = sprintf("Am kommenden %s ist", strftime("%A", $timestamp));
            }
            break;
        }
    }

    if (isset($remainingTimeText)) {
        ?>
        <?php

        $GLOBALS['toasts'] .= <<<EOL
        <div class="toast toast-actionday border-info" data-id="$name" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-info text-white">
        
            <strong class="mr-auto">Sharepic-Idee</strong>
            <small class="small text-white">
                <a href=#" class="overlay-opener text-white" data-target="actiondays">Alle Aktionstage</a> 
            </small>
            <button type="button" class="ms-2 mb-1 close text-danger text-shadow-none" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            $remainingTimeText<br>
            <strong>{$day['description']}</strong>
            <div class="text-right">
                <a href="{$day['url']}" class="small"><i class="fa fa-link"></i> mehr Informationen</a>
            </div>        
        </div>
        </div>
EOL;
    }
}

