<?php


require_once('../../wordpress/wp-load.php');


function wp_login(){
    if( !is_user_logged_in() ){
        $redirect = $_SERVER['REQUEST_URI'];
        header('Location: ' . wp_login_url($redirect));
        die();
    }
}

function get_logout_link(){
    return sprintf('%s&action=logout&_wpnonce=%s',
        wp_login_url('/index.php'),
        wp_create_nonce( 'log-out' )
    );
}
