<?php
  // $Id: node.tpl.php,v 1.2 2007/12/14 16:03:48 jswaby Exp $
?>
  <div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
    <?php if ($picture) {
      print $picture;
    }?>
    <?php if ($page == 0) { ?><h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2><?php }; ?>
    <span class="submitted"><?php print $submitted?></span>

<?php
  drupal_add_js('misc/collapse.js');
  drupal_add_js('misc/drupal.js');
?>
    <?php if ($terms) { ?>
    <fieldset class="collapsible collapsed">
    <legend><a href="#">Tags</a></legend>
	<div class="fieldset-wrapper">
	<?php print $terms?>
	</div>
    </fieldset>
    <?php }; ?>
    <!--<span class="taxonomy"><?php print $terms?></span>-->
    <div class="content"><?php print $content?></div>
    <?php if ($links) { ?><div class="links">&raquo; <?php print $links?></div><?php }; ?>
  </div>
