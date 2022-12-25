<?php

namespace Server\Manager;

use Server\Course;
use Server\Files;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

/**
 * Request
 */
class RequestManager
{
    public function checkRequests() {

        global $blocks;
        global $user;

        if(!empty($_POST)) {
            if (isset($_POST['user-reg-type-0']) || isset($_POST['user-reg-type-1'])) {

                if (isset($_POST['accept-lic'])) {
                    $success = $user->register($_POST['name'], $_POST['email'], isset($_POST['user-reg-type-1']) ? 1 : 0, $_POST['password1'], $_POST['password2']);

                    switch ($success) {
                        case 0:
                            $blocks->showModal('Вы успешно зарегестрировались', true);
                            if ($user->authorization($_POST['email'], $_POST['password1']))
                                header('Location: /news');
                            break;
                        case 1:
                            $blocks->showModal('Пароли не совпадают', false);
                            break;
                        case 2:
                            $blocks->showModal('Данный Email уже зарегестрирован', false);
                            break;
                        case 3:
                            $blocks->showModal('Произошла ошибка сервера, попробуйте позже', false);
                            break;
                    }
                }
                else
                    $blocks->showModal('Ваш аккаунт не был зарегестрирован, вы должны быть согласны с правилами сайта', false);
            }

            else if (isset($_POST['user-login'])) {
                if ($user->authorization($_POST['login'], $_POST['password']))
                    header('Location: /news');
                else
                    $blocks->showModal('Неверно введён логин или пароль', false);
            }

            else if (isset($_POST['user-dialog-delete'])) {
                if ($user->deleteDialog($_POST['id']))
                    $blocks->showModal('Диалог был удалён', true);
                else
                    $blocks->showModal('Ошибка удаления диалога', false);
            }

            else if (isset($_POST['feedback-send'])) {
                if ($user->sendFeedback($_POST['title'], $_POST['content'], $_POST['email']))
                    $blocks->showModal('Ваше обращение было отправлено', true);
                else
                    $blocks->showModal('Ошибка отправки обращения, попробуйте снова', false);
            }

            else if (isset($_POST['user-edit-password'])) {
                if ($user->editPassword($_POST['password1'], $_POST['password2']))
                    $blocks->showModal('Пароль успешно изменён', true);
                else
                    $blocks->showModal('Пароли не совпадают', false);
            }

            else if (isset($_POST['user-edit-email-or-phone'])) {
                if ($user->editEmailAndPhone($_POST['email'], $_POST['phone']))
                    $blocks->showModal('Информация была обновлена', true);
                else
                    $blocks->showModal('Данный Email занят или произошла ошибка введения данных', false);
            }

            else if (isset($_POST['user-course-create-article'])) {
                $files = new Files();
                $fileResult = $files->uploadImage(md5(time() + rand(0, 9999)), '/upload/articles/');

                if (isset($fileResult['files']) && isset($fileResult['files'][0])) {

                    $fileName = '/upload/articles/' . $fileResult['files'][0];

                    global $server;
                    global $qb;
                    $course = new Course($qb, $server);

                    if ($course->addArticle($_POST['title'], $_POST['content'], $fileName, $_POST['course']))
                        $blocks->showModal('Статья была успешно опубликована', true);
                    else
                        $blocks->showModal('Ошибка создания статьи, попробуйте снова', false);
                }
                else
                    $blocks->showModal('Ошибка загрузки картинки, попробуйте другую', false);

            }

            else if (isset($_POST['user-course-edit-article'])) {

                if ($_FILES['img']['size'] > 1) {
                    $files = new Files();
                    $fileResult = $files->uploadImage(md5(time() + rand(0, 9999)), '/upload/articles/');

                    if (isset($fileResult['files']) && isset($fileResult['files'][0])) {

                        $fileName = '/upload/articles/' . $fileResult['files'][0];

                        global $server;
                        global $qb;
                        $course = new Course($qb, $server);

                        if ($course->editArticle($_POST['id'], $_POST['title'], $_POST['content'], $_POST['course'], $fileName))
                            $blocks->showModal('Статья была успешно отредактирована', true);
                        else
                            $blocks->showModal('Ошибка создания статьи, попробуйте снова', false);
                    }
                    else
                        $blocks->showModal('Ошибка загрузки картинки, попробуйте другую', false);
                }
                else {

                    global $server;
                    global $qb;
                    $course = new Course($qb, $server);

                    if ($course->editArticle($_POST['id'], $_POST['title'], $_POST['content'], $_POST['course']))
                        $blocks->showModal('Статья была успешно отредактирована', true);
                    else
                        $blocks->showModal('Ошибка редактирования статьи, попробуйте снова', false);
                }
            }

            else if (isset($_POST['user-course-article-delete'])) {

                global $server;
                global $qb;
                $course = new Course($qb, $server);

                if ($course->deleteArticle($_POST['id']))
                    $blocks->showModal('Статья была успешно удалёна', true);
                else
                    $blocks->showModal('Ошибка удаления статьи', false);
            }

            else if (isset($_POST['user-course-file-edit'])) {

                if ($user->editCourseFile($_POST['id'], $_POST['title'], $_POST['course']))
                    $blocks->showModal('Файл был успешно отредактирован', true);
                else
                    $blocks->showModal('Ошибка редактирования файла, попробуйте снова', false);
            }

            else if (isset($_POST['user-course-file-delete'])) {

                if ($user->deleteCourseFile($_POST['id']))
                    $blocks->showModal('Файл был успешно удалён', true);
                else
                    $blocks->showModal('Ошибка удаления файла', false);
            }

            else if (isset($_POST['user-course-video-edit'])) {

                if ($user->editCourseVideo($_POST['id'], $_POST['title'], $_POST['course']))
                    $blocks->showModal('Видео было успешно отредактировано', true);
                else
                    $blocks->showModal('Ошибка редактирования видео, попробуйте снова', false);
            }

            else if (isset($_POST['user-course-video-delete'])) {

                if ($user->deleteCourseVideo($_POST['id']))
                    $blocks->showModal('Видео было успешно удалено', true);
                else
                    $blocks->showModal('Ошибка удаления видео', false);
            }

            else if (isset($_POST['user-course-create'])) {

                $colorText = 'white';

                switch ($_POST['color']) {
                    case 'yellow':
                    case 'lime':
                    case 'light-green':
                    case 'white':
                        $colorText = 'black';
                        break;
                }

                if ($user->createCourse($_POST['title'], $_POST['title-desc'], $_POST['desc'], $_POST['price'], $_POST['color'], $colorText))
                    $blocks->showModal('Курс был успешно добавлен', true);
                else
                    $blocks->showModal('Ошибка создания курса, попробуйте снова', false);
            }

            else if (isset($_POST['user-course-edit'])) {

                $colorText = 'white';

                switch ($_POST['color']) {
                    case 'yellow':
                    case 'lime':
                    case 'light-green':
                    case 'white':
                        $colorText = 'black';
                        break;
                }

                if ($user->editCourse($_POST['id'], $_POST['title'], $_POST['title-desc'], $_POST['desc'], $_POST['price'], $_POST['color'], $colorText))
                    $blocks->showModal('Курс был успешно отредактирован', true);
                else
                    $blocks->showModal('Ошибка редактирования курса, попробуйте снова', false);
            }

            else if (isset($_POST['user-course-delete'])) {

                if ($user->deleteCourse($_POST['id']))
                    $blocks->showModal('Курс был успешно удалён', true);
                else
                    $blocks->showModal('Ошибка удаления курса', false);
            }

            else if (isset($_POST['profile-edit'])) {
                if (
                    $user->profileEditInfo(
                        $_POST['status'],
                        $_POST['name'],
                        $_POST['surname'],
                        $_POST['patronymic'],
                        $_POST['country'],
                        $_POST['city'],
                        $_POST['vk'],
                        $_POST['facebook'],
                        $_POST['instagram'],
                        $_POST['website'],
                        isset($_POST['sex']) ? $_POST['sex'] : 0
                    )
                )
                    $blocks->showModal('Профиль успешно изменён', true);
                else
                    $blocks->showModal('Произошла ошибка сервера, попробуйте позже', false);

            }
        }
    }
}