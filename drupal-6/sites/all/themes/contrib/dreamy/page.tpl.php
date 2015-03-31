<?php
  // $Id: page.tpl.php,v 1.6 2007/12/14 16:03:48 jswaby Exp $
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language ?>" xml:lang="<?php print $language->language ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
  <!--[if IE 6]>
  <style type="text/css" media="all">@import "<?php print base_path().$directory ?>/ie6.css";</style>  
  <![endif]-->
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
</head>

<body>

	<div id="wrapper">

		<div id="header">
			<?php if (strlen($site_name) > 0) { ?><h1 class='site-name'><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print $site_name ?></a></h1><?php } ?>
			<?php if (strlen($site_slogan) > 0) { ?><div class='site-slogan'><?php print $site_slogan ?></div><?php } ?>
			<?php print $search_box ?>
		</div>

		<div id="menu">
			<?php if (isset($primary_links)) { ?><?php print theme('links', $primary_links, array('class' =>'links', 'id' => 'navlist')) ?><?php } ?>
		</div>
		
		<div id="content">
			<?php if (strlen($header) > 0) { ?><div id="top-header"><?php print $header ?></div><?php } ?>

			<?php if (strlen($mission) > 0) { ?><div id="mission"><?php print $mission ?></div><?php } ?>
			<div id="main">
				<?php print $breadcrumb ?>
				<h1 class="title"><?php print $title ?></h1>
				<div class="tabs"><?php print $tabs ?></div>
				<?php print $help ?>
				<?php print $messages ?>
				<?php print $content; ?>
                <?php if (isset($signature)): ?>
                  <div class="user-signature clear-block">
                    <?php print $signature ?>
                  </div>
                <?php endif; ?>
				<?php print $feed_icons; ?>
			</div>
		</div>

		<?php if (strlen($right) > 0 || strlen($left) > 0) { ?>
		<div id="sidebar">
			<div id="feed">
				<?php
					$incoming_link = l(' ', 'rss.xml');
					$incoming_link = str_replace("href", "class=\"feed-button\" href", $incoming_link);
					print $incoming_link;
				?>
			</div>
			<?php if (strlen($right) > 0) { ?>
			<div id="sidebar-right">
				<?php print $right ?>
				<div id="sidebar-bottom">
					&nbsp;
				</div>
			</div>
			<?php } ?>
			<?php if (strlen($left) > 0) { ?>
			<div id="sidebar-left">
				<div id="sidebar-top">
					&nbsp;
				</div>
				<?php print $left ?>
				<div id="sidebar-bottom">
					&nbsp;
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<div id="footer">
			<div id="footer-valid">
				<a href="http://validator.w3.org/check/referer">xhtml</a> / Ported by <a href="http://drupal.org/user/39343">Jason Swaby</a>
			</div>
			<?php print $footer ?>
			<?php print $footer_message ?>
		</div>
		<?php print $closure ?>
	</div>
</body>
</html>
