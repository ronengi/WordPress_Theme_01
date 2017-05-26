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


$displayMetaNames = array (
			   '_productMainTitle'     =>  'Page Title',
			   '_productMainSubTitle'  =>  'Page Sub-Title',
			   '_productMainImage'     =>  'Page Image',

			   '_stx'                  =>  'Text Only',
			   '_sti'                  =>  'Left Text, Right Image',
			   '_sit'                  =>  'Left Image, Right Text',
			   '_sim'                  =>  'Image Gallery',
			   );


function getStripType($fName) {
  return substr($fName, 0, 4);
}

function getStripIndex($fName) {
  $tmp = substr($fName, 0, 4);        $fName = str_replace($tmp, '', $fName);    /* remove '_sXX'*/
  $tmp = strstr($fName, 'Title');     $fName = str_replace($tmp, '', $fName);    /* remove 'Title' */
  $tmp = strstr($fName, 'Text');      $fName = str_replace($tmp, '', $fName);    /* remove 'Text' */
  $tmp = strstr($fName, 'Anchor');    $fName = str_replace($tmp, '', $fName);    /* remove 'Anchor' */
  $tmp = strstr($fName, 'img');       $fName = str_replace($tmp, '', $fName);    /* remove 'img[0-n]' */
  $tmp = strstr($fName, 'bImg');      $fName = str_replace($tmp, '', $fName);    /* remove 'bImg' */

  /* remains the index */
  return $fName;
}


function drawStripAnchor($strip, $stripCount) {
  $count = 0;
  foreach ($strip as $sKey => $sVal) {
    if (strpos($sKey, 'Anchor') > 0) {
      ++$count;
      echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
              <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Anchor :</i></b></label>
                <span style="float:right;  padding:5px 10px;  background:red;"><input type="checkbox" name="_delete'. $sKey .'"></span>
                <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="'. $sVal .'" size="93"></span>
            </div>';
    }
  }
  if ($count == 0) {
    $sKey = $strip['type'] . $strip['index'] . 'Anchor';
    echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
            <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Anchor :</i></b></label>
              <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="" size="100"></span>
          </div>';
  }
}

function drawStripTitle($strip, $stripCount) {
  $count = 0;
  foreach ($strip as $sKey => $sVal) {
    if (strpos($sKey, 'Title') > 0) {
      ++$count;
      echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
              <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Title :</i></b></label>
                <span style="float:right;  padding:5px 10px;  background:red;"><input type="checkbox" name="_delete' . $sKey .'"></span>
                <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="'. $sVal .'" size="93"></span>
            </div>';
    }
  }
  if ($count == 0) {
    $sKey = $strip['type'] . $strip['index'] . 'Title';
    echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
            <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Title :</i></b></label>
              <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="" size="100"></span>
          </div>';
  }
}

function drawStripText($strip, $stripCount) {
  $count = 0;
  foreach ($strip as $sKey => $sVal) {
    if (strpos($sKey, 'Text') > 0) {
      ++$count;
      echo '<div style="clear:both;  height:43px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
              <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Text :</i></b></label>
                <span style="float:right;  padding:5px 10px;  background:red;"><input type="checkbox" name="_delete'. $sKey .'"></span>
                <span style="float:right;  padding:5px 10px 0px 0px;"><textarea id="'. $sKey .'" name="'. $sKey .'" rows="1" cols="90">'. $sVal .'</textarea></span>
            </div>';
    }
  }
  /* its possible to get here only if changing the code to add text field to strip type */
  if ($count == 0) {
    $sKey = $strip['type'] . $strip['index'] . 'Text';
    echo '<div style="clear:both;  height:43px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
            <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Text :</i></b></label>
              <span style="float:right;  padding:5px 10px;  background:red;"><input type="checkbox" name="_delete'. $sKey .'"></span>
              <span style="float:right;  padding:5px 10px 0px 0px;"><textarea id="'. $sKey .'" name="'. $sKey .'" rows="1" cols="90"></textarea></span>
          </div>';
  }
}

function drawStripBackground($strip, $stripCount) {
  $count = 0;
  foreach ($strip as $sKey => $sVal) {
    if (strpos($sKey, 'bImg') > 0) {
      ++$count;
      echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
              <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Background :</i></b></label>
                <span style="float:right;  padding:5px 10px;  background:red;"><input type="checkbox" name="_delete'. $sKey .'"></span>
                <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="'. $sVal .'" size="93"></span>
            </div>';
    }
  }
  if ($count == 0) {
    $sKey = $strip['type'] . $strip['index'] . 'bImg';
    echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
            <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Background :</i></b></label>
              <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="" size="100"></span>
          </div>';
  }
}

function drawStripImages($_strip, $stripCount) {

  /* first: sort the images by index */
  $strip = array();
  foreach ($_strip as $sKey => $sVal) {
    /* echo $sKey . " => " . $sVal . "<br>\n"; */
    if (strpos($sKey, 'img') > 0)
      $strip[$sKey] = $sVal;
  }
  ksort($strip);


  $count = 0;
  $lastImg = '';
  $lastImgVal = '';
  foreach ($strip as $sKey => $sVal) {
    ++$count;
    $lastImg = $sKey;
    $lastImgVal = $sVal;
    echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
            <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Image '. $count  .':</i></b></label>
              <span style="float:right;  padding:5px 10px;  background:red;"><input type="checkbox" name="_delete'. $sKey .'"></span>
              <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="'. $sVal .'" size="93" ></span>
          </div>';
  }

  if ($count > 0  &&  $lastImgVal == '') /* if last image is empty, no need to add a new image */
    return;

  if ($count == 0)    $lastImg = 0; /* no images */
  else                $lastImg = substr(strstr($lastImg, 'img'), 3) + 1;

  ++$count;
  $sKey = $_strip['type'] . $_strip['index'] . 'img' . $lastImg;
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#FFE4E1; padding:1px 0px; margin:1px auto;">
          <label for="' .$sKey. '" style="float:left;  padding:5px 0px 7px 50px;"><b><i>Image '. $count .' :</i></b></label>
            <span style="float:right;  padding:5px 10px;  background:red;"><input type="checkbox" name="_delete'. $sKey .'"></span>
            <span style="float:right;  padding:5px 10px 0px 0px;"><input type="text" id="'. $sKey .'" name="'. $sKey .'" value="" size="93" ></span>
        </div>';
}

function drawStripFields($strip, $stripCount) {

  global $displayMetaNames;

  $strip['type'] = getStripType(key($strip));
  $strip['index'] = getStripIndex(key($strip));


  echo '<div style="clear:both;  height:25px;  width:60%;  background:#EED5D2; padding:1px 0px; margin-bottom:1px; margin-top:20px; margin-right:auto;  margin-left:auto;">
          <label style="float:left;  padding:5px 20px 7px 20px;"><b><i>Content Strip '. ($stripCount + 1) .' - '. $displayMetaNames[$strip['type']] .' :</i></b></label>
          <span style="float:right;  padding:5px 10px;  background:red;">
            <input type="checkbox" name="_delete'. $strip['type'].$strip['index'] .'">
          </span>
        </div>';


  drawStripAnchor($strip, $stripCount);

  switch ($strip['type']) {
  case '_stx':
    drawStripTitle($strip, $stripCount);
    drawStripText($strip, $stripCount);
    drawStripBackground($strip, $stripCount);
    break;
  case '_sti':
    drawStripTitle($strip, $stripCount);
    drawStripText($strip, $stripCount);
    drawStripImages($strip, $stripCount);
    drawStripBackground($strip, $stripCount);
    break;
  case '_sit':
    drawStripImages($strip, $stripCount);
    drawStripTitle($strip, $stripCount);
    drawStripText($strip, $stripCount);
    drawStripBackground($strip, $stripCount);
    break;
  case '_sim':
    drawStripImages($strip, $stripCount);
    drawStripTitle($strip, $stripCount);
    drawStripText($strip, $stripCount);
    break;
  }

}


/* sort strips data by strip adding order (getStripIndex(fieldName)) */
function stripIndexSort($productMeta) {

  $keyIndexMap = array();

  foreach($productMeta as $pKey => $pVal ) {
    if (strpos($pKey, '_s') === 0) /* its a strip data */
      $keyIndexMap[$pKey] = getStripIndex($pKey);
  }


  $iCount = 0;
  $newIndex = array();
  foreach($keyIndexMap as $pKey => $sIndex) {
    if (isset($newIndex[$sIndex]))
      $keyIndexMap[$pKey] = $newIndex[$sIndex];
    else {
      $newIndex[$sIndex] = $iCount;
      $keyIndexMap[$pKey] = $iCount;
      ++$iCount;
    }
  }

  asort($keyIndexMap);

  $sorted = array();
  foreach($keyIndexMap as $pKey => $sIndex)
    $sorted[$pKey] = $productMeta[$pKey];

  return $sorted;
}


/* draw the meta box */
function cbProductMeta( $post ) {

  global $productMetaKeyNames;
  global $displayMetaNames;

  wp_nonce_field( plugin_basename( __FILE__ ), 'productMeta_noncename' ); /* Use nonce for verification */

  /* Use get_post_meta to retrieve an existing value from the database and use the value for the form */
  $productMeta = getProductMeta($post->ID);


  /* main title */
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:1px; margin-top:20px; margin-right:auto;  margin-left:auto;">
          <label for="_productMainTitle" style="float:left;  padding:5px 20px 7px 20px;"><b><i>Page Title :</i></b></label>
          <span style="float:right;  padding:5px 10px;"><input type="text" name="_productMainTitle" value="'. $productMeta['_productMainTitle'] .'" size="100"></span>
        </div>';

  /* main sub-title */
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:1px; margin-top:1px; margin-right:auto;  margin-left:auto;">
          <label for="_productMainSubTitle" style="float:left;  padding:5px 20px 7px 20px;"><b><i>Page Sub-Title :</i></b></label>
          <span style="float:right;  padding:5px 10px;"><input type="text" name="_productMainSubTitle" value="'. $productMeta['_productMainSubTitle'] .'" size="100"></span>
        </div>';

  /* main image */
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#CDB7B5; padding:1px 0px; margin-bottom:20px; margin-top:1px; margin-right:auto;  margin-left:auto;">
          <label for="_productMainImage" style="float:left;  padding:5px 20px 7px 20px;"><b><i>Page Image :</i></b></label>
          <span style="float:right;  padding:5px 10px;"><input type="text" name="_productMainImage" value="'. $productMeta['_productMainImage'] .'" size="100"></span>
        </div>';




  /* deal with strips */
  /*********************************************************************************************************************/

  /* foreach ($productMeta as $pmKey => $pmVal ) */
  /*   echo "\t" . $pmKey . " => " . $pmVal ."<br>\n"; */


  $productMeta = stripIndexSort($productMeta); /* sort strips data by strip adding order (getStripIndex(fieldName)) */
  //ksort($productMeta);


  $strip = array();
  $stripCount = 0;
  $_stripIndex = -1;
  $maxStripIndex = 0;

  foreach($productMeta as $pmName => $pmValue ) {

    /* its a strip data */
    if (strpos($pmName, '_s') === 0) {

      /* echo "\t" . $pmName . " => " . $pmValue ."<br>\n"; */

      $stripIndex = getStripIndex($pmName);
      $maxStripIndex = ($maxStripIndex > $stripIndex) ? $maxStripIndex : $stripIndex;

      /* is this a new strip? */
      if ($_stripIndex == $stripIndex) {      /* no */
	$strip[$pmName] = $pmValue;
      }
      else {      /* yes */
	if ($_stripIndex > -1) {
	  drawStripFields($strip, $stripCount);	/* draw a form with the fields */
	  ++$stripCount;
	}
	$_stripIndex = $stripIndex;
	$strip = array();
	$strip[$pmName] = $pmValue;
      }

    }

  } /* end reading strips data for this page */

  //if ($stripCount > 0)

  if ($_stripIndex > -1)
    drawStripFields($strip, $stripCount);	/* draw a form with the fields */



  /* add new strip */
  ++$maxStripIndex;
  echo '<div style="clear:both;  height:25px;  width:60%;  background:#EED5D2; padding:1px 0px; margin-bottom:20px; margin-top:20px; margin-right:auto;  margin-left:auto;">
          <label for="newStrip" style="float:left;  padding:5px 20px 7px 20px;"><b><i>New Content Strip :</i></b></label>
          <span style="float:left;  padding:5px 140px;">
            <select name="_newStrip">
              <option selected="selected" value="">-- Select Type --</option>
              <option value="_stx'.$maxStripIndex.'">Text Only</option>
              <option value="_sti'.$maxStripIndex.'">Left Text, Right Image</option>
              <option value="_sit'.$maxStripIndex.'">Left Image, Right Text</option>
              <option value="_sim'.$maxStripIndex.'">Image Gallery</option>
            </select>
          </span>
        </div>';
}



/* save metadata when the post is saved */
function saveProductMeta( $post_id ) {

  global $productMetaKeyNames;
  global $metaDataActivityLogFile;
  global $displayMetaNames;

  /* this is very important */
  if (wp_is_post_revision($post_id))    return;

  /* is current user authorised to do this action.  */
  if ('page' != $_POST['post_type']  ||  ! current_user_can('edit_page', $post_id))    return;

  /* did the user intend to change this value. */
  if (!isset($_POST['productMeta_noncename'])  ||  !wp_verify_nonce($_POST['productMeta_noncename'], plugin_basename(__FILE__)))    return;

  /* save the value to the database + log database activity */
  date_default_timezone_set('Asia/Jerusalem');
  $logText = "\n|    " . date('Y-m-d,  H:i:s') . "\n";



  /* Update all FORM's fields for product: static fields(Main Title, Sub-Title & image) + existing strips' data */
  $productMeta = array();
  foreach($_POST as $psKey => $psVal) {
    if (strpos($psKey, '_s') === 0  ||  strpos($psKey, '_product') === 0) {
      $psVal = cleanStr($psVal);
      $logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $psKey . ", ". $psVal . ");\n";
      update_post_meta($_POST['post_ID'], $psKey, $psVal); /* UPDATING THE DATABASE HERE  */
    }
  }

  /* int this loop, missing new form image fields that are not in DB */
  /* foreach($productMetaKeyNames as $iKey => $iVal ) { */
  /*   $productMeta[$iVal] = cleanStr($_POST[$iVal]); */
  /*   $logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $iVal . ", ". $productMeta[$iVal] . ");\n"; */
  /*   update_post_meta($_POST['post_ID'], $iVal, $productMeta[$iVal]); /\* UPDATING THE DATABASE HERE  *\/ */
  /* } */





  /* delete complete strips / strip fields */
  foreach($_POST as $pKey => $pVal) {
    if (strpos($pKey, '_delete') === 0) {

      /* clear  single field */
      if (strpos($pKey, 'Anchor')  ||  strpos($pKey, 'Title')  ||  strpos($pKey, 'Text')  ||  strpos($pKey, 'bImg')) {
	$pKey = substr($pKey, 7);
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pKey . ", '');\n";
	update_post_meta($_POST['post_ID'], $pKey, ''); /* UPDATING THE DATABASE HERE  */
      }


      /* delete an image */
      else if (strpos($pKey, 'img')) {
	$pKey = substr($pKey, 7);
	$logText .= "|\t\t\t\tdelete_post_meta(" . $_POST['post_ID'] . ", " . $pKey . ", '');\n";
	delete_post_meta($_POST['post_ID'], $pKey, ''); /* UPDATING THE DATABASE HERE  */
      }






      /* delete whole strip's fields */
      else {
	$pKey = substr($pKey, 7);
	foreach($_POST as $sKey => $sVal) {
	  if (strpos($sKey, $pKey) === 0) {
	    $logText .= "|\t\t\t\tdelete_post_meta(" . $_POST['post_ID'] . ", " . $sKey . ", ". $sVal . ");\n";
	    delete_post_meta($_POST['post_ID'], $sKey, $sVal); /* UPDATING THE DATABASE HERE  */
	  }
	}
      }

    }
  }



  /* delete excess empty images */
  $_sID = '';
  $imgCount = 0;
  foreach($_POST as $pKey => $pVal) {
    $sImgPos = strpos($pKey, 'img');
    if ($sImgPos) {
      $sID = substr($pKey, 0, $sImgPos);
      if ($_sID == $sID) {
	++$imgCount;
	if ($imgCount > 0  &&  $pVal == '') {
	  $logText .= "|\t\t\t\tdelete_post_meta(" . $_POST['post_ID'] . ", " . $pKey . ");\n";
	  delete_post_meta($_POST['post_ID'], $sKey); /* UPDATING THE DATABASE HERE  */
	}
      }
      else {
	$_sID = $sID;
	$imgCount = 0;
      }

    }
  }



  /* add strip */
  foreach($_POST as $pKey => $pVal) {
    if (strpos($pKey, '_newStrip') === 0) {

      $stripType= substr($pVal, 0, 4);

      switch ($stripType) {
      case '_stx':
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Anchor, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Title, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Text, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "bImg, );\n";
	update_post_meta($_POST['post_ID'], $pVal . "Anchor", '');  /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Title", '');   /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Text", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "bImg", '');    /* UPDATING THE DATABASE HERE  */
	break;
      case '_sti':
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Anchor, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Title, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Text, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "img0, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "bImg, );\n";
	update_post_meta($_POST['post_ID'], $pVal . "Anchor", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Title", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Text", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "img0", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "bImg", '');    /* UPDATING THE DATABASE HERE  */
	break;
      case '_sit':
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Anchor, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "img0, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Title, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Text, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "bImg, );\n";
	update_post_meta($_POST['post_ID'], $pVal . "Anchor", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "img0", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Title", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Text", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "bImg", '');    /* UPDATING THE DATABASE HERE  */
	break;
      case '_sim':
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Anchor, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "img0, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Title, );\n";
	$logText .= "|\t\t\t\tupdate_post_meta(" . $_POST['post_ID'] . ", " . $pVal . "Text, );\n";
	update_post_meta($_POST['post_ID'], $pVal . "Anchor", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "img0", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Title", '');    /* UPDATING THE DATABASE HERE  */
	update_post_meta($_POST['post_ID'], $pVal . "Text", '');    /* UPDATING THE DATABASE HERE  */
	break;
      }

    }
  }


  $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  file_put_contents($metaDataActivityLogFile, $logText, FILE_APPEND | LOCK_EX);
}



/* end of Product Meta Fields: metabox */

?>
