<?php

//* Add HTML5 markup structure
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

//* Add viewport meta tag for mobile browsers
add_theme_support('genesis-responsive-viewport');

//* Remover Barra de Admin
add_filter('show_admin_bar', '__return_false');

//* Remove Edit Link
add_filter('edit_post_link', '__return_false');

//* Remove Genesis in-post SEO Settings
remove_action('admin_menu', 'genesis_add_inpost_seo_box');
//* Remove Genesis SEO Settings menu link
remove_theme_support('genesis-seo-settings-menu');

//* Remove the site description
remove_action('genesis_site_description', 'genesis_seo_site_description');

//* Remove Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');

//* Unregister layout settings
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-content-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');

//* Unregister secondary sidebar
unregister_sidebar('sidebar-alt');

//* Remove default post image
remove_action('genesis_entry_content', 'genesis_do_post_image', 8);

//* Add featured image above the entry content
add_action('genesis_entry_content', 'wpbilbao_featured_photo', 8);
function wpbilbao_featured_photo() {
  if (is_page() || !genesis_get_option('content_archive_thumbnail'))
    return;

  if ($image = genesis_get_image(array('format' => 'url', 'size' => genesis_get_option('image_size')))) {
    printf('<div class="featured-image"><img src="%s" alt="%s" class="entry-image"/></div>', $image, the_title_attribute('echo=0'));
  }
}

//* Reposition the post info
remove_action('genesis_entry_header', 'genesis_post_info', 12);
add_action('genesis_entry_header', 'genesis_post_info', 5);

//* Remove comment form allowed tags
add_filter('comment_form_defaults', 'wpbilbao_remove_comment_form_allowed_tags');
function wpbilbao_remove_comment_form_allowed_tags($defaults) {

  $defaults['comment_notes_after'] = '';

  return $defaults;

}

//* Add support for after entry widget
add_theme_support('genesis-after-entry-widget-area');

//* Relocate after entry widget
remove_action('genesis_after_entry', 'genesis_after_entry_widget_area');
add_action('genesis_after_entry', 'genesis_after_entry_widget_area', 5);


/*============================================
=            EDITABLE INFORMATION            =
============================================*/

//* Set Localization (do not remove)
add_action('after_setup_theme', 'wpbilbao_language_setup');
function wpbilbao_language_setup() {
  load_child_theme_textdomain('wpbilbao', get_stylesheet_directory() . '/lib/languages');
}

//* Child theme (do not remove)
define('CHILD_THEME_NAME', 'WordPress Bilbao');
define('CHILD_THEME_URL', 'http://www.kreatidos.com/');
define('CHILD_THEME_VERSION', '1.0');

//* Enqueue Scripts
function wpbilbao_enqueue_scripts() {
  wp_enqueue_style('wpbilbao-style', get_stylesheet_uri(), array('parent-style'));

  // wp_enqueue_script( 'wpbilbao', get_bloginfo( 'stylesheet_directory' ) . '/js/wpbilbao.min.js', array( 'jquery' ) );
  wp_enqueue_script('vendors', get_bloginfo('stylesheet_directory') . '/js/vendors.min.js', array('jquery'));
  wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,600', array(), CHILD_THEME_VERSION);
}

add_action('wp_enqueue_scripts', 'wpbilbao_enqueue_scripts');