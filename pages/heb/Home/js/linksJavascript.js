
function createLinkWithLanguage(myThis, lang) {
    /*/alert($(myThis).attr("href"));*/
    if ($(myThis).attr("href") == "Default.aspx") {
        $(myThis).attr(
                "href",
                    "ETypeWebSite/?lang=" + lang
            );
        return;
    }
    if ($(myThis).attr("href").indexOf(".aspx") == -1) {
        $(myThis).attr(
                "href",
                    "lang=" + lang
            );
        return;
    }
    else {
        if ($(myThis).attr("href").indexOf(".aspx?") == -1)
            $(myThis).attr("href", $(this).attr("href") + "?");
        $(myThis).attr(
                "href", $(myThis).attr("href") + (
                    "&lang=" + lang
                )
            );
    }
}

function changeLinkUrls(lang) {
    $("a").each(
        function (index, value) {
            createLinkWithLanguage(this, /*lang*/$.url().param("lang") == null || $.url().param("lang")=="" ? "en" : "he");
        });
}

