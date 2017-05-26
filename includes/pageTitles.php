<?php
/* language mapping for page titles */

$pageTitles = array(
		    array( 'Who Are We',                'מי אנחנו',             'Quienes Somos'),
		    array( 'Home',                      'בית',                  'Casa' ),
		    array( 'Products',                  'מוצרים',               ''),
		    array( 'Solutions',                 'פתרונות',              ''),
		    array( 'Services',                  'שירותים',              ''),
		    array( 'Contact Us',                'צור קשר',              ''),

		    array( 'Investigative and Regulatory Organizations',          'מוסדות חקיקה ופיקוח',              ''),
		    array( 'eType for Parliaments',     'איטייפ לבתי נבחרים',     ''),

		    array( 'Transcription',             'תמלול',                  ''),
		    array( 'Document Translation',      'תרגום מסמכים',           ''),
		    array( 'EasySubstitles',            'כותרות',                 ''),

		    array( 'eParliament',               'אי-פרלמנט',              ''),
		    array( 'EasyRecord',                'איזי-רקורד',             ''),
		    array( 'EasyType',                  'איזי-טייפ',              ''),
		    array( 'eProtocol',                 'אי-פרוטוקול',            ''),
		    );


$languages = array(
		   'English'	=> 0,
		   'Hebrew'	=> 1,
		   );

function pageTitle($title, $lang) {
  global $pageTitles;
  global $languages;

  if (!isset($languages[$lang]))    return $title;
  $langIndex = $languages[$lang];

  foreach($pageTitles as $dictionary) {
    foreach ($dictionary as $pTitle)
      if ($pTitle == $title)
	return $dictionary[$langIndex];
  }

  return $title;
}

?>
