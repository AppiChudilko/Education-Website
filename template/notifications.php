<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $settings;
?>
<ajax-title><?php echo 'Уведомления | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12" id="blog-posts">
                <div class="center animated opacity-zero error404">
                    <div class="img-block" style="width: 530px;">
                        <img class="left" src="/client/images/stickers/st5.png">
                        <div class="left margin-left">
                            <h4 class="grey-text text-darken-2">Уведомлений нет...</h4>
                            <h6 class="grey-text">Подпишитесь на преподавателей<br>чтобы их получать</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m8" style="display: none">
                <h5 class="h-title animated opacity-zero">Уведомления</h5>
                <ul class="collection card animated opacity-zero" style="border: none;">
                    <li class="collection-item avatar animated opacity-zero">
                        <i class="material-icons circle blue">group</i>
                        <span class="title">Title</span>
                        <p>First Line</p>
                    </li>
                    <li class="collection-item avatar animated opacity-zero">
                        <i class="material-icons circle green">attach_money</i>
                        <span class="title">Title</span>
                        <p>First Line
                        </p>
                    </li>
                    <li class="collection-item avatar animated opacity-zero">
                        <i class="material-icons circle red">videocam</i>
                        <span class="title">Трансляция</span>
                        <p>Началась трансляция
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>