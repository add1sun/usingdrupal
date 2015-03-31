<?php
// $Id: maintenance-page.tpl.php,v 1.2 2008/06/29 18:50:39 shannonlucas Exp $
/**
 * @file Provides the maintenance notice page.
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <title><?php print $head_title ?></title>
    <?php print $head ?>
    <?php print $styles ?>
    <?php print $scripts ?>
    <!--[if IE]>
      <?php print phptemplate_get_ie_styles() . "\n"; ?>
    <![endif]-->
  </head>
  <body class="maintenance">
    <div id="page" class="container_16">
      <?php if ($admin_header): ?>
      <div id="admin-header" class="grid_16"><?php print $admin_header; ?></div>
      <?php endif; ?>
      <div id="header">
        <div id="headerTitle" class="grid_12">
          <h1><a href="<?php print check_url($front_page); ?>" title="<?php print check_plain($site_name); ?>"><?php print nitobe_alt_word_text(check_plain($site_name)); ?></a></h1>
        </div>
        <div id="search-top" class="grid_4">&nbsp;</div>
        <?php if ($site_slogan): ?>
        <div class="clear"></div>
        <div id="site-slogan" class="grid_16">
            <?php print check_plain($site_slogan); ?>
        </div>
        <?php endif; ?>
        <div class="clear"></div>
        <div id="navphoto-top" class="rule">&nbsp;</div>
        <div id="navphoto" class="grid_16"></div>
      </div><!-- /#header -->
      <div class="rule-top">&nbsp;</div>

      <div id="center">
        <?php print $breadcrumb; ?>
        <?php if ($title): ?>
          <div class="headline grid_16 alpha omega">
            <h2 class="grid_8 alpha"><?php print $title; ?></h2>
          </div>
          <div class="clear"></div>
        <?php endif; ?>
        <?php if ($show_messages && $messages): print $messages; endif; ?>
        <?php print $help; ?>
        <div class="clear-block">
          <?php print $content ?>
        </div>
      </div> <!-- /#center -->

      <div class="clear">&nbsp;</div>
      <div id="bottomPad">&nbsp;</div>
      <div class="clear">&nbsp;</div>
      <br />
      <div class="rule">&nbsp;</div>
      <div id="footer">
        <?php print $footer_message . $footer ?>
      </div>
    </div> <!-- /container -->
  <?php print $closure; ?>
  </body>
</html>
