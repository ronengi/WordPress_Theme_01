<?php

  require_once (E_INCLUDES.'metaData.php');

  $rulerMeta = getRulerMeta($post->ID);
  /* print_r($rulerMeta); */
  if (!isset($rulerMeta))
    return;

?>


<div id="ruler" class="container wide">
  <ul class="rulerItems container narrow">
    <?php
       $rulerItems = count($rulerMeta) / 2;
       for ($iid = 0; $iid < $rulerItems; ++$iid) {

	 $rulerItemImage = $rulerMeta[$iid * 2 + 0];
	 $rulerItemTitle = $rulerMeta[$iid * 2 + 1];
	 $rulerItemLink = "#";

	 if ($rulerItemTitle != "")
	   $rulerItemLink = get_permalink(get_page_by_title($rulerItemTitle)->ID);

	 echo '<li class="';
	 if ($rulerMeta[$iid * 2 + 1] == get_the_title($post->ID))
	   echo ' selected';
	 echo '"><img src="'.$rulerItemImage.'">';
	 echo '<a href="'.$rulerItemLink.'">'.$rulerItemTitle.'</a></li>';
       }
      ?>
  </ul>
</div>

<div id="r0" class="container"></div>
