<?php

/*  synchronize contact us english & hebrew mailing lists
**********************************************************
uses the native post content field
 get_post_field('post_content', $post->ID);
*/


require_once (E_INCLUDES.'metaData.php');
require_once (E_INCLUDES.'pageTitles.php');

/* do only in contact-us pages */
$engContactPageId = get_page_by_title('Contact Us')->ID;
$hebContactPageId = get_page_by_title(pageTitle('Contact Us', 'Hebrew'))->ID;

if ($editedPageId != $hebContactPageId   &&   $editedPageId != $engContactPageId)
  return;


/* hook: write to all contact pages on save */
add_action('save_post', 'syncPages');

function syncPages() {
  global $editedPageId;
  global $hebContactPageId;
  global $engContactPageId;
  global $contactLogFile;

  if ( !current_user_can( 'edit_post', $editedPageId ) )     return;  /* this is very important */
  if (wp_is_post_revision($editedPageId))                    return;  /* this is very important */

  //echo  $editedPageId . ': ' . $hebContactPageId .', ' . $engContactPageId . "<br>\n";
  //echo $contactLogFile;

  $myPost = array();

  $myPost['post_content'] = get_post_field('post_content', $editedPageId);
  if ($editedPageId == $hebContactPageId)         $myPost['ID'] = $engContactPageId;
  else if ($editedPageId == $engContactPageId)    $myPost['ID'] = $hebContactPageId;
  else    return;

  remove_action('save_post', 'syncPages');  /* remove hook */

  wp_update_post( $myPost );	/* Update the post into the database - English page */

  $logText = "\nEdited page: " . $editedPageId;
  $logText .= "\nSaving to contact pages:\n";
  $logText .= $myPost['post_content'];
  $logText .= "\n----------------------------------------------------------------------\n";

  //file_put_contents($contactLogFile, $logText, FILE_APPEND | LOCK_EX);

  add_action('save_post', 'syncPages');

}

?>