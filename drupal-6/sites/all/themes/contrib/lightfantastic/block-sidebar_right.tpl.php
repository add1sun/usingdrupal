<?php // $Id: block-sidebar_right.tpl.php,v 1.2 2008/05/25 17:43:26 brauerranch Exp $ ?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="sidebar_right block-<?php print $block->module ?>">
	<div class="box">
	<?php if (!empty($block->subject)): ?>
		<h2><?php print $block->subject ?></h2>
	<?php endif;?>
		<div class="content"><?php print $block->content ?></div>
	</div>
</div>
