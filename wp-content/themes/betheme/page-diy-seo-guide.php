<?php get_header(); ?>

<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="/assets/css/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="/assets/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="/assets/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="/assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="/assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/4.10.0/css/bootstrap-slider.min.css" />
<link href="/assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />


<?php
$counts = array();
ob_start();
$categories = get_categories(array("type"=>"seoguide", 'parent'=>0, 'exclude' => array(1)));
//var_dump($categories);
foreach ($categories as $num=>$category) :
    $counts[$num+1] = 0;
    ?>
    <div class="modal fade bs-example-modal-lg-<?php echo ($num+1); ?> blokes" data-class="bs-example-modal-lg-<?php echo ($num+1); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <section class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h4 class="box-title"><?php echo $category->name; ?></h4>
                            <h5 class="box-title sub" style="clear: both; font-size: 14px;font-weight: normal;"><?php echo $category->description; ?></h5>
                            <div class="box-tools pull-right">

                            </div>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                        <?php

                        $sub_cat = get_categories(array("type"=>"seoguide", 'parent'=>$category->cat_ID));
                        foreach ($sub_cat as $sub) :
                            ?>
                            <div class="box-body-title"><?php echo $sub->name; ?></div>

                                <ul class="todo-list">
                                    <?php $args = array(
                                        'posts_per_page'   => 100,
                                        'offset'           => 0,
                                        'category'         => $sub->cat_ID,
                                        'category_name'    => '',
                                        'orderby'          => 'date',
                                        'order'            => 'DESC',
                                        'include'          => '',
                                        'exclude'          => '',
                                        'meta_key'         => '',
                                        'meta_value'       => '',
                                        'post_type'        => 'seoguide',
                                        'post_mime_type'   => '',
                                        'post_parent'      => '',
                                        'author'	   => '',
                                        'author_name'	   => '',
                                        'post_status'      => 'publish',
                                        'suppress_filters' => true
                                    );
                                    $posts_array = get_posts( $args );

                                    foreach ($posts_array as $ar) {
                                        $counts[$num+1] += 1;
                                        // var_dump($ar);
                                        ?>
                                        <li>
                                            <!-- drag handle -->
                                            <!-- checkbox -->
                                            <input type="checkbox" data-box="<?php echo $ar->ID; ?>" data-catid="<?php echo ($num+1) ?>" value="" name=""/>
                                            <!-- todo text -->
                                            <span class="text"> <a class="popup-link" href="javascript:void(0);"><?php echo $ar->post_title ?></a></span>
                                            <!-- Emphasis label -->
                                            <div class="tools date">
                                                <span><?php echo date("d/m/y"); ?></span>
                                            </div>
                                            <div class="long-discription">
                                                <?php echo $ar->post_content ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php

                        endforeach;
                        ?>
                        </div>
                        <div class="box-footer clearfix no-border">
                            <button class="btn btn-default pull-right"  data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        </div>
                    </div><!-- /.box -->
                </section>
            </div>
        </div>
    </div>
    <!-- 1 end ---->

    <?php

endforeach;

$modals = ob_get_clean()

?>

<!-- #Content -->
<div id="Content">
    <div class="content_wrapper clearfix">
        <!-- .sections_group -->
        <div class="sections_group">

            <div class="wrapper row-offcanvas row-offcanvas-left">

                <!-- Right side column. Contains the navbar and content of the page -->
                <aside class="right-side strech">
                    <!-- Main content -->
                    <section class="content">


                        <div class="row">
                            <!-- Left col -->
                            <section class="col-lg-12">
                                <!-- TO DO List -->
                                <div class="box box-primary diy-seo-guide">
                                    <div class="box-header">
                                        <h3 class="box-title">DIY SEO Guide</h3>
                                        <div class="box-tools pull-right">
                                            <i class="fa fa-edit"></i>&nbsp;
                                            <i class="fa fa-close"></i>
                                        </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">

                                        <ul class="todo-list">
                                            <?php $categories = get_categories(array("type"=>"seoguide", 'parent'=>0, 'exclude' => array(1)));
                                            foreach ($categories as $num=>$category) :

                                                ?>
                                                <li data-toggle="modal" data-target=".bs-example-modal-lg-<?php echo ($num+1); ?>" data-num="<?php echo ($num+1); ?>">
                                                    <span class="text"> <?php echo ($num+1); ?>. <?php echo $category->description; ?></span>
                                                    <div class="tools">
                                                        <span><span class="count_of">0</span> of <?php echo $counts[$num+1]; ?> done</span>
                                                    </div>
                                                </li>
                                                <?php

                                            endforeach;

                                            ?>

                                        </ul>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->

                            </section><!-- /.Left col -->
                            <!-- Left col -->
                        </div><!-- /.row (main row) -->

                    </section><!-- /.content -->
                </aside><!-- /.right-side -->

                <?php echo $modals; ?>

            </div><!-- ./wrapper -->

            <!-- add new calendar event modal -->


            <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
            <!-- Morris.js charts -->
            <!-- Sparkline -->
            <!-- Bootstrap WYSIHTML5 -->
            <script src="/assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
            <!-- iCheck -->
            <script src="/assets/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/4.10.0/bootstrap-slider.min.js"></script>
            <!-- AdminLTE App -->
            <script src="/assets/js/AdminLTE/app.js" type="text/javascript"></script>

            <script src="/assets/js/lockr.min.js" type="text/javascript"></script>

            <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
            <script src="/assets/js/AdminLTE/dashboard.js" type="text/javascript"></script>

            <!-- AdminLTE for demo purposes -->
            <!--script src="js/AdminLTE/demo.js" type="text/javascript"></script-->
            <!-- page script -->
            <script>
                jQuery(document).ready(function(){
                    $('.popup-link').click(function() {
                        $(this).parent().parent().find('.long-discription').slideToggle();
                    });

                    $('input').on('ifChecked ifUnchecked', function(event) {
                        var out={};
                        var curnumber = $(this).data('box');
                        var curcatid = $(this).data('catid');
                        //var item_id = $(this).data('box');

                        $('li[data-toggle=modal]').each(function () {

                            var mod_num = $(this).data('num');

                            var list=[];

                            if (curcatid==mod_num && event.type!='ifUnchecked')
                                list.push(curnumber);

                            $('.bs-example-modal-lg-'+mod_num+' div[aria-checked=true]').each(function () {
                                var data_box = $(this).find('input').data('box');
                                if (event.type=='ifUnchecked' && data_box==curnumber)
                                    return;
                                list.push(data_box);
                            });

                            if (list.length > 0) {
                                out[mod_num] = list;
                                $('li[data-target=".bs-example-modal-lg-'+curcatid+'"] .count_of').text(list.length);
                                console.log(list.length);
                            }

                        });

                        console.log(JSON.stringify(out));
                        Lockr.set('diysession', JSON.stringify(out))
                    });


                    var diy_data = Lockr.get('diysession');
                    if (diy_data!==undefined) {
                        diy_data = JSON.parse(diy_data);

                        $.each(diy_data, function(i, v) {
                            $.each(v, function(indx, chkb) {
                                console.log(chkb);

                                $('input[data-box='+chkb+']').iCheck('check');
                            });
                        });
                    }
                });

            </script>

        </div>
    </div>
</div>

<?php get_footer(); ?>
