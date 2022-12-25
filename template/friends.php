<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $page;
global $server;
global $user;
global $userInfo;
global $filePath;

$userId = isset($page['friends']) ? $page['friends'] : $userInfo['id'];

?>
<ajax-title><?php echo (isset($page['friends']) ? $this->userInfo['name'] . ' ' . $this->userInfo['surname'] . ' | ' : '') . 'Список друзей | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 l8">
                <h5 class="h-title animated opacity-zero" style="display: none">Поиск друзей</h5>
                <div class="card animated opacity-zero" style="display: none">
                    <form method="get">
                        <div class="input-field" style="margin-top: 0">
                            <input id="search" class="search_all" type="search" name="q" required="" style="border: none">
                            <label for="search" class="label-icon"><i class="material-icons">search</i></label>
                        </div>
                    </form>
                </div>
                <h5 class="h-title animated opacity-zero">Друзья</h5>

                <?php

                    $friendList = [];

                    if (isset($page['sort-'])) {
                        switch ($page['sort-']) {
                            case 'online';
                                $friendList = $user->getFriends($userId, 1);
                                break;
                            case 'followers';
                                $friendList = $user->getFriends($userId, 2);
                                break;
                            case 'pending';
                                if (!isset($page['friends']))
                                    $friendList = $user->getFriends($userId, 3);
                                break;
                        }
                    }
                    else
                        $friendList = $user->getFriends($userId);

                    if (!empty($friendList)) {
                        echo '<ul class="card collection animated opacity-zero" style="overflow: visible; border: none">';
                        foreach ($friendList as $item) {
                            echo '
                                <li class="collection-item avatar medium-item">
                                    <img src="' . $filePath . $item['img_avatar'] . '" alt="" class="circle">
                                    <a ajax-page="id' . $item['id'] . '" class="title black-text">' . $item['name'] . ' ' . $item['surname'] . ' <div class="' . ($server->timeStampNow() < $item['last_online'] + 900 ? 'green' : 'red') .  ' online-status" style="margin-left: 8px"></div></a>
                                    <p><a ajax-page="im' . $item['id'] . '">Сообщение</a></p>
                                </li>
                            ';
                        }
                        echo '</ul>';
                    }
                    else {
                        echo '
                            <div class="center animated opacity-zero error404">
                                <div class="img-block" style="width: 530px;">
                                    <img class="left" src="/client/images/stickers/st1.png">
                                    <div class="left margin-left">
                                        <h4 class="grey-text text-darken-2">Список пуст</h4>
                                        <h6 class="grey-text">К сожалению список друзей пуст :(</h6>
                                    </div>
                                </div>
                            </div>
                        ';
                    }

                ?>

            </div>
            <div class="col s12 l1 hide-on-med-and-down"></div>
            <div class="col s12 l3 hide-on-med-and-down">
                <div class="collection animated opacity-zero" id="fixed-block" style="border: none; top: 90px; position: absolute">

                    <?php
                        if (isset($page['friends']))
                            echo '
                                <a ajax-page="friends' . $page['friends'] . '" class="nav-link collection-item">Список друзей</a>
                                <a ajax-page="friends' . $page['friends'] . '/sort-online" class="nav-link collection-item">Онлайн</a>
                                <a ajax-page="friends' . $page['friends'] . '/sort-followers" class="nav-link collection-item">Подписчики</a>
                            ';
                        else
                            echo '
                                <a ajax-page="friends" class="nav-link collection-item">Список друзей</a>
                                <a ajax-page="friends/sort-online" class="nav-link collection-item">Онлайн</a>
                                <a ajax-page="friends/sort-followers" class="nav-link collection-item">Заявки в друзья</a>
                                <a ajax-page="friends/sort-pending" class="nav-link collection-item">Подписки</a>
                            ';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>