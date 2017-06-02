<?php
/**
 * The Page Sidebar containing the widget area.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


$fiverrData = get_fiverr_banners();
//var_dump($fiverrData);
?>


<div class="fiver-sidebar-vertical-banner">
    <a href="<?php echo $fiverrData['vertical_banner_link'] ;?>" target="_blank">
        <img src="<?php echo $fiverrData['vertical_banner']['url'] ;?>" alt="<?php echo $fiverrData['vertical_banner']['title'] ;?>">
    </a>
</div>
<div class="fiver-sidebar-horisontal-banner">
    <a href="<?php echo $fiverrData['horizontal_banner_link'] ;?>" target="_blank">
        <img src="<?php echo $fiverrData['horizontal_banner']['url'] ;?>" alt="<?php echo $fiverrData['horizontal_banner']['title'] ;?>">
    </a>
</div>
