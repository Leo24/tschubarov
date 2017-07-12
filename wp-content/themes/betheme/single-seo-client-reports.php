<?php
/**
 * Template Name: Page SEO Client Report
 * @package WordPress
 *
 */


$string = home_url( $wp->request );
$postName = substr($string , strrpos($string , '/') + 1);

$posts_array = get_posts(
	array(
		'name' => $postName,
		'posts_per_page' => -1,
		'post_type' => 'seo-client-reports',
	)
);
$team_posts = get_posts(
	array(
		'posts_per_page' => -1,
		'post_type' => 'seo-team-members',
	)
);
$tasks_posts = get_posts(
	array(
		'posts_per_page' => -1,
		'post_type' => 'seo-report-task',
	)
);
$postID = $posts_array[0]->ID;
$reportFields = get_fields($postID);
$teamFields = get_fields($team_posts[0]->ID);
$taskFields = get_fields($tasks_posts[0]->ID);
$seoApiCreads = getSeoApiCreads();

$pageSpeedDataBeforeMeta = get_post_meta($posts_array[0]->ID, 'googlePageSpeedDataBefore');
$pageSpeedDataAfterMeta = get_post_meta($posts_array[0]->ID, 'googlePageSpeedDataAfter');
$pageSpeedDataBefore = json_decode($pageSpeedDataBeforeMeta[0], true);
$pageSpeedDataAfter = json_decode($pageSpeedDataAfterMeta[0], true);
$seRankingKeywordsData = keywordStats($reportFields['se_rankins_site_id'], $reportFields['se_keyword_statistics_start_date'], $reportFields['se_keyword_statistics_end_date']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex">
    <title><?php echo $posts_array[0]->post_title;?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/dist/css/jquery-ui.css">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/dist/css/client-seo-reports.css">
    <link rel="stylesheet" href="<?php echo get_home_url();?>/wp-content/plugins/contact-form-7/includes/css/styles.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script>
        (function(w,d,s,g,js,fs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
            js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
        }(window,document,'script'));
    </script>

</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo get_home_url().'/'.$wp->request;?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>SEO</b>Reports</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li><a href="#tabs-1"><i class="fa fa-dashboard"></i><span>Website Status</span></a></li>
                <li><a href="#tabs-2"><i class="fa fa-th"></i><span>Keywords&Rankings</span></a></li>
                <li><a href="#tabs-3"><i class="fa fa-pie-chart"></i><span>Backlinks</span></a></li>
                <li><a href="#tabs-4"><i class="fa fa-share"></i><span>Backlinks - Tier 2&3</span></a></li>
                <li><a href="#tabs-5"><i class="fa fa-book"></i><span>Tasks</span></a></li>
                <li><a href="#tabs-6"><i class="fa fa-twitch"></i><span>Website Health and Status</span></a></li>
                <li><a href="#tabs-7"><i class="fa fa-th"></i><span>Client Details</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				<?php echo $posts_array[0]->post_title;?>
            </h1>
        </section>

		<?php
		$cols = "107443798368";
		$content = get_moz_api_data($seoApiCreads['mozs_api_access_id'], $seoApiCreads['mozs_api_secret_key'], $reportFields['website_url'], $cols);
		?>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div id="tabs">
                    <ul style="display:none;">
                        <li><a href="#tabs-1">Website Status</a></li>
                        <li><a href="#tabs-2">Keywords&Rankings</a></li>
                        <li><a href="#tabs-3">Backlinks</a></li>
                        <li><a href="#tabs-4">Backlinks - Tier 2&3</a></li>
                        <li><a href="#tabs-5">Tasks</a></li>
                        <li><a href="#tabs-6">Website Health and Status</a></li>
                        <li><a href="#tabs-7">Client Details</a></li>
                    </ul>

                    <div id="tabs-1">
                        <div class="box box-widget">
                            <div class='box-header '>
                                <div class='user-block'>
                                    <span class='username'>Authority and Page Link Metrics</span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->

                            <div class="box-body">

                                <div class="row">


                                    <div class="col-lg-2 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box bg-green">
                                            <div class="inner">
                                                <h3><?php echo (!empty($content['pda'])) ? substr($content['pda'], 0, 4) : 0; ?></h3>
                                                <p>Domain Authority</p>

                                            </div>


                                            <div class="icon">
                                                <input type="text" class="knob" value="<?php echo (!empty($content['pda'])) ? substr($content['pda'], 0, 4) : 0; ?>" data-width="80" data-height="80" data-fgColor="#f39c12" data-displayInput="false">

                                                <!--                                                <i class="ion ion-stats-bars"></i>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box bg-yellow">
                                            <div class="inner">
                                                <h3><?php echo (!empty($content['upa'])) ? substr($content['upa'], 0, 4) : 0; ?></h3>
                                                <p>Page Authority</p>
                                            </div>
                                            <div class="icon">
                                                <input type="text" class="knob" value="<?php echo (!empty($content['upa'])) ? substr($content['upa'], 0, 4) : 0; ?>" data-width="80" data-height="80" data-fgColor="#00c0ef" data-displayInput="false">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box bg-red">
                                            <div class="inner">
                                                <h3><?php echo (!empty($content['fspsc'])) ? substr($content['fspsc'], 0, 4) : 0; ?></h3>
                                                <p>Spam Score</p>
                                            </div>
                                            <div class="icon">
                                                <input type="text" class="knob" value="<?php echo (!empty($content['fspsc'])) ? substr($content['fspsc'], 0, 4) : 0; ?>" data-width="80" data-height="80" data-fgColor="#f56954" data-min="0" data-max="17" data-displayInput="false">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box bg-green">
                                            <div class="inner">
                                                <h3><?php echo (!empty($content['pid'])) ? substr($content['pid'], 0, 4) : 0; ?><sup style="font-size: 20px">%</sup></h3>
                                                <p>Root Domains</p>
                                            </div>
                                            <div class="icon">
                                                <input type="text" class="knob" value="<?php echo (!empty($content['pid'])) ? substr($content['pid'], 0, 4) : 0; ?>" data-width="80" data-height="80" data-fgColor="#dd4b39" data-displayInput="false">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box bg-aqua">
                                            <div class="inner">
                                                <h3><?php echo (!empty($content['fuid'])) ? substr($content['fuid'], 0, 4) : 0; ?></h3>
                                                <p>Total links</p>
                                            </div>
                                            <div class="icon">
                                                <input type="text" class="knob" value="<?php echo (!empty($content['fuid'])) ? substr($content['fuid'], 0, 4) : 0; ?>" data-width="80" data-height="80" data-fgColor="#f39c12" data-displayInput="false">
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- /.row -->

                            </div>
                        </div>
                        <div class="box box-widget">
                            <div class='box-header '>
                                <div class='user-block'>
                                    <span class='username'>Visits statistics</span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="embed-api-auth-container"></div>
                                        <div id="chart-container"></div>
                                        <div id="view-selector-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class='box-header '>
                                        <div class='user-block'>
                                            <span class='username'>Competition Analisys</span>
                                        </div><!-- /.user-block -->
                                    </div><!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding competitors">

										<?php
										//Code for rendering Competitors stats

										$competitorsData = array(
											$reportFields['website_url'] => $content
										);
										foreach($reportFields['competitors'] as $metrics){
											$data = get_moz_api_data($seoApiCreads['mozs_api_access_id'], $seoApiCreads['mozs_api_secret_key'], $metrics['competitor_link'], $cols);
											$competitorsData[$metrics['competitor_link']] = $data;
										}

										//array for replacing MOZ API code to human understandable name
										$urlMetrics = array (
											'upa'   => 'Page Authority',
											'umrp'  => 'Domain MozRank',
											'utrp'  => 'MozTrust',
											'fuid'  => 'Links to Subdomain',
											'ueid'  => 'External Equity Links',
											'ujid'  => 'Total Equity Links',
											'ped'   => 'External links to root domain',
											'pib'   => 'Linking C Blocks',
											'fejp'  => 'MozRank: Subdomain, External Equity',
											'feid'  => 'Subdomain External Links',
											'ftrp'  => 'MozTrust: Subdomain',
											'fspsc' => 'Subdomain Spam Score',
											'pda'   => 'Domain Authority',
										);

										//list of needed fields, it is used for removing extra fields that are returned by MOZ API
										$urlMetricsList = array('upa', 'umrp', 'utrp', 'fuid', 'ueid', 'ujid',
                                                                'ped', 'pib', 'fejp', 'feid', 'ftrp', 'fspsc', 'pda');
										$recNew = array();
										foreach($competitorsData as $key => $row) {
											foreach($row as $field => $value) {
												$recNew[$field][] = $value;
											}
										}
										?>

                                        <div class="col-sm-offset-1 col-sm-10">
                                            <table class="table table-bordered table-hover dataTable">
                                                <tr>
                                                    <th class='col-sm-2 left'></th>
													<?php foreach($competitorsData as $k => $v):?>
                                                        <th class='col-sm-2'><a href="<?php echo $k;?>" target="_blank"><?php echo $k;?></a></th>
													<?php endforeach;?>
                                                </tr>


												<?php
												$properOrderedArray = array_merge(array_flip($urlMetricsList), $recNew);

												foreach ($properOrderedArray as $key => $values):?>

													<?php
													$countValues = count($values);
													if($countValues > 1){
														$max = max($values);
                                                    }else{
													    $max = 1;
                                                    }

													if(in_array($key, $urlMetricsList)):?>
														<?php if(is_array($values)):?>
                                                            <tr>
                                                                <td class='col-sm-2 left'><?php echo $urlMetrics[$key];?></td>
																<?php foreach ($values as $cell): ?>
                                                                    <td class='col-sm-2'><p><?php if($cell == $max):?><span class='checked'></span><?php endif;?><span class="<?php if($cell == $max):?>text-green<?php endif;?> <?php if($key == 'upa'):?> bold<?php endif;?>"><?php echo mb_substr($cell, 0, 5); ?></span></p></td>
																<?php endforeach;?>
                                                            </tr>
														<?php endif;?>
													<?php endif;?>
												<?php endforeach;?>
                                            </table>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                            <div class="col-md-4">
                                <!-- USERS LIST -->
                                <div class="box box-primary">
                                    <div class="box-header ">
                                        <h3 class="box-title">Our team</h3>
                                        <div class="box-tools pull-right">
                                            <!--                                                <span class="label label-danger">--><?php //echo count($teamFields['team_member']);?><!-- Team Members</span>-->
                                            <!--                                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
                                            <!--                                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                                        </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body no-padding">
                                        <ul class="users-list clearfix">
											<?php foreach($teamFields['team_member'] as $value):?>
                                                <li>
                                                    <img src="<?php echo $value['picture']['url'];?>" alt="<?php echo $value['picture']['title'];?>">
                                                    <a class="users-list-name" href="#"><?php echo $value['name'];?></a>
<!--                                                    <span class="users-list-date">Today</span>-->
                                                </li>
											<?php endforeach;?>
                                        </ul><!-- /.users-list -->
                                    </div><!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <!--                                            <a href="javascript::" class="uppercase">View All Users</a>-->
                                    </div><!-- /.box-footer -->
                                </div><!--/.box -->
                            </div><!-- /.col -->
                        </div>
                    </div><!-- /.box -->


                    <div id="tabs-2">
                        <!-- Box Comment -->
                        <div class="col-sm-8">
                            <div class='box-header '>
                                <h3 class="box-title">Keywords&Rankings</h3>
                            </div>

                            <div class="box box-widget">
                                <div class='box-body'>
                                    <img class="img-responsive pad" src="<?php echo $reportFields['top_keywords_the_first_3_months']['url'];?>" alt="<?php echo $reportFields['page_metrics_screenshot']['title'];?>">
                                </div><!-- /.box-body -->
                            </div>

                            <div class='box-header'>
                                <h3 class="box-title">Location: <?php echo $reportFields['location'];?></h3>
                            </div>

                            <div class='box-header '>
                                <h3 class="box-title">Google Rankins Date - <?php echo $reportFields['google_rankings_date'];?></h3>
                            </div>

                            <div class="box box-widget">
                                <div class='box-body'>
                                    <img class="img-responsive pad" src="<?php echo $reportFields['google_rankings']['url'];?>" alt="<?php echo $reportFields['page_metrics_screenshot']['title'];?>">
                                </div>
                            </div>

                            <div class='box-header '>
                                <h3 class="box-title">Google Rankings Position:</h3>
                            </div>

							<?php foreach($reportFields['google_rankings_position'] as $position): ?>
                                <div class="box box-widget">
                                    <div class='box-body'>
                                        <span class='description'>Date: <?php echo $position['date']; ?></span>
                                        <img class="img-responsive pad" src="<?php echo $position['google_ranking_screenshot']['url'];?>" alt="<?php echo $reportFields['page_metrics_screenshot']['title'];?>">
                                    </div>
                                </div>
							<?php endforeach;?>

                            <div class="box-header ">
                                <h3 class="box-title">SERankins keywords statistics</h3>
                            </div>
                            <div class="box">
                                <div class="box-body table-responsive no-padding competitors">
									<?php if(is_array($seRankingKeywordsData[0]['keywords']) && !empty($seRankingKeywordsData[0]['keywords'])):?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="col-sm-1">#</th>
                                                <th class="col-sm-2">Keyword name</th>
                                                <th class="col-sm-2">Date</th>
                                                <th class="col-sm-1">Price</th>
                                                <th class="col-sm-1">Change</th>
                                                <th class="col-sm-4">Position</th>
                                            </tr>

											<?php foreach($seRankingKeywordsData[0]['keywords'] as $k => $keyword): ?>
                                                <tr>
                                                    <td class="col-sm-1"><?php echo $k+1; ?></td>
                                                    <td class="col-sm-2"><?php echo $keyword['keyword_name'];?></td>
                                                    <td class="col-sm-2"><?php echo $keyword['positions'][0]['date'];?></td>
                                                    <td class="col-sm-1"><span class="badge bg-light-blue"><?php echo $keyword['positions'][0]['price'];?></span></td>
                                                    <td class="col-sm-1"><span class="badge bg-green"><?php echo $keyword['positions'][0]['change'];?></span></td>
                                                    <td class="col-sm-4">
                                                        <p><span class="badge bg-yellow"><?php echo $keyword['positions'][0]['pos'];?></span></p>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-yellow" style="width: <?php echo $keyword['positions'][0]['pos'];?>%"></div>
                                                        </div>
                                                    </td>
                                                </tr>
											<?php endforeach;?>
                                        </table>
									<?php else:?>
                                        <p>No keywords statistics found, yet.</p>
									<?php endif;?>
                                </div><!-- /.box-body -->
                            </div>

                        </div>
                    </div>
                    <div id="tabs-3">
                        <div class="col-sm-1 col-centered">
                            <h3 class="box-title center-block">Backlinks</h3>
                        </div>

						<?php
						$backlinks = get_post_meta($postID, 'backlinks');
						$backlinks = json_decode($backlinks[0], true);
						?>
                        <div class="box-body">
							<?php $icons = array(
								'0' => 'ion ion-stats-bars',
								'1' => 'fa fa-shopping-cart',
								'2' => 'ion ion-person-add',
								'3' => 'ion ion-pie-graph',
							);
							$colors = array(
								'0' => 'bg-aqua',
								'1' => 'bg-yellow',
								'2' => 'bg-red',
								'3' => 'bg-green',
							);
							$backlinksIcons = array(
								'social_bookmarks_backlink'     => 'fa-bookmark-o',
								'blog_posts_backlink'           => 'fa-rss',
								'document_sharing_backlink'     => 'fa-file-text-o',
								'url_directories_backlink'      => 'fa-book',
								'edu_backlink'                  => 'fa-mortar-board',
								'image_sharing_backlink'        => 'fa-file-picture-o',
								'video_sharing_backlink'        => 'fa-file-movie-o',
								'audio_sharing_backlink'        => 'fa-file-audio-o',
								'infographics_backlink'         => 'fa-calendar',
								'website_feedback_backlink'     => 'fa-twitch',
								'wikis_backlink'                => 'fa-wikipedia-w',
								'classified_backlink'           => 'fa-bullhorn',
								'article_submission_backlink'   => 'fa-edit',
								'local_listings_backlink'       => 'fa-map-marker',
								'web_20_backlink'               => 'fa-globe',
								'ifttt_backlink'                => 'fa-spotify',
								'social_profiles_backlink'      => 'fa-users',
								'number_of_followers_backlink'  => 'fa-calculator',
								'blog_comments_backlink'        => 'fa-commenting',
								'login_details_backlink'        => 'fa-check-square',
							);
							?>

                            <div class="row">
                                <div class="col-sm-8 col-centered">
									<?php $count = 0;?>
									<?php if(is_array($backlinks) && !empty($backlinks)):?>
										<?php foreach($backlinks as $key => $value): ?>
											<?php
											$title = ucwords(str_replace('backlink', '', str_replace('_', ' ', $key)));
											$iconKey = $key;
											$key = str_replace('_backlink', '', $key);
											?>

                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-green box box-default collapsed-box box-backlink">
                                                    <div class="box-header ">
                                                        <span class="info-box-icon"><i class="fa <?php echo $backlinksIcons[$iconKey];?>"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text"><?php echo $title; ?></span>
                                                            <span class="info-box-number"><?php echo count($value);?></span>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: 100%"></div>
                                                            </div>
                                                            <div class="box-tools pull-right">
                                                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                            </div><!-- /.box-tools -->
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div>
                                                            <ul>
																<?php foreach($value as $i => $v):?>
																	<?php $v = strip_tags($v);
																	if (preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $v, $matches, PREG_OFFSET_CAPTURE)):?>
                                                                        <li><a href="<?php echo $v; ?>" target="_blank"><?php echo '<span class="link-number">'.($i+1).'.</span>'.$v; ?></a></li>
																	<?php else:?>
                                                                        <li><a href="#"><?php echo '<span class="link-number">'.($i+1).'.</span>'.$v; ?></a></li>
																	<?php endif;?>
																<?php endforeach;?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<?php $count++; endforeach;?>
									<?php else:?>
                                        <p class="col-md-3 col-sm-4 col-xs-12 col-centered">No baclinks added, yet.</p>
									<?php endif;?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="tabs-4">
                        <div class="box-header">
                            <h3 class="box-title">Backlinks - Tier 2&3</h3>
                        </div>
                        <div class="box box-widget">
							<?php
							$backlinks = array();
							foreach ($reportFields as $key => $value) {
								if(strpos($key, '_backlink')){
									$backlinks[$key] = $value;
								}
							} ?>
                            <div class="box-body">
                                <div class="box-body table-responsive no-padding">
									<?php if(is_array($reportFields['backlinks_-_tier_2_3']) && !empty($reportFields['backlinks_-_tier_2_3'])):?>
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Tier2</th>
                                                <th>Tier3</th>
                                            </tr>
											<?php foreach($reportFields['backlinks_-_tier_2_3'] as $tiers): ?>
                                                <tr>
                                                    <td><?php echo $tiers['tier_2']; ?></td>
                                                    <td><?php echo $tiers['tier_3']; ?></td>
                                                </tr>
											<?php endforeach;?>
                                        </table>
									<?php else:?>
                                        <p>No backlinks added, yet.</p>
									<?php endif;?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>

                    <div id="tabs-5" class="tasks">
                        <div class='box-header '>
                            <h3 class="box-title">Check list</h3>
                        </div>
                        <div class="box box-widget trello-board">

							<?php if(is_array($taskFields['startup_preparation']) && !empty($taskFields['startup_preparation'])):?>
                                <div class="col-md-2 no-padding-right">

                                    <div class="box box-default collapsed-box box-solid">
                                        <div class="box-header ">
                                            <p class="box-title">Startup Preparation</p>
											<?php foreach($taskFields['startup_preparation'] as $value): ?>
                                                <div class="box box-default collapsed-box">
                                                    <div class="box-header  task">
                                                        <span class="info-box-text"><?php echo $value['startup_preparation'];?></span>
                                                    </div><!-- /.box-header -->
                                                </div><!-- /.box -->
											<?php endforeach;?>
                                        </div><!-- /.box-header -->
                                    </div><!-- /.box -->

                                </div>
							<?php endif;?>

							<?php if(is_array($taskFields['on_page_seo']) && !empty($taskFields['on_page_seo'])):?>
                                <div class="col-md-2 no-padding-right">

                                    <div class="box box-default collapsed-box box-solid">
                                        <div class="box-header ">
                                            <p class="box-title">On PAGE SEO</p>
											<?php foreach($taskFields['on_page_seo'] as $value): ?>
                                                <div class="box box-default collapsed-box">
                                                    <div class="box-header  task">
                                                        <span class="info-box-text"><?php echo $value['on_page_seo'];?></span>
                                                    </div><!-- /.box-header -->
                                                </div><!-- /.box -->
											<?php endforeach;?>
                                        </div><!-- /.box-header -->
                                    </div><!-- /.box -->

                                </div>
							<?php endif;?>

							<?php if(is_array($taskFields['off_page_seo']) && !empty($taskFields['off_page_seo'])):?>
                                <div class="col-md-2 no-padding-right">

                                    <div class="box box-default collapsed-box box-solid">
                                        <div class="box-header ">
                                            <p class="box-title">OFF PAGE SEO</p>
											<?php foreach($taskFields['off_page_seo'] as $value): ?>
                                                <div class="box box-default collapsed-box">
                                                    <div class="box-header  task">
                                                        <span class="info-box-text"><?php echo $value['off_page_seo'];?></span>
                                                    </div><!-- /.box-header -->
                                                </div><!-- /.box -->
											<?php endforeach;?>
                                        </div><!-- /.box-header -->
                                    </div><!-- /.box -->

                                </div>
							<?php endif;?>

							<?php if(is_array($taskFields['social_media_tasks']) && !empty($taskFields['social_media_tasks'])):?>
                                <div class="col-md-2 no-padding-right">

                                    <div class="box box-default collapsed-box box-solid">
                                        <div class="box-header ">
                                            <p class="box-title">OFF PAGE SEO</p>
											<?php foreach($taskFields['social_media_tasks'] as $value): ?>
                                                <div class="box box-default collapsed-box">
                                                    <div class="box-header  task">
                                                        <span class="info-box-text"><?php echo $value['social_media_tasks'];?></span>
                                                    </div><!-- /.box-header -->
                                                </div><!-- /.box -->
											<?php endforeach;?>
                                        </div><!-- /.box-header -->
                                    </div><!-- /.box -->

                                </div>
							<?php endif;?>

							<?php if(is_array($taskFields['local_businesses']) && !empty($taskFields['local_businesses'])):?>
                                <div class="col-md-2 no-padding-right">
                                    <div class="box box-default collapsed-box box-solid">
                                        <div class="box-header ">
                                            <p class="box-title">Local Businesses</p>
											<?php foreach($taskFields['local_businesses'] as $value): ?>
                                                <div class="box box-default collapsed-box">
                                                    <div class="box-header  task">
                                                        <span class="info-box-text"><?php echo $value['local_businesses'];?></span>
                                                    </div><!-- /.box-header -->
                                                </div><!-- /.box -->
											<?php endforeach;?>
                                        </div><!-- /.box-header -->
                                    </div><!-- /.box -->

                                </div>
							<?php endif;?>

							<?php if(empty($taskFields['startup_preparation']) && empty($taskFields['on_page_seo']) && empty($taskFields['off_page_seo']) && empty($taskFields['local_businesses']) && empty($taskFields['social_media_tasks'])):?>
                                <div class="col-md-12">
                                    <div class="box box-default collapsed-box box-solid">
                                        <div class="box-header  task">
                                            <h3 class="box-title col-md-8 padding-top-2">No tasks added yet.</h3>
                                        </div>
                                    </div>
                                </div>
							<?php endif;?>

                            <div class="box-body">
                                <div class="box-body table-responsive no-padding">
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>

                    <div id="tabs-6">

                        <div class="row margin-bottom-80">
                            <div class='box-header'>
                                <h3 class="box-title">Website Health and Status</h3>
                            </div>
                            <div class="col-md-12 reports">
                                <div class="col-md-6 report before">
                                    <div class="box-header ">
                                        <h3 class="box-title">Before <?php echo $reportFields['date_before']; ?></h3>
                                    </div>
                                    <object data="<?php echo $reportFields['report_before']['url']; ?>" type="application/pdf" width="100%" height="100%">
                                        <p><?php echo $reportFields['report_before']['title']; ?><a href="<?php echo $reportFields['report_before']['url']; ?>">to the PDF!</a></p>
                                    </object>
                                </div>
                                <div class="col-md-6 report after">
                                    <div class="box-header ">
                                        <h3 class="box-title">After <?php echo $reportFields['date_after']; ?></h3>
                                    </div>
                                    <object data="<?php echo $reportFields['report_after']['url']; ?>" type="application/pdf" width="100%" height="100%">
                                        <p><?php echo $reportFields['report_before']['title']; ?><a href="<?php echo $reportFields['report_before']['url']; ?>">to the PDF!</a></p>
                                    </object>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class='box-header '>
                                <h3 class="box-title">Google PageSpeed Insights</h3>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 ">
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">General Page Speed before optimization</span>
                                        <span class="info-box-number"><?php echo $pageSpeedDataBefore['ruleGroups']['SPEED']['score'];?>%</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $pageSpeedDataBefore['ruleGroups']['SPEED']['score'];?>%"></div>
                                        </div>
                                        <span class="progress-description"></span>
                                    </div><!-- /.info-box-content -->
                                </div><!-- /.info-box -->

                                <div class="box box-widget widget-user-2">
                                    <h3 class="widget-user-desc">Possible Optimizations</h3>
                                    <div class="box-footer no-padding">
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
												<?php if(is_array($pageSpeedDataBefore['formattedResults']['ruleResults']) && !empty($pageSpeedDataBefore['formattedResults']['ruleResults'])):?>
													<?php foreach($pageSpeedDataBefore['formattedResults']['ruleResults'] as $k=> $v):?>
                                                        <li><a href="#"><?php echo $v['localizedRuleName'];?><span class="pull-right badge <?php if($v['ruleImpact'] > 2){echo 'bg-red';}else{echo 'bg-yellow';} ?>"><?php echo $v['ruleImpact'];?></span></a></li>
													<?php endforeach;?>
												<?php else:?>
                                                    <li><a href="#">No Pagespeed data found yet.</a></li>
												<?php endif;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-widget widget-user-2">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <h3 class="widget-user-desc">Google Page Stats</h3>
                                    <div class="box-footer no-padding">
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
												<?php if(is_array($pageSpeedDataBefore['pageStats']) && !empty($pageSpeedDataBefore['pageStats'])):?>
													<?php foreach($pageSpeedDataBefore['pageStats'] as $k=> $v):?>
                                                        <li><a href="#"><?php echo $k;?><span class="pull-right badge bg-yellow"><?php echo $v;?></span></a></li>
													<?php endforeach;?>
												<?php else:?>
                                                    <li><a href="#">No Page Statistics data found yet.</a></li>
												<?php endif;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="info-box bg-green">
                                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">General Page Speed after optimization</span>
                                        <span class="info-box-number"><?php echo $pageSpeedDataAfter['ruleGroups']['SPEED']['score'];?>%</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $pageSpeedDataAfter['ruleGroups']['SPEED']['score'];?>%"></div>
                                        </div>
                                        <span class="progress-description"></span>
                                    </div><!-- /.info-box-content -->
                                </div><!-- /.info-box -->
                                <div class="box box-widget widget-user-2">
                                    <h3 class="widget-user-desc">Possible Optimizations</h3>
                                    <div class="box-footer no-padding">
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
												<?php if(is_array($pageSpeedDataAfter['formattedResults']['ruleResults']) && !empty($pageSpeedDataAfter['formattedResults']['ruleResults'])):?>
													<?php foreach($pageSpeedDataAfter['formattedResults']['ruleResults'] as $k=> $v):?>
                                                        <li><a href="#"><?php echo $v['localizedRuleName'];?><span class="pull-right badge <?php if($v['ruleImpact'] > 2){echo 'bg-yellow';}else{echo 'bg-green';} ?>"><?php echo $v['ruleImpact'];?></span></a></li>
													<?php endforeach;?>
												<?php else:?>
                                                    <li><a href="#">No optimized Pagespeed data found yet.</a></li>
												<?php endif;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-widget widget-user-2">

                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <h3 class="widget-user-desc">Google Page Stats</h3>
                                    <div class="box-footer no-padding">
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
												<?php if(is_array($pageSpeedDataAfter['pageStats']) && !empty($pageSpeedDataAfter['pageStats'])):?>
													<?php foreach($pageSpeedDataAfter['pageStats'] as $k=> $v):?>
                                                        <li><a href="#"><?php echo $k;?><span class="pull-right badge bg-green"><?php echo $v;?></span></a></li>
													<?php endforeach;?>
												<?php else:?>
                                                    <li><a href="#">No optimized Page Statistics data found yet.</a></li>
												<?php endif;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
						<?php
						$backlinks = array();
						foreach ($reportFields as $key => $value) {
							if(strpos($key, '_backlink')){
								$backlinks[$key] = $value;
							}
						} ?>

                    </div>
                    <div id="tabs-7">
                        <div class='box-header'>
                            <h3 class="box-title">Client Details</h3>
                        </div>
<!--                        <div class="box">-->
							<?php render_profile_details_form();?>
<!--                        </div>-->
                    </div>
                </div>
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>© 2017 youngceaser.com.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-user bg-yellow"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript::;">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript::;">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript::;">
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

            </div><!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                            Some information about this general settings option
                        </p>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Allow mail redirect
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                            Other sets of options are available
                        </p>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div><!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div><!-- /.form-group -->
                </form>
            </div><!-- /.tab-pane -->
        </div>
    </aside><!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
		 immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports/';?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports/';?>bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports/';?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo get_template_directory_uri().'/seo-client-reports/';?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports/';?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports/';?>plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<!--<script src="--><?php //echo get_template_directory_uri().'/seo-client-reports/';?><!--dist/js/app.min.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports/';?>dist/js/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
//        $("#example1").DataTable();
//        $('#example2').DataTable({
//            "paging": true,
//            "lengthChange": false,
//            "searching": false,
//            "ordering": true,
//            "info": true,
//            "autoWidth": false
//        });
    });
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Slimscroll -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/dist/js/demo.js"></script>
<!-- jQuery Knob -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/knob/jquery.knob.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/chartjs/Chart.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/iCheck/icheck.js"></script>
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/jQuery-Plugin-To-Enlarge-Images-On-Mouseover-image-tooltip-js/image-tooltip.js"></script>
<script src="<?php echo get_template_directory_uri().'/seo-client-reports';?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script type='text/javascript' src='<?php echo get_home_url();?>/wp-content/plugins/contact-form-7/includes/js/jquery.form.min.js?ver=3.40.0-2013.08.13'></script>
<script type='text/javascript'>
    /* <![CDATA[ */
    var _wpcf7 = {"loaderUrl":"<?php echo get_home_url();?>\/wp-content\/plugins\/contact-form-7\/images\/ajax-loader.gif","sending":"Sending ..."};
    /* ]]> */
</script>
<script type='text/javascript' src='<?php echo get_home_url();?>/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=3.5.2'></script>

<script>
	<?php foreach($backlinks as $key => $value): ?>
	<?php $key = str_replace('_backlink', '', $key);?>
    $( function() {
        $( "#<?php echo $key;?>" ).accordion({
            active: false,
            collapsible: true
        });
    } );
	<?php endforeach;?>
</script>

<script>
    $( function() {
        $( "#tabs" ).tabs();
    } );
    $(document).ready(function () {
        $('.sidebar-menu li').on('click', function (e) {
            e.preventDefault();
            var self = $(this);
            $('.sidebar-menu li').each(function () {
                $(this).removeClass('active')
            });
            self.addClass('active');
            var href = self.find('a').attr('href');
            $('#tabs ul li a').each(function( index, value ) {
                if($(this).attr('href') === href) {
                    $(this).click();
                }
            });
        });
    });
</script>

<script>
    $(function () {
        /* jQueryKnob */

        $(".knob").knob({
            'readOnly': true
        });
        /* END JQUERY KNOB */
    });

</script>

<script>

    var CLIENT_ID = '<?php echo $seoApiCreads['google_oauth_20_client_id'];?>';
    //    var CLIENT_ID = '';

    gapi.analytics.ready(function() {

        /**
         * Authorize the user immediately if the user has already granted access.
         * If no access has been created, render an authorize button inside the
         * element with the ID "embed-api-auth-container".
         */
        gapi.analytics.auth.authorize({
            container: 'embed-api-auth-container',
            clientid: CLIENT_ID
        });


        /**
         * Create a new ViewSelector instance to be rendered inside of an
         * element with the id "view-selector-container".
         */
        var viewSelector = new gapi.analytics.ViewSelector({
            container: 'view-selector-container'
        });

        // Render the view selector to the page.
        viewSelector.execute();


        /**
         * Create a new DataChart instance with the given query parameters
         * and Google chart options. It will be rendered inside an element
         * with the id "chart-container".
         */
        var dataChart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:sessions',
                dimensions: 'ga:date',
                'start-date': '30daysAgo',
                'end-date': 'yesterday'
            },
            chart: {
                container: 'chart-container',
                type: 'LINE',
                options: {
                    width: '100%'
                }
            }
        });


        /**
         * Render the dataChart on the page whenever a new view is selected.
         */
        viewSelector.on('change', function(ids) {
            dataChart.set({query: {ids: ids}}).execute();
        });
        gapi.analytics.auth.on('success', function(response) {
            $('#embed-api-auth-container').css('display', 'none');
        });


    });
</script>

<script>
    //    Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_square-green'
    });
</script>
<script>
    $(document).ready(function () {
        $('.task-image').imageTooltip({
            imgWidth: 600
        });
    });
</script>

<script>
    jQuery(function($){
        $( document ).ready(function(){
            getProfileDetails();

            $(".wpcf7").on('wpcf7:submit', function(event){
                getProfileDetails();

            });

        });
    });

    function getProfileDetails(){
        var url = '<?php echo get_home_url() . '/wp-admin/admin-ajax.php';?>',
            postID = '<?php echo $postID;?>';
            
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {
                action: 'get_user_profile_details',
                postID: postID
            },
            success: function (data) {
                $.each(data,  function( key, value ) {
                    $('.wpcf7 form input[name='+key+']').val(value);
                });
                $.each(data,  function( key, value ) {
                    $('.wpcf7 form textarea[name='+key+']').val(value);
                });

                var text1 = data['bought_package'];
                $(".wpcf7 form select option").filter(function() {
                    return $(this).text() == text1;
                }).attr('selected', true);
            }
        });
    }
</script>

<script>
    $(function () {
        //bootstrap WYSIHTML5 - text editor
        $("textarea").wysihtml5();
    });
</script>


</body>
</html>
