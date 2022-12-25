<?php
if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

global $settings;
global $blocks;
global $user;

?>
<ajax-title><?php echo 'Трансляции и видео | ' . $settings->getTitle(); ?></ajax-title>
<div class="right-content container">
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="row">
                    <h5 class="col s12 animated opacity-zero">
                        <a ajax-page="broadcast-cat-top" class="h-title">Популярные курсы</a>
                        <a ajax-page="broadcast-cat-top" style="margin-top: -2px;" class="waves-effect waves-light btn btn-small red right">Ещё</a>
                    </h5>
                    <?php
                        foreach ($user->getCourseAllList(12) as $item) {
                            echo $blocks->getAnimatedColBlock(
                                $blocks->getCourseBlock(
                                    $item['id'],
                                    $item['title'],
                                    $item['title_desc'],
                                    $item['content'],
                                    $item['price'],
                                    $item['rating'],
                                    $item['color'],
                                    $item['color_text']
                                ),
                                '12',
                                '4',
                                '4'
                            );
                        }
                    ?>
                </div>
            </div>
    </div>
</div>

<!--
  "We only have room
   for one specimen,       "Let us take the small,
   Dtlxvr. Which shall     high-decible one, Ftxbp.
      we take?"               It has less mass."
             \  _.-'~~~~'-._   /
      .      .-~ \__/  \__/ ~-.         .
           .-~   (oo)  (oo)    ~-.
          (_____//~~\\//~~\\______)
     _.-~`                         `~-._
    /O=O=O=O=O=O=O=O=O=O=O=O=O=O=O=O=O=O\     *
    \___________________________________/
               \x x x x x x x/
       .  *     \x_x_x_x_x_x/
-->