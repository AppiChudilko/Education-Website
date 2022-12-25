<?php
define("AppiEngine", true);

header('Powered: Alexander Pozharov');
header("Cache-control: public");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 60 * 60 * 24) . " GMT");

spl_autoload_register(function($class) {
    include_once str_replace('\\', '/', $class) . '.php';
});

$langType = 'en';
if (isset($_COOKIE['lang']))
    if ($_COOKIE['lang'] == 'ru')
        $langType = 'ru';

include_once 'globals.php';
include_once 'lang/' . $langType . '.php';

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
global $lang;
global $utcOffset;

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

global $userInfo;

$view->set('siteName', $settings->getSiteName());
$view->set('version', $settings->getVersion());
$view->set('langType', $langType);
$view->set('metaImg', '/images/logoBG.png');
$view->set('title', $settings->getTitle());
$view->set('titleHtml', 'NotFound 404 | ' . $settings->getTitle());
$view->set('modal', $modal);
$view->set('error404', false);

if (isset($_POST['ajax'])) {

    $page['p'] = '/';
    if (isset($_POST['page']))
        $page = $request->getAjaxRequest($_POST['page']);

    switch ($_POST['action']) {
        case 'show-page':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $user->updateOnline();

            switch ($_POST['page']) {
                case 'news':
                    $tmp->showBlockPage('news');
                    break;
                case 'trending':
                    $tmp->showBlockPage('trending');
                    break;
                case 'broadcast':
                    $tmp->showBlockPage('broadcast');
                    break;
                case 'friends':
                case 'friends/sort-online':
                case 'friends/sort-followers':
                case 'friends/sort-pending':
                    $tmp->showBlockPage('friends');
                    break;
                case 'im':
                    $tmp->showBlockPage('im');
                    break;
                case 'rating':
                    $tmp->showBlockPage('rating');
                    break;
                case 'favorite':
                    $tmp->showBlockPage('fav');
                    break;
                case 'orders':
                    $tmp->showBlockPage('orders');
                    break;
                case 'myedu':
                    $tmp->showBlockPage('myedu');
                    break;
                case 'regcrt':
                    $tmp->showBlockPage('regcrt');
                    break;
                case 'settings':
                    $tmp->showBlockPage('settings');
                    break;
                case 'notifications':
                    $tmp->showBlockPage('notifications');
                    break;
                case 'balance-stats':
                    if ($user->isTeacher())
                        $tmp->showBlockPage('balance-stats');
                    else
                        $tmp->showError404Page();
                    break;
                case 'create-broadcast':
                    if ($user->isTeacher())
                        $tmp->showBlockPage('broadcast-create');
                    else
                        $tmp->showError404Page();
                    break;
                case 'create-course':
                    if ($user->isTeacher())
                        $tmp->showBlockPage('course-create');
                    else
                        $tmp->showError404Page();
                    break;
                case 'create-course-article':
                    if ($user->isTeacher())
                        if (!empty($courseList = $user->getCourseList($userInfo['id']))) {
                            $view->set('courseList', $courseList);
                            $tmp->showBlockPage('course-create-article');
                        }
                        else
                            $tmp->showBlockPage('course-none');
                    else
                        $tmp->showError404Page();
                    break;
                case 'course-attaches':
                    if ($user->isAuthorization() && $user->isTeacher())
                        $tmp->showBlockPage('course-attaches');
                    else
                        $tmp->showError404Page();
                    break;
                case 'upload-video':
                    if ($user->isTeacher()) {
                        if (!empty($courseList = $user->getCourseList($userInfo['id']))) {
                            $view->set('courseList', $courseList);
                            $tmp->showBlockPage('upload-video');
                        }
                        else
                            $tmp->showBlockPage('course-none');
                    }
                    else
                        $tmp->showError404Page();
                    break;
                case 'upload-file':
                    if ($user->isTeacher()) {
                        if (!empty($courseList = $user->getCourseList($userInfo['id']))) {
                            $view->set('courseList', $courseList);
                            $tmp->showBlockPage('upload-file');
                        }
                        else
                            $tmp->showBlockPage('course-none');
                    }
                    else
                        $tmp->showError404Page();
                    break;
                case 'contacts':
                    $tmp->showBlockPage('contacts');
                    break;
                case 'certificate':
                    $tmp->showBlockPage('certificate');
                    break;
                case 'change-log':
                    $tmp->showBlockPage('change-log');
                    break;
                default:
                    if (isset($page['id'])) {
                        if (is_numeric($page['id']) || $page['id'] == 0) {
                            $userInfoById = $user->getInfoById($page['id']);
                            if (!empty($userInfoById = $user->getInfoById($page['id']))) {

                                $view->set('userInfo', $userInfoById);
                                if ($userInfoById['is_ban'] == true) {
                                    $tmp->showBlockPage('profile-ban');
                                    break;
                                }
                                if ($user->isBlackList($userInfoById['id'])) {
                                    $tmp->showBlockPage('profile-blacklist');
                                    break;
                                }
                                $tmp->showBlockPage('profile');
                            }
                            else
                                header("HTTP/1.0 404 Not Found");
                        }
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['friends'])) {
                        if (is_numeric($page['friends']) || $page['friends'] == 0) {
                            $userInfoById = $user->getInfoById($page['friends']);
                            if (!empty($userInfoById = $user->getInfoById($page['friends']))) {

                                $view->set('userInfo', $userInfoById);
                                if ($userInfoById['is_ban'] == true) {
                                    $tmp->showBlockPage('profile-ban');
                                    break;
                                }
                                if ($user->isBlackList($userInfoById['id'])) {
                                    $tmp->showBlockPage('profile-blacklist');
                                    break;
                                }
                                $tmp->showBlockPage('friends');
                            }
                            else
                                header("HTTP/1.0 404 Not Found");
                        }
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['im'])) {
                        if (is_numeric($page['im']) || $page['im'] == 0) {
                            $userInfoById = $user->getInfoById($page['im']);
                            if ($user->isBlackList($userInfoById['id'])) {
                                $tmp->showBlockPage('profile-blacklist');
                                break;
                            }
                            $tmp->showBlockPage('im');
                        }
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['broadcast-cat-'])) {
                        if (is_numeric($page['broadcast-cat-']) || $page['broadcast-cat-'] == 'id')
                            $tmp->showBlockPage('broadcast-cat-id');
                        else
                            $tmp->showBlockPage('broadcast-cat-list');
                    }
                    else if (isset($page['broadcast-'])) {
                        if (is_numeric($page['broadcast-']) || $page['broadcast-'] == 'id')
                            $tmp->showBlockPage('broadcast-id');
                        else
                            header("HTTP/1.0 404 Not Found");
                    }

                    else if (isset($page['video-edit-'])) {
                        if (is_numeric($page['video-edit-'])) {
                            $fileId = $user->getCourseVideoById($page['video-edit-']);

                            if ($user->isTeacher() && $fileId['owner_id'] == $userInfo['id']) {
                                $view->set('file', $fileId);
                                $view->set('courseList', $user->getCourseList($userInfo['id']));
                                $tmp->showBlockPage('video-edit-id');
                            }
                            else
                                header("HTTP/1.0 404 Not Found");
                        }
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['video-'])) {
                        if (is_numeric($page['video-']) || $page['video-'] == 'id')
                            $tmp->showBlockPage('video-id');
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['file-list-edit-'])) {
                        if (is_numeric($page['file-list-edit-'])) {
                            $fileId = $user->getCourseFileById($page['file-list-edit-']);

                            if ($user->isTeacher() && $fileId['owner_id'] == $userInfo['id']) {
                                $view->set('file', $fileId);
                                $view->set('courseList', $user->getCourseList($userInfo['id']));
                                $tmp->showBlockPage('file-list-edit-id');
                            }
                            else
                                header("HTTP/1.0 404 Not Found");
                        }
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['course-list-'])) {
                        if (is_numeric($page['course-list-']))
                            $tmp->showBlockPage('course-list-id');
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['course-article-'])) {
                        if (is_numeric($page['course-article-'])) {
                            $articleId = $user->getCourseArticleById($page['course-article-']);
                            $view->set('article', $articleId);
                            $tmp->showBlockPage('course-article-id');
                        }
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else if (isset($page['course-'])) {
                        if (is_numeric($page['course-'])) {
                            $courseId = $user->getCourseById($page['course-']);
                            $view->set('course', $courseId);
                            $tmp->showBlockPage('course-id');
                        }
                        else
                            header("HTTP/1.0 404 Not Found");
                    }
                    else {
                        header("HTTP/1.0 404 Not Found");
                    }
                    break;
            }
            break;
        case 'validate-email':
            header('Content-Type: application/json');
            $data = ['success' => false];
            if ($user->isValidEmail($_POST['email']))
                $data['success'] = true;

            echo json_encode($data);
            break;
        case 'upload-image-av':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            header('Content-Type: application/json; charset=utf-8');
            $files = new \Server\Files();
            echo json_encode($files->uploadUserAvatar());
            break;
        case 'upload-image-bg':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            header('Content-Type: application/json; charset=utf-8');
            $files = new \Server\Files();
            echo json_encode($files->uploadUserBackground());
            break;
        case 'upload-image-blog':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            header('Content-Type: application/json; charset=utf-8');
            $files = new \Server\Files();
            echo json_encode($files->uploadImageBlogTemp());
            break;
        case 'upload-course-file':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            if (!$user->isTeacher()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            header('Content-Type: application/json; charset=utf-8');
            $files = new \Server\Files();
            echo json_encode($files->uploadCourseFile());
            break;
        case 'upload-course-video':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            if (!$user->isTeacher()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            header('Content-Type: application/json; charset=utf-8');
            $files = new \Server\Files();
            echo json_encode($files->uploadCourseVideo());
            break;
        case 'blog-post-send':
            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $files = new \Server\Files();
            $qm = new \Server\QueryMethods($qb, $server);
            $data = ['success' => false];

            if (!empty($_POST['content']) && !empty($_POST['image_name'])) {
                $user->sendBlogPost($_POST['content']);
                $lastPost =  $qm->getLastBlogPostByUser($userInfo['id']);

                $files->switchImageBlogTempToNews($_POST['image_name'], $lastPost['id']);
                $attaches = ['images' => [$lastPost['id'] . '.' . $files->getFileFormat($_POST['image_name'])]];

                $data['success'] = $qm->blogPostUpdateAttaches($lastPost['id'], $attaches);
            }
            else if (!empty($_POST['content'])) {
                $data['success'] = $user->sendBlogPost($_POST['content']);
            }
            else if (!empty($_POST['image_name'])) {
                $user->sendBlogPost();
                $lastPost =  $qm->getLastBlogPostByUser($userInfo['id']);

                $files->switchImageBlogTempToNews($_POST['image_name'], $lastPost['id']);
                $attaches = ['images' => [$lastPost['id'] . '.' . $files->getFileFormat($_POST['image_name'])]];

                $data['success'] = $qm->blogPostUpdateAttaches($lastPost['id'], $attaches);
            }

            echo json_encode($data);
            break;
        case 'blog-post-delete':
            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $qm = new \Server\QueryMethods($qb, $server);
            $data['success'] = $qm->blogPostDelete($_POST['id']);
            echo json_encode($data);
            break;
        case 'get-last-user-blog-post':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            global $monthN;

            $qm = new \Server\QueryMethods($qb, $server);
            $lastPost =  $qm->getLastBlogPostByUser($userInfo['id']);

            $dateTime = gmdate('d', $lastPost['timestamp']) . ' ' . $monthN[gmdate('m', $lastPost['timestamp'])] . ' ' . gmdate('Y, H:i', $lastPost['timestamp']);
            $attaches = json_decode(htmlspecialchars_decode($lastPost['attaches']), true);
            $image = isset($attaches['images']) ? '/upload/news/' . reset($attaches['images']) : '';

            echo $blocks->getBlogPost(
                $lastPost['id'],
                'id' . $lastPost['user_id'],
                $userInfo['name'] . ' ' . $userInfo['surname'],
                $userInfo['img_avatar'],
                $dateTime,
                $lastPost['content'],
                $image,
                true
            );

            break;
        case 'friend-send-request':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->friendSendRequest($_POST['id']);
            echo json_encode($data);
            break;
        case 'friend-unsend-request':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            //$redis = new \Redis();
            //$redis->connect('localhost');
            //$redis->zAdd(EnumConst::NS_USER . EnumConst::NS_MESSAGE . $_POST['id_from'], $_POST['id_from'], $_POST['id_to']);

            $data = ['success' => false];
            $data['success'] = $user->friendUnSendRequest($_POST['id']);
            echo json_encode($data);
            break;
        case 'friend-accept-request':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->friendAcceptSendRequest($_POST['id']);
            echo json_encode($data);
            break;
        case 'friend-delete-request':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->friendDeleteSendRequest($_POST['id']);
            echo json_encode($data);
            break;
        case 'course-set-like':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $course = new \Server\Course($qb, $server);

            $data = ['success' => false];
            $data['success'] = $course->setLike($_POST['id']);
            echo json_encode($data);
            break;
        case 'course-set-dislike':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $course = new \Server\Course($qb, $server);

            $data = ['success' => false];
            $data['success'] = $course->setDisLike($_POST['id']);
            echo json_encode($data);
            break;
        case 'blog-post-set-like':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->setLike($_POST['id']);
            echo json_encode($data);
            break;
        case 'blog-post-unset-like':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->unSetLike($_POST['id']);
            echo json_encode($data);
            break;
        case 'blog-post-get-comments':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            global $monthN;
            global $userInfo;
            global $filePath;

            $qm = new \Server\QueryMethods($qb, $server);

            if (!empty($content =  $qm->getAllCommentsBlogPost($_POST['id']))) {
                foreach ($content as $item) {
                    $timestamp = $item['timestamp'] + $utcOffset;
                    $dateTime = gmdate('d', $timestamp) . ' ' . $monthN[gmdate('m', $timestamp)] . ' ' . gmdate('Y, H:i', $timestamp);

                    $blockDelete = '';
                    if ($item['user_id'] == $userInfo['id'])
                        $blockDelete = '<a class="secondary-content"><i class="material-icons grey-text" onclick="$.blogPostDeleteComment(' . $item['bc_id'] . ')" style="font-size: 1.2rem;">close</i></a>';

                    echo '
                        <li class="collection-item avatar" id="blog-post-comment-id-' . $item['bc_id'] . '">
                            <img src="' . $filePath . $item['img_avatar'] . '" alt="' . $item['name'] . ' ' . $item['surname'] . '" class="circle">
                            <a ajax-page="id' . $item['id'] . '" class="title black-text"><b>' . $item['name'] . ' ' . $item['surname'] . '</b> <label>' . $dateTime . '</label></a>
                            <p class="grey-text" style="font-size: 0.8rem; line-height: 0.8rem;">' . htmlspecialchars_decode(nl2br($item['content'])) . '</p>
                            ' . $blockDelete . '
                        </li>
                    ';
                }

            }
            else {
                echo '<h5 class="center grey-text">Комментариев нет<br><label>Напишите свой первый комментарий под этим постом <i class="material-icons red-text" style="font-size: 0.8rem;">favorite</i></label></h5>';
            }
            break;
        case 'blog-post-send-comment':

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            global $monthN;
            global $filePath;

            $qm = new \Server\QueryMethods($qb, $server);

            if ($qm->blogPostSendComment($_POST['id'], $_POST['content'])) {
                $item = $qm->getLastCommentsBlogPostByUser($_POST['id']);

                $timestamp = $item['timestamp'] + $utcOffset;
                $dateTime = gmdate('d', $timestamp) . ' ' . $monthN[gmdate('m', $timestamp)] . ' ' . gmdate('Y, H:i', $timestamp);

                $blockDelete = '';
                if ($item['user_id'] == $userInfo['id'])
                    $blockDelete = '<a class="secondary-content"><i class="material-icons grey-text" onclick="$.blogPostDeleteComment(' . $item['bc_id'] . ')" style="font-size: 1.2rem;">close</i></a>';

                echo '
                    <li class="collection-item avatar" id="blog-post-comment-id-' . $item['bc_id'] . '">
                        <img src="' . $filePath . $item['img_avatar'] . '" alt="' . $item['name'] . ' ' . $item['surname'] . '" class="circle">
                        <a ajax-page="id' . $item['id'] . '" class="title black-text"><b>' . $item['name'] . ' ' . $item['surname'] . '</b> <label>' . $dateTime . '</label></a>
                        <p class="grey-text" style="font-size: 0.8rem; line-height: 0.8rem;">' . htmlspecialchars_decode(nl2br($item['content'])) . '</p>
                        ' . $blockDelete . '
                    </li>
                ';
                break;
            }
            header("HTTP/1.0 404 Not Found");
            return false;
            break;
        case 'blog-post-delete-comment':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $qm = new \Server\QueryMethods($qb, $server);
            $data = ['success' => false];
            $data['success'] = $qm->blogPostDeleteComment($_POST['id']);
            echo json_encode($data);
            break;
        case 'user-dialog-send-msg':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->sendMsgToUser($_POST['id'], $_POST['content']);
            echo json_encode($data);
            break;
        case 'user-add-blacklist':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->addBlackList($_POST['id']);
            echo json_encode($data);
            break;
        case 'user-remove-blacklist':

            header('Content-Type: application/json');

            if (!$user->isAuthorization()) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $data = ['success' => false];
            $data['success'] = $user->removeBlackList($_POST['id']);
            echo json_encode($data);
            break;
        case 'close-readme':
            if (isset($_SESSION['isShowReadme']))
                unset($_SESSION['isShowReadme']);
            break;
        default:
            header("HTTP/1.0 404 Not Found");
            break;
    }
}