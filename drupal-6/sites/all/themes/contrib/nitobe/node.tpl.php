<?php
// $Id: node.tpl.php,v 1.3 2008/07/14 02:59:45 shannonlucas Exp $

$node_class = 'node ' . ($sticky ? ' sticky ' : '') . ($status ? '' : ' node-unpublished') . ' node-' . $node->type . ' ' . ($teaser ? 'teaser' : '');
?>
<div id="node-<?php print $node->nid; ?>" class="<?php echo $node_class; ?>">

<?php if ($page == 0): ?>
  <div class="headline grid_12 alpha">
    <h2 class="grid_8 alpha"><a href="<?php print $node_url; ?>" rel="bookmark" title="Permanent Link to <?php print $title; ?>"><?php print $title; ?></a></h2>
    <div class="timestamp grid_4 omega"><?php print format_date($created, 'custom', 'd M Y'); ?></div>
  </div>
<?php endif; ?>
  <div class="content">
    <?php if (nitobe_show_authors()): ?>
    <div class="node-author grid_12 alpha"><?php print $name; ?></div>
    <?php endif; ?>
    <?php print $content; ?>
    <?php if ($teaser && $readmore): ?>
        <span class="readmore"><?php print nitobe_read_more_link($node); ?></span>
    <?php endif; ?>
  </div>

  <div class="clear-block">
    <div class="meta">
      <?php if ($taxonomy): ?>
        <?php print nitobe_render_terms($node); ?>
        <?php if ($page == 0): ?> | <?php endif; ?> 
      <?php endif;?>
      <?php if ($comment > 0): ?>
          <?php if ($teaser): ?>
            <?php print nitobe_teaser_comment_link($node); ?>
          <?php endif; ?>
      <?php else: ?>
          &nbsp;
      <?php endif; ?>
    </div>

    <?php if ($links): ?>
      <div class="links"><?php /* print_r($node->links); //print $links; // @TODO delete this now? */?></div>
    <?php endif; ?>
  </div>

</div> <!-- node-story -->
