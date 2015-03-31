<?php // $Id: block.tpl.php,v 1.2.2.1.2.1 2008/04/27 15:09:59 melon Exp $
//
// Ubiquity Drupal theme block.tpl.php file
//
?><div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?>">  
  <div class="block-inner">
    <h2 class="title"> <?php print $block->subject; ?> </h2>
    <div class="content">
      <?php print $block->content; ?>
    </div>    
  </div>
</div>
