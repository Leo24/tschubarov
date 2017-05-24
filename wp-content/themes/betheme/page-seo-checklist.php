<?php get_header(); ?>

<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/bootstrap.css';?>" rel="stylesheet">

<!-- Loading Flat UI -->
<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/style.css';?>" rel="stylesheet">
<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/flat-ui.css';?>" rel="stylesheet">
<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/default.css';?>" type="text/css" rel="stylesheet" id="theme-change">


<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery-1.8.3.min.js';?>"></script>


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


        <div class="globalHint-50" data-globalwidth="550" data-globalverticalposition="none" data-globalhorizontalposition="none" style="display:none;"></div>

        <div class="container loocked_parent">
            <script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.knob.js';?>"></script>
            <script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery-ui-1.10.4.min.js';?>"></script>

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
                        totalItems += totalInCat;
                    });

                    $('#total_items').text(totalItems);
                    $(".graf-checklist .progressbar").each(function() {
                        if (parseInt($(this).attr('data-val')) == 100) {
                            $(this).addClass("progress-done");
                            $(this).parent('div').addClass("progress-div-done");
                        }
                        $(this).progressbar({
                            value: parseInt($(this).attr('data-val'))
                        });
                    });

                    $('.regular-checkbox').change(function() {
                        UpdateCol($(this), 'update');
                        if ($(this).is(":checked")) {
                            $(this).next().next().addClass("seo-select-spa");
                            $(this).parent('div').parent('div').addClass("hide-div-text");
                        } else {
                            $(this).next().next().removeClass("seo-select-spa");
                            $(this).parent('div').parent('div').removeClass("hide-div-text");
                        }
                    });

                    $("a.toogle-close").live("click", function() {
                        if ($(this).parent('div').next().is(":visible")) {
                            $(this).parent('div').next().slideUp("fast");
                            $(this).removeClass("open-seo-link");
                        } else {
                            $(this).parent('div').next().slideDown("fast");
                            $(this).addClass("open-seo-link");
                        }
                    });

                    $(".seo-childs .span8 span").live("click", function() {
                        var self = $(this);
                        if ($(this).prev().prev().is(':checked')) {
                            $(this).prev().prev().removeAttr('checked');
                            $(this).removeClass("seo-select-spa");
                            $(this).parent('div').parent('div').removeClass("hide-div-text");
                            getSiteChecklist();
                        } else {
                            $(this).prev().prev().attr('checked', 'checked');
                            $(this).addClass("seo-select-spa");
                            $(this).parent('div').parent('div').addClass("hide-div-text");
                            getSiteChecklist();
                        }
                        UpdateCol($(this).prev().prev(), 'update');
                    });

                    StartSet();
                });

                function getSiteChecklist() {
                    var aSiteChecklist = [];
                    $(".span8 .regular-checkbox").each(function( index ) {
                        var self = $(this);
                        aSiteChecklist.push({
                            'id' : self.attr('id'),
                            'checked' : self.is(':checked')
                        });
                    });
                    aSiteChecklist = JSON.stringify(aSiteChecklist);
                    localStorage.setItem('aSiteChecklist', aSiteChecklist);
                }


                function StartSet() {
                    var aSiteChecklist = localStorage.getItem('aSiteChecklist');
                    aSiteChecklist = JSON.parse(aSiteChecklist);
                    var site;
                    $.each(aSiteChecklist, function(i) {
                        site = aSiteChecklist[i];
                        if(site.checked) {
                            $('#' + site.id).attr('checked', 'checked');
                            $('#' + site.id).next().next().addClass("seo-select-spa");
                            $('#' + site.id).parent('div').parent('div').addClass("hide-div-text");
                            UpdateCol($("#" + site.id), 'start');
                        }
                    });

                }

                function UpdateCol(elem, type) {

                    var categoryId = $(elem).attr("data-razdel");

                    if (typeof categoryId !== "undefined") {
                        var totalItems = 0;
                        $.each(countByCategories, function(k, v) {
                            totalItems += v;
                        });

                        var checkedInCategory = $("input[id^='" + categoryId + "']").filter(':checked').length;
                        //обновляем данные по разделу в разделе
                        $("div[id='" + categoryId + "'] p span").text(checkedInCategory);
                        $("div[data-count-razdel='" + categoryId + "'] div[class='span1'] span").text(checkedInCategory);
                        var categoryPercent = parseInt((checkedInCategory * 100) / countByCategories[categoryId.replace(/razdel-/, '')]);
                        $("div[data-count-razdel='" + categoryId + "'] div[role='progressbar']").attr('data-val', categoryPercent);
                        UpdateGrafRazdel();

                        //обновляем данные по всем разделам
                        var checked_razdel = $("input[id^='razdel-']").filter(':checked').length;
                        $('.total-done').text(checked_razdel);
                        $('.total-done-graf').text(checked_razdel);

                        $('.total-white-graf').text(totalItems - checked_razdel);

                        Rchange(parseInt((checked_razdel * 100) / totalItems));
//                        if (type != 'start') {
//                            $.ajax({
//                                type: "POST",
//                                url: "/admin.reports.checklist.site_id-" + siteId + ".html?ajax=UpdateCheckList",
//                                data: $("#form_div_send").serialize()
//                            });
//                        }
                    }
                }

                function UpdateGrafRazdel() {
                    $(".graf-checklist .progressbar").each(function() {
                        if (parseInt($(this).attr('data-val')) == 100) {
                            $(this).addClass("progress-done");
                            $(this).parent('div').addClass("progress-div-done");
                        } else {
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
                        'draw': function() {
                            var val = val || this.cv;
                            $(this.i).val(val + "%");
                        }
                    });
                }

                function Rchange(procent) {
                    $('.knobi_div').remove();
                    $('.knobi_graf').html('<input class="knob" data-width="102" data-height="102" data-fgColor="#37a1e4" data-bgColor="#e1e1e1" data-thickness=".15" data-readOnly="true" data-stringText="complete" data-padText="-79px" value="' + procent + '">');

                    setValueToKnobBlocks();
                }

                function getRazdel(razsel) {
                    if (razsel == 'ro-custom') {
                        openSecondTab();
                    } else {
                        openFirstTab();
                    }
                    $('html, body').animate({
                        scrollTop: $("#" + razsel).offset().top
                    }, 2000);
                }
            </script>


            <div class="container content-margin__top__a">
                <div class="row header-checklist">
                    <div class="span8">
                        <p>Online marketing plan for</p>
                        <h2>Georgiizvorski.Com</h2>
                    </div>
                    <div class="span4">
                        <h2></h2>
                        <p>Total tasks: <span class="total-done">0</span>/<span class="total-white" id="total_items">48</span></p>
                    </div>
                </div>
            </div>

            <?php $posts_array = get_posts(
                array(
                    'posts_per_page' => -1,
                    'post_type' => 'seo_checklist',
                )
            );
            $categoryPostQuantity = count($posts_array);
            ?>


            <div class="container content-margin__top__a" style="margin-top: 15px;">
                <div class="row header2-checklist">
                    <div class="span8">
                        <p style="padding-top: 20px;">If you are a newbie in SEO optimization or you have some experience but you would like to find a step-by-step SEO guide in order to avoid common mistakes that can cause some difficulties in website promotion, here is a stepwise list of SEO things you should take into account while creating and optimizing your websites.</p>
                    </div>
                    <div class="globalHint-58" data-globalwidth="428" data-globalverticalposition="bottom" data-globalhorizontalposition="left" style="display: inline-block;">
                        <div class="span2 knobi_graf_p">
                            <p><i class="total-done-graf-i"></i><span class="total-done-graf">0</span> Complete</p>
                            <p style="padding-top: 10px;"><i class="total-white-graf-i"></i><span class="total-white-graf"><?php echo $categoryPostQuantity;?></span> To do</p>
                        </div>
                        <div class="span2 knobi_graf checklist">
                            <div style="display:inline;width:102px;height:102px;" class="knobi_div">
                                <canvas width="102" height="102px"></canvas><span style="position: absolute;margin-top: 60px;margin-left: -79px;" class="text_podpis">complete</span>
                                <input class="knob" data-width="102" data-height="102" data-fgcolor="#37a1e4" data-bgcolor="#e1e1e1" data-thickness=".15" data-readonly="true" data-stringtext="complete" data-padtext="-79px" value="0" readonly="readonly" style="width: 60px; position: absolute; vertical-align: middle; margin-top: 24px; margin-left: -80px; border: 0px; background: none; text-align: center; padding: 0px; -webkit-appearance: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container content-margin__top__a" style="margin-top: 15px;" id="categories_block">

                <?php $categories = get_terms('seo-checklist-category',
                    array(
                        'type'=>'seo-checklist-category',
                        'orderby'=>'id'
                    )
                );?>

                <div class="row graf-checklist">

                    <?php
                    $num = 0;
                    foreach($categories as $k => $category):

                        $posts_array = get_posts(
                            array(
                                'posts_per_page' => -1,
                                'post_type' => 'seo_checklist',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $category->taxonomy,
                                        'field' => 'term_id',
                                        'terms' => $category->term_id,
                                    )
                                )
                            )
                        );
                        $count = count($posts_array);
                        $num = $k+1;

                        ?>
                        <div class="span4" data-count-razdel="<?php echo 'razdel-'.str_replace('-', '_', $category->slug);?>" data-total="<?php echo $count;?>" data-category-id="<?php echo str_replace('-', '_', $category->slug);?>" <?php if($num > 3): echo 'style="padding-top:30px"'; endif;?>>
                            <div class="span2"><i class="r<?php echo $num;?> razdel"></i><a href="javascript:getRazdel(&#39;<?php echo str_replace('-', '_', $category->slug);?>&#39;);"><?php echo $category->name; ?></a></div>
                            <div class="span1"><span id="ra<?php echo $num;?>">0</span>/<?php echo $count;?></div>
                            <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r<?php echo $num;?>" data-val="0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="span4" data-count-razdel="razdel-custom" data-total="0" data-category-id="custom" <?php if($num > 3): echo 'style="padding-top:30px"'; endif;?>>
                        <div class="span2"><i class="r<?php echo $num+1;?> razdel"></i><a href="javascript:getRazdel(&#39;ro-custom&#39;);">Your own task</a></div>
                        <div class="span1"><span id="ra<?php echo $num+1;?>">0</span>/0</div>
                        <div class="span4 progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" id="r<?php echo $num;?>" data-val="0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0;"></div>
                        </div>
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
            </div>
            <div class="container content-margin__top__a" style="margin-top: 10px;">
                <form id="form_div_send">

                    <?php foreach ($categories as $num => $category) : ?>

                        <?php $posts_array = get_posts(
                            array(
                                'posts_per_page' => -1,
                                'post_type' => 'seo_checklist',
                                'order'     => 'asc',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $category->taxonomy,
                                        'field' => 'term_id',
                                        'terms' => $category->term_id,
                                    )
                                )
                            )
                        ); ?>

                        <div class="checkListTab<?php echo $num; ?>">
                            <div class="row head-seo" id="ro-<?php echo $category->slug;?>">
                                <div class="span8">
                                    <h2><?php echo $category->name;?></h2>
                                </div>
                                <div class="span4" id="razdel-<?php echo str_replace('-', '_', $category->slug)?>">
                                    <p><span>0</span>/<?php echo count($posts_array);?></p>
                                </div>
                            </div>
                            <div class="row seo-line"></div>
                            <?php foreach ($posts_array as $post):
                                $postMeta = get_post_meta($post->ID); ?>

                                <div style="position:relative;">
                                    <div class="row seo-childs " data-checked="0" data-site_id="">
                                        <div class="span8">
                                            <input class="regular-checkbox" id="<?php echo 'razdel-'.str_replace('-', '_', $category->slug).'-'.str_replace('-', '_', $post->post_name);?>" type="checkbox" value="1" name="<?php echo 'razdel-'.str_replace('-', '_', $category->slug).'-'.str_replace('-', '_', $post->post_name);?>" data-razdel="<?php echo 'razdel-'.str_replace('-', '_', $category->slug);?>">
                                            <label for="<?php echo 'razdel-'.str_replace('-', '_', $post->post_name)?>" class="seo-checkbox"></label>
                                            <span><?php echo $post->post_title;?></span>
                                        </div>
                                        <?php if(!empty($postMeta['wpcf-what-is-this'][0])):?>
                                            <div class="span4">
                                                <a href="#" onclick="return false;" class="toogle-close">what's this?</a>
                                            </div>
                                        <?php endif;?>

                                        <div class="span12 seo-hide-block">
                                            <div class="podlink">
                                                <div></div>
                                            </div>
                                            <span>
                                                <div class="p"><?php echo $postMeta['wpcf-what-is-this'][0];?></div>
                                            </span>
                                        </div>
                                        <div class="span12 seo-block-p">
                                            <?php echo $post->post_content;?>
                                        </div>
                                        <div class="span12 seo-block-p">
                                            <p><span>Additional info:</span>
                                                <?php echo $postMeta['wpcf-additional-info'][0];?>
                                            </p>
                                        </div>
                                        <div class="row seo-line-child"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="row checkListTab2" style="display:none;">
                        <div class="span12 hintCustomTask">
                            <div class="blockText">
                                <h2>You haven't any own points</h2>
                                <p>Here you can add your own tasks to the to-do list of your project’s marketing plan</p>
                            </div>
                            <div class="blockArrow">
                                <img src="<?php echo get_template_directory_uri().'/seo-checklist/images/img-arrow.svg';?>">
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

            function showCustomItemAddForm() {
                var dialog = $("#edit_custom_item");
                dialog.find('.popup-title').html(customItemAddTitle);
                dialog.find('input[name=title]').val('');
                dialog.find('textarea[name=text]').val('');
                dialog.find('#custom_item_edit_id').val('0');
                $('#for_all_projects').removeProp('disabled');
                dialog.dialog('open');
            }

            function showCustomItemEditForm(id) {
                var dialog = $("#edit_custom_item");
                dialog.find('.popup-title').html(customItemEditTitle);
                var block = $('div.custom_item[data-id="' + id + '"]');

                var currentText = $('p.custom_item[data-id=' + id + ']').text();
                var currentTitle = $('span.custom_item[data-id=' + id + ']').text();

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

            function deleteCustomItem(id) {
                var popup = $('#delete-dialog');
                popup.dialog('open');
                popup.find('.btn-margin-right').attr('data-customid', id);
            }

            function confirmDeleteCustomItem() {
                var popup = $('#delete-dialog');
                var id = popup.find('.btn-margin-right').attr('data-customid');
                $.ajax({
                    type: "POST",
                    url: "/admin.reports.checklist.site_id-" + siteId + ".html?ajax=DeleteCustomItem",
                    data: {
                        id: id
                    }
                }).done(function() {
                    $('div.custom_item[data-id=' + id + ']').remove();
                    var customItem = $('.checkListTab2').find('.seo-childs').length;
                    var customItemChk = $('.checkListTab2').find('input:checkbox:checked').length;
                    $("#ro-custom .span4 p").html('<p><span>' + customItemChk + '</span>/' + customItem + '</p>');
                    $('div[data-count-razdel=razdel-custom] .span1').html('<div class="span1"><span id="ra7">' + customItemChk + '</span>/' + customItem + '</div>');
                    popup.dialog('close');
                });
            }

            function openSecondTab() {
                $('.checkListTab1').hide();
                $('.checkListTab2').show();
                $('a.switchLink').removeClass('switch_active');
                $("a.switch_second").addClass('switch_active');
            }

            function openFirstTab() {
                $('.checkListTab2').hide();
                $('.checkListTab1').show();
                $('a.switchLink').removeClass('switch_active');
                $("a.switch_first").addClass('switch_active');
            }

            $(function() {
                $("#edit_custom_item").dialog({
                    autoOpen: false,
                    modal: true
                });
                $("#delete-dialog").dialog({
                    autoOpen: false,
                    modal: true
                });

                if (window.location.hash == "#my") {
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
                    window.history.pushState(null, null, url + '#my');
                });
            });
        </script>

    </div>
    <!--/ mainр -->
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
                    <img src="<?php echo get_template_directory_uri().'/seo-checklist/images/icn-arrow.svg';?>">
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
                    <img src="<?php echo get_template_directory_uri().'/seo-checklist/images/icn-support-guide.svg';?>">
                    <h3>Hello!</h3>
                    <p>We are glad to see you among the SE Ranking users. Let’s give you brief basic service instructions. Click
                        <img src="<?php echo get_template_directory_uri().'/seo-checklist/images/guide_icon.png';?>">
                        next to your name in the upper corner of the page to re-launch the instruction again.</p>
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
<!--/ wrap -->




<?php get_footer(); ?>
