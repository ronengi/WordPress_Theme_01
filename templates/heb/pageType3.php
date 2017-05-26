<?php
/* Hebrew Template for pages titled: 
			      Investigative and Regulatory Organizations
			      eType for Parliaments

			      Transcription
			      Document Translation
			      EasySubstitles

			      eParliament
			      EasyRecord
			      EasyType
			      eProtocol
*/

require_once(E_INCLUDES.'metaData.php');

$productMetaKeyNames = getProductMetaKeyNames($post->ID);
$productMeta = getProductMeta($post->ID);

$pageImage = $productMeta[$productMetaKeyNames[2]];
$p3img = '';

if ($pageImage != '')
  $p3img = '<img id="p3img" src="'. $pageImage .'">';

?>


<div class="container narrow">
  <?php echo $p3img; ?>
  <div id="p3bannerTitles">
    <p id="p3title"><?php echo $productMeta[$productMetaKeyNames[0]]; ?></p>
    <p id="p3subTitle"><?php echo $productMeta[$productMetaKeyNames[1]]; ?></p>
  </div>
</div>
<div class="container"></div>



<div class="container wide" style="position:fixed; top:480px; z-index:999;">
<?php require_once(E_MENUS.'middleRuler.php'); ?>
</div>

<?php require_once(E_MENUS.'productContentStrips.php'); ?>