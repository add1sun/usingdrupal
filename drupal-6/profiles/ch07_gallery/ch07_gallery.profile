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
function ch07_gallery_profile_modules() {
  return oreilly_common_modules() + array('search');
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile.
 */
function ch07_gallery_profile_details() {
  return array(
    'name' => 'Chapter 7: Image Gallery',
    'description' => 'Build an image gallery with <strong>ImageField</strong>, <strong>ImageCache</strong>, and <strong>Custom Pagers</strong> modules.'
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
function ch07_gallery_profile_task_list() {
}

/**
 * Perform any final installation tasks for this profile.
 *
 * @return
 *   An optional HTML string to display to the user on the final installation
 *   screen.
 */
function ch07_gallery_profile_tasks(&$task, $url) {
  // Load install_profile_api() functions.
  install_include(ch07_gallery_profile_modules());

  // Perform tasks common to all sites.
  oreilly_common_roles_add();
  oreilly_common_users_add();
  oreilly_common_menus_add();
  oreilly_common_types_add();

  // Set site theme.
  install_disable_theme('garland');
  install_default_theme('ubiquity');

  // Setup theme.
  $theme_info = theme_get_settings('ubiquity');
  $theme_info['var'] = 'theme_ubiquity_settings';
  $theme_info['theme'] = 'ubiquity';
  $theme_info['default_logo'] = 0;
  $theme_info['logo_path'] = file_directory_path() .'/logo.png';

  $logo = './profiles/ch07_gallery/logo.png';
  file_copy($logo, file_directory_path());
  $form_state = array('values' => $theme_info);

  // Save theme specific settings.
  drupal_execute('system_theme_settings', $form_state);

  // Create a Welcome page.
  $node = new stdClass();
  $node->type = 'story';
  $node->title = st('Welcome to the Robinson Family Photo-Swap!');
  $node->body = st("The Family Photo-Swap is a place where the Robinsons share family photos. You can browse around or share your own photos with the Robinson family!");
  $node->format = 1;
  $node->status = 1;
  $node->revision = 1;
  $node->promote = 1;
  $node->sticky = 1;

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
function ch07_gallery_form_alter(&$form, $form_state, $form_id) {
  orielly_common_form_alter($form, $form_state, $form_id);

  switch ($form_id) {
    case 'install_configure':
      $form['site_information']['site_name']['#default_value'] = 'Robinson Family Photo-Swap';
      break;
  }
}
