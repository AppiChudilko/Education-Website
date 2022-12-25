<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $blocks;
global $settings;
global $userInfo;
global $monthN;
global $server;
global $qb;
global $user;
global $utcOffset;
global $filePath;

$qm = new \Server\QueryMethods($qb, $server);
$course = new \Server\Course($qb, $server);

$isThisUser = $userInfo['id'] == $this->userInfo['id'];

/*$sexOnline = ($this->userInfo['sex'] == 2) ? 'Была' : 'Был';
$lastOnline = $this->userInfo['last_online'] + $utcOffset;

if (gmdate('Y', $lastOnline) == gmdate('Y', $server->timeStampNow() + $utcOffset))
    $dateOnline = gmdate('d', $lastOnline) . ' ' . $monthN[gmdate('m', $lastOnline)] . ' ' . gmdate('H:i', $lastOnline);
else
    $dateOnline = gmdate('d', $lastOnline) . ' ' . $monthN[gmdate('m', $lastOnline)] . ' ' . gmdate('Y, H:i', $lastOnline);

if ($server->timeStampNow() < $this->userInfo['last_online'] + 900)
    $status = '<div class="green online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Онлайн"></div>';
else if($this->userInfo['last_online'] + 90 * 24 * 3600 < $server->timeStampNow())
    $status = '<div class="red online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="' . $sexOnline . ' в сети очень давно"></div>';
else
    $status = '<div class="red online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="' . $sexOnline . ' в сети ' . $dateOnline . '"></div>';*/

$status = $blocks->getOnlineStatusBlock($this->userInfo['last_online'], $this->userInfo['sex']);

if($isThisUser) {
    echo $blocks->getBlogPostSend() . $blocks->getProfileEdit();
    echo '
        <ul id="profile-menu" class="dropdown-content z-depth-3 profile-menu">
            <li><a class="black-text" ajax-page="settings">Настройки</a></li>
            <li><a class="black-text modal-trigger" href="#info-profile">Информация</a></li>
            <li><a class="black-text" ajax-page="friends">Список друзей</a></li>
            <li class="divider"></li>
            <li><a class="black-text">Закрыть</a></li>
        </ul>
    ';
}
else {

    $friendStatus = $user->getFriendStatus($this->userInfo['id']);

    $friendStatusHtml = '<a onclick="$.friendSendRequest(' . $this->userInfo['id'] . ')" class="black-text">Добавить в друзья</a>';

    if (!empty($friendStatus)) {

        if ($friendStatus['id_from'] == $userInfo['id'] && $friendStatus['status'] == 0)
            $friendStatusHtml = '<a onclick="$.friendUnSendRequest(' . $this->userInfo['id'] . ')" class="black-text">Отписаться</a>';
        else if ($friendStatus['id_to'] == $userInfo['id'] && $friendStatus['status'] == 0)
            $friendStatusHtml = '<a onclick="$.friendAcceptRequest(' . $this->userInfo['id'] . ')" class="black-text">Принять запрос</a>';
        else if (($friendStatus['id_to'] == $userInfo['id'] || $friendStatus['id_from'] == $userInfo['id']) && $friendStatus['status'] == 1)
            $friendStatusHtml = '<a onclick="$.friendDeleteRequest(' . $this->userInfo['id'] . ')" class="black-text">Удалить из друзей</a>';
    }

    $blackListBtn = '<li id="blacklist-button"><a class="red-text" onclick="$.userAddBlackList(' . $this->userInfo['id'] . ')">Заблокировать</a></li>';
    if ($user->isBlackList($userInfo['id'], $this->userInfo['id']))
        $blackListBtn = '<li id="blacklist-button"><a class="green-text" onclick="$.userRemoveBlackList(' . $this->userInfo['id'] . ')">Разблокировать</a></li>';

    echo '
        <ul id="profile-menu" class="dropdown-content z-depth-3 profile-menu">
            <li id="friend-action">' . $friendStatusHtml . '</li>
            <li><a class="black-text modal-trigger" href="#info-profile">Информация</a></li>
            <li class="divider"></li>
            <li><a class="amber-text">Пожаловаться</a></li>
            ' . $blackListBtn . '
        </ul>
    ';
}

echo $blocks->getProfileInfo($this->userInfo);

if (rand(0, 1) == 1)
    echo '
    <!--

                                        .do-"""""\'-o..
                                     .o""            ""..
                                   ,,\'\'                 ``b.
                                  d\'                      ``b
                                 d`d:                       `b.
                                ,,dP                         `Y.
                               d`88                           `8.
         ooooooooooooooooood888`88\'       HELLO WORLD          `88888888888bo,
        d"""    `""""""""""""Y:d8P                              8,          `b
        8                    P,88b                             ,`8           8
        8                   ::d888,                           ,8:8.          8
        :                   dY88888                           `\' ::          8
        :                   8:8888                               `b          8
        :                   Pd88P\',...                     ,d888o.8          8
        :                   :88\'dd888888o.                d8888`88:          8
        :                  ,:Y:d8888888888b             ,d88888:88:          8
        :                  :::b88d888888888b.          ,d888888bY8b          8
                            b:P8;888888888888.        ,88888888888P          8
                            8:b88888888888888:        888888888888\'          8
                            8:8.8888888888888:        Y8888888888P           8
        ,                   YP88d8888888888P\'          ""888888"Y            8
        :                   :bY8888P"""""\'\'                     :            8
        :                    8\'8888\'                            d            8
        :                    :bY888,                           ,P            8
        :                     Y,8888           d.  ,-         ,8\'            8
        :                     `8)888:           \'            ,P\'             8
        :                      `88888.          ,...        ,P               8
        :                       `Y8888,       ,888888o     ,P                8
        :                         Y888b      ,88888888    ,P\'                8
        :                          `888b    ,888888888   ,,\'                 8
        :                           `Y88b  dPY888888OP   :\'                  8
        :                             :88.,\'.   `\' `8P-"b.                   8
        :.                             )8P,   ,b \'  -   ``b                  8
        ::                            :\':   d,\'d`b, .  - ,db                 8
        ::                            `b. dP\' d8\':      d88\'                 8
        ::                             \'8P" d8P\' 8 -  d88P\'                  8
        ::                            d,\' ,d8\'  \'\'  dd88\'                    8
        ::                           d\'   8P\'  d\' dd88\'8                     8
         :                          ,:   `\'   d:ddO8P\' `b.                   8
         :                  ,dooood88: ,    ,d8888""    ```b.                8
         :               .o8"\'""""""Y8.b    8 `"\'\'    .o\'  `"""ob.           8
         :              dP\'         `8:     K       dP\'\'        "`Yo.        8
         :             dP            88     8b.   ,d\'              ``b       8
         :             8.            8P     8""\'  `"                 :.      8
         :            :8:           :8\'    ,:                        ::      8
         :            :8:           d:    d\'                         ::      8
         :            :8:          dP   ,,\'                          ::      8
         :            `8:     :b  dP   ,,                            ::      8
         :            ,8b     :8 dP   ,,                             d       8
         :            :8P     :8dP    d\'                       d     8       8
         :            :8:     d8P    d\'                      d88    :P       8
         :            d8\'    ,88\'   ,P                     ,d888    d\'       8
         :            88     dP\'   ,P                      d8888b   8        8
         \'           ,8:   ,dP\'    8.                     d8\'\'88\'  :8        8
                     :8   d8P\'    d88b                   d"\'  88   :8        8
                     d: ,d8P\'    ,8P""".                      88   :P        8
                     8 ,88P\'     d\'                           88   ::        8
                    ,8 d8P       8                            88   ::        8
                    d: 8P       ,:  -hrr-                    :88   ::        8
                    8\',8:,d     d\'                           :8:   ::        8
                   ,8,8P\'8\'    ,8                            :8\'   ::        8
                   :8`\' d\'     d\'                            :8    ::        8
                   `8  ,P     :8                             :8:   ::        8
                    8, `      d8.                            :8:   8:        8
                    :8       d88:                            d8:   8         8
         ,          `8,     d8888                            88b   8         8
         :           88   ,d::888                            888   Y:        8
         :           YK,oo8P :888                            888.  `b        8
         :           `8888P  :888:                          ,888:   Y,       8
         :            ``\'"   `888b                          :888:   `b       8
         :                    8888                           888:    ::      8
         :                    8888:                          888b     Y.     8,
         :                    8888b                          :888     `b     8:
         :                    88888.                         `888,     Y     8:
         ``ob...............--"""""\'----------------------`""""""""\'"""`\'"""""
        
        -->
    ';

?>



<ajax-title><?php echo $this->userInfo['name'] . ' ' . $this->userInfo['surname'] . ' | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 animated opacity-zero">
                <div class="card small profile-card" style="z-index: 1">
                    <div class="card-image">
                        <img src="<?php echo $filePath . $this->userInfo['img_wallpaper']; ?>">
                        <div class="card-title-gradient">
                            <?php echo $status; ?>
                            <span class="card-title valign-wrapper">
                                <img style="height: 70px !important; cursor: pointer" class="profile-ava modal-trigger" href="#avatar" src="<?php echo $filePath . $this->userInfo['img_avatar']; ?>">
                                <div class="left">
                                    <b><?php echo $this->userInfo['name'] . ' ' . $this->userInfo['surname'] ?></b><br>
                                    <label class="grey-text"><?php echo htmlspecialchars_decode($this->userInfo['status']) ?></label>
                                </div>
                                <div class="right hide-on-small-and-down">
                                    <a class="white-text dropdown-btn" data-activates="profile-menu">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <?php
                                        if($this->userInfo['id'] == $userInfo['id'])
                                            echo '<a href="#edit-profile" style="min-width: 254px" class="waves-effect btn white black-text modal-trigger">Изменить профиль</a>';
                                        else
                                            echo '<a ajax-page="im' . $this->userInfo['id'] . '" style="min-width: 254px" class="waves-effect btn white black-text">Отправить сообщение</a>';
                                    ?>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>

                <?php

                    if ($this->userInfo['type'] == 1) {

                        $ratingCourse = 0;
                        foreach ($user->getCourseList($this->userInfo['id']) as $item) //TODO оптимизировать запрос, если рейтинг не равно ноль
                            $ratingCourse += $course->getRating($item['id']);

                        echo '
                            <div class="row grey-text center profile-info">
                                <div class="col s6 m4 l2">
                                    <h5><a class="grey-text" ajax-page="friends' . $this->userInfo['id'] . '">' . number_format($user->getCountFriends($this->userInfo['id'])) . '</a></h5>
                                    <label>Друзей</label>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h5><a class="grey-text" ajax-page="friends' . $this->userInfo['id'] . '/sort-followers">' . number_format($user->getCountFollowers($this->userInfo['id'])) . '</a></h5>
                                    <label>Подписчики</label>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h5>' . number_format($this->userInfo['rating'] + $ratingCourse) . '</h5>
                                    <label>Репутация</label>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h5>0</h5>
                                    <label>Жалоб</label>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h5>' . $user->getCourseCount($this->userInfo['id']) . '</h5>
                                    <label>Курсов</label>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h5>' . ($this->userInfo['verify'] == true ? '<i class="mdi mdi-check green-text"></i>' : '<i class="mdi mdi-close red-text"></i>') . '</h5>
                                    <label>Верификация</label>
                                </div>
                            </div>
                        ';

                        echo '
                            <hr class="hide">
                            <div class="card z-depth-0 transparent hide">
                                <div class="videos">
                                    <label class="col s12 animated opacity-zero">
                                        <a href="#" class="grey-text">Трансляции</a>
                                        <a href="#" class="right blue-text">Весь список</a>
                                    </label>
                        ';

                        echo $blocks->getAnimatedColBlock(
                            $blocks->getBroadcastBlock(
                                'id',
                                'Learn about Places and the Google Maps Places API over Coffee with Fontaine Foxworth',
                                'https://pp.userapi.com/c638526/v638526859/363b8/Zc3vi7GoDVs.jpg',
                                199,
                                0,
                                'Александр Пожаров',
                                '3ч'
                            ),
                            '12',
                            '4',
                            '4'
                        );

                        echo $blocks->getAnimatedColBlock(
                            $blocks->getBroadcastBlock(
                                'id',
                                'The Developer Show (TL;DR 069)',
                                'https://pp.userapi.com/c638526/v638526859/3589c/m9YkK3eTt5Q.jpg',
                                0,
                                0,
                                'Александр Пожаров',
                                '4ч'
                            ),
                            '12',
                            '4',
                            '4'
                        );

                        echo $blocks->getAnimatedColBlock($blocks->getBroadcastNoneBlock($this->userInfo['id'] == $userInfo['id']), '12', '4', '4');

                        echo '
                        </div></div>
                    </div>
                    <div class="col s12">
                        <div class="row">
                            
                        ';

                        $courseList = $user->getCourseList($this->userInfo['id'], 3);
                        $courseListCount = count($courseList);

                        if($courseListCount > 0) {

                            echo '
                                <label class="col s12 animated opacity-zero">
                                    <hr>
                                    <a ajax-page="course-list-' . $this->userInfo['id'] . '" class="grey-text">Курсы</a>
                                    <a ajax-page="course-list-' . $this->userInfo['id'] . '" class="right blue-text">Весь список</a>
                                </label>
                            ';

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

                            for($i = 0; $i < 3 - $courseListCount; $i++)
                                echo $blocks->getAnimatedColBlock(
                                    $blocks->getCourseNoneBlock($this->userInfo['id'] == $userInfo['id'] && $user->isTeacher()),
                                    '12',
                                    '4',
                                    '4'
                                );
                        }

                        echo '</div>';
                    }
                    else {
                        echo '
                            <div class="row grey-text center profile-info">
                                <div class="col s6 m4">
                                    <h5><a class="grey-text" ajax-page="friends' . $this->userInfo['id'] . '">' . number_format($user->getCountFriends($this->userInfo['id'])) . '</a></h5>
                                    <label>Друзей</label>
                                </div>
                                <div class="col s6 m4">
                                    <h5><a class="grey-text" ajax-page="friends' . $this->userInfo['id'] . '/sort-followers">' . number_format($user->getCountFollowers($this->userInfo['id'])) . '</a></h5>
                                    <label>Подписчики</label>
                                </div>
                                <div class="col s12 m4">
                                    <h5>' . ($this->userInfo['verify'] == true ? '<i class="mdi mdi-check green-text"></i>' : '<i class="mdi mdi-close red-text"></i>') . '</h5>
                                    <label>Верификация</label>
                                </div>
                            </div>
                        ';
                    }

                ?>

            </div>

            <?php

            if($isThisUser) {
                echo '
                    <div class="col s12 m8 l5">
                        <a href="#new-post" class="modal-trigger z-depth-1">
                            <ul class="collection card card-new-post animated opacity-zero">
                                <li class="collection-item avatar">
                                    <img src="' . $filePath . $userInfo['img_avatar'] . '" alt="' . $userInfo['name'] . ' ' . $userInfo['surname'] . '" class="circle">
                                    <span class="title grey-text left">Что у Вас нового?</span>
                                    <span class="title grey-text grey lighten-4 btn btn-floating btn-flat right waves-effect" style="margin-top: 3px;"><i class="material-icons grey-text text-darken-2">edit</i></span>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div class="col s12 m4 l7 hide-on-med-and-down">
                        <ul class="collection card z-depth-0 transparent card-new-post animated opacity-zero">
                            <li class="collection-item transparent avatar">
                                <img src="/client/images/stickers/st2.png" alt="Appi Education Sticker" style="border-radius: 0" class="circle">
                                <span class="title grey-text left" style="margin-top: 0;">Это Ваш личный блог и он полностью в вашем распоряжении <i class="material-icons red-text" style="font-size: 1rem">favorite</i></span>
                            </li>
                        </ul>
                    </div>
                ';
            }

            ?>
            <div class="col s12" id="blog-posts">

                <?php

                if (!empty($allPost = $qm->getAllBlogPostByUser($this->userInfo['id']))) {
                    foreach ($allPost as $item) {

                        $item['timestamp'] = $item['timestamp'] + $utcOffset;
                        $dateTime = gmdate('d', $item['timestamp']) . ' ' . $monthN[gmdate('m', $item['timestamp'])] . ' ' . gmdate('Y, H:i', $item['timestamp']);
                        $attaches = json_decode(htmlspecialchars_decode($item['attaches']), true);
                        $image = isset($attaches['images']) ? '/upload/news/' . reset($attaches['images']) : '';

                        echo $blocks->getBlogPost(
                            $item['id'],
                            'id' . $item['user_id'],
                            $this->userInfo['name'] . ' ' . $this->userInfo['surname'],
                            $this->userInfo['img_avatar'],
                            $dateTime,
                            $item['content'],
                            $image,
                            $isThisUser
                        );
                    }
                }
                else {
                    echo '<h5 class="grey-text center animated opacity-zero" style="margin: 50px 0">Нет публикаций в блоге</h5>';
                }
                ?>

            </div>
        </div>
    </div>
</div>

<div id="avatar" class="modal modal-fixed-footer modal-full-height" style="width: 90%;">
    <div class="modal-content grey darken-4" style="padding: 0px; overflow: hidden">
        <img style="width: 100%; height: 100%; object-fit: contain;" src="<?php echo $filePath . $this->userInfo['img_avatar'] ?>">
    </div>
    <div class="modal-footer grey darken-4">
        <a class="modal-action modal-close waves-effect btn-flat white-text">Закрыть</a>
    </div>
</div>