<?php
/*
Plugin Name: WP Google+1
Plugin URI: http://www.goopl.de
Description: show all google +1 counts on the article overview
Author: Sebastian Thiele
Version: 0.1
Author URI: http://sebastian.thiele.me
*/
$plugindir = basename(dirname(__FILE__));
load_plugin_textdomain( 'wpg1', 'wp-content/plugins/' . $plugindir.'/lang', false );
include_once('wp1-menue.php');


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

function wpg1_admin_head($content)
{
    print '<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
      {lang: \''.get_bloginfo('language').'\'}
    </script>';
}

function wpg1_adminmenue()
{
    add_options_page(__('WP Google+1'), __('WP Google+1'), 'manage_options', 'wpg1', 'wpg1_adminmenue_show');
}

add_filter('manage_posts_columns', 'wpg1_article_colum');
add_filter('manage_posts_custom_column', 'wpg1_article_colum_content');
add_filter('admin_head', 'wpg1_admin_head');
add_action(	'admin_menu', 'wpg1_adminmenue');
?>