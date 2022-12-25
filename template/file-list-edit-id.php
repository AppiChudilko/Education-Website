<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $user;
global $userInfo;

?>
<ajax-title><?php echo 'Редактировать файл | ' . $settings->getTitle(); ?></ajax-title>

<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 animated opacity-zero">
                <form method="post" action="/file-list" class="card-panel center">
                    <div class="row">
                        <input type="hidden" id="id-file" name="id" value="<?php echo $this->file['id']; ?>">
                        <div class="input-field col s12 m7">
                            <input required id="title" name="title" value="<?php echo htmlspecialchars_decode($this->file['title']);  ?>" type="text" class="validate">
                            <label for="title">Название файла</label>
                        </div>
                        <div class="input-field col s12 m5">
                            <select name="course" required>
                                <?php
                                foreach ($this->courseList as $item)
                                    echo '<option ' . ($item['id'] == $this->file['course_id'] ? 'selected' : '') . ' value="' . $item['id'] . '">' . $item['title'] . '</option>';
                                ?>
                            </select>
                            <label>Курс</label>
                        </div>
                        <div class="input-field col s12">
                            <button name="user-course-file-edit" class="btn z-depth-0 right waves-effect light-blue" style="margin-left: 12px">Сохранить</button>
                            <button name="user-course-file-delete" class="btn z-depth-0 right waves-effect red">Удалить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s12 m4 animated opacity-zero"><br>
                <a ajax-page="file-list" class="btn waves-effect right light-blue">Список всех файлов</a>
            </div>
        </div>
    </div>
</div>