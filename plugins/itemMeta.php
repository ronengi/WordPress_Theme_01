<?php

/*  Items' Description Titles, Texts, Links & Images
*******************************************************
add/update DB dbwordpress, Table wp_postmeta, fields:
  _item_title_[0-3]
  _item_text_[0-3]
  _item_link_[0-3]
  _item_target_[0-3]
  _item_image_[0-3]
*/

require_once (E_INCLUDES.'metaData.php');


/* draw items' metadata box only in relevant pages */
if (howManyItems($editedPageId) == 0)  return;


add_action('add_meta_boxes', 'addItemMeta'); /* hook: draw meta box in add/edit page screen*/
add_action('save_post', 'saveItemMeta'); /* hook: update meta-data in db */

/* call the draw the meta box */
function addItemMeta() {  add_meta_box( '_itemsMetaId', '<b><u><center>Items</center></u></b>', 'cbItemMeta', 'page' );  }

/* draw the meta box */
function cbItemMeta( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'itemMeta_noncename' ); /* Use nonce for verification */
  $itemMeta = array();
  for ($iid=0; $iid < howManyItems($post->ID); ++$iid) {
    $keys = getItemMetaKeyNames($iid);

    // Use get_post_meta to retrieve an existing value from the database and use the value for the form
    $itemMeta[$keys[0]] =  get_post_meta($post->ID, $keys[0], true);
    $itemMeta[$keys[1]] =  get_post_meta($post->ID, $keys[1], true);
    $itemMeta[$keys[2]] =  get_post_meta($post->ID, $keys[2], true);
    $itemMeta[$keys[3]] =  get_post_meta($post->ID, $keys[3], true);
    $itemMeta[$keys[4]] =  get_post_meta($post->ID, $keys[4], true);

    echo '<div style="background:#ECECB0; padding:1px 0px; margin-bottom:1px; margin-top:30px;"><label for="' . $keys[0] . '" style="padding:7px 120px 7px 30px;">Title :</label><span style="padding:7px 10px;"><input type="text" id="' . $keys[0] . '" name="' . $keys[0] . '" value="' . $itemMeta[$keys[0]] . '" size="100" /></span></div>';
    echo '<div style="background:#ECECEC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[1] . '" style="padding:7px 138px 7px 30px; position:relative; top:-16px;">Text :</label><span style="padding:7px 10px;"><textarea id="' . $keys[1] . '" name="' . $keys[1] . '" rows="1" cols="90">' . $itemMeta[$keys[1]] . '</textarea></span></div>';
    echo '<div style="background:#ECECEC;padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[2] . '" style="padding:7px 85px 7px 30px;">Hyper Text :</label><span style="padding:7px 10px;"><input type="text" id="' . $keys[2] . '" name="' . $keys[2] . '" value="' . $itemMeta[$keys[2]] . '" size="100" /></span><br><label for="' . $keys[3] . '" style="padding:7px 72px 7px 30px;">Hyper Target :</label><span style="padding:7px 10px;"><input type="text" id="' . $keys[3] . '" name="' . $keys[3] . '" value="' . $itemMeta[$keys[3]] . '" size="100" /></span></div>';
    echo '<div style="background:#ECECEC; padding:1px 0px; margin-bottom:30px;"><label for="' . $keys[4] . '" style="padding:7px 46px 7px 30px;">Illustration Image :</label><span style="padding:7px 10px;"><input type="text" id="' . $keys[4] . '" name="' . $keys[4] . '" value="' . $itemMeta[$keys[4]] . '" size="100" /></span></div>';
  }
}



/* save metadata when the post is saved */
function saveItemMeta( $post_id ) {
  global $metaDataActivityLogFile;

  /* this is very important */
  if (wp_is_post_revision($post_id))    return;

  /* is current user authorised to do this action.  */
  if ('page' != $_POST['post_type']  ||  ! current_user_can('edit_page', $post_id))    return;

  /* did the user intend to change this value. */
  if (!isset($_POST['itemMeta_noncename'])  ||  !wp_verify_nonce($_POST['itemMeta_noncename'], plugin_basename(__FILE__)))    return;


  /* save the value to the database + log database activity */
  date_default_timezone_set('Asia/Jerusalem');
  $logText = "\n|    " . date('Y-m-d,  H:i:s') . "\n";

  $itemMeta = array();
  for ($iid=0; $iid < howManyItems($post_id); ++$iid) {
    $keys = getItemMetaKeyNames($iid);

    $itemMeta[$keys[0]] = cleanStr($_POST[$keys[0]]);
    $itemMeta[$keys[1]] = cleanStr($_POST[$keys[1]]);
    $itemMeta[$keys[2]] = cleanStr($_POST[$keys[2]]);
    $itemMeta[$keys[3]] = cleanStr($_POST[$keys[3]]);
    $itemMeta[$keys[4]] = cleanStr($_POST[$keys[4]]);
  }

  foreach ( $itemMeta as $pkey => $pval ) {
    $logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pkey . ", ". $pval . ");\n";
    update_post_meta($_POST['post_ID'], $pkey, $pval); /* UPDATING THE DATABASE HERE  */
  }
  $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  file_put_contents($metaDataActivityLogFile, $logText, FILE_APPEND | LOCK_EX);
}




/* end of Item Meta Description Fields: metabox */
?>
