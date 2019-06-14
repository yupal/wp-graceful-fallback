<?php


if ( ! defined( 'THEME_SLUG_REQUIRED_PHP_VERSION' ) ) {
	define( 'THEME_SLUG_REQUIRED_PHP_VERSION', '5.6.0' );
}

add_action( 'after_switch_theme', 'theme_slug_check_php_version' );

function theme_slug_check_php_version() {
	// Compare versions.
	if ( version_compare( phpversion(), THEME_SLUG_REQUIRED_PHP_VERSION, '<' ) ) :
		// Theme not activated info message.
		add_action( 'admin_notices', 'theme_slug_php_version_notice' );

		// Switch back to previous theme.
		switch_theme( get_option( 'theme_switched' ) );

		return false;
	endif;
}

function theme_slug_php_version_notice() {
	?>
    <div class="notice notice-alt notice-error notice-large">
        <h4><?php esc_html_e( 'Theme activation failed!', 'theme-text-domain' ); ?></h4>
        <p>
			<?php printf( esc_html__( 'You need to update your PHP version to use the %s.', 'theme-text-domain' ),
				' <strong>Theme Name</strong>' ); ?>
            <br/>
			<?php printf( esc_html__( 'Current php version is: %1$s and the mininum required version is %2$s',
				'theme-text-domain' ),
				"<strong>" . phpversion() . "</strong>",
				"<strong>" . THEME_SLUG_REQUIRED_PHP_VERSION . "</strong>" );
			?>

        </p>
    </div>
	<?php
}

if ( version_compare( phpversion(), THEME_SLUG_REQUIRED_PHP_VERSION, '>=' ) ) {
	// if minimum php version checked load the real functions.php file
	require_once get_template_directory() . "/inc/functions.php";
} else {
	// add message about the server limitations
	add_action( 'admin_notices', 'theme_slug_php_version_notice' );
}