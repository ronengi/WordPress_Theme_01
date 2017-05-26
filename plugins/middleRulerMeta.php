<?php

/*  Ruler (middle menu strip) item's text & image
*******************************************************
add/update DB dbwordpress, Table wp_postmeta, fields:
  _rulerItemImage[0-3]
  _rulerItemTitle[0-3]

*/

require_once (E_INCLUDES.'metaData.php');


/* draw items' metadata box only in relevant pages */
$rulerMetaKeyNames = getRulerMetaKeyNames($editedPageId);
if (!isset($rulerMetaKeyNames))
  return;


add_action('add_meta_boxes', 'addRulerMeta'); /* hook: draw meta box in add/edit page screen*/
add_action('save_post', 'saveRulerMeta'); /* hook: update meta-data in db */

/* call the draw the meta box */
function addRulerMeta() {  add_meta_box( '_rulerMetaId', '<b><u><center>Center Menu Strip Items</center></u></b>', 'cbRulerMeta', 'page' );  }

/* draw the meta box */
function cbRulerMeta( $post ) {

  global $rulerMetaKeyNames;

  wp_nonce_field( plugin_basename( __FILE__ ), 'rulerMeta_noncename' ); /* Use nonce for verification */

  /* Use get_post_meta to retrieve an existing value from the database and use the value for the form */
  $rulerMeta = array();

  foreach($rulerMetaKeyNames as $fieldIndex => $fieldName ) {
    $rulerMeta[$fieldName] = get_post_meta($post->ID, $fieldName, true);

    $itemNo = $fieldIndex / 2;
    if (is_int($itemNo)) {
    echo '<div style="clear:both;  height:25px;  width:60%;  background:#ECECB0; padding:1px 0px; margin-bottom:1px; margin-top:20px; margin-right:auto;  margin-left:auto;  ">
          <label for="'.$fieldName.'" style="float:left;  padding:5px 20px 7px 20px;">['.($itemNo + 1).'] Image :';
    }
    else {
    echo '<div style="clear:both;  height:25px;  width:60%;  background:#ECECB0; padding:1px 0px; margin-bottom:20px; margin-top:1px; margin-right:auto;  margin-left:auto;  ">
          <label for="'.$fieldName.'" style="float:left;  padding:5px 20px 7px 20px;">['.($itemNo + 0.5).'] Title :';
    }
    echo '</label><span style="float:right;  padding:5px 10px;"><input type="text" id="'.$fieldName.'" name="'.$fieldName.'" value="'.$rulerMeta[$fieldName].'" size="100" /></span></div>';
  }
}



/* save metadata when the post is saved */
function saveRulerMeta( $post_id ) {

  global $rulerMetaKeyNames;
  global $metaDataActivityLogFile;


  /* this is very important */
  if (wp_is_post_revision($post_id))    return;

  /* is current user authorised to do this action.  */
  if ('page' != $_POST['post_type']  ||  ! current_user_can('edit_page', $post_id))    return;

  /* did the user intend to change this value. */
  if (!isset($_POST['rulerMeta_noncename'])  ||  !wp_verify_nonce($_POST['rulerMeta_noncename'], plugin_basename(__FILE__)))    return;


  /* save the value to the database + log database activity */
  date_default_timezone_set('Asia/Jerusalem');
  $logText = "\n|    " . date('Y-m-d,  H:i:s') . "\n";

  $rulerMeta = array();
  foreach($rulerMetaKeyNames as $ikey => $ival ) {
    $rulerMeta[$ival] = cleanStr($_POST[$ival]);

    $logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $ival . ", ". $rulerMeta[$ival] . ");\n";
    update_post_meta($_POST['post_ID'], $ival, $rulerMeta[$ival]); /* UPDATING THE DATABASE HERE  */
  }

  $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  file_put_contents($metaDataActivityLogFile, $logText, FILE_APPEND | LOCK_EX);
}




/* end of Ruler Meta Items Fields: metabox */
?>
