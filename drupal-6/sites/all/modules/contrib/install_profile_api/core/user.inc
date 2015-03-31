<?php
// $Id: user.inc,v 1.1.2.4 2008/08/20 20:24:00 quicksketch Exp $

/**
 * Add a user.
 */
function install_add_user($username, $password, $email, $roles = array(), $status = 1) {
  user_save(
    new stdClass(),
    array(
      'name' => $username, 
      'pass' => $password,
      'mail' => $email,
      'roles' => $roles,
      'status' => $status
    )
  );	
}

/**
 * Add a role to the roles table.
 */
function install_add_role($name) {
  // Check to see if role already exists. If not, create it.
  $rid = install_get_rid($name);
  if (!$rid) {
    db_query("INSERT INTO {role} (name) VALUES ('%s')", $name);
  }
  
  return ($rid) ? $rid : install_get_rid($name);
}

/**
 * Get the role ID for the role name.
 */
function install_get_rid($name) {
  return db_result(db_query("SELECT rid FROM {role} WHERE name ='%s' LIMIT 1", $name));
}

/**
 * Set the permission for a certain role.
 */
function install_set_permissions($rid, $perms) {
  // Retrieve the currently set permissions.
  $result = db_query("SELECT p.perm FROM {role} r INNER JOIN {permission} p ON p.rid = r.rid WHERE r.rid = %d ", $rid);
  $existing_perms = array();
  while ($row = db_fetch_object($result)) {
    $existing_perms += explode(', ', $row->perm);
  }
  // If this role already has permissions, merge them with the new permissions being set.
  if (count($existing_perms) > 0) { 
    $perms = array_unique(array_merge($perms, (array)$existing_perms));
  }

  // Update the permissions.
  db_query('DELETE FROM {permission} WHERE rid = %d', $rid);
  db_query("INSERT INTO {permission} (rid, perm) VALUES (%d, '%s')", $rid, implode(', ', $perms));
}
