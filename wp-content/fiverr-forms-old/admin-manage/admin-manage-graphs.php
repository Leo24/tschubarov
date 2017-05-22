<?php 

$users = get_users(array('role' => 'contributor'));

?>
<div class="wrap">
  <form action="" method="get" >  
    <input type="hidden" name="page" value="orders-graphics" />
    <div id="kpi">
      <h1>KPI by Workers</h1>
      <div class="filters">
    		<select name="fuser" id="" >
          <option value="-1">All Users</option>
          <?php 
            foreach ($users as $suser) {
              $selected = (isset($_GET['fuser']) && $suser->ID === intval($_GET['fuser'])) ? ' selected="seleted"' : '';
              echo '<option value="'.$suser->ID.'" '.$selected.'>'.$suser->display_name.'</option>';
            }
          ?>
        </select>  
    		<select name="week" id="" >
      		<?php fifo_week_options(); ?>
        </select>          
        <input type="submit" value="Filter" class="button button-primary" />         
      </div>
      <div class="graphs">
        <?php 
          $result = fifo_completed_average_stat();
          
        ?>
        <div class="to-complete">
          <h3>Avg. Time to complete Task</h3>
          <?php if (!empty($result['values'])) { ?>
          <div class="bar-chart ct-perfect-fourth">
            
          </div>
          <script type="text/javascript">
              var data = {
                labels: [<?php echo "'".implode("', '",$result['labels'])."'"; ?>],
                series: [[<?php echo implode(', ',$result['values']); ?>]]
              };
              
              var options = {
                reverseData: true,
                horizontalBars: true,
                axisY: {
                  offset: 100
                }
              };
              
              new Chartist.Bar('.bar-chart', data, options);   
              
              
            (function($, window, document) {
            	$(function() {
            
                var $chart = $('.bar-chart');
                
                var $toolTip = $chart
                  .append('<div class="tooltip"></div>')
                  .find('.tooltip')
                  .hide();
                
                $chart.on('mouseenter', '.ct-bar', function() {
                  var $point = $(this),
                    value = $point.attr('ct:value'),
                    seriesName = $point.parent().attr('ct:series-name'); 
                    if (seriesName) {
                      $toolTip.html(seriesName + '<br>' + value.toHHMMSS()).show();
                    } else {
                      $toolTip.html(value.toHHMMSS()).show();
                    }  
                });
                
                $chart.on('mouseleave', '.ct-bar', function() {
                  $toolTip.hide();
                });
                
                $chart.on('mousemove', function(event) {
                  $toolTip.css({
                    left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
                    top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 40
                  });
                }); 
            		
            	});
            }(window.jQuery, window, document));                       
          </script>          
          <?php } else echo '<h4>No Data</h4>'; ?>
        </div>
        <?php 
          $result = fifo_completed_stat();
        ?>
        <div class="count-complete">
          <h3>Completed Tasks</h3>
          <?php if (!empty($result['values'])) { ?>
          <div class="count-chart ct-perfect-fourth">
            
          </div>
          <script type="text/javascript">
              var data = {
                labels: [<?php echo "'".implode("', '",$result['labels'])."'"; ?>],
                series: [[<?php echo implode(', ',$result['values']); ?>]]
              };
              
              var options = {
                reverseData: true,
                horizontalBars: true,
                axisY: {
                  offset: 100
                }
              };
              
              new Chartist.Bar('.count-chart', data, options);   
              
              
            (function($, window, document) {
            	$(function() {
            
                var $chart = $('.count-chart');
                
                var $toolTip = $chart
                  .append('<div class="tooltip"></div>')
                  .find('.tooltip')
                  .hide();
                
                $chart.on('mouseenter', '.ct-bar', function() {
                  var $point = $(this),
                    value = $point.attr('ct:value'),
                    seriesName = $point.parent().attr('ct:series-name'); 
                    if (seriesName) {
                      $toolTip.html(seriesName + '<br>' + value).show();
                    } else {
                      $toolTip.html(value).show();
                    }  
                });
                
                $chart.on('mouseleave', '.ct-bar', function() {
                  $toolTip.hide();
                });
                
                $chart.on('mousemove', function(event) {
                  $toolTip.css({
                    left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
                    top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 40
                  });
                }); 
            		
            	});
            }(window.jQuery, window, document)); 
          </script>          
        <?php } else echo '<h4>No Data</h4>'; ?>                      
        </div>
        <?php 
          $result = fifo_get_statuses_stat();
          
        ?>        
        <div class="pie-statuses">
          <h3>Tasks Statuses</h3>
          <?php if (!empty($result)) { ?>
          <div class="pie-chart ct-perfect-fourth" id="piechart">
            
          </div>
          <script src="<?php echo FIFO_URL.'/js/amcharts.js' ?>" charset="utf-8"></script>
          <script src="<?php echo FIFO_URL.'/js/pie.js' ?>" charset="utf-8"></script>
          <script src="<?php echo FIFO_URL.'/js/light.js' ?>" charset="utf-8"></script>
          <script type="text/javascript">
            var piedata = {
                  "type": "pie",
                  "addClassNames": true,
                  "classNameField": "class",
                  "theme": "light",
                  "dataProvider": [ <?php echo implode(', ',$result); ?>],
                  "valueField": "count",
                  "titleField": "title",
                   "balloon":{
                   "fixedPosition":true
                  },
                  autoMargins: false,
                  marginTop: 10,
                  marginBottom: 10,
                  marginLeft: 10,
                  marginRight: 10,
                  pullOutRadius: 0,
                } ;
            var chart = AmCharts.makeChart( "piechart", piedata);           
          </script>
        <?php } else echo '<h4>No Data</h4>'; ?>
        </div>
        <?php 
          $res = fifo_get_stat_day_by_day();
        ?>
        <div class="day-by-day">
          <h3>Tasks completed day by day</h3>
          <?php if (!empty($res)) { ?>
          <div class="ct-chart ct-perfect-fourth"></div>
          <script type="text/javascript">
            new Chartist.Bar('.ct-chart', {
              labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
              series: [
                [<?php echo implode(', ', $res); ?>]
              ]
            }, {
              fullWidth: true,
              lineSmooth: Chartist.Interpolation.simple({
                divisor: 100
              }),
              chartPadding: {
                right: 40
              }
            });
            
            (function($, window, document) {
            	$(function() {
                
                $(window).on('load', function() {
                  $('a[href="http://www.amcharts.com/javascript-charts/"]').remove();
                });
            
                var $chart = $('.ct-chart');
                
                var $toolTip = $chart
                  .append('<div class="tooltip"></div>')
                  .find('.tooltip')
                  .hide();
                
                $chart.on('mouseenter', '.ct-bar', function() {
                  var $point = $(this),
                    value = $point.attr('ct:value'),
                    seriesName = $point.parent().attr('ct:series-name'); 
                    if (seriesName) {
                      $toolTip.html(seriesName + '<br>' + value).show();
                    } else {
                      $toolTip.html(value).show();
                    }  
                });
                
                $chart.on('mouseleave', '.ct-bar', function() {
                  $toolTip.hide();
                });
                
                $chart.on('mousemove', function(event) {
                  $toolTip.css({
                    left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
                    top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 40
                  });
                }); 
            		
            	});
            }(window.jQuery, window, document));
  
 
              
  
          </script>  
        <?php } else echo '<h4>No Data</h4>'; ?>
        </div>
      </div>
    </div>
  </form>
</div>
