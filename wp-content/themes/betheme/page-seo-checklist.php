<?php get_header('seo-checklist'); ?>



<div id="wrap">
    <div id="main">



        <div class="globalHint-50" data-globalwidth="550" data-globalverticalposition="none" data-globalhorizontalposition="none" style="display:none;"></div>

        <div class="container loocked_parent">
            <script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.knob.js';?>"></script>
            <script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery-ui-1.10.4.min.js';?>"></script>

            <script>
                var siteId = 208822;
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
                        <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="showCustomItemAddForm();return false;" class="btn btn-large btn-blue globalHint-59" data-globalwidth="428" data-globalverticalposition="bottom" data-globalhorizontalposition="left">Add your own task</a>
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
                        <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="backGlobalHint();return false;" class="backGlobalHint">
                            <img src="<?php echo get_template_directory_uri().'/seo-checklist/images/btn-back.svg';?>"> Back
                        </a>
                        <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="nextGlobalHint();return false;" class="btn btn-middle btn-green nextGlobalHint">Next</a>
                        <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="skipGlobalHint();return false;" class="btn btn-middle btn-green startGlobalHint" style="display:none;">Start working</a>
                        <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="skipGlobalHint();return false;" class="skipGlobalHint">Cancel</a>
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
                        <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="runGuide();return false;" class="btn btn-large btn-blue btn-margin-right">Start</a>
                        <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="skipGlobalHint();return false;" class="btn btn-large btn-white">Not now</a>
                    </div>
                    <p><a href="https://seranking.com/contact.html" target="_blank">Contact us</a> if you need help.</p>
                </div>
            </div>
        </div>
    </div>

</div>
<!--/ wrap -->
<footer class="footer">
    <div class="container">
        <div class="footer-bg">
            <div class="row">
                <div class="span3">
                    <div class="bottom-logo">
                        <a href="https://online.seranking.com/admin.site.list.html">
                            <i class="footer-logo new"></i>
                            <span>SE</span> Ranking</a>
                    </div>
                </div>
                <div class="span9 span-right">
                    <ul class="footer-navigation">
                        <li>
                            <a class="footer_contact_support_link" href="javascript:HelpCrunch(&#39;openChat&#39;);">Contact Us</a>
                        </li>
                        <li><a href="https://seranking.com/affiliate.html" target="_blank">Affiliate</a></li>
                        <li><a href="https://seranking.com/api.html" target="_blank">API</a></li>
                        <li><a href="https://support.seranking.com/" target="_blank">Help</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="global_warning_box" style="display:none;">
    <table>
        <tbody>
        <tr>
            <td class="warning_1st">
                <svg width="22px" height="19px" viewBox="0 0 22 19" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g id="Paid-Only" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                        <g id="Paid-Features-(popup)" type="MSArtboardGroup" transform="translate(-249.000000, -174.000000)" fill="#DEA621">
                            <g id="Paid-Only-Popup" type="MSLayerGroup" transform="translate(229.000000, 139.000000)">
                                <g id="window_expanded" type="MSShapeGroup">
                                    <path d="M30.9951323,37.1937574 L30.9951323,37.1937574 L30.9951323,37.1937574 C30.9105474,37.0563352 30.8401971,36.9807803 30.8009476,36.9548938 C30.8339577,36.9766651 30.9086731,37.0001386 31.0017001,36.9999994 C31.094148,36.9998611 31.1677231,36.9765427 31.1997411,36.9553588 C31.1600248,36.981636 31.0897162,37.0572201 31.0056759,37.1937574 L22.2696481,51.3868784 C21.8338862,52.0948456 21.7828902,52 22.5314506,52 L39.4693576,52 C40.2162822,52 40.1661198,52.0935423 39.7311602,51.3868784 L30.9951323,37.1937574 Z M32.6983526,36.1454059 L41.4343804,50.3385269 C42.6790526,52.3607027 41.8015174,54 39.4693576,54 L22.5314506,54 C20.2015263,54 19.3189335,52.3652876 20.5664278,50.3385269 L29.3024557,36.1454059 C30.2402067,34.6218744 31.7560786,34.6145261 32.6983526,36.1454059 Z M30.3168732,46.7086767 L30.1186286,43.6637387 C30.0814576,43.0704284 30.0628723,42.6445227 30.0628723,42.3860089 C30.0628723,42.0342607 30.152701,41.7598588 30.3323611,41.562795 C30.5120212,41.3657312 30.7484668,41.2672008 31.0417051,41.2672008 C31.3968951,41.2672008 31.6343732,41.3932774 31.7541466,41.6454342 C31.87392,41.8975911 31.9338058,42.2609882 31.9338058,42.7356365 C31.9338058,43.0153399 31.9193506,43.299277 31.8904398,43.5874563 L31.6240486,46.7213904 C31.5951378,47.0943283 31.533187,47.3803843 31.4381943,47.5795671 C31.3432016,47.7787498 31.1862595,47.8783397 30.9673634,47.8783397 C30.7443371,47.8783397 30.58946,47.7819282 30.5027276,47.5891024 C30.4159951,47.3962765 30.3540443,47.1028042 30.3168732,46.7086767 Z M31.0045342,50.8914934 C30.7525971,50.8914934 30.5326717,50.8077955 30.3447514,50.6403972 C30.1568311,50.472999 30.0628723,50.2388568 30.0628723,49.9379637 C30.0628723,49.675212 30.152701,49.4516645 30.3323611,49.2673145 C30.5120212,49.0829645 30.7319466,48.9907909 30.9921439,48.9907909 C31.2523413,48.9907909 31.4743317,49.0829645 31.6581219,49.2673145 C31.8419121,49.4516645 31.9338058,49.675212 31.9338058,49.9379637 C31.9338058,50.2346189 31.8408796,50.4677016 31.6550243,50.6372188 C31.4691691,50.806736 31.2523412,50.8914934 31.0045342,50.8914934 Z" id="icn_alert_small"></path>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </td>
            <td class="warning_2st">
                        <span>
                    This feature is not available with your pricing plan
                </span>
                <a href="https://seranking.com/plans.html" target="_blank">See plans</a>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="warning_btn">
                <a href="https://online.seranking.com/admin.user.subscription.html" class="btn btn-middle btn-blue btn-margin-right">Upgrade the plan</a>
                <a href="javascript:void(0);" class="btn btn-middle btn-white" id="global_warning_close">Close</a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div id="global_warning_shadow" style="display:none;"></div>

<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery-ui-1.10.3.customi.min.js';?>"></script>
<script>
    var statUserData = {
        'email': "uzunchev.stanislav@gmail.com",
        'login': "uzunchev.stanislav",
        'name': "Stanislav",
        'id': "98681",
        'lang': "en",
        'license_package': "premium",
        'is_license_expired': 0,
        'is_null_balance': 0,
        'achievements': {
            "used_single_page_audit": "1",
            "used_lead_generator": "0",
            "used_backlinks": "0",
            "used_research": "1",
            "used_web_monitoring": "1"
        },
        'is_trial': 0
    };

    $(document).ready(function() {
        $("#repor-bug-form").dialog({
            autoOpen: false,
            modal: true
        });
    });

    function OpenReporBugForm() {
        $("#repor-bug-form").dialog("open");
    }

    function CloseReporBugForm() {
        $('#repor-bug-form').dialog("close");
    }

    function SendReporBugForm() {
        var error = 0;
        var comment = $('textarea#bug_comments');
        if (!$.trim(comment.val())) {
            comment.attr('style', 'border:1px solid red;width: 410px;');
            error++;
        } else {
            error = 0;
            comment.attr('style', 'width: 410px;');
        }

        if (!error) {
            $.post("admin.proxy.ajax.html", {
                do: 'sendreportbug',
                bug_name: $("#bug_name").val(),
                bug_email: $("#bug_email").val(),
                bug_url: $("#bug_url").val(),
                bug_comments: $("#bug_comments").val()
            }, function(data) {
                $('#repor-bug-form').dialog("close");
                comment.val('');
                alert('Message sent');
            });
        }
    }
</script>

<script>
    window.intercomSettings = {

        name: statUserData.login,
        email: statUserData.email,
        trial: false,
        subacc: false,
        mode: "subscription",
        plan: "premium",
        created_at: '1488216775',
        app_id: "j9oh2ay9"

    };
</script>
<script>
    (function() {
        var w = window;
        var ic = w.Intercom;
        if (typeof ic === "function") {
            ic('reattach_activator');
            ic('update', intercomSettings);
        } else {
            var d = document;
            var i = function() {
                i.c(arguments)
            };
            i.q = [];
            i.c = function(args) {
                i.q.push(args)
            };
            w.Intercom = i;

            function l() {
                var s = d.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = 'https://widget.intercom.io/widget/j9oh2ay9';
                var x = d.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            }
            if (w.attachEvent) {
                w.attachEvent('onload', l);
            } else {
                w.addEventListener('load', l, false);
            }
        }
    })()
</script>

<script>
    if (typeof dataLayer == 'undefined') {
        var dataLayer = [];
    }
</script>

<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable" tabindex="-1" role="dialog" aria-describedby="popup-placeholder-message-empty" aria-labelledby="ui-id-1" style="display: none; position: relative;">
    <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><span id="ui-id-1" class="ui-dialog-title">&nbsp;</span>
        <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close"><span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button>
    </div>
    <div class="popup-placeholder ui-dialog-content ui-widget-content" id="popup-placeholder-message-empty" style="">
        <div class="popup">
            <div class="popup-header">
                <div class="popup-title">
                    Message
                </div>
                <div class="popup-close">
                    <a href="javascript:ClosePopupMessageEmpty();" style="text-decoration:none;">
                        <div class="note-list-item-delete popup-close-button">5</div>
                    </a>
                </div>
            </div>
            <div class="popup-content">
                <div class="popup-text bottom-margin no-span-div">
                    <span class="no-span" style="color: #6f6f6f;" id="span-message-empty"></span>
                </div>
                <br>
                <br>
                <div class="popup-buttons">
                    <a href="javascript:ClosePopupMessageEmpty();" class="btn btn-input btn-blue">Ok</a>
                </div>
            </div>
        </div>
    </div>
    <div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90; display: block;"></div>
    <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
</div>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable" tabindex="-1" role="dialog" aria-describedby="edit_custom_item" aria-labelledby="ui-id-2" style="display: none; position: relative;">
    <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><span id="ui-id-2" class="ui-dialog-title">&nbsp;</span>
        <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close"><span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button>
    </div>
    <div class="popup-placeholder ui-dialog-content ui-widget-content" style="" id="edit_custom_item">
        <div class="popup" style="width: 577px;">
            <form method="post" action="https://online.seranking.com/admin.reports.checklist.do-saveCustomItem.site_id-208822.html" id="save_custom_item_form">
                <input type="hidden" name="id" value="" id="custom_item_edit_id">
                <div class="popup-header">
                    <div class="popup-title">

                    </div>
                    <div class="popup-close">
                        <a href="javascript:closePopup();" style="text-decoration:none;">
                            <div class="note-list-item-delete popup-close-button">5</div>
                        </a>
                    </div>
                </div>
                <div class="popup-content">
                    <div class="popup-text">
                        <div class="profile-input">
                            <label>Task title</label>
                            <input type="text" class="option-input" name="title" placeholder="Enter task name">
                        </div>
                        <div class="profile-input" style="margin-top: 5px;">
                            <label>Task description</label>
                            <textarea name="text" placeholder="Describe your task" class="textarea__600 textarea-shadow__a"></textarea>
                        </div>
                        <div class="profile-input" style="padding-top: 10px;clear: both;">
                            <input id="for_all_projects" type="checkbox" class="new-regular-checkbox" name="for_all_projects" value="1" checked="">
                            <label for="for_all_projects">For all projects<span class="tooltip__a" data-toggle="tooltip" data-original-title="You can add task either to all projects or only for the current one" style="font-family: caffeineregular;margin-left: 5px;">8</span></label>
                        </div>
                    </div>
                </div>
                <div class="popup-buttons footer-poup">
                    <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="$(&#39;#save_custom_item_form&#39;).submit(); return false;" class="btn btn-large btn-blue min-padding" style="margin-left: 20px;">Apply Changes</a>
                    <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="closePopup(this); return false" class="btn btn-large btn-green white-hover">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90; display: block;"></div>
    <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
</div>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable" tabindex="-1" role="dialog" aria-describedby="delete-dialog" aria-labelledby="ui-id-3" style="display: none; position: relative;">
    <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><span id="ui-id-3" class="ui-dialog-title">&nbsp;</span>
        <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close"><span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button>
    </div>
    <div class="popup-placeholder ui-dialog-content ui-widget-content" id="delete-dialog" style="">
        <div class="popup">
            <div class="popup-header">
                <div class="popup-title">
                    Deleting
                </div>
                <div class="popup-close">
                    <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="closePopup(); return false;" style="text-decoration:none;">
                        <div class="note-list-item-delete popup-close-button">5</div>
                    </a>
                </div>
            </div>
            <div class="popup-content">
                <div class="popup-text" style="margin:0px;">
                    Are you sure?
                    <br>
                    <br>
                </div>

                <div class="popup-buttons">
                    <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="confirmDeleteCustomItem(); return false;" class="btn btn-large btn-blue btn-margin-right" data-customid="0">Delete</a>
                    <a href="https://online.seranking.com/admin.reports.checklist.site_id-208822.html#" onclick="closePopup(); return false;" class="btn btn-large btn-red">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90; display: block;"></div>
    <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
</div>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable" tabindex="-1" role="dialog" aria-describedby="repor-bug-form" aria-labelledby="ui-id-4" style="display: none; position: relative;">
    <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><span id="ui-id-4" class="ui-dialog-title">&nbsp;</span>
        <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close"><span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button>
    </div>
    <div class="popup-placeholders ui-dialog-content ui-widget-content" id="repor-bug-form" style="">
        <div class="popup">
            <div class="popup-header">
                <div class="popup-title">
                    Contact Us
                </div>
                <div class="popup-close">
                    <a href="javascript:CloseReporBugForm();" style="text-decoration:none;">
                        <div class="note-list-item-delete popup-close-button">5</div>
                    </a>
                </div>
            </div>
            <div class="popup-content">
                <div class="popup-text bottom-margin">
                    Found incorrect positions or system errors, report it here. Thank you for your support.
                    <br>
                </div>
                <div class="popup-inputs">
                    <div class="profile-input">
                        <input class="option-input field-s-email input-block-level" type="text" placeholder="Name" id="bug_name" name="bug_name" value="Stanislav">
                    </div>
                    <div class="profile-input">
                        <input class="option-input field-s-email input-block-level" type="text" placeholder="Email" id="bug_email" name="bug_email" value="uzunchev.stanislav@gmail.com">
                    </div>
                    <div class="profile-input">
                        <input class="option-input field-s-email input-block-level" type="text" placeholder="URL" id="bug_url" name="bug_url" value="https://online.seranking.com/admin.reports.checklist.site_id-208822.html">
                    </div>
                    <div class="profile-input">
                        <textarea class="textarea__600 textarea-shadow__a" name="bug_comments" id="bug_comments" placeholder="Comments" style="width: 410px;"></textarea>
                    </div>
                </div>

                <div class="popup-buttons">
                    <a href="javascript:SendReporBugForm();" class="btn btn-large btn-blue btn-margin-right">Send</a>
                    <a href="javascript:CloseReporBugForm();" class="btn btn-large btn-red">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90; display: block;"></div>
    <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
    <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
</div>

<div id="intercom-container" style="position: fixed; width: 0px; height: 0px; bottom: 0px; right: 0px; z-index: 2147483647;">
    <div data-reactroot="" class="intercom-app"><span></span><span></span>
        <!-- react-empty: 4 --><span></span>
        <!-- react-empty: 6 -->
    </div>
</div>
<div id="select2-drop-mask" class="select2-drop-mask" style="display: none;"></div>
<div class="select2-drop select2-display-none select-project select2-with-searchbox select2-drop-active" style="left: 335.438px; width: 108px; top: 44px; bottom: auto; display: none;">
    <div class="select2-search">
        <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input select2-focused"> </div>
    <ul class="select2-results" tabindex="0" style="overflow: hidden; outline: none;"></ul>
    <div id="ascrail2000" class="nicescroll-rails nicescroll-rails-vr" style="width: 7px; z-index: 9999; cursor: default; position: absolute; top: 43px; left: 243px; height: 140px; opacity: 1; touch-action: none; display: none;">
        <div class="nicescroll-cursors" style="position: relative; top: 0px; float: right; width: 5px; height: 0px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px; touch-action: none;"></div>
    </div>
    <div id="ascrail2000-hr" class="nicescroll-rails nicescroll-rails-hr" style="height: 7px; z-index: 9999; top: 176px; left: 0px; position: absolute; opacity: 1; cursor: default; display: none;">
        <div class="nicescroll-cursors" style="position: absolute; top: 0px; height: 5px; width: 0px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px;"></div>
    </div>
</div>
</body>

</html>



<?php //get_footer(); ?>
