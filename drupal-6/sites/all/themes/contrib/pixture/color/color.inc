<?php
// $Id: color.inc,v 1.1.4.1 2008/04/23 05:21:27 pixture Exp $

$info = array(

  // Pre-defined color schemes
  'schemes' => array(
	// base, link, gradation(top), gradation(bottom), text
    '#eb52c1,#b21f88,#b800a6,#ff6bfe,#555555' => t('Girly Pink (Default)'),
    '#de8291,#c55964,#861509,#f8306a,#555555' => t('Red Carpet'),
    '#d59648,#865518,#572e05,#eb8919,#555555' => t('Caramel Brown'),
    '#cfb377,#90712c,#463406,#e6bd5c,#555555' => t('Earth Brown'),
    '#f7b42b,#8e6130,#ec8c04,#fade42,#555555' => t('Orange Sunset'),
    '#d1bc00,#6c7019,#d5be01,#f0fd58,#555555' => t('Gold Yellow'),
    '#afc94a,#61751f,#2d3701,#d2f943,#555555' => t('Olive Garden'),
    '#9bc068,#3c7c41,#0e3d0b,#6beb37,#555555' => t('Forest Green'),
    '#83b49f,#486156,#174431,#52bf90,#555555' => t('Teal'),
    '#76c9cb,#317d81,#054f52,#00d1bc,#555555' => t('Aquamarine'),
    '#7bc0ea,#3561b1,#025fb1,#62c8fd,#555555' => t('Ocen Water'),
    '#9ab1f9,#4b5cc3,#062984,#5283ff,#555555' => t('Deep Blue'),
    '#b0a2f6,#7958a7,#25008f,#c49eff,#555555' => t('Purple Haze'),
    '#ba90c6,#935b9f,#250c27,#c271d0,#555555' => t('Violet'),
    '#9397d7,#575dc1,#091c3e,#d0d6f6,#555555' => t('Graphite'),
    '#54677d,#3d5c85,#282e39,#8692a7,#555555' => t('Ash'),
    '#aaaeb1,#4d637a,#8c909b,#eeecec,#555555' => t('Silver'),
  ),

  // Images to copy over
  'copy' => array(
    'images/menu-collapsed.gif',
    'images/menu-expanded.gif',
    'images/menu-leaf.gif',
    'images/button.gif',
    'images/button-o.gif',
	'images/teaser-tl.gif',
	'images/teaser-tc.gif',
	'images/teaser-tr.gif',
	'images/teaser-ml.gif',
	'images/teaser-mr.gif',
	'images/teaser-bl.gif',
	'images/teaser-bc.gif',
	'images/teaser-br.gif',
	'images/logo.png',
  ),

  // CSS files (excluding @import) to rewrite with new color scheme.
  // NOTE: this is new to Drupal 6.x
  'css' => array(
    'style.css',
  ),

  // Coordinates of gradient (x, y, width, height)
  'gradient' => array(0, 0, 800, 94),

  // Color areas to fill (x, y, width, height)
  'fill' => array(
    'base' => array(0, 0, 800, 570),
    'link' => array(240, 530, 40, 40),	
  ),

  // Coordinates of all the theme slices (x, y, width, height)
  // with their filename as used in the stylesheet.
  'slices' => array(
    'images/header.png'                    => array(  0,   0, 512,  88),
    'images/bg-header.png'                 => array(792,   0,   8, 120),
    'images/bg-footer.png'                 => array(792,   0,   8,  88),
    'images/bg-menu.png'                   => array(  0,  88,   8,  32),
	'images/bg-title.png'                  => array( 20, 130,  10,  10),
	'images/bg-wall.png'                   => array(792, 120,   8, 408),

    'images/bg-bar-lite.png'               => array(  0, 530,   8,  40),
    'images/bg-bar.png'                    => array( 20, 530,   8,  40),

    'images/bg-lbar-lite.png'              => array(270, 530,   8,  40),
    'images/bg-lbar.png'                   => array(250, 530,   8,  40),

	'images/block-tl.png'                  => array( 10, 130,  10,  10),
	'images/block-tr.png'                  => array(220, 130,  10,  10),
	'images/block-bl.png'                  => array( 10, 330,  10,  10),
	'images/block-br.png'                  => array(220, 330,  10,  10),

	'images/sticky-tl.png'                 => array(250, 130,  10,  10),
	'images/sticky-tr.png'                 => array(770, 130,  10,  10),
	'images/sticky-bl.png'                 => array(250, 320,  10,  10),
	'images/sticky-br.png'                 => array(770, 320,  10,  10),

    'screenshot.png'                       => array(  0,   0, 700, 420),
  ),

  // Reference color used for blending. Matches the base.png's colors.
  'blend_target' => '#ffffff',

  // Preview files
  'preview_image' => 'color/preview.png',
  'preview_css' => 'color/preview.css',

  // Base file for image generation
  'base_image' => 'color/base.png',
);
