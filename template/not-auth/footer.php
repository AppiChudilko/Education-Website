<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
?>
</main>
<footer class="page-footer transparent">
    <div class="footer-copyright transparent">
        <div class="container grey-text">
            <div class="row">
                <div class="col s12 m4 animated fadeInUp">
                    Copyright © 2017  <a class="grey-text" target="_blank" href="https://vk.com/lo1ka">Alexander Pozharov</a>
                </div>
                <div class="col s12 m4 center-align links hide-on-small-and-down animated fadeInUp">
                    <a class="grey-text" target="_blank" href="https://vk.com/byappi">Мы в vk</a>
                    <a class="grey-text" target="_blank" href="https://about.byappi.com/">О проекте</a>
                    <a class="grey-text" href="/contacts">Обратная связь</a>
                </div>
                <div class="col s12 m4 hide-on-small-and-down animated fadeInUp">
                    <a class="grey-text right">With love <i class="material-icons red-text" style="font-size: 14px;">favorite</i></a>
                </div>
                <div class="col s12 m4 show-on-small animated fadeInUp" style="display: none">
                    <a class="grey-text">With love <i class="material-icons red-text" style="font-size: 14px;">favorite</i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--  Scripts-->
<script src="/client/js/material.js"></script>
<script src="/client/js/material-appi.js"></script>
<script src="/client/js/main.js"></script>

<?php
if($this->modal['isShow']) {
    //echo '<script type="text/javascript">$(document).ready(function(){ $("#modalInfo").openModal(); });</script>';
    echo '<script type="text/javascript">Materialize.toast(\'' . $this->modal['text'] . '\', 4000)</script>';
}
?>

</body>
</html>