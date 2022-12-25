<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $user;
global $page;
global $userInfo;
global $qb;
global $filePath;

$this->video = $user->getCourseVideoById($page['video-']);
$this->author = $user->getInfoById($this->video['owner_id']);

$friendStatusHtml = '';
if ($userInfo['id'] != $this->author['id'] && empty($user->getFriendStatus($this->author['id'])))
    $friendStatusHtml = '<button onclick="$.friendSendRequest(' . $this->author['id'] . ')" class="btn z-depth-0 waves-effect light-blue btn-small broadcast-btn-follow">Подписаться</button>';

$qb->createQueryBuilder('course_videos')->updateSql(['views'], [++$this->video['views']])->where('id = \'' . $this->video['id'] . '\'')->executeQuery()->getResult();
?>

<div class="right-content">
    <div class="section">
        <div class="row animated opacity-zero">
            <div class="col s12" style="margin-top: 10px">
                <div class="video-container grey" style="padding-bottom: 64.70%;">
                    <video class="responsive-video" poster="<?php echo $filePath .$this->video['path_img']; ?>" controls>
                        <source src="<?php echo $filePath .$this->video['path']; ?>" type="video/mp4">
                    </video>
                </div>
            </div>
            <hr class="grey lighten-4">
            <div class="col s12">
                <h5 class="h-title"><?php echo $this->video['title']; ?></h5>
            </div>
            <hr>
            <div class="col s12 m6">
                <h6 class="h-title"><i class="mdi mdi-eye"></i> <?php echo number_format($this->video['views']); ?></h6>
                <h6 class="h-title" style="margin-top: 0;"><i class="mdi mdi-account"></i> <?php echo $this->author['name'] . ' ' . $this->author['surname']; ?></h6>
            </div>
            <div class="col s12 m6">
                <?php echo $friendStatusHtml; ?>
            </div>
        </div>
        <ul class="broadcast-chat white z-depth-1 collection" style="display: none">
            <li style="height: 430px; overflow: scroll">
                <ul class="collection" style="margin: 0; border: none;">
                    <li class="collection-item avatar">
                        <i class="material-icons circle">face</i>
                        <b class="title">Alexader</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle green">face</i>
                        <b class="title">Anna</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle red">face</i>
                        <b class="title">Dima</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle">face</i>
                        <b class="title">Alexader</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle green">face</i>
                        <b class="title">Anna</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle red">face</i>
                        <b class="title">Dima</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle">face</i>
                        <b class="title">Alexader</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle green">face</i>
                        <b class="title">Anna</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle red">face</i>
                        <b class="title">Dima</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle">face</i>
                        <b class="title">Alexader</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle green">face</i>
                        <b class="title">Anna</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle red">face</i>
                        <b class="title">Dima</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle">face</i>
                        <b class="title">Alexader</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle green">face</i>
                        <b class="title">Anna</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle red">face</i>
                        <b class="title">Dima</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle">face</i>
                        <b class="title">Alexader</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle green">face</i>
                        <b class="title">Anna</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle red">face</i>
                        <b class="title">Dima</b>
                        <p>First Line <br>
                            Second Line
                        </p>
                    </li>
                </ul>

            </li>
            <hr style="margin: 0;">
            <li style="height: 160px">
                <div class="row" style="margin: 0">
                    <div class="input-field col s12">
                        <textarea id="chat" class="materialize-textarea" style="margin: 0"></textarea>
                        <label for="chat">Чат</label>
                        <button class="btn z-depth-0 light-blue right waves-effect"><i class="material-icons">send</i></button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>