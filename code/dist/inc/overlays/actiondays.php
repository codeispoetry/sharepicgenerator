<?php
$actiondaysIni = parse_ini_file('../ini/actiondays.ini', TRUE);
$actiondays = [];
foreach ($actiondaysIni AS $actionDayId => $actionDayInfo) {
    $timestamp = strToTime( $actionDayInfo['strtotime'] . " + 23 hours 59 minutes");
    if( $timestamp == 0 ){
        continue;
    }

    $month = (int) strftime("%m", $timestamp);
    $actiondays[ $month ][] = $actionDayInfo;
}
?>
<div id="actiondays" class="overlay">
        <div class="container">
            <a href="#" class="close text-danger">
                <i class="fas fa-times"></i>
            </a>
            <div class="row pt-2 mt-1">
                <div class="col-12 text-center">
                    <h2>Aktionstage</h2>
                </div>
            </div>
            <div class="row mt-1">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <?php
                    for($month = 1; $month <=12; $month++){
                        $id = "month" . $month;
                        $name = strftime("%B", mktime(0,0,0,$month, 1, date('Y')));
                        $active = '';

                        if( $month == (int) strftime("%m",mktime())){
                            $active = 'active';
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active; ?>" id="<?php echo $id; ?>-tab" data-toggle="tab" href="#<?php echo $id; ?>" role="tab" aria-controls="videos" aria-selected="false"><?php echo $name; ?></a>
                    </li>
                    <?php
                    }
                    ?>

                </ul>
            </div>
            <div class="row mt-2">
                <div class="tab-content">

                    <?php
                    for($month = 1; $month <=12; $month++) {
                        $id = "month" . $month;
                        $name = strftime("%B", mktime(0, 0, 0, $month, 1, date('Y')));
                        $active = '';

                        if ($month == (int)strftime("%m", mktime())) {
                            $active = 'active';
                        }
                        ?>
                        <div class="tab-pane <?php echo $active; ?>" id="<?php echo $id;?>" role="tabpanel" aria-labelledby="home-tab">
                            <div class="col-12">
                                <h2 class="mt-3"><?php echo $name;?></h2>
                            </div>
                            <div class="col-12">
                                <ul>
                                <?php
                                if( isset($actiondays[ $month ])) {
                                    foreach ($actiondays[$month] AS $actionday) {
                                        $timestamp = strToTime($actionday['strtotime']);
                                        if( $timestamp == 0 ) continue;
                                        printf('<li>%s: <a href="%s" target="_blank">%s</a></li>', strftime("%A, den %e. %B %G", $timestamp), $actionday['url'], $actionday['description']);
                                    }
                                }
                                ?>
                                </ul>

                                <div class="small">
                                <a href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank">
                                    Fehlende Tage kannst Du im Chat melden</a>
                                    oder als
                                <a href="https://github.com/codeispoetry/sharepicgenerator/blob/master/code/dist/ini/actiondays.ini" target="_blank">
                                    Pull-request auf github</a>.
                                </div>
                            </div>

                        </div>

                        <?php
                        }
                        ?>

                </div>
            </div>
        </div>

    </div>