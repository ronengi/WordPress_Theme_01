<?php
/* Template for pages titled: 
                              פתרונות
			      שירותים
			      מוצרים
*/

   require_once(E_INCLUDES.'metaData.php');
   $pageMeta = getPageMeta($post->ID);
?>


<div class="container narrow">
  <div class="container">
    <img class="p1img1" src="<?php echo ($pageMeta[4]); ?>" />
    <p class="p1title"><?php echo ($pageMeta[0]); ?></p>
    <p class="p1subTitle"><?php echo ($pageMeta[1]); ?></p>
  </div>
</div>
<div class="container"></div>


<?php require_once(E_MENUS.'middleRuler.php'); ?>


<?php require_once(E_MENUS.'pageGrid.php'); ?>
