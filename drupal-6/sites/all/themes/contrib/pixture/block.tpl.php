<table id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?>">
<tr>
  <td class="block-tl"></td>
  <td class="block-tc">
    <?php if ($block->subject) { ?>
      <h2><?php print $block->subject ?></h2>
    <?php } ?>
  </td>
  <td class="block-tr"></td>
</tr>
<tr>
  <td class="block-bl"></td>
  <td class="block-bc">
    <div class="content"><?php print $block->content ?></div>
  </td>
  <td class="block-br"></td>
</tr>
</table>
