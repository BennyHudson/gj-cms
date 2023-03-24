<?php

function sessions_video()
{

    $response = Timber\Timber::compile('components/sessions/sessions-featured.twig', [
        'session' => new Timber\Post($_POST['id'])
    ]);

    echo $response;

    wp_die();
}

add_action('wp_ajax_sessions_video', 'sessions_video');
add_action('wp_ajax_nopriv_sessions_video', 'sessions_video');
