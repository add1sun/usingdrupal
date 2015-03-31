<?php
// $Id: theme-settings.php,v 1.6 2008/08/05 03:05:28 shannonlucas Exp $
/**
 * @file Provides the settings for the Notibe theme.
 */

require_once drupal_get_path('theme', 'nitobe') . '/nitobe_utils.php';

/**
 * Implementation of THEMEHOOK_settings().
 *
 * @param array $settings An array of saved settings for this
 *        theme.
 *
 * @return array A form array.
 */
function nitobe_settings($settings) {
  $form = array();
  
  //-----------------------------------------------------------------------
  // Get the header image list.
  $images  = _nitobe_get_header_list(TRUE);
  $options = array('<random>' => 'Random Header Image');

  foreach ($images as $filename => $data) {
    $options[$filename] = $data->pretty_name;
  }

  //-----------------------------------------------------------------------
  // The setting for the header image.
  $current = empty($settings['header_image']) ? '' : $settings['header_image'];
  $default = in_array($current, array_keys($options)) ? $current : '<random>';
  $form['nitobe']['header_image'] = array(
    '#type'          => 'select',
    '#title'         => t('Header Image'),
    '#options'       => $options,
    '#default_value' => $default,
  );

  //-----------------------------------------------------------------------
  // Whether or not to remove the spacing between words in the page header.
  $default = (!isset($settings['remove_header_spaces'])) ? 1 : $settings['remove_header_spaces'];
  $form['nitobe']['remove_header_spaces'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Remove Page Header Spaces'),
    '#default_value' => $default,
    '#description'   => t('If checked, the spaces between words in the header will be removed and every other word will be wrapped in a %span element with the %class CSS class.',
                          array('%span' => '<span>', '%class' => 'alt-color')),
  );

  //-----------------------------------------------------------------------
  // Whether or not to show the node authors.
  $default = empty($settings['show_node_author']) ? FALSE : $settings['show_node_author'];
  $form['nitobe']['show_node_author'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show Node Author'),
    '#default_value' => $default,
    '#description'   => t('If checked, the name of the node author will be displayed in the teaser and page views for nodes.'),
  );

  //-----------------------------------------------------------------------
  // Whether or not to show the breadcrumb trail if it only contains the
  // 'Home' link.
  $default = empty($settings['show_single_breadcrumb']) ? FALSE : $settings['show_single_breadcrumb'];
  $form['nitobe']['show_single_breadcrumb'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show Single Item Breadcrumb Trail'),
    '#default_value' => $default,
    '#description'   => t('By default the breadcrumb trail will be hidden if it contains just the link to the top level page. Check this box to override that behavior.'),
  );

  return $form;
}
