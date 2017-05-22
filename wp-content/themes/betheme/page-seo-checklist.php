<?php get_header(); ?>

<link href="<?php echo get_template_directory_uri(); ?>/css/seo-checklist.css" rel="stylesheet" type="text/css"/>
<divclass="container loocked_parent">

<div id="wrap">
    <div id="main">

        <script>
            function ShowBlockOverview(Type, Siteid){
                if (Type == 'empty_keywords'){
                    var msg_empty = "You haven't added keywords. Go to <a href=\"/admin.site.keywords.site_id-%s%.html\" style=\"color: #6f6f6f;\">project settings</a> and add the keywords.";
                }else{
                    var msg_empty = "You haven't added Search engines. Go to  <a href=\"/admin.site.se.site_id-%s%.html\" style=\"color: #6f6f6f;\">project settings</a> and add the Search Engines.";
                }
                msg_empty = msg_empty.replace('%s%', Siteid);
                $("#span-message-empty").html(msg_empty);
                $( "#popup-placeholder-message-empty" ).dialog( "open" );
            }
            function ClosePopupMessageEmpty(){
                $('#popup-placeholder-message-empty').dialog( "close" );
            }
            $(function() {
                $("#popup-placeholder-message-empty").dialog({
                    autoOpen: false,
                    modal: true
                });
            });
        </script>


        <div class="container loocked_parent">
            <script src="skin/site/main/js/jquery.knob.js"></script>
            <script src="skin/site/main/js/jquery-ui-1.10.4.min.js"></script>

            <script>
                var siteId = 230147;
            </script>

            <script>
                var countByCategories = {};
                var totalItems = 0;
                $(document).ready(function() {
                    $('.knobi_graf').html('<input class="knob" data-width="102" data-height="102" data-fgColor="#37a1e4" data-bgColor="#e1e1e1" data-thickness=".15" data-readOnly="true" data-stringText="complete" data-padText="-79px" value="0">');

                    setValueToKnobBlocks();

                    $('#categories_block').find('.row>.span4').each(function() {
                        var totalInCat = parseInt($(this).attr('data-total'));
                        var catId = $(this).attr('data-category-id');
                        countByCategories[catId] = totalInCat;
                        totalItems+=totalInCat;
                    });

                    $('#total_items').text(totalItems);
                    $(".graf-checklist .progressbar").each(function(){
                        if (parseInt($(this).attr('data-val'))==100){
                            $(this).addClass("progress-done");
                            $(this).parent('div').addClass("progress-div-done");
                        }
                        $(this).progressbar({
                            value: parseInt($(this).attr('data-val'))
                        });
                    });

                    $('.regular-checkbox').change(function() {
                        UpdateCol($(this),'update');
                        if($(this).is(":checked")) {
                            $(this).next().next().addClass("seo-select-spa");
                            $(this).parent('div').parent('div').addClass("hide-div-text");
                        }else{
                            $(this).next().next().removeClass("seo-select-spa");
                            $(this).parent('div').parent('div').removeClass("hide-div-text");
                        }
                    });

                    $("a.toogle-close").live("click", function() {
                        if($(this).parent('div').next().is(":visible")) {
                            $(this).parent('div').next().slideUp("fast");
                            $(this).removeClass("open-seo-link");
                        }else{
                            $(this).parent('div').next().slideDown("fast");
                            $(this).addClass("open-seo-link");
                        }
                    });

                    $(".seo-childs .span8 span").live("click", function() {
                        if ($(this).prev().prev().is(':checked')){
                            $(this).prev().prev().removeAttr('checked');
                            $(this).removeClass("seo-select-spa");
                            $(this).parent('div').parent('div').removeClass("hide-div-text");
                        }else{
                            $(this).prev().prev().attr('checked','checked');
                            $(this).addClass("seo-select-spa");
                            $(this).parent('div').parent('div').addClass("hide-div-text");
                        }
                        UpdateCol($(this).prev().prev(),'update');
                    });

                    StartSet();
                });

                function StartSet(){

                    var aSiteChecklist = {"razdel-strategy-install_ga":"1","razdel-strategy-add_to_gwt":"1","razdel-on_page_opt-unique_meta_descriptions":"1","razdel-on_page_opt-canonical_urls":"1","razdel-on_page_opt-broken_links":"1","razdel-on_page_opt-301_redirect":"1"};
                    $.each(aSiteChecklist, function(i) {
                        $('#'+i).attr('checked','checked');
                        $('#'+i).next().next().addClass("seo-select-spa");
                        $('#'+i).parent('div').parent('div').addClass("hide-div-text");
                        UpdateCol($("#"+i),'start');
                    });

                }

                function UpdateCol(elem, type){

                    var categoryId = $(elem).attr("date-razdel");

                    if (typeof categoryId !== "undefined") {
                        var totalItems = 0;
                        $.each(countByCategories, function(k, v){
                            totalItems+=v;
                        });

                        var checkedInCategory = $("input[id^='"+categoryId+"']").filter(':checked').length;

                        //обновляем данные по разделу в разделе
                        $("div[id='"+categoryId+"'] p span").text(checkedInCategory);
                        $("div[data-count-razdel='"+categoryId+"'] div[class='span1'] span").text(checkedInCategory);
                        var categoryPercent = parseInt((checkedInCategory * 100)/countByCategories[categoryId.replace(/razdel-/,'')]);
                        $("div[data-count-razdel='"+categoryId+"'] div[role='progressbar']").attr('data-val', categoryPercent);
                        UpdateGrafRazdel();

                        //обновляем данные по всем разделам
                        var checked_razdel = $("input[id^='razdel-']").filter(':checked').length;
                        $('.total-done').text(checked_razdel);
                        $('.total-done-graf').text(checked_razdel);
                        $('.total-white-graf').text(totalItems-checked_razdel);
                        Rchange(parseInt((checked_razdel * 100)/totalItems));
                        if (type!='start'){
                            $.ajax({
                                type: "POST",
                                url: "/admin.reports.checklist.site_id-"+siteId+".html?ajax=UpdateCheckList",
                                data: $("#form_div_send").serialize()
                            });
                        }
                    }
                }

                function UpdateGrafRazdel(){
                    $(".graf-checklist .progressbar").each(function(){
                        if (parseInt($(this).attr('data-val'))==100){
                            $(this).addClass("progress-done");
                            $(this).parent('div').addClass("progress-div-done");
                        }else{
                            $(this).removeClass("progress-done");
                            $(this).parent('div').removeClass("progress-div-done");
                        }
                        $(this).progressbar({
                            value: parseInt($(this).attr('data-val'))
                        });
                    });
                }

                function setValueToKnobBlocks(val) {
                    $(".knob").knob({
                        'draw' : function () {
                            var val = val || this.cv;
                            $(this.i).val(val + "%");
                        }
                    });
                }

                function Rchange(procent){
                    $('.knobi_div').remove();
                    $('.knobi_graf').html('<input class="knob" data-width="102" data-height="102" data-fgColor="#37a1e4" data-bgColor="#e1e1e1" data-thickness=".15" data-readOnly="true" data-stringText="complete" data-padText="-79px" value="'+procent+'">');

                    setValueToKnobBlocks();
                }

                function getRazdel(razsel){
                    if (razsel == 'ro-custom'){
                        openSecondTab();
                    }else{
                        openFirstTab();
                    }
                    $('html, body').animate({scrollTop: $("#"+razsel).offset().top}, 2000);
                }
            </script>

            <div class="container content-margin__top__a">
                <div class="row header-checklist">
                    <div class="span8">
                        <p>Online marketing plan for</p>
                        <h2>Www.Mytruckpoint.Com</h2>
                    </div>
                    <div class="span4">
                        <h2></h2>
                        <p>Total tasks: <span class="total-done">6</span>/<span class="total-white" id="total_items">48</span></p>
                    </div>
                </div>
            </div>

            <div class="container content-margin__top__a" style="margin-top: 15px;">
                <div class="row header2-checklist">
                    <div class="span8">
                        <p style="padding-top: 20px;">If you are a newbie in SEO optimization or you have some experience but you would like to find a step-by-step SEO guide in order to avoid common mistakes that can cause some difficulties in website promotion, here is a stepwise list of SEO things you should take into account while creating and optimizing your websites.</p>
                    </div>
                    <div class="globalHint-58" data-globalwidth="428" data-globalverticalposition="bottom" data-globalhorizontalposition="left" style="display: inline-block;">
                        <div class="span2 knobi_graf_p">
                            <p><i class="total-done-graf-i"></i><span class="total-done-graf">6</span> Complete</p>
                            <p style="padding-top: 10px;"><i class="total-white-graf-i"></i><span class="total-white-graf">42</span> To do</p>
                        </div>
                        <div class="span2 knobi_graf checklist"><div style="display:inline;width:102px;height:102px;" class="knobi_div"><canvas width="102" height="102px"></canvas><span style="position: absolute;margin-top: 60px;margin-left: -79px;" class="text_podpis">complete</span><input class="knob" data-width="102" data-height="102" data-fgcolor="#37a1e4" data-bgcolor="#e1e1e1" data-thickness=".15" data-readonly="true" data-stringtext="complete" data-padtext="-79px" value="12" readonly="readonly" style="width: 60px; position: absolute; vertical-align: middle; margin-top: 24px; margin-left: -80px; border: 0px; background: none; text-align: center; padding: 0px; -webkit-appearance: none;"></div></div>
                    </div>
                </div>
            </div>

            <div class="container content-margin__top__a" style="margin-top: 15px;" id="categories_block">

                <div class="row graf-checklist">
                    <div class="span4" data-count-razdel="razdel-strategy" data-total="7" data-category-id="strategy">
                        <div class="span2"><i class="r1 razdel"></i><a href="javascript:getRazdel('ro-strategy');">Strategy &amp; Pre-Launch Care</a></div>
                        <div class="span1"><span id="ra1">2</span>/7</div>
                        <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r1" data-val="28" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="28"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: block; width: 28%;"></div></div>
                    </div>
                    <div class="span4" data-count-razdel="razdel-keywords_research" data-total="3" data-category-id="keywords_research">
                        <div class="span2"><i class="r2 razdel"></i><a href="javascript:getRazdel('ro-keywords_research');">Keywords Research &amp; Implementation</a></div>
                        <div class="span1"><span id="ra2">0</span>/3</div>
                        <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r2" data-val="0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0%;"></div></div>
                    </div>
                    <div class="span4" data-count-razdel="razdel-on_page_opt" data-total="25" data-category-id="on_page_opt">
                        <div class="span2"><i class="r3 razdel"></i><a href="javascript:getRazdel('ro-on_page_opt');">On Page Optimization</a></div>
                        <div class="span1"><span id="ra3">4</span>/25</div>
                        <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r3" data-val="16" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="16"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: block; width: 16%;"></div></div>
                    </div>
                </div>
                <div class="row graf-checklist margin-checklist">
                    <div class="span4" data-count-razdel="razdel-off_page_optimization" data-total="9" data-category-id="off_page_optimization">
                        <div class="span2"><i class="r6 razdel"></i><a href="javascript:getRazdel('ro-off_page_optimization');">Off Page Optimization</a></div>
                        <div class="span1"><span id="ra6">0</span>/9</div>
                        <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r6" data-val="0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0%;"></div></div>
                    </div>
                    <div class="span4" data-count-razdel="razdel-social_media_management" data-total="4" data-category-id="social_media_management">
                        <div class="span2"><i class="r4 razdel"></i><a href="javascript:getRazdel('ro-social_media_management');">Social Media Management</a></div>
                        <div class="span1"><span id="ra4">0</span>/4</div>
                        <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r4" data-val="0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0%;"></div></div>
                    </div>
                    <div class="span4" data-count-razdel="razdel-custom" data-total="0" data-category-id="custom">
                        <div class="span2"><i class="r7 razdel"></i><a href="javascript:getRazdel('ro-custom');">Your own tasks</a></div>
                        <div class="span1"><span id="ra7">0</span>/0</div>
                        <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r7" data-val="0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0%;"></div></div>
                    </div>
                </div>
            </div>

            <div class="container content-margin__top__a" id="topChecklistCustomCategory">
                <div class="row">
                    <div class="span8">
                    </div>
                    <div class="span4">
                        <a href="#" onclick="showCustomItemAddForm();return false;" class="btn btn-large btn-blue globalHint-59" data-globalwidth="428" data-globalverticalposition="bottom" data-globalhorizontalposition="left">Add your own task</a>
                    </div>
                </div>
            </div>            <div class="container content-margin__top__a" style="margin-top: 10px;">
                <form id="form_div_send">

                    <div class="checkListTab1">
                        <div class="row head-seo" id="ro-strategy">
                            <div class="span8">
                                <h2>Strategy &amp; Pre-Launch Care</h2>
                            </div>
                            <div class="span4" id="razdel-strategy">
                                <p><span>2</span>/7</p>
                            </div>
                        </div>
                        <div class="row seo-line"></div>

                        <!-- Items -->
                        <div style="position:relative;">

                            <!--home-->
                            <div class="row seo-childs  hide-div-text" data-checked="1" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-strategy-install_ga" type="checkbox" value="1" name="razdel-strategy-install_ga" date-razdel="razdel-strategy" checked="checked">
                                    <label for="razdel-strategy-install_ga" class="seo-checkbox"></label>
                                    <span class="seo-select-spa">Install Google Analytics (GA) and Set Up Goals</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">GA is the most popular traffic counter and analysis tool and will help you to monitor sources of traffic and other important activities. Especially helpful if you are planning to run Google AdWords campaign.
                                     It is important to set up basic goals such as revenue, acquisition, inquiry, engagement and many other goals that you need to monitor your website.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        You can set up one web counter, but it is better to install several ones in order to prove given results. You can check here how to install <a href="http://www.google.com/analytics/">Google Analytics</a>.
                                        You can use alternative web counters such as <a href="https://advertising.yahoo.com/">Yahoo Web Analytics</a>, <a href="https://sitecatalyst.omniture.com/login/">SiteCatalyst</a>, <a href="http://piwik.org/">Piwik</a>
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/analytics/answer/1032415?hl=en">How to Set up and Edit Goals in Google Analytics</a>, <a href="https://support.google.com/analytics/answer/1012040?hl=en">About Goals in Google Analytics</a>, <a href="https://www.google.com/intl/en/analytics/features/">Google Analytics Features</a>.</p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs  hide-div-text" data-checked="1" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-strategy-add_to_gwt" type="checkbox" value="1" name="razdel-strategy-add_to_gwt" date-razdel="razdel-strategy" checked="checked">
                                    <label for="razdel-strategy-add_to_gwt" class="seo-checkbox"></label>
                                    <span class="seo-select-spa">Add a Website into Google Search Consol</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Adding and Verifying Ownership for a website in Google Search Consol will only take a few minutes, but you will be able to check how search engines index your website,
                                        what kind of errors they can detect, what duplicate pages you have, broken links, backlinks and etc.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        By the way, Bing Webmaster Tools have a bunch of useful functions that can assist you to define and remove these errors.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.bing.com/toolbox/webmaster/">Bing Webmaster Tools</a>, <a href="https://support.google.com/webmasters/answer/35769?hl=en">Google Webmaster Guidelines</a>,
                                        <a href="https://support.google.com/webmasters/?hl=en#topic=3309469">Webmaster Tools Help Center</a>, <a href="https://support.google.com/webmasters/answer/34592?hl=en">How to Add a website to Webmaster Tools</a>,
                                        <a href="https://support.google.com/webmasters/answer/70897?hl=en">How Google Search Works</a>.</p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-strategy-link_ga_gwt" type="checkbox" value="1" name="razdel-strategy-link_ga_gwt" date-razdel="razdel-strategy">
                                    <label for="razdel-strategy-link_ga_gwt" class="seo-checkbox"></label>
                                    <span>Link Google Analytics and Google Search Consol</span>
                                </div>
                                <div class="span4">
                                </div>
                                <div class="span12 seo-hide-block">
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        In GA go to: Acquisitions &gt; Search Engine Optimization &gt; Queries and follow the tips. Linking the two services will help you to get more accurate statistics of all organic traffic on your website including the Search Queries.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/1120006?hl=en">Access Google Search Consol Data in Google Analytics</a>, <a href="https://support.google.com/analytics/answer/1142414?hl=en">Set Up</a>.</p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-strategy-add_to_maps" type="checkbox" value="1" name="razdel-strategy-add_to_maps" date-razdel="razdel-strategy">
                                    <label for="razdel-strategy-add_to_maps" class="seo-checkbox"></label>
                                    <span>Add your website or your company into Google maps if you have target audience for a specific region.</span>
                                </div>
                                <div class="span4">
                                </div>
                                <div class="span12 seo-hide-block">
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        If you have a local business you can add it in <a href="https://www.google.com/business/">Google Places for Business</a> that will help users of a specific region to find useful information.
                                        It is better to add your website into one category, but not at once into several ones.
                                        It is a great way to offer coupons that can be displayed to those users that find your local business in <a href="http://www.google.com/maps">Google</a> maps.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/92319?hl=en">Local businesses</a>, <a href="http://blogoscoped.com/archive/2008-06-24-n88.html">How to add your business to Google maps</a>.</p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-strategy-prolong_domain" type="checkbox" value="1" name="razdel-strategy-prolong_domain" date-razdel="razdel-strategy">
                                    <label for="razdel-strategy-prolong_domain" class="seo-checkbox"></label>
                                    <span>Register Your Domain for Several Years in Advance</span>
                                </div>
                                <div class="span4">
                                </div>
                                <div class="span12 seo-hide-block">
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Valuable (legitimate) domains are often paid for several years in advance, while doorway (illegitimate) domains rarely are used for more than a year.
                                        Therefore, the date when a domain expires in the future can be used as a factor in predicting the legitimacy of a domain
                                    </p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-strategy-create_robots_txt" type="checkbox" value="1" name="razdel-strategy-create_robots_txt" date-razdel="razdel-strategy">
                                    <label for="razdel-strategy-create_robots_txt" class="seo-checkbox"></label>
                                    <span>Create a robots.txt file and save the file into the root of the domain</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">This file is designed to restrict access to your website for search engine and other robots that crawl over the web. It also assists to detect the XML sitemap location. “Bad” robots may disregard the file though.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        If you want to access the whole website for index you can use this rule: User-agent*. If you want search engines not to index specific files you can use the rule: Disallow: (and the URL you want to block).
                                        To test a site's robots.txt file in Google Search Consol you can click Crawl, than Blocked URLs and click the tab Test robots.txt.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.robotstxt.org/robotstxt.html">About Robots.txt</a>, <a href="https://support.google.com/webmasters/answer/156449?hl=en">Block or remove pages using a robots.txt file</a>.</p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-strategy-create_xml_sitemap" type="checkbox" value="1" name="razdel-strategy-create_xml_sitemap" date-razdel="razdel-strategy">
                                    <label for="razdel-strategy-create_xml_sitemap" class="seo-checkbox"></label>
                                    <span>Create XML sitemap and save it in the root of the domain</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">When you create a sitemap you can submit it to Google Webmaster Tools and Bing Webmaster Tools that help search engines easily index your web pages and also find out how often you update a website.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        It is better to create a sitemap as Google can't always find all pages on your website and define its importance that's why XML Sitemap can fix it.
                                        If you have more than 10 000 pages you should arrange all content into several sitemaps.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/156184?hl=en">What are sitemaps?</a>, <a href="http://seranking.com/blog/tutorial/the-importance-of-xml-sitemap-do-you-need-to-generate-and-submit-it/">The Importance of XML Sitemap: Do you need to generate and submit it?</a>, <a href="http://www.xml-sitemaps.com/">XML Sitemap Generator</a>, <a href="https://support.google.com/sites/answer/100283?hl=en">Submit a Sitemap to Google Webmaster Tools</a>.</p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->



                        </div>

                    </div>
                    <div class="checkListTab1">
                        <div class="row head-seo" id="ro-keywords_research">
                            <div class="span8">
                                <h2>Keywords Research &amp; Implementation</h2>
                            </div>
                            <div class="span4" id="razdel-keywords_research">
                                <p><span>0</span>/3</p>
                            </div>
                        </div>
                        <div class="row seo-line"></div>

                        <!-- Items -->
                        <div style="position:relative;">

                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-keywords_research-select_strategy" type="checkbox" value="1" name="razdel-keywords_research-select_strategy" date-razdel="razdel-keywords_research">
                                    <label for="razdel-keywords_research-select_strategy" class="seo-checkbox"></label>
                                    <span>Select the Right Keyword Strategy</span>
                                </div>
                                <div class="span4">
                                </div>
                                <div class="span12 seo-hide-block">
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        The dilemma is simple enough: Setting long-terms aims and targeting
                                        highly competitive keywords or <a href="http://seranking.com/blog/tutorial/on-page-seo/can-long-tail-keywords-double-your-traffic/">going
                                            after the long tails keywords</a> you can get decent ranking for in
                                        the near future. In any case search and competition volumes are very
                                        important factor while making your semantic core.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.quora.com/Should-I-only-target-low-competition-key-words">Should I only target high competitive keywords</a>.</p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-keywords_research-analyze_competitors" type="checkbox" value="1" name="razdel-keywords_research-analyze_competitors" date-razdel="razdel-keywords_research">
                                    <label for="razdel-keywords_research-analyze_competitors" class="seo-checkbox"></label>
                                    <span>Analyze keywords of your competitors</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Analyze those keywords that use your competitors. Compare your keywords with the keywords of your competitors.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Add some keywords into your list. You can analyze your competitors with
                                        different tools in order to find out the best keywords and search
                                        queries for PPC usage. Check out these tools <a href="http://www.cy-pr.com/">CY-PR</a>, <a href="http://www.semrush.com/?db=us">Semrush</a>, <a href="https://adwords.google.com/KeywordPlanner">Google Keyword Tool</a>.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://searchengineland.com/what-you-need-to-know-for-advanced-competitive-keyword-analysis-131552">Competitive Keyword Analysis</a>, <a href="https://support.google.com/adwords/answer/3022575?hl=en">Keyword Planner</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-keywords_research-makeup_final_list" type="checkbox" value="1" name="razdel-keywords_research-makeup_final_list" date-razdel="razdel-keywords_research">
                                    <label for="razdel-keywords_research-makeup_final_list" class="seo-checkbox"></label>
                                    <span>Make up The Final List of the Targeted Keywords</span>
                                </div>
                                <div class="span4">
                                </div>
                                <div class="span12 seo-hide-block">
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        As soon as you choose keywords, cramp your list of keywords in your
                                        field and mark how much traffic each keyword can bring to your
                                        website. You need to divide your keywords into groups according to
                                        the pages they will be used for. Yes, every page of your website
                                        needs to have a unique set of its own keywords not overlapping (and
                                        of course not duplicate) with the keywords of other pages.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/adwords/answer/3525312?hl=en">What your customers are looking for?</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->



                        </div>

                    </div>
                    <div class="checkListTab1">
                        <div class="row head-seo" id="ro-on_page_opt">
                            <div class="span8">
                                <h2>On Page Optimization</h2>
                            </div>
                            <div class="span4" id="razdel-on_page_opt">
                                <p><span>4</span>/25</p>
                            </div>
                        </div>
                        <div class="row seo-line"></div>

                        <!-- Items -->
                        <div style="position:relative;">

                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-architecture" type="checkbox" value="1" name="razdel-on_page_opt-architecture" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-architecture" class="seo-checkbox"></label>
                                    <span>Logic Site Architecture / Structure</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p"><ol>
                                    <li>Plan out a hierarchy before you develop your website</li>
                                    <li>2. Create a URL structure that follows your navigation hierarchy</li>
                                    <li>Use a shallow depth navigation structure</li>
                                </ol></div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        A “hierarchy” is nothing more than
                                        a way to organize your information — something that is simple
                                        and makes sense. Your hierarchy will also become your navigation and
                                        your URL structure, so everything important begins here.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.wordstream.com/information-architecture">Information Architecture for SEO</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-unique_titles" type="checkbox" value="1" name="razdel-on_page_opt-unique_titles" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-unique_titles" class="seo-checkbox"></label>
                                    <span>Write unique titles for each page of your website</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">The meta tag title is the key in search engine ranking that's why you need to pay lots of attention to it.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Some tips for writing website titles:
                                    </p><ul><li>Try to write unique titles for each web page.</li>
                                        <li>Include one keyword into your title and keep 70 characters for each title as search engines show the first 70 characters.</li>
                                        <li>Don't use more than 2 or more keywords.</li>
                                        <li>Try to make up a short and informative title.</li>
                                        <li>Try to avoid such keywords as free, cheap as it will look like spam.</li>
                                        <li>Avoid duplicate titles.</li>
                                        <li>You can use a brand name in your titles but it is no need to use it on each page of a website as it will decay the user perception.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/35624?hl=en">Page titles</a>, <a href="http://searchenginewatch.com/article/2154469/How-to-Write-Title-Tags-For-Search-Engine-Optimization">Title Tags for Search Engine Optimization</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs  hide-div-text" data-checked="1" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-unique_meta_descriptions" type="checkbox" value="1" name="razdel-on_page_opt-unique_meta_descriptions" date-razdel="razdel-on_page_opt" checked="checked">
                                    <label for="razdel-on_page_opt-unique_meta_descriptions" class="seo-checkbox"></label>
                                    <span class="seo-select-spa">Make up unique meta descriptions for each page</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Meta description plays an important role in snippets creation.
                                    This description will be displayed into search engine results so you should draw much attention to it and write only that your users really need to know about each page of a website.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Some tips how to create a right meta description:
                                    </p><ul><li>Write unique meta description about 160 characters as Google shows the first 160 characters of a meta description.</li>
                                        <li>Include one keyword into a meta description. Avoid keyword stuffing.</li>
                                        <li>All meta descriptions must be informative and shows the main idea of a page.</li>
                                        <li>Meta descriptions must be written for people, primarily, but not for search engines.</li>
                                        <li>Use a brand name in your description, but not in each one. Avoid the usage of such words as free, cheap.</li></ul>
                                    In <strong>Google Search Consol&gt;Search Appearance&gt;HTML Improvements&gt;Duplicate Meta Descriptions</strong> you can check all meta descriptions and duplicate content.
                                    <p></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-seo_friendly" type="checkbox" value="1" name="razdel-on_page_opt-seo_friendly" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-seo_friendly" class="seo-checkbox"></label>
                                    <span>Build up SEO Friendly URLs</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Making SEO Friendly URLs will improve your on page optimization and will increase your authority among search engines. And it is quite comfortable for users to view your URLs.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        How to create SEO Friendly URLs:
                                    </p><ul><li>Use a target keyword in your URL as search engines rank better such files;</li>
                                        <li>Do the utmost to make your URL short without senseless signs such as &amp;4%34@!$$%%;</li>
                                        <li>Use hyphens for your URLs. Don't use underscore;</li>
                                        <li>Use a minimum amount of folders into your URL. For examples, use seranking.com/folder1/keyword-research instead of seranking.com/folder1/subfolder1/keyword-research</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.searchenginejournal.com/five-steps-to-seo-friendly-site-url-structure/59813/">SEO Friendly Site URL Structure</a>, <a href="http://searchengineland.com/seo-friendly-url-syntax-practices-134218">Understanding SEO Friendly URL</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs  hide-div-text" data-checked="1" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-canonical_urls" type="checkbox" value="1" name="razdel-on_page_opt-canonical_urls" date-razdel="razdel-on_page_opt" checked="checked">
                                    <label for="razdel-on_page_opt-canonical_urls" class="seo-checkbox"></label>
                                    <span class="seo-select-spa">Use Canonical URL's, avoid duplicate pages from index</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Lots of websites have such web pages that have the same information on some URLs what is considered as duplicate content by search engines as they don't know what pages to index.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        To make your URL's more effective it is recommended to use Canonical URL's as a preferred version for your page. Just indicate your preferred URL as a Canonical attribute (rel="canonical") for your content.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/139066?rd=1">Canonical URLs</a>, <a href="http://www.mattcutts.com/blog/seo-advice-url-canonicalization/">URL canonicalizaion</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-heading_tags" type="checkbox" value="1" name="razdel-on_page_opt-heading_tags" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-heading_tags" class="seo-checkbox"></label>
                                    <span>Optimize H titles (heading tags)</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">It is recommended to use one heading tag per one page that's why it is better to use your keyword into this heading tag.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Some tips how to optimize a heading tag:
                                    </p><ul><li>If you have lots of titles, use heading tags h2-h6.</li>
                                        <li>The best combination will be the usage of h1-h3. You don't need to use extra titles.</li>
                                        <li>Don't use H tags with other tags such as strong or em.</li>
                                        <li>Don't use a heading tag into your images as it will be considered as spam.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.hobo-web.co.uk/headers/">H1-H6 HTML Elements</a>, <a href="http://seranking.com/blog/tutorial/how-to-do-on-site-seo-optimization-complete-tutorial-for-beginners-part-i/">On Site Optimization</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-alt_tags" type="checkbox" value="1" name="razdel-on_page_opt-alt_tags" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-alt_tags" class="seo-checkbox"></label>
                                    <span>Use Alt tags for your images</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">If you have images on your website, it is better to use <a href="http://www.w3schools.com/tags/att_img_alt.asp">Alt tag</a> to describe a text that can helps search engines and users get what the image and the page is about. Typically, search engines don't read images, but analyze the description of images.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Some tips how to optimize your Alt tags:
                                    </p><ul><li>Alt tags can improve your usability and availability. With the search by image you can get traffic on your website.</li>
                                        <li>You should consider Alt images are more important for search engines than title images.</li>
                                        <li>Try to describe your images with no more than 5 words.</li>
                                        <li>Use one keyword in Alt images, avoid keyword stuffing.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/114016?hl=en">Image publishing guidelines</a>, <a href="http://googlewebmastercentral.blogspot.in/2012/04/1000-words-about-images.html">About Images</a>, <a href="http://seranking.com/blog/tutorial/complete-tutorial-for-seo-beginners-part-ii-keyword-consistence-internal-linking-alt-tag/">Alt Tags</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs  hide-div-text" data-checked="1" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-broken_links" type="checkbox" value="1" name="razdel-on_page_opt-broken_links" date-razdel="razdel-on_page_opt" checked="checked">
                                    <label for="razdel-on_page_opt-broken_links" class="seo-checkbox"></label>
                                    <span class="seo-select-spa">Monitor and Delete / Nofollow Broken Links</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Broken links decay behavior factors on a website. For search engines a broken link means an error. If you have a great number of such errors search engine robots will mark as a low quality website.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        The reasons of broken links:
                                    </p><ul><li> 404 error when entering an address domain;</li>
                                        <li> A download link you offer is not working;</li>
                                        <li> An article you refer was removed by admin;</li>
                                        <li> A website or a blog is closed or is not working anymore.</li></ul><br>
                                    To detect such broken links you can use such plugins as <a href="http://brokenlinkcheck.com/">Broken Link Check</a>, <a href="http://www.2bone.com/links/linkchecker.shtml">2bone Online Link Checker</a>, <a href="http://www.iwebtool.com/broken_link_checker">iWebTool Broken Link Checker</a> or use <a href="https://www.google.com/webmasters/tools/home?hl=en#utm_source=en-et-gwcblog&amp;utm_medium=link&amp;utm_campaign=sitemaps-us-gwcblog">Google Search Consol</a>: Crawl &gt; Crawl Errors
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://googlewebmastercentral.blogspot.in/2012/03/crawl-errors-next-generation.html">Crawl Errors</a>, <a href="http://searchengineland.com/how-to-capture-broken-inbound-links-94552">Capture Broken Inbound Links</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-website_load_speed" type="checkbox" value="1" name="razdel-on_page_opt-website_load_speed" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-website_load_speed" class="seo-checkbox"></label>
                                    <span>Monitor / Improve Your Website Load Speed</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Website speed affects not only behavior factors but your SEO optimization. Nowadays search engines take into account website speed. The page speed must be no less than 5 seconds. You will find lots of tools that can help you to define your page speed, for example, <a href="http://tools.pingdom.com/fpt/">Pingdom</a>, <a href="http://www.webpagetest.org/">WebPageTest</a>, <a href="https://developers.google.com/speed/pagespeed/">PageSpeed Tools</a>.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/analytics/answer/2811279?hl=en">Speed Suggestions</a>, <a href="http://www.mattcutts.com/blog/site-speed/">Site Speed in Search Rankings</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-outbound_links" type="checkbox" value="1" name="razdel-on_page_opt-outbound_links" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-outbound_links" class="seo-checkbox"></label>
                                    <span>Do Not Use Over 100 Outbound Links per Page</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">If you have a great number of links it can irritate your users and can be considered as spam activity. It is better to check if your website has broken links, use the rel=nofollow attribute that search engines can't index these backlinks.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Once Google spots a page with over 100 external links per one page it may flag not only the page but your entire website.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.mattcutts.com/blog/how-many-links-per-page/">How many links per page?</a>, <a href="http://www.linkvendor.com/seo-tools/outbound-links.html">Link Analysis Tool</a>, <a href="http://googlewebmastercentral.blogspot.ru/2008/10/linking-out-often-its-just-applying.html">The common sense while you link out</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-inner_crosslinking" type="checkbox" value="1" name="razdel-on_page_opt-inner_crosslinking" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-inner_crosslinking" class="seo-checkbox"></label>
                                    <span>Wise and SEO-Friendly Inner Cross Linking</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Interlinking plays a significant role to enhance your authority and webpage weight in search engines. You can analyze your internal linking for your website into Google Search Consol: Search Traffic &gt; Internal Links.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        How to make a right website interlinking:
                                    </p><ul><li>Create a sitemap in html format that helps search engines to index your website and users to find a right article or information.</li>
                                        <li>Insert backlinks into articles of your website at the bottom of the web page. You can insert 3-10 backlinks.</li>
                                        <li>Make internal linking in your article referring on other articles of your website. Try to include no more than 5-10 backlinks in each article.</li>
                                        <li>Insert backlinks into your images. It works well but it should do it in a right way.</li>
                                        <li>Make a sitebar on each page of the website with the recent articles. Don't forget to block this section from indexing in order to avoid duplicate content.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://searchenginewatch.com/article/2169471/9-Pro-Tips-for-Developing-a-Killer-Internal-Link-Structure">Killer Internal Linking Structure</a>, <a href="http://googlewebmastercentral.blogspot.ru/2008/10/importance-of-link-architecture.html">Link architecture</a>, <a href="https://support.google.com/webmasters/answer/138752?hl=en">Internal links</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs  hide-div-text" data-checked="1" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-301_redirect" type="checkbox" value="1" name="razdel-on_page_opt-301_redirect" date-razdel="razdel-on_page_opt" checked="checked">
                                    <label for="razdel-on_page_opt-301_redirect" class="seo-checkbox"></label>
                                    <span class="seo-select-spa">Use 301 Redirect</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">It is important to define whether you will use your website with www or without it as Search Engines may treat these two as different websites. <br>Same with http://www.domain.com and http://www.domain.com/index.php or http://www.domain.com/index.html. It is recommended to use 301 redirect or Rel=Canonical tag. </div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        301 redirect is a status code that says that a page permanently moved to another location. You may directly create these in htaccess file with the <a href="http://www.webconfs.com/how-to-redirect-a-webpage.php">following instructions</a>.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/93633?hl=en">301 redirects</a>, <a href="http://seranking.com/blog/tutorial/301-and-302-redirect-how-you-can-use-it-and-how-it-influences-on-seo/">How to use 301 redirect</a>, <a href="http://googlewebmastercentral.blogspot.com/2013/04/5-common-mistakes-with-relcanonical.html">5 Common Mistakes with Rel=Canonical</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-markup_validity" type="checkbox" value="1" name="razdel-on_page_opt-markup_validity" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-markup_validity" class="seo-checkbox"></label>
                                    <span>Check the markup validity of web documents in HTML</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Validity means the conformity of the entire website with open standards so you need to check html code errors of your website.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        You can check the defined syntax of HTML and detect some discrepancies. It will help you to display your website in different browsers in a right way, cut down your speed page and affect your rankings in search engines results. You can check the markup validity of your website with online tool <a href="http://validator.w3.org/">validator.w3.org</a>.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://googlewebmastercentral.blogspot.ru/2011/07/validation-measuring-and-tracking-code.html">Validation</a>, <a href="https://support.google.com/webmasters/answer/35658?hl=en">Verification: HTML file</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-breadcrumbs" type="checkbox" value="1" name="razdel-on_page_opt-breadcrumbs" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-breadcrumbs" class="seo-checkbox"></label>
                                    <span>Use Breadcrumbs</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">It is recommended to use breadcrumbs on your website as it improves your usability and simplifies your website navigation for search engines and users. Search engines love breadcrumbs that help users to get additional information. If you add them into snippets it will give you lots of benefits.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/185417?hl=en">Breadcrumbs-Rich Snippets</a>, <a href="http://www.webpronews.com/how-do-you-get-breadcrumbs-in-google-results-2010-01">Breadcrumbs in Google</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-niche_content" type="checkbox" value="1" name="razdel-on_page_opt-niche_content" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-niche_content" class="seo-checkbox"></label>
                                    <span>Analyze the content in your niche</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">It is not secret that content is the most important factor that affects your website positions and engages more visitors. That's why it is really vital to write only useful and fresh content.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                    </p><ul><li>Analyze news and events in your field;</li>
                                        <li>Make a deep research about your product, service;</li>
                                        <li>Make some interviews and audience research;</li>
                                        <li>To increase the relevancy of your website there are several ways how to create a content that can attract more clients on your website:</li></ul>
                                    <ol>
                                        <li>Make an interview with famous experts in your field;</li>
                                        <li>Create a list of tips, ratings and etc. For example, "5 Ways…", "10 Best…", "Top 6…";</li>
                                        <li>Make some polls and votes;</li>
                                        <li>Create some educational sections, i.e. different dictionaries, reports, guidelines, tips, checklists and etc;</li>
                                        <li>Regularly update your articles, read over again old articles and add something new into them. Analyze what topics you should create in order to refer to your written articles. Search engines, in particular Google, love fresh and new ideas;</li>
                                        <li>Write reviews about popular products, services, books and something that people need most of all from search engines;</li>
                                        <li>Compare popular products, services and etc;</li>
                                        <li>Be the first who can inform fresh and new events in your field;</li>
                                        <li>Use some phrases and quotes of famous people in your niche;</li>
                                        <li>Make some predictions and outcomes;</li>
                                        <li>Share your stories based on real events;</li>
                                        <li>Use humor in your articles as even some stupid and funny things can be viral over the net that can attract more traffic;</li>
                                        <li>Organize some interesting and useful contests;</li>
                                        <li>If you have an on-line shop, try to post your price list as people need to know prices and compare where to buy, what to buy and how much to buy.</li>
                                    </ol>

                                    Content writing guidelines:

                                    <ul><li>Your article must have at least 300 words of unique content, but it is better to write more than 300 words. Just keep the golden mean not too short and not too long;</li>
                                        <li>Use your target keyword and long-tail keywords that can be greatly included in your article and look natural and useful for your website;</li>
                                        <li>Don't use duplicate and rewritten content. All articles, titles, meta descriptions and heading tags should be unique. Check your articles for plagiarism with <a href="http://www.copyscape.com/">Copyscape</a>.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://blogs.constantcontact.com/fresh-insights/ask-an-expert-how-do-you-write-case-studies-to-fit-a-more-social-world/">Write Case Studies</a>, <a href="https://support.google.com/webmasters/answer/66359">Duplicate content</a>, <a href="http://www.copyblogger.com/boring-topic-content-marketing/">How to write interesting content</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-optimize_content" type="checkbox" value="1" name="razdel-on_page_opt-optimize_content" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-optimize_content" class="seo-checkbox"></label>
                                    <span>Optimize your content</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Content optimization is the most important part in your SEO promotion in order to be in the top of search engine results.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        When you write content, try to use the following tips:
                                    </p><ul><li>Write only unique content. Avoid duplicate content. All your pages must have unique content.</li>
                                        <li>Check website content for plagiarism. You can use the tool <a href="http://www.copyscape.com/">Copyscape</a>.</li>
                                        <li>Avoid grammar and spelling mistakes, although sometimes you can get some mistakes for search engine results. But it is better not to abuse of it as your content can be considered as of low quality.</li>
                                        <li>Keep keyword density with max 3-5% in each article. Avoid keyword stuffing as you can get Google penalties for that stuff.</li>
                                        <li>Use interlinking with your target anchor links. Make sure that too optimized content can create a negative impact on your website.</li>
                                        <li>Don't' use ad bots that close the main content as it really irritates and distract users' attention. This method of promotion can decay your usability and your website rankings.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/66358?hl=en">Irrelevant keywords</a>, <a href="http://seranking.com/blog/tutorial/complete-tutorial-for-seo-beginners-part-iii-conclusion/">Content of the website</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-update_content" type="checkbox" value="1" name="razdel-on_page_opt-update_content" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-update_content" class="seo-checkbox"></label>
                                    <span>Regularly update content on your website</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">A regular update of unique and fresh articles will never harm your website, conversely, it will show a serious intention of website owners to give useful information to readers. You should know that search engines have their own crawling schedule. Some websites are indexed every day, and other websites are indexed once per a month. That's why it is better to keep your own schedule of content update and follow it in future. Try to update your website once per a week. If you add new information or some news, don't forget to update a XML sitemap.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://googleblog.blogspot.in/2011/11/giving-you-fresher-more-recent-search.html">Frequent update</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-website_blog" type="checkbox" value="1" name="razdel-on_page_opt-website_blog" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-website_blog" class="seo-checkbox"></label>
                                    <span>Create a blog on your website</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Blog is a great way to attract more users and improve your website rankings in search engines.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Some tips how to run a blog:
                                    </p><ul><li>Try to make a worthy and useful material, regularly update your blog.</li>
                                        <li>Optimize your articles for a blog and share them via social networks (Google Plus, Facebook, Pinterest, Twitter and etc.).</li>
                                        <li>Create informative, quality and fresh articles with carefully chosen keywords.</li>
                                        <li>If you run an ecommerce website you can write not only about your products, service, industry, but you can write about something that is closed connected with your product that can attract your users.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.socialmediaexaminer.com/7-tips-to-increase-your-blog-comments/">Increase Your Blog Activity</a>, <a href="http://socialmediatoday.com/node/508468">Promote Your Blog</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-create_infographics" type="checkbox" value="1" name="razdel-on_page_opt-create_infographics" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-create_infographics" class="seo-checkbox"></label>
                                    <span>Create infographics, videos, webinars, PDF documents.</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">It is pretty effective to create different infographics, videos, webinars, podcasts, PDF documents, images and etc, but not use just a dry content. It is not only the best way to attract users, but save your time and add a touch of color and design for your website. Share your creations via social signals. There are different free tools that will help you to create infographics, for example, <a href="http://piktochart.com/">Piktochart</a>, <a href="http://www.easel.ly/">Easelly</a>, <a href="http://infogr.am/">Infogr.am</a>.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        The video usage is a great method to promote your website in search engines.<br>
                                        What you need to know:
                                    </p><ul><li>Use keywords in headlines and video descriptions;</li>
                                        <li>Create backlinks on your video with your anchor texts. It is better to use 50% of exact and mixed keywords and 50% of keywords with your brand name, domain name or natural phrases like "click here", "link here" and etc.</li>
                                        <li>Write 10 characters for video descriptions with your keywords.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.smashingmagazine.com/2011/10/14/the-dos-and-donts-of-infographic-design/">Do's and Don'ts of Infographic Design</a>, <a href="http://www.quicksprout.com/2012/06/11/5-ways-to-get-your-infographic-to-go-viral/">Get Your Infographic Viral</a>, <a href="http://searchengineland.com/the-key-to-top-video-rankings-on-youtube-google-35930">Video Rankings</a>, <a href="http://www.quicksprout.com/2012/03/19/how-to-rank-on-the-first-page-of-google-through-videos/">How to Rank Your Video in Google</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-guest_writers" type="checkbox" value="1" name="razdel-on_page_opt-guest_writers" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-guest_writers" class="seo-checkbox"></label>
                                    <span>Invite famous guest writers to write an article for your blog</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">If you don't have any clues or you are not good at copywriting, you can always find a good and reliable guest writer in your field. It is better to pay a round amount but instead you will get a great and quality article. Use a free plagiarism checker <a href="http://www.copyscape.com/">Copyscape</a> to check how unique an article is. Try to read articles several times before you publish it on your blog. Always check articles in details, but not get it and publish it at once on the blog.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        If you want to find a good copywriter it is important to check their recent articles, social accounts and etc. Specify deadlines, make up a list of ideas you want to see in your article referring to trusted and quality resources, and also keep the possibility to edit the article in future.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.problogger.net/archives/2007/02/28/how-to-find-a-guest-blogger-for-your-blog/">How to Find a Good Guest Blogger</a>, <a href="http://www.quicksprout.com/2013/02/18/dont-accept-guest-posts-unless-you-follow-these-7-rules/">Guest Post Rules</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-keyword_stuffing" type="checkbox" value="1" name="razdel-on_page_opt-keyword_stuffing" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-keyword_stuffing" class="seo-checkbox"></label>
                                    <span>Avoid keyword stuffing</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">One of the simpliest ways to kill a decent SEO work is by using the targeted keywords too frequently. It doesn't look natural and creates some inconveniences for users. Create an interesting and useful content where you can effectively use your keywords. Don't use the following ways of <a href="https://support.google.com/webmasters/answer/66353?hl=en">hidden text and links</a>.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.mattcutts.com/blog/avoid-keyword-stuffing/">Keyword Stuffing</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-mobile_website" type="checkbox" value="1" name="razdel-on_page_opt-mobile_website" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-mobile_website" class="seo-checkbox"></label>
                                    <span>Make sure your website works good when viewed on a mobile device</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Nowadays everybody has mobile devices as a great number of them use them everywhere instead of computer. That's why it is important to create mobile websites and make sure that search engine robots indexed your version of a website.<br>
                                    Since April 2015, website's mobile optimization will be taken into account when calculating the Google search rankings.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Search engines robots (including their mobile versions) can't find your website if you block the access to it. That's why you can decide whether to allow access or block search engine robots from the mobile version of a website. If you decide to access the site than use the rule: User-Agent "Google-Mobile" in robots.txt file.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://www.google.com/webmasters/tools/mobile-friendly/">Mobile-Friendly Test</a>, <a href="https://support.google.com/adwords/answer/2549057?hl=en">Create an effective mobile site</a>, <a href="http://www.forbes.com/sites/work-in-progress/2013/09/05/how-to-make-your-website-mobile-friendly-on-a-budget/">Website Mobile Friendly</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-mobile_urls" type="checkbox" value="1" name="razdel-on_page_opt-mobile_urls" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-mobile_urls" class="seo-checkbox"></label>
                                    <span>All URLs should be available for mobile devices</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Make sure that all URLs of your mobile website should be available in a mobile format XHTML Mobile or Compact HTML. If you have done everything right your website page will be available for users and will be indexed.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://searchengineland.com/the-definitive-guide-to-mobile-technical-seo-166066">Mobile URLs</a>, <a href="https://support.google.com/webmasters/answer/72462?hl=en&amp;ref_topic=2370586">Mobile site development</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-mobile_version_page" type="checkbox" value="1" name="razdel-on_page_opt-mobile_version_page" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-mobile_version_page" class="seo-checkbox"></label>
                                    <span>Direct the mobile version of the page for the same product</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">When your users want to find your website with help of computer you should direct them to the proper page of the website as you used in the mobile version of a website. Google fairly gets two versions of the website for mobile devices and for computers. Make sure once again that you redirect users to the suitable page of the mobile site as it affects your website rankings and website usability.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.designyourway.net/blog/resources/detecting-and-redirecting-mobile-users/">Redirecting Mobile Users</a>, <a href="http://static.googleusercontent.com/media/www.google.ru/en/ru/webmasters/docs/search-engine-optimization-starter-guide.pdf">Google Starter Guide</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-on_page_opt-user-friendly" type="checkbox" value="1" name="razdel-on_page_opt-user-friendly" date-razdel="razdel-on_page_opt">
                                    <label for="razdel-on_page_opt-user-friendly" class="seo-checkbox"></label>
                                    <span>Make Sure Website is Not only SEO-Friendly but also User-Friendly</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p"><ul><li>Check whether all fill-out forms work well;</li>
                                    <li>Your content should be well-formed, structural and comfortable for users' perception;</li>
                                    <li>The website should be well displayed in all browsers;</li>
                                    <li>All pages of a website should have a common style of appearance;</li>
                                    <li>Your contacts should be located in footer and should be displayed on each page of the website;</li>
                                    <li>Make your content easy to read with necessary type, color and line interval;</li>
                                    <li>All important sections are placed on the homepage;</li>
                                    <li>Use unique favicon for your website;</li>
                                    <li>Check your website for plagiarism, for grammar, spelling and punctual mistakes;</li>
                                    <li>Anchor text should be understandable and logical;</li>
                                    <li>Your logo in the website header should look like a hyperlink that refers to the homepage of your website.</li></ul></div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->



                        </div>

                    </div>
                    <div class="checkListTab1">
                        <div class="row head-seo" id="ro-off_page_optimization">
                            <div class="span8">
                                <h2>Off Page Optimization</h2>
                            </div>
                            <div class="span4" id="razdel-off_page_optimization">
                                <p><span>0</span>/9</p>
                            </div>
                        </div>
                        <div class="row seo-line"></div>

                        <!-- Items -->
                        <div style="position:relative;">

                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-backlink_quality_analyze" type="checkbox" value="1" name="razdel-off_page_optimization-backlink_quality_analyze" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-backlink_quality_analyze" class="seo-checkbox"></label>
                                    <span>Analyze the quality and quantity of the current backlinks for your website</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">It is important to analyze a number of backlinks you have on your website in order to take some measures to improve and increase a great number of quality backlinks.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Some useful tips about backlinks:
                                    </p><ul><li>Analyze how much your backlinks are natural and unique;</li>
                                        <li>Check all anchors that refer to your website and how much they are effective;</li>
                                        <li>Check all errors that can be in your backlinks, detect all broken links, 404 errors and etc;</li>
                                        <li>Detect what web pages are more visited and what ones are less visited. Think how to improve this page or pages.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.mattcutts.com/blog/how-many-links-per-page/">how many links per page?</a>, <a href="https://support.google.com/blogger/answer/42533?hl=en">How to use backlinks?</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-competitors_backlinks" type="checkbox" value="1" name="razdel-off_page_optimization-competitors_backlinks" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-competitors_backlinks" class="seo-checkbox"></label>
                                    <span>Analyze backlinks of your competitors</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Find top 10 competitors in your field and analyze the following:
                                    <ul><li>The front page and the main landing pages on their PR, domain age, backlinks, page weight;</li>
                                    <li>What trusted websites refer to them;</li>
                                    <li>What anchors your competitors are using and try to get the same backlink for your website. The best way to get it is to offer quality and exclusive content to that website.</li></ul></div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        You can analyze competitors' backlinks with the following tools: <a href="http://www.majesticseo.com/">Majesctic SEO</a>, <a href="https://ahrefs.com/">Ahrefs</a>, <a href="http://www.opensiteexplorer.org/">Opensiteexplorer</a>.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.fervilvon.com/how-to-analyze-competitors/">Competitor Analysis</a>, <a href="http://www.webconfs.com/how-to-analyze-your-competitors-article-39.php">How to analyze SEO competitors</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-backlink_quality_control" type="checkbox" value="1" name="razdel-off_page_optimization-backlink_quality_control" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-backlink_quality_control" class="seo-checkbox"></label>
                                    <span>Constantly Control the Quality of  you Backlinks</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Quality and good backlinks play a significant role in SEO that's why it is important to get lots of quality and natural backlinks than just pay attention to its quantity</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Some tips how to get good backlinks:
                                    </p><ul><li>Check each page and resource, Goolge PR, a number of backlinks for each page, geographical location;</li>
                                        <li>Use your keywords in anchor text that will help search engines to detect the relevancy of your backlinks;</li>
                                        <li>Try to get Dofollow backlinks that are indexed by search engines as they give a significant weight to the web page. Therefore, if you have a blog site and some articles have links that refer to trusted resources you should make the nofollow tag for these links and Google will ignore such kind of bakclinks.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/webmasters/answer/96569?hl=en">rel=nofollow for links</a>, <a href="http://googlewebmastercentral.blogspot.ru/2010/06/quality-links-to-your-site.html">Quality links to your site</a>, <a href="http://www.poweredbysearch.com/7-types-of-anchor-text-you-can-use-to-avoid-a-google-flag/">Anchor Text to Avoid Google Flag</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-similar_websites" type="checkbox" value="1" name="razdel-off_page_optimization-similar_websites" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-similar_websites" class="seo-checkbox"></label>
                                    <span>Interact with other websites that have similar topics</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">There are a large number of topical websites with good traffic and authority that you can cooperate to improve your site rankings. Fresh, informative and useful topics can be a good occasion to get quality backlinks on such websites.<br>
                                    You have heard a lot about guest posting. Although Matt Cutts published a bunch of articles about <a href="http://www.mattcutts.com/blog/guest-blogging/">guest posting</a> it won't disable you to get more traffic and users with this way.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        What you should pay attention:
                                    </p><ul><li>Be creative and bright to write quality article with infographics, videos, images and etc. Google loves such articles that can affect your keyword positions in search engine results.</li>
                                        <li>Use only unique and new material.</li>
                                        <li>Publish your articles on quality and trusted websites with good traffic and authority.</li>
                                        <li>Try to keep balance and post articles 2-5 articles per week. You shouldn't post 10-20 articles per week as Google will see you use guest posting as the basic way to get backlinks.</li>
                                        <li>Firstly, write for people, define your target audience and detect what they really want and their FAQ. The best way to find out that is to read forums and blogs that can give good ideas to write useful articles.</li>
                                        <li>Insert the anchor text where it can be really needful to give additional information.</li>
                                        <li>Use some real stories, use humour that can attract people's attention.</li></ul><br>
                                    What you should avoid:
                                    <ul><li>DON'T use guest posting as the main way of website promotion.</li>
                                        <li>DON'T write too optimized articles.</li>
                                        <li>DON'T post your articles on low quality and non topical websites.</li>
                                        <li>DON'T use duplicate and spin content.</li>
                                        <li>DON'T insert a lot of backlinks in your articles for link building.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.forbes.com/sites/johnhall/2014/01/21/guest-posting-isnt-dead-google-just-raised-the-quality-bar/">Guest Posting</a>, <a href="http://marketingland.com/google-clarifies-guest-blogging-71201">Guest Blogging for SEO</a>, <a href="http://seranking.com/blog/link-building/top-golden-rules-how-to-make-a-perfect-guest-post-on-a-blog/">How to Make a Perfect Guest Post</a>, <a href="http://seranking.com/blog/link-building/guest-posting-is-this-link-building-standard-dead/">Guest Posting is Not Dead</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-topical_questions" type="checkbox" value="1" name="razdel-off_page_optimization-topical_questions" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-topical_questions" class="seo-checkbox"></label>
                                    <span>Discuss topical questions on forums and blogs</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">It is a good way to discuss and give some tips about your topic on forums and blogs, for example, you can recommend some services or products to use. Try to create profile authority on topical forums. Become an expert in your field. If it is possible you can post your link in signatures, in profiles or in the comment itself (in case you mention about your product or something else). But make sure that an administrator of a forum is not against it.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        It is not necessary to register on such forums and insert your links in the first comment. You can be banned and won't get any sense from that link as it will be deleted. If you post a link on forums make sure that this link is dofollow. What is really great is to create your own forum and take an active participation into forum discussions.<br>
                                        What concerns blogs, read only topical and interesting articles for you where you can really leave comments with your link that will help people to get additional information, cast back author's opinion or just give some advice about something.<br>
                                        Leave comments on blogs with good authority and traffic as these kinds of blogs will give significant results. Try to choose dofollow blogs, but you can vary them with nofollow blogs, of course, if a blog site is really worthy. You should notice that most of comments are moderated that's why you should write more extended and good comments, but not just "Thank for your article" or "It is a really informative article" as you can just like or tweet and the author will know you like his article.<br>
                                        Don't spam and post comments on non topical and low quality websites in order to get more backlinks on your website. Make sure if you have a lot of spam links you can get Google penalties.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://googlewebmastercentral.blogspot.ru/2009/11/hard-facts-about-comment-spam.html">Comment Spam</a>, <a href="http://searchengineland.com/googles-matt-cutts-when-commenting-on-blog-posts-try-to-use-your-real-name-177002">Blog Commenting</a>, <a href="http://onlinebusiness.about.com/od/gettingtrafficmarketing/tp/forum-marketing.htm">Forum Marketing</a>, <a href="http://seranking.com/blog/tutorial/complete-tutorial-for-seo-beginners-part-ii-guest-blogging-blog-commenting-forum-posting/">SEO Beginners</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-field_questions" type="checkbox" value="1" name="razdel-off_page_optimization-field_questions" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-field_questions" class="seo-checkbox"></label>
                                    <span>Answers the Questions in Your Field</span>
                                </div>
                                <div class="span4">
                                </div>
                                <div class="span12 seo-hide-block">
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        You should take an active participation to answer questions in <a href="https://answers.yahoo.com/dir/index?sid=2115500141">Yahoo Answers</a>, <a href="http://otvety.google.ru/otvety/">Google Answers</a>, <a href="http://www.answerbag.com/">Answer Bag</a>. Try to post broad and useful answers. If you want to give more additional information you can insert the link in your answer. Avoid spam and don't need to place your links wherever you want. Include the links where they really need in order to completely disclose the entire answer.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.wikinomics.com/blog/index.php/2009/07/27/how-do-yahoo-answers-get-to-the-top-of-google-search/">How do Yahoo!</a>, <a href="http://searchenginewatch.com/article/2060212/Web-Search-History-Before-Google-Answers-and-Yahoo-Answers-There-Was-Answer-Point-From-Ask-Jeeves">Web Search History</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-product_reviews" type="checkbox" value="1" name="razdel-off_page_optimization-product_reviews" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-product_reviews" class="seo-checkbox"></label>
                                    <span>Write reviews about your product, website, service</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">If you want to advertise your website, product, tool, you can write reviews or ask your friends to help you. Try to post your reviews on good and topical websites that can be useful for people.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Write a well-detailed review that people can view all benefits of your product, mention some key features that differ you from your competitors. Make it catching, try to avoid terminology as some people can't know them what will cause some difficulties. If you decide to use some terms, try to explain them into your reviews.<br>
                                        Reviews should be clear, understandable and well-formed. Don't need to write just about these features that other competitors also have. Be creative!
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="https://support.google.com/plus/answer/2519605?hl=en">Tips for Writing Great Reviews</a>, <a href="http://lifehacker.com/5885607/how-to-write-interesting-and-effective-reviews-online-that-people-will-actually-read">Genuinely Useful Reviews</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-promotion_videos" type="checkbox" value="1" name="razdel-off_page_optimization-promotion_videos" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-promotion_videos" class="seo-checkbox"></label>
                                    <span>Website promotion with images and videos</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">You should publish images about your products, services, companies on your website. Make them quite available for users on your website and in social media. You can post your articles in Flickr, Picasa, Picli, Photo Bucket and etc.<br>
                                    Try to create unique and picturesque images and use the same size for each one:
                                    <ul><li>Create useful and informative images;</li>
                                    <li>Detect your target audience and post those images people want;</li>
                                    <li>Be creative while making exclusive pictures;</li>
                                    <li>Induce your target audience to call.</li></ul></div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Like images, you can publish your videos, experts opinions, interviews with famous peoples, product reviews on YouTube, Dailymotion, Metacafe, Google Videos and etc.<br>
                                    </p><ul><li>Create interesting and useful videos, use some humor, don't use lots of texts into videos;</li>
                                        <li>Don't forget to mention about your brand;</li>
                                        <li>Don't make videos too long, make it short and clear (it depends on your topic);</li>
                                        <li>Call your users into action;</li>
                                        <li>Make audience orientated videos and take into account their preferences and needs.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.theguardian.com/technology/2014/feb/26/secret-to-viral-video-marketing">Viral Video Marketing</a>, <a href="http://www.forbes.com/sites/theyec/2013/10/18/ten-biggest-video-marketing-mistakes-to-avoid/">Video Marketing Mistakes</a>, <a href="https://www.distilled.net/training/video-marketing-guide/">Video Marketing Guide</a>, <a href="http://www.socialmediaexaminer.com/visual-social-media-with-donna-moritz/">How Images Can Improve Your Social Media</a>, <a href="http://www.socialmediaexaminer.com/shareable-images/">Shareable Images to Drive Traffic</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-off_page_optimization-press_releases" type="checkbox" value="1" name="razdel-off_page_optimization-press_releases" date-razdel="razdel-off_page_optimization">
                                    <label for="razdel-off_page_optimization-press_releases" class="seo-checkbox"></label>
                                    <span>Use Press Releases</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">The principal of operation is the same one while you write a common article for a website, but press releases have an informative and logical structure. You can write everything about your product, about a new event, about company rewards and etc. They are considered as a sort of ads that cover a range of news and events for your website or company. To write quality and well-optimized press releases and post on trusted resources will help you scoop and get good results in search engines. It is advised not to use anchor links for your website from Press Releases – just use plain hypelinked URL.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        What you should avoid:
                                    </p><ul><li>Don't spam;</li>
                                        <li>Avoid keyword stuffing in your articles;</li>
                                        <li>Don't publish your press releases on low quality websites;</li>
                                        <li>Don't write duplicate and rewritten press releases.</li></ul><br>
                                    What you should pay attention:
                                    <ul><li>Write informative and useful material that will engage users and induce them to get more detailed information about your product, company and etc;</li>
                                        <li>Use 2-3 keywords in a press release;</li>
                                        <li>Write unique press releases;</li>
                                        <li>Leave your contacts and website address that people can find you at any time;</li>
                                        <li>All press releases are written in third person;</li>
                                        <li>Publish your press releases on quality and good websites with high PR and good traffic;</li>
                                        <li>Use multimedia files, for example, images, videos and etc;</li>
                                        <li>Use subtitles, highlight an important information in bold or italic;</li>
                                        <li>At the begging of your press releases you should include your logo that people can define your brand name.</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://searchengineland.com/matt-cutts-more-proof-google-does-count-links-from-press-releases-158350">Google Counts Press Releases</a>, <a href="http://www.forbes.com/sites/cherylsnappconner/2013/08/28/do-press-releases-still-matter-yes-but-not-like-you-think/">Press Releases Still Matters</a>, <a href="http://www.forbes.com/sites/groupthink/2013/09/20/5-ways-to-make-everyone-care-about-your-press-release/">Care About Your Press Release</a>, <a href="http://seranking.com/blog/tutorial/complete-tutorial-for-seo-beginners-part-iii-press-releases-online-directories-social-bookmarking-and-online-answers/">Complete Tutorial: Press Releases</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->



                        </div>

                    </div>
                    <div class="checkListTab1">
                        <div class="row head-seo" id="ro-social_media_management">
                            <div class="span8">
                                <h2>Social Media Management</h2>
                            </div>
                            <div class="span4" id="razdel-social_media_management">
                                <p><span>0</span>/4</p>
                            </div>
                        </div>
                        <div class="row seo-line"></div>

                        <!-- Items -->
                        <div style="position:relative;">

                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-social_media_management-social_signals" type="checkbox" value="1" name="razdel-social_media_management-social_signals" date-razdel="razdel-social_media_management">
                                    <label for="razdel-social_media_management-social_signals" class="seo-checkbox"></label>
                                    <span>Learn the Social Signals Model of Your Industry</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Check social accounts of your competitors to start with and analyze what they share, what kind of articles they post, how many tweets, likes, G+ shares they have, what social networks they use. When you analyze these things you can get what you should pay more attention to your social accounts and what methods you should use for your website. Remember, there are virtually no businesses in the world that would not benefit from an increased Social visibility.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.forbes.com/sites/jaysondemers/2014/06/23/myth-busted-my-industry-isnt-a-good-fit-for-social-media/">Myth Busted: My Industry Isn’t a good Fit for Social Media</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-social_media_management-social_buttons" type="checkbox" value="1" name="razdel-social_media_management-social_buttons" date-razdel="razdel-social_media_management">
                                    <label for="razdel-social_media_management-social_buttons" class="seo-checkbox"></label>
                                    <span>Add Social Media Buttons to Your Website</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">You can do so manually or by using one of the multiple Social Media button plugins available for virtually any CMS: Wordpress, Joomla, Drupal, Magento, Blogger and other. Encourage your visitors to follow you and do not complicate things missing Social buttons. Stop losing a fair part of your potential and social active audience at this point.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>

                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.sharethis.com/get-sharing-tools/">Get the Social Share Button for Your Website</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-social_media_management-sharing_strategy" type="checkbox" value="1" name="razdel-social_media_management-sharing_strategy" date-razdel="razdel-social_media_management">
                                    <label for="razdel-social_media_management-sharing_strategy" class="seo-checkbox"></label>
                                    <span>Be Aware of What is Worth Sharing</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Once you have created accounts in Google Plus, Twitter, Facebook, Pinterest and etc. you gain potential not only to get additional traffic but also an extra positive ranking factor and increased user-friendliness. It is always a good idea to promote your fresh articles via social networks. Try to share only informative and worthy material and don't publish minor updates.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        To attract more people on your social pages you should make the following things:
                                    </p><ul><li>Share only interesting, useful and new content;</li>
                                        <li>Share videos, infographics, charts, tables and other multimedia;</li>
                                        <li>Make some contests, polls, events, webinars that can engage your fans;</li>
                                        <li>Make some interviews with famous people, experts in a specific field;</li>
                                        <li>Analyze audience activity, what they need, FAQ, give them useful tips;</li>
                                        <li>Take an active participation in discussions, ask people's opinion about products or etc;</li>
                                        <li>Try to get real FB likes, Google+ Shares, Tweets, don't use autofollowing services and bots;</li>
                                        <li>Remember to Include your links into social profiles;</li></ul>
                                    <p></p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://www.exacttarget.com/blog/50-ways-to-drive-traffic-to-your-website-with-social-media/">Ways to Drive Traffic to Your Website</a>, <a href="http://www.socialmediaexaminer.com/21-social-media-marketing-tips-from-the-pros/">Social Media Marketing Tips</a>, <a href="http://www.wordstream.com/social-media-marketing">Social Media Marketing</a>, <a href="http://seranking.com/blog/tutorial/off-page-seo/how-to-drive-more-traffic-on-your-website-from-social-media-signals/">Traffic from Social Media Signals</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->





                            <!--home-->
                            <div class="row seo-childs " data-checked="0" data-site_id="">
                                <div class="span8">
                                    <input class="regular-checkbox" id="razdel-social_media_management-social_bookmarkings" type="checkbox" value="1" name="razdel-social_media_management-social_bookmarkings" date-razdel="razdel-social_media_management">
                                    <label for="razdel-social_media_management-social_bookmarkings" class="seo-checkbox"></label>
                                    <span>Use Social Bookmarking to Get Occasional Links</span>
                                </div>
                                <div class="span4">
                                    <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                </div>
                                <div class="span12 seo-hide-block">
                                    <div class="podlink"><div></div></div>
                                    <span>
										<div class="p">Social websites like Digg, Delicious, StumbleUpon, Propeller have been in the industry long before Social Signals became so important. Be careful and use only quality social bookmarking sites. Pay attention to tags writing that can overspread news and articles over the whole social network.</div>
									</span>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p>
                                        Although this method is out-dated many webmaster still use it as the basic way to get a number of no-follow backlinks, a ranking factor of being mentioned. In general search engine systems like social bookmarking websites and they often crawl through them. So if you have some updates and news on your website you can add your news in social bookmarking sites.
                                    </p>
                                </div>
                                <div class="span12 seo-block-p">
                                    <p><span>Additional info:</span><a href="http://seranking.com/blog/tutorial/complete-tutorial-for-seo-beginners-part-iii-press-releases-online-directories-social-bookmarking-and-online-answers/">Complete tutorial: Social Bookmarking</a>, <a href="http://socialmediatoday.com/bigcouchmedia/1439116/why-social-bookmarking-needs-be-important-part-your-online-marketing-strategy">Social Bookmarking Marketing</a>, <a href="http://www.hubspot.com/internet-marketing-tips/social-bookmarking-marketing">Social Bookmarking Secrets</a>, <a href="http://seopressor.com/blog/nofollow-link-pass-seo-juices/">Nofollow Links Pass SEO Juice</a></p>
                                </div>
                                <div class="row seo-line-child"></div>
                            </div>
                            <!--end-->



                        </div>

                    </div>

                    <div class="row checkListTab2" style="display:none;">
                        <div class="span12 hintCustomTask">
                            <div class="blockText">
                                <h2>You haven't any own points</h2>
                                <p>Here you can add your own tasks to the to-do list of your project’s marketing plan</p>
                            </div>
                            <div class="blockArrow">
                                <img src="/skin/site/main/svg/img-arrow.svg">
                            </div>
                        </div>
                    </div>

                    <input id="site_save" type="hidden" name="do[save_checklist]" value="">
                </form>
            </div>
        </div>


        <script>

            var customItemAddTitle = "Add your own task";
            var customItemEditTitle = "Edit own task";

            function showCustomItemAddForm(){
                var dialog = $("#edit_custom_item");
                dialog.find('.popup-title').html(customItemAddTitle);
                dialog.find('input[name=title]').val('');
                dialog.find('textarea[name=text]').val('');
                dialog.find('#custom_item_edit_id').val('0');
                $('#for_all_projects').removeProp('disabled');
                dialog.dialog('open');
            }

            function showCustomItemEditForm(id){
                var dialog = $("#edit_custom_item");
                dialog.find('.popup-title').html(customItemEditTitle);
                var block = $('div.custom_item[data-id="'+id+'"]');

                var currentText = $('p.custom_item[data-id='+id+']').text();
                var currentTitle = $('span.custom_item[data-id='+id+']').text();

                dialog.find('input[name=title]').val(currentTitle);
                dialog.find('textarea[name=text]').val(currentText);

                dialog.find('#custom_item_edit_id').val(id);
                var allProjectsCheckbox = $('#for_all_projects');
                allProjectsCheckbox.prop('disabled', 'disabled');
                if (block.attr('data-site_id')) {
                    allProjectsCheckbox.removeProp('checked');
                } else {
                    allProjectsCheckbox.prop('checked', 'checked');
                }
                dialog.dialog('open');
            }

            function deleteCustomItem(id){
                var popup = $('#delete-dialog');
                popup.dialog('open');
                popup.find('.btn-margin-right').attr('data-customid', id);
            }

            function confirmDeleteCustomItem(){
                var popup = $('#delete-dialog');
                var id = popup.find('.btn-margin-right').attr('data-customid');
                $.ajax({
                    type: "POST",
                    url: "/admin.reports.checklist.site_id-"+siteId+".html?ajax=DeleteCustomItem",
                    data: {id: id}
                }).done(function() {
                    $('div.custom_item[data-id='+id+']').remove();
                    var customItem = $('.checkListTab2').find('.seo-childs').length;
                    var customItemChk = $('.checkListTab2').find('input:checkbox:checked').length;
                    $("#ro-custom .span4 p").html('<p><span>'+customItemChk+'</span>/'+customItem+'</p>');
                    $('div[data-count-razdel=razdel-custom] .span1').html('<div class="span1"><span id="ra7">'+customItemChk+'</span>/'+customItem+'</div>');
                    popup.dialog('close');
                });
            }


            function openSecondTab(){
                $('.checkListTab1').hide();
                $('.checkListTab2').show();
                $('a.switchLink').removeClass('switch_active');
                $("a.switch_second").addClass('switch_active');
            }

            function openFirstTab(){
                $('.checkListTab2').hide();
                $('.checkListTab1').show();
                $('a.switchLink').removeClass('switch_active');
                $("a.switch_first").addClass('switch_active');
            }

            $(function () {
                $("#edit_custom_item").dialog({
                    autoOpen: false,
                    modal: true
                });
                $("#delete-dialog").dialog({
                    autoOpen: false,
                    modal: true
                });

                if (window.location.hash == "#my"){
                    openSecondTab();
                }

                $("a.switch_first").on("click", function() {
                    var url = window.location.href.replace("#my", "");
                    openFirstTab();
                    window.history.pushState(null, null, url);
                });
                $("a.switch_second").on("click", function() {
                    var url = window.location.href.replace("#my", "");
                    openSecondTab();
                    window.history.pushState(null, null, url+'#my');
                });
            });

        </script>











    </div><!--/ mainр -->
    <div id="preGlobalShadow" style="display:none;"></div>

    <div id="globalShadow" style="display:none;">
        <div class="globalShadowMaskBox">
            <div class="globalShadowMask">
                <div class="globalShadowMaskRow">
                    <div class="globalShadowMaskRowCol topLeftMask"></div>
                    <div class="globalShadowMaskRowCol"></div>
                    <div class="globalShadowMaskRowCol"></div>
                </div>
                <div class="globalShadowMaskRow">
                    <div class="globalShadowMaskRowCol"></div>
                    <div class="globalShadowMaskRowCol centerMask"></div>
                    <div class="globalShadowMaskRowCol"></div>
                </div>
                <div class="globalShadowMaskRow">
                    <div class="globalShadowMaskRowCol"></div>
                    <div class="globalShadowMaskRowCol"></div>
                    <div class="globalShadowMaskRowCol"></div>
                </div>
            </div>
        </div>

        <div class="globalShadowBlock">
            <div class="globalShadowBlockPopup">
                <div class="globalShadowBlockArrow">
                    <img src="/skin/site/main/svg/guide/icn-arrow.svg">
                </div>
                <div class="globalShadowBlockContent">
                    <div class="globalShadowBlockContentStep">
                    </div>
                    <div class="globalShadowBlockContentText">
                    </div>
                    <div class="globalShadowBlockContentBtn">
                        <a href="#" onclick="backGlobalHint();return false;" class="backGlobalHint">
                            <img src="/skin/site/main/svg/guide/btn-back.svg">
                            Back
                        </a>
                        <a href="#" onclick="nextGlobalHint();return false;" class="btn btn-middle btn-green nextGlobalHint">Next</a>
                        <a href="#" onclick="skipGlobalHint();return false;" class="btn btn-middle btn-green startGlobalHint" style="display:none;">Start working</a>
                        <a href="#" onclick="skipGlobalHint();return false;" class="skipGlobalHint">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-placeholders" id="open-guide" style="display:none;">
        <div class="popup">
            <div class="popup-content">
                <div class="popup-text bottom-margin">
                    <img src="skin/site/main/svg/icn-support-guide.svg">
                    <h3>Hello!</h3><p>We are glad to see you among the SE Ranking users. Let’s give you brief basic service instructions. Click <img src="/skin/site/main/images/guide/guide_icon.png"> next to your name in the upper corner of the page to re-launch the instruction again.</p>
                    <div class="baseline-buttons">
                        <a href="#" onclick="runGuide();return false;" class="btn btn-large btn-blue btn-margin-right">Start</a>
                        <a href="#" onclick="skipGlobalHint();return false;" class="btn btn-large btn-white">Not now</a>
                    </div>
                    <p><a href="http://seranking.com/contact.html" target="_blank">Contact us</a> if you need help.</p>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<?php get_footer(); ?>
