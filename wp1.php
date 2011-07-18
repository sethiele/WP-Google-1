<?php
/*
Plugin Name: WP Google+1
Plugin URI: http://www.goopl.de
Description: show all google +1 counts on the article overview
Author: Sebastian Thiele
Version: 0.4
Author URI: http://sebastian.thiele.me
*/
$wpg1Options = get_option('wpg1');
$wpg1Options = get_option('wpg1');
$plugindir = basename(dirname(__FILE__));
load_plugin_textdomain( 'wpg1', 'wp-content/plugins/' . $plugindir.'/lang', false );
include_once('wp1-menue.php');
include_once('wp1-userprofile.php');


/**
 * render a link to a google profile wit rel="me"
 * @param userID The user id where to get the user datas from
 * @param anker the anker text of the link
 * @param target target of the link
 * @return a HTML link to enter in the theme
 */
function wpg1_google_profile_link($userID, $anker = NULL, $target = '_self')
{
    if(!$userID) return __('Missing userID', 'wpg1');
    if(!$anker) $anker = esc_attr( get_the_author_meta( 'display_name', $userID ) );
    $gprofile = esc_attr( get_user_meta( $userID, 'g1profile', true ) );
    if($gprofile) {
        return '<a href="'.$gprofile.'" target="'.$target.'" rel="me">'.$anker.'</a>';
    }
    else {
        return;
    }
}


// return the button code (theme function)
function wpg1_g1button($size = 'standart', $pid = NULL)
{
    global $post;
    if($pid) $plink = get_permalink($pid);
    else $plink = get_permalink($post->ID);
    return '<g:plusone size="'.$size.'" href="'.$plink.'"></g:plusone>';
}

function wpg1_article_colum($columns)
{
    $columns['g1'] = __('Google +1', 'wpg1');
    return $columns;
}


function wpg1_article_colum_content($names)
{
    global $post;
    switch ($names) {
        case 'g1':
            print wpg1_g1button('small', $post->ID);
            break;
    }
}

// show the js code in the header
function wpg1_head($content)
{
    print '<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
      {lang: \''.get_bloginfo('language').'\'}
    </script>';
}

function wpg1_adminmenue()
{
    add_options_page(__('WP Google+1'), __('WP Google+1'), 'manage_options', 'wpg1', 'wpg1_adminmenue_show');
}

function wpg1_deactivate()
{
    delete_option('wpg1');
}

// Extra column
add_filter('manage_posts_columns', 'wpg1_article_colum');
add_filter('manage_posts_custom_column', 'wpg1_article_colum_content');

// g+1 theme Functions
add_filter('admin_head', 'wpg1_head');
if($wpg1Options['wpg1-addtheme']) 
{
    add_filter('wp_head', 'wpg1_head');
}

// Adminmenue
add_action('admin_menu', 'wpg1_adminmenue');

// TODO: unregister
register_deactivation_hook( __FILE__, 'wpg1_deactivate' );

// G+1 Profil userprofil
if($wpg1Options['wpg1-add-g1-profile-link'])
{
    add_action( 'show_user_profile', 'wpg1_user_profile_fields' );
    add_action( 'edit_user_profile', 'wpg1_user_profile_fields' );

    add_action( 'personal_options_update', 'wpg1_save_user_profile_fields' );
    add_action( 'edit_user_profile_update', 'wpg1_save_user_profile_fields' );
}

?>