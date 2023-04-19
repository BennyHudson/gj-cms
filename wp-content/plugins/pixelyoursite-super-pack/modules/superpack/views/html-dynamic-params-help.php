<?php

namespace PixelYourSite\SuperPack;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$serverUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>

<div class="card card-static">
	<div class="card-header">
		Dynamic Parameters Help
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				<ul>
					<li><code>[id]</code> - it will pull the WordPress post ID</li>
					<li><code>[title]</code> - it will pull the content title</li>
					<li><code>[content_type]</code> - it will pull the post type (post, product, page and so on)</li>
					<li><code>[categories]</code> - it will pull the content categories</li>
					<li><code>[tags]</code> - it will pull the content tags</li>
                    <li><code>[total]</code> - it will pull WooCommerce or EDD order's total when it exists</li>
                    <li><code>[subtotal]</code> - it will pull WooCommerce or EDD orders's subtotal when it exists</li>
				</ul>
                <p><strong>Track URL parameters:</strong></p>
                <p> Use <code>[url_ParameterName]</code> where ParameterName = the name of the parameter. <br/>
                    Example:<br/>
                    This is your URL: <?=$serverUrl?>?ParameterName=123<br/>
                    The parameter value will be 123.<br/>
                </p>
				<p class="mb-0"><strong>Note:</strong> if a parameter is missing from a particular page, the event won't
					include it.</p>
			</div>
		</div>
	</div>
</div>