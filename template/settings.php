<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
global $userInfo;
global $settings;
global $user;
global $server;
global $qb;
global $monthN;
global $utcOffset;

$qm = new \Server\QueryMethods($qb, $server);

?>
<ajax-title><?php echo 'Настройки | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 l9">
                <h5 id="section-balance" class="h-title animated opacity-zero">Баланс: <?php echo number_format($userInfo['balance']) ?> ₽</h5>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card-panel animated opacity-zero">
                            <div class="row" style="margin: 0">
                                <div class="input-field col s12">
                                    <input id="balance" type="number" class="validate">
                                    <label for="balance">Пополнить баланс</label>
                                    <button class="waves-effect right btn-flat btn-small grey lighten-4">Пополнить</button>
                                    <button class="waves-effect right btn-flat btn-small" style="margin-right: 8px">Оферта</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-panel animated opacity-zero" style="<?php echo ($user->isTeacher() ? '' : 'display: none;') ?>">
                            <div class="row" style="margin: 0">
                                <div class="input-field col s12">
                                    <input id="bank-card" type="text" class="validate">
                                    <label for="bank-card">Банковская карта</label>
                                    <button class="z-depth-0 waves-effect right btn-flat btn-small grey lighten-4">Сохранить</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-panel animated opacity-zero" style="<?php echo ($user->isTeacher() ? '' : 'display: none;') ?>">
                            <div class="row" style="margin: 0">
                                <div class="input-field col s12">
                                    <input id="balance" type="number" class="validate">
                                    <label for="balance">Заказать вывод средств</label>
                                    <button class="z-depth-0 waves-effect right btn-flat btn-small grey lighten-4">Вывести средства</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 animated opacity-zero">
                        <ul class="collection card" style="border: 0; max-height: 457px; overflow: auto">
                            <li class="collection-item avatar">
                                <i class="material-icons green circle">account_balance_wallet</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons red circle">tv</i>
                                <span class="title">- 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons blue circle">credit_card</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons green circle">account_balance_wallet</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons red circle">tv</i>
                                <span class="title">- 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons blue circle">credit_card</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons green circle">account_balance_wallet</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons red circle">tv</i>
                                <span class="title">- 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons blue circle">credit_card</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons green circle">account_balance_wallet</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons red circle">tv</i>
                                <span class="title">- 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons blue circle">credit_card</i>
                                <span class="title">+ 2,000 ₽</span>
                                <label><br>13 Января 2018, 13:43</label>
                            </li>
                        </ul>
                        <a ajax-page="balance-stats" class="btn waves-effect green" style="width: 100%; <?php echo ($user->isTeacher() ? '' : 'display: none;') ?>">Подробная статистика</a>
                    </div>
                </div>
                <br>
                <h5 id="section-account" class="h-title animated opacity-zero">Аккаунт</h5>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card-panel animated opacity-zero">
                            <form method="post" class="row" style="margin: 0">
                                <div class="input-field col s12">
                                    <input required id="password1" name="password1" type="text" class="validate">
                                    <label for="password1">Новый пароль</label>
                                </div>
                                <div class="input-field col s12">
                                    <input required id="password2" name="password2" type="text" class="validate">
                                    <label for="password2">Повторите пароль</label>
                                    <button name="user-edit-password" class="z-depth-0 waves-effect right btn-flat btn-small grey lighten-4">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card-panel animated opacity-zero">
                            <form method="post" class="row" style="margin: 0">
                                <div class="input-field col s12">
                                    <input required id="email" name="email" type="email" value="<?php echo $userInfo['email'] ?>" class="validate">
                                    <label for="email">Email</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="phone" name="phone" type="text" value="<?php echo $userInfo['phone'] ?>" class="validate">
                                    <label for="phone">Мобильный телефон</label>
                                    <button name="user-edit-email-or-phone" class="z-depth-0 waves-effect right btn-flat btn-small grey lighten-4">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <h5 id="section-security" class="h-title animated opacity-zero" style="display: none">Безопасность</h5>
                <div class="row" style="display: none">
                    <div class="col s12 m6">
                        <div class="card-panel animated opacity-zero">
                            <form method="post" class="row" style="margin: 0">
                                <div class="input-field col s12">
                                    <input required id="password1" name="password1" type="text" class="validate">
                                    <label for="password1">Пароль</label>
                                </div>
                                <div class="input-field col s12">
                                    <input required id="password2" name="password2" type="text" class="validate">
                                    <label for="password2">Повторите пароль</label>
                                    <button name="user-edit-password" class="z-depth-0 waves-effect right btn-flat btn-small grey lighten-4">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card-panel animated opacity-zero">
                            <form method="post" class="row" style="margin: 0">
                                <p>
                                    <input name="group1" type="radio" id="test1" />
                                    <label for="test1">Не запрашивтаь никогда</label>
                                </p>
                                <p>
                                    <input name="group1" type="radio" id="test2" />
                                    <label for="test2">Запрашивать только 1 раз</label>
                                </p>
                                <p>
                                    <input name="group1" type="radio" id="test3" />
                                    <label for="test3">Запрашивать каждый раз</label>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <h5 id="section-history" class="h-title animated opacity-zero">История авторизаций</h5>
                <div class="card-panel animated opacity-zero">
                    <table>
                        <tbody>
                            <?php

                                foreach ($qm->getAuthLog() as $item) {

                                    $timestamp = $item['timestamp'] + $utcOffset;
                                    $dateOnline = gmdate('d', $timestamp) . ' ' . $monthN[gmdate('m', $timestamp)] . ' ' . gmdate('Y, H:i', $timestamp);

                                    $ipInfo = json_decode(file_get_contents('http://ipinfo.io/' . $server->getClientIp()));

                                    echo '
                                        <tr>
                                            <td>' . $ipInfo->country . '</td>
                                            <td>' . $ipInfo->city . '</td>
                                            <td>' . $item['ip'] . '</td>
                                            <td>' . $dateOnline . '</td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div><br>
                <h5 id="section-blacklist" class="h-title animated opacity-zero">Черный список</h5>

                <?php

                    if (!empty($blackList = $user->getBlackList())) {
                        echo '<ul class="card collection animated opacity-zero" style="overflow: visible; border: none">';
                        foreach ($blackList as $item) {
                            echo '
                                <li class="collection-item avatar medium-item">
                                    <img src="' . $item['img_avatar'] . '" alt="" class="circle">
                                    <a ajax-page="id' . $item['id'] . '" class="title black-text">' . $item['name'] . ' ' . $item['surname'] . '</a>
                                    <p><a class="grey-text" onclick="$.userRemoveBlackList(' . $item['id'] . ')">Разблокировать</a></p>
                                </li>
                            ';
                        }
                        echo '</ul>';
                    }
                    else
                        echo '<div class="card-panel animated opacity-zero"><h5 class="center grey-text">Список пуст</h5></div>';
                ?>

            </div>
            <div class="col s12 l3 hide-on-med-and-down">
                <div class="collection animated opacity-zero" id="fixed-block" style="border: none; top: 90px; position: absolute">
                    <a href="#section-balance" class="nav-link nav-scroll collection-item">Баланс</a>
                    <a href="#section-account" class="nav-link nav-scroll collection-item">Аккаунт</a>
                    <a href="#section-history" class="nav-link nav-scroll collection-item">История авторизаций</a>
                    <a href="#section-blacklist" class="nav-link nav-scroll collection-item">Черный список</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("a.nav-scroll").click(function() {
            $("html, body").animate({
                scrollTop: ($($(this).attr("href")).offset().top - 80) + "px"
            }, {
                duration: 500,
                easing: "swing"
            });
            return false;
        });
    });
</script>