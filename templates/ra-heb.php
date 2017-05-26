<?php
/*
Template Name: ra-heb
*/

require_once (E_INCLUDES.'pageTitles.php');

$pageName = str_replace(' ', '_', pageTitle(get_the_title(), 'English'));
$pageTitle = get_bloginfo('name').' | '.get_the_title();

define('E_IMAGES', get_bloginfo('template_url').'/images/');
define('E_FONTS', get_bloginfo('template_url').'/fonts/');


switch ($pageName) {
case 'Home':         $pageTemplate = E_PAGES    .'heb/'.'Home.php';         break;

case 'Who_Are_We':   $pageTemplate = E_TEMPLATES.'heb/'.'pagra0.php';    break;
case 'About_Us':     $pageTemplate = E_TEMPLATES.'heb/'.'pagra0.php';    break;

case 'Products':     $pageTemplate = E_TEMPLATES.'heb/'.'pagra1.php';    break;
case 'Services':     $pageTemplate = E_TEMPLATES.'heb/'.'pagra1.php';    break;
case 'Solutions':    $pageTemplate = E_TEMPLATES.'heb/'.'pagra1.php';    break;

case 'Contact_Us':   $pageTemplate = E_TEMPLATES.'heb/'.'pagra2.php';    break;


case 'Investigative_and_Regulatory_Organizations':   $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;
case 'ra_for_Parliaments':                        $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;

case 'Transcription':                                $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;
case 'Document_Translation':                         $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;
case 'EasySubstitles':                               $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;

case 'eParliament':                                  $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;
case 'EasyRecord':                                   $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;
case 'EasyType':                                     $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;
case 'eProtocol':                                    $pageTemplate = E_TEMPLATES.'heb/'.'pagra3.php';    break;
}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <title><?php echo $pageTitle ?></title>
    <link rel="stylesheet" href="wp-content/themes/ra/templates/raStyle-heb.css" type="text/css" />
    <link rel="shortcut icon" href="<?php echo (E_IMAGES.'favicon.ico'); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
    <meta name="author" content="<?php  the_author_meta( 'display_name', 1);  echo ' (';  the_author_meta( 'user_email', 1);  echo ')';  ?>">


    <script type="text/javascript" src="wp-content/themes/ra/templates/jquery-1.8.0.js"></script>
    <script type="text/javascript" src="wp-content/themes/ra/templates/jquery-ui-1.8.23.js"></script>


    <script src="wp-content/themes/ra/templates/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(function () {
	$(".gallery").find("li[rel='galleryitem']:first").show();
	$("a.galleryleft").click(function () {
	    if ($(this).next(".gallery").find("li[rel='galleryitem']:visible").next().length > 0)
		$(this).next(".gallery").find("li[rel='galleryitem']:visible").hide().next("li[rel='galleryitem']").show("slide", { direction: "left" });
	    return false;
	});
	$("a.galleryright").click(function () {
	    if ($(this).next().next(".gallery").find("li[rel='galleryitem']:visible").prev().length > 0)
		$(this).next().next(".gallery").find("li[rel='galleryitem']:visible").hide().prev("li[rel='galleryitem']").show("slide", { direction: "right" });
	    return false;
	});
	$("li[rel='galleryitem'] a").fancybox({ helpers: { media: {}} });

    });

    </script>
    <link href="wp-content/themes/ra/templates/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />



  </head>

  <body>
    <a id="_PTOP"></a>

      <?php
	 require_once(E_MENUS.'heb/'.'header.php');	   /* header menu */
	 require_once($pageTemplate);              /* content */
	 require_once(E_MENUS.'heb/'.'footer_1.php' );	   /* high footer menus */
	 require_once(E_MENUS.'heb/'.'footer_2.php' );	   /* low footer menus */
	 ?>

  </body>

</html>





<?php
    /* Always have wp_head() just before the closing </head> tag of your theme, or you will break many plugins,
       which generally use this hook to add elements to <head> such as styles, scripts, and meta tags. */

    /* wp_head(); */
?>
