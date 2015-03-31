<?php // $Id: page-maintenance.tpl.php,v 1.1.2.1 2008/04/27 11:07:31 melon Exp $ 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php print drupal_get_title() ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" href="<?php print path_to_theme(); ?>/favicon.ico" type="image/x-icon" />
  <style type="text/css" media="all">@import "<?php print path_to_theme(); ?>/maintenance.css";</style>
</head>
<body>
  <div id="content">
    <?php print $content ?>
  </div>
<?php if (!$partial) : ?></body></html><?php endif; ?>