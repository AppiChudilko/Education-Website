<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $server;
global $qb;
global $utcOffset;
global $monthN;

$qm = new \Server\QueryMethods($qb, $server);

?>
<ajax-title><?php echo 'Лог изменений | ' . $settings->getTitle(); ?></ajax-title>

<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12">
                <?php

                $i = 1;

                foreach ($qm->getChangeLog() as $item) {

                    $item['timestamp'] = $item['timestamp'] + $utcOffset;
                    $date = gmdate('d', $item['timestamp']) . ' ' . $monthN[gmdate('m', $item['timestamp'])] . ' ' . gmdate('Y', $item['timestamp']);

                    echo '
                        <h5 class="h-title animated opacity-zero">Change log #' . $item['id'] . ' <label>' . $date . '</label></h5>
                        <div class="light animated opacity-zero">
                            ' . htmlspecialchars_decode(nl2br($item['content'])) . '
                        </div><br>
                        <hr class="animated opacity-zero"><br>
                    ';
                }

                ?>
            </div>
        </div>
    </div>
</div>
