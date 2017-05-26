<?php
/* Template for pages titled: 
                              Who Are We
                              About Us
*/

   require_once(E_INCLUDES.'metaData.php');
   $pageMeta = getPageMeta($post->ID);
?>

<div class="container narrow">
  <p id="p0title1"><?php echo ($pageMeta[0]); ?></p>
  <p id="p0subTitle1"><?php echo ($pageMeta[1]); ?></p>
</div>

<div class="container narrow">
  <img id="p0img1" src="<?php echo ($pageMeta[4]); ?>" />
  <p   id="p0txt1"><?php echo ($pageMeta[2]); ?></p>
</div>

<div class="container narrow">
  <p   id="p0txt2"><?php echo ($pageMeta[3]); ?></p>
  <img id="p0img2" src="<?php echo ($pageMeta[5]); ?>" />
</div>

<div class="container"></div>
