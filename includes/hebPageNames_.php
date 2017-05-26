<?php

/* Hebrew language mappings */



function engPageName($hebPageName) {
  $pageNamesDic = array(
			'מי אנחנו' =>  'Who Are We',
			'בית'      =>  'Home',
			'מוצרים'   =>  'Products',
			'פתרונות'  =>  'Solutions',
			'שירותים'  =>  'Services',
			'צור קשר'  =>  'Contact Us',

			'Investigative and Regulatory Organizations' => 'Investigative and Regulatory Organizations',
			'eType for Parliaments' => 'eType for Parliaments',

			'Transcription' => 'Transcription',
			'Document Translation' => 'Document Translation',
			'EasySubstitles' => 'EasySubstitles',

			'eParliament' => 'eParliament',
			'EasyRecord' => 'EasyRecord',
			'EasyType' => 'EasyType',
			'eProtocol' => 'eProtocol',

			);

  return $pageNamesDic[$hebPageName];
}


function hebPageName($engPageName) {
  $pageNamesDic = array(
			'Who Are We' => 'מי אנחנו',
			'Home' => 'בית',
			'Products' => 'מוצרים',
			'Solutions' => 'פתרונות',
			'Services' => 'שירותים',
			'Contact Us' => 'צור קשר',

			'Investigative and Regulatory Organizations' => 'Investigative and Regulatory Organizations',
			'eType for Parliaments' => 'eType for Parliaments',

			'Transcription' => 'Transcription',
			'Document Translation' => 'Document Translation',
			'EasySubstitles' => 'EasySubstitles',

			'eParliament' => 'eParliament',
			'EasyRecord' => 'EasyRecord',
			'EasyType' => 'EasyType',
			'eProtocol' => 'eProtocol',

			);

  return $pageNamesDic[$engPageName];
}


?>
