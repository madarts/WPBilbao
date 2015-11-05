<?php

// Define the constant path
define(SINGLE_PATH, STYLESHEETPATH . '/single');

// Filter the single_template with our function
add_filter('single_template', 'wpbilbao_single_resumenes');

function wpbilbao_single_resumenes($single) {
	global $wp_query, $post;

	/**
	* Check the single_template by category
	* Check by the slug and the ID of the category
	*/
	foreach((array)get_the_category() as $cat) :

		if(file_exists(SINGLE_PATH . '/single-cat-' . $cat->slug . '.php'))
			return SINGLE_PATH . '/single-cat-' . $cat->slug . '.php';

	endforeach;

	return $single;

}