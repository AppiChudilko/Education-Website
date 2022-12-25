<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $page;
?>

</main>

<footer class="page-footer transparent right-content container" style="<?php echo ($page['p'] == 'broadcast-id') ? 'width: calc(100% - 40px);' : '' ?> z-index: 1; position: relative;">
    <div class="footer-copyright transparent">
        <div class="row grey-text" style="width: 100%">
            <div class="col s12 m4 animated fadeInUp">
                Copyright © <?php echo gmdate('Y'); ?>  <a class="grey-text" target="_blank" href="https://vk.com/lo1ka">Alexander Pozharov</a>
            </div>
            <div class="col s12 m4 animated fadeInUp center-align links hide-on-small-and-down">
                <a class="grey-text" target="_blank" href="https://vk.com/byappi">Мы в VK</a>
                <a class="grey-text" href="#">Правила сайта</a>
                <a class="grey-text dropdown-about-us" data-activates="about-us">Ещё...</a>
            </div>
            <div class="col s12 m4 animated fadeInUp hide-on-small-and-down">
                <a class="grey-text right" style="margin-right: -22px;">With love <i class="material-icons red-text" style="font-size: 14px;">favorite</i></a>
            </div>
            <div class="col s12 m4 animated fadeInUp show-on-small" style="display: none">
                <a class="grey-text">With love <i class="material-icons red-text" style="font-size: 14px;">favorite</i></a>
            </div>
        </div>
    </div>
</footer>

<ul id="about-us" class="dropdown-content z-depth-5">
    <li><a class="black-text" ajax-page="contacts">Обратная связь</a></li>
    <li><a class="black-text" ajax-page="change-log">Лог изменений</a></li>
    <li><a class="black-text" href="#">О нас</a></li>
    <li><a class="black-text" href="https://about.byappi.com" target="_blank">О проектах "Appi"</a></li>
</ul>

<!--  Scripts-->
<script src="/client/js/material.js"></script>
<script src="/client/js/material-appi.js"></script>
<script src="/client/js/main.js?v=11"></script>

<a id="scrollup1" style="display: none" class="z-depth-4 animated btn-floating btn-large waves-effect blue lighten-1"><i class="material-icons white-text" style="font-size: 56px;">keyboard_arrow_up</i></a>

<?php
if($this->modal['isShow']) {
    //echo '<script type="text/javascript">$(document).ready(function(){ $("#modalInfo").openModal(); });</script>';
    echo '<script type="text/javascript">Materialize.toast(\'' . $this->modal['text'] . '\', 4000)</script>';
}

if (isset($_SESSION['isShowReadme'])) { //TODO заполнить

    echo '
        <div id="modal-readme" class="modal modal-fixed-footer modal-help">
            <div class="modal-content" style="padding: 0">
                <div class="carousel carousel-slider center">
                    <div class="carousel-item blue white-text" href="#one!">
                        <div class="content">
                            <h2>Кто мы?</h2>
                            <p class="white-text light">
                            Для учеников<br>
                            Партренская образовательая сеть, которая поможет Вам найти подходящего преподавателя для обучения в любой области!
                            </p><br>
                            <p class="white-text light">
                            Для преподавателей<br>
                            Партренская образовательая сеть, которая поможет Вам найти подходящего ученика для обучения в любой области!
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item amber white-text" href="#two!">
                        <div class="content">
                            <h2>Для чего?</h2>
                            <p class="white-text">This is your first panel</p>
                        </div>
                    </div>
                    <div class="carousel-item green white-text" href="#three!">
                        <div class="content">
                            <h2>Гарантии</h2>
                            <p class="white-text">This is your first panel</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="left modal-action modal-close waves-effect btn-flat ">Закрыть</a>
                <a onclick="$(\'.carousel\').carousel(\'next\');" class="modal-action waves-effect btn-flat ">Далее</a>
            </div>
        </div>
    
        <script>
            $(document).ready(function() {
                $(\'#modal-readme\').modal(\'open\');
                setTimeout(function () {
                    $(\'.carousel.carousel-slider\').carousel({fullWidth: true})
                }, 1500);
            });
        </script>
            
    ';

    unset($_SESSION['isShowReadme']);
}

?>

</body>
</html>