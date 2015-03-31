<?php
// $Id: contact.inc,v 1.1.2.2 2008/08/15 03:00:29 quicksketch Exp $

/**
 * Add a new contact category, including recipients and so on.
 */
function install_contact_add_category($category, $recipients, $reply = '', $weight = 0, $selected = 0) {
  $cid = db_next_id("{contact}_cid");
  db_query("INSERT INTO {contact} (cid, category, recipients, reply, weight, selected) VALUES (%d, category = '%s', recipients = '%s', reply = '%s', weight = %d, selected = %d)", $cid, $category, $recipients, $reply, $weight, $selected);
}