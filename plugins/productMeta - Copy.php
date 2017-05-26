<?php

/*  Product Page title, text , image, strips & strips' contents
****************************************************************
add/update DB dbwordpress, Table wp_postmeta, fields:

    _productMainTitle
    _productMainSubTitle
    _productMainImage

    _sti[0-n]Title
    _sti[0-n]Text
    _sti[0-n]Anchor
    _sti[0-n]img[0-n]
    _sit[0-n]bImg

    _sit[0-n]Title
    _sit[0-n]Text
    _sit[0-n]Anchor
    _sit[0-n]img[0-n]
    _sti[0-n]bImg

    _sim[0-n]img[0-n]

*/


require_once (E_INCLUDES.'metaData.php');


/* draw product metadata box only in relevant pages */
$productMetaKeyNames = getProductMetaKeyNames($editedPageId);
if (!isset($productMetaKeyNames))
  return;


add_action('add_meta_boxes', 'addProductMeta'); /* hook: draw meta box in add/edit page screen*/
add_action('save_post', 'saveProductMeta'); /* hook: update meta-data in db */

/* call the draw the meta box */
function addProductMeta() {  add_meta_box( '_productMetaId', '<b><u><center>Product: details & Strip Items</center></u></b>', 'cbProductMeta', 'page' );  }


/* parse each field to it's ingredients */
function getStripFields($fName) {
  $strip = array();
  $strip['name'] = $fName;
  $strip['type'] = substr($fName, 0, 4);        $fName = str_replace($strip['type'],   '', $fName);
  $strip['title'] = strstr($fName, 'Title');    $fName = str_replace($strip['title'],  '', $fName);    
  $strip['text'] = strstr($fName, 'Text');      $fName = str_replace($strip['text'],   '', $fName);
  $strip['anchor'] = strstr($fName, 'Anchor');  $fName = str_replace($strip['anchor'], '', $fName);
  $strip['img'] = strstr($fName, 'img');        $fName = str_replace($strip['img'],    '', $fName);
  $strip['bImg'] = strstr($fName, 'bImg');      $fName = str_replace($strip['bImg'],   '', $fName);
  $strip['index'] = $fName;
  return $strip;
}

function cleanStripArray() {
  $strip = array (
		  'name'   => '',
		  'type'   => '',
		  'title'  => '',
		  'text'   => '',
		  'anchor' => '',
		  'img'    => '',
		  'bImg'   => '',
		  'index'  => '',
		  );
  return $strip;
}

function appendArrays($strip, $newArray) {
  if ($strip['type']   == NULL)    $strip['type']    =  $newArray['type'];
  if ($strip['title']  == NULL)    $strip['title']   =  $newArray['title'];
  if ($strip['text']   == NULL)    $strip['text']    =  $newArray['text'];
  if ($strip['anchor'] == NULL)    $strip['anchor']  =  $newArray['anchor'];
  if ($strip['img']    == NULL)    $strip['img']     =  $newArray['img'];
  if ($strip['bImg']   == NULL)    $strip['bImg']    =  $newArray['bImg'];
  if ($strip['index']  == NULL)    $strip['index']    =  $newArray['index'];
  return $strip;
}

function drawStripFields($strip) {
  print_r($strip);
}



/* draw the meta box */
function cbProductMeta( $post ) {

  global $productMetaKeyNames;

  $displayMetaNames = array (
			     '_productMainTitle'     =>  'Page Title',
			     '_productMainSubTitle'  =>  'Page Sub-Title',
			     '_productMainImage'     =>  'Page Image',

			     '_stx'                  =>  'Text Only',
			     '_sti'                  =>  'Left Text, Right Image',
			     '_sit'                  =>  'Left Image, Right Text',
			     '_sim'                  =>  'Image Gallery',
			     );

  wp_nonce_field( plugin_basename( __FILE__ ), 'productMeta_noncename' ); /* Use nonce for verification */

  /* Use get_post_meta to retrieve an existing value from the database and use the value for the form */
  $productMeta = array();
  foreach($productMetaKeyNames as $fIndex => $fName ) {
    $productMeta[$fName] = get_post_meta($post->ID, $fName, true);
  }

  /* title, sub-title & image */
  $fName = $productMetaKeyNames[0]; /* main title */
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:1px; margin-top:20px; margin-right:auto;  margin-left:auto;">
          <label for="' .$fName. '" style="float:left;  padding:5px 20px 7px 20px;"><b><i>'. $displayMetaNames[$fName] .' :</i></b></label>
          <span style="float:right;  padding:5px 10px;"><input type="text" id="'. $fName .'" name="'. $fName .'" value="'. $productMeta[$fName] .'" size="100"></span>
        </div>';

  $fName = $productMetaKeyNames[1]; /* main sub-title */
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:1px; margin-top:1px; margin-right:auto;  margin-left:auto;">
          <label for="' .$fName. '" style="float:left;  padding:5px 20px 7px 20px;"><b><i>'. $displayMetaNames[$fName] .' :</i></b></label>
          <span style="float:right;  padding:5px 10px;"><input type="text" id="'. $fName .'" name="'. $fName .'" value="'. $productMeta[$fName] .'" size="100"></span>
        </div>';

  $fName = $productMetaKeyNames[2]; /* main image */
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:20px; margin-top:1px; margin-right:auto;  margin-left:auto;">
          <label for="' .$fName. '" style="float:left;  padding:5px 20px 7px 20px;"><b><i>'. $displayMetaNames[$fName] .' :</i></b></label>
          <span style="float:right;  padding:5px 10px;"><input type="text" id="'. $fName .'" name="'. $fName .'" value="'. $productMeta[$fName] .'" size="100"></span>
        </div>';



  $productMeta = array (
			'_sit2Title'  => 'my title',
			'_sit2Text'   => 'my text',
			'_sit32Anchor' => 'my anchor',
			'_sit2Anchor' => 'my anchor',
			'_sit2img1'   => 'my 2-nd image',
			'_sit2img2'   => 'my 3-rd image',
			'_sit2bImg'   => 'my backgroung image',
			'1_sit' => 'aaa',
			);


  /* deal with strips */

  ksort($productMeta);

  $stripCount = 0;
  $stripIndex = -1;
  $strip = cleanStripArray();
  foreach($productMeta as $fName => $fValue ) {

    /* its a strip data */
    if (strpos($fName, '_s') === 0) {
      $newArray = getStripFields($fName);
      print_r($newArray);
      /* new strip index, or first strip */
      if ($stripIndex != $newArray['index']) {

	/* don't print empty strip the first time! */
	if ($stripIndex != -1)
	  drawStripFields($strip);

	++$stripCount;
	$strip = $newArray;
	$stripIndex = $newArray['index'];
      }

      /* same strip index: append $newArray data to $strip */
      else
	$strip = appendArrays($strip, $newArray);
    }

  } /* end reading data for this page */

  drawStripFields($strip);



  /* strip fields */
  $fName = '_sit2';
  $sIndex = substr($fName, 4);
  $sType = substr($fName, 0, 4);

  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:1px; margin-top:1px; margin-right:auto;  margin-left:auto;">
          <label for="' .$fName. '" style="float:left;  padding:5px 20px 7px 20px;"><b><i>Content Strip '. $sIndex .' - '. $displayMetaNames[$sType] .' :</i></b></label>
          <span style="float:right;  padding:5px 10px;  background:red;">
            <input type="checkbox" name="deleteStrip" value="'. $fName  .'">
          </span>
        </div>';



  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:1px; margin-top:1px; margin-right:auto;  margin-left:auto;">
          <label for="' .$fName. '" style="float:left;  padding:5px 20px 7px 20px;"><b><i>Content Strip '. $sIndex .' - '. $displayMetaNames[$sType] .' :</i></b></label>
          <span style="float:right;  padding:5px 10px;  background:red;">
            <input type="checkbox" name="deleteStrip" value="'. $fName  .'">
          </span>
        </div>';



  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:20px; margin-top:20px; margin-right:auto;  margin-left:auto;">
          <label for="newStrip" style="float:left;  padding:5px 20px 7px 20px;"><b><i>New Content Strip :</i></b></label>
          <span style="float:left;  padding:5px 140px;">
            <select name="newStrip">
              <option selected="selected" value="">-- Select Type --</option>
              <option value="_stx'.$stripCount.'">Text Only</option>
              <option value="_sti'.$stripCount.'">Left Text, Right Image</option>
              <option value="_sit'.$stripCount.'">Left Image, Right Text</option>
              <option value="_sim'.$stripCount.'">Image Gallery</option>
            </select>
          </span>
        </div>';

 }



/* save metadata when the post is saved */
function saveProductMeta( $post_id ) {

  global $productMetaKeyNames;
  global $metaDataActivityLogFile;


  /* this is very important */
  if (wp_is_post_revision($post_id))    return;

  /* is current user authorised to do this action.  */
  if ('page' != $_POST['post_type']  ||  ! current_user_can('edit_page', $post_id))    return;

  /* did the user intend to change this value. */
  if (!isset($_POST['productMeta_noncename'])  ||  !wp_verify_nonce($_POST['productMeta_noncename'], plugin_basename(__FILE__)))    return;

  /* save the value to the database + log database activity */
  date_default_timezone_set('Asia/Jerusalem');
  $logText = "\n|    " . date('Y-m-d,  H:i:s') . "\n";

  foreach($_POST as $pkey => $pval)
    $logText .= $pkey . " => " . $pval . "\n";

  $productMeta = array();
  foreach($productMetaKeyNames as $ikey => $ival ) {
    $productMeta[$ival] = cleanStr($_POST[$ival]);
    $logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $ival . ", ". $productMeta[$ival] . ");\n";
    //update_post_meta($_POST['post_ID'], $ival, $productMeta[$ival]); /* UPDATING THE DATABASE HERE  */
  }

  $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  file_put_contents($metaDataActivityLogFile, $logText, FILE_APPEND | LOCK_EX);
}




/* end of Product Meta Fields: metabox */
?>
