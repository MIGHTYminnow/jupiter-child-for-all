<?php
defined( 'ABSPATH' ) || exit;

class Jupiter_All {

	public function __construct() {
		$this->updater();
		$this->helpers();
		$this->hooks();
	}

	private function updater() {
		require_once( JUPITER_ALL_PATH . '/includes/class-github-plugin-updater.php' );
		if ( is_admin() ) {
			new GitHubPluginUpdater( JUPITER_ALL_PATH . '/includes/class-github-plugin-updater.php', 'MIGHTYminnow', "jupiter-for-all", '42568449eebe76dafadf7f42a2096aa7a0e228b0' );
		}
	}

	private function helpers() {
		include JUPITER_ALL_PATH . '/framework/helpers/global.php';
		include JUPITER_ALL_PATH . '/framework/helpers/wp_head.php';
		include JUPITER_ALL_PATH . '/includes/helpers/template-part-helpers.php';
	}

	private function hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'mk_theme_after_body_opening', array( $this, 'skip_to_links' ) );
		$files = scandir( JUPITER_ALL_PATH . '/vc-shortcodes/' );
		foreach ( $files as $file ) {
			if ( ! is_dir( $file ) ) {
				$file = basename( $file, '.php' );
				add_filter( "vc_shortcode_set_template_{$file}", array( $this, 'vc_shortcode_set_template' ) );
			}
		}
	}

	public function enqueue_assets() {
		wp_enqueue_style( 'j4a', JUPITER_ALL_URL . 'css/j4a.css', array(), null );
		wp_enqueue_script( 'j4a', JUPITER_ALL_URL . 'js/j4a.js', array( 'jquery' ), null, true );
	}

	public function skip_to_links() {
		mk_get_template_part( 'parts/header/global/skip-to-links' );
	}

	public function vc_shortcode_set_template( $template ) {
		return JUPITER_ALL_PATH . '/vc-shortcodes/' . basename( $template );
	}

}
