<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;

?>
<ajax-title><?php echo 'Статистика баланса | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card-panel animated opacity-zero">
                    <div id="balance" style="height: 500px"></div>
                </div>
                <div class="card-panel animated opacity-zero">
                    <div id="views" style="height: 500px"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChartBalance);
        google.charts.setOnLoadCallback(drawChartViews);

        function drawChartBalance() {

            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Месяц');
            data.addColumn('number', 'Прибыль');

            data.addRows([
                [1,  3700],
                [2,  3700],
                [3,  3700],
                [4,  5000],
                [5,  2100],
                [6,  0],
                [7,  1100],
                [8,  3300],
                [9,  2134],
                [10,  3300],
                [11,  3300],
                [12,  3300],
                [13,  3300],
                [14,  3300],
                [15,  2100],
                [16,  10000],
                [17,  1100],
                [18,  3300],
                [19,  2134],
                [20,  2134],
                [21,  3700],
                [22,  3700],
                [23,  3700],
                [24,  5000],
                [25,  2100],
                [26,  0],
                [27,  1100],
                [28,  3300],
                [29,  2134],
                [30,  2134]
            ]);

            var options = {
                chart: {
                    title: 'Статистика дохода',
                    subtitle: 'Статистика дохода с трансляций в рублях, за последние 30 дней.'
                },
                height: 500,
                axes: {
                    x: {
                        0: {side: 'top'}
                    }
                }
            };

            var chart = new google.charts.Line(document.getElementById('balance'));
            chart.draw(data, google.charts.Line.convertOptions(options));
        }

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
                    subtitle: 'Статистика среднего числа просмотров за последние 30 дней.'
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