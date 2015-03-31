<?php
// $Id: comment.tpl.php,v 1.2 2008/07/03 16:32:02 eaton Exp $

$comment_class = 'comment' . (($comment->new) ? ' comment-new' : '') . 
                 ' ' . $status . ' ' . $zebra;
?>
<div class="<?php print $comment_class; ?>">
  <div class="content">
    <?php print $content ?>
  </div>
  <div class="comment-meta">
    <span>
      <strong><?php print $author; ?></strong> | <?php print $date; ?>
      <?php if ($links): ?> | <?php print $links; ?><?php endif; ?>
    </span>
  </div>
</div>
