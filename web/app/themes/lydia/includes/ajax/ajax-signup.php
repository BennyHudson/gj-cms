<?php
/**
*  Ajax Signup form
*  ------
*  @package GJ
*  @since GJ 5.0
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_ajax_gj_newsletter_signup', 'gj_newsletter_signup' );
add_action( 'wp_ajax_nopriv_gj_newsletter_signup', 'gj_newsletter_signup' );

function gj_newsletter_signup() {

    // Var
    $sendy_url = 'http://mailout.mogmachine.com';
	$list = 'BLbj9HPNN04bDwOmN7xhZg';

    // POST variables
	$email = $_POST['email'];
	$title = false;
	$fname = false;
	$lname = false;
	if (isset($_POST['fname'])) {
		$fname = $_POST['fname'];
	}
	if (isset($_POST['lname'])) {
		$lname = $_POST['lname'];
	}
	if (isset($_POST['title'])) {
		$title = $_POST['title'];
	}

    // Combine the Data
	$data = array(
		'email' => $email,
        'list' => $list,
        'boolean' => 'true'
	);
    if ($title) {
		$data['Title'] = $title;
	}
    if ($fname) {
		$data['FirstName'] = $fname;
	}
	if ($lname) {
		$data['LastName'] = $lname;
	}

	// Subscribe
	$postdata = http_build_query($data);

	$opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
	$context  = stream_context_create($opts);
	$result = file_get_contents($sendy_url.'/subscribe', false, $context);
	//--------------------------------------------------//

	echo $result;
}
