<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
?>
<ajax-title>Ошибка - Создайте курс</ajax-title>
<div class="right-content container">
    <div class="row">
        <div class="col s12 center">
            <div class="center animated opacity-zero fadeInUp error404">
                <div class="img-block" style="width: 500px">
                    <img class="left" src="/client/images/404.png">
                    <div class="left margin-left">
                        <h4 class="grey-text text-darken-2">Упс...</h4>
                        <h6 class="grey-text" style="word-wrap: break-word; width: 330px">Для начала Вам нужно создать курс, чтобы выполнить это действиие</h6>
                        <br><a ajax-page="create-course" class="btn waves-effect light-blue">Создать курс</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>