<?php // $Id: node.tpl.php,v 1.4 2008/05/28 03:47:05 brauerranch Exp $ ?>
<div id="node-<?php print $node->nid ?>" class="node<?php if ($sticky): print ' sticky'; endif; ?><?php if (!$status): print ' node-unpublished'; endif; ?>">
	<?php print $picture ?>
<?php if ($page == 0) { ?>
	<h2 class="title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php } ?>
<?php if ($submitted) { ?>
	<p class="submitted"><?php print $submitted ?></p>
<?php } ?>
	<div class="content">
		<?php print $content ?>
	</div>
	<div class="meta">
		<?php if ($taxonomy): print $terms; endif; ?>
	</div>
	<div class="comments_links">
		<?php if ($links): print $links; endif; ?>
	</div>
</div>
