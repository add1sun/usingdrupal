<?php

/*
* Initialize theme settings
*/
$wabi_width = theme_get_setting('wabi_width');
wabi_validate_page_width($wabi_width);

/*
* Check if a node has the specified term or not
*/
function does_node_have_term($term_array, $word)
{
  if(empty($term_array)) return 0;
  if(!is_array($term_array)) return 0;

  foreach($term_array as $a_term) {
    if(preg_match("/$word/i", $a_term['title'])) {
      return 1; // found the word
    }
  }
  return 0;
}
/*
* Check the page width theme settings and reset to default 
* if the value is null, or invalid value is specified
*/
function wabi_validate_page_width($width)
{
  global $theme_key;

  /*
  * The default values for the theme variables. Make sure $defaults exactly
  * matches the $defaults in the theme-settings.php file.
  */
  $defaults = array(             // <-- change this array
    'wabi_width' => '90%',
  );

  // check if it is liquid (%) or fixed width (px)
  if(preg_match("/(\d+)\s*%/", $width, $match)) {
    $liquid = 1;
    $num = intval($match[0]);
    if(50 <= $num && $num <= 100) {
      return $num . "%";  // OK!
    }
  }
  else if(preg_match("/(\d+)\s*px/", $width, $match)) {
    $fixed = 1;
    $num = intval($match[0]);
    if(800 <= $num && $num < 1600) {
      return $num . "px"; // OK
    }
  }
  
  // reset to default value
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, theme_get_settings($theme_key))
  );
  // Force refresh of Drupal internals
  theme_get_setting('', TRUE);

  return $defaults['wabi_width'];
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}
