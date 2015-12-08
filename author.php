<?php

/*
 *
 * @package WPBilbao\Page\Author
 * @author  Ibon Azkoitia
 * @license GPL-2.0+
 * @link    http://www.kreatidos.com
 *
 */

/** Init WPBilbao Author Page **/
add_action('genesis_meta', 'wpbilbao_page_author');

function wpbilbao_page_author() {

  // Remove the Standard Genesis Loop
  remove_action('genesis_loop', 'genesis_do_loop');

  // Add our Custom Loop
  add_action('genesis_loop', 'wpbilbao_page_author_do_loop');

  // Remove the entry meta in the entry footer (requires HTML5 theme support)
  remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

  // Add Related Members
  add_action('genesis_entry_footer', 'wpbilbao_page_author_related_members');

  // Force full width content
  add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

}

function wpbilbao_page_author_do_loop() {

  // Check that the page is author page
  if (!is_author()) return;

  // Assign Query Object to $miembro var
  if (get_query_var('author')) {
    global $wp_query;
    $miembro = $wp_query->get_queried_object();
  }

  // Assign the $miembro ID to $miembro_id var to let us get the rest info of the $miembro
  $miembro_id = $miembro->ID;

  /*
   * We assign the $miembro fields to different variables
   * get_cimyFieldValue lets us get the field of the "Cimy User Extra Fields" Plugin
   *
   * We have to pass the $miembro_id to get the information
   * Then we pass the field name to get it
   */
  $miembro_imagen = get_cimyFieldValue($miembro_id, 'IMAGEN');
  $miembro_nombre = get_the_author();
  $miembro_email = get_cimyFieldValue($miembro_id, 'EMAIL');
  $miembro_telefono = get_cimyFieldValue($miembro_id, 'TELEFONO');
  $miembro_web = get_cimyFieldValue($miembro_id, 'PAGINA-WEB');
  $miembro_twitter = get_cimyFieldValue($miembro_id, 'TWITTER');
  $miembro_linkedin = get_cimyFieldValue($miembro_id, 'LINKEDIN');
  $miembro_facebook = get_cimyFieldValue($miembro_id, 'FACEBOOK');
  $miembro_google = get_cimyFieldValue($miembro_id, 'GOOGLEPLUS');

  $miembro_descripcion = get_cimyFieldValue($miembro_id, 'DESCRIPCION');
  $miembro_deskribapena = get_cimyFieldValue($miembro_id, 'DESKRIBAPENA');

  ?>

  <div class="entry">
    <div class="row">

      <?php
      /*
       * Check that the $miembro_descripcion it's not empty - Line 79
       *
       * If has content, then we show it - Line 81
       * If hasn't got content, then we show the "else :" content - Line 214
       */
      if ($miembro_descripcion) : ?>

        <div class="perfil col-xs-12 col-sm-3">

          <?php if ($miembro_imagen) : ?>
            <img src="<?php echo cimy_uef_sanitize_content($miembro_imagen); ?>"
                 alt="<?php echo esc_html(cimy_uef_sanitize_content($miembro_nombre)); ?>"/>
          <?php endif; ?>

          <?php if ($miembro_nombre) : ?>
            <h1><?php echo esc_html(cimy_uef_sanitize_content($miembro_nombre)); ?></h1>
          <?php endif; ?>

          <?php
          /*
           * Check if the viewer it's a logued in user - Line 99
           *
           * If logged in, we show him the 'real button' - Line 101
           * If not logged in, we show the 'false button'. This button shows the Modal - Line 106
           */
          if (is_user_logged_in()) : ?>

            <a class="btn btn-primario" role="button" data-toggle="collapse" href=".collapseDatos" aria-expanded="false" aria-controls="collapseDatos">
              <?php _e('Ver datos de contacto', 'wpbilbao'); ?>
            </a>

          <?php else : ?>
            <!-- Botón del Modal -->
            <div class="text-center">
              <a class="btn btn-primario" role="button" data-toggle="modal" data-target="#noUsuario">
                <?php _e('Ver datos de contacto', 'wpbilbao'); ?>
              </a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="noUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span
                        aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php _e('Hazte miembro', 'wpbilbao'); ?></h4>
                  </div>
                  <div class="modal-body">
                    <p><?php _e('Para poder ver los datos de contacto de los miembros tienes que ser miembro.', 'wpbilbao'); ?></p>

                    <p><?php _e('Ser miembro es <strong>totalmente gratuito</strong> y podrás contar con tu propio perfil.', 'wpbilbao'); ?></p>

                    <p><?php _e('Iremos añadiendo nuevas características para los miembros.', 'wpbilbao'); ?></p>

                    <p class="text-center">
                      <strong><?php _e('¡Crea tu perfil ahora en menos de 5 minutos!', 'wpbilbao'); ?></strong></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cerrar', 'wpbilbao'); ?></button>
                    <a href="<?php echo site_url(); ?>/wp-login.php" type="button" class="btn btn-primary" title="<?php _e('Entrar', 'wpbilbao'); ?>"><?php _e('Entrar', 'wpbilbao'); ?></a>
                    <a href="<?php echo site_url(); ?>/wp-login.php?action=register" type="button" class="btn btn-primario" title="<?php _e('Hacerse miembro', 'wpbilbao'); ?>"><?php _e('Hacerse miembro', 'wpbilbao'); ?></a>
                  </div> <!-- .modal-footer -->
                </div> <!-- .modal-content -->
              </div> <!-- .modal-dialog -->
            </div><!-- #noUsuario -->
          <?php endif; ?>
        </div><!-- .perfil -->

        <div class="descripcion col-xs-12 col-sm-8">
          <?php   if ( pll_current_language != 'eu'): ?>
              <?php if ( $miembro_descripcion ) : ?>
                <?php echo $miembro_descripcion; ?>
              <?php endif; ?>
          <?php else: ?>
              <?php if ( $miembro_deskribapena ) : ?>
                <?php echo $miembro_deskribapena; ?>
              <?php endif; ?>
          <?php endif; ?>

          <div class="collapse collapseDatos">
            <ul>
              <?php if ($miembro_email) : ?>
                <li class="text-right"><i class="fa fa-envelope"></i>
                  <a href="mailto:<?php echo esc_html($miembro_email); ?>" title="<?php _e('Enviar correo electrónico', 'wpbilbao'); ?>" target="_blank"><?php echo esc_html($miembro_email); ?></a>
                </li>
              <?php endif; ?>

              <?php if ($miembro_telefono) : ?>
                <?php $caracteres = array("+", " "); ?>
                <?php $miembro_telefono_formatted = str_replace($caracteres, "", $miembro_telefono); ?>
                <li class="text-right"><i class="fa fa-phone"></i>
                  <a href="tel:<?php echo esc_html($miembro_telefono_formatted); ?>" title="<?php _e('Llamar por teléfono', 'wpbilbao'); ?>">
                    <?php echo esc_html($miembro_telefono); ?>
                  </a>
                </li>
              <?php endif; ?>
              <ul>
          </div><!-- #collapseDatos -->
        </div><!-- .descripcion -->

        <div class="redes-sociales col-xs-12 col-sm-1">
          <div class="collapse collapseDatos">
            <ul>
              <?php if ($miembro_web) : ?>
                <li><a href="<?php echo esc_html($miembro_web); ?>" title="<?php _e('Visitar página web', 'wpbilbao'); ?>"
                       target="_blank"><i class="fa fa-globe"></i></a>
                </li>
              <?php endif; ?>

              <?php if ($miembro_twitter) : ?>
                <li><a href="<?php echo esc_html($miembro_twitter); ?>" title="<?php _e('Visitar Twitter', 'wpbilbao'); ?>"
                       target="_blank"><i class="fa fa-twitter"></i>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($miembro_linkedin) : ?>
                <li><a href="<?php echo esc_html($miembro_linkedin); ?>" title="<?php _e('Visitar Linkedin', 'wpbilbao'); ?>"
                       target="_blank"><i class="fa fa-linkedin"></i></a>
                </li>
              <?php endif; ?>

              <?php if ($miembro_facebook) : ?>
                <li><a href="<?php echo esc_html($miembro_facebook); ?>" title="<?php _e('Visitar Facebook', 'wpbilbao'); ?>"
                       target="_blank"><i class="fa fa-facebook"></i></a>
                </li>
              <?php endif; ?>

              <?php if ($miembro_google) : ?>
                <li><a href="<?php echo esc_html($miembro_google); ?>" title="<?php _e('Visitar Google', 'wpbilbao'); ?>"
                       target="_blank"><i class="fa fa-google"></i></a>
                </li>
              <?php endif; ?>
            </ul>
          </div><!-- .collapseDatos -->
        </div><!-- .redes-sociales -->

      <?php else : ?>
        <h2 class="text-center"><?php _e('Aún no hay contenido de este miembro', 'wpbilbao'); ?></h2>
      <?php endif; ?>

      <?php wp_reset_query(); ?>

    </div><!-- .row -->

    <?php do_action( 'genesis_entry_footer' ); ?>

  </div><!-- .entry -->

  <?php do_action( 'genesis_after_entry' ); ?>

  <?php
} // wpbilbao_page_author_do_loop


function wpbilbao_page_author_related_members() {

  $miembros = get_users();

  // Get random order of the members
  shuffle($miembros);

  echo '<div class="lista-miembros row">';
    echo '<h2>' . __('Otros Miembros', 'wpbilbao') . '</h2>';

    $i = 0;
    foreach ( $miembros as $miembro ) {
      $miembro_id = $miembro->ID;
      $miembro_imagen = get_cimyFieldValue($miembro_id, 'IMAGEN');
      $miembro_descripcion = get_cimyFieldValue($miembro_id, 'DESCRIPCION');

      // Show 6 members
      if ( $i == 6 ) break; ?>

      <?php if ( $miembro_descripcion ) : ?>

        <div class="miembro-lista col-xs-6 col-sm-2">
          <a href="<?php echo get_author_posts_url( $miembro_id ); ?>" title="<?php printf( __('Pefil de %s', 'wpbilbao'), esc_html($miembro->display_name) ); ?>">

            <?php if ($miembro_imagen) : ?>
              <img src="<?php echo cimy_uef_sanitize_content($miembro_imagen); ?>" alt="<?php echo esc_html($miembro->display_name); ?>"/>
            <?php else: ?>
              <img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/miembros/wpbilbao-sin-foto.jpg" alt="<?php echo esc_html($miembro->display_name); ?>"/>
            <?php endif; ?>

            <h3><?php echo esc_html($miembro->display_name); ?></h3>
          </a>
        </div><!-- .miembro-lista -->

        <?php $i++; ?>
      <?php endif;

    }
    echo '<div class="clearfix"></div>';

    echo '<p>';
      echo '<a class="btn btn-primario" href="' . site_url() . '/miembros/" title="' . __('Ver todos los miembros', 'wpbilbao') . '">' . __('Ver todos los miembros', 'wpbilbao') . '</a>';
    echo '</p>';
  echo '</div><!-- .lista-miembros -->';

} // wpbilbao_page_author_related_members

genesis();
