<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $blocks;
global $user;

?>
<ajax-title><?php echo 'Трансляции и видео | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="row">
                    <div class="col s12 m4">
                        <div onclick="$.showPage('broadcast')" class="card-panel center hoverable animated opacity-zero" style="cursor: pointer">
                            <div style="padding: 64px"><i class="material-icons grey-text" style="font-size: 8rem">personal_video</i></div>
                            <div class="grey-text">Видео</div>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div onclick="$.showPage('broadcast')" class="card-panel center hoverable animated opacity-zero" style="cursor: pointer">
                            <div style="padding: 64px"><i class="material-icons grey-text" style="font-size: 8rem">live_tv</i></div>
                            <div class="grey-text">Трансляции</div>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div onclick="$.showPage('broadcast')" class="card-panel center hoverable animated opacity-zero" style="cursor: pointer">
                            <div style="padding: 64px"><i class="material-icons grey-text" style="font-size: 8rem">library_books</i></div>
                            <div class="grey-text">Курсы</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 videos">
                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-top" class="h-title">Популярные трансляции</a>
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
            </div>
            <div class="col s12 videos">
                <h5 class="col s12 animated opacity-zero">
                    <a ajax-page="broadcast-cat-top" class="h-title">Популярные видео</a>
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
            </div>
            <div class="col s12">
                <div class="row">
                    <h5 class="col s12 animated opacity-zero">
                        <a ajax-page="broadcast-cat-top" class="h-title">Популярные курсы</a>
                        <a ajax-page="broadcast-cat-top" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small red right">Ещё</a>
                    </h5>
                    <?php
                    foreach ($user->getCourseAllList(6) as $item) {
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
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!--
      "We only have room
       for one specimen,       "Let us take the small,
       Dtlxvr. Which shall     high-decible one, Ftxbp.
          we take?"               It has less mass."
                 \  _.-'~~~~'-._   /
          .      .-~ \__/  \__/ ~-.         .
               .-~   (oo)  (oo)    ~-.
              (_____//~~\\//~~\\______)
         _.-~`                         `~-._
        /O=O=O=O=O=O=O=O=O=O=O=O=O=O=O=O=O=O\     *
        \___________________________________/
                   \x x x x x x x/
           .  *     \x_x_x_x_x_x/
    -->