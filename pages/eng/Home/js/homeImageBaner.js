/* Stages Constants Region */
var firstStageDelay = 1000, delayBetweenStages = 400;
var stagesArr = new Array("#frameDiv #underSoccer", "#frameDiv #underlaptop", "#frameDiv #underResult");
/* End Stages Constants Region */

/* Images On Stages Constants Region */
var firstImageDelay = 1000, delayBetweenImages = 600;
var imagesArr = new Array('#frameDiv #soccerGuy', '#frameDiv #laptop', '#frameDiv #eSync', '#frameDiv #result');
/* End Images On Stages Constants Region */

/* Headers Constants Region */
var bigHeaderDelay = 2000, subHeaderDelay = 1000;
var headersArr = new Array('#frameDiv #mySpan1', '#frameDiv #mySpan2');
/* End Headers Constants Region */

/* Captions Constants Region */
var firstCaptionDelay = 300, delayBetweenCaptions = 100;
var captionsArr = new Array("#frameDiv #underSoccerCaption", "#frameDiv #underlaptopCaption", "#frameDiv #underResultCaption");
/* End Captions Constants Region */

var imagesOnFirstStage = new Array(
    "police", "judge", "soccer", "business"
);

var imagesOnFirstStageInterval = null;
var timeoutInt = null;
/* Delay Region */
var totalDelay = 0;
/* End Delay Region */

/* TryIt Constants Region */
var DelayTry = 2500, subDelay = 0;
var TryItArr = new Array("#frameDiv #tryIt");
/* End TryIt Constants Region */

var alreadyMovedForward = false;
var alreadySLDown = false;
var currentShown = -1;

/* ****************************************************************************************************** */
/* ****************************************************************************************************** */
/* ****************************************************************************************************** */
/* ****************************************************************************************************** */
/* ****************************************************************************************************** */
/* **************************************** Function Region ********************************************* */
/* ****************************************************************************************************** */
/* ****************************************************************************************************** */
/* ****************************************************************************************************** */
/* ****************************************************************************************************** */


function insertElementsFadeSlide(i, first, usual, arr) {
    if (i == arr.length)
        return;
    totalDelay += (i == 0) ? first : usual;
    insertElementFadeInSlideDown(arr[i], totalDelay, 400);
    insertElementsFadeSlide(i + 1, first, usual, arr);
    alreadySLDown = true;
}

function insertElementFadeInSlideDown(id, delay, drtn) {
    //fadeElementIn(id, delay, drtn);
    $(id).delay(delay).animate(
        {
            opacity:1,
            top: "+=50"

        },
        400
        
    );
}


function RemoveElementsSlideUp(id, delay, drtn) {
    removeElementFadeOut(id, delay, drtn);
    $(id).delay(delay).animate(
            {
                top: "-=50"
            }, {
                duration: 500
            });
    $(id).delay(delay).animate(
            {
                top: "+=50"
            }, {
                duration: 500
            });
}

function moveForward(drtn, dlay) {
    if (!alreadyMovedForward) {
        alreadyMovedForward = true;
        $("#frameDiv #underSoccer").animate(
        {
            opacity: 1,
            width: "359",
            top: "185",
            left: "70"
        }, {
            duration: 1000
        });
        return drtn + 1000;
    }
    $("#frameDiv #underSoccer").css({top: 185, left: 70,width:359, opacity: 1});
    return drtn;
}

function insertForegroundBackgroundImages(i, duration) {
    
    fadeElementIn("#frameDiv #backgroundImg", duration, 500);
    duration += 500;
    fadeElementIn("#frameDiv #foregroundImg", duration, 500);
}

function doDefaultStuff() {
    currentShown = -1;
    removeElementFadeOut("#frameDiv *", 0, 300);
    $("#content_menu_list li").removeClass("selectedMenuTD");
    setTimeout(function () {
        displayOpeningAnimation();
    }, 350);
}

function somethingClicked(i) {
    $("#frameDiv *").clearQueue();
    $("#frameDiv *").stop();
    somethingClicked2(myMatrix[i], i);
    clearInterval(imagesOnFirstStageInterval);
    clearTimeout(timeoutInt);
    $("td.contentBaner #frameDiv #soccerGuy").css({ opacity: 0 });
}

function somethingClicked2(arr, i) {
    try {
        if (currentShown == i)
            return;
        currentShown = i;
        $("#content_menu_list li").removeClass("selectedMenuTD");
        var tdID = arr[4];
        try {
        $(tdID).addClass("selectedMenuTD");
        } catch (err) { }
        
        $("#frameDiv *").clearQueue();
        $("#frameDiv *").stop();
        RemoveElementsSlideUp("#frameDiv .removable", 0, 500);
        removeFBImagesFadeOut();
        setTimeout(function () {
            $("#frameDiv #foregroundImg").attr("src", arr[0]);
            $("#frameDiv #backgroundImg").attr("src", arr[1]);
        }, 400);
        
        setTimeout(function () {
            changeImageBar(arr);
        }, 900);}
    catch (err) { }
    try {
    } catch (err) { }
}

function switchFirstStageImage(i) {
    currentShown = i;
    $("td.contentBaner #frameDiv #soccerGuy").clearQueue();
    $("td.contentBaner #frameDiv #soccerGuy").stop();
    clearInterval(imagesOnFirstStageInterval);
    var dly = 400;
    $("td.contentBaner #frameDiv #soccerGuy").animate(
    {
        opacity: 0
    }, dly
    );
    setTimeout(function(){ $("td.contentBaner #frameDiv #soccerGuy").attr("src", "wp-content/themes/ra/pages/eng/Home/images/" + imagesOnFirstStage[i] + ".png") }, dly);
    $("td.contentBaner #frameDiv #soccerGuy").delay(dly+50).animate(
    {
        opacity: 1
    }, dly
    );
    imagesOnFirstStageInterval = setInterval(function () { forward() }, 10000);
}

function forward() {
    if ($("td.contentBaner #frameDiv #soccerGuy").css("opacity").toString() != "0") {
        if (currentShown == imagesOnFirstStage.length - 1)
            switchFirstStageImage(0);
        else
            switchFirstStageImage(1 + currentShown);
    }
}

function backwards() {
    if ($("td.contentBaner #frameDiv #soccerGuy").css("opacity").toString() != "0") {
        if (currentShown == 0)
            switchFirstStageImage(imagesOnFirstStage.length - 1);
        else
            switchFirstStageImage(currentShown - 1);
    }
}

/* ********************************************************************* */
/* ********************************************************************* */
/************************** FadeIn / FadeOut *****************************/
function fadeElementIn(id, dlay, drtn) {
    $(id).delay(dlay).animate({opacity: 1}, drtn);
}

function insertElementsFadeIn(i, first, usual, arr) {
    if (i >= arr.length) return;
    totalDelay += (i == 0) ? first : usual;
    fadeElementIn(arr[i], totalDelay, 300);
    insertElementsFadeIn(i + 1, first, usual, arr);
}
function removeElementFadeOut(id, dlay, drtn) {
    $(id).delay(dlay).animate({opacity: 0}, drtn);
}

function removeFBImagesFadeOut() {
    removeElementFadeOut("#frameDiv  #backgroundImg", 0, 400);
    removeElementFadeOut("#frameDiv  #foregroundImg", 0, 400);
}
/************************** FadeIn / FadeOut *****************************/
/* ********************************************************************* */
/* ********************************************************************* */

function changeImageBar(arr) {
    var drtn = 0;
    drtn = moveForward(drtn);
    insertForegroundBackgroundImages(arr, drtn);
    displayTextOnSpans(arr);
}

function displayTextOnSpans(arr) {
    $("#mySpan1").animate({ opacity: 0 }, { duration: 300 });
    $("#mySpan2").animate({ opacity: 0 }, { duration: 300 });
    setTimeout(function () {
        $("#mySpan1").animate({ top: "75", right: "-15" }, 0);
        $("#mySpan2").animate({ top: "275", right: "-5" }, 0);
    }, 300);
    setTimeout(function () {
        $("#mySpan1").html(arr[2]);
        $("#mySpan2").html(arr[3]);
    }, 400);
    setTimeout(function () {
        fadeElementIn("#mySpan1", 0, 500);
    }, 500);
    setTimeout(function () {
        fadeElementIn("#mySpan2", 0, 500);
    }, 900);
    
}

function displayOpeningAnimation() {
    resetObjectsForOpeningAnimation();
    $('#frameDiv #line').delay(200).fadeIn('slow', function () {
        insertElementsFadeSlide(0, firstStageDelay, delayBetweenStages, stagesArr);
        insertElementsFadeSlide(0, firstImageDelay, delayBetweenImages, imagesArr);
        insertElementsFadeIn(0, firstCaptionDelay, delayBetweenCaptions, captionsArr);
        insertElementsFadeIn(0, bigHeaderDelay, subHeaderDelay, headersArr);
        insertElementsFadeIn(0, DelayTry, subDelay, TryItArr);
    });
    timeoutInt = setTimeout(function () {
        imagesOnFirstStageInterval = setInterval(function () { forward() }, 10000);
    }, 10000);
}

function resetObjectsForOpeningAnimation() {
    totalDelay = 0;
    $("#frameDiv *").css({ opacity: 0 });
    $("#frameDiv *").clearQueue();
    $("#frameDiv *").stop();
    //$("td.contentBaner #frameDiv #mySpan1").html("Now you can");
    //$("td.contentBaner #frameDiv #mySpan2").html("Search your media using Live Text");
    $("td.contentBaner #frameDiv #mySpan1").css({ top: 60, right: -63 });
    $("td.contentBaner #frameDiv #mySpan2").css({ top: 165, right: -65 });
    $("td.contentBaner #frameDiv #soccerGuy").css({ left: 43, top: 15 });
    $("td.contentBaner #frameDiv #underSoccer, #frameDiv #underSoccerCaption").css({ left: -13, top: 82 });
    $("td.contentBaner #frameDiv #laptop").css({ left: 215, top: 155 });
    $("td.contentBaner #frameDiv #underlaptop, #frameDiv #underlaptopCaption").css({ top: 178, left: 150 });
    $("td.contentBaner #frameDiv #line").css({ opacity: 1, display: "none", top: 190, left: 70 });
    $("td.contentBaner #frameDiv #eSync").css({ top: 280, left: 327 });
    $("td.contentBaner #frameDiv #underResult, #frameDiv #underResultCaption").css({ top: 218, right: 244 });
    $("td.contentBaner #frameDiv #result").css({ top: 200, right: 290 });
    $("td.contentBaner #frameDiv #tryIt").css({ top: 220, right: 27 });
    $("td.contentBaner #frameDiv #line").css({ top: 190, left: 70 });
    $("td.contentBaner #frameDiv #line").css({ top: 190, left: 70 });
    $("td.contentBaner #frameDiv #line, #frameDiv #underResultCaption, #frameDiv #underSoccerCaption, #frameDiv #underlaptopCaption").css("top", "+=50");
    $("#frameDiv #underSoccer").css({ width: 259 });
    $("td.contentBaner #frameDiv *").css("top", "-=50");
}

$(document).ready(function () {
    displayOpeningAnimation();
});
    
