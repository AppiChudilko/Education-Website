<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $settings;
global $blocks;
?>
<ajax-title><?php echo 'Трансляции | ' . $settings->getTitle(); ?></ajax-title>
<a href="#" class="z-depth-4 btn-floating btn-large waves-effect light-blue lighten-1 profile-new-post modal-trigger animated opacity-zero"><i class="material-icons white-text">add</i></a>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 videos">
                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-list" class="h-title">Категории</a>
                    <a ajax-page="broadcast-cat-list" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small teal right">Ещё</a>
                </h5>
                <?php

                echo $blocks->getAnimatedColBlock(
                        $blocks->getBroadcastCategoryBlock(
                        'id',
                        'Языки',
                        'http://creativecrunk.com/wp-content/uploads/2014/11/Mobile-Flagships.jpg',
                        134000
                        ),
                        '12',
                        '6',
                        '4'
                    );

                echo $blocks->getAnimatedColBlock(
                        $blocks->getBroadcastCategoryBlock(
                        'id',
                        'IT направление',
                        'http://icloudpicture.com/wp-content/uploads/2016/01/Computer-Flat-HD-Wallpaper.png',
                        52000
                        ),
                        '12',
                        '6',
                        '4'
                    );

                echo $blocks->getAnimatedColBlock(
                        $blocks->getBroadcastCategoryBlock(
                        'id',
                        'Бизнес',
                        'http://www.lvtc.ca/files/2014/01/photodune-6462660-business-meeting-flat-illustration-m.jpg',
                        34000
                        ),
                        '12',
                        '6',
                        '4'
                    );

                echo $blocks->getAnimatedColBlock(
                        $blocks->getBroadcastCategoryBlock(
                        'id',
                        'Наука',
                        'http://www.bluthemes.com/assets/img/blog/12/space-earth.jpg',
                        12103
                        ),
                        '12',
                        '6',
                        '4'
                    );

                echo $blocks->getAnimatedColBlock(
                        $blocks->getBroadcastCategoryBlock(
                        'id',
                        'Автомобили',
                        'https://thumbs.web.sapo.io/?epic=MzhlVdBRMniv/t/GcmUXwJ0giR8tX8V/K78WZrw4O1vaOIhqxcp8G48e7ZHT+GBv4gdhTDD18Y8QbNtS+dtaV094hFNO3R9ysv6MpVT2uizNV/w=&W=1200&H=627&delay_optim=1&tv=1&crop=center&.jpg',
                        8000
                        ),
                        '12',
                        '6',
                        '4'
                    );

                echo $blocks->getAnimatedColBlock(
                        $blocks->getBroadcastCategoryBlock(
                        'id',
                        'Разное',
                        'https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/N13e7awhgiljgescq/videoblocks-modern-city-background-animated-urban-backdrop-with-flat-design_stuxyo_cx_thumbnail-full01.png',
                        3000
                        ),
                        '12',
                        '6',
                        '4'
                    );

                ?>
                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-top" class="h-title">Популярные</a>
                    <a ajax-page="broadcast-cat-top" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small red right">Ещё</a>
                </h5>

                <?php

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Learn about Places and the Google Maps Places API over Coffee with Fontaine Foxworth',
                        'https://pp.userapi.com/c638526/v638526859/363b8/Zc3vi7GoDVs.jpg',
                        199,
                        3000,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'The Developer Show (TL;DR 069)',
                        'https://pp.userapi.com/c638526/v638526859/3589c/m9YkK3eTt5Q.jpg',
                        0,
                        2340,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Introducing AIY Projects: DIY AI for Makers',
                        'https://pp.userapi.com/c638526/v638526859/35d46/7ne2FcM9qOM.jpg',
                        0,
                        2040,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Learn about Places and the Google Maps Places API over Coffee with Fontaine Foxworth',
                        'https://pp.userapi.com/c638526/v638526859/363b8/Zc3vi7GoDVs.jpg',
                        99,
                        1232,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'The Developer Show (TL;DR 069)',
                        'https://pp.userapi.com/c638526/v638526859/3589c/m9YkK3eTt5Q.jpg',
                        10,
                        923,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Introducing AIY Projects: DIY AI for Makers',
                        'https://pp.userapi.com/c638526/v638526859/35d46/7ne2FcM9qOM.jpg',
                        0,
                        300,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                ?>

                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-new" class="h-title">Новые</a>
                    <a ajax-page="broadcast-cat-new" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small light-blue right">Ещё</a>
                </h5>

                <?php

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Learn about Places and the Google Maps Places API over Coffee with Fontaine Foxworth',
                        'https://pp.userapi.com/c638526/v638526859/363b8/Zc3vi7GoDVs.jpg',
                        199,
                        3000,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'The Developer Show (TL;DR 069)',
                        'https://pp.userapi.com/c638526/v638526859/3589c/m9YkK3eTt5Q.jpg',
                        0,
                        2340,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Introducing AIY Projects: DIY AI for Makers',
                        'https://pp.userapi.com/c638526/v638526859/35d46/7ne2FcM9qOM.jpg',
                        0,
                        2040,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                ?>

                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-future" class="h-title">Предстоящие</a>
                    <a ajax-page="broadcast-cat-future" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small green right">Ещё</a>
                </h5>

                <?php

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
                    '6',
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
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Introducing AIY Projects: DIY AI for Makers',
                        'https://pp.userapi.com/c638526/v638526859/35d46/7ne2FcM9qOM.jpg',
                        0,
                        0,
                        'Александр Пожаров',
                        '5ч'
                    ),
                    '12',
                    '6',
                    '4'
                );

                ?>

                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-last" class="h-title">Прошедшие</a>
                    <a ajax-page="broadcast-cat-last" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small amber right">Ещё</a>
                </h5>

                <?php

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Learn about Places and the Google Maps Places API over Coffee with Fontaine Foxworth',
                        'https://pp.userapi.com/c638526/v638526859/363b8/Zc3vi7GoDVs.jpg',
                        199,
                        3000,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'The Developer Show (TL;DR 069)',
                        'https://pp.userapi.com/c638526/v638526859/3589c/m9YkK3eTt5Q.jpg',
                        0,
                        2340,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Introducing AIY Projects: DIY AI for Makers',
                        'https://pp.userapi.com/c638526/v638526859/35d46/7ne2FcM9qOM.jpg',
                        0,
                        2040,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                ?>

                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-history" class="h-title">История</a>
                    <a ajax-page="broadcast-cat-history" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small indigo right">Ещё</a>
                </h5>


                <?php

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Learn about Places and the Google Maps Places API over Coffee with Fontaine Foxworth',
                        'https://pp.userapi.com/c638526/v638526859/363b8/Zc3vi7GoDVs.jpg',
                        199,
                        3000,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'The Developer Show (TL;DR 069)',
                        'https://pp.userapi.com/c638526/v638526859/3589c/m9YkK3eTt5Q.jpg',
                        0,
                        2340,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Introducing AIY Projects: DIY AI for Makers',
                        'https://pp.userapi.com/c638526/v638526859/35d46/7ne2FcM9qOM.jpg',
                        0,
                        2040,
                        'Александр Пожаров'
                    ),
                    '12',
                    '6',
                    '4'
                );

                ?>

            </div>
        </div>
    </div>
</div>