<?php // $Id: block.tpl.php,v 1.4 2008/05/25 18:04:35 brauerranch Exp $ ?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?>">
<?php if (!empty($block->subject)): ?>
  <h2><?php print $block->subject ?></h2>
<?php endif;?>
  <div class="content"><?php print $block->content ?></div>
</div>
