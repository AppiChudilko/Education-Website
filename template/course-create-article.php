<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $user;
global $userInfo;

$this->article = [];

if (isset($_GET['edit'])) {
    $this->article = $user->getCourseArticleById($_GET['edit']);
}

$isEdit = (isset($_GET['edit']) && $user->isTeacher() && $this->article['owner_id'] == $userInfo['id']);

?>
<ajax-title><?php echo 'Создание статьи | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 animated opacity-zero">
                <div class="card-panel">
                    <form enctype="multipart/form-data" method="post" class="row">
                        <div class="input-field col s12 m7">
                            <input required id="title" name="title" value="<?php echo ($isEdit ? htmlspecialchars_decode($this->article['title']) : '')  ?>" type="text" class="validate">
                            <label for="title">Заголовок</label>
                        </div>
                        <div class="input-field col s12 m5">
                            <select name="course" required>
                                <?php
                                    foreach ($this->courseList as $item)
                                        echo '<option ' . ($isEdit && $item['id'] == $this->article['course_id'] ? 'selected' : '') . ' value="' . $item['id'] . '">' . $item['title'] . '</option>';
                                ?>
                            </select>
                            <label>Курс</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <div class="btn light-blue">
                                <span><i class="material-icons">add_a_photo</i></span>
                                <input name="img" type="file" accept="image/x-png,image/gif,image/jpeg">
                            </div>
                            <div class="file-path-wrapper">
                                <input placeholder="Картинка для статьи" class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <textarea required id="content" name="content" class="materialize-textarea" maxlength="65000"><?php echo ($isEdit ? htmlspecialchars_decode(htmlspecialchars_decode(nl2br($this->article['content']))) : '')  ?></textarea>
                            <label for="content">Статья</label>
                            <?php echo ($isEdit ? '<input type="hidden" name="id" value="' . $this->article['id'] . '"><button name="user-course-edit-article" class="btn z-depth-0 right waves-effect light-blue">Редактировать</button>' : '<button name="user-course-create-article" class="btn z-depth-0 right waves-effect light-blue">Опубликовать</button>') ?>
                        </div>
                    </form>
                </div>
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
                        Создавая статью на Appi Education, вы принимаете <a>условия использования</a> и <a>правила сайта</a>.<br>
                        Следите за тем, чтобы ваш контент не нарушал авторских прав и других прав собственности. <a>Подробнее...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>