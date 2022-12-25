<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $settings;
global $blocks;
global $user;
global $page;
global $userInfo;

$this->userInfo = $user->getInfoById($page['course-list-']);

if ($user->isTeacher() && $this->userInfo['id'] == $userInfo['id'])
    echo $blocks->getCourseListAdd();

?>
<ajax-title><?php echo 'Список курсов | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <h5 class="col s12 animated opacity-zero h-title">
                Список курсов преподавателя
            </h5>

            <?php

            if (!empty($courseList = $user->getCourseList($page['course-list-']))) {
                foreach ($courseList as $item) {
                    echo $blocks->getAnimatedColBlock(
                        $blocks->getCourseBlock(
                            $item['id'],
                            $item['title'],
                            $item['title_desc'],
                            $item['content'],
                            $item['price'],
                            $item['rating'],
                            $item['color'],
                            $item['color_text']
                        ),
                        '12',
                        '4',
                        '4'
                    );
                }
            }
            else {

                if ($this->userInfo['type'] == 1) {
                    if ($this->userInfo['id'] == $userInfo['id'])
                        echo '
                        <div class="col s12">
                            <div class="center animated opacity-zero error404">
                                <div class="img-block" style="width: 530px;">
                                    <img class="left" src="/client/images/stickers/st1.png">
                                    <div class="left margin-left">
                                        <h4 class="grey-text text-darken-2">Список пуст</h4>
                                        <h6 class="grey-text">К сожалению список курсов пуст :(</h6><br>
                                        <a ajax-page="create-course" class="btn light-blue waves-effect">Создать</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    else
                        echo '
                        <div class="col s12">
                            <div class="center animated opacity-zero error404">
                                <div class="img-block" style="width: 530px;">
                                    <img class="left" src="/client/images/stickers/st1.png">
                                    <div class="left margin-left">
                                        <h4 class="grey-text text-darken-2">Список пуст</h4>
                                        <h6 class="grey-text">К сожалению список курсов пуст :(</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                }
                else
                    echo '<h4 class="col s12 animated opacity-zero center grey-text" style="margin: 200px 0;">Этот пользователь не является преподавателем</h4>';
            }

            ?>
        </div>
    </div>
</div>