<?php
//* Remove user profile options
function remove_website_row_wpse_94963_css() { ?>
  <style>
    h3:first-of-type,
    .form-table:first-of-type,
    tr.user-url-wrap,
    tr.user-admin-color-wrap,
    tr.show-admin-bar,
    label[for="user_lang"],
    #user_lang,
    tr.user-googleplus-wrap,
    tr.user-description-wrap {
      display: none;
    }

    .description strong {
      color: red;
    }
  </style>
<?php }

add_action('admin_head-user-edit.php', 'remove_website_row_wpse_94963_css');
add_action('admin_head-profile.php', 'remove_website_row_wpse_94963_css');