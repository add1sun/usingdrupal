<?php // $Id: page.tpl.php,v 1.17 2008/06/03 00:18:36 brauerranch Exp $ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>">
  <head>
    <title><?php print $head_title ?></title>
    <?php print $head ?>

    <link type="text/css" rel="stylesheet" media="screen, projection" href="<?php print base_path() . path_to_theme(); ?>/assets/style/initial.css" />
    <?php print $styles ?>

    <!--[if lte IE 6]>
      <?php print $ie6_styles ?>
    <![endif]-->

    <!--[if lt IE 7]>
      <?php print $ie7_styles ?>
    <![endif]-->

    <?php print $scripts ?>
    <?php print $layout_style ?>
  </head>
  <body<?php print $body_class ?>>
    <div id="container">
      <div id="wrapper">
        <div id="header">
          <?php if ($search_box || $top) { ?>
            <div id="top">
              <?php print $top; ?>
              <?php if ($search_box): print $search_box; endif; ?>
              <hr class="hidden clear" />
            </div><!-- /top -->
          <?php } ?>
          <div id="logowrap">
            <div id="logo">
              <?php if ($logo || $site_title) { ?>
               <?php if ($is_front) : /* if we are on the front page use <h1> for site title */ ?>
                <h1><a href="<?php print $front_page ?>" title="<?php print $site_title ?>">
                   <?php if ($logo) { ?>
                     <img src="<?php print $logo ?>" alt="<?php print $site_title ?>" id="logo-image" />
                   <?php } ?>
                 <span><?php print $site_title ?></span></a></h1>
               <?php endif; ?>
               <?php if (!$is_front) : /* if we are not on the front page use <h2> for site title */ ?>
                <h2 class="sitetitle"><a href="<?php print $front_page ?>" title="<?php print $site_title ?>">
                   <?php if ($logo) { ?>
                     <img src="<?php print $logo ?>" alt="<?php print $site_title ?>" id="logo-image" />
                   <?php } ?>
                 <span><?php print $site_title ?></span></a></h2>
               <?php endif; ?>
              <?php } ?>
            </div>
            <?php if ($primary_links || $header) { ?>
              <div id="ie7menuhack">
                <div id="topmenu">
                  <?php print $header ?>
                  <?php if ($primary_links) { ?>
                    <div id="primary-links">
                      <?php print $primary_nav ?>
                    </div><!-- /primary-links -->
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
            <?php if ($site_slogan) { ?>
              <p id="tagline"><?php print $site_slogan ?></p>
            <?php } ?>
            <hr class="hidden clear" />
          </div>
        </div><!-- /header -->
        <?php if ($sidebar_left || $navigation_left || ($secondary_links && ($secondary_nav == "left"))) { ?>
          <div id="ie7contenthack"><div id="content-outer-wrap"><div id="content-wrap"><div id="content-inter-wrap">
        <?php } ?>
        <div id="content">
          <?php if ($banner) { ?>
            <div id="banner">
              <div class="<?php print $banner_chunk ?>">
                <?php print $banner ?>
              </div>
            </div><!-- /banner -->
          <?php } ?>
          <?php if ($breadcrumb): print $breadcrumb; endif; ?>
          <?php if ($sidebar_right || $navigation_right || ($secondary_links && ($secondary_nav == "right"))) { ?>
            <div id="main-content">
          <?php } ?>
          <div id="main">
            <?php if ($pre_content): print $pre_content; endif; ?>
            <?php if ($tabs): ?><div id="tabs-wrapper"><?php endif; ?>
            <?php if ($title): print '<h1'. ($tabs ? ' class="title with-tabs"' : ' class="title"') .'>'. $title .'</h1>'; endif; ?>
            <?php if ($tabs): ?><?php print $tabs ?></div><!-- /tabs-wrapper --><?php endif; ?>
            <?php if (!empty($tabs2)): print '<span class="clear"></span><ul class="tabs secondary">' . $tabs2 . '</ul><span class="clear"></span>'; endif; ?>
            <?php if ($help): print $help; endif; ?>
            <?php if ($show_messages && $messages): print $messages; endif; ?>
            <?php print $content ?>
          </div><!-- /main -->
          <?php if ($sidebar_right || $navigation_right || ($secondary_links && ($secondary_nav == "right"))) { ?>
            </div><!-- /main-content -->
          <?php } ?>
          <?php if ($sidebar_right || $navigation_right || ($secondary_links && ($secondary_nav == "right"))) { ?>
            <div id="sidebar-right">
              <?php if ($navigation_right || ($secondary_links && ($secondary_nav == "right"))) { ?>
                <div id="navigation_right">
                  <?php if ($secondary_links && ($secondary_nav == "right")) { ?>
                    <div class="navigation_right">
                      <?php print theme('links', $secondary_links, array('class' => 'secondary-links')) ?>
                    </div>
                  <?php } ?>
                  <?php print $navigation_right ?>
                </div><!-- /navigation_right -->
              <?php } ?>
              <?php if ($sidebar_right): print $sidebar_right; endif; ?>
            </div><!-- /sidebar-right -->
          <?php } ?>
          <hr class="hidden clear" />
        </div><!-- /content -->
        <?php if ($sidebar_left || $navigation_left || ($secondary_links && ($secondary_nav == "left"))) { ?>
          </div><!-- /content-inter-wrap -->
        <?php } ?>
        <?php if ($sidebar_left || $navigation_left || ($secondary_links && ($secondary_nav == "left"))) { ?>
          <div id="sidebar-left">
            <?php if ($navigation_left || ($secondary_links && ($secondary_nav == "left"))) { ?>
              <div id="navigation_left">
                <?php if ($secondary_links && ($secondary_nav == "left")) { ?>
                  <div class="navigation_left">
                    <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
                  </div>
                <?php } ?>
                <?php if ($navigation_left): print $navigation_left; endif; ?>
              </div><!-- /navigation_left -->
            <?php } ?>
            <?php if ($sidebar_left): print $sidebar_left; endif; ?>
          </div><!-- /sidebar-left -->
        <?php } ?>
        <?php if ($sidebar_left || $navigation_left || ($secondary_links && ($secondary_nav == "left"))) { ?>
          <hr class="hidden clear" />
          </div><!-- /content-wrap --></div><!-- /content-outer-wrap --></div><!-- /ie7contenthack -->
        <?php } ?>
        <?php if ($additional) { ?>
          <div id="additional-wrap">
            <div id="additional<?php if ($additional_chunk == "three-box") print "Three-box"; ?>">
              <div class="<?php print $additional_chunk ?>">
                <?php print $additional ?>
              </div>
              <hr class="hidden clear" />
            </div>
          </div><!-- /additional-wrap -->
        <?php } ?>
        <div id="footer">
          <?php if ($bottom): print $bottom; endif; ?>
          <?php if ($footer_message): print $footer_message; endif; ?>
        </div><!-- /footer -->
      </div><!-- /wrapper -->
    </div><!-- /container -->
    <?php print $closure ?>
  </body>
</html>
