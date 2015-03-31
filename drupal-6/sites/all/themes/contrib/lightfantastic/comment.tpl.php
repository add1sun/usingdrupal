<?php // $Id: comment.tpl.php,v 1.4 2008/05/28 03:47:05 brauerranch Exp $ ?>
<div class="comments comment<?php ($comment->new) ? print ' comment-new' : print ''; (isset($comment->status) && $comment->status  == COMMENT_NOT_PUBLISHED) ? print ' comment-unpublished' : print ''; print ' '. $zebra; ?>">

  <?php if ($submitted): ?>
    <p class="submitted"><?php print $submitted ?></p>
  <?php endif; ?>

  <?php if ($comment->new): ?>
    <span class="new"><?php print drupal_ucfirst($new) ?></span>
  <?php endif; ?>

  <?php print $picture ?>

    <h3 class="comment_title"><?php print $title ?></h3>

    <div class="content">
      <?php print $content ?>
      <?php if ($signature) { ?>
      <div class="signature">
        <?php print $signature ?>
      </div>
      <?php } ?>
    </div>

  <?php if ($links): ?>
    <div class="comments_links"><?php print $links ?></div>
  <?php endif; ?>
</div>
