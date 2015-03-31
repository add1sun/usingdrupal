<table class="node<?php if ($teaser) { if($sticky) { print " sticky"; } else { print " teaser"; } } ?><?php if (!$status) print " node-unpublished"; ?>"> 
  <?php 
    if($teaser) {
      if($sticky) $prefix = 'sticky-'; 
      else $prefix = 'teaser-';
    }
    else {
      $prefix = '';
    }
  ?>

  <tr>
  <td class="<?php print $prefix; ?>node-tl"></td>
  <td class="<?php print $prefix; ?>node-tc"></td>
  <td class="<?php print $prefix; ?>node-tr"></td>
  <tr>

  <tr>
  <td class="<?php print $prefix; ?>node-ml"></td>
  <td class="<?php print $prefix; ?>node-mc">

    <table>
    <tr>
      <td>
        <h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2>
        <span class="submitted"><?php print $submitted?></span>
        <span class="taxonomy"><?php print $terms?></span>
      </td>
    </tr>
    </table>
    <?php if($picture) print $picture; ?>
    <div class="content"><?php print $content?></div>
    <?php if ($links) { ?><div class="links"><?php print $links?></div><?php }; ?>

  </td>
  <td class="<?php print $prefix; ?>node-mr"></td>
  </tr>

  <tr>
  <td class="<?php print $prefix; ?>node-bl"></td>
  <td class="<?php print $prefix; ?>node-bc"></td>
  <td class="<?php print $prefix; ?>node-br"></td>
  <tr>
</table>
