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
    <link rel="stylesheet" href="<?php echo get_home_url();?>/wp-content/plugins/contact-form-7/includes/css/styles.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
            <h1>
                <?php echo $posts_array[0]->post_title;?>
            </h1>
        </section>

        <?php
        // Get your access id and secret key here: https://moz.com/products/api/keys
        $accessID = $reportFields['mozs_api_access_id'];
        $secretKey = $reportFields['mozs_api_secret_key'];

        // Set your expires times for several minutes into the future.
        // An expires time excessively far in the future will not be honored by the Mozscape API.
        $expires = time() + 300;

        // Put each parameter on a new line.
        $stringToSign = $accessID."\n".$expires;

        // Get the "raw" or binary output of the hmac hash.
        $binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);

        // Base64-encode it and then url-encode that.
        $urlSafeSignature = urlencode(base64_encode($binarySignature));

        // Specify the URL that you want link metrics for.
        //$objectURL = "www.seomoz.org";
        $objectURL = $reportFields['client_url'];

        // Add up all the bit flags you want returned.
        // Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
        $cols = "111736266752";

        // Put it all together and you get your request URL.
        // This example uses the Mozscape URL Metrics API.
        $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
        //$requestUrl = "http://lsapi.seomoz.com/linkscape/links/".urlencode($objectURL)."?Scope=pagetopage&Sort=page_authority&Filter=internal+301&Limit=1&SourceCols=536870916&TargetCols= 4&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;

        // Use Curl to send off your request.
        $options = array(
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init($requestUrl);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        $content = json_decode($content, true);
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
                                    <span class='username'>Page Link Metrics</span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->
                            <!--                            <div class='box-body'>-->
                            <!--                                <img class="img-responsive pad" src="--><?php //echo $reportFields['page_metrics_screenshot']['url'];?><!--" alt="--><?php //echo $reportFields['page_metrics_screenshot']['title'];?><!--">-->
                            <!--                            </div>-->
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title username">URL: <?php echo $reportFields['client_url'];?></h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="col-sm-6">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Authority</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-12">
                                                            <p class="title">DOMAIN AUTHORITY</p>
                                                            <p><span class="value"><?php echo (!empty($content['pda'])) ? substr($content['pda'], 0, 4) : 0; ?></span><span> / 100</span></p>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="progress-group">
                                                                <span class="">SPAM SCORE:</span>
                                                                <span class="progress-number"><?php echo (!empty($content['fspsc'])) ? substr($content['fspsc'], 0, 4) : '-'; ?>/17</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <p>PAGE AUTHORITY</p>
                                                        <p><span class="value"><?php echo (!empty($content['upa'])) ? substr($content['upa'], 0, 4) : 0; ?></span><span> /100</span></p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-6">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Page Link Metrics</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-12">
                                                            <p class="title">JUST-DISCOVERED</p>
                                                            <p><span class="value"><?php echo (!empty($content[''])) ? substr($content[''], 0, 4) : 0; ?></span><span> 60 Days</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-12">
                                                            <p class="title">ESTABLISHED LINKS</p>
                                                            <p><span class="value"><?php echo (!empty($content['upl'])) ? substr($content['upl'], 0, 4) : 0; ?></span><span> Root Domains</span></p>
                                                            <p><span class="value"><?php echo (!empty($content['puid'])) ? substr($content['puid'], 0, 4) : 0; ?></span><span> Total Links</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.box -->
                            </div>
                        </div>


                        <div class="box box-widget">
                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Page Link Metrics</span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->
                            <!--                            <div class='box-body'>-->
                            <!--                                <img class="img-responsive pad" src="--><?php //echo $reportFields['page_metrics_screenshot']['url'];?><!--" alt="--><?php //echo $reportFields['page_metrics_screenshot']['title'];?><!--">-->
                            <!--                            </div>-->
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="box-body">
                                        <div class="col-sm-6">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Authority</h3>
                                            </div>
                                            <div class="row">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">DOMAIN AUTHORITY</span>
                                                        <span class="info-box-number"><?php echo (!empty($content['pda'])) ? substr($content['pda'], 0, 4) : 0; ?><small> / 100</small></span>
                                                    </div><!-- /.info-box-content -->
                                                </div><!-- /.info-box -->
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-red"><i class="fa ion-ios-gear-outline"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">SPAM SCORE</span>
                                                        <span class="info-box-number"><?php echo (!empty($content['fspsc'])) ? substr($content['fspsc'], 0, 4) : '-'; ?><small>/17</small></span>
                                                    </div><!-- /.info-box-content -->
                                                </div><!-- /.info-box -->
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-yellow"><i class="fa ion-ios-gear-outline"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">PAGE AUTHORITY</span>
                                                        <span class="info-box-number"><?php echo (!empty($content['upa'])) ? substr($content['upa'], 0, 4) : 0; ?><small>/ 100</small></span>
                                                    </div><!-- /.info-box-content -->
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Page Link Metrics</h3>
                                            </div>
                                            <div class="row">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">JUST-DISCOVERED</span>
                                                        <span class="info-box-number"><?php echo (!empty($content[''])) ? substr($content[''], 0, 4) : 0; ?><small> 60 Days</small></span>
                                                    </div><!-- /.info-box-content -->
                                                </div><!-- /.info-box -->
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">ESTABLISHED LINKS</span>
                                                        <span class="info-box-number"><?php echo (!empty($content['pid'])) ? substr($content['pid'], 0, 4) : 0; ?><small> Root Domains</small></span>
                                                        <span class="info-box-number"><?php echo (!empty($content['puid'])) ? substr($content['puid'], 0, 4) : 0; ?><small> Total Links</small></span>
                                                    </div><!-- /.info-box-content -->
                                                </div><!-- /.info-box -->
                                            </div>
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
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Your website</th>
                                                <th>Your Competitors</th>
                                                <th>Competitors</th>
                                                <th>Competitors link</th>
                                            </tr>
                                            <?php foreach($reportFields['page_specific_metrics'] as $metrics): ?>
                                                <tr>
                                                    <td><span><?php echo $metrics['your_website']; ?></span></td>
                                                    <td class="col-sm-3"><img src="<?php echo $metrics['your_competitors']['url']; ?>" alt="<?php echo $metrics['your_competitors']['title']; ?>"></td>
                                                    <td><span><?php echo $metrics['competitors']; ?></span></td>
                                                    <td><a href="http://<?php echo $metrics['competitors_link']; ?>"><?php echo $metrics['competitors_link']; ?></a></td>
                                                </tr>
                                            <?php endforeach;?>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>



                            <div class="col-md-6">
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
                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Backlinks</span>
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

                                <!--                                <div id="accordion">-->
                                <!--                                    --><?php //foreach($backlinks as $key => $value): ?>
                                <!--                                        --><?php
                                //                                        $title = ucwords(str_replace('backlink', '', str_replace('_', ' ', $key)));
                                //                                        $key = str_replace('_backlink', '', $key);
                                //                                        ?>
                                <!--                                        <p class="accordio-title ui-accordion-header ui-corner-top ui-accordion-header-collapsed ui-corner-all ui-state-default ui-accordion-icons">-->
                                <!--                                            --><?php //echo $title; ?>
                                <!--                                        </p>-->
                                <!--                                        <div>-->
                                <!--                                            <ul>-->
                                <!--                                                --><?php //foreach($value as $v):?>
                                <!--                                                    --><?php //if (preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $v[$key], $matches, PREG_OFFSET_CAPTURE)):?>
                                <!--                                                        <li><a href="--><?php //echo $v[$key]; ?><!--">--><?php //echo $v[$key]; ?><!--</a></li>-->
                                <!--                                                    --><?php //else:?>
                                <!--                                                        <li><p>--><?php //echo $v[$key]; ?><!--</p></li>-->
                                <!--                                                    --><?php //endif;?>
                                <!--                                                --><?php //endforeach;?>
                                <!--                                            </ul>-->
                                <!--                                        </div>-->
                                <!--                                    --><?php //endforeach;?>
                                <!--                                </div>-->


                                <?php $icons = [
                                    '0' => 'ion ion-stats-bars',
                                    '1' => 'fa fa-shopping-cart',
                                    '2' => 'ion ion-person-add',
                                    '3' => 'ion ion-pie-graph',
                                ];
                                $colors = [
                                    '0' => 'bg-aqua',
                                    '1' => 'bg-green',
                                    '2' => 'bg-yellow',
                                    '3' => 'bg-red',
                                ];
                                ?>
                                <?php foreach($backlinks as $key => $value): ?>
                                    <?php
                                    $title = ucwords(str_replace('backlink', '', str_replace('_', ' ', $key)));
                                    $key = str_replace('_backlink', '', $key);
                                    ?>
                                    <div class="col-lg-4 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box <?php echo $colors[ rand ( 0, 3 )];?>">
                                            <div class="inner">
                                                <h3><?php echo count($value);?></h3>
                                                <p><?php echo $title; ?></p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa <?php echo $icons[ rand ( 0, 3 )];?>"></i>
                                            </div>

                                            <div id="<?php echo $key;?>">
                                                <h3>More info<i class="fa fa-arrow-circle-right"></i></h3>
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
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
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

</body>
</html>

