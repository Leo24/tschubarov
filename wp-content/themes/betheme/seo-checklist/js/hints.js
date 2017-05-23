///http://devsergey.seranking.com/admin.ajax.hints.ajax-SetInitGuideModalNotShown.html

// jQuery(document).ready(function($) {
//     if ('seranking' in window) {
//         if (window['seranking'].hasOwnProperty('hint_category_id')) {
//             if (typeof showInitGuideModal !== "undefined" && showInitGuideModal == 1) {
//                 openGuide();
//             }else{
//                 loadPageHints(window['seranking']['hint_category_id'], true, false, false);
//             }
//         }
//     }
// });

function markHintCategoryViewed(categoryId) {
    $.post('admin.ajax.hints.ajax-markCategoryViewed.html', {'category_id':categoryId});
}

function markHintViewed(hintId) {
    $.post('admin.ajax.hints.ajax-markHintViewed.html', {'hint_id':hintId});
}

var globalHintArray = [];
var globalHintStep = 1;
var globalHintGuide = false;

function runGuide() {
    var htmlBody = $('html,body');
    htmlBody.animate({
        scrollTop: 0
    }, 200, function() {
        $.get('admin.ajax.hints.ajax-SetInitGuideModalShown.html', function() {
            var topLinkGlobalHint = $('.topLinkGlobalHint');
            $("#open-guide").dialog("close");
            topLinkGlobalHint.removeClass('topShow');
            globalHintStep = 1;
            loadPageHints(window['seranking']['hint_category_id'], true, true, false);
            topLinkGlobalHint.addClass('activeLinkGlobalHint');
        });
    }); 
}

function loadPageHints(categoryId, forceAll, autoShowHint, showAllHint) {
    var method;

    forceAll = (typeof  forceAll == 'undefined')?0:forceAll;
    autoShowHint = (typeof  autoShowHint == 'undefined')?0:autoShowHint;
    showAllHint = (typeof  showAllHint == 'undefined')?0:showAllHint;

    if (forceAll) {
        method = 'getAllCategoryHints';
    } else {
        method = 'getNotViewedCategoryHints';
    }
    
    $.get('admin.ajax.hints.ajax-'+method+'.html', {'category_id': categoryId}, function(data) {
        var message, hintId; 
        var k = 1;
        var hints = data['hints'];
        var totalInCategory = data['total'];
        var topLinkGlobalHint = $(".topLinkGlobalHint");
        if (totalInCategory > 0) {
            topLinkGlobalHint.css("display", "inline-block");
        }
        $.each(hints, function(i, val) {
            message = $.trim(val['message']);
            hintId = val['id'];
            if (message.length && $(".globalHint-"+hintId).length) {
                var hintElement = $(".globalHint-"+hintId);
                globalHintArray[k] = {element:"globalHint-"+hintId, text:message, width:hintElement.data('globalwidth'), vertical:hintElement.data('globalverticalposition'), horizontal:hintElement.data('globalhorizontalposition')};
                k++;                
            }
        });
        var showGlobalHint = (typeof  $.cookie('showGlobalHint') == 'undefined')?0:$.cookie('showGlobalHint');
        if (typeof showInitGuideModal == "undefined" || showInitGuideModal == 0) {
            if (categoryId == 1){
                globalHintArray.splice(-1,1);
            }
        }
        if (showGlobalHint){
            showInitGuideModal = 1;
            autoShowHint = 1;
        }else{
            if (categoryId > 1){
                globalHintArray.splice(-1,1);
            }
        }
        if (globalHintArray.length && autoShowHint) {
            topLinkGlobalHint.addClass('activeLinkGlobalHint');
            setGlobalHint();
        }
    });
}

function getNextUrl(){
    var nextUrl = '#';
    switch (window['seranking']['hint_category_id']) {
        case 1:
            nextUrl = $('.group_open_liness.list_dash').find('.data-dashboard-table-item_toolbar__a').first().find('.flat-icon__a.link-edit').first().attr('href'); 
        break;
        case 2:
            nextUrl = '/admin.site.overview.site_id-' + header_site_id + '.html';
        break;
        case 3:
            nextUrl = '/admin.site.competitors.site_id-' + header_site_id + '.html';
        break;
        case 4:
            nextUrl = '/admin.reports.checklist.site_id-' + header_site_id + '.html';
        break;
        case 5:
            nextUrl = '/admin.reports.audit.site_id-' + header_site_id + '.html';
        break;
        case 6:
            nextUrl = '/admin.backlinks.do-allBacklinks.site_id-' + header_site_id + '.html';
        break;
        case 7:
            nextUrl = '/admin.social.site_id-' + header_site_id + '.html';
        break;
        case 8:
            nextUrl = 0;
        break;        
    }
    return nextUrl;
}

function setLinkbackGlobalHint(){
    var backGlobalHint = $('.backGlobalHint');
    if (globalHintStep == 1){
        backGlobalHint.hide();
    }else{
        backGlobalHint.show();
    }
}

function setGlobalHint() {
    if (globalHintArray.hasOwnProperty(globalHintStep)) {
        var rowElement = globalHintArray[globalHintStep];
        var nextGlobalHint = $('.nextGlobalHint');
        var startGlobalHint = $('.startGlobalHint');
        var skipGlobalHint = $('.skipGlobalHint');
        if (globalHintStep == (globalHintArray.length - 1)){
            setTimeout(function() {
                nextGlobalHint.hide();
            }, 300);
            skipGlobalHint.hide();            
            if (showInitGuideModal){
                var nextSectionUrl = getNextUrl();
                if (nextSectionUrl){
                    $.cookie('showGlobalHint', '1', { expires: 7, path: '/' });
                    startGlobalHint.attr('href', getNextUrl());
                    startGlobalHint.text(globalHintNextSection);
                    startGlobalHint.attr('onclick', '');
                    skipGlobalHint.show();
                }
            } 
            setTimeout(function() {
                if (rowElement.element == 'globalHint-57'){
                    startGlobalHint.attr('style', 'position: absolute;right: 0px;');
                }else{
                    startGlobalHint.attr('style', 'display: inline-block;');
                }
            }, 300);
        }else{
            setTimeout(function() {
                nextGlobalHint.show();
                startGlobalHint.hide();
                skipGlobalHint.show();
            }, 300);
        }
        var htmlBody = $('html,body');
        if (globalHintStep == 7){
            htmlBody.animate({
                scrollTop: $('.'+rowElement.element).offset().top - htmlBody.offset().top + htmlBody.scrollTop()
            }, 200, function() {
                showGlobalHint(rowElement);
            });
        }else{
            htmlBody.animate({
                scrollTop: 0
            }, 200, function() {
                showGlobalHint(rowElement);
            });
        }
    }else{
        markHintCategoryViewed(window['seranking']['hint_category_id']);
        $('.topLinkGlobalHint').removeClass('activeLinkGlobalHint');
    }
}

function showGlobalHint(rowElement) {   
    var globalShadowBlockPopup = $('.globalShadowBlockPopup');
    var globalShadowBlockArrow = $('.globalShadowBlockArrow img');
    var globalShadow = $('#globalShadow');
    var globalShadowBlockContentText = $('.globalShadowBlockContentText');
    var globalShadowBlockContentStep = $('.globalShadowBlockContentStep');
    globalShadowBlockPopup.attr("style","top:0px;left:0px;"); 
    setLinkbackGlobalHint();
    
    globalShadowBlockPopup.removeClass('startGuide');
    
    globalShadowBlockContentStep.text(globalHintStep + ' ' + globalHintOf + ' ' + (globalHintArray.length - 1));
    globalShadowBlockContentText.html(rowElement.text);
    
    globalShadowBlockArrow.attr('style', '');
    
    var topElement = 0;
    if (rowElement.vertical == 'top'){
        topElement = $('.'+rowElement.element).offset().top + ($('.'+rowElement.element).height() / 2) + 83;
    }else{
        globalShadowBlockArrow.attr('style', 'right: auto;left: -20px;transform: rotate(180deg);top: auto;bottom: -270px;');
    }
    
    var leftElement = 0;
    if (rowElement.horizontal == 'left'){
        leftElement = $('.'+rowElement.element).offset().left - (rowElement.width + 40) - 12;
        if (rowElement.vertical == 'bottom'){
            globalShadowBlockArrow.attr('style', 'right: -20px;left: auto;transform: rotate(180deg) scale(-1, 1);top: auto;bottom: -270px;');
        }
    }else{
        leftElement = $('.'+rowElement.element).offset().left + $('.'+rowElement.element).outerWidth();
        if (rowElement.vertical == 'top'){
            globalShadowBlockArrow.attr('style', 'transform: scale(-1, 1);right: auto;left: -20px;');
        }
        if ((rowElement.element == 'globalHint-47') || (rowElement.element == 'globalHint-48') || (rowElement.element == 'globalHint-49') || (rowElement.element == 'globalHint-55') || (rowElement.element == 'globalHint-56') || (rowElement.element == 'globalHint-65') || (rowElement.element == 'globalHint-67') || (rowElement.element == 'globalHint-69') || (rowElement.element == 'globalHint-70')){
            leftElement = leftElement + 10;
        }
        if (rowElement.element == 'globalHint-68'){
            leftElement = leftElement + 5;        
        }
    }
    if (rowElement.vertical == 'top'){
        globalShadowBlockPopup.css('width', rowElement.width).offset({top:topElement, left:leftElement});
    }
    
    $('#wrap').css('position','relative');
    setMask(rowElement.element);
    $('#preGlobalShadow').hide();    
    globalShadow.show();
    var globalShadowBlockContent = $('.globalShadowBlockContent');
     
    
    if (rowElement.vertical == 'bottom'){
        topElement = $('.'+rowElement.element).offset().top + ($('.'+rowElement.element).outerHeight() / 2) - globalShadowBlockContent.height() - 90; 
        if (globalHintStep == 7){
            topElement = topElement - 17;
            leftElement = leftElement + 10;
        }
        if (rowElement.horizontal == 'left'){
            topElement = topElement + 15;        
        }
        if (rowElement.element == 'globalHint-37'){
            leftElement = leftElement - 13;
        }
        if ((rowElement.element == 'globalHint-43') || (rowElement.element == 'globalHint-54')){
            topElement = $('.'+rowElement.element).offset().top - globalShadowBlockContent.height() - 35;
            leftElement = (document.body.clientWidth/2) - (globalShadowBlockContent.width()/2);
        }
        if ((rowElement.element == 'globalHint-54') || (rowElement.element == 'globalHint-63')){
            topElement = topElement - 10;
        }
        if ((rowElement.element == 'globalHint-54') && (globalHintOf == 'of')){
            topElement = topElement - 60;
        }
        if ((rowElement.element == 'globalHint-43') || (rowElement.element == 'globalHint-38')){
            topElement = topElement - 10;
        }
        if (rowElement.element == 'globalHint-58'){
            topElement = topElement - 30;
        }
        if (rowElement.element == 'globalHint-42'){
            topElement = topElement + 5;
        }        
        if (rowElement.element == 'globalHint-59'){
            topElement = topElement - 30;
        }
        if (rowElement.element == 'globalHint-61'){
            topElement = topElement + 15;
            leftElement = leftElement + 10;
        }
        if ((rowElement.element == 'globalHint-62') || (rowElement.element == 'globalHint-63')){ 
            leftElement = leftElement + 10;
        }
        globalShadowBlockPopup.css('width', rowElement.width).offset({top:topElement, left:leftElement});
        globalShadowBlockArrow.css('bottom', '-' + (globalShadowBlockContent.height()+100) + 'px');
    }
    
    if (rowElement.vertical == 'none'){
        globalShadowBlockContentText.html('<img src="skin/site/main/svg/icn-support-guide.svg">' + globalShadowBlockContentText.html());
        globalShadowBlockPopup.addClass('startGuide');
        globalShadowBlockPopup.css('width', rowElement.width).offset({top:140, left:((document.body.clientWidth/2) - (globalShadowBlockContent.width()/2))});
    }
    
    if (rowElement.element == 'globalHint-37'){
        var arrowDash = $('.globalHint-37').closest('.data-dashboard-table-cell__a.name_url').find('.arrow_dash');
        if (!arrowDash.hasClass('open_arrow')){
            arrowDash.click();
        }
    }
    globalShadowBlockPopup.show();
}

function setMask(rowElement){
    var maskElement = $('.'+rowElement);
    var leftPositionCorrection = -5;
    var topPositionCorrection = -5;
    var widthElementCorrection = 10;
    var heightElementCorrection = 10;
    
    var globalShadowBlockContentBtn = $('.globalShadowBlockContentBtn');
        console.log(rowElement);
    
    switch (rowElement) {
        case 'globalHint-33':
            topPositionCorrection = -9;
            leftPositionCorrection = 0;
            widthElementCorrection = 5;
        break;
        case 'globalHint-34':
            leftPositionCorrection = 5;
            widthElementCorrection = -10;            
        break;
        case 'globalHint-36':
            topPositionCorrection = -9;
            heightElementCorrection = 18;          
            widthElementCorrection = -8;          
        break;
        case 'globalHint-37':
            leftPositionCorrection = -20;
            topPositionCorrection = -10;
            heightElementCorrection = 20;
            widthElementCorrection = -2;
        break;
        case 'globalHint-38':
            topPositionCorrection = 0;
            heightElementCorrection = -1;
        break;
        case 'globalHint-41':
            widthElementCorrection = 5;
        break;
        case 'globalHint-43':
            topPositionCorrection = 10;
            heightElementCorrection = 0;
        break;
        case 'globalHint-45':
        case 'globalHint-46':
        case 'globalHint-52':
            widthElementCorrection = 2;
        break;
        case 'globalHint-58':
            topPositionCorrection = -50;
            heightElementCorrection = 50;
        break;
        case 'globalHint-61':
            heightElementCorrection = 0;
            topPositionCorrection = 8;
        break;
        case 'globalHint-64':
            leftPositionCorrection = -20;
        break;
        case 'globalHint-57':
            globalShadowBlockContentBtn.attr('style', 'margin-bottom: 10px;');
            $('.btn.btn-middle.btn-green.startGlobalHint').attr('style', 'position: absolute;right: 0px;');
        break;
        case 'globalHint-55':
            globalShadowBlockContentBtn.attr('style', '');
            $('.btn.btn-middle.btn-green.startGlobalHint').attr('style', 'display: none;');
        break;
    }
        
    if ((rowElement == 'globalHint-60') && (globalHintArray.length == 2)){
        globalShadowBlockContentBtn.attr('style', 'text-align: center;');
    }
    
    var leftPosition = maskElement.offset().left + leftPositionCorrection;
    var topPosition = maskElement.offset().top + topPositionCorrection;
    var widthElement = maskElement.outerWidth() + widthElementCorrection;
    var heightElement = maskElement.outerHeight() + heightElementCorrection;
    
    var minusTopPosition = 0;
    if ($('.demo_notif_sign_up').length){
        minusTopPosition = $('.demo_notif_sign_up').height();
    }
    
    topPosition = topPosition - minusTopPosition;
    
    if (topPosition == 0){
        topPosition = 1;
    }
    if ((heightElement == 10) && (widthElement == 10)){
        heightElement = 1;
        widthElement = 1;
    }
    $('.globalShadowMaskRowCol.topLeftMask').height(topPosition).width(leftPosition);
    $('.globalShadowMaskRowCol.centerMask').height(heightElement).width(widthElement);
}

function skipGlobalHint() {
    $.get('admin.ajax.hints.ajax-SetInitGuideModalShown.html');
    showInitGuideModal = 0;
    $.removeCookie('showGlobalHint', { path: '/' });
    markHintCategoryViewed(window['seranking']['hint_category_id']);
    var openGuide = $("#open-guide");
    openGuide.dialog({
        autoOpen: false,
        modal: true
    });
    openGuide.dialog("close");
    $('#globalShadow').attr("style","display:none;");
    $('#preGlobalShadow').hide();
    var topLinkGlobalHint = $('.topLinkGlobalHint');
    topLinkGlobalHint.css("display", "inline-block");
    $('#wrap').attr('style', '');
    topLinkGlobalHint.removeClass('activeLinkGlobalHint');
}

function nextGlobalHint() {
    globalHintStep++;
    setGlobalHint();
}
function backGlobalHint() {
    globalHintStep--;
    setGlobalHint();
}
function openGuide() {
    var htmlBody = $('html,body');
    htmlBody.animate({
        scrollTop: 0
    }, 200);
    var openGuide = $("#open-guide");
    openGuide.dialog({
        autoOpen: false,
        modal: true,
        closeOnEscape: false
    });
    $('#wrap').css('position','relative');
    $('#preGlobalShadow').show();
    openGuide.dialog("open");
    globalHintGuide = true;
}


if (!window.notApplicationInit) {
    $(window).scroll(function () {
        if ($('#help-guide').is(':visible')) {
            setPositionHelpGuide();
        }
    });
    $(window).resize(function () {
        if ($('#help-guide').is(':visible')) {
            setPositionHelpGuide();
        }
        if ($('a.topLinkGlobalHint').hasClass("activeLinkGlobalHint")) {
            setGlobalHint();
        }
    });
}