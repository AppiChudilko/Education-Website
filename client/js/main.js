var $document = $(document);
var $window = $(window);
var $page = 0;

var pageError404 = '<div class="right-content container"><div class="row"><div class="col s12 center"><div class="center animated opacity-zero fadeInUp error404"><div class="img-block"><img class="left" src="/client/images/404.png"><div class="left margin-left"><h4 class="grey-text text-darken-2">Error 404</h4><h6 class="grey-text">Псс... Что вы тут забыли?</h6></div></div></div></div></div></div>';
var timeOut;
var files;

$document.ready(function() {

    var user = getCookie('ap_u');
    //if (user) { $.checkNotification(); }

    $("nav #hover-black").hover(
        function() {
            $("nav #hover-black").attr("style", "color: rgba(0, 0, 0, 0.3) !important");
            $(this).attr("style", "color: #000 !important");
        },
        function() {
            $("nav #hover-black").attr("style", "color: #000 !important");
        }
    );

    $('.dropdown-button-notif').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false,
            hover: false,
            gutter: 0,
            belowOrigin: false,
            alignment: 'left',
            stopPropagation: false
        }
    );

    $('.dropdown-btn').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false,
            hover: false,
            gutter: 39,
            belowOrigin: false,
            alignment: 'left',
            stopPropagation: false
        }
    );

    $('.dropdown-about-us').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false,
            hover: false,
            gutter: 0,
            belowOrigin: false,
            alignment: 'left',
            stopPropagation: false
        }
    );

    $('#notif-more-btn').width($('#notif-menu').width());

    $('body').on('click', 'a', function(){
        if($(this).attr('ajax-page') != undefined) {
            $.showPage($(this).attr('ajax-page'));
        }
    });

    $('#email-register').focusout(function() {
        $.checkEmail($(this));
    });

    $('#name-register').keyup(function() {
        $(this).val($(this).val().match(/[a-zA-Zа-яА-Я]/gui).join('')); //TODO все кроме символов
    });

    $.showMain();
});

$window.scroll(function() {
    //$.buttonCheckScroll();
    $.fixedBlockCheckScroll();
});

$window.bind("popstate", function () {
    var $pathname = location.pathname.replace('/', '');
    $.showPage(($pathname != '') ? $pathname : 'index', true);
});

$.showMain = function() {

    $('.button-collapse').sideNav();
    $('.carousel.carousel-slider').carousel({fullWidth: true});
    $('.tooltipped').tooltip({delay: 50});
    $('.modal').modal();
    $('.materialboxed').materialbox();
    $('select').material_select();

    $('.timepicker').pickatime({
        default: 'now', // Set default time: 'now', '1:30AM', '16:30'
        fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Очистить', // text for clear-button
        canceltext: 'Отменить', // Text for cancel-button
        autoclose: false, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
        aftershow: function(){} //Function for after opening timepicker
    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Сегодня',
        clear: 'Очистить',
        close: 'Ok',
        closeOnSelect: false // Close upon selecting a date,
    });

    $('#name').keyup(function() {
        $(this).val($(this).val().match(/[a-zA-Zа-яА-Я]/gui).join(''));
    });

    $('#surname').keyup(function() {
        $(this).val($(this).val().match(/[a-zA-Zа-яА-Я]/gui).join(''));
    });

    $('#country').keyup(function() {
        $(this).val($(this).val().match(/[a-zA-Zа-яА-Я]/gui).join(''));
    });

    $('#city').keyup(function() {
        $(this).val($(this).val().match(/[a-zA-Zа-яА-Я]/gui).join(''));
    });

    $("#upload-profile-bg-btn").click(function() {
        $("#upload-profile-bg-input").click();
    });

    $("#upload-profile-ava-btn").click(function() {
        $("#upload-profile-ava-input").click();
    });

    $("#upload-img-blog-btn").click(function() {
        $("#upload-img-blog-input").click();
    });

    $("#upload-course-file").click(function() {
        $("#upload-course-file-input").click();
    });

    $("#upload-course-video").click(function() {
        $("#upload-course-video-input").click();
    });

    $('#upload-profile-ava-input').change(function () {
        $.uploadImage(this, 'upload-image-av');
    });

    $('#upload-profile-bg-input').change(function () {
        $.uploadImage(this, 'upload-image-bg');
    });

    $('#upload-img-blog-input').change(function () {
        $.uploadImage(this, 'upload-image-blog');
    });

    $('#upload-course-file-input').change(function () {
        $.uploadFile(this, 'upload-course-file');
    });

    $('#upload-course-video-input').change(function () {
        $.uploadFile(this, 'upload-course-video');
    });

    $('#msg-content-textarea').keypress(function (e) {
        if (e.which == 13) {
            $.userDialogSendMsg();
            return false;    //<---- Add this line
        }
    });

    $.downScrollMsg();

    $('main .animated').each(function( index ) {
        (function(that, i) {
            var t = setTimeout(function() {
                $(that).removeClass('fadeOutDown');
                $(that).removeClass('opacity-zero');
                $(that).addClass('fadeInUp');
            }, 50 * i);
        })(this, index);
    });

    //Костыль для того, чтобы z-index работал корректно.
    timeOut = setTimeout(function () {
        $('main .animated').each(function( index ) {
            $(this).removeClass('fadeInUp');
        });
    }, 3000);
};

$.hideMain = function() {

    clearTimeout(timeOut);

    $($('main .animated').get().reverse()).each(function( index ) {
        (function(that, i) {
            var t = setTimeout(function() {
                $(that).removeClass('fadeInUp');
                $(that).addClass('fadeOutDown');
            }, 25 * i);
        })(this, index);
    });
};

$.showPreloader = function() {
    $('#preloader').removeClass('fadeOut');
    $('#preloader').addClass('fadeIn');
};

$.hidePreloader = function() {
    $('#preloader').removeClass('fadeIn');
    $('#preloader').addClass('fadeOut');
};

$.fixedBlockCheckScroll = function() {
    if ($document.scrollTop() > 30 ) {
        $('#fixed-block').css('position', 'fixed');
        $('#fixed-block').css('top', '60px');
    } else {
        $('#fixed-block').css('position', 'absolute');
        $('#fixed-block').css('top', '90px');
    }
};

$.showPage = function($page, $isRepeat){

    if((($page === 'index') ? '/' : '/' + $page) == location.pathname && $isRepeat !== true)
        return false;

    $.hideMain();
    $.showPreloader();

    if($isRepeat !== true)
        window.history.pushState('Appi', 'Appi - РЈРјРЅС‹Р№ Р¶СѓСЂРЅР°Р» | ' + $page, ($page === 'index') ? '/' : '/' + $page);

    $('html, body').animate({scrollTop: 0}, '500', 'swing');
    $('.button-collapse').sideNav('hide');

    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=show-page&page=' + $page,
        success: function(data) {
            setTimeout(function () {
                $('main').html(data);
                $('title').text($('ajax-title').text());
                $.hidePreloader();
                $.showMain();

                if ($('.side-nav').hasClass('slide-nav-small')) {
                    $('.side-nav').removeClass('slide-nav-small');
                    $('footer').removeAttr('style');
                }

                Materialize.updateTextFields();


                $('.dropdown-btn').dropdown({
                        inDuration: 300,
                        outDuration: 225,
                        constrainWidth: false,
                        hover: false,
                        gutter: 39,
                        belowOrigin: false,
                        alignment: 'left',
                        stopPropagation: false
                    }
                );
                //$('script').each(function (index, element) { eval(element.innerHTML); });
            }, $('.animated').length * 50);
        },
        error: function () {
            setTimeout(function (jqXHR, textStatus, errorThrown) {
                $('main').html(pageError404);
                //$('main').html(pageError404 + '<div class="black-text"><br><hr>' + jqXHR + '<br><hr>' + textStatus + '<br><hr>' + errorThrown + '</div>');
                $('title').text($('ajax-title').text());
                $.hidePreloader();
                $.showMain();
            }, $('.animated').length * 50);
        }
    });
};

$.checkEmail = function($email){
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=validate-email&email=' + $email.val(),
        success: function(data) {
            if (data.success === true) {
                $email.css('borderBottom', '1px solid #53ea93');
                $email.css('box-shadow', '0 1px 0 0 #53ea93');
            }
            else {
                $email.css('borderBottom', '1px solid #ff8479');
                $email.css('box-shadow', '0 1px 0 0 #ff8479');
            }
        }
    });
};

$.buttonScroll = function() {
    $('#scrollup').click( function() {
        $('html, body').animate({scrollTop: 0}, '500', 'swing');
        return false;
    });
};

$.buttonCheckScroll = function() {
    if ($document.scrollTop() > 100 ) {
        $('#scrollup').css('opacity', 1);
        $('#scrollup').removeClass('bounceOutDown');
        $('#scrollup').addClass('bounceInUp');
    } else {
        $('#scrollup').removeClass('bounceInUp');
        $('#scrollup').addClass('bounceOutDown');
    }
};

$.uploadImage = function ($images, $action) {

    $('#blog-attaches').hide('fast');
    $('#blog-preloader').show('fast');

    files = $images.files;

    event.stopPropagation();
    event.preventDefault();

    var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });

    data.append('ajax', true);
    data.append('action', $action);

    $.ajax({
        url: '/ajax.php',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(respond, textStatus, jqXHR) {
            if( typeof respond.error === 'undefined' ) {

                if (typeof respond.success === 'undefined')
                    Materialize.toast('Картинка успешно загружена', 2000);
                else
                    Materialize.toast(respond.success.message, 2000);

                switch ($action) {
                    case 'upload-image-av':
                    case 'upload-image-bg':
                        setTimeout(function () { location.reload(); }, 2000);
                        break;
                    case 'upload-image-blog':
                        $('#blog-preloader').hide('fast');
                        $('#blog-temp-imgname').val(respond.success.files.files[0]);
                        $('#blog-attaches').show('fast');
                        break;
                }
            }
            else {
                console.log('Ошибка сервера: ' + respond.error);
                Materialize.toast('Ошибка сервера: ' + respond.error, 4000);
            }
        },
        error: function(e, textStatus, errorThrown) {
            console.log('Ошибка Ajax: ' + textStatus);
            console.log('Ошибка Ajax: ' + errorThrown);
            console.log('Ошибка Ajax: ' + e);
            Materialize.toast('Ошибка ответа сервера', 4000);
        }
    });
};

$.uploadFile = function ($files, $action) {

    $('#blog-attaches').hide('fast');
    $('#blog-preloader').show('fast');

    files = $files.files;

    event.stopPropagation();
    event.preventDefault();

    var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });

    data.append('ajax', true);
    data.append('action', $action);

    $.ajax({
        url: '/ajax.php',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(respond) {
            if( typeof respond.error === 'undefined' ) {

                if (typeof respond.success === 'undefined')
                    Materialize.toast('Файл успешно загружен', 2000);
                else
                    Materialize.toast(respond.success.message, 2000);

                switch ($action) {
                    case 'upload-course-file':
                        $.showPage('file-list-edit-' + respond.success.id);
                        break;
                    case 'upload-course-video':
                        $.showPage('video-edit-' + respond.success.id);
                        break;
                }
            }
            else {
                console.log('Ошибка сервера: ' + respond.error);
                Materialize.toast('Ошибка сервера: ' + respond.error, 4000);

                console.log(respond);
            }
        },
        error: function(data) {
            console.log(data);
            Materialize.toast('Ошибка ответа сервера', 4000);
        }
    });
};

$.closeReadme = function() {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=close-readme'
    });
};

$.blogPostSend = function() {

    if ($('#blog-temp-imgname').val() == '' && $('#blog-new-text').val() == '')
        Materialize.toast('Загрузите фото или напишите текст', 4000);

    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=blog-post-send&image_name=' + $('#blog-temp-imgname').val() + '&content=' + $('#blog-new-text').val(),
        success: function(data) {

            if (data.success == true) {
                $('#blog-temp-imgname').val('');
                $('#blog-new-text').val('');

                $('#blog-preloader').hide('fast');
                $('#blog-attaches').hide('fast');

                $.ajax({
                    type: 'POST',
                    url: '/ajax.php',
                    data: 'ajax=true&action=get-last-user-blog-post',
                    success: function(post) {
                        $('#blog-posts').html(post + $('#blog-posts').html());
                        $('.opacity-zero').removeClass('opacity-zero');
                        $('.materialboxed').materialbox();
                        Materialize.toast('Пост в ваш блог был опубликован', 4000);

                    }
                });
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.blogPostDelete = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=blog-post-delete&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                var $post = $('#blog-post-id-' + $id);
                $post.addClass('animated fadeOutDown');
                setTimeout( function () {
                        $post.animate({
                            height: 0
                        }, 600, function() {
                            $post.remove();
                        });
                    }
                    , 300
                );
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.friendSendRequest = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=friend-send-request&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Заявка была отправлена', 3000);
                $('#friend-action').html('<a onclick="$.friendUnSendRequest(' + $id + ')" class="black-text">Отписаться</a>');
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.friendUnSendRequest = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=friend-unsend-request&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Вы отписались от данного пользователя', 3000);
                $('#friend-action').html('<a onclick="$.friendSendRequest(' + $id + ')" class="black-text">Добавить в друзья</a>');
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.friendAcceptRequest = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=friend-accept-request&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Вы добавили в друзья данного пользователя', 3000);
                $('#friend-action').html('<a onclick="$.friendDeleteRequest(' + $id + ')" class="black-text">Удалить из друзей</a>');
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.friendDeleteRequest = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=friend-delete-request&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Вы удалили из друзей данного пользователя', 3000);
                $('#friend-action').html('<a onclick="$.friendAcceptRequest(' + $id + ')" class="black-text">Принять запрос</a>');
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.blogPostSetLike = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=blog-post-set-like&id=' + $id,
        success: function(data) {
            if (data.success === true) {

                var $countLikes = $('#blog-post-clikes-' + $id);
                if (parseInt($countLikes.text()) < 1)
                    $countLikes.show('fast');
                $countLikes.text(parseInt($countLikes.text()) + 1);

                setTimeout(function () {
                    $('#blog-post-like-btn-' + $id).html('<a onclick="$.blogPostUnSetLike(' + $id + ')" class="btn-floating btn waves-effect red z-depth-0 hoverable-z1"><i class="material-icons white-text">favorite</i></a>');
                }, 310);
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.blogPostUnSetLike = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=blog-post-unset-like&id=' + $id,
        success: function(data) {
            if (data.success === true) {

                var $countLikes = $('#blog-post-clikes-' + $id);
                $countLikes.text(parseInt($countLikes.text()) - 1);
                if (parseInt($countLikes.text()) < 1)
                    $countLikes.hide('fast');

                setTimeout(function () {
                    $('#blog-post-like-btn-' + $id).html('<a onclick="$.blogPostSetLike(' + $id + ')" class="btn-floating btn waves-effect waves-red grey lighten-3 z-depth-0 hoverable-z1"><i class="material-icons grey-text">favorite</i></a>');
                }, 350);
            }
            else {
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.blogPostShowOrHideComments = function($id) {

    var $commentBlockAll = $('#comments-all-' + $id);
    var $preloaderBlock = '<div class="preloader-wrapper active" style="left: calc(50% - 35px);"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';

    if ($commentBlockAll.is(":visible")) {
        $commentBlockAll.hide('fast');
        $('#comments-all-content-' + $id).html('');
    }
    else {
        $commentBlockAll.show('fast');
        $('#comments-all-content-' + $id).html($preloaderBlock);

        $.ajax({
            type: 'POST',
            url: '/ajax.php',
            data: 'ajax=true&action=blog-post-get-comments&id=' + $id,
            success: function(data) {
                $('#comments-all-content-' + $id).html(data);
            },
            error: function () {
                $('#comments-all-content-' + $id).html('');
                Materialize.toast('Произошла ошибка ответа сервера', 2000);
            }
        });
    }
};

$.blogPostSendComment = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=blog-post-send-comment&id=' + $id + '&content=' + $('#comment-textarea-' + $id).val(),
        success: function(data) {
            $('#comments-all-content-' + $id).html($('#comments-all-content-' + $id).html() + data);
            $('#comment-textarea-' + $id).val('');
        },
        error: function (data) {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.blogPostDeleteComment = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=blog-post-delete-comment&id=' + $id + '&content=' + $('#comment-textarea-' + $id).val(),
        success: function(data) {
            if (data.success === true) {
                $('#blog-post-comment-id-' + $id).hide('fast');

                setTimeout(function () {
                    $('#blog-post-comment-id-' + $id).remove()
                }, 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.userDialogSendMsg = function() {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=user-dialog-send-msg&id=' + $('#msg-content-textarea').attr('user-id') + '&content=' + $('#msg-content-textarea').val(),
        success: function(data) {
            if (data.success === true) {
                $('.msg-container').html($('.msg-container').html() + '<div class="right msg-box"> <div class="msg-text grey lighten-3">' + $.nl2br($('#msg-content-textarea').val()) + '</div><label class="right">Не прочитано</label></div>');
                $('#msg-content-textarea').val('');
                $.downScrollMsg();
                return;
            }
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        },
        error: function (data) {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.userAddBlackList = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=user-add-blacklist&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Пользователь был добавлен в черный список', 2000);
                $('#blacklist-button').html('<a class="green-text" onclick="$.userRemoveBlackList(' + $id + ')">Разблокировать</a>');
                return;
            }
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        },
        error: function (data) {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.userRemoveBlackList = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=user-remove-blacklist&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Пользователь был удалён из черного списка', 2000);
                $('#blacklist-button').html('<a class="red-text" onclick="$.userAddBlackList(' + $id + ')">Заблокировать</a>');
                return;
            }
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        },
        error: function (data) {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.courseLike = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=course-set-like&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Вам понравился курс', 2000);
            }
            else {
                Materialize.toast('Вы уже ставили оценку этому курсу', 2000);
            }
        },
        error: function (data) {
            console.log(data);
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.courseDisLike = function($id) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=course-set-dislike&id=' + $id,
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Вам не понравился курс', 2000);
            }
            else {
                Materialize.toast('Вы уже ставили оценку этому курсу', 2000);
            }
        },
        error: function () {
            Materialize.toast('Произошла ошибка ответа сервера', 2000);
        }
    });
};

$.downScrollMsg = function () {
    var wrapp = document.getElementById('msg-container');

    if (wrapp != undefined)
        wrapp.scrollTop = wrapp.scrollHeight;
};

//TODO костыль вместо лонгпулла, впадлу делать, потом сделаю

$.checkNotification = function() {
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: 'ajax=true&action=check-notification',
        success: function(data) {
            if (data.success === true) {
                Materialize.toast('Вам не понравился курс', 2000);
            }
            else {
                Materialize.toast('Вы уже ставили оценку этому курсу', 2000);
            }

            setTimeout(function () { $.checkNotification(); }, 5000);
        },
        error: function () {
            setTimeout(function () { $.checkNotification(); }, 30000);
        }
    });
};


/*

$.checkNotification = function() {

    if (getCookie('ap_u')) {
        $.ajax(
            {
                type: 'GET',
                dataType: 'json',
                url: '/longpoll.php',
                data: {'token' : getCookie('ap_u')},
                success: function(data) {

                    console.log(data);

                    if (data.Friends != 0) {
                        console.log(data);
                        //Materialize.toast('Test', 2000);

                         var $toastContent = $('<span>У вас новая заявка в друзья</span>');
                         Materialize.toast($toastContent, 5000);
                         //$.openModalNotification();

                         var audio = new Audio();
                         audio.src = '/views/sound/notif.mp3';
                         audio.autoplay = true;

                    }

                    if (data.Message != 0) {
                        if($('*').is('#msgs')) {

                            if (window.location.pathname.match(/\d*[0-9]/) == data.Message.id) {
                                $messageTo = '<div class="dialog_msg_to">' + data.Message.text + '</div>';
                                $('#msgs').html($('#msgs').html() + $.nl2br($messageTo));
                                $.downScrollMsg();
                            }
                        }

                        var count = $('.nav_mobile .count_feed').text();
                         $('.nav_mobile .count_feed').text(++count);
                         $('.nav_mobile .count_feed').show('fast');

                        var $toastContent = $('<span>' + data.Message.name + ' - прислал вам личное сообщение</span>');
                        Materialize.toast($toastContent, 5000);

                        var audio = new Audio();
                        //audio.src = '/views/sound/notif.mp3';
                        //audio.autoplay = true;
                    }
                    $.checkNotification();
                },
                error: function (data) {
                    Materialize.toast('Произошла ошибка подключения к серверу', 2000);
                    console.log(data);
                    //setTimeout(function () { $.checkNotification(); }, 10000);
                }
            }
        );
    }
};
*/