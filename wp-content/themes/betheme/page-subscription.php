<?php
get_header();



$galleries = get_posts(
    array(
        'name' => $postName,
        'posts_per_page' => -1,
        'post_type' => 'subscription-gallery',
        'order' => 'ASC'
    )
);

$fields = get_fields();

$keywords_text = '
<h5>Keywords Research</h5>
<p>
- We will perform a and in-depth keyword research. By In-Depth, I mean analyzing your niche and going through every possible keyword, in order to choose the best one!
</p>
<p>The main difference between keywords is their:
<ul>
<li>1.competition</li>
<li>2.search volume</li>
<li>3.conversion rate</li>
</ul>
</p>
<p>In order to target high competitive keywords, your website must have high Domain Authority, which is achieved with months/years of work.</p>

<p>It will be best to start with keywords which can be ranked on the top of Google, In 3-4 months.
So after 3-4 months, you will be ranking first in Google for many keywords that will be bringing you traffic and conversion.
Also, by this time, your Website Authority will increase and we will be able to target harder keywords.</p>

<p>It is like a Pyramid, but we must start from the base and not from the top!</p>';

?>

<link href="<?php echo get_template_directory_uri();?>/js/jquery-modal/jquery.modal.css" type="text/css" rel="stylesheet" id="theme-change">
<link href="<?php echo get_template_directory_uri(); ?>/css/subscription.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo get_template_directory_uri();?>/js/jquery-modal/jquery.modal.min.js"></script>

<script src="<?php echo get_template_directory_uri();?>/js/unitegallery/package/unitegallery/js/unitegallery.js"></script>
<link href="<?php echo get_template_directory_uri(); ?>/js/unitegallery/package/unitegallery/css/unite-gallery.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo get_template_directory_uri();?>/js/unitegallery/package/unitegallery/themes/tilesgrid/ug-theme-tilesgrid.js"></script>

<div class="component" id="Pages-SubscriptionPage-main">
    <script>
        var isRub = null;
        var curancy = '$';
        var ref_service = '&REF=0-0';
        var lang = 'en';

        var procent_skidka = 0;
        var OPTIONS_frequency = 'CHECK_DAILY';
        var month = 1;
        var percent = 1;

        var calc_price1 = '841';
        var calc_price1_1 = '1441';
        var calc_price2 = '5671';
        var calc_price2_1 = '541';
        var calc_price2_2 = '691';
        var calc_price3 = '12341';
        var calc_price3_1 = '1491';
        var calc_price4 = '1891';
        var calc_price4_1 = '3491';
        var calc_price4_2 = '5491';
        var calc_price4_3 = '8991';
    </script>

    <div class="page_wrap page_wrap_subscription">
        <div class="r top_block">
            <h1><?php echo $fields['header']; ?></h1>
            <div class="frequency">
                <div class="hint_arrow arrow_top_to_left">
                    Websites to work with
                    <div class="hint_trigger hint_fixed hint_ico"
                         data-hint-cont="<h5>WEBSITES TO WORK WITH</h5><p>If you give us more of your websites to work with, there will be a nice discount!</p>"></div>
                </div>
                <ul class="clearfix">
                    <li class="active" data-discount="0" data-monitoring="CHECK_DAILY">ONE</li>
                    <li data-discount="10" data-monitoring="CHECK_1IN3_DAYS" class="">
                        THREE
                        <span>10% OFF</span>
                    </li>
                    <li data-discount="20" data-monitoring="CHECK_WEEKLY" class="">
                        FIVE
                        <span>20% OFF</span>
                    </li>
                </ul>
            </div>

            <div class="period_block per3">
                <div class="itm active" data-month="1" data-discount="0">1 month</div>
                <div class="itm active" data-month="4" data-discount="5">
                    3 months
                    <div>5% OFF</div>
                </div>
                <div class="itm active" data-month="7" data-discount="10">
                    6 months
                    <div>10% OFF</div>
                </div>
                <div class="itm active" data-month="10" data-discount="15">
                    9 months
                    <div>15% OFF</div>
                </div>
                <div class="itm" data-month="13" data-discount="20">
                    Annual
                    <div>20% OFF</div>
                </div>
                <span class="hint_arrow arrow_bottom_to_right">
				Subscription period
                <div class="hint_trigger hint_fixed hint_ico"
                     data-hint-cont="<h5>SUBSCRIPTION PERIOD</h5><p>The longer we work together, the more traffic and sales you will get! If you pay for few months ahead, you will get a discount!</p>"></div>
			</span>
            </div>

            <div class="total_discount">
                <div class="box">
                    <div>15</div>
                    <span>TOTAL DISCOUNT</span>
                </div>
            </div>
        </div>

        <div class="main_tariff_block">
            <div class="r tariff_block">
                <!-- personal -->
                <div class="itm" data-tariff="personal">
                    <div class="top">
                        <div class="name">BASE</div>

                        <div class="price">
                            <div class="billed_price billed_price_1">
                                <span><i>$</i>234.00</span>/month
                            </div>
                            <div class="price_bottom"><span class="price1 billed_price"><i>$</i>2808</span>/year</div>
                        </div>

                        <a href="https://www.fiverr.com/youngceaser/rank-you-1st-in-google-guaranteed"
                           class="btn btn_green 4604320">Buy Now</a>

                        <div class="keywords">
                            <div class="title hint_trigger" data-hint-cont="<?php echo $keywords_text; ?>">
                                Targeted Keywords:<img style="opacity: 0.5" src="/wp-content/themes/betheme/images/plans/icn_question.svg">
                            </div>
                            <div class="select_block">
                                <p>6 Keywords</p>
                                <div class="select_dropdown">
                                    <div class="cont tariff_values">
                                        <p class="active" data-audit-account="5,000" data-audit-project="1,000"
                                           data-backlinks="1,000" data-value="4604320" data-price="2808">
                                            6 Keywords
                                        </p>
                                        <p data-audit-account="7,000" data-audit-project="3,000"
                                           data-backlinks="3,000" data-value="4616846" data-price="4008">
                                            8 Keywords
                                        </p>
                                        <p data-audit-account="7,000" data-audit-project="3,000"
                                           data-backlinks="3,000" data-value="4616846" data-price="5208">
                                            10 Keywords
                                        </p>
                                        <p data-audit-account="7,000" data-audit-project="3,000"
                                           data-backlinks="3,000" data-value="4616846" data-price="6408">
                                            12 Keywords
                                        </p>
                                        <p data-audit-account="7,000" data-audit-project="3,000"
                                           data-backlinks="3,000" data-value="4616846" data-price="7608">
                                            14 Keywords
                                        </p>
                                        <p data-audit-account="7,000" data-audit-project="3,000"
                                           data-backlinks="3,000" data-value="4616846" data-price="8808">
                                            16 Keywords
                                        </p>
                                        <p data-audit-account="7,000" data-audit-project="3,000"
                                           data-backlinks="3,000" data-value="4616846" data-price="10008">
                                            18 Keywords
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php  $post_id = 129769;
                    ?>

                    <div class="tariff_wrap">
                        <ul class="tariff_list">
                            <?php
                            $limit = 12;
                            $plan = 'base';
                            $i=1;
                            $fields2 = get_fields($post_id);
                            foreach ($fields2 as $name => $field) {
                                if (preg_match('/_perms/', $name))
                                    continue;

                                $f = get_field_object($name, $post_id);
                                ?>

                                <li class="hint_trigger <?php if (!in_array($plan, $fields2[$name.'_perms'])) echo 'no' ?>"
                                    data-hint-cont="<h5><?php echo $f['label']; ?></h5><p><?php echo $field; ?></p>">
                                    <?php echo $f['label']; ?>
                                </li>

                                <?php
                                if ($i % 9 == 0 ) {
                                    echo '</ul><ul class="tariff_list">';
                                }
                                $i++;
                                if ($i>$limit) break;
                            }
                            ?>
                        </ul>
                    </div>

                    <a href="#" class="tariff_more">See full listing</a>
                </div><!-- /personal -->

                <!-- optimum -->
                <div class="itm" data-tariff="optimum">

                    <div class="top">
                        <div class="name">optimum</div>

                        <div class="price">
                            <span class="price2"><i>$</i>567</span>/month
                        </div>

                        <a href="https://www.fiverr.com/youngceaser/rank-you-1st-in-google-guaranteed"
                           class="btn btn_green 4604321">Buy Now</a>

                        <div class="keywords">
                            <div class="title hint_trigger" data-hint-cont="<?php echo $keywords_text; ?>">
                                Targeted Keywords:<img style="opacity: 0.5" src="/wp-content/themes/betheme/images/plans/icn_question.svg">
                            </div>
                            <div class="select_block">
                                <p>12 Keywords</p>
                                <div class="select_dropdown">
                                    <div class="cont tariff_values">
                                        <p class="active" data-audit-account="25,000" data-audit-project="5,000"
                                           data-backlinks="5,000" data-value="4604321" data-price="567">
                                            12 Keywords
                                        </p>
                                        <p data-audit-account="40,000" data-audit-project="7,000"
                                           data-backlinks="10,000" data-value="4616882" data-price="667">
                                            14 Keywords
                                        </p>
                                        <p data-audit-account="60,000" data-audit-project="10,000"
                                           data-backlinks="15,000" data-value="4616883" data-price="767">
                                            16 Keywords
                                        </p>
                                        <p data-audit-account="60,000" data-audit-project="10,000"
                                           data-backlinks="15,000" data-value="4616883" data-price="867">
                                            18 Keywords
                                        </p>
                                        <p data-audit-account="60,000" data-audit-project="10,000"
                                           data-backlinks="15,000" data-value="4616883" data-price="967">
                                            20 Keywords
                                        </p>
                                        <p data-audit-account="60,000" data-audit-project="10,000"
                                           data-backlinks="15,000" data-value="4616883" data-price="1067">
                                            22 Keywords
                                        </p>
                                        <p data-audit-account="60,000" data-audit-project="10,000"
                                           data-backlinks="15,000" data-value="4616883" data-price="1167">
                                            24 Keywords
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tariff_wrap">
                        <ul class="tariff_list">
                            <?php
                            $limit = 12;
                            $plan = 'optimum';
                            $i=1;
                            $fields2 = get_fields($post_id);
                            foreach ($fields2 as $name => $field) {
                                if (preg_match('/_perms/', $name))
                                    continue;

                                $f = get_field_object($name, $post_id);
                                ?>

                                <li class="hint_trigger <?php if (!in_array($plan, $fields2[$name.'_perms'])) echo 'no' ?>"
                                    data-hint-cont="<h5><?php echo $f['label']; ?></h5><p><?php echo $field; ?></p>">
                                    <?php echo $f['label']; ?>
                                </li>

                                <?php
                                if ($i % 9 == 0 ) {
                                    echo '</ul><ul class="tariff_list">';
                                }
                                $i++;
                                if ($i>$limit) break;
                            }
                            ?>
                        </ul>

                    </div>
                    <a href="#" class="tariff_more">See full listing</a>
                </div><!-- /optimum -->

                <!-- plus -->
                <div class="itm" data-tariff="plus">
                    <div class="top">
                        <div class="top_label">MOST POPULAR</div>
                        <div class="name">evolution</div>

                        <div class="price">
                            <span class="price3"><i>$</i>1234</span>/month
                        </div>

                        <a href="https://www.fiverr.com/youngceaser/rank-you-1st-in-google-guaranteed"
                           class="btn btn_green 4604323">Buy Now</a>

                        <div class="keywords">
                            <div class="title hint_trigger" data-hint-cont="<?php echo $keywords_text; ?>">
                                Targeted Keywords:<img style="opacity: 0.5" src="/wp-content/themes/betheme/images/plans/icn_question.svg">
                            </div>
                            <div class="select_block">
                                <p>23 Keywords</p>
                                <div class="select_dropdown">
                                    <div class="cont tariff_values">
                                        <p class="active" data-audit-account="150,000" data-audit-project="15,000"
                                           data-backlinks="25,000" data-value="4604323" data-price="1234">
                                            23 Keywords
                                        </p>
                                        <p data-audit-account="200,000" data-audit-project="20,000"
                                           data-backlinks="50,000" data-value="4616884" data-price="1384">
                                            28 Keywords
                                        </p>
                                        <p data-audit-account="200,000" data-audit-project="20,000"
                                           data-backlinks="50,000" data-value="4616884" data-price="1634">
                                            33 Keywords
                                        </p>
                                        <p data-audit-account="200,000" data-audit-project="20,000"
                                           data-backlinks="50,000" data-value="4616884" data-price="1884">
                                            38 Keywords
                                        </p>
                                        <p data-audit-account="200,000" data-audit-project="20,000"
                                           data-backlinks="50,000" data-value="4616884" data-price="2134">
                                            43 Keywords
                                        </p>
                                        <p data-audit-account="200,000" data-audit-project="20,000"
                                           data-backlinks="50,000" data-value="4616884" data-price="2384">
                                            48 Keywords
                                        </p>
                                        <p data-audit-account="200,000" data-audit-project="20,000"
                                           data-backlinks="50,000" data-value="4616884" data-price="2634">
                                            53 Keywords
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tariff_wrap">
                        <ul class="tariff_list">
                            <?php
                            $limit = 12;
                            $plan = 'evolution';
                            $i=1;
                            $fields2 = get_fields($post_id);
                            foreach ($fields2 as $name => $field) {
                                if (preg_match('/_perms/', $name))
                                    continue;

                                $f = get_field_object($name, $post_id);
                                ?>

                                <li class="hint_trigger <?php if (!in_array($plan, $fields2[$name.'_perms'])) echo 'no' ?>"
                                    data-hint-cont="<h5><?php echo $f['label']; ?></h5><p><?php echo $field; ?></p>">
                                    <?php echo $f['label']; ?>
                                </li>

                                <?php
                                if ($i % 9 == 0 ) {
                                    echo '</ul><ul class="tariff_list">';
                                }
                                $i++;
                                if ($i>$limit) break;
                            }
                            ?>
                        </ul>
                    </div>

                    <a href="#" class="tariff_more">See full listing</a>
                </div><!-- /plus -->

            </div><!-- /tariff_block -->    </div>

        <div class="pop_block tariff_block_pop">
            <div class="mob_pop_header">
                <a href="#" class="btn btn_green">Buy now</a>
                <div class="pop_close"></div>
            </div>
            <div class="pop_cont clearfix">
                <div class="pop_close"></div>
                <div class="r tariff_block">
                    <!-- personal -->
                    <div class="itm" data-tariff="personal">
                        <div class="top">
                            <div class="top_label">BILLED ANNUALLY</div>11
                            <div class="name">BASE</div>

                            <div class="price">
                                <div class="billed_price billed_price_1">
                                    <span><i>$</i>234.00</span>/month
                                </div>
                                <div class="price_bottom"><span class="price1 billed_price"><i>$</i>2808</span>/year
                                </div>
                            </div>

                            <a href="https://www.fiverr.com/youngceaser/rank-you-1st-in-google-guaranteed"
                               class="btn btn_green 4604320">Buy Now</a>

                            <div class="keywords">
                                <div class="title">Targeted Keywords:</div>
                                <div class="select_block">
                                    <p>6 Keywords</p>
                                    <div class="select_dropdown">
                                        <div class="cont tariff_values">
                                            <p class="active" data-audit-account="5,000" data-audit-project="1,000"
                                               data-backlinks="1,000" data-value="4604320" data-price="2808">
                                                6 Keywords
                                            </p>
                                            <p data-audit-account="7,000" data-audit-project="3,000"
                                               data-backlinks="3,000" data-value="4616846" data-price="4008">
                                                8 Keywords
                                            </p>
                                            <p data-audit-account="7,000" data-audit-project="3,000"
                                               data-backlinks="3,000" data-value="4616846" data-price="5208">
                                                10 Keywords
                                            </p>
                                            <p data-audit-account="7,000" data-audit-project="3,000"
                                               data-backlinks="3,000" data-value="4616846" data-price="6408">
                                                12 Keywords
                                            </p>
                                            <p data-audit-account="7,000" data-audit-project="3,000"
                                               data-backlinks="3,000" data-value="4616846" data-price="7608">
                                                14 Keywords
                                            </p>
                                            <p data-audit-account="7,000" data-audit-project="3,000"
                                               data-backlinks="3,000" data-value="4616846" data-price="8808">
                                                16 Keywords
                                            </p>
                                            <p data-audit-account="7,000" data-audit-project="3,000"
                                               data-backlinks="3,000" data-value="4616846" data-price="10008">
                                                18 Keywords
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tariff_wrap">
                            <ul class="tariff_list">
                                <?php
                                $limit = 120;
                                $plan = 'base';
                                $i=1;
                                $fields2 = get_fields($post_id);
                                foreach ($fields2 as $name => $field) {
                                    if (preg_match('/_perms/', $name))
                                        continue;

                                    $f = get_field_object($name, $post_id);
                                    ?>

                                    <li class="hint_trigger <?php if (!in_array($plan, $fields2[$name.'_perms'])) echo 'no' ?>"
                                        data-hint-cont="<h5><?php echo $f['label']; ?></h5><p><?php echo $field; ?></p>">
                                        <?php echo $f['label']; ?>
                                    </li>

                                    <?php
                                    if ($i % 9 == 0 ) {
                                        echo '</ul><ul class="tariff_list">';
                                    }
                                    $i++;
                                    if ($i>$limit) break;
                                }
                                ?>
                            </ul>
                        </div>

                        <a href="#" class="tariff_more">See full listing</a>
                    </div><!-- /personal -->

                    <!-- optimum -->
                    <div class="itm" data-tariff="optimum">ssssssss

                        <div class="top">
                            <div class="name">optimum</div>

                            <div class="price">
                                <span class="price2"><i>$</i>567</span>/month
                            </div>

                            <a href="https://www.fiverr.com/youngceaser/rank-you-1st-in-google-guaranteed"
                               class="btn btn_green 4604321">Buy Now</a>

                            <div class="keywords">
                                <div class="title">Targeted Keywords:</div>
                                <div class="select_block">
                                    <p>12 Keywords</p>
                                    <div class="select_dropdown">
                                        <div class="cont tariff_values">
                                            <p class="active" data-audit-account="25,000" data-audit-project="5,000"
                                               data-backlinks="5,000" data-value="4604321" data-price="567">
                                                12 Keywords
                                            </p>
                                            <p data-audit-account="40,000" data-audit-project="7,000"
                                               data-backlinks="10,000" data-value="4616882" data-price="667">
                                                14 Keywords
                                            </p>
                                            <p data-audit-account="60,000" data-audit-project="10,000"
                                               data-backlinks="15,000" data-value="4616883" data-price="767">
                                                16 Keywords
                                            </p>
                                            <p data-audit-account="60,000" data-audit-project="10,000"
                                               data-backlinks="15,000" data-value="4616883" data-price="867">
                                                18 Keywords
                                            </p>
                                            <p data-audit-account="60,000" data-audit-project="10,000"
                                               data-backlinks="15,000" data-value="4616883" data-price="967">
                                                20 Keywords
                                            </p>
                                            <p data-audit-account="60,000" data-audit-project="10,000"
                                               data-backlinks="15,000" data-value="4616883" data-price="1067">
                                                22 Keywords
                                            </p>
                                            <p data-audit-account="60,000" data-audit-project="10,000"
                                               data-backlinks="15,000" data-value="4616883" data-price="1167">
                                                24 Keywords
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tariff_wrap">
                            <ul class="tariff_list">
                                <?php
                                $limit = 120;
                                $plan = 'optimum';
                                $i=1;
                                $fields2 = get_fields($post_id);
                                foreach ($fields2 as $name => $field) {
                                    if (preg_match('/_perms/', $name))
                                        continue;

                                    $f = get_field_object($name, $post_id);
                                    ?>

                                    <li class="hint_trigger <?php if (!in_array($plan, $fields2[$name.'_perms'])) echo 'no' ?>"
                                        data-hint-cont="<h5><?php echo $f['label']; ?></h5><p><?php echo $field; ?></p>">
                                        <?php echo $f['label']; ?>
                                    </li>

                                    <?php
                                    if ($i % 9 == 0 ) {
                                        echo '</ul><ul class="tariff_list">';
                                    }
                                    $i++;
                                    if ($i>$limit) break;
                                }
                                ?>
                            </ul>
                        </div>

                        <a href="#" class="tariff_more">See full listing</a>
                    </div><!-- /optimum -->

                    <!-- plus -->
                    <div class="itm" data-tariff="plus">
                        <div class="top">
                            <div class="top_label">MOST POPULAR</div>
                            <div class="name">evolution</div>

                            <div class="price">
                                <span class="price3"><i>$</i>1234</span>/month
                            </div>

                            <a href="https://www.fiverr.com/youngceaser/rank-you-1st-in-google-guaranteed"
                               class="btn btn_green 4604323">Buy Now</a>

                            <div class="keywords">
                                <div class="title">Targeted Keywords:</div>
                                <div class="select_block">
                                    <p>23 Keywords</p>
                                    <div class="select_dropdown">
                                        <div class="cont tariff_values">
                                            <p class="active" data-audit-account="150,000" data-audit-project="15,000"
                                               data-backlinks="25,000" data-value="4604323" data-price="1234">
                                                23 Keywords
                                            </p>
                                            <p data-audit-account="200,000" data-audit-project="20,000"
                                               data-backlinks="50,000" data-value="4616884" data-price="1384">
                                                28 Keywords
                                            </p>
                                            <p data-audit-account="200,000" data-audit-project="20,000"
                                               data-backlinks="50,000" data-value="4616884" data-price="1634">
                                                33 Keywords
                                            </p>
                                            <p data-audit-account="200,000" data-audit-project="20,000"
                                               data-backlinks="50,000" data-value="4616884" data-price="1884">
                                                38 Keywords
                                            </p>
                                            <p data-audit-account="200,000" data-audit-project="20,000"
                                               data-backlinks="50,000" data-value="4616884" data-price="2134">
                                                43 Keywords
                                            </p>
                                            <p data-audit-account="200,000" data-audit-project="20,000"
                                               data-backlinks="50,000" data-value="4616884" data-price="2384">
                                                48 Keywords
                                            </p>
                                            <p data-audit-account="200,000" data-audit-project="20,000"
                                               data-backlinks="50,000" data-value="4616884" data-price="2634">
                                                53 Keywords
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tariff_wrap">
                            <ul class="tariff_list">
                                <?php
                                $limit = 120;
                                $plan = 'evolution';
                                $i=1;
                                $fields2 = get_fields($post_id);
                                foreach ($fields2 as $name => $field) {
                                    if (preg_match('/_perms/', $name))
                                        continue;

                                    $f = get_field_object($name, $post_id);
                                    ?>

                                    <li class="hint_trigger <?php if (!in_array($plan, $fields2[$name.'_perms'])) echo 'no' ?>"
                                        data-hint-cont="<h5><?php echo $f['label']; ?></h5><p><?php echo $field; ?></p>">
                                        <?php echo $f['label']; ?>
                                    </li>

                                    <?php
                                    if ($i % 9 == 0 ) {
                                        echo '</ul><ul class="tariff_list">';
                                    }
                                    $i++;
                                    if ($i>$limit) break;
                                }
                                ?>
                            </ul>
                        </div>

                        <a href="#" class="tariff_more">See full listing</a>
                    </div><!-- /plus -->

                </div><!-- /tariff_block -->        </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div id="centerblock" style="position: relative">
    <a href="#ex1" rel="modal:open">
        <img id="features_rating_image" src="<?php echo get_template_directory_uri(); ?>/images/features.png" style="position: absolute; top: 108px; left: 48.5%; z-index: 1; cursor: pointer;">
    </a>
    <div class="top_block">
        <div class="r">
            <div class="text_block">
                <h1>Proven to work </h1>
                <p class="p">144 000+ sales, because it works!.</p>
                <div class="btns">
                    <a href="https://www.fiverr.com/conversations/youngceaser" class="btn btn_white">Get Free Analysis</a>
                </div>
                <p class="bottomnote">See some client's Rankings, 1 month after our work.</p>
            </div>
            <div>
                <a href="#ex1" rel="modal:open">
                    <img id="right-image-more" src="<?php echo get_template_directory_uri(); ?>/images/right-round.png" width="40">
                </a>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<script src="<?php echo get_template_directory_uri(); ?>/js/subscription.js"></script>

<?php
$fields = get_fields();
?>

<div class="border-content">
    <div class="container-fixed">

        <h2 class="align-center mt-40">
            <?php echo $fields['seo_header']; ?>
        </h2>

        <div class="index-feature-block align-center">
            <div class="icon-feature rankings">

            </div>
            <p class="roboto-slab-bold px16">
                <?php echo $fields['seo_subheader1']; ?>
            </p>

            <?php echo $fields['seo_content_column1']; ?>
        </div>

        <div class="index-feature-block align-center">
            <div class="icon-feature traffic">

            </div>
            <p class="roboto-slab-bold px16">
                <?php echo $fields['seo_subheader2']; ?>
            </p>

            <?php echo $fields['seo_content_column2']; ?>
        </div>

        <div class="index-feature-block align-center">
            <div class="icon-feature time">

            </div>
            <p class="roboto-slab-bold px16">
                <?php echo $fields['seo_subheader3']; ?>
            </p>

            <?php echo $fields['seo_content_column3']; ?>
        </div>

        <div class="index-feature-block align-center last">
            <div class="icon-feature seo-clients">

            </div>
            <p class="roboto-slab-bold px16">
                <?php echo $fields['seo_subheader4']; ?>
            </p>

            <?php echo $fields['seo_content_column4']; ?>
        </div>

        <div class="clear"></div>
        <div class="splitter splitter-dotted"></div>

        <h2 class="align-center">
            <?php echo $fields['steps_header']; ?>
        </h2>

        <div class="align-center mb-80">
            <?php echo $fields['steps_description']; ?>
        </div>

        <?php
        $image = get_field('step_1_image');
        ?>
        <div class="index-scr-block">
            <div class="scr-shadow float-left">
                <img width="430" height="311" alt=""
                     src="<?php echo $image['url']; ?>">
            </div>
            <div class="scr-text float-right">
                <div class="scr-title">
                    <?php echo $fields['step_1_name']; ?>
                </div>

                <p>
                    <?php echo $fields['step_1_desc']; ?>
                </p>

                <?php echo $fields['step_1_list']; ?>
            </div>
            <div class="clear"></div>
        </div>

        <?php
        $image = get_field('step_2_image');
        ?>
        <div class="index-scr-block">
            <div class="scr-text float-left">
                <div class="scr-title">
                    <?php echo $fields['step_2_name']; ?>
                </div>

                <p>
                    <?php echo $fields['step_2_desc']; ?>
                </p>

                <?php echo $fields['step_2_list']; ?>
            </div>

            <div class="scr-shadow float-right">
                <img width="430" height="311" alt=""
                     src="<?php echo $image['url']; ?>">
            </div>
            <div class="clear"></div>
        </div>

        <?php
        $image = get_field('step_3_image');
        ?>
        <div class="index-scr-block">
            <div class="scr-shadow float-left">
                <img width="430" height="311" alt=""
                     src="<?php echo $image['url']; ?>">
            </div>
            <div class="scr-text float-right">
                <div class="scr-title">
                    <?php echo $fields['step_3_name']; ?>
                </div>

                <p>
                    <?php echo $fields['step_3_desc']; ?>
                </p>

                <?php echo $fields['step_3_list']; ?>
            </div>
            <div class="clear"></div>
        </div>

        <?php
        $image = get_field('step_4_image');
        ?>
        <div class="index-scr-block">
            <div class="scr-text float-left">
                <div class="scr-title">
                    <?php echo $fields['step_4_name']; ?>
                </div>

                <p>
                    <?php echo $fields['step_4_desc']; ?>
                </p>

                <?php echo $fields['step_4_list']; ?>
            </div>
            <div class="scr-shadow float-right">
                <img width="430" height="311" alt=""
                     src="<?php echo $image['url']; ?>">
            </div>

            <div class="clear"></div>
        </div>

        <?php
        $image = get_field('step_5_image');
        ?>

        <h2 class="align-center">
            SEO SERVICES TESTED BY over <span class="green">144,000 users</span> worldwide
        </h2>

        <div class="lg-sub-title align-center">
            All these SEOs and website owners simply <span class="green">can't be wrong</span>
        </div>
    </div>
</div>

<?php foreach($galleries as $value): ?>
    <?php $gallery = get_fields($value->ID);?>

    <?php foreach($gallery['items'] as $k => $item):?>
        <?php //var_dump($item['image']);?>
    <?php endforeach;?>


<?php endforeach; ?>


<!-- Modal HTML embedded directly into document -->
<div id="ex1" style="display:none;">
        <?php foreach($galleries as $value): ?>
            <?php $gallery = get_fields($value->ID);?>
            <div class="gallery-wrapper">
                <div class="text-container">
                    <p class="title"><span><?php echo $value->post_title;?></span></p>
                </div>
                <div id="<?php echo $value->post_name;?>" style="display:none; max-width: 300px">
                    <?php foreach($gallery['items'] as $k => $item):?>
                        <img alt="<?php echo $item['title'];?>" src="<?php echo $item['image']['size']['url'];?>"
                             data-image="<?php echo $item['image']['url'];?>"
                             data-description="<?php echo $item['description'];?>">
                    <?php endforeach;?>
                </div>
            </div>
        <?php endforeach; ?>
</div>


<script>
    jQuery(document).ready(function ($) {
        <?php foreach($galleries as $value): ?>
        jQuery("#<?php echo $value->post_name;?>").unitegallery({
            gallery_theme: "tilesgrid",
            tile_height: 60,
            tile_width: 70,
            grid_num_rows: 1,
//            gallery_width:"30%"
            theme_navigation_type: "bullets",		//bullets, arrows
            tile_enable_textpanel:true,
            tile_textpanel_title_text_align: "center",
            tile_textpanel_always_on:false,
            lightbox_textpanel_enable_title: true,
            lightbox_textpanel_enable_description: true,
            theme_bullets_margin_top: 10,

        });
        <?php endforeach; ?>
    });


</script>

<?php get_footer(); ?>
