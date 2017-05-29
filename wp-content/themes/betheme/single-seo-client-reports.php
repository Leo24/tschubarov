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

$reportFields = get_fields($posts_array[0]->ID);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Data Tables</title>
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
                                <li><a href="#tabs-1"><span>Website Status</span></a></li>
                                <li><a href="#tabs-2"><span>Keywords&Rankings</span></a></li>
                                <li><a href="#tabs-3"><span>Backlinks</span></a></li>
                                <li><a href="#tabs-4"><span>Backlinks - Tier 2&3</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data Tables
                <small>advanced tables</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Website Status</a></li>
                        <li><a href="#tabs-2">Keywords&Rankings</a></li>
                        <li><a href="#tabs-3">Backlinks</a></li>
                        <li><a href="#tabs-4">Backlinks - Tier 2&3</a></li>
                    </ul>
                    <div id="tabs-1">
                        <div class="box box-widget">
                            <div class='box-header with-border'>
                                <div class='user-block'>
                                    <span class='username'>Page Link Metrics</span>
                                </div><!-- /.user-block -->
                            </div><!-- /.box-header -->
                            <div class='box-body'>
                                <img class="img-responsive pad" src="<?php echo $reportFields['page_metrics_screenshot']['url'];?>" alt="<?php echo $reportFields['page_metrics_screenshot']['title'];?>">
                            </div><!-- /.box-body -->

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
                                                </tr>
                                                <?php foreach($reportFields['page_specific_metrics'] as $metrics): ?>
                                                    <tr>
                                                        <td><a href="http://<?php echo $metrics['your_website']; ?>"><?php echo $metrics['your_website']; ?></a></td>
                                                        <td><a href="http://<?php echo $metrics['your_competitors']; ?>"><?php echo $metrics['your_competitors']; ?></a></td>
                                                        <td><a href="http://<?php echo $metrics['competitors']; ?>"><?php echo $metrics['competitors']; ?></a></td>
                                                    </tr>
                                                <?php endforeach;?>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div>
                            </div>
                        </div><!-- /.box -->
                    </div>
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
                        <div class="box">
                            <?php
                            $backlinks = [];
                            foreach ($reportFields as $key => $value) {
                                if(strpos($key, '_backlink')){
                                    $backlinks[$key] = $value;
                                }
                            } ?>
                            <div class="box-body">
                                <div id="accordion">
                                    <?php foreach($backlinks as $key => $value): ?>
                                        <?php
                                        $title = ucwords(str_replace('backlink', '', str_replace('_', ' ', $key)));
                                        $key = str_replace('_backlink', '', $key);
                                        ?>
                                        <p class="accordio-title ui-accordion-header ui-corner-top ui-accordion-header-collapsed ui-corner-all ui-state-default ui-accordion-icons">
                                            <?php echo $title; ?>
                                        </p>
                                        <div>
                                            <ul>
                                                <?php foreach($value as $v):?>
                                                    <?php if (preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $v[$key], $matches, PREG_OFFSET_CAPTURE)):?>
                                                        <li><a href="<?php echo $v[$key]; ?>"><?php echo $v[$key]; ?></a></li>
                                                    <?php else:?>
                                                        <li><p><?php echo $v[$key]; ?></p></li>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                    <div id="tabs-4">
                        <div class="box box-widget">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">Backlinks - Tier 2&3</h3>
                                        </div><!-- /.box-header -->
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
                                    </div><!-- /.box -->
                                </div>
                            </div>
                        </div><!-- /.box -->
                    </div>
                </div>
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
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
<script>
    //    $( function() {
    //        $( "#accordion" ).accordion({
    //            active: false,
    //            collapsible: true
    //        });
    //    } );
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

