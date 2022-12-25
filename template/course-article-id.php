<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $userInfo;
global $monthN;
global $utcOffset;
global $filePath;

$timestamp = $this->article['timestamp'] + $utcOffset;
$datePublish = gmdate('d', $timestamp) . ' ' . $monthN[gmdate('m', $timestamp)] . ' ' . gmdate('Y, H:i', $timestamp);

if ($userInfo['id'] == $this->article['owner_id'])
    echo '
        <div id="article-delete" class="modal">
            <div class="modal-content">
                <h5>Вы точно хотите удалить эту статью?</h5>
                <p>Внимание, статья удалится навсегда!</p>
            </div>
            <form action="/course-' . $this->article['course_id'] . '" method="post" class="modal-footer">
                <a class="modal-action modal-close waves-effect btn-flat">Отмена</a>
                <input type="hidden" name="id" value="' . $this->article['id'] . '">
                <button name="user-course-article-delete" class="modal-action waves-effect btn-flat red lighten-4">Удалить</button>
            </form>
        </div>
    ';
?>
<ajax-title><?php echo htmlspecialchars_decode($this->article['title']) . ' | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12 animated opacity-zero">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $filePath . $this->article['img']; ?>" style="max-height: 400px;">
                        <?php echo ($userInfo['id'] == $this->article['owner_id'] ? '<a href="#article-delete" class="btn-floating btn-large halfway-fab waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a>' : '') ?>
                        <?php echo ($userInfo['id'] == $this->article['owner_id'] ? '<a href="/create-course-article?edit=' . $this->article['id'] . '" class="btn-floating btn-large halfway-fab waves-effect white" style="right: 104px;"><i class="material-icons black-text">edit</i></a>' : '') ?>
                    </div>
                    <div class="card-content">
                        <h4 class="light"><?php echo htmlspecialchars_decode($this->article['title']); ?></h4>
                        <p><?php echo htmlspecialchars_decode(nl2br($this->article['content'])); ?></p>
                    </div>
                    <div class="card-action">
                        <label><?php echo $datePublish; ?></label>
                        <label class="right" style="line-height: 22px; display: flex;"><i class="material-icons" style="font-size: 1rem; margin: 3px;">visibility</i><?php echo number_format($this->article['views']); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>