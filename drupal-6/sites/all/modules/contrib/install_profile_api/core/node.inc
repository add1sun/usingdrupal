<?php

/**
 * Given a content_type array, enable the new content type.
 */
function install_add_content_type($content_type) {
  install_create_content_type($content_type['type'], $content_type['name'], $content_type);
}

/**
 * Given a content_type name, and an array of custom properties, enable
 * a new content type. This function is written to be self-documenting,
 * as it explicitly lists the properties you can set, and shows the defaults
 * if you don't set them.
 *
 * @param $content_type
 *   Required. Type id, only alpha-numeric and underscores.
 * @param $content_name
 *   Required. A descriptive name.
 * @param $properties
 *   Optional. An array of properties that describe the new node type.
 */
function install_create_content_type($content_type, $content_name, $properties = array()) {

  $default = array(
    'type' => $content_type,     // No default, must pass a content type id name
    'name' => st($content_name), // No default, must pass a content type display name
    'module' => 'node',
    'description' => st(''),
    'custom' => TRUE,
    'modified' => TRUE,
    'has_title' => TRUE,
    'has_body' => TRUE,
    'title_label' => 'Title',
    'body_label' => '',
    'locked' => FALSE,
    'min_word_count' => '0',
    'orig_type' => '',
    'help' => '',
  );
  $type = array_merge($default, $properties);

  $type = (object)_node_type_set_defaults($type);
  node_type_save($type);
}