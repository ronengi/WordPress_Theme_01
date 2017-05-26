<?php

/*  Page Titles & Images
***************************
add/update DB dbwordpress, Table wp_postmeta, fields:
  _page_title
  _page_sub_title
  _page_text_1
  _page_text_2
  _page_image_1
  _page_image_2
*/


require_once (E_INCLUDES.'metaData.php');


/* draw page's metadata box only in relevant pages */
if (whatPageMeta($editedPageId) == NULL)  return;


add_action('add_meta_boxes', 'addPageMeta');	/* hook: draw meta box in add/edit page screen*/
add_action('save_post', 'savePageMeta'); /* hook: update meta-data in db */

/* call the draw the meta box */
function addPageMeta() {  add_meta_box('_pageMetaId', '<b><u><center>Titles & Images</center></u></b>', 'cbPageMeta', 'page');  }

/* draw the meta box */
function cbPageMeta( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'pageMeta_noncename' ); /* Use nonce for verification */
  $pageMeta = array();
  $keys = getPageMetaKeyNames();

  /* Use get_post_meta to retrieve an existing value from the database and use the value for the form */
  $pageMeta[$keys[0]] =  get_post_meta($post->ID, $keys[0], true);
  $pageMeta[$keys[1]] =  get_post_meta($post->ID, $keys[1], true);
  $pageMeta[$keys[2]] =  get_post_meta($post->ID, $keys[2], true);
  $pageMeta[$keys[3]] =  get_post_meta($post->ID, $keys[3], true);
  $pageMeta[$keys[4]] =  get_post_meta($post->ID, $keys[4], true);
  $pageMeta[$keys[5]] =  get_post_meta($post->ID, $keys[5], true);

  $whatMeta = whatPageMeta($post->ID); /* selective display of input fields, relevant for specific page */

  foreach ($whatMeta as $relevantKeyNum) {
    switch ($relevantKeyNum) {
    case 0:			/* title */
      echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 112px 7px 30px;">Page Title :</label> <span style="padding:7px 10px;"><input type="text" id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" value="' . $pageMeta[$keys[$relevantKeyNum]] . '" size="150" /></span></div>';
      break;
    case 1:			/* sub title */
      echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 35px 7px 30px; position:relative; top:-15px;">Page Subtitle Paragraph :</label> <span style="padding:7px 10px;"><textarea id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" rows="1" cols="146">' . $pageMeta[$keys[$relevantKeyNum]] . '</textarea></span></div>';
      break;
    case 2:			/* text 1 */
      echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 77px 7px 30px; position:relative; top:-15px;">Text Paragraph 1 :</label> <span style="padding:7px 10px;"><textarea id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" rows="1" cols="146">' . $pageMeta[$keys[$relevantKeyNum]] . '</textarea></span></div>';
      break;
    case 3:			/* text 2 */
      echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 77px 7px 30px; position:relative; top:-15px;">Text Paragraph 2 :</label> <span style="padding:7px 10px;"><textarea id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" rows="1" cols="146">' . $pageMeta[$keys[$relevantKeyNum]] . '</textarea></span></div>';
      break;
    case 4:			/* image 1 */
      echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 123px 7px 30px;">Image 1 :</label> <span style="padding:7px 10px;"><input type="text" id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" value="' . $pageMeta[$keys[$relevantKeyNum]] . '" size="150" /></span></div>';
      break;
    case 5:			/* image 2 */
      echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 123px 7px 30px;">Image 2 :</label> <span style="padding:7px 10px;"><input type="text" id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" value="' . $pageMeta[$keys[$relevantKeyNum]] . '" size="150" /></span></div>';
      break;
    }
  }
}



/* save metadata when the post is saved */
function savePageMeta( $post_id ) {
  global $metaDataActivityLogFile;

  /* this is very important */
  if (wp_is_post_revision($post_id))    return;

  /* is current user authorised to do this action. */
  if ('page' != $_POST['post_type']  ||  !current_user_can('edit_page', $post_id))    return;

  /* did the user intend to change this value. */
  if (!isset($_POST['pageMeta_noncename'])  ||  !wp_verify_nonce($_POST['pageMeta_noncename'], plugin_basename(__FILE__)))    return;



  /* save the value to the database + log database activity */
  date_default_timezone_set('Asia/Jerusalem');
  $logText = "\n|    " . date('Y-m-d,  H:i:s') . "\n";

  $pageMeta = array();
  $keys = getPageMetaKeyNames();
  $whatMeta = whatPageMeta($post_id); /* selective insert fields to DB, relevant for specific page */
  foreach ($whatMeta as $relevantKeyNum) { /* fetch from form into array */
    $pageMeta[$keys[$relevantKeyNum]] = cleanStr($_POST[$keys[$relevantKeyNum]]);
  }

  foreach ( $pageMeta as $pkey => $pval ) { /* write log and update DB */
    $logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pkey . ", ". $pval . ");\n";
    update_post_meta($_POST['post_ID'], $pkey, $pval); /* UPDATING THE DATABASE HERE */
  }
  $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  file_put_contents($metaDataActivityLogFile, $logText, FILE_APPEND | LOCK_EX);
}




/* end of Page Meta Description Fields: metabox */
?>
