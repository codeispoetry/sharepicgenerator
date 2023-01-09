<?php


require_once('../../wordpress/wp-load.php');


function wordpress_login(){

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

function do_saml_login()
{
    $hasAccess = isLocal() ?: isLocalUser();

    $doLogout = false;
    if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
        if ($hasAccess) {
            doLogout();
        } else {
            $doLogout = true;
            handleSamlAuth($doLogout);
        }
        die();
    }

    if (!$hasAccess) {
        $user = handleSamlAuth($doLogout);
    }

    return $user;
}