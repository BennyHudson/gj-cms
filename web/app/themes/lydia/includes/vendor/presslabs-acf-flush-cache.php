<?php
//flush presslabs cache when saving an option
add_action('acf/save_post', function() {
	// bail early if no ACF data
    if( empty($_POST['acf']) ) {
        return;
    }
	if (function_exists('pl_cache_refresh') && preg_match('/thegentlemansjournal.com/', $_SERVER['HTTP_HOST'])) {
		pl_cache_refresh( 'https://www.thegentlemansjournal.com/' );
	}
});
