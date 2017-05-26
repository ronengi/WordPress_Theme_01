<?php
$homeDir = get_bloginfo('template_url') . '/pages/eng/Home/';
$imagesDir = $homeDir.'images/';
$imagesMenuDir = $homeDir.'images/menu/';
$imagesBannerDir = $homeDir.'images/banner/';
$jsDir = $homeDir.'js/';
$ScriptsDir = $homeDir.'Scripts/';
$StylesDir = $homeDir.'Styles/';


require_once (E_INCLUDES.'metaData.php');

$homeMeta = getHomeMeta($post->ID);

?>

<link href='<?php echo $StylesDir; ?>_reset.css' rel="stylesheet" type="text/css" />
<link href='<?php echo $StylesDir; ?>_style.css' rel="stylesheet" type="text/css" />
<link href='<?php echo $StylesDir; ?>_styles_en.css' rel="stylesheet" type="text/css" />


<link href='<?php echo $StylesDir; ?>index.css' rel="stylesheet" type="text/css" />

<link href='<?php echo $StylesDir; ?>homeImageBaner.css' rel="stylesheet" type="text/css" />

<link href='<?php echo $StylesDir; ?>menuStyles.css' rel="stylesheet" type="text/css" />


<script src='<?php echo $ScriptsDir; ?>jquery-1.8.0.js' type="text/javascript"></script>
<script src='<?php echo $ScriptsDir; ?>jquery-ui-1.8.23.js' type="text/javascript"></script>


<script src='<?php echo $jsDir; ?>linksJavascript.js' type="text/javascript"></script>
<script src='<?php echo $jsDir; ?>homeImageBaner.js' type="text/javascript"></script>




<form method="post" action="" id="form">

  <script type="text/javascript">
  var theForm = document.forms['form'];
  if (!theForm) {  theForm = document.form;  }
  function __doPostBack(eventTarget, eventArgument) {
    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
      theForm.__EVENTTARGET.value = eventTarget;
      theForm.__EVENTARGUMENT.value = eventArgument;
      theForm.submit();
    }
  }
  </script>


  <div id="banner">

    <div class="goleft"><a href="javascript:backwards()"><img src='<?php echo $imagesDir; ?>go_left.png'></a></div>
    <div class="slider">
      <table>
        <tr>
          <td class="contentBaner">
            <div id="frameDiv">
              <span class="removable" id="mySpan1"><?php echo $homeMeta[0]; ?></span>
              <span class="removable" id="mySpan2"><?php echo $homeMeta[1]; ?></span>
              <img class="removable" src='<?php echo $imagesDir; ?>business.png' id="soccerGuy" />
              <img src='<?php echo $imagesDir; ?>Easytype-Baner-base.png' id="underSoccer" />
              <img class="removable" src='<?php echo $imagesDir; ?>media-source.png' id="underSoccerCaption" />
              <img class="removable" src='<?php echo $imagesDir; ?>Base-Banner-transcription-comp.png' id="laptop" />
              <img class="removable" src='<?php echo $imagesDir; ?>Easytype-Baner-base.png' id="underlaptop" />
              <img class="removable" src='<?php echo $imagesDir; ?>Transcription.png' id="underlaptopCaption" />
              <img class="removable" src='<?php echo $imagesDir; ?>Base-Banner-line.png' id="line" />
              <img class="removable" src='<?php echo $imagesDir; ?>Base-Banner-E-sync.png' id="eSync" />
              <img class="removable" src='<?php echo $imagesDir; ?>Easytype-Baner-base.png' id="underResult" />
              <img class="removable" src='<?php echo $imagesDir; ?>result.png' id="underResultCaption" />
              <img class="removable" src='<?php echo $imagesDir; ?>pc.png' id="result" />
              <img class="removable" src='<?php echo $imagesDir; ?>Base-Banner-Tryit-button.png' id="tryIt" />
              <img src="" id="backgroundImg" width="587px" height="430px" />
              <img src="" id="foregroundImg" width="250px" height="195px" />
            </div>
          </td>
        </tr>
      </table>
    </div>

    <div class="goright"><a href="javascript:forward()"><img src='<?php echo $imagesDir; ?>go_right.png'></a></div>

  </div>

  <div id="center_menu">
    <ul id="content_menu_list">
      <li id='tdeParliament' ><img src='<?php echo $imagesMenuDir; ?>7.png' alt='eParliament' /><a href='javascript: somethingClicked(0)'>eParliament</a></li>
      <li id='tdEasyRecord' ><img src='<?php echo $imagesMenuDir; ?>9.png' alt='EasyRecord' /><a href='javascript: somethingClicked(1)'>EasyRecord</a></li>
      <li id='tdEasyType' ><img src='<?php echo $imagesMenuDir; ?>10.png' alt='EasyType' /><a href='javascript: somethingClicked(2)'>EasyType</a></li>
      <li id='tdeProtocol' ><img src='<?php echo $imagesMenuDir; ?>8.png' alt='eProtocol' /><a href='javascript: somethingClicked(3)'>eProtocol</a></li>
    </ul>
  </div>

  <div id="contentOutside_scriptDiv">
    <script type="text/javascript">
    var productNames = ["eParliament", "EasyRecord", "EasyType", "eProtocol"];
    var _eParliamentBanerArray = ["<?php echo $imagesBannerDir; ?>fg7.png",  "<?php echo $imagesBannerDir; ?>bg7.png",  "<?php echo $homeMeta[2]; ?>", "<?php echo $homeMeta[3]; ?>", "#tdeParliament" ];
    var _EasyRecordBanerArray =  ["<?php echo $imagesBannerDir; ?>fg9.png",  "<?php echo $imagesBannerDir; ?>bg9.png",  "<?php echo $homeMeta[4]; ?>", "<?php echo $homeMeta[5]; ?>", "#tdEasyRecord"  ];
    var _EasyTypeBanerArray =    ["<?php echo $imagesBannerDir; ?>fg10.png", "<?php echo $imagesBannerDir; ?>bg10.png", "<?php echo $homeMeta[6]; ?>", "<?php echo $homeMeta[7]; ?>", "#tdEasyType"    ];
    var _eProtocolBanerArray =   ["<?php echo $imagesBannerDir; ?>fg8.png",  "<?php echo $imagesBannerDir; ?>bg8.png",  "<?php echo $homeMeta[8]; ?>", "<?php echo $homeMeta[9]; ?>", "#tdeProtocol"   ];

    var myMatrix = new Array();
    myMatrix[0] = _eParliamentBanerArray;
    myMatrix[1] = _EasyRecordBanerArray;
    myMatrix[2] = _EasyTypeBanerArray;
    myMatrix[3] = _eProtocolBanerArray;

    </script>
  </div>



  <div id="items">
    <div>
      <h2 id="Header1"><?php echo $homeMeta[10]; ?></h2>
      <p id="firstTD"><?php echo $homeMeta[11]; ?></p>
      <a href="<?php echo $homeMeta[13]; ?>"><?php echo $homeMeta[12]; ?></a>
    </div>
    <div>
      <h2 id="Header2"><?php echo $homeMeta[14]; ?></h2>
      <p id="secondTD"><?php echo $homeMeta[15]; ?></p>
      <a href="<?php echo $homeMeta[17]; ?>"><?php echo $homeMeta[16]; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="<?php echo $homeMeta[19]; ?>"><?php echo $homeMeta[18]; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="<?php echo $homeMeta[21]; ?>"><?php echo $homeMeta[20]; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="submit_form">
      <h2>Try us now!</h2>
      <input type="text" /> 
      <span><button>Upload</button></span>
    </div>
  </div>


  <div style="clear:both; height:100px;"></div>

</form>




<!-- part_01.php -->