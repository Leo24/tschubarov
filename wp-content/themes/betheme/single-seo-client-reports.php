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

$reportFields = get_fields($posts_array[0]->ID);
$teamFields = get_fields($team_posts[0]->ID);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $posts_array[0]->post_title;?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="google-signin-client_id" content="289130753296-9j0uivsjiu461460ugm1gitltralntu8.apps.googleusercontent.com">

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


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<!--    <script src="https://apis.google.com/js/platform.js" async defer></script>-->


<!--    <script>-->
<!--        function onSignIn(googleUser) {-->
<!--            var profile = googleUser.getBasicProfile();-->
<!--            var id_token = googleUser.getAuthResponse().id_token;-->
<!--            console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.-->
<!--            console.log('Name: ' + profile.getName());-->
<!--            console.log('Image URL: ' + profile.getImageUrl());-->
<!--            console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.-->
<!--            var xhr = new XMLHttpRequest();-->
<!---->
<!--            var data = "action=seoGoogleAnalitics&id_token="+id_token;-->
<!--            xhr.open('POST', '--><?php //echo get_home_url().'/wp-admin/admin-ajax.php';?><!--', true);-->
<!--            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');-->
<!--            xhr.onload = function() {-->
<!--                console.log('Signed in as: ' + xhr.responseText);-->
<!--            };-->
<!--            xhr.send(data);-->
<!---->
<!--        }-->
<!--    </script>-->

<!--    <script>-->
<!--        function signOut() {-->
<!--            var auth2 = gapi.auth2.getAuthInstance();-->
<!--            auth2.signOut().then(function () {-->
<!--                console.log('User signed out.');-->
<!--            });-->
<!--        }-->
<!--    </script>-->



</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo get_template_directory_uri().'/seo-client-reports';?>/index2.html" class="logo">
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
                <li><a href="#tabs-6"><i class="fa fa-edit"></i><span>Contact form for Seo Reports</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="pull-right"><button class="btn btn-success" id="auth-button">Authorize to Google Account</button></div>
            <h1>
				<?php echo $posts_array[0]->post_title;?>
            </h1>





            <textarea cols="80" rows="20" id="query-output"></textarea>




        </section>

		<?php
		$cols = "111736266752";
		$content = get_moz_api_data($reportFields['mozs_api_access_id'], $reportFields['mozs_api_secret_key'], $reportFields['client_url'], $cols);
		?>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Website Status</a></li>
                        <li><a href="#tabs-2">Keywords&Rankings</a></li>
                        <li><a href="#tabs-3">Backlinks</a></li>
                        <li><a href="#tabs-4">Backlinks - Tier 2&3</a></li>
                        <li><a href="#tabs-5">Tasks</a></li>
                        <li><a href="#tabs-6">Contact form for Seo Reports</a></li>
                    </ul>

                    <div id="tabs-1">
                        <div class="box box-widget">
                            <div class='box-header with-border'>
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

                        <div class="row">
                            <div class="col-md-7">
                                <!-- AREA CHART -->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Area Chart</h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="chart">
                                            <canvas id="areaChart" style="height:250px"></canvas>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Website Status</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding competitors">

										<?php
										//Code for rendering Competitors stats

										$cols = "107443798368";
										$competitorsData = array(
											'default' => $content
										);
										foreach($reportFields['competitors'] as $metrics){
											$data = get_moz_api_data($reportFields['mozs_api_access_id'], $reportFields['mozs_api_secret_key'], $metrics['competitor_link'], $cols);
											$competitorsData[$metrics['competitor_link']] = $data;
										}

										//array for replacing MOZ API code to human understandable name
										$urlMetrics = [
											'pda'   => 'Domain Authority',
											'umrp'  => 'Domain MozRank',
											'utrp'  => 'MozTrust',
											'fuid'  => 'Links to Subdomain',
											'ueid'  => 'External Equity Links',
											'ujid'  => 'Total Equity Links',
											'ped'   => 'External links to root domain',
											'pib'   => 'Linking C Blocks',
											'upa'   => 'Page Authority',
											'fejp'  => 'MozRank: Subdomain, External Equity',
											'ftrp'  => 'MozTrust: Subdomain',
											'fspsc' => 'Subdomain Spam Score',
											'feid'  => 'Subdomain External Links'
										];


										//list of needed fields, it is used for removing extra fields that are returned by MOZ API
										$urlMetricsList = ['pda', 'umrp', 'utrp', 'fuid', 'ueid', 'ujid', 'ped', 'pib', 'upa', 'fejp', 'ftrp', 'fspsc', 'feid'];

										foreach($competitorsData as $key => $row) {
											foreach($row as $field => $value) {
												$recNew[$field][] = $value;
											}
										}

										echo "<table class=\"table table-hover\">\n

                                        <tr>
                                                <th>Params\Competitors</th>";
										foreach($competitorsData as $k => $v){
											echo "<th><a href=$k target=\"_blank\">$k</a></th>";
										}
										echo "</tr>";

										foreach ($recNew as $key => $values) // For every field name (id, name, last_name, gender)
										{
											$max = max($values);
											if(in_array($key, $urlMetricsList)){
												echo "<tr>\n"; // start the row
												echo "\t<td>" . $urlMetrics[$key] . "</td>\n" ; // create a table cell with the field name
												foreach ($values as $cell) // for every sub-array iterate through all values
												{
													if($cell == $max){
														echo "\t<td><p><span class='checked'></span><span class=text-green>" . mb_substr($cell, 0, 5) . "</span></p></td>\n"; // write cells next to each other
													}
													else{
														echo "\t<td><p>" . mb_substr($cell, 0, 5) . "</p></td>\n"; // write cells next to each other
													}
												}
												echo "</tr>\n"; // end row
											}
										}
										echo "</table>";
										?>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                            <div class="col-md-4">
                                <!-- USERS LIST -->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
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
                                                    <span class="users-list-date">Today</span>
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
                        <div class="box box-widget">
                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Keywords&Rankings</span>
                                </div><!-- /.user-block -->

                            </div><!-- /.box-header -->
                            <div class='box-body'>
                                <img class="img-responsive pad" src="<?php echo $reportFields['top_keywords_the_first_3_months']['url'];?>" alt="<?php echo $reportFields['page_metrics_screenshot']['title'];?>">
                            </div><!-- /.box-body -->

                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Location: <?php echo $reportFields['location'];?></span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->

                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Google Rankins</span>
                                    <span class='description'>Date - <?php echo $reportFields['google_rankings_date'];?></span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->
                            <div class='box-body'>
                                <img class="img-responsive pad" src="<?php echo $reportFields['google_rankings']['url'];?>" alt="<?php echo $reportFields['page_metrics_screenshot']['title'];?>">
                            </div><!-- /.box-body -->

                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Google Rankings Position</span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->

							<?php foreach($reportFields['google_rankings_position'] as $position): ?>
                                <div class='box-body'>
                                    <span class='description'>Date: <?php echo $position['date']; ?></span>
                                    <img class="img-responsive pad" src="<?php echo $position['google_ranking_screenshot']['url'];?>" alt="<?php echo $reportFields['page_metrics_screenshot']['title'];?>">
                                </div><!-- /.box-body -->
							<?php endforeach;?>
                        </div><!-- /.box -->
                    </div>
                    <div id="tabs-3">

                        <div class="box box-widget">
                            <div class="col-sm-1 col-centered">
                                <h3 class="box-title center-block">Backlinks</h3>
                            </div>

							<?php
							$backlinks = array();
							foreach ($reportFields as $key => $value) {
								if(strpos($key, '_backlink')){
									$backlinks[$key] = $value;
								}
							} ?>
                            <div class="box-body">

								<?php $icons = [
									'0' => 'ion ion-stats-bars',
									'1' => 'fa fa-shopping-cart',
									'2' => 'ion ion-person-add',
									'3' => 'ion ion-pie-graph',
								];
								$colors = [
									'0' => 'bg-aqua',
									'1' => 'bg-yellow',
//                                    '2' => 'bg-red',
//                                    '3' => 'bg-green',
								];
								?>
                                <div class="row">
                                    <div class="col-sm-8 col-centered">

										<?php foreach($backlinks as $key => $value): ?>
											<?php
											$title = ucwords(str_replace('backlink', '', str_replace('_', ' ', $key)));
											$key = str_replace('_backlink', '', $key);
											?>


                                            <div class="col-md-4">
                                                <div class="box box-default collapsed-box box-backlink small-box">
                                                    <div class="box-header with-border">
                                                        <div class="icon">
                                                            <i class="fa <?php echo $icons[ rand ( 0, 3 )];?>"></i>
                                                        </div>

                                                        <p>
                                                            <span><?php echo $title; ?></span>
                                                        </p>
                                                        <p>
                                                            <span>Backlinks count:<?php echo count($value);?></span>
                                                        </p>

                                                        <div class="box-tools pull-right">
                                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                        </div><!-- /.box-tools -->
                                                    </div><!-- /.box-header -->
                                                    <div class="box-body">
                                                        <div>
                                                            <ul>
																<?php foreach($value as $v):?>
																	<?php if (preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $v[$key], $matches, PREG_OFFSET_CAPTURE)):?>
                                                                        <li><a href="<?php echo $v[$key]; ?>"><?php echo $v[$key]; ?></a></li>
																	<?php else:?>
                                                                        <li><?php echo $v[$key]; ?></li>
																	<?php endif;?>
																<?php endforeach;?>
                                                            </ul>
                                                        </div>
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            </div><!-- /.col -->


										<?php endforeach;?>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div>
                    <div id="tabs-4">
                        <div class="box box-widget">
                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Backlinks - Tier 2&3</span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->

							<?php
							$backlinks = array();
							foreach ($reportFields as $key => $value) {
								if(strpos($key, '_backlink')){
									$backlinks[$key] = $value;
								}
							} ?>
                            <div class="box-body">
                                <div class="box-body table-responsive no-padding">
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
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>

                    <div id="tabs-5">
                        <div class="box box-widget">
                            <div class="col-md-3">
                                <h3 class="box-title text-center">Startup Preparation</h3>
								<?php foreach($reportFields['startup_preparation'] as $value): ?>
                                    <div class="col-md-12">
                                        <div class="box box-default collapsed-box box-solid">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><?php echo $value['startup_preparation'];?></h3>
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <p>Doing by:<?php echo $value['doing'];?></p>
                                                <p>Notes:<?php echo $value['notes'];?></p>
                                                <p>Status:<?php echo $value['status'];?></p>
                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->
                                    </div>
								<?php endforeach;?>
                            </div>
                            <div class="col-md-3">
                                <h3 class="box-title text-center">On PAGE SEO</h3>
								<?php foreach($reportFields['on_page_seo'] as $value): ?>
                                    <div class="col-md-12">
                                        <div class="box box-default collapsed-box box-solid">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><?php echo $value['on_page_seo'];?></h3>
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <p>Doing by:<?php echo $value['doing'];?></p>
                                                <p>Notes:<?php echo $value['notes'];?></p>
                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->
                                    </div>
								<?php endforeach;?>
                            </div>
                            <div class="col-md-3">
                                <h3 class="box-title text-center">OFF PAGE SEO</h3>
								<?php foreach($reportFields['off_page_seo'] as $value): ?>
                                    <div class="col-md-12">
                                        <div class="box box-default collapsed-box box-solid">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><?php echo $value['off_page_seo'];?></h3>
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <p>Doing by:<?php echo $value['doing'];?></p>
                                                <p>Notes:<?php echo $value['amount'];?></p>
                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->
                                    </div>
								<?php endforeach;?>
                            </div>
                            <div class="col-md-3">
                                <h3 class="box-title text-center">Local Businesses</h3>
								<?php foreach($reportFields['local_businesses'] as $value): ?>
                                    <div class="col-md-12">
                                        <div class="box box-default collapsed-box box-solid">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><?php echo $value['local_businesses'];?></h3>
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <p>Doing by:<?php echo $value['doing'];?></p>
                                                <p>Notes:<?php echo $value['status'];?></p>
                                                <p>Notes:<?php echo $value['link'];?></p>
                                                <p>Notes:<?php echo $value['social_media'];?></p>
                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->
                                    </div>
								<?php endforeach;?>
                            </div>
                            <div class="box-body">
                                <div class="box-body table-responsive no-padding">
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                    <div id="tabs-6">
                        <div class="box box-widget">

                            <!--                            --><?php //echo do_shortcode('[contact-form-7 id="6" title="Contact form for Contact page" html_class="np-form"]');?>
                            <div class="col-sm-6">
								<?php echo do_shortcode('[contact-form-7 id="135822" title="Contact form for Seo Reports" html_class="use-floating-validation-tip"]');?>
                            </div>
                            <div class="box-body">
                                <div class="box-body table-responsive no-padding">
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
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
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas);

        var areaChartData = {
            labels: Last7Days(),
//            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
//                {
//                    label: "Electronics",
//                    fillColor: "rgba(210, 214, 222, 1)",
//                    strokeColor: "rgba(210, 214, 222, 1)",
//                    pointColor: "rgba(210, 214, 222, 1)",
//                    pointStrokeColor: "#c1c7d1",
//                    pointHighlightFill: "#fff",
//                    pointHighlightStroke: "rgba(220,220,220,1)",
//                    data: [65, 59, 80, 81, 56, 55, 40]
//                },
                {
                    label: "Digital Goods",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [28, 48, 40, 19, 86, 27, 90]
                }
            ]
        };

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions);



    });
</script>

<script>

    // Replace with your client ID from the developer console.
//    var CLIENT_ID = '289130753296-9j0uivsjiu461460ugm1gitltralntu8.apps.googleusercontent.com';
    var CLIENT_ID = '289130753296-qmn59qkqkb8bhasqorbjsfeu53fufd4v.apps.googleusercontent.com';

    // Set authorized scope.
    var SCOPES = ['https://www.googleapis.com/auth/analytics.readonly'];


    function authorize(event) {
        // Handles the authorization flow.
        // `immediate` should be false when invoked from the button click.
        var useImmdiate = event ? false : true;
        var authData = {
            client_id: CLIENT_ID,
            scope: SCOPES,
            immediate: useImmdiate
        };

        gapi.auth.authorize(authData, function(response) {
            var authButton = document.getElementById('auth-button');
            if (response.error) {
                authButton.style.display = 'block';
            }
            else {
                authButton.style.display = 'none';
                queryAccounts();
            }
        });
    }


    function queryAccounts() {
        // Load the Google Analytics client library.
        gapi.client.load('analytics', 'v3').then(function() {

            // Get a list of all Google Analytics accounts for this user
            gapi.client.analytics.management.accounts.list().then(handleAccounts);
        });
    }


    function handleAccounts(response) {
        // Handles the response from the accounts list method.
        if (response.result.items && response.result.items.length) {
            // Get the first Google Analytics account.
            var firstAccountId = response.result.items[0].id;

            // Query for properties.
            queryProperties(firstAccountId);
        } else {
            console.log('No accounts found for this user.');
        }
    }


    function queryProperties(accountId) {
        // Get a list of all the properties for the account.
        gapi.client.analytics.management.webproperties.list(
            {'accountId': accountId})
            .then(handleProperties)
            .then(null, function(err) {
                // Log any errors.
                console.log(err);
            });
    }


    function handleProperties(response) {
        // Handles the response from the webproperties list method.
        if (response.result.items && response.result.items.length) {

            // Get the first Google Analytics account
            var firstAccountId = response.result.items[0].accountId;

            // Get the first property ID
            var firstPropertyId = response.result.items[0].id;

            // Query for Views (Profiles).
            queryProfiles(firstAccountId, firstPropertyId);
        } else {
            console.log('No properties found for this user.');
        }
    }


    function queryProfiles(accountId, propertyId) {
        // Get a list of all Views (Profiles) for the first property
        // of the first Account.
        gapi.client.analytics.management.profiles.list({
            'accountId': accountId,
            'webPropertyId': propertyId
        })
            .then(handleProfiles)
            .then(null, function(err) {
                // Log any errors.
                console.log(err);
            });
    }


    function handleProfiles(response) {
        // Handles the response from the profiles list method.
        if (response.result.items && response.result.items.length) {
            // Get the first View (Profile) ID.
            var firstProfileId = response.result.items[0].id;

            // Query the Core Reporting API.
            queryCoreReportingApi(firstProfileId);
        } else {
            console.log('No views (profiles) found for this user.');
        }
    }


    function queryCoreReportingApi(profileId) {
        // Query the Core Reporting API for the number sessions for
        // the past seven days.
        gapi.client.analytics.data.ga.get({
            'ids': 'ga:' + profileId,
            'start-date': '7daysAgo',
            'end-date': 'today',
            'metrics': 'ga:sessions',
            'dimensions' : 'ga:source,ga:keyword',
            'sort' : '-ga:sessions,ga:source',
            'filters' : 'ga:medium==organic',
            'max-results' : '25'


        })
            .then(function(response) {
                var formattedJson = JSON.stringify(response.result, null, 2);
                document.getElementById('query-output').value = formattedJson;












            })
            .then(null, function(err) {
                // Log any errors.
                console.log(err);
            });
    }

    // Add an event listener to the 'auth-button'.
    document.getElementById('auth-button').addEventListener('click', authorize);

    function formatDate(date){
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var dd = date.getDate();
        var mm = date.getMonth()+1;
        if(dd<10) {dd='0'+dd}
        date = dd + '' + monthNames[mm];
        return date
    }



    function Last7Days () {
        var result = [];
        for (var i=0; i<7; i++) {
            var d = new Date();
            d.setDate(d.getDate() - i);
            result.push(formatDate(d))
        }
        return result.reverse();
    }

</script>

<script src="https://apis.google.com/js/client.js?onload=authorize"></script>



</body>
</html>
