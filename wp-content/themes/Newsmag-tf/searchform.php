<form role="search" method="get" class="td-search-form-widget" action="<?php echo esc_url(home_url( '/' )); ?>">
    <div>
        <input class="td-widget-search-input" type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" /><input class="wpb_button wpb_btn-inverse btn" type="submit" id="searchsubmit" value="<?php _etd('Search')?>" />
    </div>
</form>