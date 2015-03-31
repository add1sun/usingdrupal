<?php
// $Id: block.tpl.php,v 1.2 2008/06/27 18:40:31 shannonlucas Exp $
$block_class = 'block block-' . $block->module . ' block-' . $block->region;
$block_uniq  = 'block-' . $block->module .'-'. $block->delta;

// -------------------------------------------------------------------------
// The 'bottom' region requires the first and fourth block to receive an
// extra class.
if ($block->region == 'bottom') {
  if (($block_id == 1) OR ($block_id % 5) == 0) {
    $block_class .= ' bottom-row-start';
  }
  else if (($block_id % 4) == 0) {
    $block_class .= ' bottom-row-end';
  }
}
?>
<div id="<?php print $block_uniq; ?>" class="<?php print $block_class; ?>">
  <?php if (!empty($block->subject)): ?>
    <h3><?php print $block->subject ?></h3>
  <?php endif;?>
  <?php print $block->content ?>
</div>
