<?php

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

$filePath = 'http://edf.byappi.com';

$sexList = ['Не выбран', 'Мужской', 'Женский'];

$modal = ['isShow' => false, 'text' => '', 'success' => false];

$notificationAction = ['Спасибо за регистрацию', 'Заявка в друзья', 'Трансляция началась', 'Пополнение счёта'];

$monthN = [
    '01' => 'Января',
    '02' => 'Февраля',
    '03' => 'Марта',
    '04' => 'Апреля',
    '05' => 'Мая',
    '06' => 'Июня',
    '07' => 'Июля',
    '08' => 'Августа',
    '09' => 'Сентября',
    '10' => 'Октября',
    '11' => 'Ноября',
    '12' => 'Декабря'
];

$month = [
    '01' => 'Январь',
    '02' => 'Февраль',
    '03' => 'Март',
    '04' => 'Апрель',
    '05' => 'Май',
    '06' => 'Июнь',
    '07' => 'Июль',
    '08' => 'Август',
    '09' => 'Сентябрь',
    '10' => 'Октябрь',
    '11' => 'Ноябрь',
    '12' => 'Декабрь'
];
