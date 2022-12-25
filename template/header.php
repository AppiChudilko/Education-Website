<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $blocks;
global $page;
global $user;
global $userInfo;
global $filePath;

if (!$user->isAuthorization())
    header('Location: /login');

$user->updateOnline();
$countFriendsRequest = $user->friendCountSendRequest();

$friendBadge = '';
if ($countFriendsRequest > 0)
    $friendBadge = '<span class="new badge light-blue white-text">' . $countFriendsRequest . '</span>';

/*
<ul id="notif-menu" class="dropdown-content z-depth-5 collection">
    <li style="position: fixed;" id="notif-more-btn" class="white z-depth-2">
        <a class="blue-text" ajax-page="notifications"><i class="material-icons">more_vert</i>Показать больше</a>
        <div class="divider"></div>
    </li>
    <li><a class="grey-text text-darken-3" href="#">empty</a></li>
    <li><a class="grey-text text-darken-3" href="#">УведомлениеУведомлениеУведомлениеУведомлениеУведомление</a></li>
    <li><a class="grey-text text-darken-3" href="#">Уведомление</a></li>
    <li><a class="grey-text text-darken-3" href="#">Уведомление</a></li>
    <li><a class="grey-text text-darken-3" href="#">Уведомление</a></li>
    <li><a class="grey-text text-darken-3" href="#">Уведомление</a></li>
    <li><a class="grey-text text-darken-3" href="#">Уведомление</a></li>
</ul>

<div class="nav-content" id="friend-tab" style="padding: 0 1rem; <?php echo ($page['p'] != 'friends') ? 'display:none;' : '' ?>">
    <ul class="tabs tabs-transparent">
        <li class="tab right"><a class="black-text" href="#test4">Заявки</a></li>
        <li class="tab right"><a class="black-text" href="#test3">Подписки</a></li>
        <li class="tab right"><a class="black-text" href="#test2">Онлайн</a></li>
        <li class="tab right"><a class="black-text active" href="#test1">Список друзей</a></li>
    </ul>
</div>
 * */


?>
<!--

Фея Винкс всегда на страже вашей страницы

``````````{\
````````{\{*\
````````{*\~\__&&&
```````{```\`&&&&&&.
``````{~`*`\((((((^^^)
`````{`*`~((((((( ♛ ♛
````{`*`~`)))))))). _' )
````{*```*`((((((('\ ~
`````{~`*``*)))))`.&
``````{.*~``*((((`\`\)) ?
````````{``~* ))) `\_.-'``
``````````{.__ ((`-*.*
````````````.*```~``*.
``````````.*.``*```~`*.
`````````.*````.````.`*.
````````.*``~`````*````*.
```````.*``````*`````~``*.
`````.*````~``````.`````*.
```.*```*```.``~```*``~ *.¤´҉ .

-->
<!DOCTYPE html>
<html lang="<?php echo $this->langType ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title><?php echo $this->titleHtml; ?></title>

    <meta property="og:title" content="<?php echo $this->titleHtml; ?>" />
    <meta property="og:description" content="Desc" />
    <meta property="og:site_name" content="<?php echo $this->title; ?>">
    <meta property="og:type" content="top">
    <meta property="og:url" content="<?php echo $this->siteName ?>">
    <meta property="og:image" content="/client/images/logo/Logo-500-500.png">

    <meta name="description" content="Test">
    <meta name="keywords" content="Key" />
    <meta name="generator" content="Appi <?php echo $this->version ?>">
    <meta name="theme-color" content="#ffffff">

    <link rel="shortcut icon" href="https://appi-rp.com/images/logoBig.png" type="image/x-icon" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/client/css/material.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/client/css/material-appi.css?v=11" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/client/css/style.css?v=11" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/client/css/animate.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <!-- Icons -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">

</head>
<body class="grey lighten-4">

<ul id="nav-mobile" class="side-nav">
    <li>
        <div class="userView" style="min-height: 100px;">
            <div class="background">
                <img src="<?php echo $filePath . $userInfo['img_wallpaper'] ?>" style="width: 100%;">
            </div>
            <a ajax-page="id<?php echo $userInfo['id'] ?>"><img style="object-fit: cover" class="circle" src="<?php echo $filePath . $userInfo['img_avatar'] ?>"></a>
        </div>
    </li>
    <li><a ajax-page="id<?php echo $userInfo['id'] ?>" class="grey-text text-darken-3 waves-effect collection-item"><i class="mdi mdi-account" style="font-size: 1.5rem;"></i>Мой профиль</a></li>
    <li><a ajax-page="news" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-newspaper" style="font-size: 1.5rem;"></i>Новости</a></li>
    <li><a ajax-page="im" class="grey-text text-darken-3 waves-effect collection-item"><i class="mdi mdi-email" style="font-size: 1.5rem;"></i>Сообщения</a></li>
    <li><a ajax-page="friends" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-account-multiple" style="font-size: 1.5rem;"></i><?php echo $friendBadge; ?>Друзья</a></li>
    <li><a ajax-page="notifications" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-bell" style="font-size: 1.5rem;"></i>Уведомления</a></li>
    <li><a ajax-page="trending" class="grey-text text-darken-3 waves-effect"><i class="mdi material-icons" style="font-size: 1.5rem;">ondemand_video</i>Обучение</a></li>
    <li><a ajax-page="rating" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-chart-areaspline" style="font-size: 1.5rem;"></i>Преподаватели</a></li>
    <li><a ajax-page="favorite" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-star" style="font-size: 1.5rem;"></i>Избранное</a></li>
    <li><a ajax-page="orders" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-cash" style="font-size: 1.5rem;"></i>Мои покупки</a></li>
    <li><a ajax-page="myedu" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-book-open-page-variant" style="font-size: 1.5rem;"></i>Моё обучение</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-help-box" style="font-size: 1.5rem;"></i>Помощь</a></li>
    <li><a ajax-page="regcrt" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-content-paste" style="font-size: 1.5rem;"></i>Реестр сертификатов</a></li>
    <li><a ajax-page="settings" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-settings" style="font-size: 1.5rem;"></i>Настройки</a></li>
    <li><div class="divider"></div></li>
    <li><a href="/logout" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-logout" style="font-size: 1.5rem;"></i>Выход</a></li>
</ul>

<div class="navbar-fixed">
    <nav class="white z-depth-3 animated slideInDown" role="navigation" style="height: auto;">
        <div class="nav-wrapper" style="padding: 0 1rem;">
            <a id="logo-container" href="/" class="brand-logo black-text hide-on-med-and-down">
                <img src="https://appi-rp.com/images/logoBig.png" class="logo"><div class="left" style="margin-left: 10px;"></div>
            </a>
            <ul class="right hide-on-med-and-down">
                <?php
                    if ($user->isTeacher())
                        echo '
                            <li>
                                <a href="" data-activates="main-menu-upload" class="dropdown-button btn-floating z-depth-0 white waves-effect" style="padding: 0;margin: 0;"><i style="margin-top: -3px;" class="material-icons mdi mdi-plus-circle grey-text text-darken-2"></i></a>
                            </li>
                            <li>
                                <a ajax-page="balance-stats" class="btn-floating z-depth-0 white waves-effect tooltipped" data-position="left" data-delay="50" data-tooltip="Заработок" style="padding: 0;margin: 0;"><i style="margin-top: -3px;" class="material-icons mdi mdi-cash-usd grey-text text-darken-2"></i></a>
                            </li>
                        ';
                ?>
                <li>
                    <a ajax-page="settings" class="btn-floating z-depth-0 white waves-effect tooltipped" data-position="left" data-delay="50" data-tooltip="Баланс: <?php echo number_format($userInfo['balance']) ?> ₽" style="padding: 0;margin: 0;"><i style="margin-top: -3px;" class="material-icons mdi mdi-wallet grey-text text-darken-2"></i></a>
                </li>
                <li>
                    <a href="#" data-activates="notif-menu" class="dropdown-button-notif btn-floating z-depth-0 white waves-effect" style="padding: 0;margin: 0;"><i class="material-icons grey-text text-darken-2">notifications</i></a>
                </li>
                <li>
                    <a class="grey-text text-darken-4 dropdown-button waves-effect" href="" data-activates="main-menu">
                        <div class="left user-name grey-text text-darken-2"><?php echo $userInfo['name'] ?></div>
                        <i class="material-icons right grey-text text-darken-2" style="margin-left: -5px;">arrow_drop_down</i>
                        <img src="<?php echo $filePath . $userInfo['img_avatar'] ?>" class="avatar right">
                    </a>
                </li>
            </ul>

            <form action="/" class="left right-search grey lighten-4 search-input hoverable-z1 focusable-z1">
                <div class="input-field">
                    <input id="search" placeholder="Поиск по сайту" type="search" name="q" required="" style="line-height: 24px" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : ''; ?>">
                    <label style="top: -12px;" class="label-icon active" for="search"><i class="search-i material-icons grey-text">search</i></label>
                </div>
            </form>

            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="black-text material-icons">menu</i></a>
        </div>
    </nav>
</div>

<ul id="notif-menu1" class="dropdown-content z-depth-5 collection notification">

    <li class="collection-item avatar">
        <i class="material-icons circle">folder</i>
        <span class="title no-pad">Title</span>
        <p>First Line <br>
            Second Line
        </p>
    </li>

</ul>

<div id="notif-menu" class="dropdown-content z-depth-5 collection">
    <div class="card-panel z-depth-0 transparent" style="margin: 0">
        <h5 class="grey-text">Уведомлений нет</h5>
    </div>
</div>

<ul id="main-menu" class="dropdown-content z-depth-5">
    <li><a class="black-text" ajax-page="id<?php echo $userInfo['id'] ?>">Мой профиль</a></li>
    <li><a class="black-text" ajax-page="notifications">Уведомления</a></li>
    <li><a class="black-text" ajax-page="settings">Настройки</a></li>
    <?php echo ($user->isTeacher() ? '<li><a class="black-text" ajax-page="course-attaches">Список файлов</a></li>' : '') ?>
    <li class="divider"></li>
    <li><a class="black-text" href="/logout">Выход</a></li>
</ul>

<ul id="main-menu-upload" class="dropdown-content z-depth-5" style="min-width: 260px">
    <li><a class="black-text" ajax-page="create-course"><i class="material-icons">library_books</i>Создать курс</a></li>
    <li class="hide"><a class="black-text" ajax-page="create-broadcast"><i class="material-icons">live_tv</i>Создать трансляцию</a></li>
    <li><a class="black-text" ajax-page="upload-video"><i class="material-icons">videocam</i>Добавить видео</a></li>
    <li><a class="black-text" ajax-page="create-course-article"><i class="material-icons">mode_edit</i>Написать статью</a></li>
    <li><a class="black-text" ajax-page="upload-file"><i class="material-icons">insert_drive_file</i>Загрузить файл</a></li>
</ul>

<ul class="side-nav grey lighten-4 left-menu z-depth-0 hide-on-med-and-down animated slideInLeft <?php echo ($page['p'] == 'broadcast-id' || (isset($page['broadcast-']) && !isset($page['broadcast-cat-']))) ? 'slide-nav-small' : '' ?>">
    <li><a ajax-page="id<?php echo $userInfo['id'] ?>" class="grey-text text-darken-3 waves-effect collection-item"><i class="mdi mdi-account" style="font-size: 1.5rem;"></i>Мой профиль</a></li>
    <li><a ajax-page="news" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-newspaper" style="font-size: 1.5rem;"></i>Новости</a></li>
    <li><a ajax-page="im" class="grey-text text-darken-3 waves-effect collection-item"><i class="mdi mdi-email" style="font-size: 1.5rem;"></i>Сообщения</a></li>
    <li><a ajax-page="friends" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-account-multiple" style="font-size: 1.5rem;"></i><?php echo $friendBadge; ?>Друзья</a></li>
    <li><a ajax-page="trending" class="grey-text text-darken-3 waves-effect"><i class="mdi material-icons" style="font-size: 1.5rem;">ondemand_video</i>Обучение</a></li>
    <li><a ajax-page="rating" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-chart-areaspline" style="font-size: 1.5rem;"></i>Преподаватели</a></li>
    <li><a ajax-page="favorite" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-star" style="font-size: 1.5rem;"></i>Избранное</a></li>
    <li><a ajax-page="orders" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-cash" style="font-size: 1.5rem;"></i>Мои покупки</a></li>
    <li><a ajax-page="myedu" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-book-open-page-variant" style="font-size: 1.5rem;"></i>Моё обучение</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-help-box" style="font-size: 1.5rem;"></i>Помощь</a></li>
    <li><a ajax-page="regcrt" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-content-paste" style="font-size: 1.5rem;"></i>Реестр сертификатов</a></li>
    <li><a ajax-page="settings" class="grey-text text-darken-3 waves-effect"><i class="mdi mdi-settings" style="font-size: 1.5rem;"></i>Настройки</a></li>
</ul>

<div class="right-content container center animated fadeOut" id="preloader">
    <div class="preloader-wrapper active">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>

<main class="animated" style="display: flow-root;">