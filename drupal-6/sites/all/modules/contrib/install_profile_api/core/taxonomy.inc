<?php
// $Id: taxonomy.inc,v 1.1.2.3 2008/08/15 20:30:32 quicksketch Exp $

/**
 * Given the name of a vocabulary, return its Vocab ID.
 *
 * @param $name
 *   A text string identifying the vocabulary.
 */
function install_taxonomy_get_vid($name) {
  // Not guaranteed to be unique, hence the LIMIT.
  return db_result(db_query_range("SELECT vid FROM {vocabulary} WHERE name = '%s'", $name, 0, 1));
};

/**
 * Given the name of a term, return its tid.
 *
 * @param $name
 *   A term name to search on.
 */
function install_taxonomy_get_tid($name) {
  // Not guaranteed to be unique, hence the LIMIT.
  return db_result(db_query_range("SELECT tid FROM {term_data} WHERE name = '%s'", $name, 0, 1));
};

/**
 * Create a new taxonomy vocabulary
 * 
 * @param $vocab_name
 *   The vocabulary name.
 * @param $node_types
 *   Optional. An array of content types.
 * @param $properties
 *   Optional additional properties to the vocabulary
 * @return  integer
 *   The database ID of the created vocabulary.
 */
function install_taxonomy_add_vocabulary($vocab_name, $content_types = array(), $properties = array()) {
  $return = 0;

  // Default properties so you don't have to pass anything.
  $defaults = array(
    'name' => $vocab_name,
    'multiple' => 0,
    'required' => 0,
    'hierarchy' => 0,
    'relations' => 0,
    'module' => 'event',
    'weight' => 0,
    'nodes' => $content_types,
  );

  $vocabulary = array_unique(array_merge($defaults, $properties));
  taxonomy_save_vocabulary($vocabulary);
  $return = install_taxonomy_get_vid($vocab_name);
  
  return $return;
}// end - function

/**
 * Create a new taxonomy term.
 *
 * @param $vid
 *   The vocabulary ID
 * @param $name
 *   The text name of the new term.
 * @param $description
 *   Term description.
 * @return integer
 *   The database ID of the created term.
 */
function install_taxonomy_add_term($vid, $name, $description = '', $properties = array()) {
  $return = 0;
  // default properties.
  $defaults = array(
    'name' => st($name),
    'description' => $description,
    'parent' => array(),
    'relations' => array(),
    'weight' => 0,
    'vid' => $vid,
  );
  $term = array_unique(array_merge($defaults, $properties));
  taxonomy_save_term($term);
  
  $return = install_taxonomy_get_tid(st($name));
  
  return $return;
}

/**
 * Assign a term to a node.
 *
 * TODO: NOT TESTED FOR D6 - MAY STILL BE ONLY D5
 * NOTE: does not check whether the assignment is valid.
 *
 * @param $vocab
 *   The vocabulary ID.
 * @param $name
 *   The text name of the new term.
 */
function install_taxonomy_assign_nid_tid($nid, $tid) {
  if (!$tid || !$nid) {
    return;
  }
  db_query('DELETE FROM {term_node} WHERE nid = %d AND tid = %d', $nid, $tid);
  db_query('INSERT INTO {term_node} (nid, tid) VALUES (%d, %d)', $nid, $tid);
}
