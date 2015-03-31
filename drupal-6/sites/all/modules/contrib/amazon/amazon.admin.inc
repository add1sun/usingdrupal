<?php

function amazon_settings_form($form_state) {
  $cache = amazon_data_cache();
  $options = array();
  foreach ($cache['locales'] as $locale => $data) {
    $options[$locale] = $data['name'];
  }
  $form['amazon_locale'] = array(
    '#type' => 'select',
    '#title' => t('Amazon locale'),
    '#default_value' => variable_get('amazon_locale', 'US'),
    '#options' => $options,
    '#description' => t('Amazon.com uses separate product databases and Ecommerce features in different locales; pricing and availability information, as well as product categorization, differs from one locale to the next. Be sure to select the locale your site will be running in.'),
  );

  $form['amazon_associate_setting'] = array(
    '#type' => 'select',
    '#title' => t('Amazon referral settings'),
    '#default_value' => variable_get('amazon_associate_setting', 'association'),
    '#options' => array(
      'association' => t('Use the Drupal Association\'s associate ID'),
      'author' => t('Use the module developer\'s associate ID'),
      'custom' => t('Use your own associate ID'),
      'none' => t('Do not use any associate ID')
    ),
    '#description' => t('Outgoing links to Amazon.com can include an associate ID code. When shoppers purchase Amazon products via one of those links, the associate ID is used to determine who should receive a referral bonus from Amazon.com.'),
  );

  $form['amazon_custom_associate_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Your associate ID'),
    '#description' => t('Enter your own associate ID to receive referral bonuses when shoppers purchase Amazon products via your site.'),
    '#default_value' => variable_get('amazon_custom_associate_id', ''),
    '#prefix' => '<div id="amazon-associate-id-wrapper">',
    '#suffix' => '</div>',
  );
  if (variable_get('amazon_associate_setting', 'author') != 'custom') {
    $form['amazon_custom_associate_id']['#prefix'] = '<div id="amazon-associate-id-wrapper" class="js-hide">';
  }

  $form['amazon_aws_access_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Amazon API key'),
    '#description' => t('Applications must use a unique key to access Amazon services. One is supplied with the Drupal Amazon API module by default, but developers building high-traffic custom modules on the Amazon API may want to enter a custom key here.'),
    '#default_value' => variable_get('amazon_aws_access_key', '0CD9RCQYM0TBVH55NB82'),
  );

  // Now add the Javascript that does the fancy hide/show effects.
  drupal_add_js(drupal_get_path('module', 'amazon') .'/amazon.admin.js');

  return system_settings_form($form);
}

function amazon_storage_settings_form() {
  $form['amazon_explain'] = array(
    '#type' => 'markup',
    '#value' => t("Storing Amazon product information in the Drupal database can speed up the display of commonly viewed products. In addition, stored product data can be included in content displayed by the Views module. On some sites, though, this functionality is unecessary and can be disabled."),
  );

  $form['amazon_cache'] = array(
    '#type' => 'checkbox',
    '#title' => t('Store Amazon data locally'),
    '#default_value' => variable_get('amazon_cache', TRUE),
  );

  if (!variable_get('amazon_cache', TRUE)) {
    $form['details']['#prefix'] = '<div id="amazon-storage-details" class="js-hide">';
  }
  else {
    $form['details']['#prefix'] = '<div id="amazon-storage-details">';
  }

  $form['details']['#suffix'] = '</div>';

  $period = array(0 => t('Never'));
  $period += drupal_map_assoc(array(43200, 86400, 604800), 'format_interval');
  $form['details']['amazon_refresh_schedule'] = array(
    '#type' => 'select',
    '#title' => t('Amazon refresh schedule'),
    '#description' => t('Cached information on Amazon items must be refreshed regularly to keep pricing and stock information up to date. Cron must be enabled for this function to work properly.'),
    '#default_value' => variable_get('amazon_refresh_schedule', 86400),
    '#options' => $period
  );

  $form['details']['amazon_core_data'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Store extended product data'),
    '#default_value' => variable_get('amazon_core_data', array('creators', 'images')),
    '#options' => array(
      'creators' => t('Book authors, film actors, etc.'),
      'images' => t('Product images'),
      'editorial_reviews' => t('Editorial reviews'),
    ),
  );

  // Now add the Javascript that does the fancy hide/show effects.
  drupal_add_js(drupal_get_path('module', 'amazon') .'/amazon.admin.js');

  return system_settings_form($form);
}


function amazon_test_form($form_state) {
  $form = array();

  $form['asin'] = array(
    '#type' => 'textfield',
    '#title' => t('Amazon Product ID'),
    '#description' => t('The ASIN of a product listed on Amazon.com. For books, this is generally the ISBN number.'),
    '#required' => TRUE,
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Look Up Product'),
  );

  if (isset($form_state['amazon_item'])) {
    $markup = theme('amazon_item', $form_state['amazon_item'], 'details');
    $markup .= '<pre>'. print_r($form_state['amazon_item'], TRUE) .'</pre>';
    $form['item_data'] = array(
      '#type' => 'markup',
      '#value' => $markup,
      '#weight' => 10,
    );
  }
  return $form;
}

function amazon_test_form_submit($form, &$form_state) {
  $items = amazon_item_lookup($form_state['values']['asin']);
  if (is_array($items)) {
    $item = array_pop($items);
    amazon_item_delete($item['asin']);
    amazon_item_save($item);

    // We could probably be sneaky and put the Amazon data in here directly,
    // but SimpleXML objects can't be serialized, and setting rebuild = TRUE
    // causes a serialization operation. Whoops.
    $form_state['amazon_item'] = $item;
    $form_state['rebuild'] = TRUE;
  }
}
