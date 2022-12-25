<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $user;
global $userInfo;

?>
<ajax-title><?php echo 'Список загруженных файлов | ' . $settings->getTitle(); ?></ajax-title>

<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12">
                <h5 class="h-title animated opacity-zero">Список загруженных файлов</h5>

                <ul class="card tabs tabs-transparent white animated opacity-zero">
                    <li class="tab"><a class="black-text" href="#file-list">Список файлов</a></li>
                    <li class="tab"><a class="black-text" href="#video-list">Список видео</a></li>
                    <li class="tab"><a class="black-text" href="#article-list">Список статей</a></li>
                </ul>
                <div class="card-panel animated opacity-zero">
                    <table id="file-list" class="responsive-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Тип</th>
                            <th>Имя</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $i = 1;

                        foreach ($user->getCourseFileList() as $item) {

                            $color = 'grey';
                            $icon = 'file';

                            switch ($item['type']) {
                                case 1:
                                    $color = 'blue';
                                    $icon = 'file-word-box';
                                    break;
                                case 2:
                                    $color = 'green';
                                    $icon = 'file-excel-box';
                                    break;
                                case 3:
                                    $color = 'amber';
                                    $icon = 'file-powerpoint-box';
                                    break;
                                case 4:
                                    $color = 'red';
                                    $icon = 'file-pdf-box';
                                    break;
                            }

                            echo '
                                <tr class="animated opacity-zero">
                                    <td>' . ($i++) . '</td>
                                    <td><i style="font-size: 2rem;" class="mdi mdi-' . $icon . ' ' . $color . '-text"></i></td>
                                    <td>' . htmlspecialchars_decode($item['title']) . '</td>
                                    <td><a ajax-page="file-list-edit-' . $item['id'] . '" class="btn btn-small z-depth-0 blue-text transparent waves-effect">Редактировать</a></td>
                                </tr>
                                ';
                        }

                        ?>

                        </tbody>
                    </table>
                    <table id="video-list" class="responsive-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Тип</th>
                            <th>Имя</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $i = 1;

                        foreach ($user->getCourseVideoList() as $item) {

                            $color = 'grey';
                            $icon = 'file-video';

                            echo '
                                <tr class="animated opacity-zero">
                                    <td>' . ($i++) . '</td>
                                    <td><i style="font-size: 2rem;" class="mdi mdi-' . $icon . ' ' . $color . '-text"></i></td>
                                    <td>' . htmlspecialchars_decode($item['title']) . '</td>
                                    <td><a ajax-page="video-edit-' . $item['id'] . '" class="btn btn-small z-depth-0 blue-text transparent waves-effect">Редактировать</a></td>
                                </tr>
                            ';
                        }

                        ?>

                        </tbody>
                    </table>
                    <table id="article-list" class="responsive-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Тип</th>
                            <th>Имя</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $i = 1;

                        foreach ($user->getCourseArticleList() as $item) {

                            $color = 'grey';
                            $icon = 'file';

                            echo '
                                <tr class="animated opacity-zero">
                                    <td>' . ($i++) . '</td>
                                    <td><i style="font-size: 2rem;" class="mdi mdi-' . $icon . ' ' . $color . '-text"></i></td>
                                    <td>' . htmlspecialchars_decode($item['title']) . '</td>
                                    <td><a href="/create-course-article?edit=' . $item['id'] . '" class="btn btn-small z-depth-0 blue-text transparent waves-effect">Редактировать</a></td>
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
