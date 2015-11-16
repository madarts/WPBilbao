<?php

/*
 * Template Name: Miembros
 *
 * The template for displaying the WPBilbao Community Members.
 *
 * @package WPBilbao\Template\Miembros
 * @author  Ibon Azkoitia
 * @license GPL-2.0+
 * @link    http://www.kreatidos.com
 *
 */

/** Init WPBilbao Miembros Page **/
add_action('genesis_meta', 'wpbilbao_template_miembros');

function wpbilbao_template_miembros() {

  // Add custom content to the entry footer.
  add_action('genesis_entry_footer', 'wpbilbao_template_miembros_do_loop');

  // Force full with content.
  add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

}

function wpbilbao_template_miembros_do_loop() {
  $miembros = get_users('orderby=nicename&role=miembro');

  echo '<div class="lista-miembros row">';

  foreach ( $miembros as $miembro ) {
    $miembro_id = $miembro->ID;
    $miembro_imagen = get_cimyFieldValue($miembro_id, 'IMAGEN'); ?>

    <div class="miembro-lista col-xs-6 col-sm-2">
      <a href="<?php echo get_author_posts_url( $miembro_id ); ?>" title="<?php printf( __('Pefil de %s', 'wpbilbao'), esc_html($miembro->display_name) ); ?>">
        <?php if ( $miembro_imagen ) : ?>
          <img src="<?php echo cimy_uef_sanitize_content($miembro_imagen); ?>" alt="<?php echo esc_html($miembro->display_name); ?>"/>
        <?php else : ?>
          <img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/miembros/wpbilbao-sin-foto.jpg" alt="<?php echo esc_html($miembro->display_name); ?>"/>
        <?php endif; ?>
        <h4><?php echo esc_html($miembro->display_name); ?></h4>
      </a>
    </div><!-- .miembro-lista -->

  <?php
  }
  echo '<div class="clearfix"></div>';

  echo '</div><!-- .row -->';
}

genesis();