<?php
// $Id$

// Include common O'Reilly installer tasks.
include_once './profiles/oreilly.inc';

/**
 * Return an array of the modules to be enabled when this profile is installed.
 *
 * @return
 *  An array of modules to be enabled.
 */
function ch10_store_profile_modules() {
  return oreilly_common_modules() + array('path');
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile.
 */
function ch10_store_profile_details() {
  return array(
    'name' => 'Chapter 10: Store',
    'description' => 'Select this profile to setup a site for an online store with <strong>Ubercart</strong>.'
  );
}

/**
 * Return a list of tasks that this profile supports.
 *
 * @return
 *   A keyed array of tasks the profile will perform during
 *   the final stage. The keys of the array will be used internally,
 *   while the values will be displayed to the user in the installer
 *   task list.
 */
function ch10_store_profile_task_list() {
}

/**
 * Perform any final installation tasks for this profile.
 *
 * @return
 *   An optional HTML string to display to the user on the final installation
 *   screen.
 */
function ch10_store_profile_tasks(&$task, $url) {
  // Load install_profile_api() functions.
  install_include(ch10_store_profile_modules());

  // Perform tasks common to all sites.
  oreilly_common_roles_add();
  oreilly_common_users_add();
  oreilly_common_menus_add();
  oreilly_common_types_add();

  // Setup theme.
  install_disable_theme('garland');
  install_default_theme('pixture');

  $theme_info = theme_get_settings('ad_novus-fluid');
  $theme_info['var'] = 'theme_pixture_settings';
  $theme_info['theme'] = 'pixture';
  $theme_info['toggle_logo'] = 0;
  $theme_info['pixture_width'] = '100%';
  $form_state = array('values' => $theme_info);
  
  // Save theme specific settings.
  drupal_execute('system_theme_settings', $form_state);

  // Create a Welcome page.
  $node = new stdClass();
  $node->type = 'story';
  $node->title = st('Welcome to Sweet Tees!');
  $node->body = st("Thanks for stopping by our store! Here you will find all of the products available by sweet tees.");
  $node->format = 1;
  $node->status = 1;
  $node->revision = 1;
  $node->promote = 1;

  $node = node_submit($node);
  $node->uid = 1;
  node_save($node);

  // Uninstall the install_profile_api helper module.
  module_disable(array('install_profile_api'));
  drupal_set_installed_schema_version('install_profile_api', SCHEMA_UNINSTALLED);
}

/**
 * Instance of hook_form_alter().
 */
function ch10_store_form_alter(&$form, $form_state, $form_id) {
  orielly_common_form_alter($form, $form_state, $form_id);

  switch ($form_id) {
    case 'install_configure':
      $form['site_information']['site_name']['#default_value'] = 'Sweet Tees';
      break;
  }
}
