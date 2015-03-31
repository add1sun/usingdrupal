<?php

/*
* Initialize theme settings
*/
$pixture_width = theme_get_setting('pixture_width');
pixture_validate_page_width($pixture_width);

/*
* Check the page width theme settings and reset to default 
* if the value is null, or invalid value is specified
*/
function pixture_validate_page_width($width)
{
  global $theme_key;

  /*
  * The default values for the theme variables. Make sure $defaults exactly
  * matches the $defaults in the theme-settings.php file.
  */
  $defaults = array(             // <-- change this array
    'pixture_width' => '85%',
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

  return $defaults['pixture_width'];
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
