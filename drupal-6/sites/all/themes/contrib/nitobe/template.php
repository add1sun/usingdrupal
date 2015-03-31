<?php
// $Id: template.php,v 1.9 2008/08/05 03:05:27 shannonlucas Exp $
/**
 * @file The Nitobe theme.
 */

require_once drupal_get_path('theme', 'nitobe') . '/nitobe_utils.php';

/**
 * Implementation of hook_theme().
 *
 * @param array  $existing
 * @param string $type
 * @param string $theme
 * @param string $path
 *
 * @return array
 */
function _nitobe_theme($existing, $type, $theme, $path) {
  $funcs = array(
    'nitobe_username'=> array(
      'arguments' => $existing['theme_username'],
    ),
  );

  return $funcs;
}


/**
 * Display the list of available node types for node creation.
 *
 * @param $content array
 *
 * @return string The rendered HTML.
 */
function nitobe_node_add_list($content) {
  $output = '';

  if ($content) {
    $output = '<dl class="node-type-list">';
    $class = 'odd';
    foreach ($content as $item) {
      $output .= '<dt class="' . $class . '">'. l($item['title'], $item['href'], $item['options']) .'</dt>';
      $output .= '<dd class="' . $class . '">'. filter_xss_admin($item['description']) .'</dd>';

      $class = ($class == 'odd') ? 'even' : 'odd';
    }
    $output .= '</dl>';
  }
  return $output;
}


/**
 * Overrides theme_username(). Performs special work if the given object is a
 * comment. Otherwise, it calls the default implementation.
 *
 * @param object $object An instance of a node, comment, etc.
 *
 * @return string A string containing an HTML link to the user's page if
 *         the passed object suggests that this is a site user. Otherwise,
 *         only the username is returned.
 */
function nitobe_username($object) {
  // Is it a comment?
  if (!empty($object->cid)) {
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage,
                  array('attributes' => array('rel' => 'external nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }
  }
  // If not, just call the default implementation.
  else {
    $output = theme_username($object);
    $output = t('Posted by !author', array('!author' => $output));
  }

  return $output;
}


/**
 * Determine whether to show the date stamp for the given node.
 *
 * @param $node object The node to check.
 *
 * @return bool TRUE if the node is of a type that should show the date
 *         stamp, FALSE if not.
 */
function nitobe_show_datestamp($node) {
  $valid_types = array (
    'story',
    'image',
  );

  if (!empty($node) AND !empty($node->type)) {
    return in_array($node->type, $valid_types);
  }

  return FALSE;
}


/**
 * Should the theme show node authors?
 *
 * @return boolean TRUE if node authors should be shown, FALSE if not.
 */
function nitobe_show_authors() {
 return theme_get_setting('show_node_author');
}


/**
 * Removes the spaces between words in the given string and returns an HTML
 * string with every other word wrapped in a span with the class "alt-color".
 *
 * @param $text string The text to render.
 *
 * @return string The rendered HTML.
 */
function nitobe_alt_word_text($text = '') {
  if (theme_get_setting('remove_header_spaces') === 0) {
    return $text;  
  }
  
  $words  = explode(' ', $text);
  $result = '';

  if (is_array($words)) {
    $alt = FALSE;
    foreach ($words as $word) {
      if ($alt) {
        $result .= '<span class="alt-color">' . $word . '</span>';
      }
      else {
        $result .= $word;
      }

      $alt = !$alt;
    }
  }

  return $result;
}


/**
 * Render the node terms with a text prefix and join them with a comma.
 *
 * @param $node object The node to render term links for.
 * @param $prefix string The text to show before the list of terms. By
 *        defaults the localized text 'Tags:' is used.
 * @param $separator string The character(s) to place between the terms. By
 *        default a comma is used.
 */
function nitobe_render_terms($node, $prefix = NULL, $separator = ',') {
  $prefix = ($prefix == NULL) ? t('Tags:') : $text;
  $output = '';

  if (module_exists('taxonomy')) {
    $terms = taxonomy_link('taxonomy terms', $node);
  }
  else {
    $terms = array();
  }

  if (count($terms) > 0) {
    $output  .= $prefix . ' <ul class="links inline">';
    $rendered = nitobe_list_of_links($terms);

    $i = 1;
    foreach ($rendered as $term) {
      $output .= '<li class="' . $term[1] . '">' . $term[0];

      if ($i < count($terms)) {
        $output .= $separator . ' ';
      }

      $output .= '</li>';

      $i++;
    }

    $output .= '</ul>';
  }

  return $output;
}


/**
 * Returns an array of rendered lists without any wrapping elements such as
 * <ul> and <li>.
 *
 * @param $links array A keyed array of links to be themed.
 *
 * @return array An array of arrays. The first element of each inner array
 *         will be the rendered link. The second element will be the CSS
 *         class that should be applied to any wrapping element of that
 *         link.
 */
function nitobe_list_of_links($links) {
  $output = array();

  if (count($links) > 0) {
    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = $key;

      // Add first, last and active classes to the list of links to help
      // out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))) {
        $class .= ' active';
      }

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output[] = array(l($link['title'], $link['href'], $link), $class);
      }
      else if (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for
        // adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $span = '<span'. $span_attributes .'>'. $link['title'] .'</span>';
        $output[] = array($span, $class);
      }

      $i++;
    }
  }

  return $output;
}


/**
 * Return the comment link to display for a node rendered as a teaser.
 *
 * @param $node object The node to render the comment link for.
 *
 * @return string The rendered comment link.
 */
function nitobe_teaser_comment_link($node) {
  if (($node->comment_count > 0) AND ($node->comment > COMMENT_NODE_DISABLED)) {
    $text = format_plural($node->comment_count,
                          '1 Comment', '@count Comments');
    
    if ($node->comment == COMMENT_NODE_READ_WRITE) {
      $title = t('Read comments or comment on @title',
                 array('@title' => $node->title));
    }
    else {
      $title = t('Read comments for @title', array('@title' => $node->title));
    }
    
    $options = array(
      'fragment'   => 'comments',
      'html'       => TRUE,
      'attributes' => array('title' => $title),
    );

    $output = l($text, 'node/' . $node->nid, $options);
  }
  else if ($node->comment == COMMENT_NODE_READ_WRITE) {
    $options = array(
      'fragment'   => 'comment-form',
      'html'       => TRUE,
      'attributes' => array('title' => t('Comment on @title', 
                                         array('@title' => $node->title))),
    );

    $output = l(t('Add a Comment'), 'comment/reply/' . $node->nid, $options);
  }

  return $output;
}


/**
 * Create the 'Continue reading' link for the bottom of posts.
 *
 * @param $node object The node to add the continue reading link to.
 *
 * @return string The link HTML.
 */
function nitobe_read_more_link($node) {
  if ($node != NULL) {
    $link_text  = t('Continue reading...');
    $link_title = t('Continue reading !title.', array('!title' => $node->title));
    $options = array(
      'attributes' => array('title' => $link_title),
      'html' => TRUE,
    );
    return l($link_text, 'node/' . $node->nid, $options);
  }

  return '';
}


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    if (theme_get_setting('show_single_breadcrumb') == 0) {
        if (count($breadcrumb) == 1) {
            return '';
        }
    }
  
    return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .'</div>';
  }
}


/**
 * Allow themable wrapping of all comments.
 */
function phptemplate_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div>';
  }
}


/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  $vars['primary_links']   = menu_primary_links();
  $vars['secondary_links'] = menu_secondary_links();
  $vars['tabs2']           = menu_secondary_local_tasks();
  
  // Determine the header image if it is set, or add the JavaScript for
  // random header images.
  $header_img = theme_get_setting('header_image');
  $header_img = empty($header_img) ? '<random>' : $header_img;

  if ($header_img == '<random>') {
    $vars['closure'] .= _nitobe_random_header_js();
  }
  else {
    $vars['styles'] .= _nitobe_fixed_header_css($header_img) . "\n";
  }
}


/**
 * Overrides template_preprocess_comment().
 *
 * @param array $variables
 */
function phptemplate_preprocess_comment(&$variables) {
  $comment = $variables['comment'];
  $node    = $variables['node'];

  $variables['author']  = theme('username', $comment);
  $variables['content'] = $comment->comment;

  $params = array(
    '@date' => format_date($comment->timestamp, 'custom', 'M jS, Y'),
    '@time' => format_date($comment->timestamp, 'custom', 'g:i a'),
  );
  $variables['date']    = t('@date at @time', $params);

  if (user_access('administer comments')) {
    $links = array(
      l(t('Edit'), 'comment/edit/' . $comment->cid),
      l(t('Delete'), 'comment/delete/' . $comment->cid),
    );

    $variables['links'] = implode(' | ', $links);
  }
  else {
    unset($variables['links']);
  }
}


/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function phptemplate_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function phptemplate_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}


/**
 * Generates IE CSS links for LTR and RTL languages.
 *
 * @return string the IE style elements.
 */
function phptemplate_get_ie_styles() {
  global $language;

  $iecss = '<link type="text/css" rel="stylesheet" media="screen" href="'. base_path() . path_to_theme() .'/fix-ie.css" />';
  if (defined('LANGUAGE_RTL') && $language->direction == LANGUAGE_RTL) {
    $iecss .= '<style type="text/css" media="screen">@import "'. base_path() . path_to_theme() .'/fix-ie-rtl.css";</style>';
  }

  return $iecss;
}
