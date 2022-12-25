<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $user;
global $userInfo;

$this->course = [];

if (isset($_GET['edit'])) {
    $this->course = $user->getCourseById($_GET['edit']);
}

$isEdit = (isset($_GET['edit']) && $user->isTeacher() && $this->course['owner_id'] == $userInfo['id']);


?>
<ajax-title><?php echo 'Создание курса | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 animated opacity-zero">
                <div class="card-panel">
                    <form method="post" action="/course-list-<?php echo $userInfo['id'] ?>" class="row">
                        <div class="input-field col s12">
                            <input required id="title" name="title" maxlength="120" type="text" value="<?php echo ($isEdit ? htmlspecialchars_decode($this->course['title']) : '')  ?>" class="validate">
                            <label for="title">Заголовок</label>
                        </div>
                        <div class="input-field col s12 m5">
                            <input required id="title-desc" name="title-desc" maxlength="120" value="<?php echo ($isEdit ? htmlspecialchars_decode($this->course['title_desc']) : '')  ?>" type="text" class="validate">
                            <label for="title-desc">Заголовок описания</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input required id="price" name="price" type="number" value="<?php echo ($isEdit ? $this->course['price'] : '0')  ?>" class="validate">
                            <label for="price">Цена курса</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <select name="color" required>
                                <option value="red" selected>Красный</option>
                                <option value="pink">Розовый</option>
                                <option value="purple">Фиолетовый</option>
                                <option value="deep-purple">Тёмно-Фиолетовый</option>
                                <option value="indigo">Индиго</option>
                                <option value="blue">Синий</option>
                                <option value="light-blue">Голубой</option>
                                <option value="cyan">Светло-Голубой</option>
                                <option value="teal">Караловый</option>
                                <option value="green">Зеленый</option>
                                <option value="light-green">Светло-Зеленый</option>
                                <option value="lime">Лаймовый</option>
                                <option value="yellow">Желтый</option>
                                <option value="amber">Тёмно-Желтый</option>
                                <option value="orange">Оранжевый</option>
                                <option value="deep-orange">Темно-Оранжевый</option>
                                <option value="brown">Коричневый</option>
                                <option value="grey">Серый</option>
                                <option value="blue-grey">Серо-Голубой</option>
                                <option value="black">Черный</option>
                                <option value="white">Белый</option>
                            </select>
                            <label>Цвет</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea required id="desc" name="desc" class="materialize-textarea" data-length="2000"><?php echo ($isEdit ? htmlspecialchars_decode(nl2br($this->course['content'])) : '')  ?></textarea>
                            <label for="desc">Описание курса</label>
                        </div>
                        <div class="input-field col s12">
                            <?php
                                if ($isEdit)
                                    echo '<input type="hidden" name="id" value="' . $_GET['edit'] . '"><button name="user-course-edit" class="btn z-depth-0 right waves-effect light-blue">Редактировать</button>';
                                else
                                    echo '<button name="user-course-create" class="btn z-depth-0 right waves-effect light-blue">Создать</button>';

                            ?>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>