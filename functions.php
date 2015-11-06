<?php
/*
 * Functions.php
 */

//* Start the engine
include_once(get_template_directory() . '/lib/init.php');

//* Setup Theme
include_once(get_stylesheet_directory() . '/lib/theme_setup.php');

/*=============================================
=            WPBILBAO FUNCTIONS            =
=============================================*/

/*==========  Functions  ===========*/
@include 'lib/functions/single-resumenes.php';
@include 'lib/functions/user-profile.php';
@include 'lib/functions/custom-footer.php';

/*===========  Sections  ===========*/
@include 'lib/sections/section-autor.php';

/*==========  Navigation  ==========*/
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_before_header', 'genesis_do_subnav');

/*===  Add WooCommerce Support  ===*/
add_theme_support('genesis-connect-woocommerce');

/*=====  End of WPBILBAO FUNCTIONS  ======*/

