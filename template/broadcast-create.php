<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;

?>
<ajax-title><?php echo 'Создание трансляции | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 animated opacity-zero">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12">
                            <input required id="last_name" type="text" class="validate">
                            <label for="last_name">Название трансляции</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input required id="last_name" type="number" value="0" class="validate">
                            <label for="last_name">Стоимость</label>
                        </div>
                        <div class="input-field col s12 m8">
                            <select required>
                                <option value="" disabled selected>Нет</option>
                                <option value="1">Английский</option>
                                <option value="2">Экономика</option>
                                <option value="3">Немецкий для начинающих</option>
                            </select>
                            <label>Курс</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select required>
                                <option value="" selected>Разное</option>
                                <option value="1">Английский</option>
                                <option value="2">Экономика</option>
                                <option value="3">Астрономия</option>
                            </select>
                            <label>Категория</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select required>
                                <option value="3" selected>Для всех</option>
                                <option value="1">Для начинающих</option>
                                <option value="2">Для среднячков</option>
                                <option value="3">Для профи</option>
                            </select>
                            <label>Подкатегория</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea required id="textarea1" class="materialize-textarea" data-length="500"></textarea>
                            <label for="textarea1">Описание трансляции</label>
                            <button class="btn z-depth-0 right waves-effect light-blue">Создать</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card-panel animated opacity-zero">
                    <div style="display: flex; line-height: 46px;"><i class="material-icons" style="font-size: 3rem; margin-right: 8px">videocam</i>ЗАГРУЖАЙТЕ ВИДЕО</div>
                    <div class="grey-text" style="margin-top: 4px">
                        Загружайте видео, чтобы повысить свой доход и рейтинг
                    </div><br>
                    <a ajax-page="upload-video" class="btn z-depth-0 btn-small red">Загрузить</a>
                </div>
                <div class="card-panel animated opacity-zero">
                    <div style="display: flex; line-height: 46px;"><i class="material-icons" style="font-size: 3rem; margin-right: 8px">library_books</i>СОЗДАВАЙТЕ КУРСЫ</div>
                    <div class="grey-text" style="margin-top: 4px">
                        Создавайте курсы для группировки ваших видео, трансляций, различных файлов и статей
                    </div><br>
                    <a ajax-page="create-course" class="btn z-depth-0 btn-small red">Создать</a>
                </div>
            </div>
            <div class="col s12 animated opacity-zero">
                <div class="grey-text text-darken-2">
                    <br>СПРАВКА И РЕКОМЕНДАЦИИ<br>
                    <div class="grey-text">
                        Создавая трансляцию на Appi Education, вы принимаете <a>условия использования</a> и <a>правила сайта</a>.<br>
                        Следите за тем, чтобы ваш контент не нарушал авторских прав и других прав собственности. <a>Подробнее...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>