<?php
define("AppiEngine", true);

header('Powered: Alexander Pozharov');
header("Cache-control: public");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 60 * 60 * 24) . " GMT");

spl_autoload_register(function($class) {
    include_once str_replace('\\', '/', $class) . '.php';
});

/*$langType = 'ru';
if (isset($_COOKIE['lang']))
    if ($_COOKIE['lang'] == 'ru')
        $langType = 'ru';*/

include_once 'globals.php';
//include_once 'lang/' . $langType . '.php';

use Server\Core\Init;
use Server\Core\EnumConst;
use Server\Core\QueryBuilder;
use Server\Core\Request;
use Server\Core\Template;
use Server\Core\Server;
use Server\Core\Settings;
use Server\Manager\PermissionManager;
use Server\Manager\RequestManager;
use Server\Manager\TemplateManager;
use Server\Blocks;
use Server\User;

global $modal;
//global $lang;
global $utcOffset;
global $userInfo;
global $filePath;

$UTC = 0;
if (isset($_COOKIE['UTC']))
    $UTC = $_COOKIE['UTC'];
$utcOffset = $UTC * 3600;

$init = new Init;
$init->initAppi();

$qb = new QueryBuilder();
$qb->connectDataBase(EnumConst::DB_HOST, EnumConst::DB_NAME, EnumConst::DB_USER, EnumConst::DB_PASS);

$view = new Template('/template/');
$requests = new RequestManager();
$permissionManager = new PermissionManager();
$tmp = new TemplateManager($view, $init);
$request = new Request();
$server = new Server();
$user = new User($qb, $server);
$blocks = new Blocks();
$settings = new Settings();

$requests->checkRequests();

$page = $request->getRequest(['/']);
$view->set('siteName', $settings->getSiteName());
$view->set('version', $settings->getVersion());
$view->set('langType', 'ru');
$view->set('metaImg', '/images/logoBG.png');
$view->set('title', $settings->getTitle());
$view->set('titleHtml', 'NotFound 404 | ' . $settings->getTitle());
$view->set('modal', $modal);

if (isset($page['p'])) {
    switch ($page['p']) {
        case 'debug':
            $tmp->setTitle('Debug');
            $tmp->showBlockPage('debug');
            break;
        case 'engine-info':
            $tmp->setTitle('Info');
            $tmp->showBlockPage('engine-info');
            break;
        case 'login':
            $tmp->setTitle('??????????????????????');
            $tmp->showHeaderPage('not-auth/header');
            $tmp->showBlockPage('not-auth/login');
            $tmp->showFooterPage('not-auth/footer');
            break;
        case 'logout':
            $user->logout();
            break;
        case 'news':
            $tmp->showPage('news', '??????????????');
            break;
        case 'im':
            $tmp->showPage('im', '??????????????');
            break;
        case 'favorite':
            $tmp->showPage('fav', '??????????????????');
            break;
        case 'orders':
            $tmp->showPage('orders', '?????? ??????????????');
            break;
        case 'rating':
            $tmp->showPage('rating', '??????????????????????????');
            break;
        case 'regcrt':
            $tmp->showPage('regcrt', '???????????? ????????????????????????');
            break;
        case 'myedu':
            $tmp->showPage('myedu', '?????? ????????????????');
            break;
        case 'trending':
            $tmp->showPage('trending', '???????????????????? ?? ??????????');
            break;
        case 'broadcast':
            $tmp->showPage('broadcast', '????????????????????');
            break;
        case 'course-id':
            $tmp->showPage('course-id', '????????');
            break;
        case 'friends':
            $tmp->showPage('friends', '????????????');
            break;
        case 'settings':
            $tmp->showPage('settings', '??????????????????');
            break;
        case 'notifications':
            $tmp->showPage('notifications', '??????????????????????');
            break;
        case 'contacts':
            $tmp->showPage('contacts', '???????????????? ??????????');
            break;
        case 'balance-stats':
            if ($user->isAuthorization() && $user->isTeacher()) //TODO ??????????????
                $tmp->showPage('balance-stats', '???????????????????? ??????????????');
            else
                $tmp->showError404Page();
            break;
        case 'create-broadcast':
            if ($user->isAuthorization() && $user->isTeacher())
                $tmp->showPage('broadcast-create', '???????????????? ????????????????????');
            else
                $tmp->showError404Page();
            break;
        case 'create-course':
            if ($user->isAuthorization() && $user->isTeacher())
                $tmp->showPage('course-create', '???????????????? ??????????');
            else
                $tmp->showError404Page();
            break;
        case 'create-course-article':
            if ($user->isAuthorization() && $user->isTeacher()) {
                if (!empty($courseList = $user->getCourseList($userInfo['id']))) {
                    $view->set('courseList', $courseList);
                    $tmp->showPage('course-create-article', '???????????????? ???????????? ?????? ??????????');
                }
                else
                    $tmp->showPage('course-none', '???????????? - ???????????????? ????????');
            }
            else
                $tmp->showError404Page();
            break;
        case 'course-attaches':
            if ($user->isAuthorization() && $user->isTeacher())
                $tmp->showPage('course-attaches', '???????????? ?????????????????????? ????????????');
            else
                $tmp->showError404Page();
            break;
        case 'upload-video':
            if ($user->isAuthorization() && $user->isTeacher())
            {
                if (!empty($courseList = $user->getCourseList($userInfo['id']))) {
                    $view->set('courseList', $courseList);
                    $tmp->showPage('upload-video', '???????????????? ??????????');
                }
                else
                    $tmp->showPage('course-none', '???????????? - ???????????????? ????????');
            }
            else
                $tmp->showError404Page();
            break;
        case 'upload-file':
            if ($user->isAuthorization() && $user->isTeacher()) {
                if (!empty($courseList = $user->getCourseList($userInfo['id']))) {
                    $view->set('courseList', $courseList);
                    $tmp->showPage('upload-file', '???????????????? ??????????');
                }
                else
                    $tmp->showPage('course-none', '???????????? - ???????????????? ????????');
            }
            else
                $tmp->showError404Page();
            break;
        case 'certificate':
            $tmp->showPage('certificate', '????????????????????');
            break;
        case 'change-log':
            $tmp->showPage('change-log', '?????? ??????????????????');
            break;
        default:
            if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == 'index.php' || $_SERVER['REQUEST_URI'] == 'index') {
                $tmp->setTitle('??????????????');
                $tmp->showHeaderPage('not-auth/header');
                $tmp->showBlockPage('not-auth/index');
                $tmp->showFooterPage('not-auth/footer');
            } else {
                if (isset($page['id'])) {
                    if (is_numeric($page['id']) || $page['id'] == 0) {
                        $userInfoById = $user->getInfoById($page['id']);
                        if (!empty($userInfoById = $user->getInfoById($page['id']))) {

                            $view->set('userInfo', $userInfoById);
                            if ($userInfoById['is_ban'] == true) {
                                $tmp->showPage('profile-ban', $userInfoById ['name'] . ' ' . $userInfoById['surname'] . ' | ?????????????? ???????????????????????? ');
                                break;
                            }
                            if ($user->isBlackList($userInfoById['id'])) {
                                $tmp->showPage('profile-blacklist', $userInfoById ['name'] . ' ' . $userInfoById['surname'] . ' | ???? ???????????????? ');
                                break;
                            }
                            $tmp->showPage('profile', $userInfoById ['name'] . ' ' . $userInfoById['surname']);
                        }
                        else
                            $tmp->showError404Page();
                    }
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['friends'])) {
                    if (is_numeric($page['friends']) || $page['friends'] == 0) {
                        $userInfoById = $user->getInfoById($page['friends']);
                        if (!empty($userInfoById = $user->getInfoById($page['friends']))) {

                            $view->set('userInfo', $userInfoById);
                            if ($userInfoById['is_ban'] == true) {
                                $tmp->showPage('profile-ban', $userInfoById ['name'] . ' ' . $userInfoById['surname'] . ' | ?????????????? ???????????????????????? ');
                                break;
                            }
                            if ($user->isBlackList($userInfoById['id'])) {
                                $tmp->showPage('profile-blacklist', $userInfoById ['name'] . ' ' . $userInfoById['surname'] . ' | ???? ???????????????? ');
                                break;
                            }
                            $tmp->showPage('friends', $userInfoById ['name'] . ' ' . $userInfoById['surname'] . ' | ???????????? ???????????? ');
                        }
                        else
                            $tmp->showError404Page();
                    }
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['im'])) {
                    if (is_numeric($page['im']) || $page['im'] == 0) {
                        $userInfoById = $user->getInfoById($page['im']);
                        if ($user->isBlackList($userInfoById['id'])) {
                            $tmp->showPage('profile-blacklist', $userInfoById ['name'] . ' ' . $userInfoById['surname'] . ' | ???? ???????????????? ');
                            break;
                        }
                        $tmp->showPage('im', '?????????????? ');
                    }
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['file-list-edit-'])) {
                    if (is_numeric($page['file-list-edit-'])) {
                        $fileId = $user->getCourseFileById($page['file-list-edit-']);

                        if ($user->isAuthorization() && $user->isTeacher() && $fileId['owner_id'] == $userInfo['id']) {
                            $view->set('file', $fileId);
                            $view->set('courseList', $user->getCourseList($userInfo['id']));
                            $tmp->showPage('file-list-edit-id', htmlspecialchars_decode($fileId['title']));
                        }
                        else
                            $tmp->showError404Page();
                    }
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['video-edit-'])) {
                    if (is_numeric($page['video-edit-'])) {
                        $fileId = $user->getCourseVideoById($page['video-edit-']);

                        if ($user->isAuthorization() && $user->isTeacher() && $fileId['owner_id'] == $userInfo['id']) {
                            $view->set('file', $fileId);
                            $view->set('courseList', $user->getCourseList($userInfo['id']));
                            $tmp->showPage('video-edit-id', htmlspecialchars_decode($fileId['title']));
                        }
                        else
                            $tmp->showError404Page();
                    }
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['broadcast-cat-'])) {
                    if (is_numeric($page['broadcast-cat-']) || $page['broadcast-cat-'] == 'id')
                        $tmp->showPage('broadcast-cat-id', '??????????????????');
                    else
                        $tmp->showPage('broadcast-cat-list', '???????????? ??????????????????');
                }
                else if (isset($page['broadcast-'])) {
                    if (is_numeric($page['broadcast-']) || $page['broadcast-'] == 'id')
                        $tmp->showPage('broadcast-id', '????????????????????');
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['video-'])) {
                    if (is_numeric($page['video-']) || $page['video-'] == 'id')
                        $tmp->showPage('video-id', '??????????');
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['course-list-'])) {
                    if (is_numeric($page['course-list-']))
                        $tmp->showPage('course-list-id', '???????????? ???????????? ??????????????????????????');
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['course-article-'])) {
                    if (is_numeric($page['course-article-'])) {
                        $articleId = $user->getCourseArticleById($page['course-article-']);
                        $view->set('article', $articleId);
                        $tmp->showPage('course-article-id', htmlspecialchars_decode($articleId['title']));
                    }
                    else
                        $tmp->showError404Page();
                }
                else if (isset($page['course-'])) {
                    if (is_numeric($page['course-'])) {
                        $courseId = $user->getCourseById($page['course-']);
                        $view->set('course', $courseId);
                        $tmp->showPage('course-id', htmlspecialchars_decode($courseId['title']));
                    }
                    else
                        $tmp->showError404Page();
                }else {
                    $tmp->showError404Page();
                }
            }
    }
}