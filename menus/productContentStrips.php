<?php

require_once (E_INCLUDES.'metaData.php');
require_once(E_INCLUDES.'pageTitles.php');
require_once(E_INCLUDES.'homePageNames.php');

$isHebrew = ($post->post_parent == get_page_by_title($raHomes[1])->ID);


/***************************************************** helper functions ***************************************************************/

function printArray($arr) {
  echo "<br>\n";
  foreach($arr as $aKey => $aVal)
    echo $aKey . " => " . $aVal . "<br>\n";
  echo "<br>\n";
}

function getCSIndex($fName) {
  $tmp = substr($fName, 0, 4);        $fName = str_replace($tmp, '', $fName);    /* remove '_sXX'*/
  $fName = str_replace('Title', '', $fName);
  $fName = str_replace('Text', '', $fName);
  $fName = str_replace('Anchor', '', $fName);
  $fName = str_replace('bImg', '', $fName);
  $tmp = strstr($fName, 'img');       $fName = str_replace($tmp, '', $fName);    /* remove 'img[0-n]' */
  return $fName;
}


/***************************************************** content strip drawing functions ***************************************************************/

/* anchors list */
function drawCSAnchors($csAnchors, $smKey) {
  foreach ($csAnchors as $csIndex => $anchorName) {
    if ($csIndex != $smKey)
      echo '<a class="csAnchor" href="#'. $csIndex  .'">'. $anchorName  .'</a> ';
  }
}


/* split text paragraph to 2 columns */
function splitText($csText) {
  $csTextLR = array();
  $csText = wordwrap($csText, (mb_strlen($csText) / 1.9), '[SPLIT_HERE]');
  $splitPos = strpos($csText, '[SPLIT_HERE]');
  $csTextLR['left']  = substr($csText, 0, $splitPos);
  $csTextLR['right'] = substr($csText, $splitPos + 12);
  return $csTextLR;
}


/* buy button */
function drawBuyButton() {
  global $isHebrew;
  $buttonText = 'Buy';
  $contact = 'Contact Us';

  if ($isHebrew) {
    $buttonText = 'קנה';
    $contact = pageTitle($contact, 'Hebrew');
  }

  echo '<div class="container wide csButton">';
  echo '<button class="buyButton" onclick="window.location.href=\''. get_permalink(get_page_by_title($contact )->ID) .'\'">'. $buttonText .'</button>';
  echo '</div>';
}


/* images */
function drawCSGallery($csImg, $csType) {
  echo '<div class="gallerywrap">
          <a href="#prev" class="galleryright"></a><a href="#next" class="galleryleft"></a>
          <ul class="gallery">';
  foreach($csImg as $img) {
    echo '  <li rel="galleryitem"><a href="'. $img .'" title="תמונה 1"> <img src="'. $img .'" width="392" height="250" alt="" /></a></li>';
  }

  /*
    <li rel="galleryitem"><a href="images/img1.png" title="תמונה 1"> <img src="images/img1.png" width="392" height="250" alt="" /></a></li>
    <li rel="galleryitem"><a href="images/img2.png" title="תמונה 1"> <img src="images/img2.png" width="392" height="250" alt="" /></a></li>
    <li rel="galleryitem"><a href="images/img3.png" title="תמונה 1"> <img src="images/img3.png" width="392" height="250" alt="" /></a></li>
    <li rel="galleryitem"><a href="http://www.youtube.com/watch?v=opj24KnzrWo" title="סרט 1">  <img src="images/img1.png" width="392" height="250" alt="" /></a></li>
  */

  echo '    </ul>
        </div>';
}


/* draw strips by type */
function drawStrip($csType, $csBackground, $csAnchors, $smKey, $csTitle, $csText, $csImg) {
  global $isHebrew;
  switch ($csType) {

  case '_stx':
    echo '<a id="' . $smKey . '"></a>'; /* content strip anchor */
    echo '<div class="cStrip container narrow" style="background-image:url('. $csBackground .');">'; /* content strip container */
    echo '<div class="csTop container narrow"> <a class="aTop" href="#_PTOP">לראש הדף <img src="'. E_IMAGES .'upArrow.png"></a> </div>'; /* page top link */
    drawCSAnchors($csAnchors, $smKey);
    echo '<p class="csTitle">'. $csTitle .'</p>';
    $csTextLR = splitText($csText);
    if ($isHebrew) {    $tmp = $csTextLR['left'];      $csTextLR['left'] = $csTextLR['right'];      $csTextLR['right'] = $tmp;    }
    echo '<span class="csText csLeft">'. nl2br($csTextLR['left']) .'</span>';
    echo '<span class="csText csRight">'. nl2br($csTextLR['right']) .'</span>';
    drawBuyButton();
    break;

  case '_sti':
    echo '<a id="' . $smKey . '"></a>'; /* content strip anchor */
    echo '<div class="cStrip container narrow" style="background-image:url('. $csBackground .');">'; /* content strip container */
    echo '<div class="csTop container narrow"> <a class="aTop" href="#_PTOP">לראש הדף <img src="'. E_IMAGES .'upArrow.png"></a> </div>'; /* page top link */

    echo '<div class="csText csLeft">';
    drawCSAnchors($csAnchors, $smKey);
    echo '<p class="csTitle">'. $csTitle .'</p>';
    echo nl2br($csText);
    drawBuyButton();
    echo '</div>';

    echo '<div class="csRight">';
    drawCSGallery($csImg, $csType);
    echo '</div>';

    break;

  case '_sit':
    echo '<a id="' . $smKey . '"></a>'; /* content strip anchor */
    echo '<div class="cStrip container narrow" style="background-image:url('. $csBackground .');">'; /* content strip container */
    echo '<div class="csTop container narrow"> <a class="aTop" href="#_PTOP">לראש הדף <img src="'. E_IMAGES .'upArrow.png"></a> </div>'; /* page top link */

    echo '<div class="csImg csLeft">';
    drawCSGallery($csImg, $csType);
    echo '</div>';

    echo '<div class="csText csRight">';
    drawCSAnchors($csAnchors, $smKey);
    echo '<p class="csTitle">'. $csTitle .'</p>';
    echo nl2br($csText);
    drawBuyButton();
    echo '</div>';

    break;

  case '_sim':
    echo '<a id="' . $smKey . '"></a>'; /* content strip anchor */
    echo '<div class="cStrip container wide csGallery">'; /* content strip container */
    echo '<div class="csImg container">';
    drawCSGallery($csImg, $csType);
    echo '<div class="csLowTitle">'. $csTitle .'</div>';
    echo '<div class="csLowText">'. nl2br($csText) .'</div>';
    echo '</div>';
    break;

  }



  echo '</div>';
}




/***************************************************** main page ***************************************************************/
$productMeta = getProductMeta($post->ID);

/* foreach ($productMeta as $pmKey => $pmVal ) */
/*   echo "\t" . $pmKey . " => " . $pmVal ."<br>\n"; */


/* get all strip indexes */
$strips = array();
$count = 0;

if (isset($productMeta))
  foreach($productMeta as $pKey => $pVal) {
    if (strpos($pKey, '_s') === 0) {
      $csIndex = getCSIndex($pKey);
      if (!isset($strips[$csIndex]))
	$strips[$csIndex] = $count++;
    }
  }


/* collect all strip meta in arrays by strip index */
$stripMeta = array();
foreach($strips as $sKey => $sVal) {
  $stripMeta[$sKey] = array();
  foreach($productMeta as $pKey => $pVal) {
    $csIndex = getCSIndex($pKey);
    if ($csIndex == $sKey)
      $stripMeta[$sKey][] = $pKey;
  }
}


/* sort strip fields - only to preserve images order */
/* !!!check this:maybe doesn't sort correctly */
$sortedStripMeta = array();
foreach($stripMeta as $smKey => $smVal) {
  asort($smVal);
  $sortedStripMeta[$smKey] = $smVal;
}
$stripMeta = $sortedStripMeta;


/* make a complete anchors list */
$csAnchors = array();
foreach($stripMeta as $smKey => $smVal) {
  foreach($smVal as $fName) {
    if (strpos($fName, 'Anchor') > 0  &&  $productMeta[$fName] != '')
      $csAnchors[$smKey] = $productMeta[$fName];
  }
}




/*********************** output the content strips fields to product page **************************/
foreach($stripMeta as $sKey => $sFields) {

  /* get this content strip's meta values */
  $csType = substr(reset($sFields), 0, 4);
  $csTitle ='';
  $csText = '';
  $csBackground = '';
  $csImg = array();
  foreach ($sFields as $sfKey) {
    if (strpos($sfKey, 'Title') > 0)       $csTitle = $productMeta[$sfKey];
    if (strpos($sfKey, 'Text') > 0)        $csText = $productMeta[$sfKey];
    if (strpos($sfKey, 'bImg') > 0)        $csBackground = $productMeta[$sfKey];
    if (strpos($sfKey, 'img') > 0  &&  $productMeta[$sfKey] != '')             $csImg[] = $productMeta[$sfKey];
  }
  /* $csAnchors (array(stripIndex => AnchorName) )  is the complete anchor list already calculated */


  drawStrip($csType, $csBackground, $csAnchors, $sKey, $csTitle, $csText, $csImg);


} /* end of content strips loop */



echo '<div id="cStripBuyIt" class="container"><a href="'. get_permalink(get_page_by_title('Contact Us')->ID)  .'"><b><u>Buy It!</u></b></a></div>';

echo '<div id="cStrip0" class="container narrow"></div>';




?>
