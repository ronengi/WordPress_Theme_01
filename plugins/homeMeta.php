<?php

/*  Home Page Titles & Texts
********************************
add/update DB dbwordpress, Table wp_postmeta, fields:
  _home_page_title
  _home_page_sub_title

  _home_eParl_title
  _home_eParl_sub_title

  _home_eRecd_title
  _home_eRecd_sub_title

  _home_eType_title
  _home_eType_sub_title

  _home_eProt_title
  _home_eProt_sub_title

  _home_page_title_1
  _home_page_text_1
  _home_page_link_1
  _home_page_targ_1

  _home_page_title_2
  _home_page_text_2
  _home_page_link_2_1
  _home_page_targ_2_1
  _home_page_link_2_2
  _home_page_targ_2_2
  _home_page_link_2_3
  _home_page_targ_2_3
*/

require_once (E_INCLUDES.'metaData.php');


/* draw home's metadata box only in home pages */
if (isEtypeHome($editedPageId) == NULL)  return;


add_action('add_meta_boxes', 'addHomeMeta'); /* hook: draw meta box in add/edit page screen*/
add_action('save_post', 'saveHomeMeta'); /* hook: update meta-data in db */

/* call the draw the meta box */
function addHomeMeta() {  add_meta_box('_homeMetaId', '<b><u><center>Home Page Titles, Texts & Links</center></u></b>', 'cbHomeMeta', 'page');  }

/* draw the meta box */
function cbHomeMeta( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'homeMeta_noncename' ); /* Use nonce for verification */

  /* Use get_post_meta to retrieve an existing value from the database and use the value for the form */
  $homeMeta = array();
  $keys = getHomeMetaKeyNames();
  foreach ($keys as $keyName) {
    $homeMeta[$keyName] = get_post_meta($post->ID, $keyName, true);
  }


  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[0] . '" style="padding:7px 0px 7px 30px; float:left;">Main Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[0] . '" name="' . $keys[0] . '" rows="1" cols="146">' . $homeMeta[$keys[0]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[1] . '" style="padding:7px 0px 7px 30px; float:left;">Main Sub Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[1] . '" name="' . $keys[1] . '" rows="1" cols="146">' . $homeMeta[$keys[1]] . '</textarea></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[2] . '" style="padding:7px 0px 7px 30px; float:left;">eParliament Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[2] . '" name="' . $keys[2] . '" rows="1" cols="146">' . $homeMeta[$keys[2]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[3] . '" style="padding:7px 0px 7px 30px; float:left;">eParliament Sub Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[3] . '" name="' . $keys[3] . '" rows="1" cols="146">' . $homeMeta[$keys[3]] . '</textarea></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[4] . '" style="padding:7px 0px 7px 30px; float:left;">EasyRecord Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[4] . '" name="' . $keys[4] . '" rows="1" cols="146">' . $homeMeta[$keys[4]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[5] . '" style="padding:7px 0px 7px 30px; float:left;">EasyRecord Sub Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[5] . '" name="' . $keys[5] . '" rows="1" cols="146">' . $homeMeta[$keys[5]] . '</textarea></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[6] . '" style="padding:7px 0px 7px 30px; float:left;">EasyType Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[6] . '" name="' . $keys[6] . '" rows="1" cols="146">' . $homeMeta[$keys[6]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[7] . '" style="padding:7px 0px 7px 30px; float:left;">EasyType Sub Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[7] . '" name="' . $keys[7] . '" rows="1" cols="146">' . $homeMeta[$keys[7]] . '</textarea></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[8] . '" style="padding:7px 0px 7px 30px; float:left;">eProtocol Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[8] . '" name="' . $keys[8] . '" rows="1" cols="146">' . $homeMeta[$keys[8]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[9] . '" style="padding:7px 0px 7px 30px; float:left;">eProtocol Sub Title</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[9] . '" name="' . $keys[9] . '" rows="1" cols="146">' . $homeMeta[$keys[9]] . '</textarea></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[10] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Left Paragraph Header</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[10] . '" name="' . $keys[10] . '" rows="1" cols="146">' . $homeMeta[$keys[10]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[11] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Left Paragraph Text</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[11] . '" name="' . $keys[11] . '" rows="1" cols="146">' . $homeMeta[$keys[11]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[12] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Left Paragraph Link</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[12] . '" name="' . $keys[12] . '" value="' . $homeMeta[$keys[12]] . '" size="150" /></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[13] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Left Paragraph Target</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[13] . '" name="' . $keys[13] . '" value="' . $homeMeta[$keys[13]] . '" size="150" /></span></div>';


  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[14] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Header</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[14] . '" name="' . $keys[14] . '" rows="1" cols="146">' . $homeMeta[$keys[14]] . '</textarea></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:58px;"><label for="' . $keys[15] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Text</label><span style="padding:7px 10px; float:right;"><textarea id="' . $keys[15] . '" name="' . $keys[15] . '" rows="1" cols="146">' . $homeMeta[$keys[15]] . '</textarea></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[16] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Link 1</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[16] . '" name="' . $keys[16] . '" value="' . $homeMeta[$keys[16]] . '" size="150" /></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[17] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Target 1</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[17] . '" name="' . $keys[17] . '" value="' . $homeMeta[$keys[17]] . '" size="150" /></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[18] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Link 2</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[18] . '" name="' . $keys[18] . '" value="' . $homeMeta[$keys[18]] . '" size="150" /></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[19] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Target 2</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[19] . '" name="' . $keys[19] . '" value="' . $homeMeta[$keys[19]] . '" size="150" /></span></div>';

  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[20] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Link 3</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[20] . '" name="' . $keys[20] . '" value="' . $homeMeta[$keys[20]] . '" size="150" /></span></div>';
  echo '<div style="background:#ECECBC; padding:0px 0px; margin-bottom:1px; clear:both; height:38px;"><label for="' . $keys[21] . '" style="padding:7px 0px 7px 30px; float:left;">Bottom Middle Paragraph Target 3</label><span style="padding:7px 10px; float:right;"><input type="text" id="' . $keys[21] . '" name="' . $keys[21] . '" value="' . $homeMeta[$keys[21]] . '" size="150" /></span></div>';

}


    /* switch ($relevantKeyNum) { */
    /* case 0:			/\* title *\/ */
    /*   echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 112px 7px 30px;">Page Title :</label> <span style="padding:7px 10px;"><input type="text" id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" value="' . $pageMeta[$keys[$relevantKeyNum]] . '" size="150" /></span></div>'; */
    /*   break; */
    /* case 1:			/\* sub title *\/ */
    /*   echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 35px 7px 30px; position:relative; top:-15px;">Page Subtitle Paragraph :</label> <span style="padding:7px 10px;"><textarea id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" rows="1" cols="146">' . $pageMeta[$keys[$relevantKeyNum]] . '</textarea></span></div>'; */
    /*   break; */
    /* case 2:			/\* text 1 *\/ */
    /*   echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 77px 7px 30px; position:relative; top:-15px;">Text Paragraph 1 :</label> <span style="padding:7px 10px;"></span></div>'; */
    /*   break; */
    /* case 3:			/\* text 2 *\/ */
    /*   echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 77px 7px 30px; position:relative; top:-15px;">Text Paragraph 2 :</label> <span style="padding:7px 10px;"><textarea id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" rows="1" cols="146">' . $pageMeta[$keys[$relevantKeyNum]] . '</textarea></span></div>'; */
    /*   break; */
    /* case 4:			/\* image 1 *\/ */
    /*   echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 123px 7px 30px;">Image 1 :</label> <span style="padding:7px 10px;"><input type="text" id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" value="' . $pageMeta[$keys[$relevantKeyNum]] . '" size="150" /></span></div>'; */
    /*   break; */
    /* case 5:			/\* image 2 *\/ */
    /*   echo '<div style="background:#ECECBC; padding:1px 0px; margin-bottom:1px;"><label for="' . $keys[$relevantKeyNum] . '" style="padding:7px 123px 7px 30px;">Image 2 :</label> <span style="padding:7px 10px;"><input type="text" id="' . $keys[$relevantKeyNum] . '" name="' . $keys[$relevantKeyNum] . '" value="' . $pageMeta[$keys[$relevantKeyNum]] . '" size="150" /></span></div>'; */
    /*   break; */
    /* } */
  



/* save metadata when the post is saved */
function saveHomeMeta( $post_id ) {
  global $metaDataActivityLogFile;

  /* this is very important */
  if (wp_is_post_revision($post_id))    return;

  /* is current user authorised to do this action. */
  if ('page' != $_POST['post_type']  ||  !current_user_can('edit_page', $post_id))    return;

  /* did the user intend to change this value. */
  if (!isset($_POST['homeMeta_noncename'])  ||  !wp_verify_nonce($_POST['homeMeta_noncename'], plugin_basename(__FILE__)))    return;


  /* save the value to the database + log database activity */
  date_default_timezone_set('Asia/Jerusalem');
  $logText = "\n|    " . date('Y-m-d,  H:i:s') . "\n";

  /* write log and update DB */
  $keys = getHomeMetaKeyNames();
  foreach ($keys as $keyName) {
    $thisMeta = cleanStr($_POST[$keyName]);
    $logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $keyName . ", ". $thisMeta . ");\n";
    update_post_meta($_POST['post_ID'], $keyName, $thisMeta); /* UPDATING THE DATABASE HERE */
  }

  $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  file_put_contents($metaDataActivityLogFile, $logText, FILE_APPEND | LOCK_EX);
}




/* end of Home Page Meta Description Fields: metabox */
?>
