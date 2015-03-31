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
function ch08_i18n_profile_modules() {
  $modules = oreilly_common_modules();
  $modules[] = 'forum';
  return $modules;
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile.
 */
function ch08_i18n_profile_details() {
  return array(
    'name' => 'Chapter 8: Multilingual',
    'description' => 'Select this profile to setup a multilingual site with the <strong>i18n</strong> package.'
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
function ch08_i18n_profile_task_list() {
}

/**
 * Perform any final installation tasks for this profile.
 *
 * @return
 *   An optional HTML string to display to the user on the final installation
 *   screen.
 */
function ch08_i18n_profile_tasks(&$task, $url) {
  // Load install_profile_api() functions.
  install_include(ch08_i18n_profile_modules());

  // Perform tasks common to all sites.
  oreilly_common_roles_add();
  oreilly_common_users_add();
  oreilly_common_menus_add();
  oreilly_common_types_add();

  // Set site theme.
  install_disable_theme('garland');
  install_default_theme('dreamy');

  // Create a Welcome page.
  $node = new stdClass();
  $node->type = 'story';
  $node->title = st('Welcome');
  $node->body = st('We hope this site will be useful to bird enthusiasts from all over the world. Get an <a href="/user/register">account</a> and join the discussion in our <a href="/forum">forums</a>!');
  $node->format = 1;
  $node->status = 1;
  $node->revision = 1;
  $node->promote = 1;

  $node = node_submit($node);
  $node->uid = 1;
  node_save($node);
  
  // Set up the forums.
  // Make the container first.
  $vid = install_taxonomy_get_vid('Forums');
  $container = install_taxonomy_add_term($vid, 'Types of Birds', 'Discussions grouped by bird classifications.');
  variable_set('forum_containers', array($container));
  // Now add the forums.
  install_taxonomy_add_term($vid, 'Raptors', 'Birds of prey.', array('parent' => $container));
  install_taxonomy_add_term($vid, 'Water birds', 'Birds that live on or near the water.', array('parent' => $container));
  // Stupid vid isn't being saved on the forum terms so I'm jamming it in there manually.
  db_query("UPDATE {term_data} SET vid = %d WHERE vid = 0", $vid);
  
  // Uninstall Locale module because core is silly:
  // http://drupal.org/node/310863.
  module_disable(array('locale'));

  // Uninstall the install_profile_api helper module.
  module_disable(array('install_profile_api'));
  drupal_set_installed_schema_version('install_profile_api', SCHEMA_UNINSTALLED);
}

/**
 * Instance of hook_form_alter().
 */
function ch08_i18n_form_alter(&$form, $form_state, $form_id) {
  orielly_common_form_alter($form, $form_state, $form_id);

  switch ($form_id) {
    case 'install_configure':
      $form['site_information']['site_name']['#default_value'] = 'Migratory Patterns';
      break;
  }
}
