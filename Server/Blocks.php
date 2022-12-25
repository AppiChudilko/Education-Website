<?php

namespace Server;

use Server\Core\EnumConst;
use Server\Core\QueryBuilder;
use Server\Core\Server;
use Server\Core\Time;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

/**
 * Blocks
 */
class Blocks
{
    /**
     * @param $content
     * @param $s
     * @param $m
     * @param $l
     * @return string
     */
    public function getAnimatedColBlock($content, $s, $m, $l) {
        return '<div class="col s' . $s . ' m' . $m . ' l' . $l . ' animated opacity-zero">' . $content . '</div>';
    }

    /**
     * @param $id
     * @param $title
     * @param $titleDesc
     * @param $desc
     * @param $price
     * @param $rating
     * @param $color
     * @param $colorText
     * @return string
     */
    public function getCourseBlock($id, $title, $titleDesc, $desc, $price, $rating, $color = 'pink', $colorText = 'white') {
        return '
            <div class="card card-course hoverable">
                <div class="card-image ' . $color . ' ' . $colorText . '-text">
                    <a ajax-page="course-' . $id . '" class="card-title white-text" title="' . $title . '">
                        ' . htmlspecialchars_decode($title) . '
                    </a>
                </div>
                <div class="card-content">
                    <h6>' . htmlspecialchars_decode($titleDesc) . '</h6>
                    <div class="hide-desc"></div>
                    <label>' . htmlspecialchars_decode(nl2br($desc)) . '</label>
                </div>
                <div class="card-action">
                    <label class="left">
                        ' . ($price == 0 ? 'Бесплатный курс' : 'Цена: ' . number_format($price) . '₽') . '<br>
                        Рейтинг: ' . number_format($rating) . '
                    </label>
                    <a ajax-page="course-' . $id . '" class="btn btn-small waves-effect grey lighten-4 grey-text text-darken-3 z-depth-0 right">Подробнее</a>
                </div>
            </div>
        ';
    }

    /**
     * @param bool $isShowAdd
     * @return string
     */
    public function getCourseNoneBlock($isShowAdd = false) {
        return '
            <div class="card card-course grey lighten-3 z-depth-0">
                <div class="card-image grey lighten-3 center">
                </div>
                <div class="card-content">
                    <div class="center" style="width: 100%;">
                        ' . ($isShowAdd ? '<h5 class="grey-text" style="margin-top: -24px; margin-bottom: 12px">Создать курс</h5><a ajax-page="create-course" class="grey-text btn btn-floating grey lighten-1 z-depth-1 waves-effect" style="margin-top: 0"><i class="material-icons">add</i></a>' : '') . '
                    </div>
                </div>
                <div class="card-action" style="border: 0">
                    <label class="left">
                </div>
            </div>
        ';
    }

    /**
     * @param $id
     * @param $title
     * @param $img
     * @param int $price
     * @param int $views
     * @param string $author
     * @param string $soon
     * @return string
     */
    public function getBroadcastBlock($id, $title, $img, $price = 0, $views = 0, $author = '', $soon = '') {

        $priceBlock = '<div class="live-price" title="Стомость ' . number_format($price) . ' ₽">' . number_format($price) . ' ₽</div>';

        if ($price == 0)
            $priceBlock = '<div class="live-price green" title="Бесплатная трансляция">Бесплатно</div>';
        if ($price == -1)
            $priceBlock = '<div class="live-price blue" title="Трансляция была оплачена">Оплачено</div>';

        $infoBlock = '<i class="mdi mdi-eye" title="Сейчас смотрят"></i> ' . number_format($views, 0, '.', ' ');
        
        if ($soon != '')
            $infoBlock = '<i class="mdi mdi-timer" title="Предстоящая трансляция через ' . $soon . '"></i> Через ' . $soon;

        return '
            <div class="card z-depth-0 transparent">
                <a href="/broadcast-' . $id . '" class="card-image">
                    <img src="' . $img . '">
                    ' . $priceBlock . '
                    <span class="card-title card-title-very-small">
                        ' . $title . '
                    </span>
                </a>
                <div class="card-content transparent grey-text" style="padding: 4px 0;">
                    <i class="mdi mdi-account" title="Автор"></i> ' . $author . '<br>
                    ' . $infoBlock . '
                </div>
            </div>
        ';
    }

    /**
     * @param $id
     * @param $title
     * @param $img
     * @param int $price
     * @param int $views
     * @param string $author
     * @param string $soon
     * @return string
     */
    public function getVideoBlock($id, $title, $img, $price = 0, $views = 0, $author = '', $soon = '') {

        $priceBlock = '<div class="live-price" title="Стомость ' . number_format($price) . ' ₽">' . number_format($price) . ' ₽</div>';

        if ($price == 0)
            $priceBlock = '<div class="live-price green" title="Бесплатная трансляция">Входит в стоимость курса</div>';
        if ($price == -1)
            $priceBlock = '<div class="live-price blue" title="Трансляция была оплачена">Оплачено</div>';

        $infoBlock = '<i class="mdi mdi-eye" title="Сейчас смотрят"></i> ' . number_format($views, 0, '.', ' ');

        if ($soon != '')
            $infoBlock = '<i class="mdi mdi-timer" title="Предстоящая трансляция через ' . $soon . '"></i> Через ' . $soon;

        return '
            <div class="card z-depth-0 transparent">
                <a ajax-page="video-' . $id . '" class="card-image">
                    <img src="' . $img . '">
                    ' . $priceBlock . '
                    <span class="card-title card-title-very-small">
                        ' . $title . '
                    </span>
                </a>
                <div class="card-content transparent grey-text" style="padding: 4px 0;">
                    <i class="mdi mdi-account" title="Автор"></i> ' . $author . '<br>
                    ' . $infoBlock . '
                </div>
            </div>
        ';
    }

    /**
     * @param bool $isShowAddBroadcast
     * @return string
     */
    public function getBroadcastNoneBlock($isShowAddBroadcast = false) {
        return '
            <div class="card z-depth-0 transparent">
                <div class="card-image grey lighten-3" style="border-radius: 2px">
                    <div class="center" style="height: 200px; width: 100%; padding-top: 40px">
                        ' . ($isShowAddBroadcast ? '<h5 class="grey-text" style="margin-top: 20px; margin-bottom: 12px;">Создать трансялцию</h5><a ajax-page="create-broadcast" class="grey-text btn btn-floating grey lighten-1 z-depth-1 waves-effect" style="margin-top: 0"><i class="material-icons">add</i></a>' : '') . '
                    </div>
                </div>
                <div class="card-content transparent" style="padding: 4px 0;">
                    <div class="grey lighten-3 grey-text text-lighten-3" style="border-radius: 2px 2px 0 0; user-select: none;"><i class="mdi mdi-account"></i> Если ты читаешь это, то ты крут</div>
                    <div class="grey lighten-3 grey-text text-lighten-3" style="border-radius: 0 0 2px 2px; user-select: none;""><i class="mdi mdi-timer"></i> Вот таки дела</div>
                </div>
            </div>
        ';
    }

    /**
     * @param $id
     * @param $title
     * @param $img
     * @param int $views
     * @return string
     */
    public function getBroadcastCategoryBlock($id, $title, $img, $views = 0) {
        return '
            <div class="card z-depth-0 transparent">
                <a ajax-page="broadcast-cat-' . $id . '" class="card-image">
                    <img src="' . $img . '">
                    <span class="card-title card-title-very-small">
                        ' . $title . '
                    </span>
                </a>
                <div class="card-content transparent grey-text" style="padding: 4px 0;">
                    <i class="mdi mdi-star" title="Сейчас смотрят"></i> ' . number_format($views, 0, '.', ' ') . '
                </div>
            </div>
        ';
    }

    /**
     * @param $id
     * @param $title
     * @param $img
     * @param $view
     * @return string
     */
    public function getBroadcastUserEduBlock($id, $title, $img, $view) {
        return '
            <div class="card z-depth-0 transparent">
                <a href="/myedu-' . $id . '" class="card-image">
                    <img src="' . $img . '">
                    <div class="live-price green" title="Просмотренно: ' . $view . 'ч.">' . $view . 'ч.</div>
                    <span class="card-title card-title-very-small">
                        ' . $title . '
                    </span>
                </a>
            </div>
        ';
    }

    /**
     * @return string
     */
    public function getProfileEdit()
    {
        global $userInfo;
        global $filePath;

        return '
        <form method="post" id="edit-profile" class="modal modal-fixed-footer modal-full-height">
            <div class="modal-content">
                <div class="row">
                    <div class="col s12">
                        <h5 style="margin: 0">Изменить профиль</h5>
                        <div class="card z-depth-0">
                            <div class="card-image">
                                <img style="height: 150px; object-fit: cover; border-radius: 2px" src="' . $filePath . $userInfo['img_wallpaper'] . '">
                                <span class="card-title" style="padding: 5px">
                                    <img class="profile-ava" src="' . $filePath . $userInfo['img_avatar'] . '">
                                    <input type="file" style="display: none" id="upload-profile-ava-input">
                                    <a id="upload-profile-ava-btn" style="right: -10px; bottom: -10px; left: 55px;" class="btn-floating halfway-fab waves-effect waves-light blue lighten-1">
                                        <i class="material-icons white-text">photo_camera</i>
                                    </a>
                                </span>
                                <input type="file" style="display: none" id="upload-profile-bg-input">
                                <a id="upload-profile-bg-btn" class="btn-floating halfway-fab waves-effect waves-light blue lighten-1"><i class="material-icons">photo_camera</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <input name="status" value="' . htmlspecialchars_decode($userInfo['status']) . '" id="status" maxlength="200" type="text" class="validate">
                        <label for="status">Статус</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input required name="name" value="' . $userInfo['name'] . '" id="name" maxlength="30" type="text" class="validate">
                        <label for="name">Имя</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="surname" value="' . $userInfo['surname'] . '" id="surname" maxlength="30" type="text" class="validate">
                        <label for="surname">Фамилия</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="patronymic" value="' . $userInfo['patronymic'] . '" id="patronymic" maxlength="64" type="text" class="validate">
                        <label for="patronymic">Отчество</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="country" value="' . $userInfo['country'] . '" id="country" maxlength="30" type="text" class="validate">
                        <label for="country">Страна</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="city" value="' . $userInfo['city'] . '" id="city" maxlength="30" type="text" class="validate">
                        <label for="city">Город</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="vk" value="' . $userInfo['vk'] . '" id="vk" maxlength="30" type="text" class="validate">
                        <label for="vk">Вконтакте</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="facebook" value="' . $userInfo['facebook'] . '" id="facebook" maxlength="30" type="text" class="validate">
                        <label for="facebook">Facebook</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="instagram" value="' . $userInfo['instagram'] . '" id="inst" maxlength="30" type="text" class="validate">
                        <label for="inst">Instagram</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="website" value="' . $userInfo['website'] . '" id="website" maxlength="30" type="text" class="validate">
                        <label for="website">Веб-сайт</label>
                    </div>
                    <p class="col s6">
                        <input name="sex" value="1" ' . ($userInfo['sex'] == 1 ? 'checked' : '') . ' type="radio" id="male" />
                        <label for="male">Мужской</label>
                    </p>
                    <p class="col s6">
                        <input name="sex" value="2" ' . ($userInfo['sex'] == 2 ? 'checked' : '') . ' type="radio" id="female" />
                        <label for="female">Женский</label>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect btn-flat small-padding">Отмена</a>
                <button class="modal-action waves-effect btn-flat small-padding" name="profile-edit">Сохранить</button>
            </div>
        </form>
        ';
    }

    /**
     * @param $userInfo
     * @return string
     */
    public function getProfileInfo($userInfo)
    {
        global $filePath;
        return '
        <div id="info-profile" class="modal modal-fixed-footer modal-full-height">
            <div class="modal-content">
                <div class="row">
                    <div class="col s12">
                        <h5 style="margin: 0">Информация о пользователе</h5>
                        <div class="card z-depth-0">
                            <div class="card-image">
                                <img style="height: 150px; object-fit: cover; border-radius: 2px" src="' . $filePath . $userInfo['img_wallpaper'] . '">
                                <span class="card-title" style="padding: 5px">
                                    <img class="profile-ava" src="' . $filePath . $userInfo['img_avatar'] . '">
                                    <input type="file" style="display: none" id="upload-profile-ava-input">
                                </span>
                                <input type="file" style="display: none" id="upload-profile-bg-input">
                            </div>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <input disabled value="' . htmlspecialchars_decode($userInfo['status']) . '" id="status" maxlength="200" type="text" class="validate black-text">
                        <label for="status">Статус</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input disabled value="' . $userInfo['name'] . '" id="name" maxlength="30" type="text" class="validate black-text">
                        <label for="name">Имя</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input disabled value="' . $userInfo['surname'] . '" id="surname" maxlength="30" type="text" class="validate black-text">
                        <label for="surname">Фамилия</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input disabled value="' . $userInfo['country'] . '" id="country" maxlength="30" type="text" class="validate black-text">
                        <label for="country">Страна</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input disabled value="' . $userInfo['city'] . '" id="city" maxlength="30" type="text" class="validate black-text">
                        <label for="city">Город</label>
                    </div>
                    <a target="_blank" href="https://vk.com/' . $userInfo['vk'] . '" class="input-field col s12 m6">
                        <input style="cursor: pointer;" disabled value="' . $userInfo['vk'] . '" id="vk" maxlength="30" type="text" class="validate black-text">
                        <label for="vk">Вконтакте</label>
                    </a>
                    <a target="_blank" href="https://facebook.com/' . $userInfo['facebook'] . '" class="input-field col s12 m6">
                        <input style="cursor: pointer;" disabled value="' . $userInfo['facebook'] . '" id="facebook" maxlength="30" type="text" class="validate black-text">
                        <label for="facebook">Facebook</label>
                    </a>
                    <a target="_blank" href="https://instagram.com/' . $userInfo['instagram'] . '" class="input-field col s12 m6">
                        <input style="cursor: pointer;" disabled value="' . $userInfo['instagram'] . '" id="inst" maxlength="30" type="text" class="validate black-text">
                        <label for="inst">Instagram</label>
                    </a>
                    <a target="_blank" href="' . $userInfo['website'] . '" class="input-field col s12 m6">
                        <input style="cursor: pointer;" disabled value="' . $userInfo['website'] . '" id="website" maxlength="30" type="text" class="validate black-text">
                        <label for="website">Веб-сайт</label>
                    </a>
                    <p class="col s6">
                        <input disabled type="radio" ' . ($userInfo['sex'] == 1 ? 'checked' : '') . ' id="male-inf" />
                        <label for="male-inf">Мужской</label>
                    </p>
                    <p class="col s6">
                        <input disabled type="radio" ' . ($userInfo['sex'] == 2 ? 'checked' : '') . ' id="female-inf" />
                        <label for="female-inf" >Женский</label>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect btn-flat small-padding">Закрыть</a>
            </div>
        </div>
        ';
    }

    /**
     * @return string
     */
    public function getBlogPostSend() {
        return '
            <a href="#new-post" class="z-depth-4 btn-floating btn-large waves-effect light-blue lighten-1 profile-new-post modal-trigger animated opacity-zero"><i class="material-icons white-text">edit</i></a>
            <div id="new-post" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h5>
                        Публикация в блог
                        <a class="right modal-action modal-close waves-effect btn-flat" style="padding: 0 10px;"><i class="material-icons">close</i></a>
                    </h5>
                    <div class="row">
                        <div class="col s12">
                            <textarea required="" id="blog-new-text" name="text" placeholder="Что у вас нового?" class="materialize-textarea" style="box-shadow: none; border-bottom: 0"></textarea>
                            <input type="hidden" id="blog-temp-imgname">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="file" style="display: none" id="upload-img-blog-input">
                    <a class="left modal-action waves-effect btn-flat" id="upload-img-blog-btn" style="padding: 0 10px;"><i class="material-icons grey-text text-darken-2">photo</i></a>
                    <a class="left modal-action waves-effect btn-flat" style="padding: 0 10px;"><i class="material-icons grey-text text-darken-2">videocam</i></a>
                    <a class="left modal-action waves-effect btn-flat" style="padding: 0 10px;"><i class="material-icons grey-text text-darken-2">insert_drive_file</i></a>
                    
                    <div class="preloader-wrapper small active left" id="blog-preloader">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                                </div><div class="gap-patch">
                                <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grey-text" id="blog-attaches">Вложения: 1</div>
                    <button class="modal-action waves-effect btn-flat small-padding modal-close" onclick="$.blogPostSend();">Опубликовать</button>
                </div>
            </div>
        ';
    }

    /**
     * @return string
     */
    public function getCourseListAdd() {
        return '
            <a ajax-page="create-course" class="z-depth-4 btn-floating btn-large waves-effect light-blue lighten-1 profile-new-post modal-trigger animated opacity-zero"><i class="material-icons white-text">add</i></a>
        ';
    }

    /**
     * @param integer $id
     * @param string $authorUrl
     * @param string $authorName
     * @param string $authorImg
     * @param string $dateTime
     * @param string $content
     * @param string $image
     * @param bool $canDelete
     * @return string
     */
    public function getBlogPost($id, $authorUrl, $authorName, $authorImg, $dateTime, $content = '', $image = '', $canDelete = false) {

        global $qb;
        global $server;
        global $user;
        global $userInfo;
        global $filePath;

        $qm = new QueryMethods($qb, $server);

        $likeBlock = '<a onclick="$.blogPostSetLike(' . $id . ')" class="btn-floating btn waves-effect waves-red grey lighten-3 z-depth-0 hoverable-z1"><i class="material-icons grey-text">favorite</i></a>';
        $likeCount = $user->countLikes($id);
        $commentsCount = $qm->blogPostCountComments($id);

        if ($likeCount > 0 && $user->isSetLike($id))
            $likeBlock = '<a onclick="$.blogPostUnSetLike(' . $id . ')" class="btn-floating btn waves-effect red z-depth-0 hoverable-z1"><i class="material-icons white-text">favorite</i></a>';

        return '
            <div id="blog-post-id-' . $id . '" class="card card-feed animated opacity-zero">
                <ul class="collection" style="overflow: visible;">
                    <li class="collection-item avatar">
                        <img src="' . $filePath . $authorImg . '" alt="' . $authorName . '" class="circle">
                        <span class="title"><a class="black-text" ajax-page="' . $authorUrl . '">' . $authorName . '</a></span>
                        <p class="grey-text text-lighten-1">' . $dateTime . '</p>
                        ' . ($canDelete ? '<a onclick="$.blogPostDelete(' . $id . ')" class="secondary-content"><i class="material-icons grey-text waves-effect">close</i></a>' : '') . '
                    </li>
                </ul>
                ' . (!empty($content) ? '<div class="card-content"><p>' . htmlspecialchars_decode(nl2br($content)) . '</p></div>' : '') . '
                ' . (!empty($image) ? '<div class="card-image"><div class="material-placeholder"><img src="' . $filePath . $image . '" class="materialboxed"></div></div>' : '') . '
                <div class="card-action">
                    <label class="valign-wrapper">
                        <div style="width: 90%; position: absolute;" class="left comment-add-container" onclick="$.blogPostShowOrHideComments(' . $id . ')">
                            <img class="left" src="' . $filePath . $userInfo['img_avatar'] . '">
                            <div class="left grey-text comment-add-label hide-on-small-and-down">Добавьте комменатрий...</div>
                        </div>
                        <div style="margin-left: auto;">
                            <span id="blog-post-like-btn-' . $id . '">' . $likeBlock . '</span>
                            <label id="blog-post-clikes-' . $id . '" style="margin-right: 16px; margin-left: 4px; ' . ($likeCount > 0 ? '' : 'display:none') . '">' . $likeCount . '</label>
                            <a onclick="$.blogPostShowOrHideComments(' . $id . ')" class="btn-floating btn waves-effect grey lighten-3 z-depth-0 hoverable-z1" style="margin-left: 4px">
                                <i class="material-icons grey-text">comment</i>
                            </a>
                            <label id="blog-post-ccomments-' . $id . '" style="margin-left: 4px; ' . ($commentsCount > 0 ? '' : 'display:none') . '">' . $commentsCount . '</label>
                        </div>
                    </label>
                </div>
                <div class="card-content" id="comments-all-' . $id . '" style="display: none">
                    <ul class="collection" id="comments-all-content-' . $id . '" style="margin-bottom: 16px; border: none;"></ul>
                    <textarea id="comment-textarea-' . $id . '" placeholder="Текст комментария..." required="" class="materialize-textarea"></textarea>
                    <button onclick="$.blogPostSendComment(' . $id . ')" class="btn z-depth-0 light-blue waves-effect">Отправить</button>
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $type
     * @param $link
     * @return string
     *
     * types
     * 0 - default unknown
     * 1 - word
     * 2 - excel
     * 3 - powerpoint
     * 4 - pdf
     */
    public function getFileBlock($name, $link = '#', $type = 0) {

        $color = 'grey';
        $icon = 'file';

        switch ($type) {
            case 1:
                $color = 'blue';
                $icon = 'file-word-box';
                break;
            case 2:
                $color = 'green';
                $icon = 'file-excel-box';
                break;
            case 3:
                $color = 'amber';
                $icon = 'file-powerpoint-box';
                break;
            case 4:
                $color = 'red';
                $icon = 'file-pdf-box';
                break;
        }

        return '
            <div class="card card-file">
                <a href="' . $link . '" download class="grey-text" title="' . htmlspecialchars_decode($name) . '">
                    <div class="shadow-block"></div>
                    <label class="' . $color . '-text">
                        <i class="mdi mdi-' . $icon . '"></i>
                    </label>
                    ' . htmlspecialchars_decode($name) . '
                </a>
            </div>
        ';
    }

    /**
     * @param $link
     * @param $img
     * @param $title
     * @param $desc
     * @return string
     */
    public function getCourseArticleBlock($link, $img, $title, $desc) {
        return '
            <div class="card card-course-news hoverable-z3">
                <a ajax-page="course-article-' . $link . '" style="display: block" class="card-image hoverable-black black">
                    <img src="' . $img . '">
                </a>
                <div class="card-content">
                    <div class="no-wrap">
                        <div class="shadow-block"></div>
                        <span title="' . $title . '">' . $title . '</span><br>
                        <label class="grey-text light no-wrap-desc">' . $desc . '</label>
                    </div>
                </div>
            </div>
        ';
    }

    /**
     * @param $timestamp
     * @param $sex
     * @return string
     */
    public function getOnlineStatusBlock($timestamp, $sex = 0) {

        global $monthN;
        global $utcOffset;
        global $server;

        $time = new Time($server);
        $sexOnline = ($sex == 2) ? 'Была' : 'Был';

        $lastOnline = $timestamp + $utcOffset;

        if ($server->timeStampNow() < $timestamp + 900)
            return '<div class="green online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Онлайн"></div>';
        else if ($time->isToday($lastOnline, $utcOffset))
            return '<div class="red online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="' . $sexOnline . ' в сети сегодня в ' . gmdate('H:i', $lastOnline) . '"></div>';
        else if ($time->isYesterday($lastOnline, $utcOffset))
            return '<div class="red online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="' . $sexOnline . ' в сети вчера в ' . gmdate('H:i', $lastOnline) . '"></div>';
        else if($timestamp + 90 * 24 * 3600 < $server->timeStampNow())
            return '<div class="red online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="' . $sexOnline . ' в сети очень давно"></div>';
        else if ($time->isThisYear($lastOnline, $utcOffset))
                return '<div class="red online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="' . $sexOnline . ' в сети ' . gmdate('d', $lastOnline) . ' ' . $monthN[gmdate('m', $lastOnline)] . ' ' . gmdate('H:i', $lastOnline) . '"></div>';

        return '<div class="red online-status z-depth-1 tooltipped" data-position="left" data-delay="50" data-tooltip="' . $sexOnline . ' в сети ' . gmdate('d', $lastOnline) . ' ' . $monthN[gmdate('m', $lastOnline)] . ' ' . gmdate('Y, H:i', $lastOnline) . '"></div>';
    }

    /**
     * @param $text
     * @param $success
     */
    public function showModal($text, $success) {
        global $modal;
        $modal['isShow'] = true;
        $modal['success'] = $success;
        $modal['text'] = $text;
    }
}