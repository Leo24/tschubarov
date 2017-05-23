// Some general UI pack related JS
// Extend JS String with repeat method
String.prototype.repeat = function(num) {
    return new Array(num + 1).join(this);
};

/**
 * @todo change to prototype
 * @param str
 * @param maxLen
 * @param etc
 * @returns {*}
 */
function truncateString(str, maxLen, etc) {
    if(maxLen === undefined) {
        maxLen = 80;
    }
    if(etc === undefined) {
        etc = '...';
    }
    if(str.length<=maxLen) {
        return str;
    }
    return str.substr(0,maxLen)+etc;
}

// Date prototype
Date.prototype.monthNames = {
    "en": [
        "January", "February", "March",
        "April", "May", "June",
        "July", "August", "September",
        "October", "November", "December"
    ],
    "ru": [
        "Янв", "Фев", "Мар",
        "Апр", "Май", "Июн",
        "Июл", "Авг", "Сен",
        "Окт", "Ноя", "Дек"
    ]
};

Date.prototype.getMonthName = function(lang) {
    if (lang === undefined || this.monthNames[lang] === undefined) {
        lang = "en";
    }
    return this.monthNames[lang][this.getMonth()];
};
Date.prototype.getShortMonthName = function (lang) {
    return this.getMonthName(lang).substr(0, 3);
};


function getDataPickerFormat(lang) {
    if (lang === undefined) {
        lang = "en";
    }

    if (lang == "ru") {
        return 'd M yy';
    } else {
        return 'M-dd, yy';
    }
}

String.prototype.ucFirst = function() {
    var str = this;
    if(str.length) {
        str = str.charAt(0).toUpperCase() + str.slice(1);
    }
    return str;
};

function cloneObject(obj) {
    return JSON.parse(JSON.stringify(obj))
}


//------------------------------------
// Charts

function setChartData(chData,containerRef,reversed, legendType, typeChart) {
    if(!chData['aData'].length || chData['aData'][0]['data']===undefined) {
        containerRef.empty();
        return;
    }
    
    //circles everywhere
    for(var j=0;j<chData['aData'].length;j++)
    {
        chData['aData'][j]['marker'] = {'symbol':'circle'};
    }
    var yMax = chData['yMax']+1;
    var yMin = chData['yMin'];
    if(yMin!=0)
        yMin--;
    var sdata, ts, plotLines=[], pushedDates=[];
    /*
     if(chData['aData'][0]['data'].length>10)
     xTickInterval = 24 * 3600 * 1000 * 7;
     else
     xTickInterval = 24 * 3600 * 1000;
     */
    for(j=0;j<chData['aData'].length;j++)
    {
        sdata = chData['aData'][j]['data'];
        if(sdata===undefined)
            continue;
        for(var i=0;i<sdata.length;i++)
        {
            ts = sdata[i][0];
            if($.inArray(ts,pushedDates)>-1)
                continue;
            plotLines.push({
                value: ts,
                color: '#CCCCCC',
                width:1,
                zIndex:1

            });
            pushedDates.push(ts);
        }
    }

    // types:
    // 0 - none
    // 1 - bottom
    // 2 - right
    if (legendType === undefined) {
        legendType = 2; // right
    }

    var marginBottom = undefined;

    if (legendType == 1) { // bottom
        var legend = {
            enabled: true,
            //floating: true,
            verticalAlign: 'bottom',
            align: 'right',
            //y:40,
            borderWidth: 0,
            itemStyle: {
                fontWeight: 'normal' // docs
            },
            labelFormatter: function() {
                return truncateString(this.name, 50);
            }
        };
        //var marginBottom = 100;
    }

    if (legendType == 2) { // right
        var legend = {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0,
            itemStyle: {
                fontWeight: 'normal' // docs
            },
            labelFormatter: function() {
                return truncateString(this.name, 50);
            }
        };

    }
    
    if ((legendType == 2) && (typeChart == 'legend_icon')) { // right
        var legend = {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0,
            itemStyle: {
                fontWeight: 'normal' // docs
            },
            labelFormatter: function() {
                return truncateString(this.name, 20);
            }
        };

    }

    if (legendType == 0) { // none
        var legend = {
            enabled: false
        }
    }

    var chart = {
        type: 'line',
        //,backgroundColor: '#F9F9F9'
        plotBackgroundColor: '#F9F9F9',
        marginBottom: marginBottom,
        events: {
            click: function(e) {
                hideCalendar()
            }
        }
    };

    if (chData['categories']){
        var xAxis = {
            categories: chData['categories'],
            tickmarkPlacement: 'on',
            max: chData['categories'].length-1.4,
            min: 0.4,
            startOnTick: false,
            endOnTick: false,
            minPadding: 0,
            maxPadding: 0,
            align: "left",
            gridLineWidth: 1
        };
    }else{
        var xAxis = {
            type: 'datetime'
            ,labels: {
                formatter: function () {
                    return Highcharts.dateFormat('%d/%m', this.value);
                },
                dateTimeLabelFormats: {
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%e. %b',
                    week: '%e. %b',
                    month: '%b \'%y',
                    year: '%Y'
                }
            }
            //,tickInterval:xTickInterval
            //,tickPositions: tickPositionsX
            ,minTickInterval:24 * 3600 * 1000
            ,plotLines:plotLines
        };
    }

    var yAxis ={
        title: {text: ''},
        startOnTick: false,
        reversed: reversed,
        allowDecimals: false,
        min: yMin,
        max: yMax,
        gridLineDashStyle: 'longdash'
    };

    var marker = {
        enabled : true
        ,lineWidth: 1
        ,radius:5
    };

    if (typeChart == 'social') {
        var chart = {
            type: 'line',
            plotBackgroundColor: '#FFF',
            marginBottom: marginBottom,
            events: {
                click: function(e) {
                    hideCalendar()
                }
            }
        };

        var xAxis = {
            type: 'datetime'
            ,labels: {
                formatter: function () {
                    return Highcharts.dateFormat('%d/%m', this.value);
                },
                dateTimeLabelFormats: {
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%e. %b',
                    week: '%e. %b',
                    month: '%b \'%y',
                    year: '%Y'
                }
            }
            //,tickInterval:xTickInterval
            //,tickPositions: tickPositionsX
            ,minTickInterval:24 * 3600 * 1000
            //,plotLines:plotLines
            ,lineWidth:0
            ,minorGridLineWidth:0
            ,lineColor: 'transparent'
            ,minorTickLength: 0
            ,tickLength: 0
        };

        var yAxis ={
            title: {text: ''},
            startOnTick: false,
            reversed: reversed,
            allowDecimals: false,
            min: yMin,
            max: yMax,
           // gridLineDashStyle: 'longdash'
        };

        var marker = {
            fillColor: '#FFFFFF',
            enabled : true,
            lineColor: null,
            lineWidth: 2
        }
    }

    if (typeChart == 'research') {
        var chart = {
            type: 'spline',
            plotBackgroundColor: '#FAFAFA',
            height: 200
        };

        var xAxis = {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%b, %Y'
            },
            minTickInterval: 3600*24*30*1000,
            ordinal: false
        };

        var yAxis = {
            title: {
                text: ''
            },
            min: 0
        };

        var marker = {
            "symbol": "circle",
            radius: 4,
            lineColor: '#fff',
            lineWidth: 2
       };
    }

    containerRef.highcharts({
        chart: chart,
        title: {
            text: '',
            x: -20 //center
        },
        subtitle: {
            text:'',
            x: -20
        },

        xAxis: xAxis,

        yAxis:yAxis,

        tooltip: {
            valueSuffix: chData.suffix,
            valuePrefix: chData.prefix
        },
        plotOptions: {
            line: {
                states: {
                    hover: {
                        // enabled: false
                    }
                }
            },
            series: {
                lineWidth: 3,
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {

                        }
                    }
                },
                marker: marker
            }

        },

        legend: legend,
        credits: {enabled: false},
        series: chData['aData']
    });
}

function loadChartData(currUrl,graphDivID,periodSelectID,straightParam, limitChecked,afterLoadCallback, loadDataText, typeChart, hideSpinner, noDataText, hideBlock)
{
    var periodVal = $('#'+periodSelectID).val();
    var ajaxDataUrl = currUrl+'&ajax_graph_data=1&period='+periodVal;
    var containerRef = $('#'+graphDivID);
    var seUID;
    var idx=graphDivID.indexOf('report_chart_');
    if(idx===0)
        seUID = graphDivID.substr(13);
    else
        seUID = '';
    var reversed = !(straightParam !== undefined && straightParam == true);
    hideSpinner = (typeof  hideSpinner == 'undefined') ? false : hideSpinner;
    noDataText = (typeof  noDataText == 'undefined') ? '' : '<div class="noDataText">' + noDataText + '</div>';

    if(containerRef.highcharts()!== undefined) {
        containerRef.highcharts().destroy();
    }
    if (typeChart == undefined) {
        typeChart = 'default';
    }
    containerRef.html($('#graph_loading_placeholder').html());
    if (loadDataText) {
        containerRef.find('.text').text(loadDataText);
    }

    $.get(ajaxDataUrl, function(chData) {
        var j;
        if(chData=='error' || chData==null || chData['aData'].length==0) {
            containerRef.empty();
            if (noDataText) {
                containerRef.html(noDataText);
                if (typeof  hideBlock !== 'undefined') {
                    hideBlock.hide();
                }
            }
            if (hideSpinner) {
                hideSpinner2();
            }
            if (afterLoadCallback!==undefined) {
                afterLoadCallback(graphDivID,chData);
            }
            return;
        }
        if(limitChecked!==undefined && limitChecked && !reversed && chData['aData'][0]['elemid']!==undefined) {
            var tmpChData=[];
            //containerRef.closest();
            for(j=0;j<chData['aData'].length;j++) {
                var elemID = chData['aData'][j]['elemid'];
                var cb = $('#checkbox-3-'+seUID+'_'+elemID);
                if(cb.is(':checked'))
                    tmpChData.push(chData['aData'][j]);
            }
            chData['aData'] = tmpChData;
        }
        setChartData(chData,containerRef,reversed, 2, typeChart);
        if(afterLoadCallback!==undefined) {
            afterLoadCallback(graphDivID,chData);
        }
        if (hideSpinner) {
            hideSpinner2();
        }
    },'json');

}

//
//--------------------------------------

(function($) {
    if (window.notApplicationInit) {
        return;
    }
  // Add segments to a slider
  $.fn.addSliderSegments = function (amount) {
    return this.each(function () {
      var segmentGap = 100 / (amount - 1) + "%"
        , segment = "<div class='ui-slider-segment' style='margin-left: " + segmentGap + ";'></div>";
      $(this).prepend(segment.repeat(amount - 2));
    });
  };

  $(function() {
      if ( window.notApplicationInit) {
          return;
      }

    $(".todo li").click(function() {
        $(this).toggleClass("todo-done");
    });

    // Custom Select
    $("select[name='herolist']").selectpicker({style: 'btn-primary', menuStyle: 'dropdown-inverse'});

    // Tooltips
    $(window).ready(function(){
        $("a[data-toggle=tooltip], i[data-toggle=tooltip], div[data-toggle=tooltip], span[data-toggle=tooltip], label[data-toggle=tooltip]").tooltip({
            delay: { show: 500, hide: 100, trigger: 'hover' }
        });
    });

    $("a[data-toggle=tooltipFast], span[data-toggle=tooltipFast], th[data-toggle=tooltipFast]").tooltip({
        delay: {show: 100, hide: 100, trigger: 'hover'}
    });

    $(document).on("click", "span.tooltip__a", function() {
        $('.tooltip').remove();
    });

    // Tags Input
    $(".tagsinput").tagsInput();

    // jQuery UI Sliders
    var $slider = $("#slider");
    if ($slider.length) {
      $slider.slider({
        min: 1,
        max: 5,
        value: 2,
        orientation: "horizontal",
        range: "min"
      }).addSliderSegments($slider.slider("option").max);
    }

    $(".link_message").live("click", function(event) {
        $(this).parent().parent().hide();
    });
    $(".link_message_additional").live("click", function(event) {
        $.post("admin.proxy.ajax.html", { do: 'hide_msg' }, function(data) {
            $.cookie('message_additional', 'hide');
            $(".link_message_additional").parent().parent().hide();
        });
    });

    // Placeholders for input/textarea
    $("input, textarea").placeholder();

    // Make pagination demo work
    $(".pagination a").on('click', function() {
      $(this).parent().siblings("li").removeClass("active").end().addClass("active");
    });

    $(".btn-group a").on('click', function() {
      $(this).siblings().removeClass("active").end().addClass("active");
    });

    // Disable link clicks to prevent page scrolling
    $('a[href="#fakelink"]').on('click', function (e) {
      e.preventDefault();
    });

    // Switch
    $("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();

    $(".menu_line .menu_line_items").mouseenter(function() {
        if ($(this).find('div.arrow_box').length > 0) {
            $(this).addClass("sudmenu-hover");
            $(this).find('div.arrow_box').css('left', (($(this).width()/2)-($(this).find('div.arrow_box').width()/2))).show();
        }
    }).mouseleave(function() {
        if ($(this).find('div.arrow_box').length > 0) {
            $(this).removeClass("sudmenu-hover");
            $(this).find('div.arrow_box').hide();
        }
    });

    var usernameBox = $("#topUsernameBox");
    $("div.globalHint-4").mouseenter(function() {
        if (usernameBox.length > 0) {
            usernameBox.css('left', (usernameBox.width()/2 - 4) * -1).show();
        }
    }).mouseleave(function() {
        if (usernameBox.length > 0) {
            usernameBox.hide();
        }
    });

    $(".popup-placeholder").live("click", function(event) {
        var idPopup = '';
        if (typeof $(event.target).attr('id') !== "undefined") {
            idPopup = $(event.target).attr('id');
        }
        if ($(event.target).hasClass("popup-placeholder") && (idPopup != 'importGa') && (idPopup != 'popup-placeholder-limit-demo')) {
            closePopup();
        }
    });

    $('#global_warning_shadow, #global_warning_close').live('click', function(e) {
        $('#global_warning_box').attr("style", "display: none;");
        $('#global_warning_shadow').attr("style", "display: none;");
        $("#wrap").css('position', '');
    });

    var globalHintBox = $('#global_hint_shadow, #global_hint_box');
    var wrap = $('#wrap');

    $('#global_hint_shadow').live('click', function(e) {
        if ($(this).hasClass("shadowGlobalHintAll")) {
            globalHintBox.attr("style","display:none;");
        }else{
            wrap.attr('style', '');
            globalHintBox.css("display", "none");
        }
    });

    $('.hintIcon').live('click', function(e) {
        if ($(this).hasClass("hintIconClone")) {
            showGlobalHintAll($(this));
        }else{
            wrap.attr('style', 'position: relative;');
            globalHintBox.css("display", "block");
        }
    });

    $('.topLinkGlobalHint').live('click', function(e) {
        if ($(this).hasClass("activeLinkGlobalHint")) {
            markHintCategoryViewed(window['seranking']['hint_category_id']);
            wrap.attr('style', '');
            $('#global_hint_shadow, #global_hint_box, .hintIcon').attr("style","display:none;");
            $(this).removeClass('activeLinkGlobalHint');
            $('.hintIconClone').remove();
        }else{
            $("#help-guide").dialog({
                autoOpen: false,
                modal: true
            });
            $("#help-guide").dialog("close");
            globalHintStep = 1;
            loadPageHints(window['seranking']['hint_category_id'], true, true, true);
            $(this).addClass('activeLinkGlobalHint');
        }
    });

    $(".disabledElement").live("click", function(event) {
        $("#wrap").css('position', 'relative');
        $('#global_warning_box').attr("style", "display: none;");
        $('#global_warning_shadow').attr("style", "display: none;");
        var topCorrect = 0;
        if ($(this).closest('.menu_line_sub_items').length){
            topCorrect = 14;
        }
        var posTop = $(this).offset().top + $(this).height() - (28 - topCorrect);
        var posLeft = $(this).offset().left + ($(this).width()/2) - 60;
        $('#global_warning_box').offset({top:posTop, left:posLeft}).show();
        $('#global_warning_shadow').show();
        event.preventDefault();

    });

  });
})(jQuery);

function ShowSubMenu() {
    if ($("#asubmenu").is(":hidden")) {
        $("#asubmenu").slideDown( "slow", function() {
            $("#hidesubmenu").click();
        });
    }
}

jQuery(document).ready(function($) {
    if (window.notApplicationInit) {
        return;
    }
    $('.selectpickers').selectpicker();

    (function () {
        if ( typeof window.CustomEvent === "function" ) return false;
        function CustomEvent ( event, params ) {
            params = params || { bubbles: false, cancelable: false, detail: undefined };
            var evt = document.createEvent( 'CustomEvent' );
            evt.initCustomEvent( event, params.bubbles, params.cancelable, params.detail );
            return evt;
        }
        CustomEvent.prototype = window.Event.prototype;
        window.CustomEvent = CustomEvent;
    })();
});


function setCookie(name, value, expires, path, domain, secure) {
    // Send a cookie
    //
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)

    expires instanceof Date ? expires = expires.toGMTString() : typeof(expires) == 'number' && (expires = (new Date(+(new Date) + expires * 1e3)).toGMTString());
    var r = [name + "=" + escape(value)], s, i;
    for(i in s = {expires: expires, path: path, domain: domain}) {
        s[i] && r.push(i + "=" + s[i]);
    }
    return secure && r.push("secure"), document.cookie = r.join(";"), true;
}

function addDays(date, days) {
    var d2 = new Date(date);
    d2.setDate(d2.getDate() + days);
    return d2;
}

function saveGraphPeriod(name, value) {
    if (value) {
        setCookie('graph_period_' + name, value, addDays(new Date(), 360));
    }
}

function redirect(url) {
    window.location = url;
}


function setLpagesHistoryPopupContent(e) {
    e.preventDefault();
    var popup = $('#popup_landing_pages');
    var history = $.parseJSON($(this).attr('data-json'));
    var tbody = popup.find('tbody');
    tbody.empty();
    var tbodyContent = '';
    $.each(history,function(index,item) {
        tbodyContent+='<tr><td>'+item.date+'</td><td><a href="'+item.link+'" target="_blank" class="popup_history_link">'+item.link+'</a></td></tr>';
    });
    tbody.html(tbodyContent);
    popup.dialog("open");
}


function isNumber(value) {
    if ((undefined === value) || (null === value)) {
        return false;
    }
    if (typeof value == 'number') {
        return true;
    }
    return !isNaN(value - 0);
}



function dateNow() {
    var dateobj= new Date();
    var month = dateobj.getMonth()+1;
    var day = dateobj.getDate();
    var year = dateobj.getFullYear();

    return year+'-'+month+'-'+day;
}



function add_month(year, month, add) {

    month = month+add;
    if (month > 12) {
        year += 1;
        month -= 12;
    }
    if (month < 1) {
        year -= 1;
        month += 12;
    }

    return [year, month];
}



var selectDate = '';
var open_calendar = 0;




function _2(num) {
    var A = num.toString();
    if(A.length > 1) return A;
    else return ("00" + A).slice(-2);
}

function DtToStr(d, lang) {
    d = new Date(d);
    var curr_date = ('0' + d.getDate()).slice(-2);
    var curr_month = ('0' + (d.getMonth() + 1)).slice(-2) ;
    var curr_year = d.getFullYear();

    var str;
    if (lang == 'sys') {
        str = curr_year+'-'+curr_month+'-'+curr_date;
    }else{
        if (lang == 'ru') {
            str = curr_date+' '+ d.getShortMonthName(lang)+' '+curr_year;
        } else {
            str = d.getShortMonthName(lang)+'-'+ curr_date+', '+curr_year;
        }
    }
    return str;
}

function selectRange(from, to, onRangeSelected, isCompareMode) {

    // global
    dateFrom = from;
    dateTo = to;

    var rangeText = DtToStr(from, lang) + ' - ' + DtToStr(to, lang);

    $('#date').val(rangeText).data({
        from: from,
        to: to
    });



    if(onRangeSelected!==undefined) {
        //changeRange(from, to, compareMode);
        onRangeSelected(from, to, isCompareMode);
    }

    hideCalendar();
}

function selectLastMonth(onRangeSelected) {
    var today = new Date();
    var first = new Date();
    first.setDate(today.getDate() - 29);

    selectRange(DtToStr(first,'sys'), DtToStr(today,'sys'), onRangeSelected, false);
}

function selectSixDays(onRangeSelected) {
    var today = new Date();
    var first = new Date();
    first.setDate(today.getDate() - 5);

    selectRange(DtToStr(first,'sys'), DtToStr(today,'sys'), onRangeSelected, false);
}

function selectCurrentMonth(onRangeSelected) {
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date();

    selectRange(DtToStr(firstDay,'sys'), DtToStr(lastDay,'sys'), onRangeSelected, false);
}

function showCalendar() {
    selectDate = '';
    $( "#datepicker1" ).datepicker( "refresh" );

    $('.show_calendar').attr('style', 'display: block;');
    $('.show_calendar_arrow').attr('style', 'display: block;');
    open_calendar = 1;
}

function hideCalendar() {
    $('.show_calendar').attr('style', 'display: none;');
    $('.show_calendar_arrow').attr('style', 'display: none;');
    open_calendar = 0;


    if (typeof resetCompareMode === "function") {
        resetCompareMode();
    }
}

// Calendar



function initCalendar(onRangeSelected,onChangeMonthYearCallback) {

    $("#datepicker1").datepicker({
        dateFormat: 'yy-mm-dd', numberOfMonths : 2,
        beforeShowDay: function(date) {


            var year  = date.getFullYear();
            var month = date.getMonth() + 1;

            var key = year+'_'+month;

            date = DtToStr(date, 'sys');

            if ( ! selectDate) {
                if ((date > dateFrom) && (date < dateTo)) {
                    return [true, 'selected_date', ''];
                }
                if (date == dateFrom || date == dateTo) {
                    return [true, 'end_dates', ''];
                }
            } else {
                if (date == selectDate) {
                    return [true, 'selected_date', ''];
                }
            }

            if (datesMap[key] !== undefined) {
                var map = datesMap[key];

                if ($.inArray(date, map) == -1) {
                    return [false, '', '']
                }
            }

            return [true, '', ''];
        },
        onSelect: function (date) {
            if ( ! selectDate) {
                selectDate = date;
            } else {
                if (selectDate < date) {
                    selectRange(selectDate, date,onRangeSelected)
                } else {
                    selectRange(date, selectDate,onRangeSelected);
                }


            }
        },
        onChangeMonthYear: function (year, month) {

            if(onChangeMonthYearCallback!==undefined) {
                var next = add_month(year, month, +2);
                onChangeMonthYearCallback(next[0], next[1]);
                var prev = add_month(year, month, -1);
                onChangeMonthYearCallback(prev[0], prev[1]);//updateDatesMap
            }
        }
    });
    $("#date.calendar").focus(function() {
        if (open_calendar == 0) {
            showCalendar();
        }
    });
}


//----------------------------------------------
// Dialogs

var popupDialogs  = [];
function showDialog(id, title, height, width) {

    if (title === undefined) {
        title = '';
    }
    if(height === undefined ) {
        height = 400;
    }
    if(width === undefined ) {
        width = 400;
    }
    var dlg;
    if($.inArray(id,popupDialogs)==-1) {
        var html = '' +
            '<div class="popup-placeholder" id="' + id + '" style="display:none;">' +
                '<div class="popup" style="width: '+(width+10)+'px;">' +
                    '<div class="popup-header">' +
                        '<div class="popup-title"></div>' +
                        '<div class="popup-close">' +
                            '<a href="javascript:closePopup();" style="text-decoration:none;">' +
                                '<div class="note-list-item-delete popup-close-button">&#x35;</div>' +
                            '</a>' +
                         '</div>' +
                    '</div>' +
                    '<div class="popup-content">' +
                        '<div class="scroll-simple" style="height:'+height+'px;">' +
                            '<div class="real-popup-content" style="height:'+height+'px;margin-top: 0px;">' +
                            '</div>' +
                        '</div>' +
                    '<div class="popup-buttons"></div>' +
                    '<div style="clear: both;"></div>' +
                '</div>' +
                '</div>' +
            '</div>';
        popupDialogs.push(id);
        $('body').append(html);
        dlg = $("#"+id);
        dlg.dialog({
            autoOpen: false,
            width: width,
            modal: true
        });
    }
    dlg = $("#"+id);
    dlg.find('.popup-title').html(title);
    dlg.find('.scroll-simple').scrollbar({"type": "simple"});
    dlg.dialog('open');
    return dlg;
}

function closePopup(item) {
    if (item !== undefined) {
        var dialog = $(item).closest('.popup-placeholder');
        dialog.dialog('close')
    } else {

        $(".popup-placeholder").each(function () {
            if ($(this).is(':visible')) { //case when dialog is not init
                $(this).dialog('close');
            }
        });
    }
}

//
//---------------------------------------------------

function moneyFormat(amount, isRub) {
    if (isRub) {
        return (amount * 50).toFixed(2) + ' руб';
    }
    // форматируем денежную величину в тысячные или сотые доллара
    amount = (amount - 0).toFixed(3);               // round to 0.000
    amount = amount.replace(/(\.\d\d)0$/, '$1');    // 1.050 -> 1.05
    // если после зяпятой одни лишь нули, форматируем как целое
    amount = amount.replace(/\.00$/, '');           // 1.00 -> 1
    return '$' + amount;
}

function convertFormattedNumber(s) {
    if(s.length==0) {
        return '';
    }
    var float = parseFloat(s);
    if(s.indexOf('B')!=-1) {
        return float*1000000000;
    }
    if(s.indexOf('M')!=-1) {
        return float*1000000;
    }
    if(s.indexOf('K')!=-1) {
        return float*1000;
    }
    return float;
}

//------------------------------------------
// Spinners

function showSpinner2() {
    var spinner2 = '<div class="container loocked" style="position: absolute;display: block;height: calc(100% + 20px);width: 100%;" id="spinner2"><div class="spinner-css-background"></div><div class="spinner-container" style="height: 100%;"><div class="spinner-css" id="spinner-1" style="top: 200px;position: fixed;left: 0;right: 0;margin: auto;"><span class="side sp_left"><span class="fill"></span></span><span class="side sp_right"><span class="fill"></span></span></div></div></div>';
    $("#wrap").css('position', 'relative').append(spinner2);
}

function chkShowSpinner2() {
    var spinner2 = $('#spinner2');
        spinner2.remove();
    if (spinner2.length) {
        setTimeout(function() {
            chkShowSpinner2();
        }, 1500);
    }
}

function hideSpinner2() {
    if (!$('#globalShadow').is(':visible')) {
        $("#wrap").css('position', '');
    }
    $('#spinner2').remove();
    chkShowSpinner2();
}


function showSpinnerGlobal(container, relative, text) {
    if (text === undefined) {
        text = 'Loading...';
    }
    var spinner2 = '<div class="container loocked" style="position: absolute;display: block;height: calc(100% + 20px);left: -2px;padding-right: 4px;width: 100%;" id="spinner2"><div class="centered_spinner" style="top: 10%;"><img src="/skin/site/main/img/spinner2.gif" alt="loading..."><br>'+text+'</div></div>';
    if (relative) {
        container.css('position', 'relative');
    }
    container.append(spinner2);

}

function hideSpinnerGlobal(container, relative) {
    if (relative) {
        container.css('position', '');
    }
    container.find("#spinner2").remove();
}

//
//---------------------------------------------


function initAdvancedUploader()
{
    var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

    $('input[type=file]').change(function() {
        var inp = $(this);
        var file_name;
        if( file_api && inp[ 0 ].files[ 0 ] )
            file_name = inp[ 0 ].files[ 0 ].name;
        else
            file_name = inp.val().replace( "C:\\fakepath\\", '' );

        var semibutton = inp.parent().find('.upload_button');
        if( ! file_name.length ) {
            semibutton.text(semibutton.attr('data-orig-text'));
            return;
        }
        semibutton.text(file_name);
    }).change();
}


function renderPieChart(data, container, is3d, title) {

    if (typeof title == 'undefined') {
        title = '';
    }
    var chartOpts = {
        type: 'pie'
        ,plotBackgroundColor: null
         ,plotBorderWidth: null
        ,plotShadow: false
    };
    if(is3d!== undefined && is3d) {
        chartOpts.options3d = {
            enabled: true,
                alpha: 45,
                beta: 0
        };
    }

    container.highcharts({
        chart: chartOpts,
        title: {
            text: title
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            itemMarginBottom: 10,
            itemStyle: {
                fontWeight: 'normal'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.point.name + '</b>: ' + Math.round(this.percentage) + ' %';
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                depth: 35,
                showInLegend: true,
                size: '75%'//,
            }
        },
        credits: {enabled: false},
        series: [{
            type: 'pie',
            data: data,
            point: {
                events: {
                    legendItemClick: function (e) {
                        if(e.browserEvent.ctrlKey) {
                            this.slice(null);
                            this.select(null,true);
                        } else {
                            this.select();
                        }
                        return false; // <== returning false will cancel the default action
                    }
                }
            }
        }]
    });
}

function renderCircleChart(data, container) {
    container.highcharts({
        chart: {
            renderTo: 'auditPieChar',
            type: 'pie',
            width: 270
        },
        title: {
            text: ''
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        plotOptions: {
            pie: {
                shadow: false
            }
        },
        tooltip: {
            formatter: function () {
                return this.point.name;
            }
        },
        series: [{
            name: '',
            data: data,
            size: '100%',
            innerSize: '75%',
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        }],
        credits: {enabled: false}
    });
}

//---------------------------------------------------------
// Ajax methods

/**
 * @deprecated
 * @param url
 * @param data
 * @param callback
 * @param errorCallback
 */
function postAjax(url, data, callback, errorCallback) {
    $.post(url, data, function (json) {
        if (json.error) {
           
            if (errorCallback !== undefined) {
                errorCallback(json);
            }
        } else {
            callback(json);
        }
    }, 'json').fail(function () {
        alert('Unknown error');
        if (errorCallback !== undefined) {
            errorCallback();
        }
    });
}


function getAjax(url, callback, errorCallback) {
    sendAjax("GET", url, {}, callback, errorCallback);
}

/**
 * @internal
 * @private
 *
 * @param type
 * @param url
 * @param data
 * @param callback
 * @param errorCallback
 */
function sendAjax(type, url, data, callback, errorCallback) {

    if (errorCallback === undefined) {
        errorCallback = function(error) {
            alert(error);
        };
    }

    jQuery.ajax({
        type: type,
        url: url,
        data: data,
        success: function (data) {
            if (!data.error) {
                callback(data);
            } else {
                errorCallback(data.error);
            }
        },
        dataType: 'json'
    }).fail(function (failResult) {
        var content = JSON.parse(failResult.responseText);
        var errorMessage = 'unknown error';
        if (content.error) {
            errorMessage = content.error;
        }

        errorCallback(errorMessage)
    });
}
//
//---------------------------------------------



function isDecimal(n) {
    if(n == "") {
        return false;
    }
    if (!typeof(n)=='number') {
        return false;
    }
    if (parseInt(n)<=0) {
        return false;
    }
    return true;
}

function setColumnChartData(container, chartData, typePage, noDataText, colors, endLineString)
{
    var chartOpts = {
        type: 'column'
    };

    noDataText = (typeof  noDataText == 'undefined') ? '' : '<div class="noDataText">' + noDataText + '</div>';

    if (typePage == 'web_monitoring') {
        chartData['yText'] = '';
	}

	if (typePage == undefined) {
        typePage = '';
    }

    if (endLineString == undefined) {
        typePage = '';
    }

    var legend = {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        itemMarginBottom: 10,
        itemStyle: {
            fontWeight: 'normal'
        }
    };

    if (typePage == 'web_monitoring') {
        chartOpts = {
            type: 'column',
            marginTop: 65
        };
    }
    var pointFormat;
    var formatter;
    var percentSymbol = '%';
    if (chartData['_data'] !== undefined && chartData['_data']['is_percents'] != 1) {
        percentSymbol = '';
    }
    if (chartData['aData'].length==1 && chartData['yText'].length == 0) {
        legend['enabled'] = false;
        pointFormat = '<tr><td class="highcharts_td"><span style="background-color:{series.color}" class="highcharts_series"></span> </td>' +
        '<td style="text-align: right"><b>{point.y}'+percentSymbol+'</b></td></tr>';
    } else {
        pointFormat = '<tr><td class="highcharts_td"><span style="background-color:{series.color}" class="highcharts_series"></span> <span class="highcharts_text">{series.name}</span> </td>' +
        '<td style="text-align: right"><b>{point.y}'+percentSymbol+'</b></td></tr>';
    }
    if (chartData['point_html'] !== undefined) {
        formatter = function () {
            var s = [];
            var str = '';
            s['header'] = '<table><tr><td>' + this.series.name + ': '+ this.x + '</td></tr>';
            $.each(chartData['point_html'][this.series.data.indexOf( this.point )], function(i, line) {
                s[line.name] = '<tr><td class="highcharts_td"><span style="background-color:' + line.color + '" class="highcharts_series"></span><span class="highcharts_text">' + line.name + '</span></tr>';
            });
            s['footer'] = '</table>';
            for (var i in s) {
                str += s[i] + "\n";
            }
            return str;
        }
    }

    if (endLineString){
        formatter = function () {
            return '<table><tr><td class="highcharts_td"><span style="background-color:' + this.series.color + '" class="highcharts_series"></span> <span class="highcharts_text">' + this.series.name + '</span> </td></tr>' +
            '<tr><td style="text-align: left"><b>' + this.y + '</b> ' + pluralForm(this.y, endLineString) + '</td></tr></table>';
        }
    }

    var options = {
        chart: chartOpts,
        title: {
            text: ''
        },
        xAxis: {
            categories: chartData['categories']
        },
        yAxis: {
            min: 0,
            title: {
                text: chartData['yText']
            },
            allowDecimals: false,
            stackLabels: {
                enabled: false,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: legend,

        plotOptions: {
            column: {
                //stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    /*color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }*/
                }
            }
        },
        tooltip: {
            backgroundColor: 'rgba(33, 43, 53, 0.85)',
            borderRadius: 5,
            borderWidth: 0,
            style: {
                color: '#fff'
            },
			formatter: formatter,
            useHTML: true,
            headerFormat: '<table>',
            pointFormat: pointFormat,
            footerFormat: '</table>'
        },
        credits: {enabled: false},
        series: chartData['aData']
    };
    if (colors) {
        options['colors'] = colors;
    }
    if (chartData['isStacked']=='1') {
        options['plotOptions']['column']['stacking'] = 'normal';
    }
    if ((chartData['aData'][0]['data'].length==0) && (typePage == 'web_monitoring')) {
        container.html(noDataText);
    }else{
        var chart = container.highcharts(options).highcharts();
    }
}

function loadColumnChartData(ajaxDataUrl,containerRef, afterLoadCallback, loadDataText, noDataText, hideBlock) {
    
    noDataText = (typeof  noDataText == 'undefined') ? '' : '<div class="noDataText">' + noDataText + '</div>';
    if(containerRef.highcharts()!== undefined) {
        containerRef.highcharts().destroy();
    }
    containerRef.html($('#graph_loading_placeholder').html());
    if (loadDataText) {
        containerRef.find('.text').text(loadDataText);
    }

    $.get(ajaxDataUrl, function(chData) {
        if(chData==null || chData['aData'].length==0 || (chData['_data']['totalFemalePercent'] == 0 && (chData['_data']['totalMalePercent'] == 0))) {
            containerRef.html(noDataText);
            if (typeof  hideBlock !== 'undefined') {
                hideBlock.hide();
            }
            if(afterLoadCallback!==undefined) {
                afterLoadCallback(containerRef, chData);
            }
            return;
        }

        setColumnChartData(containerRef,chData);
        if(afterLoadCallback!==undefined) {
            afterLoadCallback(containerRef, chData);
        }
    },'json');

}


//---------------------------------------
// Messages

function showMessage(msg, status) {
    if (status === undefined) {
        status = 'error';
    }
    clearMessage();
    var html = '<div class="component" id="System-BlockMessages-manage_accounts"><div class="container message '+status+'"><span class="one_message"></span><span class="two_message">'+msg+'</span><span class="close_message"><a href="javascript:void(0);" class="link_message"><img src="/skin/site/main/img/dell_message.png"></a></span></div></div>';
    $("#ajax-message-block").html(html);
    window.scrollTo(0, 0);
}

function clearMessage() {
    $('#ajax-message-block').empty();
    $('#System-BlockMessages-manage_accounts').remove(); // deprecated message style
}

//
//--------------------------------------
function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}


function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
//
//---------------------------------------------

function hexc(colorval) {
    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    delete(parts[0]);
    for (var i = 1; i <= 3; ++i) {
        parts[i] = parseInt(parts[i]).toString(16);
        if (parts[i].length == 1) parts[i] = '0' + parts[i];
    }
    return parts.join('');
}

//pluralForm( 1, ["стул", "стула", "стульев"] );
function pluralForm(n, forms) {
    return forms[(n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2) ];
}

function htmlDecode(value){
  return $('<div/>').html(value).text();
}

function defineSeIcon(seName){
    var icon = '';
    if (seName.indexOf('Google Mobile') + 1) {
        icon = 'google_mobile_site_check.svg';
    }else if (seName.indexOf('Google') + 1) {
        icon = 'google_site_check.svg';
    }else if (seName.indexOf('Yandex Mobile') + 1) {
        icon = 'yandex_mobile_site_check.svg';
    }else if (seName.indexOf('Yandex') + 1) {
        icon = 'yandex_site_check.svg';
    }else if (seName.indexOf('Yahoo') + 1) {
        icon = 'yahoo_site_check.svg';
    }else if (seName.indexOf('Bing') + 1) {
        icon = 'bing_site_check.svg';
    }else if (seName.indexOf('Youtube') + 1) {
        icon = 'youtube_site_check.svg';
    }
    return icon;
}