<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language ?>" xml:lang="<?php print $language->language ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
    <!--[if lt IE 7]>
    <style type="text/css" media="all">@import "<?php print base_path() . path_to_theme() ?>/fix-ie.css";</style>
    <![endif]-->
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?></script>
</head>

<?php
$wabi_width = theme_get_setting('wabi_width');
$wabi_width = wabi_validate_page_width($wabi_width);
?>

<body>

<div id="wrapper" style="width: <?php print $wabi_width; ?>;">

<div id="container">

<table border="0" cellpadding="0" cellspacing="0" id="header">
<tr>
    <td id="logo" valign="top">
      <?php if ($logo) { ?><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a><?php } ?>
  </td>
  <td id="site_name">
      <?php if ($site_name) { ?><h1><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print $site_name; ?></a></h1>
    <?php } ?>
      <?php if ($site_slogan) { ?><div class="site-slogan"><?php print $site_slogan ?></div><?php } ?>
    </td>
    <td id="site_search">
      <?php print $search_box ?>
  </td>
</tr>
</table>


<table border="0" cellpadding="0" cellspacing="0" id="menu">
<tr>
  <td id="menu-l"></td>
    <td id="menu">
      <?php if (isset($primary_links)) { ?><?php print theme('links', $primary_links, array('class' =>'links', 'id' => 'navlist')) ?><?php } ?>
    </td>
  <td id="menu-r"></td>
</tr>
</table>

<?php if($header) { ?>
<table border="0" cellpadding="0" cellspacing="0" id="header-area">
<tr>
  <td id="main-l"></td>
  <td id="main-c"><div><?php print $header ?></div></td>
  <td id="main-r"></td>
</tr>
</table>
<?php } ?>


<table border="0" cellpadding="0" cellspacing="0" id="content">

  <tr>
  <td id="main-l"></td>

  <?php if ($left) { ?>
  <td id="sidebar-left" class="sidebar sidebar-left" valign="top">
    <?php print $left ?>
  </td>
  <?php } ?>

  <td id="main-content" valign="top">

    <?php if($mission) { ?>
      <table border="0" cellpadding="0" cellspacing="0" id="mission">
      <tr>
        <td class="pagetitle-l"></td>
        <td class="pagetitle-c">
            <div id="mission"><h1><?php print $mission ?></h1></div>
        </td>
        <td class="pagetitle-r"></td>
        </tr>
      </table>
    <?php } ?>

    <div id="main">
    <?php print $breadcrumb ?>
    <?php if(!empty($node) && $page == 0) { ?>
      <div id="cr8"></div>
    <?php } else { ?>
      <?php if($title) { ?>
        <table border="0" cellpadding="0" cellspacing="0" class="pagetitle">
        <tr>
          <td class="pagetitle-l"></td>
          <td class="pagetitle-c">
              <h1><?php print $title ?></h1>
          </td>
          <td class="pagetitle-r"></td>
        </tr>
        </table>
      <?php } ?>
    <?php } ?>
    <div class="tabs"><?php print $tabs ?></div>
    <?php print $help ?>
    <?php print $messages ?>
    <?php print $content; ?>
    <?php print $feed_icons; ?>
    </div>
  </td>

  <?php if ($right) { ?>
  <td id="sidebar-right" class="sidebar sidebar-right" valign="top">
    <?php print $right ?>
  </td>
  <?php } ?>

  <td id="main-r"></td>

  </tr>
</table>

</div><!-- end of div#container -->

<table border="0" cellpadding="0" cellspacing="0" id="footer">
<tr>
  <td id="foot-l"><td>
  <td id="foot">
  <?php print $footer_message . $footer ?><?php print $closure ?>
  </td>
  <td id="foot-r"><td>
</tr>
</table>

</div><!-- end of div#wrapper -->

</body>
</html>
