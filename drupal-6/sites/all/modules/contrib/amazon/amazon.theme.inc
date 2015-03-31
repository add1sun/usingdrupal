<?php
// $Id: amazon.theme.inc,v 1.1.2.1 2008/06/05 08:08:14 eaton Exp $

function theme_amazon_inline_item($item) {
  $alt_theme = 'amazon_inline_item_' . _amazon_clean_type($item['producttypename']);
  if ($output = theme($alt_theme, $item)) {
    return $output;
  }
  else {
    $output = '<span class="'. _amazon_item_classes($item) .' amazon-item-inline">';
    $output .= l($item['title'], $item['detailpageurl']);
    $output .= '</span>';
    return $output;
  }
}
