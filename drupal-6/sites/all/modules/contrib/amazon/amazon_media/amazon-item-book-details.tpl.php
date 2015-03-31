<div class="<?php print $classes; ?>">
<?php print $smallimage; ?>
<div><strong><?php print l($title, $detailpageurl); ?></strong></div>
<div><strong><?php print t('Author'); ?>:</strong> <?php print $author; ?></div>
<div><strong><?php print t('Publisher'); ?>:</strong> <?php print $publisher; ?> (<?php print $publicationyear; ?>)</div>
<div><strong><?php print t('Binding'); ?>:</strong> <?php print t('@binding, @pages pages', array('@binding' => $binding, '@pages' => $numberofpages)); ?></div>
</div>
