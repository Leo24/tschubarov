<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */
?>

/******************* Background ********************/
	
	html { 
		background-color: <?php mfn_opts_show( 'background-body', '#FCFCFC' ) ?>;
	}
	
	#Wrapper, #Content { 
		background-color: <?php mfn_opts_show( 'background-body', '#FCFCFC' ) ?>;
	}
	
	<?php if( mfn_opts_get( 'img-subheader-bg' ) ): ?>
		body:not(.template-slider) #Header_wrapper { background-image: url("<?php mfn_opts_show( 'img-subheader-bg' ) ?>"); }
	<?php endif; ?>
	
	<?php if( mfn_opts_get( 'footer-bg-img' ) ): ?>
		#Footer { background-image: url("<?php mfn_opts_show( 'footer-bg-img' ) ?>"); }
	<?php endif; ?>

/********************** Font | Family **********************/

 	body, button, span.date_label, .timeline_items li h3 span, input[type="submit"], input[type="reset"], input[type="button"],
	input[type="text"], input[type="password"], input[type="tel"], input[type="email"], textarea, select, .offer_li .title h3 {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-content', 'Roboto' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 400;
	}
	
	#menu > ul > li > a, .action_button, #overlay-menu ul li a {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-menu', 'Roboto' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 400;
	}
	
	#Subheader .title {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-title', 'Roboto' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 400;
	}
	
	h1, .text-logo #logo {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-headings', 'Patua One' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h2 {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-headings', 'Patua One' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h3 {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-headings', 'Patua One' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h4 {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-headings', 'Patua One' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h5 {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-headings-small', 'Roboto' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 700;
	}
	
	h6 {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-headings-small', 'Roboto' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
		font-weight: 400;
	}
	
	blockquote {
		<?php $font = str_replace( '#', '', mfn_opts_get( 'font-blockquote', 'Patua One' ) ); ?>
		font-family: "<?php echo $font; ?>", Arial, Tahoma, sans-serif;
	}


/********************** Font | Size **********************/

	<?php 
		$aFontSize = $aFontSizeDefault = array(
			'content'	=> mfn_opts_get( 'font-size-content', '13' ),
			'menu'		=> mfn_opts_get( 'font-size-menu', '14' ),
			'h1'		=> mfn_opts_get( 'font-size-h1', '25' ),
			'h2'		=> mfn_opts_get( 'font-size-h2', '30' ),
			'h3'		=> mfn_opts_get( 'font-size-h3', '25' ),
			'h4'		=> mfn_opts_get( 'font-size-h4', '21' ),
			'h5'		=> mfn_opts_get( 'font-size-h5', '15' ),
			'h6'		=> mfn_opts_get( 'font-size-h6', '13' ),
		);
	?>

/* Body */

	body {
		font-size: <?php echo $aFontSize['content']; ?>px;
		line-height: <?php echo $aFontSize['content'] + 8; ?>px;		
	}	
	#menu > ul > li > a, .action_button {	
		font-size: <?php echo $aFontSize['menu']; ?>px;
	}
	
/* Headings */

	h1, #Subheader .title, .text-logo #logo { 
		font-size: <?php echo $aFontSize['h1']; ?>px;
		line-height: <?php echo $aFontSize['h1'] + 0; ?>px;	
	}	
	h2 { 
		font-size: <?php echo $aFontSize['h2']; ?>px;
		line-height: <?php echo $aFontSize['h2'] + 0; ?>px;	
	}	
	h3 {
		font-size: <?php echo $aFontSize['h3']; ?>px;
		line-height: <?php echo $aFontSize['h3'] + 2; ?>px;	
	}	
	h4 {
		font-size: <?php echo $aFontSize['h4']; ?>px;
		line-height: <?php echo $aFontSize['h4'] + 4; ?>px;	
	}	
	h5 {
		font-size: <?php echo $aFontSize['h5']; ?>px;
		line-height: <?php echo $aFontSize['h5'] + 5; ?>px;	
	}	
	h6 {		
		font-size: <?php echo $aFontSize['h6']; ?>px;
		line-height: <?php echo $aFontSize['h6'] + 7; ?>px;	
	}
	
/* Responsive */
	<?php if( mfn_opts_get('responsive') && mfn_opts_get('font-size-responsive') ): ?>
	
		<?php
			// Tablet (Landscape) ------------------------- 768 - 959
			$min = 13;
			$multiplier = 0.9;
			
			foreach( $aFontSize as $k => $v ){	
				$aFontSize[$k] = round( $v * $multiplier );
				if( $aFontSize[$k] < $min ) $aFontSize[$k] = $min;
			}
		?>
		
		@media only screen and (min-width: 768px) and (max-width: 959px){	
			body {
				font-size: <?php echo $aFontSize['content']; ?>px;		
				line-height: <?php echo $aFontSize['content'] + 7; ?>px;		
			}
			#menu > ul > li > a {	
				font-size: <?php echo $aFontSize['menu']; ?>px;
			}
			
			h1, #Subheader .title, .text-logo #logo { 
				font-size: <?php echo $aFontSize['h1']; ?>px;
				line-height: <?php echo $aFontSize['h1'] + 0; ?>px;	
			}	
			h2 { 
				font-size: <?php echo $aFontSize['h2']; ?>px;
				line-height: <?php echo $aFontSize['h2'] + 0; ?>px;	
			}	
			h3 {
				font-size: <?php echo $aFontSize['h3']; ?>px;
				line-height: <?php echo $aFontSize['h3'] + 2; ?>px;	
			}	
			h4 {
				font-size: <?php echo $aFontSize['h4']; ?>px;
				line-height: <?php echo $aFontSize['h4'] + 4; ?>px;	
			}	
			h5 {
				font-size: <?php echo $aFontSize['h5']; ?>px;
				line-height: <?php echo $aFontSize['h5'] + 4; ?>px;	
			}	
			h6 {		
				font-size: <?php echo $aFontSize['h6']; ?>px;
				line-height: <?php echo $aFontSize['h6'] + 6; ?>px;	
			}
			
			blockquote { font-size: 15px;}
			.the_content_wrapper ul, .the_content_wrapper ol { font-size: 14px; line-height: 19px; }
			.faq .question .title { font-size: 14px; }
			.pricing-box .plan-header h2 { font-size: 27px; line-height: 27px; }
			.pricing-box .plan-header .price > span { font-size: 40px; line-height: 40px; }
			.pricing-box .plan-header .price sup.currency { font-size: 18px; line-height: 18px; }
			.pricing-box .plan-header .price sup.period { font-size: 14px; line-height: 14px;}
			.offer .offer_li .desc_wrapper .title h3 { font-size: 32px; line-height: 32px; }
			.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 32px; line-height: 32px; }
			.counter .desc_wrapper .number-wrapper { font-size: 45px; line-height: 45px;}
			.counter .desc_wrapper .title { font-size: 14px; line-height: 18px;}
			.chart_box .chart .num { font-size: 45px; line-height: 45px; }
			.trailer_box .desc h2 { font-size: 27px; line-height: 27px; }
			.quick_fact .number { font-size: 80px; line-height: 80px;}
		}
		
		<?php
			// Tablet (Portrait) & Mobile (Landscape) ----- 480 - 767
			$min = 13;
			$multiplier = 0.8;
			
			$aFontSize = $aFontSizeDefault;
			foreach( $aFontSize as $k => $v ){	
				$aFontSize[$k] = round( $v * $multiplier );
				if( $aFontSize[$k] < $min ) $aFontSize[$k] = $min;
			}
		?>
		
		@media only screen and (min-width: 480px) and (max-width: 767px){
			body {
				font-size: <?php echo $aFontSize['content']; ?>px;		
				line-height: <?php echo $aFontSize['content'] + 7; ?>px;		
			}
			#menu > ul > li > a {	
				font-size: <?php echo $aFontSize['menu']; ?>px;
			}
			
			h1, #Subheader .title, .text-logo #logo { 
				font-size: <?php echo $aFontSize['h1']; ?>px;
				line-height: <?php echo $aFontSize['h1'] + 0; ?>px;	
			}	
			h2 { 
				font-size: <?php echo $aFontSize['h2']; ?>px;
				line-height: <?php echo $aFontSize['h2'] + 0; ?>px;	
			}	
			h3 {
				font-size: <?php echo $aFontSize['h3']; ?>px;
				line-height: <?php echo $aFontSize['h3'] + 2; ?>px;	
			}	
			h4 {
				font-size: <?php echo $aFontSize['h4']; ?>px;
				line-height: <?php echo $aFontSize['h4'] + 4; ?>px;	
			}	
			h5 {
				font-size: <?php echo $aFontSize['h5']; ?>px;
				line-height: <?php echo $aFontSize['h5'] + 4; ?>px;	
			}	
			h6 {		
				font-size: <?php echo $aFontSize['h6']; ?>px;
				line-height: <?php echo $aFontSize['h6'] + 5; ?>px;	
			}
			
			blockquote { font-size: 14px;}
			.the_content_wrapper ul, .the_content_wrapper ol { font-size: 13px; line-height: 16px; }
			.faq .question .title { font-size: 13px; }
			.pricing-box .plan-header h2 { font-size: 24px; line-height: 24px; }
			.pricing-box .plan-header .price > span { font-size: 34px; line-height: 34px; }
			.pricing-box .plan-header .price sup.currency { font-size: 16px; line-height: 16px; }
			.pricing-box .plan-header .price sup.period { font-size: 13px; line-height: 13px;}
			.offer .offer_li .desc_wrapper .title h3 { font-size: 28px; line-height: 28px; }
			.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 28px; line-height: 28px; }
			.counter .desc_wrapper .number-wrapper { font-size: 40px; line-height: 40px;}
			.counter .desc_wrapper .title { font-size: 13px; line-height: 16px;}
			.chart_box .chart .num { font-size: 40px; line-height: 40px; }
			.trailer_box .desc h2 { font-size: 24px; line-height: 24px; }
			.quick_fact .number { font-size: 70px; line-height: 70px;}
		}
		
		<?php
			// Mobile (Portrait) ------------------------------ < 479
			$min = 13;
			$multiplier = 0.7;
			
			$aFontSize = $aFontSizeDefault;
			foreach( $aFontSize as $k => $v ){	
				$aFontSize[$k] = round( $v * $multiplier );
				if( $aFontSize[$k] < $min ) $aFontSize[$k] = $min;
			}
		?>
		
		@media only screen and (max-width: 479px){
			body {
				font-size: <?php echo $aFontSize['content']; ?>px;		
				line-height: <?php echo $aFontSize['content'] + 7; ?>px;		
			}
			#menu > ul > li > a {	
				font-size: <?php echo $aFontSize['menu']; ?>px;
			}
			
			h1, #Subheader .title, .text-logo #logo { 
				font-size: <?php echo $aFontSize['h1']; ?>px;
				line-height: <?php echo $aFontSize['h1'] + 0; ?>px;	
			}	
			h2 { 
				font-size: <?php echo $aFontSize['h2']; ?>px;
				line-height: <?php echo $aFontSize['h2'] + 0; ?>px;	
			}	
			h3 {
				font-size: <?php echo $aFontSize['h3']; ?>px;
				line-height: <?php echo $aFontSize['h3'] + 2; ?>px;	
			}	
			h4 {
				font-size: <?php echo $aFontSize['h4']; ?>px;
				line-height: <?php echo $aFontSize['h4'] + 3; ?>px;	
			}	
			h5 {
				font-size: <?php echo $aFontSize['h5']; ?>px;
				line-height: <?php echo $aFontSize['h5'] + 3; ?>px;	
			}	
			h6 {		
				font-size: <?php echo $aFontSize['h6']; ?>px;
				line-height: <?php echo $aFontSize['h6'] + 4; ?>px;	
			}
			
			blockquote { font-size: 13px;}
			.the_content_wrapper ul, .the_content_wrapper ol { font-size: 13px; line-height: 16px; }
			.faq .question .title { font-size: 13px; }
			.pricing-box .plan-header h2 { font-size: 21px; line-height: 21px; }
			.pricing-box .plan-header .price > span { font-size: 32px; line-height: 32px; }
			.pricing-box .plan-header .price sup.currency { font-size: 14px; line-height: 14px; }
			.pricing-box .plan-header .price sup.period { font-size: 13px; line-height: 13px;}
			.offer .offer_li .desc_wrapper .title h3 { font-size: 26px; line-height: 26px; }
			.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 26px; line-height: 26px; }
			.counter .desc_wrapper .number-wrapper { font-size: 35px; line-height: 35px;}
			.counter .desc_wrapper .title { font-size: 13px; line-height: 26px;}
			.chart_box .chart .num { font-size: 35px; line-height: 35px; }
			.trailer_box .desc h2 { font-size: 21px; line-height: 21px; }
			.quick_fact .number { font-size: 60px; line-height: 60px;}
		}
		
	<?php endif; ?>

	
/********************** Sidebar | Width **********************/
	
	<?php 
		$sidebarW 	= mfn_opts_get( 'sidebar-width', '23' );
		$contentW 	= 100 - 2 - $sidebarW;	// 100% - wrapper, 2% - 2x margin 1% for sidebar
		$sidebar2W 	= $sidebarW - 5;
		$content2W 	= 100 - 4 - ( $sidebar2W * 2 );
		$sidebar2M 	= $content2W + $sidebar2W + 1;
		$content2M 	= $sidebar2W + 2;
	?>

	.with_aside .sidebar.columns {
		width: <?php echo $sidebarW; ?>%;	
	}
	.with_aside .sections_group {
		width: <?php echo $contentW; ?>%;	
	}
	
	.aside_both .sidebar.columns {
		width: <?php echo $sidebar2W; ?>%;	
	}
	.aside_both .sidebar-1{ 
		margin-left: -<?php echo $sidebar2M; ?>%;
	}
	.aside_both .sections_group {
		width: <?php echo $content2W; ?>%;	
		margin-left: <?php echo $content2M; ?>%;	
	}	
	
	
/********************** Grid | Width **********************/

	<?php if( mfn_opts_get('responsive') && ! mfn_opts_get('grid960') ): ?>

		<?php 
			$gridW = mfn_opts_get( 'grid-width', 1240 );
		?>
		
		@media only screen and (min-width:1240px){
			#Wrapper {
				max-width: <?php echo $gridW; ?>px;
			}	
			.section_wrapper, .container, .with_aside .content_wrapper {
				max-width: <?php echo $gridW - 20; ?>px;
			}
			.layout-boxed.header-boxed #Top_bar.is-sticky{
				max-width: <?php echo $gridW; ?>px;
			}
		}
	
	<?php endif; ?>
