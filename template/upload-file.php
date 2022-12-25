<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;

?>
<ajax-title><?php echo 'Загрузка файлов | ' . $settings->getTitle(); ?></ajax-title>

<input type="file" id="upload-course-file-input" style="display: none">

<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 animated opacity-zero" id="upload-course-file">
                <div class="card-panel center" style="cursor: pointer">
                    <h6 style="margin-top: 114px; margin-bottom: 130px;">
                        <i class="material-icons grey-text" style="font-size: 7rem;">file_upload</i>
                        <br>Выберите файл для загрузки
                        <br><label style="display: none">...или перетащите их мышью</label>
                    </h6>
                </div>
            </div>
            <div class="col s12 m8 animated opacity-zero" id="edit-course-file" style="display: none">
                <form method="post" class="card-panel center">
                    <div class="row">
                        <input type="hidden" id="id-file" name="id">
                        <div class="input-field col s12 m7">
                            <input required id="title" name="title" type="text" class="validate">
                            <label for="title">Название файла</label>
                        </div>
                        <div class="input-field col s12 m5">
                            <select name="course" required>
                                <?php
                                foreach ($this->courseList as $item)
                                    echo '<option selected value="' . $item['id'] . '">' . $item['title'] . '</option>';
                                ?>
                            </select>
                            <label>Курс</label>
                        </div>
                        <div class="input-field col s12">
                            <button name="user-course-edit-file" class="btn z-depth-0 right waves-effect light-blue">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s12 m4">
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
                        Загружая видео на Appi Education, вы принимаете <a>условия использования</a> и <a>правила сайта</a>.<br>
                        Следите за тем, чтобы ваш контент не нарушал авторских прав и других прав собственности. <a>Подробнее...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>