<?php
// $Id: template.php,v 1.13 2008/06/01 04:13:46 brauerranch Exp $

/**
 * @file
 * template.php for the Light Fantastic theme for Drupal 6.
 *
 * This file provides overrides and theme-specific functions for the Light
 * Fantastic theme for Drupal 6 and higher.
 */

/**
 * Override or insert variables into the page template.
 */
function lightfantastic_preprocess_page(&$vars) {
  
  $vars['site_title'] = !empty($vars['site_name']) ? check_plain($vars['site_name']) : '';
  $vars['ie6_styles'] = '<link type="text/css" rel="stylesheet" media="all" href="' . base_path() . path_to_theme() . '/assets/style/ie6.css" />'. "\n";
  $vars['ie7_styles'] = '<link type="text/css" rel="stylesheet" media="all" href="' . base_path() . path_to_theme() . '/assets/style/ie7.css" />'. "\n";
  $vars['primary_nav'] = isset($vars['primary_links']) ? theme('links', $vars['primary_links'], array('id' => 'main-menu')) : FALSE;
  $vars['tabs2'] = menu_secondary_local_tasks();
  
  /**
   * Set width for the site and two sidebars:
   * This theme allows the site to have a fluid or fixed width layout.
   * Setting a value for the fixed width will force the layout to be fixed.
   * For fluid layouts, maximum and minimum widths could be set.
   * For any layout, Left and Right column widths could be set.
   * If fixed width, maximum and minimum widths would be ignored.
   */
  
  $site_fixed_width    = '960px'; // Width if fixed-width layout. Leave blank ('') for fluid layout.
  $site_min_width      = '760px'; // Minimum width if fluid layout.
  $site_max_width      = '960px'; // Maximum width if fluid layout.
  $left_sidebar_width  = '240px'; // Width of left column.
  $right_sidebar_width = '240px'; // Width of right column.
  $secondary_nav       = "left";
  
  // Set page width.
  if ($site_fixed_width == "") {
    $site_fixed_width = (($site_max_width - $site_min_width) < 0 ) ? "960px" : "" ;
  }
  $site_width = ($site_fixed_width != "") ? "width: $site_fixed_width;" : "max-width: $site_max_width; min-width: $site_min_width;" ;
  
  if ($site_fixed_width == "") {
    $site_fixed_width = (($site_max_width - $site_min_width) < 0 ) ? "1" : "" ;
  }
  $is_fixed_width = ($site_fixed_width != "") ? "0" : "1" ;
  
  // Secondary navigation position.
  $vars['secondary_nav'] = $secondary_nav == 'right' ? 'right' : 'left';
  
  $style = "";
  $style .= '<style type="text/css">';
  $style .= "div#container { $site_width }";
  
  if ($vars['sidebar_left'] || $vars['navigation_left'] || ($vars['secondary_links'] && $vars['secondary_nav'] == 'left')) {
    $style .= "div#content-wrap div#content-inter-wrap { margin-left: -$left_sidebar_width; }";
    $style .= "div#content-wrap div#sidebar-left { width: $left_sidebar_width; }";
    $background = 1000 - $left_sidebar_width;
    $style .= "div#content-outer-wrap { background-position: -". $background ."px top; }";
    $style .= "div#content-wrap div#content { margin-left: $left_sidebar_width; }";
  }
  
  if (($vars['sidebar_left'] || $vars['navigation_left']  || ($vars['secondary_links'] && $vars['secondary_nav'] == 'left'))
    && ($vars['sidebar_right'] || $vars['navigation_right'] || ($vars['secondary_links'] && $vars['secondary_nav'] == 'right'))) {
    $style .= "div#content-wrap div#content { margin-left: $left_sidebar_width; }";
  }
  
  if ($vars['sidebar_right'] || $vars['navigation_right'] || ($vars['secondary_links'] && $vars['secondary_nav'] == 'right')) {
    $style .= "div#container div#main-content { margin-left: -$right_sidebar_width; }";
    $style .= "div#container div#main { margin-left: $right_sidebar_width; }";
    $style .= "div#container div#sidebar-right { width: $right_sidebar_width; }";
  }
  
  $style .= '</style>';
  
  if ($is_fixed_width) {
    // IE6 min-width, max-width expression.
    $style .= '
    	<!--[if lte IE 6]>
    		<style type="text/css">
    			div#container { width: expression(document.body.clientWidth < '. ($site_min_width + 1) .' ? "'. $site_min_width .'" : document.body.clientWidth > '. ($site_max_width + 1) .' ? "'. $site_max_width .'" : "100%"); }
    		</style>
    	<![endif]-->';
  }
  
  $vars['layout_style'] = $style;

  // Sets the body-tag class attribute.
  // Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
  $vars['body_class'] = isset($vars['body_class']) ? $vars['body_class'] : '';
  if ((($vars['sidebar_left'] || $vars['navigation_left'] || ($vars['secondary_links'] && ($vars['secondary_nav'] == 'left'))))
    && ($vars['sidebar_right'] || $vars['navigation_right'] || ($vars['secondary_links'] && ($vars['secondary_nav'] == 'right')))) {
    $body_class = 'sidebars';
  }
  else {
    if ($vars['sidebar_left'] || $vars['navigation_left'] || ($vars['secondary_links'] && ($vars['secondary_nav'] == 'left'))) {
      $body_class = 'sidebar-left';
    }
    if ($vars['sidebar_right'] || $vars['navigation_right'] || ($vars['secondary_links'] && ($vars['secondary_nav'] == 'right'))) {
      $body_class = 'sidebar-right';
    }
  }
  if (isset($body_class)) {
    $vars['body_class'] = ' class="'. $body_class .'"';
  }

  // Get published block in 'additional' region and set 'additional_chunk' variable.
  switch (count(block_list('additional'))) {
    case 0:
      $vars['additional_chunk'] = "";
      break;
    case 1:
      $vars['additional_chunk'] = "chunk-one";
      break;
    case 2:
      $vars['additional_chunk'] = "chunk-two";
      break;
    case 3:
      $vars['additional_chunk'] = "chunk-three";
      break;
    default:
      $vars['additional_chunk'] = "chunk-unknown";
  }
  
  // Get published block in 'banner' region and set 'banner_chunk' variable.
  switch (count(block_list('banner'))) {
    case 0:
      $vars['banner_chunk'] = "";
      break;
    case 1:
      $vars['banner_chunk'] = "chunk-one";
      break;
    case 2:
      $vars['banner_chunk'] = "chunk-two";
      break;
    case 3:
      $vars['banner_chunk'] = "chunk-three";
      break;
    default:
      $vars['banner_chunk'] = "chunk-unknown";
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function lightfantastic_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div id="breadcrumb">'. implode(' &raquo; ', $breadcrumb) .'</div>';
  }
  else {
    return '<div id="breadcrumb">&nbsp;</div>';
  }
}

/**
 * Allow themable wrapping of all comments.
 */
function lightfantastic_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div>';
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs.
 *
 * @ingroup themeable
 */
function lightfantastic_menu_local_tasks() {
  $output = '';

  if ($primary = menu_primary_local_tasks()) {
    $output .= "<ul class=\"tabs primary\">\n". $primary ."</ul>\n";
  }

  return $output;
}

function lightfantastic_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function lightfantastic_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

