<?php
/**
 * @file oreilly.inc
 *   Common install profile logic used in all chapters of the book.
 */

/**
 * Return a list of standard modules.
 */
function oreilly_common_modules() {
  return array('block', 'comment', 'dblog', 'filter', 'help', 'menu', 'node', 'system', 'taxonomy', 'user', 'install_profile_api');
}

/**
 * Add roles used in all chapters.
 */
function oreilly_common_roles_add() {
  install_add_role('site administrator');
  install_add_role('editor');
}

/**
 * Add users used in all chapters.
 */
function oreilly_common_users_add() {
  install_add_user('user', 'oreilly', 'user@example.com');
  install_add_user('editor', 'oreilly', 'editor@example.com', array('editor'));
}

/**
 * Add a "Home" link to all sites.
 */
function oreilly_common_menus_add() {
  install_menu_create_menu_item('<front>', st('Home'), st('Back to the home page'), 'primary-links', 0 , -10);
}

/**
 * Add node types used in all chapters.
 */
function oreilly_common_types_add() {
  // Insert default user-defined node types into the database.
  // For a complete list of available node type attributes, refer to the node
  // type API documentation at:
  // http://api.drupal.org/api/HEAD/function/hook_node_info
  $types = array(
    array(
      'type' => 'page',
      'name' => st('Page'),
      'module' => 'node',
      'description' => st('If you want to add a static page, like a contact page or an about page, use a page.'),
      'custom' => TRUE,
      'modified' => TRUE,
      'locked' => FALSE,
    ),
    array(
      'type' => 'story',
      'name' => st('Story'),
      'module' => 'node',
      'description' => st('Stories are articles in their simplest form: they have a title, a teaser and a body, but can be extended by other modules. The teaser is part of the body too. Stories may be used as a personal blog or for news articles.'),
      'custom' => TRUE,
      'modified' => TRUE,
      'locked' => FALSE,
    ),
  );

  foreach ($types as $type) {
    $type = (object) _node_type_set_defaults($type);
    node_type_save($type);
  }

  // Default page to not be promoted and have comments disabled.
  variable_set('node_options_page', array('status'));
  variable_set('comment_page', COMMENT_NODE_DISABLED);

  // Don't display date and author information for page nodes by default.
  $theme_settings = variable_get('theme_settings', array());
  $theme_settings['toggle_node_info_page'] = FALSE;
  variable_set('theme_settings', $theme_settings);
}

/**
 * Alter all the installer forms across all chapters.
 */
function orielly_common_form_alter(&$form, &$form_state, $form_id) {
  switch ($form_id) {
    case 'install_configure':
      $form['site_information']['site_mail']['#default_value'] = 'admin@example.com';
      $form['admin_account']['account']['name']['#default_value'] = 'admin';
      $form['admin_account']['account']['mail']['#default_value'] = 'admin@example.com';
      $form['admin_account']['account']['pass']['#default_value'] = 'oreilly';
      $form['admin_account']['account']['pass']['#type'] = 'textfield';
      $form['admin_account']['account']['pass']['#title'] = t('Password');
      $form['admin_account']['account']['pass']['#description'] = t('This password field has been changed to plain text to ease the installation process.');
      break;
  }
}
