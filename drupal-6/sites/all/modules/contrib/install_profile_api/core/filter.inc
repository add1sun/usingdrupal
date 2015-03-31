<?php
// $Id: filter.inc,v 1.1.2.2 2008/08/15 03:00:29 quicksketch Exp $

/**
 * Set the roles that can be used with the filter.
 *
 * @param $roles
 *   An array of role IDs.
 * @param $format_id
 *   An integer of the format ID.
 */
function install_format_set_roles($roles, $format_id) {
  $roles = implode(',',$roles);	
  db_query("UPDATE {filter_formats} SET roles = '%s' WHERE format = %d", $roles, $format_id);
}

/**
 * Add a new input format .
 *
 * @param $name
 *   The human-readable name of the new format.
 * @param $cache
 *   If this format is cacheable.
 */
function install_add_format($name, $cache = 1) {
  $format_id = db_next_id('{filter_formats}_fid');
  // Check explicitly for format_id <= 3. If the database was improperly prefixed,
  // this would cause a nasty infinite loop or duplicate mid errors.
  // TODO: have automatic prefixing through an installer to prevent this.
  while ($format_id <= 3) {
    $format_id = db_next_id('{filter_formats}_fid');
  }
  db_query("INSERT INTO {filter_formats} (`format`, `name`, `roles`, `cache`) VALUES (%d, '%s', '', %d)", $format_id, $name, $cache);
  return $format_id;
}

/**
 * Remove the specified filter from the specified format.
 * @param $format_id
 *   The ID of the format to remove the filter from.
 * @param $module
 *   The module this filter belongs to.
 * @param $delta
 *   The delta of this filter.
 *
 * NOTE: the module name + the delta is what uniquely identifies a filter
 */
function install_remove_filter($format_id, $module, $delta) {	
  db_query("DELETE FROM {filters} WHERE format = %d AND module = '%s' AND delta = %d", $format_id, $module, $delta);
}

/**
 * Add a filter to an input format.
 *
 * @param $format_id
 *   The ID of the format to add the filter to.
 * @param $module
 *   The module this filter belongs to.
 * @param $delta
 *   The delta of this filter.
 * @param $weight
 *   The weight to be applied to this filter.
 */
function install_add_filter($format_id, $module, $delta = 0, $weight = 0) {
  db_query("INSERT INTO {filters} (`format`, `module`, `delta`, `weight`) VALUES (%d, '%s', %d, %d)", $format_id, $module, $delta, $weight);
}
