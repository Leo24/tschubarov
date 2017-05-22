<?php get_header(); ?>

<?php
$args = array(
    'post_type' => 'comparison',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page' => 100
);
$my_query = new WP_Query($args);
$services = $my_query->get_posts();
$services_count = count($services);

$fields = array();
$fields_count = 0;
foreach ($services as $cnt => $service) {

    $fields[$cnt] = get_field_objects($service->ID);
    if (empty($fields_count))
        $fields_count = count($fields[$cnt]);

}

//echo "<pre>";
//var_dump($fields[0]);
global $post;
?>
    <div class="main-table clearfix">
        <div class="wrapper">
            <h2><?php the_title(); ?></h2>
            <p><?php echo $post->post_content; ?></p>
            <table>
                <thead>
                <tr>
                    <td class="align-left">
                        <h3>Name</h3></td>

                    <?php foreach ($services as $cnt => $service): ?>
                        <td>
                            <div class="title-company">
                                <h4>
                                    <?php if ($cnt == 0) { ?>
                                        <span><?php echo $service->post_title ?></span>
                                    <?php } else { ?>
                                        <?php echo $service->post_title ?>
                                    <?php } ?>
                                </h4>
                            </div>
                            <div class="info-company">
                                <div class="logo-company"><img height="30" src="<?php echo get_the_post_thumbnail_url($service->ID) ?>"></div>
                                <span class="stars-table"> <i class="star active"></i> <i class="star active"></i> <i
                                        class="star active"></i> <i class="star active"></i> <i class="star active"></i> </span>
                            </div>

                        </td>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <th>Rank</th>

                    <?php foreach ($services as $cnt => $service): ?>
                        <th class="bg-<?php echo($cnt + 1) ?>">
                            <?php if ($cnt == 0) { ?>
                                <span><?php echo($cnt + 1) ?></span>
                            <?php } else { ?>
                                <?php echo($cnt + 1) ?>
                            <?php } ?>
                        </th>
                    <?php endforeach; ?>

                </tr>

                <?php $i = 0; ?>
                <?php foreach ($fields[0] as $field_name => $f_val): ?>
                    <?php
                    $divider = false;
                    if (preg_match('/_divider$/', $field_name)) $divider = true;
                    ?>
                    <tr>
                    <?php echo $divider ? '<th>' : '<td class="left-align">' ?><?php echo $fields[0][$field_name]['label'] ?></<?php echo $divider ? 'th' : 'td' ?>">
                    <?php foreach ($services as $cnt => $service): ?>
                        <?php if (!$divider): ?>
                            <td><?php echo $fields[$cnt][$field_name]['value'] ?></td>
                        <?php else: ?>
                            <th></th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

<?php get_footer(); ?>