<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
?>

<div class="blue darken-1 main-panel">
    <div class="hide-on-small-and-down" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 810" preserveAspectRatio="xMinYMin slice" aria-hidden="true">
            <path class="fill light-blue lighten-2" fill="#fbfbfc" d="M153.89 0H0v809.5h415.57C345.477 500.938 240.884 211.874 153.89 0z"></path>
            <path class="fill light-blue lighten-1" fill="#f7f7f7" d="M153.89 0c74.094 180.678 161.088 417.448 228.483 674.517C449.67 506.337 527.063 279.465 592.56 0H153.89z"></path>
            <path class="fill light-blue" fill="#f6f6f6" d="M545.962 183.777c-53.796 196.576-111.592 361.156-163.49 490.74 11.7 44.494 22.8 89.49 33.1 134.883h404.07c-71.294-258.468-185.586-483.84-273.68-625.623z"></path>
            <path class="fill light-blue darken-1" fill="#efefee" d="M592.66 0c-15 64.092-30.7 125.285-46.598 183.777C634.056 325.56 748.348 550.932 819.642 809.5h419.672C1184.518 593.727 1083.124 290.064 902.637 0H592.66z"></path>
            <path class="fill light-blue darken-2" fill="#ebebec" d="M1144.22 501.538c52.596-134.583 101.492-290.964 134.09-463.343 1.2-6.1 2.3-12.298 3.4-18.497 0-.2.1-.4.1-.6 1.1-6.3 2.3-12.7 3.4-19.098H902.536c105.293 169.28 183.688 343.158 241.684 501.638v-.1z"></path>
            <path class="fill light-blue darken-3" fill="#e7e7e7" d="M1278.31,38.196C1245.81,209.874 1197.22,365.556 1144.82,499.838L1144.82,503.638C1185.82,615.924 1216.41,720.211 1239.11,809.6L1439.7,810L1439.7,256.768C1379.4,158.78 1321.41,86.288 1278.31,38.195L1278.31,38.196z"></path>
            <path class="fill light-blue darken-4" fill="#e1e1e1" d="M1285.31 0c-2.2 12.798-4.5 25.597-6.9 38.195C1321.507 86.39 1379.603 158.98 1440 257.168V0h-154.69z"></path>
        </svg>
    </div>
</div>

<div class="container login-container">
    <div class="section">
        <div class="row">
            <div class="col s12 xl5 animated opacity-zero">
                <div class="card" id="login-form" style="height: 352px; overflow: hidden">
                    <div class="card-image light-blue white-text" style="height: 80px;">
                        <span onclick="$('#login-form').height(596);" style="background: none;" class="card-title activator white-text">Авторизация</span>
                        <a onclick="$('#login-form').height(596);" class="activator btn-floating halfway-fab waves-effect waves-light light-blue lighten-1"><i class="material-icons white-text">add</i></a>
                    </div>
                    <div class="card-content">
                        <form action="/login" method="post" class="row">
                            <div class="input-field col s12">
                                <input id="email-or-login" name="login" type="email" class="validate">
                                <label for="email-or-login" class="active">Email</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="password" name="password" type="password" class="validate">
                                <label for="password" class="active">Пароль</label>
                            </div>
                            <div class="input-field col s12">
                                <button class="z-depth-0 right btn waves-effect waves-light light-blue lighten-1 white-text" type="submit" name="user-login">
                                    Войти
                                </button>
                                <a style="margin-right: 16px" class="hide-on-small-and-down z-depth-0 right btn waves-effect waves-light light-blue lighten-1 white-text activator" onclick="$('#login-form').height(596);">
                                    Регистрация
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="card-reveal" style="padding: 0; overflow: auto">
                        <div class="light-blue white-text reg-title">
                            <span onclick="$('#login-form').height(352);" style="background: none;" class="card-title">Регистрация<a class="right" style="margin-top: 5px;"><i class="material-icons white-text">close</i></a></span>
                        </div>
                        <ul class="tabs light-blue">
                            <li class="tab" style="width: 49%"><a class="white-text active" href="#tab1">Ученик</a></li>
                            <li class="tab" style="width: 49%"><a class="white-text" href="#tab2">Преподаватель</a></li>
                        </ul>
                        <div style="padding: 24px;">
                            <form action="/login" method="post" class="row">
                                <div class="input-field col s12">
                                    <input id="name-register" required maxlength="32" name="name" type="text" class="validate">
                                    <label for="name-register">Имя</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="email-register" required maxlength="128" name="email" type="email" class="validate">
                                    <label for="email-register">Email</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="password1" required name="password1" type="password" class="validate">
                                    <label for="password1">Пароль</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="password2" required name="password2" type="password" class="validate">
                                    <label for="password2">Повторите пароль</label>
                                </div>
                                <div class="col s12">
                                    <input type="checkbox" required name="accept-lic" id="accept-lic" />
                                    <label for="accept-lic">Согласен с правилами сайта</label>
                                </div>

                                <div id="tab1" class="input-field col s12">
                                    <button class="z-depth-0 right btn waves-effect waves-light light-blue lighten-1 white-text" type="submit" name="user-reg-type-0">
                                        Регистрация
                                    </button>
                                </div>

                                <div id="tab2" class="input-field col s12">
                                    <button class="z-depth-0 right btn waves-effect waves-light light-blue lighten-1 white-text" type="submit" name="user-reg-type-1">
                                        Регистрация
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s1 hide-on-small-and-down"></div>
            <div class="col s12 xl6 hide-on-small-and-down animated opacity-zero">
                <h5 class="white-text">Добро пожаловать!</h5><br>
                <label class="white-text" style="font-size: 1rem">
                    <div id="client">
                        Для ученика:
                        <br>— Выбирайте преподавателя который Вам по душе
                        <br>— Просмотр курсов в любое время и в любой точке мира
                        <br>— Не устроил преподаватель? Мы вернем Вам деньги
                        <br>— Получение сертификата в любую минуту по вашему требованию
                    </div><br>
                    <div id="teacher">
                        Для преподавателя:
                        <br>— Сколько вы хотите зарабатывать в месяц — решайте сами
                        <br>— Не тратьте время на поиски клиентов, они появятся автоматически
                        <br>— Вы получите деньги уже в первый день работы
                        <br>— От регистрации до первого клиента — несколько минут
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>