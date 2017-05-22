<?php

if (isset($_GET['unique'])) {

    $real_id = $_GET['order'];

    $report = $wpdb->get_row("SELECT * FROM $wpdb->links WHERE link_name = '" . $real_id . "'");

    $seo_rep = unserialize($report->link_notes);

    $url = $report->link_description;

} else {

    $post_id = $_GET["order"];
    $key = $_GET["key"];

    $seo_rep = get_post_meta((int)$post_id, 'seo_rep', true);

    $real_id = get_post_meta($post_id, 'order_number', true);

    $url = get_post_meta((int)$post_id, 'seo_rep_url', true);

}

if (!preg_match("/$key/", $url)) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    exit();
}

$off_seo1 = array(
    '10 Blog Posts' => 'fa fa-book',
    '10 Blog Comments' => 'fa fa-commenting',
    '10 Document Shares' => 'fa fa-share-alt',
    '10 Social Bookmarks' => 'fa fa-bookmark',
    '10 Directory Submissions' => 'fa fa-check',
    '5 Social Profiles' => 'fa fa-group',
);
$off_seo2 = array(
    '5 Image Submissions' => 'fa fa-photo',
    '5 Microblog links' => 'fa fa-link',
    '5 Q&A Posts' => 'fa fa-question',
    '5 Wiki Posts' => 'fa fa-wikipedia-w',
    '5 EDU Links' => 'fa fa-graduation-cap',
    '5 Article submissions' => 'fa fa-pencil-square-o',
);

$on_seo = array(
    'Keywords Research' => 'fa fa-search',
    'Competition Analysis' => 'fa fa-stethoscope',
    'Off Page SEO Report' => 'fa fa-file-code-o',
    'On Page SEO Report' => 'fa fa-file-text-o',
    'Website Errors and Issues' => 'fa fa-ambulance',
    'DIY SEO Marketing Plan' => 'fa fa-calendar',
    'White hat and safe' => 'fa fa-flag-o',
);

function getList($arr, $seo_rep) {
    foreach ($arr as $item => $class) {
        ?>
        <li class="<?php echo $class; ?>">
            <?php
            $empty = empty($seo_rep[seo_comp($item)]);
            ?>
            <a href="#<?php if (!$empty) { ?>TB_inline?width=600&height=550&inlineId=<?php echo seo_comp($item); } ?>" class="<?php if (!$empty) { ?>thickbox<?php } ?><?php  if (empty($seo_rep[seo_comp($item)])) echo 'empty' ?>"><?php echo $item; ?></a>
            <div class="cont_popup" id="<?php echo seo_comp($item); ?>">
                <h4><?php echo $item; ?></h4>
                <hr>
                <div><?php echo ys_prepare_output($seo_rep[seo_comp($item)]); ?></div>
            </div>
        </li>
        <?php
    }

}

get_header();
?>

    <link rel='stylesheet'
          href='/wp-content/plugins/nextgen-gallery/products/photocrati_nextgen/modules/nextgen_gallery_display/static/fontawesome/font-awesome.min.css'
          type='text/css' media='all'/>
    <style>
        .seo_package_list {
            width: 250px;
            float: left;
            margin-left: 40px;
        }

        .seo_package_list .cont_popup {
            display: none;
        }

        .seo_package_list li {
            width: 250px;
        }

        .seo_package_list a {
            color: #626262;
        }

        .seo_package_list a.empty {
            color: #CCC;
        }

        .seo_package_list a {
            font-family: "Open Sans", Arial, Tahoma, sans-serif;
            font-size: 18px;
        }

        .fa:before {
            padding-right: 7px;
            color: #ff00ff;
        }
    </style>

    <?php add_thickbox(); ?>
    <div style="width: 1170px; margin: 0 auto; overflow: hidden; margin-bottom: 20px; margin-top: 20px">

        <h2>Seo Package Report</h2>
        <br/>
        <h4>Order ID: <b><?php echo $real_id; ?></b></h4>
        <br/><br/>
        <div style="background: #f0f0f0; overflow: hidden; padding-top: 20px; border-radius: 5px">
            <div style="width: 50%; float: left;">
                <p style="text-align: center;"><span class="highlight"><i class="fa fa-edit"></i> OFF Page SEO</span>
                </p>
                <ul class="seo_package_list">
                    <?php
                    getList($off_seo1, $seo_rep);
                    ?>
                </ul>
                <ul class="seo_package_list">
                    <?php
                    getList($off_seo2, $seo_rep);
                    ?>
                </ul>

            </div>
            <div style="width: 50%; float: left;">
                <div class="column">
                    <p style="text-align: center;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="highlight"><i
                                class="fa fa-cogs"></i> ON Page SEO</span></p>
                    <ul class="seo_package_list">
                        <?php
                        getList($on_seo, $seo_rep);
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php get_footer(); ?>