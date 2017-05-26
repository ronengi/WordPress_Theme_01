<?php
/* Template for pages titled: 
                              צור קשר
*/

require_once(E_INCLUDES.'metaData.php');


if (isset($_POST['cName'])  &&  isset($_POST['cEmail'])  &&  isset($_POST['cCompany'])  &&  isset($_POST['cTelephone'])  &&  isset($_POST['cMessage'])) {

  $thisName = $_POST['cName'];
  $thisEmail = $_POST['cEmail'];
  $thisCompany = $_POST['cCompany'];
  $thisTelephone = $_POST['cTelephone'];

  $thisMessage = str_replace("\r", "", $_POST['cMessage']);
  $thisMessage = str_replace("\n", "\n|\t\t\t", $thisMessage);


  date_default_timezone_set('Asia/Jerusalem');
  $logText = "\n|\t" . date('Y-m-d,  H:i:s') . "\n";
  $logText .= "|\n";
  $logText .= "|\t" . "Name:\t\t".    $thisName .      "\n";
  $logText .= "|\t" . "Email:\t\t".   $thisEmail .     "\n";
  $logText .= "|\t" . "Company:\t".   $thisCompany .   "\n";
  $logText .= "|\t" . "Telephone:\t". $thisTelephone . "\n";
  $logText .= "|\t" . "Message:\t".   $thisMessage .   "\n";
  $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  $logText = cleanStr($logText);

  /* send message via mail */
  $mailTo = get_post_field('post_content', $post->ID);
  $mailTo = str_replace("\r", "", $mailTo);
  $mailTo = str_replace("\n", ", ", $mailTo);
  $mailSubject = 'E-Type Incoming Contact-Us Request';
  $mailHeaders = 'From: E-Type Web Server <' . $current_user->user_email . '>';
  if (!wp_mail($mailTo, $mailSubject, $logText, $mailHeaders)) {
  /* if (!mail($mailTo, $mailSubject, $logText, $mailHeaders)) { */
    $logText .= "|\t!!! Mailing failed !!!\n";
    $logText .= "------------------------------------------------------------------------------------------------------------------------------------------------\n";
  }

  /* log message to file */
  file_put_contents($contactLogFileHeb, $logText, FILE_APPEND | LOCK_EX);


  echo ("<script type=\"text/javascript\">");
  echo ("alert('Your Message was Successfully sent!');");
  echo ("window.location.assign(\"" . get_permalink(get_page_by_title('בית')->ID) . "\")");
  echo ("</script>");


}

?>

<div class="container narrow">

  <p class="p2title">צור קשר</p>
  <p class="p2subTitle">נשמח לקבל את הפניה שלך</p>
  <form method="post" action="">
    <div class="p2left"><label class="cLabel" for="cName">שם</label><br><input class="cInput" type="text" id="cName" name="cName" value="" /></div>
    <div class="p2left"><label class="cLabel" for="cEmail">Email</label><br><input class="cInput" type="text" id="cEmail" name="cEmail" value="" /></div>
    <div class="p2right"><label class="cLabel" for="cCompany">שם חברה</label><br><input class="cInput" type="text" id="cCompany" name="cCompany" value="" /></div>
    <div class="p2right"><label class="cLabel" for="cTelephone">טלפון</label><br><input class="cInput" type="text" id="cTelephone" name="cTelephone" value="" /></div>
    <div class="p2centerTitle container"><label class="cLabel" for="cMessage">הודעה</label><br><textarea class="cTextArea" name="cMessage" id="cMessage" cols="117" rows="10"></textarea></div>
    <div class="p2center container"><input class="cSubmit" type="submit" value="שלח" id="cSend" name="cSend" /></div>
  </form>

</div>

<div id="cFooter" class="container">
  <p id="cFooterL">5 רח. האופן<br>פתח תקוה</p>
  <p id="cFooterR">טל: 03-9267057<br>Email: sales@ra.co.il</p>
</div>

<div id="cMap" class="container">
  <iframe id="googleMap" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src='http://maps.google.com/maps?q=%D7%94%D7%90%D7%95%D7%A4%D7%9F+5+%D7%A4%D7%AA%D7%97+%D7%AA%D7%A7%D7%95%D7%95%D7%94&hl=he&ie=UTF8&ll=32.097409,34.852753&spn=0.157928,0.338173&sll=37.0625,-95.677068&sspn=37.735377,86.572266&hnear=HaOfan+5,+Petah+Tikva,+Israel&t=m&z=12&amp;output=embed'></iframe>
</div>


