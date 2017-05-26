<?php
require_once (E_INCLUDES.'metaData.php');

function getClass($row) {

}

?>

<div id="m0" class="container"></div>

<div id="grid" class="container wide">

  <?php
  /********** Grid Structure: **********/
  /*  topRow:  |  cell0  |  cell1  |  cell2  |  cell3  |  */
  /*  midRow:  |  cell0  |  cell1  |  cell2  |  cell3  |  */
  /*  midRow:  |  cell0  |  cell1  |  cell2  |  cell3  |  */
  /*  ...                                                 */
  /*  botRow:  |         |         |         |         |  */

     $itemMeta = getItemMeta($post->ID);
     $rows = count($itemMeta) / 10;

     for ($row = 0; $row <= $rows; ++$row) {

       $divRow = "\n".'<div class="container';
       $divCol0 = '<div class="cell cell0">';
       $divCol1 = '<div class="cell cell1">';
       $divCol2 = '<div class="cell cell2">';
       $divCol3 = '<div class="cell cell3">';

       switch ($row) {
       case 0:	         $divRow .= ' topRow">'."\n";	 break;
       case $rows:	 $divRow .= ' botRow">'."\n";	 break;
       default:          $divRow .= ' midRow">'."\n";	 break;
       }

       if ($row < $rows) {
	 $itemL = $row * 10;
	 $itemR = $row * 10 + 5;

	 if ($itemMeta[$itemL + 4] != '')	   $divCol1 .= '<img src="'.$itemMeta[$itemL + 4].'">';
	 $divCol1 .= '<p class="title">'.$itemMeta[$itemL + 0].'</p><p class="text">'.$itemMeta[$itemL +1].'</p><a href="'.$itemMeta[$itemL+ 3].'">'.$itemMeta[$itemL +2].'</a>';

	 if ($itemMeta[$itemR + 4] != '')	   $divCol2 .= '<img src="'.$itemMeta[$itemR + 4].'">';
	 $divCol2 .= '<p class="title">'.$itemMeta[$itemR + 0].'</p><p class="text">'.$itemMeta[$itemR +1].'</p><a href="'.$itemMeta[$itemR+ 3].'">'.$itemMeta[$itemR +2].'</a>';
       }

       $divCol0 .= '</div>'."\n";
       $divCol1 .= '</div>'."\n";
       $divCol2 .= '</div>'."\n";
       $divCol3 .= '</div>'."\n";

       $divRow .= $divCol0 . $divCol1 . $divCol2 . $divCol3 . '</div>' . "\n";

       echo $divRow;
     }

  ?>

</div>

<div id="g0" class="container"></div>
