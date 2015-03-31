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
function ch06_newspaper_profile_modules() {
  return oreilly_common_modules();
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile.
 */
function ch06_newspaper_profile_details() {
  return array(
    'name' => 'Chapter 6: Online Newspaper',
    'description' => 'Select this profile to setup a site for publishing news online using the <strong>Trigger,</strong> <strong>Workflow,</strong> <strong>Workspace</strong> and <strong>Views Bulk Operations</strong> modules.'
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
function ch06_newspaper_profile_task_list() {
}

/**
 * Perform any final installation tasks for this profile.
 *
 * @return
 *   An optional HTML string to display to the user on the final installation
 *   screen.
 */
function ch06_newspaper_profile_tasks(&$task, $url) {
  // Load install_profile_api() functions.
  install_include(ch06_newspaper_profile_modules());

  // Perform tasks common to all sites.
  oreilly_common_roles_add();
  oreilly_common_users_add();
  oreilly_common_menus_add();
  oreilly_common_types_add();

  // Set site slogan.
  variable_set('site_slogan', st('Covering the Minneapolis St. Paul art scene'));

  // Setup theme.
  install_disable_theme('garland');
  install_default_theme('lightfantastic');

  // Because we want this site to start with a number of articles already,
  // we'll generate a list of 20 starter articles.
  for ($x = 1; $x <= 20; $x++) {
    // Create a random story for the paper.
    $node = new stdClass();
    $node->type = 'story';
    $node->title = st("News story @story_number", array('@story_number' => $x));
    $node->body = ch06_newspaper_dada();
    $node->format = 1;
    $node->status = 1;
    $node->revision = 1;
    $node->promote = 1;

    $node = node_submit($node);
    $node->uid = 3; // We want these articles to be written by the 'user'
    node_save($node);
  }

  // Uninstall the install_profile_api helper module.
  module_disable(array('install_profile_api'));
  drupal_set_installed_schema_version('install_profile_api', SCHEMA_UNINSTALLED);
}

/**
 * Instance of hook_form_alter().
 */
function ch06_newspaper_form_alter(&$form, $form_state, $form_id) {
  orielly_common_form_alter($form, $form_state, $form_id);

  switch ($form_id) {
    case 'install_configure':
      $form['site_information']['site_name']['#default_value'] = 'Twin City Arts';
      break;
  }
}


/**
 * Generate poststructuralist literary hand-waving.
 * Not a very smart algorithm, but we're not trying
 * to fool a literature professor, or anything like
 * that.
 */
function ch06_newspaper_dada() {
  $paragraphs = array(
    "If one examines posttextual materialism, one is faced with a choice: either accept Foucaultist power relations or conclude that context is a product of communication. Hamburger= implies that we have to choose between posttextual materialism and dialectic narrative.",
    "The main theme of the works of Spelling is the collapse, and some would say the failure, of pretextual consciousness. Thus, the subject is contextualised into a that includes narrativity as a totality. The paradigm, and eventually the defining characteristic, of posttextual materialism prevalent in Spelling's Models, Inc. emerges again in Melrose Place.",
    "If one examines Sontagist camp, one is faced with a choice: either reject structuralist nihilism or conclude that academe is capable of truth, but only if culture is distinct from truth; otherwise, Lyotard's model of posttextual materialism is one of “capitalist discourse”, and thus intrinsically elitist. It could be said that constructive discourse suggests that discourse must come from the masses. If Marxist capitalism holds, we have to choose between constructive discourse and neodialectic libertarianism.",
    "The primary theme of von Ludwig's analysis of textual desituationism is the role of the participant as writer. But Baudrillard's critique of structuralist nihilism holds that language is used in the service of the status quo. Prinn suggests that we have to choose between posttextual materialism and the neostructural paradigm of context.",
    "It could be said that many theories concerning constructive discourse may be revealed. The main theme of the works of Spelling is the fatal flaw of cultural sexual identity.",
    "Thus, Sartre suggests the use of posttextual materialism to analyse and modify class. The premise of constructive discourse implies that the purpose of the reader is social comment.",
    "But Derrida uses the term 'structuralist nihilism' to denote the bridge between truth and society. If posttextual materialism holds, we have to choose between structuralist nihilism and submodern libertarianism.",
    "Thus, any number of discourses concerning a mythopoetical whole exist. Lacan promotes the use of constructive discourse to attack capitalism.",
    "In a sense, Lyotard uses the term 'structuralist nihilism' to denote the role of the poet as observer. Marxist socialism holds that reality comes from the collective unconscious, but only if Derrida's essay on posttextual materialism is valid.",
    "The main theme of the works of Eco is the genre of cultural sexual identity. It could be said that Parry holds that we have to choose between constructive discourse and the prestructuralist paradigm of context. If structuralist nihilism holds, the works of Burroughs are an example of self-justifying capitalism.",
    "In the works of Burroughs, a predominant concept is the distinction between creation and destruction. But the subject is interpolated into a that includes language as a totality. Several narratives concerning constructive discourse may be found.",
    "In a sense, the subject is contextualised into a that includes sexuality as a reality. Reicher states that we have to choose between structuralist nihilism and deconstructive theory.",
    "Therefore, Foucault promotes the use of posttextual materialism to attack sexism. Subcultural narrative holds that consciousness serves to exploit minorities.",
    "It could be said that Sontag suggests the use of constructive discourse to analyse and modify society. The characteristic theme of Drucker's critique of structuralist nihilism is the role of the poet as artist.",
  );
  
  shuffle($paragraphs);
  return ($paragraphs[0] ."\n\n". $paragraphs[1] ."\n\n". $paragraphs[2] ."\n\n");
}
