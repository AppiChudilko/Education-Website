<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;

?>
<ajax-title><?php echo 'Сертификат | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8">
                <div class="card-panel center">
                    <img width="90px" src="https://appi-rp.com/images/logoBig.png">
                    <h4>
                        СЕРТИФИКАТ
                    </h4>
                    <div class="grey-text">
                        Пожаров Александр Владимирович<br>
                        Прослушал 74ч. курса обучения "PHP"
                    </div>
                    <br>
                    <div class="row">
                        <div class="col s6 left-align">
                            <label>
                                Руководитель проекта<br>
                                Пожаров А.В.
                            </label>
                        </div>
                        <div class="col s6">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>