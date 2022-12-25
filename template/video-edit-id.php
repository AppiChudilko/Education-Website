<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $user;
global $userInfo;

?>
<ajax-title><?php echo 'Редактировать видео | ' . $settings->getTitle(); ?></ajax-title>

<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 animated opacity-zero">
                <form enctype="multipart/form-data" method="post" action="/video-list" class="card center">
                    <div class="card-image"><img src="<?php echo $this->file['path_img'] ?>"></div>
                    <div class="card-content">
                        <div class="row">
                            <input type="hidden" id="id-file" name="id" value="<?php echo $this->file['id']; ?>">
                            <div class="input-field col s12 m7">
                                <input required id="title" name="title" value="<?php echo htmlspecialchars_decode($this->file['title']);  ?>" type="text" class="validate">
                                <label for="title">Название видео</label>
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
                            <div class="file-field input-field col s12">
                                <div class="btn light-blue z-depth-0 waves-effect">
                                    <span><i class="material-icons">add_a_photo</i></span>
                                    <input name="img" accept="image/x-png,image/gif,image/jpeg" type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action" style="height: 53px">
                        <button name="user-course-video-edit" class="btn z-depth-0 right waves-effect light-blue" style="margin-left: 12px">Сохранить</button>
                        <button name="user-course-video-delete" class="btn z-depth-0 right waves-effect red">Удалить</button>
                    </div>
                </form>
            </div>
            <div class="col s12 m4 animated opacity-zero"><br>
                <a ajax-page="video-list" class="btn waves-effect right light-blue">Список всех видео</a>
            </div>
        </div>
    </div>
</div>