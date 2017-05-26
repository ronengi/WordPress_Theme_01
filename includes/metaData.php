<?php

require_once (E_INCLUDES.'pageTitles.php');
require_once (E_INCLUDES.'homePageNames.php');
require_once (E_INCLUDES.'logFileNames.php');


/********************** globals definitions **********************/
$editedPageId = NULL;
if (isset($_GET['post']))        $editedPageId = $_GET['post'];
if (isset($_POST['post_ID']))    $editedPageId = $_POST['post_ID'];
//if (isset($editedPageId))    echo $editedPageId;

/* Script is executed twice: for $_GET, and for $_POST :  BOTH are necessary !!! */
/* $editedPageId = $_GET['post'] ? $_GET['post'] : $_POST['post_ID']; */




/********************** Meta Data Definitions & Handlings **********************/


/*
Page Meta Data: main title & sub-title, images and texts to show in top of pages.
Item Meta Data: item's descriptions, images and links to show in page grid.
Home Meta Data: home pages specific info: titles, images, links etc.

Ruler Meta Dats: middle menu strip item texts, images & backgroungs.
Product Meta Data: Product page components: main image & title, what strips of which kind & strip images, texts & links.


*/

function imageLocalize($pageId) {
  /* echo '<img src="http://localhost/wordpress/wp-content/themes/ra/images/menus/EasyType-60x50.png">'; */
  /* echo '<img src="wp-content/themes/ra/images/menus/EasyType-60x50.png">'; */

  $allMeta = get_post_meta($pageId);
  foreach($allMeta as $itemKey => $itemArr) {
    /* echo $itemKey .' => '. $itemArr . "<br>\n"; */

    foreach($itemArr as $item) {
      if (strpos($item, 'http://') === 0  &&  strpos($item, 'wordpress')) {
	$imgUrl = substr($item, strpos($item, 'wordpress') + 10);
	update_post_meta($pageId, $itemKey, $imgUrl);
	/* echo $imgUrl ."<br>\n"; */
	}
    }
  }


}



function getRulerMetaKeyNames($pageId) {
  $rulerItems = array (
		       'Solutions' => 2,
		       pageTitle('Solutions', 'Hebrew') => 2,

		       'Services' => 3,
		       pageTitle('Services', 'Hebrew') => 3,

		       'Products' => 4,
		       pageTitle('Products', 'Hebrew') => 4,

		       'eParliament' => 4,
		       pageTitle('eParliament', 'Hebrew') => 4,
		       'EasyRecord' => 4,
		       pageTitle('EasyRecord', 'Hebrew') => 4,
		       'EasyType' => 4,
		       pageTitle('EasyType', 'Hebrew') => 4,
		       'eProtocol' => 4,
		       pageTitle('eProtocol', 'Hebrew') => 4,

		       'Investigative and Regulatory Organizations' => 2,
		       pageTitle('Investigative and Regulatory Organizations', 'Hebrew') => 2,
		       'ra for Parliaments' => 2,
		       pageTitle('ra for Parliaments', 'Hebrew') => 2,

		       'Transcription' => 3,
		       pageTitle('Transcription', 'Hebrew') => 3,
		       'Document Translation' => 3,
		       pageTitle('Document Translation', 'Hebrew') => 3,
		       'EasySubstitles' => 3,
		       pageTitle('EasySubstitles', 'Hebrew') => 3,

		       );
  $pageTitle = get_the_title($pageId);
  if (!isset($rulerItems[$pageTitle]))
    return NULL;
  $rulerMetaKeyNames = array();

  for ($iid = 0; $iid < $rulerItems[$pageTitle]; ++$iid) {
    $rulerMetaKeyNames[] = '_rulerItemImage'.$iid;
    $rulerMetaKeyNames[] = '_rulerItemTitle'.$iid;
  }

  return $rulerMetaKeyNames;
}

function getRulerMeta($pageId) {

  imageLocalize($pageId);

  $rulerMetaKeyNames = getRulerMetaKeyNames($pageId);
  if (!isset($rulerMetaKeyNames))
    return NULL;
  $rulerMeta = array();
  foreach($rulerMetaKeyNames as $fieldIndex => $fieldName )
    $rulerMeta[] = get_post_meta($pageId, $fieldName, true); /* $fieldName */
  return $rulerMeta;
}



function getProductMetaKeyNames($pageId) {
  /* products' meta database field names examples:
                                            _sti3Title    :  4-th strip (left text    & right gallery)  ->  the title
					    _sti3Text     :  4-th strip (left text    & right gallery)  ->  the text
					    _sti3Anchor   :  4-th strip (left text    & right gallery)  ->  the anchor's display name
					    _sti0img0     :  1-st strip (left text    & right gallery)  ->  the 1-st image/movie
					    _syrSit1bImg  :  2-nd strip (left gallery & right text)     ->  the background image/movie
					    _syrSit2img3  :  3-rd strip (left gallery & right text)     ->  the 4-th image/movie
					    _sim0img2     :  1-st strip (gallery only)                  ->  the 3-rd image/movie
  */

  $productNames = array (
  			 'eParliament'                                 =>  TRUE,
  			 'EasyRecord'                                  =>  TRUE,
  			 'EasyType'                                    =>  TRUE,
  			 'eProtocol'                                   =>  TRUE,

  			 'Investigative and Regulatory Organizations'  =>  TRUE,
  			 'ra for Parliaments'                       =>  TRUE,

  			 'Transcription'                               =>  TRUE,
  			 'Document Translation'                        =>  TRUE,
  			 'EasySubstitles'                              =>  TRUE,
  			 );

  /* add also the hebrew translations for these pages */
  foreach ($productNames as $pKey => $pVal) {
    $productNames[pageTitle($pKey, 'Hebrew')] = TRUE;
  }



  $pageTitle = get_the_title($pageId);
  if (!isset($productNames[$pageTitle]))
    return NULL;

  /* constant fields */
  $productMetaKeyNames = array(
			       0 => '_productMainTitle',
			       1 => '_productMainSubTitle',
			       2 => '_productMainImage',
			       );

  $postMeta = get_post_meta($pageId);

  /* dynamic content-strips' data '_s...'*/
  foreach ($postMeta as $pmKey => $pmVal ) {
    if (strpos($pmKey, '_s') === 0)
      $productMetaKeyNames[] = $pmKey;
  }

  /* foreach ($productMetaKeyNames as $pmKey => $pmVal ) */
  /*   echo "\t" . $pmKey . " => " . $pmVal ."<br>\n"; */

  return $productMetaKeyNames;
}

function getProductMeta($pageId) {

  imageLocalize($pageId);

  $productMetaKeyNames = getProductMetaKeyNames($pageId);
  if (!isset($productMetaKeyNames))
    return NULL;
  $productMeta = array();
  foreach($productMetaKeyNames as $pmIndex => $pmName )
    $productMeta[$pmName] = get_post_meta($pageId, $pmName, true);

  return $productMeta;
}



function getPageMetaKeyNames() {
  return array(
	       0 => '_page_title',
	       1 => '_page_sub_title',
	       2 => '_page_text_1',
	       3 => '_page_text_2',
	       4 => '_page_image_1',
	       5 => '_page_image_2',
	       );
}

function getItemMetaKeyNames($iid) {
  return array(
	       0 => '_item_title_'.$iid,
               1 => '_item_text_'.$iid,
               2 => '_item_link_'.$iid,
               3 => '_item_target_'.$iid,
               4 => '_item_image_'.$iid
	       );
}

function getHomeMetaKeyNames() {
  return array (
		0 => '_home_page_title',
		1  => '_home_page_sub_title',

 		2  => '_home_eParl_title',
		3  => '_home_eParl_sub_title',

		4  => '_home_eRecd_title',
		5  => '_home_eRecd_sub_title',

		6  => '_home_ra_title',
		7  => '_home_ra_sub_title',

		8  => '_home_eProt_title',
		9  => '_home_eProt_sub_title',

		10 => '_home_page_title_1',
		11 => '_home_page_text_1',
		12 => '_home_page_link_1',
		13 => '_home_page_targ_1',

		14 => '_home_page_title_2',
		15 => '_home_page_text_2',
		16 => '_home_page_link_2_1',
		17 => '_home_page_targ_2_1',
		18 => '_home_page_link_2_2',
		19 => '_home_page_targ_2_2',
		20 => '_home_page_link_2_3',
		21 => '_home_page_targ_2_3',
		);
}



function whatPageMeta($pageId) {
  $pageTitle = get_the_title($pageId);

  switch ($pageTitle) {
  case 'Who Are We':
  case 'About Us':
  case 'מי אנחנו':
    return array(0, 1, 2, 3, 4, 5);
    break;

  case 'Solutions':
  case 'Services':
  case 'Products':
  case 'פתרונות':
  case 'שירותים':
  case 'מוצרים':
    return array(0, 1, 4);
    break;

  case 'test meta fields':
    return array(0, 1, 2, 3, 4, 5);
    break;

  default:			/* all other pages */
    return NULL;
    break;
  }

  return 0;
}

function howManyItems($pageId) {
  $pageTitle = get_the_title($pageId);

  switch ($pageTitle) {

  case 'Solutions':
  case 'פתרונות':
    return 2;
    break;

  case 'Services':
  case 'Products':
  case 'שירותים':
  case 'מוצרים':
    return 4;
    break;

  case 'test meta fields':
    return 2;
    break;

  default:
    return 0;
    break;
  }
  return 0;
}

function israHome($pageId) {
  global $raHomes;

  foreach ($raHomes as $langHome) {
    if ($langHome == get_the_title($pageId))
      return true;
  }
  return false;
}


function getItemMeta($pageId) {

  imageLocalize($pageId);

  $itemMeta = array();
  for ($iid = 0; $iid < howManyItems($pageId); ++$iid) {
    $keys = getItemMetaKeyNames($iid);
    $itemMeta[$iid * 5 + 0] = get_post_meta($pageId, $keys[0], true);
    $itemMeta[$iid * 5 + 1] = get_post_meta($pageId, $keys[1], true);
    $itemMeta[$iid * 5 + 2] = get_post_meta($pageId, $keys[2], true);
    $itemMeta[$iid * 5 + 3] = get_post_meta($pageId, $keys[3], true);
    $itemMeta[$iid * 5 + 4] = get_post_meta($pageId, $keys[4], true);
  }
  return $itemMeta;
}

function getPageMeta($pageId) {

  imageLocalize($pageId);

  $keys = getPageMetaKeyNames();
  $pageMeta = array();
  foreach ($keys as $keyName) {
    $thisMeta = str_replace("\r", "", get_post_meta($pageId, $keyName, true));
    $thisMeta = str_replace("\n", "<br>", $thisMeta);
    $pageMeta[] = $thisMeta;
  }
  return $pageMeta;
}

function getHomeMeta($pageId) {

  imageLocalize($pageId);

  $keys = getHomeMetaKeyNames();
  $homeMeta = array();
  foreach ($keys as $keyName) {
    $thisMeta = str_replace("\r", "", get_post_meta($pageId, $keyName, true));
    $thisMeta = str_replace("\n", "<br>", $thisMeta);
    $homeMeta[] = $thisMeta;
  }
  return $homeMeta;
}








/********************** string sanitizing **********************/
function cleanStr($str) {
  //$str = sanitize_text_field($str);
  $str = esc_attr($str);
  return $str;
}





?>
