<?php

function newmarine_preprocess_page(&$vars) {
  $vars['random_number'] = rand(1, 100);
}

function newmarine_preprocess_node(&$vars) {
  // Change the submitted value to output like "Posted on June 12, 2008".
  $vars['submitted'] = t('Posted on') .' '. format_date($vars['node']->created, 'custom', 'F j, Y');
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function newmarine_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' :: ', $breadcrumb) .'</div>';
  }
}