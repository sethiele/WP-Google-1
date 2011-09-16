<?php
/*
Plugin Name: WP Google+1
Plugin URI: http://www.goopl.de
Description: show all google +1 counts on the article overview
Author: Sebastian Thiele
Version: 1.0.1
Author URI: http://sebastian.thiele.me
*/
$wpg1Options = get_option('wpg1');
$plugindir = basename(dirname(__FILE__));
load_plugin_textdomain( 'wp1', 'wp-content/plugins/' . $plugindir.'/lang', false );
include_once('wp1-menue.php');
include_once('wp1-userprofile.php');
include_once('wpg1_sb_1.php');
include_once('wpg1_sb_2.php');
include_once('wp1-gooplrss.php');


/**
 * render a link to a google profile wit rel="me"
 * @param userID The user id where to get the user datas from
 * @param anker the anker text of the link
 * @param target target of the link
 * @return a HTML link to enter in the theme
 */
function wpg1_google_profile_link($userID, $anker = NULL, $target = '_self', $option = array())
{
    if( !isset($option['rel']) ) $option['rel'] = 'me';
    if(!$userID) return __('Missing userID', 'wp1');
    if(!$anker) $anker = esc_attr( get_the_author_meta( 'display_name', $userID ) );
    $gprofile = esc_attr( get_user_meta( $userID, 'g1profile', true ) );
    if($gprofile) {
        return '<a href="'.$gprofile.'" target="'.$target.'" rel="'.$option['rel'].'">'.$anker.'</a>';
    }
    else {
        return;
    }
}


// return the button code (theme function)
function wpg1_g1button($size = 'standart', $pid = NULL)
{
    global $post;
    if(substr($pid, 0, 4) == 'http') {
        $plink = $pid;
    } else {
        if($pid) $plink = get_permalink($pid);
        else $plink = get_permalink($post->ID);
    }
    return '<g:plusone size="'.$size.'" href="'.$plink.'"></g:plusone>';
}

/**
  * render a Button out of the content
  * @param content
  */
function wpg1_button_content($content)
{
    global $post;
    $content = str_replace('[wpg1-small]', wpg1_g1button('small', $post->ID), $content);
    $content = str_replace('[wpg1-medium]', wpg1_g1button('medium', $post->ID), $content);
    $content = str_replace('[wpg1-standard]', wpg1_g1button('standard', $post->ID), $content);
    $content = str_replace('[wpg1-large]', wpg1_g1button('large', $post->ID), $content);
    return $content;
}

function wpg1_article_colum($columns)
{
    $columns['g1'] = __('Google +1', 'wp1');
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

// show the js code in the footer
function wpg1_footer($content)
{
    print '<script type="text/javascript">
  window.___gcfg = {lang: \''.get_bloginfo('language').'\'};

  (function() {
    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
    po.src = \'https://apis.google.com/js/plusone.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
  })();
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

// Register Sidebar for SingleUser Authorlink
wp_register_sidebar_widget( 
    'wpg1_sb_2', 
    __('Authorlink'),
    'wpg1_sb_2_display',
    array(
       'description' => __('Only for single user blogs helpfull. This sidebar provides a Author Link and linkes so all content to one user. (If this is a multiuser Blog lakk at the plugin option page for this function.)')
    )
);

// Register Sidebar Menue for authorlink
wp_register_widget_control(
    'wpg1_sb_2',
    __('Authorlink to google/ google+ profile'),
    'wpg1_sb_2_options'
);

// Register Sidebar for g+1 Button
wp_register_sidebar_widget( 
    'wpg1_sb_1', 
    __('Google+1 Sidebar Button'),
    'wpg1_sb_1_display',
    array(
       'description' => __('A Single Google +1 Button for your sidebar. You can decide what kind of Target the +1 have. E.g. give a +1 for the current shown page or for a special page like the front URL.')
    )
);

// Register Sidebar Menue for g+1 button
wp_register_widget_control(
    'wpg1_sb_1',
    __('Google+1 Sidebar Button'),
    'wpg1_sb_1_options'
);

// Extra column
add_filter('manage_posts_columns', 'wpg1_article_colum');
add_filter('manage_posts_custom_column', 'wpg1_article_colum_content');

// g+1 theme Functions
//add_filter('admin_head', 'wpg1_head');
add_filter('admin_footer', 'wpg1_footer');
if($wpg1Options['wpg1-add-theme']) 
{
    //add_filter('wp_head', 'wpg1_head');
    add_filter('wp_footer', 'wpg1_footer');
    add_filter('the_content', 'wpg1_button_content');
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

// Add RSS to dashboard
function wpg1_rss_add_dashboard()
{
    wp_add_dashboard_widget( 'wpg1gooplrss', __('GooPl.de RSS-Feed', 'wp1'), 'wpg1_feed' );
}

// Initialize dashboard
add_action( 'wp_dashboard_setup', 'wpg1_rss_add_dashboard' );


?>