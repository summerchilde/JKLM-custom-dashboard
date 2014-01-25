<?php
/**
 * Plugin Name: Custom Dashboard
 * Plugin URI: http://kerimariondesign.com
 * Description: Customizes the dashboard
 * Author: Justin Lewis
 * Author URI: http://kerimariondesign.com
 * Version: 0.1.0
 */
 
 /*Remove default widgets*/
 // unregister all widgets
 function unregister_default_widgets() {
    // unregister_widget('WP_Widget_Pages');
     //unregister_widget('WP_Widget_Calendar');
    // unregister_widget('WP_Widget_Archives');
     //unregister_widget('WP_Widget_Links');
    // unregister_widget('WP_Widget_Meta');
     //unregister_widget('WP_Widget_Search');
     //unregister_widget('WP_Widget_Text');
    // unregister_widget('WP_Widget_Categories');
    // unregister_widget('WP_Widget_Recent_Posts');
     //unregister_widget('WP_Widget_Recent_Comments');
     //unregister_widget('WP_Widget_RSS');
     //unregister_widget('WP_Widget_Tag_Cloud');
    // unregister_widget('WP_Nav_Menu_Widget');
     unregister_widget('Twenty_Eleven_Ephemera_Widget');
 }
 add_action('widgets_init', 'unregister_default_widgets', 11);
/*Change the Howdy */ 
add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );

function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );

if ( 0 != $user_id ) {
/* Add the "My Account" menu */
$avatar = get_avatar( $user_id, 28 );
$howdy = sprintf( __('Greetings, %1$s'), $current_user->display_name );
$class = empty( $avatar ) ? '' : 'with-avatar';

$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );

}
}
/* Add custom Dashboard Widget */
add_action('wp_dashboard_setup', 'jklm_custom_dashboard_widget');
 
function jklm_custom_dashboard_widget() {
global $wp_meta_boxes;

wp_add_dashboard_widget('custom_intro_widget', 'Introduction to the Dashboard', 'custom_dashboard_intro');
}

function custom_dashboard_intro() {
echo '<h1 style="color:#2ea2cc">Welcome to the ' . get_bloginfo ( 'name' ). ' dashboard!</h1>';
echo '<p>Make changes to the site content and settings using the sidebar menu on the left. Basic description of each menu item is listed below.</p>

<h2>Dashboard Sidebar Menu Items:</h2>
<div id="docs-left" style="float:left;width:48%;">
<ul style="padding: 0 0 0 18px">';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'index.php' ). '">Dashboard:</a> This link will bring you back to this page.
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'update-core.php' ). '">Updates:</a> This is where you update the WordPress software and plugins when updates become available. 
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'edit.php' ). '">Blog Posts:</a> This is where you can edit the content of your blog posts.
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'edit.php?post_type=page' ). '">Site Pages:</a> This is where you can edit the content of your  pages.
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'upload.php' ). '">Media Library:</a> This is the library containing all the uploaded images and other media that are used on the website.
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'edit-comments.php' ). '">Reader Comments:</a> This is where you can edit/approve/remove comments left on your blog posts or pages. 
<li>';
echo '</ul>
</div>
<div id="docs-right" style="float:right;width:48%;">
<ul style="padding: 0 0 0 18px">';

echo '<li style="list-style-type:disc"><a href="' . admin_url( 'themes.php' ). '">Appearance:</a> This is where you can edit the site widgets, menus, and theme options if they are available. 
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'options-general.php' ). '">Site Settings:</a> This is where you can edit the settings for your site.
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'plugins.php' ). '">Plugin Settings:</a> This is where you can edit the settings for your site plugins.
<li>';
echo '<li style="list-style-type:disc"><a href="' . admin_url( 'users.php' ). '">User Profiles:</a> Change your password and account information here.
<li>';
echo '<li style="list-style-type:disc"><b>Other:</b> If you add other plugins to the site sometimes they include their own menu link that will show up in the sidebar.
<li>


</ul>
</div>
<div style="clear:both"></div>


';
}

/*Remove Welcome Panel*/
add_action( 'load-index.php', 'remove_welcome_panel' );

function remove_welcome_panel()
{
    remove_action('welcome_panel', 'wp_welcome_panel');
    $user_id = get_current_user_id();
    if (0 !== get_user_meta( $user_id, 'show_welcome_panel', true ) ) {
        update_user_meta( $user_id, 'show_welcome_panel', 0 );
    }
}
/*Admin Credit */

function remove_footer_admin () {
echo 'Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Theme designed by <a href="http://www.kerimariondesign.com/" target="_blank">Keri Marion Design</a></p>';
}

add_filter('admin_footer_text', 'remove_footer_admin');
/*Remove Dashboard Widgets */

function example_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	//remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	//remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	//remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
} 

add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );

// Remove the admin bar from the front end
add_filter( 'show_admin_bar', '__return_false' );

//custom dashboard menu order
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
	
	return array(
		'index.php', // Dashboard
		'separator1', // First separator
		'edit.php', //Posts
		'edit.php?post_type=page', // Pages
		'upload.php', // Media
		'edit-comments.php', // Comments
		'separator2', // Second separator
		'themes.php', // Appearance
		'options-general.php', // Settings
		'plugins.php', // Settings
		'users.php', // Users
		'separator-last', // Last separator
	);
}
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');
//Edit admin menu names
function edit_admin_menus() {
	global $menu;
	$menu[5][0] = 'Blog Posts'; // Posts title
	$menu[10][0] = 'Media Library'; // Change Media Menu title
	$menu[80][0] = 'Site Settings'; // Change Settings Menu title
	$menu[70][0] = 'User Profile'; // Change Users title
	$menu[25][0] = 'Reader Comments'; // Change Comments title
	$menu[65][0] = 'Plugin Settings'; // Plugins  title
	$menu[20][0] = 'Site Pages'; // Pages title
}
add_action( 'admin_menu', 'edit_admin_menus' );
// Remove the admin bar from the front end
add_filter( 'show_admin_bar', '__return_false' );
//remove dashboard menu links - uncomment to remove
add_action( 'admin_menu', 'my_remove_menu_pages' );

	function my_remove_menu_pages() {
		remove_menu_page('link-manager.php');
		//remove_menu_page('tools.php');	
		//remove_menu_page('plugins.php');	
		//remove_submenu_page( 'themes.php', 'themes.php' );
		//remove_menu_page('edit.php');
		//remove_submenu_page( 'options-general.php', 'options-discussion.php' ); 
		//remove_submenu_page( 'options-general.php', 'options-writing.php' ); 
		//remove_submenu_page( 'options-general.php', 'options-general.php' );
		//remove_submenu_page( 'options-general.php', 'options-reading.php' ); 
		//remove_submenu_page( 'options-general.php', 'options-media.php' ); 
		//remove_submenu_page( 'options-general.php', 'options-permalink.php' ); 
		//remove_submenu_page( 'users.php', 'users.php' );
		//remove_submenu_page( 'users.php', 'user-new.php' );
		
	}

/*Security functions */
// Remove the version number of WP
// Warning - this info is also available in the readme.html file in your root directory - delete this file!
remove_action('wp_head', 'wp_generator');


// Obscure login screen error messages
function wpfme_login_obscure(){ return '<strong>Sorry</strong>: Think you have gone wrong somwhere!';}
add_filter( 'login_errors', 'wpfme_login_obscure' );

/* Place custom code above this line. */
?>