<?php

require_once (E_INCLUDES.'pageTitles.php');

$engPageLink = get_permalink(get_page_by_title(pageTitle(get_the_title(), 'English'))->ID);
$hebPageLink = get_permalink(get_page_by_title(get_the_title())->ID);
$homePageLink = get_permalink(get_page_by_title('בית')->ID);
?>


<div class="container narrow">
  <div id="h0logo"><img src="<?php echo E_IMAGES.'logo-ra.png'; ?>" onclick="window.location.href='<?php echo $homePageLink; ?>'" ></div>
  <div id="h0lang">
    <form autocomplete="off">
      <select id="selectLang" onchange="window.location.assign(this[this.selectedIndex].value)">
        <option value="<?php echo $engPageLink; ?>" id="eng">ENGLISH</option>
        <option value="<?php echo $hebPageLink; ?>" id="heb" selected="selected">עברית</option>
      </select>
    </form>
  </div>
  <div id="h0menu"><?php wp_nav_menu( array( 'theme_location' => 'menu-heb_header' ) ); ?></div>
</div>

<div id="h0" class="container"></div>
