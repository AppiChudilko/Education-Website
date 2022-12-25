<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $settings;
global $qb;
global $server;
global $user;
global $filePath;

$qm = new \Server\QueryMethods($qb, $server);
?>
<ajax-title><?php echo 'Преподаватели | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12">
                <h5 class="h-title animated opacity-zero">Преподаватели</h5>

                <div class="card-panel animated opacity-zero">
                    <table class="responsive-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Имя</th>
                            <th>Репутация</th>
                            <th>Подписчиков</th>
                            <th>Жалоб</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php

                            $i = 1;

                            foreach ($qm->getTeacherList() as $item) {
                                echo '
                                <tr class="animated opacity-zero">
                                    <td>' . ($i++) . '</td>
                                    <td>
                                        <img style="width: 40px; height: 40px" src="' . $filePath . $item['img_avatar'] . '" alt="' . $item['name'] . ' ' . $item['surname'] . '" class="circle left">
                                        <a ajax-page="id' . $item['id'] . '" style="font-size: 1.3rem; margin-left: 12px; line-height: 38px;" class="light black-text">' . $item['name'] . ' ' . $item['surname'] . ' &nbsp;' . ($item['verify'] == 1 ? '<i class="mdi mdi-check green-text tooltipped" data-position="left" data-delay="50" data-tooltip="Верифицирован"></i>' : '') . '</a>
                                    </td>
                                    <td>' . number_format($item['rating']) . '</td>
                                    <td>' . number_format($user->getCountFollowers($item['id'])) . '</td>
                                    <td>0</td>
                                    <td><a ajax-page="im' . $item['id'] . '" class="btn btn-small z-depth-0 blue-text transparent waves-effect">Написать</a></td>
                                </tr>
                                ';
                            }

                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>