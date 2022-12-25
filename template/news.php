<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $blocks;
global $userInfo;
global $qb;
global $server;
global $monthN;
global $user;
global $utcOffset;
global $filePath;

$result = $qb
    ->createQueryBuilder('friends')
    ->selectSql('id_from, id_to')
    ->where('id_to = \'' . intval($userInfo['id']) . '\' AND status = 1')
    ->orWhere('id_from = \'' . intval(intval($userInfo['id'])) . '\'')
    ->limit(10)
    ->executeQuery()
    ->getResult()
;


$ids = [];
foreach ($result as $item)
    $ids = array_merge($ids, [($item['id_to'] == $userInfo['id'] ? $item['id_from'] : $item['id_to'] )]);

$qm = new \Server\QueryMethods($qb, $server);
$allPost = $qm->getAllBlogPostByPending($ids);

?>

<ajax-title><?php echo 'Новости | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 l5">
                <a href="#new-post" class="modal-trigger z-depth-1">
                    <ul class="collection card card-new-post animated opacity-zero">
                        <li class="collection-item avatar">
                            <img src="<?php echo $filePath . $userInfo['img_avatar'] ?>" alt="Alexander Pozharov" class="circle">
                            <span class="title grey-text left">Что у вас нового?</span>
                            <span class="title grey-text grey lighten-4 btn btn-floating btn-flat right waves-effect" style="margin-top: 3px;"><i class="material-icons grey-text text-darken-2">edit</i></span>
                        </li>
                    </ul>
                </a>
            </div>
            <div class="col s12 m4 l7 hide-on-med-and-down">
                <ul class="collection card z-depth-0 transparent card-new-post animated opacity-zero">
                    <li class="collection-item transparent avatar">
                        <img src="/client/images/stickers/st2.png" alt="Appi Education Sticker" style="border-radius: 0" class="circle">
                        <span class="title grey-text left" style="margin-top: 0;">Здесь вы видете новости тех - на кого вы подписаны или у вас в друзьях <i class="material-icons red-text" style="font-size: 1rem">favorite</i></span>
                    </li>
                </ul>
            </div>
            <div class="col s12" id="blog-posts">

                <?php

                    if (!empty($allPost)) {
                        foreach ($allPost as $item) {

                            $itemUserInfo = $user->getInfoById($item['user_id']);

                            $item['timestamp'] = $item['timestamp'] + $utcOffset;

                            $dateTime = gmdate('d', $item['timestamp']) . ' ' . $monthN[gmdate('m', $item['timestamp'])] . ' ' . gmdate('Y, H:i', $item['timestamp']);
                            $attaches = json_decode(htmlspecialchars_decode($item['attaches']), true);
                            $image = isset($attaches['images']) ? '/upload/news/' . reset($attaches['images']) : '';

                            echo $blocks->getBlogPost(
                                $item['id'],
                                'id' . $item['user_id'],
                                $itemUserInfo['name'] . ' ' . $itemUserInfo['surname'],
                                $itemUserInfo['img_avatar'],
                                $dateTime,
                                $item['content'],
                                $image,
                                ($item['user_id'] == $userInfo['id'])
                            );
                        }
                    }
                    else {
                        echo '
                            <div class="center animated opacity-zero error404">
                                <div class="img-block" style="width: 530px;">
                                    <img class="left" src="/client/images/stickers/st5.png">
                                    <div class="left margin-left">
                                        <h4 class="grey-text text-darken-2">Новостей нет...</h4>
                                        <h6 class="grey-text">Подпишитесь на преподавателей<br>чтобы получать новости</h6>
                                    </div>
                                </div>
                            </div>
                        ';
                    }

                ?>
            </div>
        </div>
    </div>
</div>

<?php echo $blocks->getBlogPostSend(); ?>