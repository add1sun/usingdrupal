<?php

/**
 * Add a new plain block provided by block module.
 */
function install_add_block($module, $delta, $theme, $status, $weight, $region, $visibility = 0, $pages = '', $custom = 0, $throttle = 0, $title = '') {
  db_query("INSERT INTO {blocks} (module, delta, theme, status, weight, region, visibility, pages, custom, throttle, title) 
     VALUES ('%s', '%s', '%s', %d, %d, '%s', %d, '%s', %d, %d, '%s')", 
     $module, $delta, $theme, $status, $weight, $region, $visibility, $pages, $custom, $throttle, $title);
  if ($module == 'block') {
    $box = db_fetch_object(db_query('SELECT * FROM {boxes} WHERE bid=%d', $delta));
    db_query("INSERT INTO {boxes} (bid, body, info, format) VALUES (%d, '%s', '%s', '%s')", $box->bid, $box->body, $box->info, $box->format);
  }
}

/**
 * Creates a new block role.
 */
function install_add_block_role($module, $delta, $rid) {
  db_query("INSERT INTO {blocks_roles} (module,delta,rid) VALUES ('%s', '%s', %d)", $module, $delta, $rid);
}
