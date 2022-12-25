<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $settings;
?>
<ajax-title><?php echo 'Не доступно | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12" id="blog-posts">
                <div class="center animated opacity-zero fadeInUp error404">
                    <div class="img-block" style="width: 100%;">
                        <img class="left" src="/client/images/stickers/st4.png">
                        <div class="left margin-left">
                            <h4 class="grey-text text-darken-2">Не доступно</h4>
                            <h6 class="grey-text">К сожалению данный пользователь внёс вас в черный список, сожалеем</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>