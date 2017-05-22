<!DOCTYPE html>
<html lang="en"><head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
    <title>Young Ceaser</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <base href="<?php echo get_template_directory_uri(); ?>/" />
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/jquery.cycle2.js"></script>
    <script src="assets/js/jquery.jcarousel.min.js"></script>
    <script src="assets/js/niceCheck_niceRadio.js"></script>
    <script src="assets/js/js.js"></script>
    <script src="assets/js/bootstrap-tagsinput.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body cz-shortcut-listen="true" >
<div class="all">

    <!-- header -->
    <header class="header clearfix">
        <a href="javascript:void(0)" class="logo"></a>
        <a href="https://www.fiverr.com/youngceaser" target="_blank" class="logo_fiverr"></a>
        <a href="https://www.fiverr.com/youngceaser" target="_blank" class="a_link">fiverr.com/<span>youngceaser</span></a>
    </header>
    <!-- // header -->

    <!-- content -->
    <main class="content clearfix">
      <div class="block_slider cycle-slideshow" data-cycle-slides="> .div" data-cycle-speed="800" data-cycle-timeout="6000" data-cycle-pager=".cycle-pager_1">
    		<div class="div slider_img"></div>
    	</div>


<section class="block_welcome">
    <h2>Welcome, <span><?php echo $fullName;?></span></h2>
    <div class="two_cols clearfix">
        <div class="col">
            <span class="bnr_big"><img src="assets/img/bnr_big.jpg" alt=""></span>
        </div>
        <div class="col block_order">
            <div class="title">
                <p>Order <a href="https://www.fiverr.com/users/<?php echo $username;?>/orders/<?php echo $orderID;?>" class="a_order">#<?php echo $orderID; ?></a></p>
                <a href="https://www.fiverr.com/users/<?php echo $username;?>/orders/<?php echo $orderID;?>" class="a_more">See it in Fiverr</a>				</div>
            <p class="p_1"><strong>BASIC GIGs ordered: <?php echo $gigsOrdered;?></strong></p>

            <p class="p_2">
                <strong>WEBSITE</strong><br>
                <a id="website" href="<?php echo $website?>" target="_blank"><?php echo $website;?></a>
            </p>
            <p class="p_3">
                <strong>KEYWORDS</strong><br>
                <a class="label label-info"><?php echo $keywords; ?></a>
            </p>
            <p class="p_4">
                <span class="niceCheck niceChecked niceCheckDisabled"><input type="checkbox" name="undefined" id="ch_1" value="on" tabindex="undefined" disabled="disabled"></span> <label for="ch_1">EXTRA FAST DELIVERY</label>
            </p>
        </div>
    </div>
</section>

<section class="block_extras_all">
    <h2>You’ve bought these extras <u>Add more at your discretion</u></h2>
    <!--<div class="block_extras">-->
    <div class="block_mycarousel_extras">
        <div class="mycarousel mycarousel_extras" data-jcarousel="true">
            <ul style="left: 0px; top: 0px;">
                <li>
                    <?php $visibleClass = 'op';
                    if(in_array('Bring Targeted Traffic to Your Website', $gigExtra))
                    { $visibleClass = ''; }
                    ?>
                    <article class="block_extra <?php echo $visibleClass;?>">
                        <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="img"><img src="assets/img/g1_e1.jpg" alt=""></a>
                        <!--<div class="title">Bring Targeted Traffic to Your Website</div>-->
                        <?php if(!in_array('Bring Targeted Traffic to Your Website', $gigExtra)):?>
                            <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_add">Add</a>
                        <?php endif;?>
                    </article>
                </li>
                <li>
                    <?php $visibleClass = 'op';
                    if(in_array('20 Niche Related Blog Comments', $gigExtra))
                    { $visibleClass = ''; }
                    ?>
                    <article class="block_extra <?php echo $visibleClass;?>">
                        <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="img"><img src="assets/img/g1_e2.jpg" alt=""></a>
                        <!--<div class="title">20 Niche Related Blog Comments</div>-->
                        <?php if(!in_array('20 Niche Related Blog Comments', $gigExtra)):?>
                            <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_add">Add</a>
                        <?php endif;?>
                    </article>
                </li>
                <li>
                    <?php $visibleClass = 'op';
                    if(in_array('SEO Survival Kit', $gigExtra))
                    { $visibleClass = ''; }
                    ?>
                    <article class="block_extra <?php echo $visibleClass;?>">
                        <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="img"><img src="assets/img/g1_e3.jpg" alt=""></a>
                        <!--<div class="title">SEO Survival Kit</div>-->
                        <?php if(!in_array('SEO Survival Kit', $gigExtra)):?>
                            <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_add">Add</a>
                        <?php endif;?>
                    </article>
                </li>
                <li>
                    <?php $visibleClass = 'op';
                    if(in_array('All in One SEO Package', $gigExtra))
                    { $visibleClass = ''; }
                    ?>
                    <article class="block_extra <?php echo $visibleClass;?>">
                        <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="img"><img src="assets/img/g1_e4.jpg" alt=""></a>
                        <!--<div class="title">All in One SEO Package</div>-->
                        <?php if(!in_array('All in One SEO Package', $gigExtra)):?>
                            <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_add">Add</a>
                        <?php endif;?>
                    </article>
                </li>
                <li>
                    <?php $visibleClass = 'op';
                    if(in_array('Local SEO Package', $gigExtra))
                    { $visibleClass = ''; }
                    ?>
                    <article class="block_extra <?php echo $visibleClass;?>">
                        <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="img"><img src="assets/img/g1_e5.jpg" alt=""></a>
                        <!--<div class="title">Local SEO Package</div>-->
                        <?php if(!in_array('Local SEO Package', $gigExtra)):?>
                            <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_add">Add</a>
                        <?php endif;?>
                    </article>
                </li>
                <li>
                    <?php $visibleClass = 'op';
                    if(in_array('Get Your Website Viral', $gigExtra))
                    { $visibleClass = ''; }
                    ?>
                    <article class="block_extra <?php echo $visibleClass;?>">
                        <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="img"><img src="assets/img/g1_e6.jpg" alt=""></a>
                        <!--<div class="title">Get Your Website Viral</div>-->
                        <?php if(!in_array('Get Your Website Viral', $gigExtra)):?>
                        <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_add">Add</a>
                        <?php endif;?>
                    </article>
                </li>
            </ul>
        </div>
        <a href="javascript:void(0)" class="carousel_arrow_left"></a>
        <a href="javascript:void(0)" class="carousel_arrow_right"></a>
    </div>
</section>

<section class="block_seo_stats clearfix">
    <h2>Your SEO stats</h2>
    <div class="block_seo_stats_before">
        <div class="block_seo_stats_center">
            <article class="block_seo_stat"><span><?php echo number_format($overView->upa, 2);?><sup>%</sup></span> PAGE AUTHORITY</article>
            <article class="block_seo_stat"><span><?php echo number_format($overView->pda, 2);?><sup>%</sup></span> DOMAIN AUTHORITY</article>
            <article class="block_seo_stat"><span><?php echo $pageRank;?></span> PAGE RANK</article>
            <article class="block_seo_stat"><span><?php echo $overView->ueid; ?></span> BACKLINKS</article>
        </div>
    </div>
    <div class="block_seo_stats_after">
        <div class="block_seo_stats_center">
            <article class="block_seo_stat"><span><small id="page_auth">0.00</small><sup>%</sup></span> PAGE AUTHORITY</article>
            <article class="block_seo_stat"><span><small id="domain_auth">0.00</small><sup>%</sup></span> DOMAIN AUTHORITY</article>
            <article class="block_seo_stat"><span id="page_rank">0</span> PAGE RANK</article>
            <article class="block_seo_stat"><span id="backlink">0</span> BACKLINKS</article>
        </div>
    </div>
    <div class="block_seo_stats_info">
        BEFORE GIG / <span>AFTER THE GIG</span>
        <br/>
        <br/>
        <button href="" onclick="getReport('<?php echo $website;?>')" class="button_add_solid">TODAY Stats - Check after 1 month</button>
    </div>


</section>


<section class="block_backlinks_list">
    <h2 style="margin-top: 100px;"><?php echo(sizeof($givenBackLinks))?>/50 Backlinks List (<?php echo(sizeof($givenBackLinks))?>)</h2>
    <table class="table">
        <tbody><tr>
            <th>&nbsp;</th>
            <th>#</th>
            <th>Backlink URL</th>
            <th>Domain</th>
            <th>PR</th>
            <th>DA</th>
            <th>PA</th>
            <th>Moz Rank</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach($givenBackLinks as $key => $link):?>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo $key+1; ?></td>
            <td>
                <a href="<?php echo $originalList[$key];?>" target="_blank"><?php echo $originalList[$key];?></a>
            </td>
            <td>
                <a href="<?php echo $originalList[$key];?>" target="_blank"><?php echo $links[$key];?></a>
            </td>
            <td><?php echo $givenBackLinkPR[$key]; ?></td>

            <td><?php echo number_format($link->pda, 2);?>%</td>
            <td><?php echo number_format($link->upa, 2);?>%</td>
            <td><?php echo number_format($link->umrp, 2);?></td>
            <td>&nbsp;</td>
        </tr>
        <?php endforeach;?>
        </tbody></table>
</section>


<article class="block_download_cvs">
    <div class="content_center clearfix">
        <div class="block_download_cvs_left">
            <a href="<?php echo FIFO_URL.'/'.$orderID;?>_back_link_list.csv" class="ico_download_cvs">Download a .CSV or<br> copy the values from here</a>
        </div>
        <div class="block_download_cvs_right">
            <textarea cols="10" rows="10"><?php foreach($givenBackLinks as $key => $link):?><?php echo $originalList[$key];?><?php endforeach;?>
            </textarea>
        </div>
        <div class="block_download_cvs_info">THANKS FOR WORKING WITH US. WE ARE HERE TO HELP YOU.</div>
        <a href="https://uk.fiverr.com/youngceaser" target="_blank" class="button">FIND MORE USEFUL GIGS FROM US</a>
    </div>
</article>
<section class="block_results">
    <div class="content_center clearfix">
        <h2>Please tell us how you feel with the results</h2>
        <div class="block_result">
            <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_like">
                <span>I am satisfied</span>
                Please rank us with 5 stars<br> and get a coupon code
            </a>
        </div>
        <div class="block_result">
            <a href="https://uk.fiverr.com/users/<?php echo $username; ?>/orders/<?php echo $orderID;?>" target="_blank" class="button_dislike">
                <span>I am not satisfied</span>
                Please contact us immediately and tell us what went wrong
            </a>
        </div>
    </div>
</section>
<section class="block_faq">
    <div class="content_center clearfix">
        <h2>Frequently Asked Questions</h2>
        <a href="http://report.mindsrocket.com/wp-content/uploads/2015/09/YoungCeaserFAQ2.pdf" target="_blank" class="ico_faq_pdf">DOWNLOAD THE FAQ (INTERACTIVE PDF)</a>
    </div>
</section>

<section class="block_recommended">
    <div class="content_center clearfix">
        <h2>Here are some recommended<br> Gigs to complete your campaign.</h2>
        <ul class="ul_recommended clearfix">
            <li><a href="https://uk.fiverr.com/youngceaser"><img src="assets/img/bnr_small_1_4.jpg" alt=""></a></li>
            <li><a href="https://uk.fiverr.com/youngceaser"><img src="assets/img/bnr_small_1_3.jpg" alt=""></a></li>
            <li><a href="https://uk.fiverr.com/youngceaser"><img src="assets/img/bnr_small_1_2.jpg" alt=""></a></li>
            <li><a href="https://uk.fiverr.com/youngceaser"><img src="assets/img/bnr_small_1_1.jpg" alt=""></a></li>
        </ul>
    </div>
</section>

<section class="block_fiverr clearfix">
    <h2>Find Young Ceaser on <a href="http://www.fiverr.com/youngceaser" target="_blank"><img src="assets/img/logo_fiverr_text.png" alt=""></a></h2>
</section>
</main>
<!-- // content -->
</div>


</body>

<script src="assets/js/block.js"></script>
<script>
    <?php if($fastDelivery):?>
    $( document ).ready(function() {
        $('.niceCheck').addClass('niceChecked');
    });
    <?php endif;?>

    function getReport(domainName){
        jQuery.blockUI({ message: '<h1 style="font-size: 12px;"><img style="  margin-top: 11px;" src="http://jquery.malsup.com/block/busy.gif" /> Just a moment...</h1>' });
         //var url = '<?php echo BASE_URL?>/ajax_report.php?url='+domainName;
         jQuery.ajax({
            type: "POST",
            url: "<?php echo admin_url('admin-ajax.php') ?>",
            data: {url: domainName, action : 'fiverr_update_stats' },
            success: function (response) {
                //var response = jQuery.parseJSON( response );
                jQuery('#page_auth').text(response.page_auth);
                jQuery('#domain_auth').text(response.domain_auth);
                jQuery('#page_rank').text(response.page_rank);
                jQuery('#backlink').text(response.backlink);
                jQuery.unblockUI();
            },
            error: function (xhr, status, error) {
              console.log('@@@test: ',error);
              jQuery.unblockUI();
            }
         });
    }
</script>
</html>