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
function ch05_wiki_profile_modules() {
  $modules = oreilly_common_modules();
  $modules[] = 'search';
  return $modules;
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile.
 */
function ch05_wiki_profile_details() {
  return array(
    'name' => 'Chapter 5: Wiki',
    'description' => 'Select this profile to setup a site to build a wiki using the <strong>Freelinking</strong>, <strong>Markdown</strong>, <strong>Pathauto</strong>, and <strong>Diff</strong> modules.'
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
function ch05_wiki_profile_task_list() {
}

/**
 * Perform any final installation tasks for this profile.
 *
 * @return
 *   An optional HTML string to display to the user on the final installation
 *   screen.
 */
function ch05_wiki_profile_tasks(&$task, $url) {
  // Load install_profile_api() functions.
  install_include(ch05_wiki_profile_modules());

  // Perform tasks common to all sites.
  oreilly_common_roles_add();
  oreilly_common_users_add();
  oreilly_common_menus_add();
  oreilly_common_types_add();

  // Set site theme.
  install_disable_theme('garland');
  install_default_theme('barlow');

  // Create a Welcome page.
  $node = new stdClass();
  $node->type = 'page';
  $node->title = st('About the SGA Wiki');
  $node->body = st("Welcome to the SGA wiki site. This wiki is a central place for all members to work together on internal documentation and planning.");
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
function ch05_wiki_form_alter(&$form, $form_state, $form_id) {
  orielly_common_form_alter($form, $form_state, $form_id);

  switch ($form_id) {
    case 'install_configure':
      $form['site_information']['site_name']['#default_value'] = 'Berchem University SGA';
      break;
  }
}
