<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $userInfo;
global $settings;

?>
<ajax-title><?php echo 'Обратная связь | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 l6">
                <h5 class="h-title animated opacity-zero">Обратная связь</h5>
                <div class="card-panel animated opacity-zero">
                    <form method="post">
                        <div class="row">
                            <div class="input-field col s12">
                                <input required="" value="<?php echo $userInfo['email'] ?>" name="email" type="email" class="validate">
                                <label for="email">Ваш емайл</label>
                            </div>
                            <div class="input-field col s12">
                                <input required="" id="title" name="title" type="text" class="validate">
                                <label for="title" class="active">Тема сообщения</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mode_edit</i>
                                <textarea name="content" required="" class="materialize-textarea"></textarea>
                                <label for="icon_prefix2">Текст сообщения</label>
                                <button name="feedback-send" class="light-blue z-depth-0 btn right">Отправить</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="center">
                        <h4 class="grey-text">
                            <a href="#" class="grey-text"><i class="mdi mdi-vk-box"></i></a>
                            <a href="#" class="grey-text"><i class="mdi mdi-facebook-box"></i></a>
                            <a href="#" class="grey-text"><i class="mdi mdi-twitter-box"></i></a>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col s12 l6">
            </div>
        </div>
    </div>
</div>