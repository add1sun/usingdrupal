<?php

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Allows the profile to alter the site configuration form.
 */
function ch07_newssite_form_install_configure_form_alter(&$form, $form_state) {
  // Pre-populate the site name.
  $form['site_information']['site_name']['#default_value'] = 'Our Media';
  $form['site_information']['site_mail']['#default_value'] = 'ourmedia@example.com';
  $form['admin_account']['account']['name']['#default_value'] = 'admin';
  $form['admin_account']['account']['mail']['#default_value'] = 'admin@example.com';
}

