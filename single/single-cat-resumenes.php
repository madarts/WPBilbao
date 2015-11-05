<?php

/*
 *
 * @package WPBilbao\Single\Resumenes
 * @author  Ibon Azkoitia
 * @license GPL-2.0+
 * @link    http://www.kreatidos.com
 *
 */

/** Init WPBilbao Single Resumenes **/
add_action('genesis_meta', 'wpbilbao_single_resumenes_meta');

function wpbilbao_single_resumenes_meta() {

  // Force full with content
  add_action('genesis_entry_footer', 'wpbilbao_single_resumenes_content', 1);

}

function wpbilbao_single_resumenes_content() { ?>

  <?php if (get_field('resumenes_seleccion_presentacion')) : ?>
    <div class="presentacion seccion-single-resumenes">
      <h2><?php _e('Presentación', 'wpbilbao'); ?></h2>

      <?php if (get_field('resumenes_url_presentacion_google_drive')) : ?>
        <iframe
          src="https://docs.google.com/presentation/embed?id=<?php the_field('resumenes_url_presentacion_google_drive'); ?>&amp;start=false&amp;loop=false&amp;"
          frameborder="0" width="100%" height="405"></iframe>
      <?php endif; ?>

      <?php if (get_field('resumenes_url_presentacion_slideshare')) : ?>
        <iframe src="<?php the_field('resumenes_url_presentacion_slideshare'); ?>" width="100%" height="405"
                frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:none;" allowfullscreen
                webkitallowfullscreen mozallowfullscreen></iframe>
      <?php endif; ?>

    </div><!-- .presentación -->
  <?php endif; ?>

  <?php if (get_field('resumenes_url_video')) : ?>
    <div class="video seccion-single-resumenes">
      <h2><?php _e('Vídeo', 'wpbilbao'); ?></h2>

      <div class="embed-container">
        <?php the_field('resumenes_url_video'); ?>
      </div> <!-- .embed-container -->
    </div> <!-- .video -->
  <?php endif; ?>

  <?php if (have_rows('resumenes_menciones_twitter')) : ?>
    <div class="menciones-twitter seccion-single-resumenes">
      <h2><?php _e('Menciones en Twitter', 'wpbilbao'); ?></h2>

      <p><?php _e('Para completar el resumen de esta presentación os dejamos algunas menciones recogidas de nuestro timeline de Twitter.', 'wpbilbao'); ?></p>
      <?php while (have_rows('resumenes_menciones_twitter')) : the_row(); ?>
        <?php the_sub_field('resumenes_url_tweet'); ?>
      <?php endwhile; ?>
    </div><!-- .menciones-twitter -->
  <?php endif; ?>

  <?php if (get_field('resumenes_url_meetup')) : ?>
    <?php $resumenUrlMeetup = get_field('resumenes_url_meetup'); ?>
    <div class="enlace-meetup seccion-single-resumenes">
      <h2><?php _e('Enlace Meetup', 'wpbilbao'); ?></h2>

      <p><?php printf(__('Si quieres saber qué han comentado los asistentes a este encuentro y dejar tu propia valoración no dejes de pasarte por <a href="%s" title="Enlace Meetup" target="_blank">la página del evento en Meetup</a>.', 'wpbilbao'), $resumenUrlMeetup); ?></p>
    </div> <!-- .enlace-meetup -->
  <?php endif; ?>

<?php }

genesis();