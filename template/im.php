<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $page;
global $settings;
global $server;
global $user;
global $monthN;
global $userInfo;
global $utcOffset;
global $filePath;


/*
<div class="left msg-box"><div class="msg-text blue white-text">Test</div></div>
<div class="right msg-box">
    <div class="msg-text grey lighten-3">Test</div>
    <label class="right">Прочитано</label>
</div>
 * */

$dialogList = $user->getDialogList();

?>
<ajax-title><?php echo 'Диалоги | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m4">
                <div class="card animated opacity-zero">
                    <form method="get">
                        <div class="input-field" style="margin: 0">
                            <input id="search" class="search_all" type="search" name="q" required="" style="border: none">
                            <label for="search" class="label-icon"><i class="material-icons">search</i></label>
                        </div>
                    </form>
                </div>
                <ul class="card collection animated opacity-zero" style="border: none; height: 509px; overflow: auto;">
                    <?php
                        foreach ($dialogList as $item) {

                            $userId = 0;

                            if ($item['id_from'] == $userInfo['id'])
                                $userId = $item['id_to'];
                            else
                                $userId = $item['id_from'];

                            $dialogUserInfo = $user->getInfoById($userId);
                            $lastMsg = $user->getDialogLastMsg($userId);

                            echo '
                                <li style="cursor: pointer;" onclick="$.showPage(\'im' . $dialogUserInfo['id'] . '\');" class="collection-item avatar animated opacity-zero ' . (isset($lastMsg['is_read']) && $lastMsg['is_read'] == true ? '' : 'light-blue lighten-5') . '">
                                    <a ajax-page="im' . $dialogUserInfo['id'] . '">
                                        <img src="' . $filePath . $dialogUserInfo['img_avatar'] . '" alt="' . $dialogUserInfo['name'] . ' ' . $dialogUserInfo['surname'] . '" class="circle">
                                        <span class="title black-text">' . $dialogUserInfo['name'] . ' ' . $dialogUserInfo['surname'] . '</span><br>
                                        <label>' . (isset($lastMsg['content']) ? htmlspecialchars_decode($lastMsg['content']) : '' ) . '</label>
                                    </a>
                                </li>
                            ';
                        }
                    ?>
                </ul>
            </div>
            <?php

            if (isset($page['im'])) {
                if (!empty($this->userInfo = $user->getInfoById($page['im']))) {

                    $sexOnline = ($this->userInfo['sex'] == 2) ? 'Была' : 'Был';
                    $lastOnline = $this->userInfo['last_online'] + $utcOffset;
                    $dateOnline = gmdate('d', $lastOnline) . ' ' . $monthN[gmdate('m', $lastOnline)] . ' ' . gmdate('Y, H:i', $lastOnline);

                    if ($server->timeStampNow() < $this->userInfo['last_online'] + 900)
                        $status = '<label class="blue-text">Онлайн</label>';
                    else if($this->userInfo['last_online'] + 90 * 24 * 3600 < $server->timeStampNow())
                        $status = '<label >' . $sexOnline . ' в сети очень давно</label>';
                    else
                        $status = '<label >' . $sexOnline . ' в сети ' . $dateOnline . '</label>';

                    $dialogs = '';
                    foreach ($user->getDialogsByUserId($this->userInfo['id']) as $item) {
                        if ($this->userInfo['id'] == $item['id_from'])
                            $dialogs .= '<div class="left msg-box"><div class="msg-text blue white-text">' . htmlspecialchars_decode(nl2br($item['content'])) . '</div></div>';
                        else
                            $dialogs .= '<div class="right msg-box"><div class="msg-text grey lighten-3">' . htmlspecialchars_decode(nl2br($item['content'])) . '</div><label class="right">' . ($item['is_read'] == true ? 'Прочитано' : 'Не прочитано') . '</label></div>';
                    }

                    echo '
                        <div class="col s12 m8 animated opacity-zero">
                            <div class="card msg-container-block">
                                <ul class="collection msg-profile-info">
                                    <li class="collection-item avatar msg-profile-info-content">
                                        <img src="' . $filePath . $this->userInfo['img_avatar'] . '" alt="' . $this->userInfo['name'] . ' ' . $this->userInfo['surname'] . '" class="circle">
                                        <div class="left">
                                            <a ajax-page="id' . $this->userInfo['id'] . '" class="title black-text a-hover">' . $this->userInfo['name'] . ' ' . $this->userInfo['surname'] . '</a><br>
                                            ' . $status . '
                                        </div>
                                        <a class="black-text right modal-trigger" href="#dialog-delete">
                                            <i class="material-icons grey-text" style="font-size: 1.4rem;">close</i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="msg-container" id="msg-container">
                                    ' . $dialogs . '
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content" style="padding: 8px 24px">
                                    <textarea placeholder="Текст сообщения..." id="msg-content-textarea" required="" class="materialize-textarea msg-area" user-id="' . $this->userInfo['id'] . '"></textarea>
                                </div>
                                <div class="card-action" style="height: 56px;">
                                    <a class="left modal-action waves-effect btn-flat" style="padding: 0 10px;margin: 0;"><i class="material-icons grey-text text-darken-2">photo</i></a>
                                    <a class="left modal-action waves-effect btn-flat" style="padding: 0 10px;margin: 0;"><i class="material-icons grey-text text-darken-2">videocam</i></a>
                                    <a class="left modal-action waves-effect btn-flat" style="padding: 0 10px;margin: 0;"><i class="material-icons grey-text text-darken-2">insert_drive_file</i></a>
                                    <button class="btn-flat right waves-effect light-blue" onclick="$.userDialogSendMsg();"><i class="material-icons white-text">send</i></button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="dialog-delete" class="modal">
                            <div class="modal-content">
                                <h5>Вы точно хотите удалить этот диалог?</h5>
                                <p>Внимание, диалог удалится навсегда!</p>
                            </div>
                            <form action="/im" method="post" class="modal-footer">
                                <a class="modal-action modal-close waves-effect btn-flat">Отмена</a>
                                <input type="hidden" name="id" value="' . $this->userInfo['id'] . '">
                                <button name="user-dialog-delete" class="modal-action waves-effect btn-flat red lighten-4">Удалить</button>
                            </form>
                        </div>
                    ';
                }
            }
            else {
                echo '
                    <div class="col s12 m8">
                        <div class="center animated opacity-zero error404">
                            <div class="img-block" style="width: 530px;">
                                <img class="left" src="/client/images/stickers/st5.png">
                                <div class="left margin-left">
                                    <h4 class="grey-text text-darken-2">Сообщений нет...</h4><br>
                                    <a ajax-page="friends" class="btn btn-small waves-effect">Написать кому-нибудь ;)</a>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }

            ?>
        </div>
    </div>
</div>