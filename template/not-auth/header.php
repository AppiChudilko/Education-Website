<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $page;
global $user;

if ($user->isAuthorization())
    header('Location: /news');

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

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/client/css/material.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/client/css/material-appi.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/client/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/client/css/animate.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <style>
        .indicators {
            bottom: -20px !important;
        }
        .tabs .indicator {
            background: #fff;
        }
    </style>

</head>
<body class="white" style="overflow-x: hidden;">

<?php echo ($page['p'] == '/') ? '<div class="wave-bg"></div>' : '' ?>
<nav class="transparent z-depth-0 animated slideInDown" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="/" class="brand-logo black-text hide-on-med-and-down">
            <img src="https://appi-rp.com/images/logoBig.png" class="logo"><div class="left" style="margin-left: 10px;"></div>
        </a>
        <ul class="right hide-on-med-and-down">
            <li><a href="/" class="<?php echo ($page['p'] == '/') ? 'white' : 'black' ?>-text">Реестр сертификатов</a></li>
            <li><a href="/login" class="<?php echo ($page['p'] == '/') ? 'white' : 'black' ?>-text">Вход</a></li>
        </ul>

        <form action="/" style="display: none;" class="right grey lighten-4 search-input hoverable-z1 focusable-z1">
            <div class="input-field">
                <input id="search" placeholder="Search" type="search" name="q" required="" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : ''; ?>">
                <label style="top: -12px;" class="label-icon active" for="search"><i class="search-i material-icons grey-text">search</i></label>
            </div>
        </form>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="black-text material-icons">menu</i></a>
    </div>
</nav>

<ul id="nav-mobile" class="side-nav">
    <li>
        <div class="userView">
            <div class="background">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 810">
                    <path class="fill light-blue lighten-2" fill="#fbfbfc" d="M153.89 0H0v809.5h415.57C345.477 500.938 240.884 211.874 153.89 0z"></path>
                    <path class="fill light-blue lighten-1" fill="#f7f7f7" d="M153.89 0c74.094 180.678 161.088 417.448 228.483 674.517C449.67 506.337 527.063 279.465 592.56 0H153.89z"></path>
                    <path class="fill light-blue" fill="#f6f6f6" d="M545.962 183.777c-53.796 196.576-111.592 361.156-163.49 490.74 11.7 44.494 22.8 89.49 33.1 134.883h404.07c-71.294-258.468-185.586-483.84-273.68-625.623z"></path>
                    <path class="fill light-blue darken-1" fill="#efefee" d="M592.66 0c-15 64.092-30.7 125.285-46.598 183.777C634.056 325.56 748.348 550.932 819.642 809.5h419.672C1184.518 593.727 1083.124 290.064 902.637 0H592.66z"></path>
                    <path class="fill light-blue darken-2" fill="#ebebec" d="M1144.22 501.538c52.596-134.583 101.492-290.964 134.09-463.343 1.2-6.1 2.3-12.298 3.4-18.497 0-.2.1-.4.1-.6 1.1-6.3 2.3-12.7 3.4-19.098H902.536c105.293 169.28 183.688 343.158 241.684 501.638v-.1z"></path>
                    <path class="fill light-blue darken-3" fill="#e7e7e7" d="M1278.31,38.196C1245.81,209.874 1197.22,365.556 1144.82,499.838L1144.82,503.638C1185.82,615.924 1216.41,720.211 1239.11,809.6L1439.7,810L1439.7,256.768C1379.4,158.78 1321.41,86.288 1278.31,38.195L1278.31,38.196z"></path>
                    <path class="fill light-blue darken-4" fill="#e1e1e1" d="M1285.31 0c-2.2 12.798-4.5 25.597-6.9 38.195C1321.507 86.39 1379.603 158.98 1440 257.168V0h-154.69z"></path>
                </svg>
            </div>
            <a href="/"><img class="circle" src="http://read.byappi.com/client/images/logo.png"></a>
            <a href="/"><span class="white-text email">Appi Education</span></a>
        </div>
    </li>
    <li><a href="/" class="black-text">Главная</a></li>
    <li><a href="/login" class="black-text">Войти</a></li>
    <li><a href="/login" class="black-text">Регистрация</a></li>
    <li><a href="/" class="black-text">Реестр сертификатов</a></li>
</ul>
<?php echo ($page['p'] == '/') ? '<div class="wave"></div>' : '' ?>

<main>