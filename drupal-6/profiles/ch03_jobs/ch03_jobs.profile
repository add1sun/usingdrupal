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
function ch03_jobs_profile_modules() {
  $modules = oreilly_common_modules();
  $modules[] = 'color';
  return $modules;
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile.
 */
function ch03_jobs_profile_details() {
  return array(
    'name' => 'Chapter 3: Job Posting',
    'description' => 'Select this profile to setup a site with for posting jobs with <strong>CCK</strong> and <strong>Views</strong>.'
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
function ch03_jobs_profile_task_list() {
}

/**
 * Perform any final installation tasks for this profile.
 *
 * @return
 *   An optional HTML string to display to the user on the final installation
 *   screen.
 */
function ch03_jobs_profile_tasks(&$task, $url) {
  // Load install_profile_api() functions.
  install_include(ch03_jobs_profile_modules());

  // Perform tasks common to all sites.
  oreilly_common_roles_add();
  oreilly_common_users_add();
  oreilly_common_menus_add();
  oreilly_common_types_add();

  // Add sample users that we'll need for later.
  install_add_user('Jane Faculty', 'oreilly', 'jane@example.com', array('editor'));
  install_add_user('Frank Faculty', 'oreilly', 'frank@example.com', array('editor'));
  install_add_user('Laura Faculty', 'oreilly', 'laura@example.com', array('editor'));
  install_add_user('Joe Jobless', 'oreilly', 'joe@example.com');
  install_add_user('Harry Hapless', 'oreilly', 'harry@example.com');

  // Set site theme.
  install_disable_theme('garland');
  install_default_theme('wabi');

  // Setup theme.
  $theme_info = theme_get_settings('wabi');
  $theme_info['info'] = color_get_info('wabi');
  $theme_info['var'] = 'theme_wabi_settings';
  $theme_info['theme'] = 'wabi';
  $theme_info['default_logo'] = 0;
  $theme_info['logo_path'] = file_directory_path() .'/logo.png';
  $theme_info['scheme'] = '';
  $theme_info['palette'] = array(
    "base" => "#ad8410",
    "link" => "#6c420e",
    "top" => "#ccc2b7",
    "bottom" => "#971702",
    "text" => "#494949",
  );
  $logo = './profiles/ch03_jobs/logo.png';
  file_copy($logo, file_directory_path());
  $form_state = array('values' => $theme_info);

  // Color module hard-codes arg(4) as the theme, so we can't use drupal_execute().
  color_scheme_form_submit(array(), $form_state);

  // Save theme specific settings.
  drupal_execute('system_theme_settings', $form_state);

  // Create a Welcome page.
  $node = new stdClass();
  $node->type = 'page';
  $node->title = st('Welcome to Epic University!');
  $node->body = st("At Epic University, we prepare you for the hard, cruel life after college. We're currently hiring experienced staff to keep Epic above the competition.");
  $node->format = 1;
  $node->status = 1;
  $node->revision = 1;
  $node->promote = 1;

  $node = node_submit($node);
  $node->uid = 1;
  node_save($node);

  // Set site front page to welcome page.
  variable_set('site_frontpage', 'node/1');

  // Uninstall the install_profile_api helper module.
  module_disable(array('install_profile_api'));
  drupal_set_installed_schema_version('install_profile_api', SCHEMA_UNINSTALLED);
}

/**
 * Instance of hook_form_alter().
 */
function ch03_jobs_form_alter(&$form, $form_state, $form_id) {
  orielly_common_form_alter($form, $form_state, $form_id);

  switch ($form_id) {
    case 'install_configure':
      $form['site_information']['site_name']['#default_value'] = 'Epic University';
      break;
  }
}
