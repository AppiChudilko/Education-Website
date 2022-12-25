<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $settings;
global $blocks;
?>
<ajax-title><?php echo 'Мои покупки | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 videos">
                <h5 class="col s12 h-title animated opacity-zero">
                    <div class="left">Мои покупки</div>
                </h5>

                <?php

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastBlock(
                        'id',
                        'Learn about Places and the Google Maps Places API over Coffee with Fontaine Foxworth',
                        'https://pp.userapi.com/c638526/v638526859/363b8/Zc3vi7GoDVs.jpg',
                        -1,
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
                        -1,
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
                        -1,
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
        </div>
    </div>
</div>