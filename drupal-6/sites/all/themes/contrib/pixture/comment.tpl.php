<div class="comment<?php if ($comment->status == COMMENT_NOT_PUBLISHED) print ' comment-unpublished'; ?>">
  <div class="submitted"><span class="comment-id"><?php print "#" . $id; ?></span><?php print $submitted; ?></div>
    <?php if ($picture) {
    print $picture;
  } ?>
  <h3 class="title"><?php print $title; ?></h3>
  <?php if ($comment->new != '') { ?>
    <span class="new"><?php print $new; ?></span>
  <?php } ?>
  <div class="content"><?php print $content; ?></div>
  <?php if($signature) { ?>
  <div class="clear-block">
    <div>-</div>
    <?php print $signature; ?>
    </div>
  <?php } ?>
  <div class="links"><?php print $links; ?></div>
</div>
