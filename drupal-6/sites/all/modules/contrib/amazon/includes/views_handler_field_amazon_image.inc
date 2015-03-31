<?php

class views_handler_field_amazon_image extends views_handler_field {
  function options(&$options) {
    parent::options($options);
    $options['image_size'] = 'smallimage';
    $options['link_format'] = 'amazon';
  }

  /**
   * Override init function to provide generic option to link to node.
   */
  function init(&$view, &$data) {
    parent::init($view, $data);
    if (!empty($data['image_size'])) {
      //$this->additional_fields[] = 'size';
      $this->additional_fields[] = 'height';
      $this->additional_fields[] = 'width';
    }
    if (!empty($data['link_format']) && $data['link_format'] == 'amazon') {
      $this->additional_fields['detailpageurl'] = array('table' => 'amazon_item', 'field' => 'detailpageurl');
    }
  }

  function ensure_my_table() {
    if (empty($this->table_alias)) {
      $join_extra = array();
      if (!empty($this->options['image_size'])) {
        $join_extra[] = array('field' => 'size', 'value' => $this->options['image_size'], 'numeric' => FALSE);
      }

      $join = new views_join();
      $join->construct($this->table, 'amazon_item', 'asin', 'asin', $join_extra);

      $this->table_alias = $this->query->ensure_table($this->table, $this->relationship, $join);
    }
    return $this->table_alias;
  }

  /**
   * Provide link to node option
   */
  function options_form(&$form, &$form_state) {
    $form['image_size'] = array(
      '#title' => t('Image size'),
      '#type' => 'select',
      '#options' => array(
        'smallimage' => t('Small'),
        'mediumimage' => t("Medium"),
        'largeimage' => t("Large"),
      ),
      '#default_value' => !empty($this->options['image_size']) ? $this->options['image_size'] : 'MedumImage',
    );

    $form['link_format'] = array(
      '#title' => t('Link behavior'),
      '#type' => 'radios',
      '#options' => array(
        'plain' => t('No link'),
        'amazon' => t("A link to the product's Amazon page"),
      ),
      '#default_value' => !empty($this->options['link_format']) ? $this->options['link_format'] : 'plain',
    );
    if ($this->view->base_table == 'node') {
      $form['link_format']['#options']['node'] = t('A link to the node the product is associated with');
    }
  }

  function render($values) {
    $attributes = array(
      'height' => $values->{$this->table_alias . '_height'},
      'width' => $values->{$this->table_alias . '_width'},
    );
    $image = theme('image', $values->{$this->table_alias . '_url'}, NULL, NULL, $attributes, FALSE);

    switch($this->options['link_format']) {
      case 'plain':
        return $image;
        break;
      case 'node':
        return l($image, 'node/'. $values->nid, array('html' => TRUE));
        break;
      case 'amazon':
        $urlfield = $this->additional_fields['detailpageurl']['field'];
        if (!empty($this->relationship)) {
          $urlfield = $this->relationship .'_'. $urlfield;
        }
        return l($image, $values->{$urlfield}, array('html' => TRUE));
        break;
    }
  }
}
