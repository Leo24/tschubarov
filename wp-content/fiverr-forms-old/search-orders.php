<div class="wrap">
  <h1>Bulk Search Orders</h1>
  <form action="" method="post" class="fifo_search">
    <label for="forders">Enter Order Numbers one per line</label></br />
    <textarea name="orders" id="forders" cols="50" rows="10"></textarea><br />
    <div class="alignleft">
      <input type="submit" value="Search" class="button button-primary" id="fifo_search_orders" /><span class="spinner"></span>
    </div>
    <div class="clear"></div>
  </form>
  <div class="fiverr_search_results clearfix">
    <h3 id="found_fiverrs"></h3>
    <div id="found_fiverrs_results">
      
    </div>
    <hr />
    <h3 id="not_found_fiverrs"></h3>
    <div id="not_found_fiverrs_results">
      
    </div>    
  </div>
</div>