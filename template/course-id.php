<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $settings;
global $blocks;
global $user;
global $userInfo;
global $page;
global $filePath;

$isFree = $this->course['price'] < 1;

?>
<ajax-title><?php echo htmlspecialchars_decode($this->course['title']) . ' | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <h5 class="col s12 m9 animated opacity-zero h-title">
                <?php echo htmlspecialchars_decode($this->course['title_desc']) . ' <label title="Рейтинг курса" class="' . ($this->course['rating'] >= 0 ? 'green' : 'red') . '-text"><i class="mdi mdi-star"></i>' . number_format($this->course['rating']) . '</label>'; ?>
                <br>
                <p style="line-height: 16px; font-size: 0.8rem;"><?php echo htmlspecialchars_decode(nl2br($this->course['content'])); ?></p>
            </h5>

            <?php

            if ($user->isTeacher() && $this->course['owner_id'] == $userInfo['id'])
                echo '
                    <h5 class="col s12 m3 animated opacity-zero right-align">
                        <a href="#delete-course" class="btn btn-small waves-effect red right modal-trigger"><i class="material-icons">delete</i></a>
                        <a href="/create-course?edit=' . $page['course-'] . '" class="btn btn-small waves-effect green right" style="margin-right: 16px;"><i class="material-icons">mode_edit</i></a>
                    </h5>
                    <div id="delete-course" class="modal">
                        <div class="modal-content">
                            <h5>Вы точно хотите удалить этот курс?</h5>
                            <p>Внимание, курс удалится навсегда!</p>
                        </div>
                        <form action="/course-list-' . $userInfo['id'] . '" method="post" class="modal-footer">
                            <a class="modal-action modal-close waves-effect btn-flat">Отмена</a>
                            <input type="hidden" name="id" value="' . $page['course-'] . '">
                            <button name="user-course-delete" class="modal-action waves-effect btn-flat red lighten-4">Удалить</button>
                        </form>
                    </div>
                ';
            else {
                echo '
                    <h5 class="col s12 m3 animated opacity-zero right-align">
                        ' . ($isFree ? '<button class="btn green disabled" style="width: 100%">Бесплатный курс</button><br><br>' : '<button class="btn green waves-effect" style="width: 100%">Купить ' . number_format($this->course['price']) . ' ₽</button><br><br>') . '
                        <a onclick="$.courseDisLike(' . $this->course['id'] . ');" class="btn btn-floating waves-effect red right modal-trigger"><i class="material-icons">thumb_down</i></a>
                        <a onclick="$.courseLike(' . $this->course['id'] . ');" class="btn btn-floating waves-effect green right" style="margin-right: 16px;"><i class="material-icons">thumb_up</i></a>
                    </h5>
                ';

            }

            echo '<div class="col s12">';

            if (!empty($courseFiles = $user->getCourseFileListByCourseId($page['course-']))) {

                echo '
                <hr class="animated opacity-zero">
                    <div class="row">
                        <h5 class="col s12 animated opacity-zero h-title">
                            Файлы
                            ' . (($user->isTeacher() && $this->course['owner_id'] == $userInfo['id']) ? '<a ajax-page="upload-file" class="btn btn-small waves-effect light-blue right"><i class="material-icons">file_upload</i></a>' : '') . '
                        </h5>
                    ';

                foreach ($courseFiles as $item) {
                    echo $blocks->getAnimatedColBlock(
                        $blocks->getFileBlock($item['title'], $filePath . $item['path'], $item['type']),
                        '6',
                        '4',
                        '2'
                    );
                }


                echo '</div>';
            }

            if (!empty($courseArticles = $user->getCourseArticleListByCourseId($page['course-']))) {

                echo '
                    <hr class="animated opacity-zero">
                        <div class="row">
                            <h5 class="col s12 animated opacity-zero h-title">
                                Статьи
                                ' . (($user->isTeacher() && $this->course['owner_id'] == $userInfo['id']) ? '<a ajax-page="create-course-article" class="btn btn-small waves-effect light-blue right"><i class="material-icons">add</i></a>' : '') . '
                            </h5>
                ';


                foreach ($courseArticles as $item) {
                    echo $blocks->getAnimatedColBlock(
                        $blocks->getCourseArticleBlock(
                            $item['id'],
                            $filePath . $item['img'],
                            $item['title'],
                            substr(htmlspecialchars_decode($item['content']), 0, 100)
                        ),
                        '6',
                        '3',
                        '3'
                    );
                }

                echo '</div>';
            }

            ?>

            </div>
        </div>
        <?php


            if (!empty($courseFiles = $user->getCourseVideoListByCourseId($page['course-']))) {


                echo '
                <div class="row">
                    <div class="col s12 videos">
                        <hr class="animated opacity-zero">
                        <h5 class="col s12 animated opacity-zero h-title">
                            Видео
                            ' . (($user->isTeacher() && $this->course['owner_id'] == $userInfo['id']) ? '<a ajax-page="upload-video" class="btn btn-small waves-effect light-blue right"><i class="material-icons">add</i></a>' : '') . '
                        </h5>
                ';

                foreach ($courseFiles as $item) {

                    $author = $user->getInfoById($item['owner_id']);

                    echo $blocks->getAnimatedColBlock(
                        $blocks->getVideoBlock(
                            $item['id'],
                            $item['title'],
                            $filePath . $item['path_img'],
                            0,
                            $item['views'],
                            $author['name'] . ' ' . $author['surname']
                        ),
                        '12',
                        '6',
                        '4'
                    );
                }


                echo '<div class="col s12 animated opacity-zero" style="margin-top: 32px">
                            <button class="btn btn-large grey lighten-2 grey-text z-depth-0 waves-effect" style="width: 100%;">Показать больше</button>
                        </div>
                    </div>
                </div>';
            }


        ?>
    </div>
</div>