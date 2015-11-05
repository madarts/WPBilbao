<?php
// Customize the entire footer
remove_action('genesis_footer', 'genesis_do_footer');
add_action('genesis_footer', 'wpbilbao_custom_footer');
function wpbilbao_custom_footer() { ?>
  <p>Copyright <?php echo do_shortcode('[footer_copyright]'); ?> - <?php _e('Comunidad WordPress Bilbao', 'wpbilbao'); ?></p>
  <p>
    <a href="<?php echo site_url(); ?>/politica-de-privacidad/" title="<?php _e('Política de Privacidad', 'wpbilbao'); ?>" rel="nofollow"><?php _e('Política de Privacidad', 'wpbilbao'); ?></a> ·
    <a href="<?php echo site_url(); ?>/aviso-legal/" title="<?php _e('Aviso Legal', 'wpbilbao'); ?>" rel="nofollow"><?php _e('Aviso Legal', 'wpbilbao'); ?></a> ·
    <a href="<?php echo site_url(); ?>/politica-de-cookies/" title="<?php _e('Política de Cookies', 'wpbilbao'); ?>" rel="nofollow"><?php _e('Política de Cookies', 'wpbilbao'); ?></a>
  </p>
  <?php
}