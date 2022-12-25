<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $blocks;
global $settings;
?>
<ajax-title><?php echo 'Моё обучение | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 videos">

                <h5 class="col s12 animated opacity-zero">
                    <a href="#" class="h-title">Моё обучение</a>
                    <a href="#" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small green right">Ещё</a>
                </h5>
                <?php

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastUserEduBlock(
                        'id',
                        'Языки',
                        'http://creativecrunk.com/wp-content/uploads/2014/11/Mobile-Flagships.jpg',
                        123
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastUserEduBlock(
                        'id',
                        'IT направление',
                        'http://icloudpicture.com/wp-content/uploads/2016/01/Computer-Flat-HD-Wallpaper.png',
                        52
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastUserEduBlock(
                        'id',
                        'Бизнес',
                        'http://www.lvtc.ca/files/2014/01/photodune-6462660-business-meeting-flat-illustration-m.jpg',
                        34
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastUserEduBlock(
                        'id',
                        'Наука',
                        'http://www.bluthemes.com/assets/img/blog/12/space-earth.jpg',
                        12
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastUserEduBlock(
                        'id',
                        'Автомобили',
                        'https://thumbs.web.sapo.io/?epic=MzhlVdBRMniv/t/GcmUXwJ0giR8tX8V/K78WZrw4O1vaOIhqxcp8G48e7ZHT+GBv4gdhTDD18Y8QbNtS+dtaV094hFNO3R9ysv6MpVT2uizNV/w=&W=1200&H=627&delay_optim=1&tv=1&crop=center&.jpg',
                        1
                    ),
                    '12',
                    '6',
                    '4'
                );

                echo $blocks->getAnimatedColBlock(
                    $blocks->getBroadcastUserEduBlock(
                        'id',
                        'Разное',
                        'https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/N13e7awhgiljgescq/videoblocks-modern-city-background-animated-urban-backdrop-with-flat-design_stuxyo_cx_thumbnail-full01.png',
                        0.1
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
                    <a ajax-page="broadcast-cat-history" class="h-title">Статистика просмотров</a>
                </h5>

                <div class="col s12">
                    <div class="card-panel animated opacity-zero">
                        <div id="views" style="height: 500px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChartViews);

        function drawChartViews() {

            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Месяц');
            data.addColumn('number', 'Просмотры');

            data.addRows([
                [1,  10],
                [2,  10],
                [3,  10],
                [4,  15],
                [5,  7],
                [6,  0],
                [7,  3],
                [8,  5],
                [9,  3],
                [10,  10],
                [11,  10],
                [12,  10],
                [13,  10],
                [14,  10],
                [15,  6],
                [16,  25],
                [17,  3],
                [18,  8],
                [19,  6],
                [20,  9],
                [21,  9],
                [22,  9],
                [23,  9],
                [24,  13],
                [25,  6],
                [26,  0],
                [27,  2],
                [28,  6],
                [29,  4],
                [30,  4]
            ]);

            var options = {
                chart: {
                    title: 'Статистика просмотров',
                    subtitle: 'Статистика просмотров за последние 30 дней (В часах).'
                },
                height: 500,
                axes: {
                    x: {
                        0: {side: 'top'}
                    }
                }
            };

            var chart = new google.charts.Line(document.getElementById('views'));
            chart.draw(data, google.charts.Line.convertOptions(options));
        }
    });
</script>