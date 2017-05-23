<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php mfn_tag_schema(); ?>>

<head>
	<!-- meta -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php if( mfn_opts_get('responsive') ) echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">'; ?>

	<title itemprop="name"><?php
		if( mfn_title() ){
			echo mfn_title();
		} else {
			global $page, $paged;
			wp_title( '|', true, 'right' );
			bloginfo( 'name' );
			if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', 'betheme' ), max( $paged, $page ) );
		}
		?></title>

	<?php do_action('wp_seo'); ?>

	<link rel="shortcut icon" href="<?php mfn_opts_show( 'favicon-img', THEME_URI .'/images/favicon.ico' ); ?>" />
	<?php if( mfn_opts_get('apple-touch-icon') ): ?>
		<link rel="apple-touch-icon" href="<?php mfn_opts_show( 'apple-touch-icon' ); ?>" />
	<?php endif; ?>

	<!-- Loading Bootstrap -->
	<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/bootstrap.css';?>" rel="stylesheet">

	<!-- Loading Flat UI -->
	<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/flat-ui.css';?>" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/style.css';?>" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/en.css';?>" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri().'/seo-checklist/css/default.css';?>" type="text/css" rel="stylesheet" id="theme-change">
	<meta name="msapplication-config" content="/skin/site/main/favicon/yellow/browserconfig.xml">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/skin/site/main/favicon/yellow/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<script type="text/javascript" async="" src="<?php echo get_template_directory_uri().'/seo-checklist/js/watch.js';?>"></script>
	<script async="" src="<?php echo get_template_directory_uri().'/seo-checklist/js/gtm.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery-1.8.3.min.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery-ui-1.10.3.custom.min.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.ui.touch-punch.min.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/bootstrap.min.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/bootstrap-select.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/bootstrap-switch.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/flatui-checkbox.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/flatui-radio.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.tagsinput.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.placeholder.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.stacktable.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.cookie.js';?>"></script>

	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/application.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/hints.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.mousewheel.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/jquery.nicescroll.min.js';?>"></script>

	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/highcharts.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/highcharts-3d.js';?>"></script>
	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/en.js';?>"></script>

	<script type="text/javascript" src="<?php echo get_template_directory_uri().'/seo-checklist/js/select2.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri().'/seo-checklist/js/jsrender.min.js';?>"></script>

	<script>
		var isReadOnly = 0;
		var spinnerText = 'Data loading...';

		$(document).ready(function() {
			$(".top-username").live("click", function() {
				window.location = "/admin.user.settings.do-profile.html";
			});
		});

		var showInitGuideModal = 0;
		var globalHintOf = 'of';
		var globalHintNextSection = 'Next';
		var header_site_id = '208822';

		window.seranking = [];
		window.seranking.hint_category_id = 5;
	</script>

	<script src="<?php echo get_template_directory_uri().'/seo-checklist/js/sdk-code.js';?>"></script>

</head>

<body cz-shortcut-listen="true">

<script id="theTmplSite" type="text/x-jsrender" data-jsv-tmpl="_0">
        <ul class="headerSiteSubMenu" style="left:{{:Left}}px;top:{{:Top}}px;">
            <li class="showSubTopMenu">
                <a href="/admin.site.positions.site_id-{{:siteId}}.html">
                    <svg width="15px" height="16px" viewBox="0 0 15 16" version="1.1" xmlns="http://www.w3.org/2000/svg" >
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Header" type="MSLayerGroup" transform="translate(-251.000000, -60.000000)" class="svg_icon_nenu">
                                <g id="First-Level" transform="translate(0.000000, 52.000000)" type="MSShapeGroup">
                                    <g id="Positions" transform="translate(251.000000, 4.000000)">
                                        <path d="M0,12.9970301 C0,12.4463856 0.442660332,12 0.998956561,12 L2.00104344,12 C2.55275191,12 3,12.4530363 3,12.9970301 L3,19.0029699 C3,19.5536144 2.55733967,20 2.00104344,20 L0.998956561,20 C0.447248087,20 0,19.5469637 0,19.0029699 L0,12.9970301 Z M6,9.00247329 C6,8.44882258 6.44266033,8 6.99895656,8 L8.00104344,8 C8.55275191,8 9,8.45576096 9,9.00247329 L9,18.9975267 C9,19.5511774 8.55733967,20 8.00104344,20 L6.99895656,20 C6.44724809,20 6,19.544239 6,18.9975267 L6,9.00247329 Z M12,5.00087166 C12,4.4481055 12.4426603,4 12.9989566,4 L14.0010434,4 C14.5527519,4 15,4.44463086 15,5.00087166 L15,18.9991283 C15,19.5518945 14.5573397,20 14.0010434,20 L12.9989566,20 C12.4472481,20 12,19.5553691 12,18.9991283 L12,5.00087166 Z" id="icn_positions"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Rankings</a>
                <ul class="subTopMenu">
                    <li>
                        <a href="/admin.site.check.site_id-{{:siteId}}.html" class="pdd">
                            Detailed
                        </a>
                    </li>
                    <li>
                        <a href="/admin.site.overall2.site_id-{{:siteId}}.html" class="pdd">
                            Overall
                        </a>
                    </li>
                    <li>
                        <a href="/admin.site.history.site_id-{{:siteId}}.html" class="pdd">
                            Historical Data
                        </a>
                    </li>
                </ul>
            </li>
            <li class="showSubTopMenu">
                <a href="/admin.site.overview.site_id-{{:siteId}}.html">
                    <svg width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" >
                        <g id="Navigation" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Navigation-with-search" type="MSArtboardGroup" transform="translate(-258.000000, -105.000000)">
                                <g id="Header" type="MSLayerGroup" class="svg_icon_nenu">
                                    <g id="Sub-Nav" transform="translate(130.000000, 104.000000)" type="MSShapeGroup">
                                        <g id="analytics_traffic" transform="translate(96.000000, 1.000000)">
                                            <path d="M47,4.4728241 L47,0 L46.9318182,0 L42.9090909,3.9375 L38.8181818,2.8125 L34.7272727,5.625 L32,5.0625 L32,7.85878813 L32,15 L47,15 L47,4.4728241 L47,4.4728241 L47,4.4728241 Z M45,4.64331055 L43.9337769,6.65863037 L39.2050781,5.27539063 L35.4162234,8.06141961 L34,7.70605469 L34,12.344406 L34,11.688812 L35.4296834,12.0480969 L39.215847,9.25013828 L43.9437532,10.6440142 L45,9.58779135 L45,11.2938957 L45,4.64331055 Z" id="icn_analytics_traffic"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Analytics & Traffic</a>
                <ul class="subTopMenu">
                    <li>
                        <a href="/admin.site.overview.site_id-{{:siteId}}.html" class="pdd">
                            Overview
                        </a>
                    </li>
                    <li>
                        <a href="/admin.site.overview.do-traffic.site_id-{{:siteId}}.html">
                            Traffic
                        </a>
                    </li>
                    <li>
                        <a href="/admin.site.overview.snippets.site_id-{{:siteId}}.html">
                            Snippets
                        </a>
                    </li>

                    <li>
                        <a href="/admin.site.overview.wmtoolsdata.site_id-{{:siteId}}.html" class="odd">
                            Google Search Console Data
                        </a>
                    </li>

                    <li>
                        <a href="/admin.site.overview.traffic_opportunity.site_id-{{:siteId}}.html">
                            SEO Potential
                        </a>
                    </li>
                </ul>
            </li>
            <li class="showSubTopMenu">
                <a href="/admin.site.competitors.site_id-{{:siteId}}.html">
                    <svg width="17px" height="16px" viewBox="0 0 17 16" version="1.1" xmlns="http://www.w3.org/2000/svg" >
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Header" type="MSLayerGroup" transform="translate(-370.000000, -104.000000)" class="svg_icon_nenu">
                                <g id="Sub-Nav" transform="translate(130.000000, 104.000000)" type="MSShapeGroup">
                                    <g id="competitors" transform="translate(204.000000, 0.000000)">
                                        <path d="M48.1128025,9 L49.9906311,9 C50.5566468,9 51.1226283,8.57080104 51.2738979,8.04135729 L52.7261021,2.95864271 C52.874891,2.43788135 52.5480902,2 51.9906311,2 L50.0093689,2 C49.9702937,2 49.9312186,2.00204552 49.8922802,2.00602834 C49.9629019,1.315182 50,0.640564981 50,0 L39,0 C39,0.639432686 39.0369521,1.3141737 39.10735,2.00599057 C39.068534,2.00203259 39.0295826,2 38.9906311,2 L37.0093689,2 C36.4519098,2 36.125109,2.43788135 36.2738979,2.95864271 L37.7261021,8.04135729 C37.8773717,8.57080104 38.4433532,9 39.0093689,9 L40.8743125,9 C41.4222067,10.2576796 42.0660394,11.311198 42.7725344,11.9875231 L42.7670769,11.9875556 C45.4743462,14.3516444 39.8478462,14.0536889 39.8478462,15.7436444 C39.8478462,15.8609778 42.1612308,15.9985778 44.4847692,16 L44.5,16 L44.5152308,16 C46.8387692,15.9989333 49.1521538,15.8609778 49.1521538,15.7436444 C49.1521538,14.0536889 43.5256538,14.3313778 46.2329231,11.9669333 L46.2239381,11.9669868 C46.9254396,11.2902106 47.5662209,10.2455698 48.1128025,9 L48.1128025,9 Z M49.7658227,3.02374359 C49.8455665,3.00820921 49.9257007,3 50.0049925,3 L50.3975952,3 C50.9526373,3 51.2830039,3.42629719 51.1321547,3.96405029 L50.270433,7.03594971 C50.121077,7.56837998 49.5573397,8 49.0010434,8 L48.5159788,8 C49.0847589,6.46505676 49.518221,4.72229981 49.7658227,3.02374359 L49.7658227,3.02374359 Z M39.2331235,3.02353873 C39.1537276,3.00813705 39.07395,3 38.9950075,3 L38.6024048,3 C38.0473627,3 37.7169961,3.42629719 37.8678453,3.96405029 L38.729567,7.03594971 C38.878923,7.56837998 39.4426603,8 39.9989566,8 L40.4741029,8 C39.9089264,6.46334541 39.4789309,4.71958099 39.2331235,3.02353873 L39.2331235,3.02353873 Z M47.1770465,3.93489443 C47.1516366,3.85649312 47.0834427,3.79915808 47.0017837,3.78721329 L45.4076961,3.55570138 L44.6947002,2.11124951 C44.6215112,1.96291683 44.3784888,1.96291683 44.3052998,2.11124951 L43.5923039,3.55570138 L41.9982163,3.78721329 C41.9165573,3.79915808 41.8485806,3.85627594 41.8229535,3.93489443 C41.7975437,4.0137301 41.81861,4.09994982 41.8778996,4.15750203 L43.0315499,5.28205049 L42.7592085,6.86962276 C42.7453091,6.95106457 42.7787546,7.03359226 42.8454283,7.08202299 C42.9125363,7.13088808 43.001145,7.13718624 43.074334,7.09852853 L44.5001086,6.34882956 L45.925666,7.09831135 C45.957374,7.11503407 45.9923397,7.12328684 46.026871,7.12328684 C46.0718269,7.12328684 46.1165656,7.10938744 46.1545717,7.08180581 C46.2214626,7.03337509 46.254908,6.95084739 46.2407915,6.86940558 L45.9684501,5.28183331 L47.1221004,4.15728485 C47.18139,4.09973264 47.2024563,4.0137301 47.1770465,3.93489443 Z" id="icn_competitors"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Competitors</a>
                <ul class="subTopMenu">
                    <li>
                        <a href="/admin.site.competitors.site_id-{{:siteId}}.html" class="pdd">
                                Main competitors
                            </a>
                    </li>
                    <li>
                        <a href="/admin.site.competitors.top10.site_id-{{:siteId}}.html">
                                Top 10
                            </a>
                    </li>
                    <li>
                        <a href="/admin.site.competitors.all.site_id-{{:siteId}}.html" class="odd">
                                All competitors
                            </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/admin.reports.checklist.site_id-{{:siteId}}.html">
                    <svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" >
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Header" type="MSLayerGroup" transform="translate(-507.000000, -104.000000)" class="svg_icon_nenu">
                                <g id="Sub-Nav" transform="translate(130.000000, 104.000000)" type="MSShapeGroup">
                                    <g id="marketing" transform="translate(323.000000, 0.000000)">
                                        <path d="M61,8.58578644 L60.0066248,7.59241125 C59.6063913,7.19217769 58.9763107,7.19526215 58.5857864,7.58578644 C58.1925395,7.97903339 58.1982282,8.61244174 58.5924112,9.00662481 L59.8980205,10.312234 C59.9343829,10.5013939 60.0253327,10.682187 60.1715729,10.8284271 C60.5648198,11.2216741 61.1943219,11.2198916 61.5836864,10.8305271 L65.8305271,6.58368643 C66.2151889,6.1990247 66.2189514,5.56209717 65.8284271,5.17157288 C65.4351802,4.77832592 64.8056781,4.78010838 64.4163136,5.16947287 L61,8.58578644 Z M54,1.99406028 C54,0.892771196 54.8945138,0 55.9940603,0 L68.0059397,0 C69.1072288,0 70,0.894513756 70,1.99406028 L70,14.0059397 C70,15.1072288 69.1054862,16 68.0059397,16 L55.9940603,16 C54.8927712,16 54,15.1054862 54,14.0059397 L54,1.99406028 Z M56,3.00247329 C56,2.44882258 56.455761,2 57.0024733,2 L66.9975267,2 C67.5511774,2 68,2.45576096 68,3.00247329 L68,12.9975267 C68,13.5511774 67.544239,14 66.9975267,14 L57.0024733,14 C56.4488226,14 56,13.544239 56,12.9975267 L56,3.00247329 Z" id="icn_marketing"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Online marketing plan</a>
            </li>
            <li class="showSubTopMenu">
                <a href="/admin.reports.audit.site_id-{{:siteId}}.html">
                    <svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" >
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Header" type="MSLayerGroup" transform="translate(-649.000000, -104.000000)" class="svg_icon_nenu">
                                <g id="Sub-Nav" transform="translate(130.000000, 104.000000)" type="MSShapeGroup">
                                    <g id="site_analysis" transform="translate(476.000000, 0.000000)">
                                        <path d="M57.5856864,11.8831402 C58.0260516,11.1920773 58.2805845,10.3752175 58.2805845,9.5 C58.2805845,7.01471863 56.2281793,5 53.6964092,5 C51.164639,5 49.1122338,7.01471863 49.1122338,9.5 C49.1122338,11.9852814 51.164639,14 53.6964092,14 L50.6499918,14 L46.0367177,14 C45.484816,14 45.0374113,13.544239 45.0374113,12.9975267 L45.0374113,3.00247329 C45.0374113,2.44882258 45.4894279,2 46.0437285,2 L50.1309394,2 L50.1309394,5 L51.6589979,5 L55.2244676,5 L55.2244676,5 L55.2244676,4.9253753 L50.2282492,0 L44.9942851,0 C43.8863252,0 43,0.892771196 43,1.99406028 L43,14.0059397 C43,15.1054862 43.8915259,16 44.9912789,16 L53.2331887,16 C54.3237544,16 55.2214737,15.1050808 55.2244601,14 L53.6964092,14 L53.6964092,14 C54.5919065,14 55.4274322,13.7479455 56.133378,13.3121665 L57.2420272,14.4208156 C57.6313022,14.8100907 58.2782631,14.8120429 58.6760924,14.4142136 C59.0766953,14.0136107 59.0768776,13.3743314 58.6826945,12.9801483 L57.5856864,11.8831402 Z M53.6964092,12 C55.1029481,12 56.2431732,10.8807119 56.2431732,9.5 C56.2431732,8.11928813 55.1029481,7 53.6964092,7 C52.2898702,7 51.1496451,8.11928813 51.1496451,9.5 C51.1496451,10.8807119 52.2898702,12 53.6964092,12 Z" id="icn_site_analysis"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Website Audit</a>
                <ul class="subTopMenu">
                    <li>
                        <a href="/admin.reports.audit.site_id-{{:siteId}}.html" class="pdd">
										Website Audit
									</a>
                    </li>
                    <li>
                        <a href="/admin.audit.compare_crawls.site_id-{{:siteId}}.html">
										Compare crawls
									</a>
                    </li>
                    <li>
                        <a href="/admin.web_monitoring.site_id-{{:siteId}}.html" class="odd disabledElement">
                                        Page changes monitoring
                                    </a>
                    </li>
                </ul>
            </li>
            <li class="showSubTopMenu">
                <a href="/admin.backlinks.do-allBacklinks.site_id-{{:siteId}}.html">
                    <svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" >
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Header" type="MSLayerGroup" transform="translate(-795.000000, -104.000000)" class="svg_icon_nenu">
                                <g id="Sub-Nav" transform="translate(130.000000, 104.000000)" type="MSShapeGroup">
                                    <g id="back_links" transform="translate(605.000000, 0.000000)">
                                        <path d="M71,2.05912426 C71.2773036,2.038588 71.6076836,2.02786563 72,2.02785605 C73.1013059,2.02782915 73.9947068,2.91623165 73.9999766,4.01411064 L73.9999766,4.01411064 C73.9999922,4.01637638 74,4.01864373 74,4.02091266 L74,10.0149023 C74,10.070337 73.9954835,10.124713 73.9867909,10.1776797 C75.158878,10.5849514 76,11.6974285 76,13.0059692 C76,14.6595267 74.6568542,16 73,16 C71.3431458,16 70,14.6595267 70,13.0059692 C70,11.6972956 70.8412927,10.5847256 72.013566,10.1775557 L72.013566,10.1775557 C72.0046428,10.1245337 72,10.0701886 72,10.0149023 L72,6.01989718 C71.994934,6.01989718 71.9898723,6.01987838 71.9848152,6.01984085 L71.9848152,6.01942834 C71.9848152,4.43006851 72.0142052,4.10655643 71,4.04070598 L71,5.4608551 C71,6.0132983 70.6308594,6.21325231 70.1711974,5.89618016 C70.1711974,5.89618016 67,3.8329719 67,3.02156895 C67,2.29722391 70.1905403,0.148958074 70.1905403,0.148958074 C70.6375926,-0.164166491 71,0.0333558853 71,0.582282802 L71,2.05912426 Z M65,13.9408757 C64.7226964,13.961412 64.3923164,13.9721344 64,13.9721439 C62.8986941,13.9721708 62.0052932,13.0837683 62.0000234,11.9858894 L62.0000234,11.9858894 C62.0000078,11.9836236 62,11.9813563 62,11.9790873 L62,5.98509774 C62,5.929663 62.0045165,5.87528702 62.0132091,5.82232028 C60.841122,5.41504858 60,4.30257155 60,2.99403085 C60,1.34047327 61.3431458,6.21724894e-15 63,6.21724894e-15 C64.6568542,6.21724894e-15 66,1.34047327 66,2.99403085 C66,4.30270436 65.1587073,5.4152744 63.986434,5.82244426 L63.986434,5.82244426 C63.9953572,5.87546634 64,5.92981136 64,5.98509774 L64,9.98010282 C64.005066,9.98010282 64.0101277,9.98012162 64.0151848,9.98015915 L64.0151848,9.98057166 C64.0151848,11.5699315 63.9857948,11.8934436 65,11.959294 L65,10.5391449 C65,9.9867017 65.3691406,9.78674769 65.8288026,10.1038198 C65.8288026,10.1038198 69,12.1670281 69,12.978431 C69,13.7027761 65.8094597,15.8510419 65.8094597,15.8510419 C65.3624074,16.1641665 65,15.9666441 65,15.4177172 L65,13.9408757 L65,13.9408757 Z M63,3.99204113 C63.5522847,3.99204113 64,3.5452167 64,2.99403085 C64,2.44284499 63.5522847,1.99602056 63,1.99602056 C62.4477153,1.99602056 62,2.44284499 62,2.99403085 C62,3.5452167 62.4477153,3.99204113 63,3.99204113 Z M73,12.0079589 C72.4477153,12.0079589 72,12.4547833 72,13.0059692 C72,13.557155 72.4477153,14.0039794 73,14.0039794 C73.5522847,14.0039794 74,13.557155 74,13.0059692 C74,12.4547833 73.5522847,12.0079589 73,12.0079589 Z" id="icn_back_links"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Backlinks</a>
                <ul class="subTopMenu">
                    <li>
                        <a href="/admin.backlinks.do-allBacklinks.site_id-{{:siteId}}.html" class="pdd">
                                            Backlinks
                                        </a>
                    </li>
                    <li>
                        <a href="/admin.backlinks.site_id-{{:siteId}}.html">
                                            Overview
                                        </a>
                    </li>
                    <li>
                        <a href="/admin.backlinks.do-anchors.site_id-{{:siteId}}.html">
                                            Anchors
                                        </a>
                    </li>
                    <li>
                        <a href="/admin.backlinks.do-pages.site_id-{{:siteId}}.html">
                                            Pages
                                        </a>
                    </li>
                    <li>
                        <a href="/admin.backlinks.do-disavow.site_id-{{:siteId}}.html" class="odd">
                                            Disavow
                                        </a>
                    </li>
                </ul>
            </li>
            <li class="showSubTopMenu">
                <a href="/admin.social.site_id-{{:siteId}}.html">
                    <svg width="14px" height="14px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" >
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Header" type="MSLayerGroup" transform="translate(-971.000000, -104.000000)" class="svg_icon_nenu">
                                <g id="Sub-Nav" transform="translate(130.000000, 104.000000)" type="MSShapeGroup">
                                    <g id="social_services" transform="translate(770.000000, 0.000000)">
                                        <path d="M81.0057505,12.8127211 L76.2009104,10.0386454 C75.6529694,10.6299191 74.8697032,11 74,11 C72.3431458,11 71,9.65685425 71,8 C71,6.34314575 72.3431458,5 74,5 C74.8697032,5 75.6529694,5.37008092 76.2009104,5.96135458 L81.0057505,3.18727887 L81.0057505,3.18727887 C81.0019356,3.12534221 81,3.06289715 81,3 C81,1.34314575 82.3431458,0 84,0 C85.6568542,0 87,1.34314575 87,3 C87,4.65685425 85.6568542,6 84,6 C83.1302968,6 82.3470306,5.62991908 81.7990896,5.03864542 L76.9942495,7.81272113 C76.9980644,7.87465779 77,7.93710285 77,8 C77,8.06289715 76.9980644,8.12534221 76.9942495,8.18727887 L76.9942495,8.18727887 L81.7990896,10.9613546 C82.3470306,10.3700809 83.1302968,10 84,10 C85.6568542,10 87,11.3431458 87,13 C87,14.6568542 85.6568542,16 84,16 C82.3431458,16 81,14.6568542 81,13 C81,12.9371029 81.0019356,12.8746578 81.0057505,12.8127211 L81.0057505,12.8127211 Z M84,4 C84.5522847,4 85,3.55228475 85,3 C85,2.44771525 84.5522847,2 84,2 C83.4477153,2 83,2.44771525 83,3 C83,3.55228475 83.4477153,4 84,4 Z M74,9 C74.5522847,9 75,8.55228475 75,8 C75,7.44771525 74.5522847,7 74,7 C73.4477153,7 73,7.44771525 73,8 C73,8.55228475 73.4477153,9 74,9 Z M84,14 C84.5522847,14 85,13.5522847 85,13 C85,12.4477153 84.5522847,12 84,12 C83.4477153,12 83,12.4477153 83,13 C83,13.5522847 83.4477153,14 84,14 Z" id="icn_social_services"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Social</a>
                <ul class="subTopMenu">
                    <li>
                        <a href="/admin.social.site_id-{{:siteId}}.html">Dashboard</a>
                    </li>
                    <li>
                        <a href="/admin.social.do-facebook.site_id-{{:siteId}}.html">Facebook Metrics</a>
                    </li>
                    <li>
                        <a href="/admin.social.do-twitter.site_id-{{:siteId}}.html">Twitter Metrics</a>
                    </li>
                    <li>
                        <a href="/admin.social.do-accounts.site_id-{{:siteId}}.html">Accounts</a>
                    </li>
                    <li>
                        <a href="/admin.social.poster.do-posts.site_id-{{:siteId}}.html">Posting Schedule</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/admin.site.edit.site_id-{{:siteId}}.html">
                    <svg width="14px" height="14px" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" >
                        <g id="Homepage-Desktop" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" type="MSPage">
                            <g id="Detailed-Info-v1" type="MSArtboardGroup" transform="translate(-810.000000, -538.000000)" class="svg_icon_nenu">
                                <g id="Shot1" type="MSLayerGroup">
                                    <g id="Header" transform="translate(130.000000, 530.000000)" type="MSShapeGroup">
                                        <g id="btn_columns" transform="translate(668.000000, 0.000000)">
                                            <path d="M26,15.8617878 L26,14.1107308 L23.9177572,13.7710892 C23.7937387,13.2785384 23.6006644,12.8148782 23.3448762,12.3892692 L24.5589893,10.6586471 L23.3216227,9.4219851 L21.6135494,10.6501913 C21.1879404,10.3922891 20.720757,10.1949869 20.2246829,10.0723777 L19.8610831,8 L18.1107308,8 L17.7739078,10.0660358 C17.2764244,10.1879404 16.8078317,10.3817193 16.3808134,10.6382122 L14.6776726,9.4219851 L13.440306,10.6586471 L14.6382122,12.3716529 C14.3789007,12.8007852 14.1823032,13.2686732 14.0568754,13.7689752 L12,14.1107308 L12,15.8610831 L14.0547614,16.2246829 C14.1787799,16.7249849 14.3760821,17.1935776 14.6353936,17.6234145 L13.4212805,19.3209181 L14.6586471,20.5589893 L16.3737669,19.3582645 C16.8021945,19.615462 17.2693779,19.8106503 17.7668613,19.9325549 L18.1107308,22 L19.8610831,22 L20.2282062,19.9276223 C20.7221663,19.8021945 21.1886451,19.6055969 21.6142541,19.3469901 L23.3413529,20.559694 L24.5780149,19.3216227 L23.3455808,17.6100262 C23.6006644,17.1844172 23.7944433,16.7200523 23.9170525,16.2260922 L26,15.8617878 L26,15.8617878 Z M19,17.44091 C17.6520032,17.44091 16.55909,16.3487014 16.55909,15 C16.55909,13.6527079 17.6520032,12.5597946 19,12.5597946 C20.3479968,12.5597946 21.4402054,13.6527079 21.4402054,15 C21.44091,16.3487014 20.3479968,17.44091 19,17.44091 L19,17.44091 Z" id="icn_settings"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>Settings</a>
            </li>
        </ul>
    </script>

<script>
	var allWebsitesText = 'All Websites';
	var selectedSiteText = 'Select a Website';
	var headerSiteTitle = 'georgi';
	var is_client = false;

	$(document).ready(function($) {
		$(".hint_close a").on('click', function(event) {
			var hintTextSelector = $(event.target).closest('div.hint_text');

			hintTextSelector.slideUp("fast", function() {
				hintTextSelector.siblings('div.back_text').slideDown("fast");
			});
		});

		$(".back_text a.back").on('click', function() {
			$('div.back_text').slideUp(function() {
				$('div.hint_text').slideDown("fast");
			});
		});

		$(".back_text a.not_more").on('click', function(event) {
			$.post("/ajax.admin.html", {
				ajax: 'HideHint',
				name: $(this).data('blockname')
			}, function(data) {
				$(event.target).closest('div.container.new_hint').slideUp("fast");
			});
		});

		$("#s2id_select-project").remove();

		$("#select-project").select2({
			minimumInputLength: 0,
			placeholder: selectedSiteText,
			dropdownCssClass: 'select-project',
			formatResult: formatState,
			query: function(query) {
				$.post('/ajax.admin.html?ajax=FindSitesWithGroups', {
					query: query.term
				}, function(result) {
					query.callback({
						results: result.response
					});
					var container = $('.select-project ul.select2-results');
					if (container.hasClass('q') === false) {
						$('.select-project > .select2-results').niceScroll({
							autohidemode: false
						}).scrollstart(function() {
							if ($('.headerSiteSubMenu').length > 0) {
								$('.headerSiteSubMenu').remove();
							}
						});
					}
					$("#select-project-ranking").select2("close");
				}, 'json');
			}
		}).on('change', function() {
			var siteId = $(this).val();
			if (siteId != 0) {
				redirect('/admin.site.check.site_id-' + siteId + '.html');
			} else {
				redirect('/admin.site.check.html');
			}
		}).on("select2-close", function() {
			$('.headerSiteSubMenu').remove();
		});

		var template = $.templates("#theTmplSite");
		$("div.select2-drop.select-project ul.select2-results li.select2-result-selectable").live('mouseenter', function() {
			$('.headerSiteSubMenu').remove();
			var offset = $(this).offset();
			var dataSiteId = $(this).find('span.submenuTextSite').data('siteid');
			var site = {
				siteId: dataSiteId,
				Left: (offset.left + 250),
				Top: offset.top
			};
			var htmlOutput = template.render(site);
			$("body").append(htmlOutput);
		}).live('mouseleave', function() {
			$('.headerSiteSubMenu').remove();
			var highlighted = $("div.select2-drop.select-project ul.select2-results li.select2-result-selectable.select2-highlighted");
			var offsetSelect = highlighted.offset();
			var dataSiteIdSelect = highlighted.find('span.submenuTextSite').data('siteid');
			var siteSelect = {
				siteId: dataSiteIdSelect,
				Left: (offsetSelect.left + 250),
				Top: offsetSelect.top
			};
			var htmlOutputSelect = template.render(siteSelect);
			$("body").append(htmlOutputSelect);
		});
		$("div.select2-drop.select-project ul.select2-results li.select2-result-unselectable").live('mouseenter', function() {
			$('.headerSiteSubMenu').remove();
		});

		$("div.select2-drop.select-project .select2-input").on("keyup", function(e) {
			$('.headerSiteSubMenu').remove();
		});


	});

	function formatState(state) {

		if (!state.id) {
			return state.text + '<span class="countSite">' + state.count + '</span>';
		}

		var $state = $('<span class="submenuTextSite" data-siteid="' + state.id + '">' + state.text + '</span>');
		return $state;
	}
</script>
