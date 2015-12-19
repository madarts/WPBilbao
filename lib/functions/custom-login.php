<?php

// CUSTOM LOGIN STYLES

// LOGIN - custom style
function wpbilbao_login_style() { ?>
	<style>
    .login h1 a {
      background-image: url(http://www.wpbilbao.es/wp-content/uploads/2015/11/wordpress-bilbao-favicon-high.png);
    }

    #login .cimy_uef_input_27,
    #login .cimy_uef_picture,
    .login form .input,
    .login input[type=text] {
    	font-size: 12px;
    	padding: 8px 3px;
    }

    #login h2 {
    	margin-top: 20px;
    }

    #registerform p.submit {
    	text-align: center !important;
    }

    	#registerform .submit .button {
    		float: none;
    	}

    /* Just show the Background Image hover 700px for the rest the basic grey */
    @media (min-width: 700px) {
    	.login {
    		background: url(http://www.wpbilbao.es/wp-content/themes/wpbilbao/images/login/wordpress-bilbao-login-background.jpg) no-repeat center center fixed;
			  -webkit-background-size: cover;
			  -moz-background-size: cover;
			  -o-background-size: cover;
			  background-size: cover;
    		height: 100%;
    	}
      
			#login {
				width: 500px;
			}

			#nav,
			#backtoblog {
				text-align: center;
			}
				#nav a,
				#backtoblog a {
					color: #ffffff !important;
				}
    }
  </style>
<?php }
add_action('login_head', 'wpbilbao_login_style');


// CUSTOM LOGIN FORM

/* changes the "Register For This Site" text on the WordPress login screen (wp-login.php) */
function wpbilbao_change_login_message($message)
{
	// change messages that contain 'Register'
	if (strpos($message, 'Regístrate') !== FALSE) {
		$newMessage = __('¡Hola! Rellena el siguiente formulario para ser un nuevo miembro de WordPress Bilbao.', 'wpbilbao' );
		return '<p class="message register">' . $newMessage . '</p>';
	}
	else {
		return $message;
	}
}

// add our new function to the login_message hook
add_action('login_message', 'wpbilbao_change_login_message');
?>