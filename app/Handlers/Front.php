<?php

namespace StarterKit\Handlers;

use StarterKit\Helper\Assets;
use StarterKit\Helper\Utils;
use StarterKit\Helper\View;

/**
 * Basic Front handlers
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Front {
	
	/**
	 * Add site icon from customizer
	 *
	 * @return void
	 **/
	public static function add_site_icon() {
		
		if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
			wp_site_icon();
		}
		
	}
	
	/**
	 * Load JavaScript and CSS files in a front-end
	 *
	 * @return void
	 **/
	public static function load_assets() {
		
		// JS scripts
		Assets::enqueue_script( 'jquery' );
		
		Assets::enqueue_script_dist( 'starter-kit-front', 'app.min.js', [ 'jquery' ] );
		
		$js_vars = [
			'ajaxurl'    => esc_url( admin_url( 'admin-ajax.php' ) ),
			'assetsPath' => get_template_directory_uri() . '/assets',
		];
		
		Assets::enqueue_script( 'starter-kit-front' );
		wp_localize_script( 'starter-kit-front', 'themeJsVars', $js_vars );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			Assets::enqueue_script( 'comment-reply' );
		}
		
		if ( self::antispam_enabled() === 1 ) {
			Assets::enqueue_script(
				'starter-kit-antispam',
				'assets/js/antispam.js',
				[
					'jquery',
				],
				Utils::getConfigSetting( 'cache_time', '' ),
				true
			);
		}
		
		
		// CSS styles
		Assets::enqueue_style_dist( 'starter-kit-libs', 'libs.css' );
		Assets::enqueue_style_dist( 'starter-kit-front', 'front.css' );
		
	}
	
	
	public static function load_critical_css() {
		
		if ( self::inline_critical_css() === 1 ) {
			$path = get_template_directory() . '/dist/css/critical.css';
			if ( is_file( $path ) && $css = file_get_contents( $path ) ) {
				wp_register_style( 'starter-kit-critical', false );
				wp_enqueue_style( 'starter-kit-critical' );
				wp_add_inline_style( 'starter-kit-critical', apply_filters( 'StarterKit/critical_css', $css ) );
			}
		} else {
			Assets::enqueue_style_dist( 'starter-kit-critical', 'critical.css' );
		}
	}
	
	/**
	 * Check if Inline critical css enabled in theme options
	 *
	 * @return int
	 */
	public static function inline_critical_css() {
		return (int) Utils::get_option( 'inline_critical_css', 0 );
	}
	
	/**
	 * Check if anti-spam enabled in theme options
	 *
	 * @return int
	 */
	public static function antispam_enabled() {
		return (int) Utils::get_option( 'forms_antispam', 0 );
	}
	
	/**
	 * Remove no needed default js and styles
	 *
	 * @return void
	 */
	public static function remove_assets() {
		
		// disable huge default JS composer styles
		wp_dequeue_style( 'js_composer_front' );
		wp_dequeue_style( 'animate-css' );
		
		if ( class_exists( 'Classic_Editor' ) ) {
			wp_dequeue_style( 'wp-block-library' );
		}
		
	}
	
	/**
	 * Change excerpt More text
	 *
	 * @param $more
	 *
	 * @return string
	 */
	public static function change_excerpt_more( $more ) {
		return '…';
	}
	
	/**
	 * Remove jquery migrate for optimization reasons
	 *
	 * @param $scripts
	 */
	public static function dequeue_jquery_migrate( $scripts ) {
		if ( ! is_admin() ) {
			$scripts->remove( 'jquery' );
			$scripts->add( 'jquery', false, [ 'jquery-core' ], '1.10.2' );
		}
	}
	
	/**
	 * @param \PHPMailer $phpmailer
	 *
	 * @return null|\PHPMailer
	 */
	public static function antispam_form( $phpmailer ) {
		
		if ( self::antispam_enabled() !== 1 ) {
			return null;
		}

		$date_utc = new \DateTime("now", new \DateTimeZone("UTC"));

		$code = ($date_utc->format('H') +1) * $date_utc->format('d') * $date_utc->format('m') * $date_utc->format('Y');

		if ( ! empty( $_POST ) && ! empty($_POST['as_code']) && $_POST['as_code'] == $code )  {
			return null;
		}

		$phpmailer->clearAllRecipients();

		return $phpmailer;
	}
	
	
	/**
	 * Load Google Tag Manager
	 **/
	public static function add_gtm_head() {
		$tag_manager_code = Utils::get_option( 'tag_manager_code', '' );
		
		if ( ! empty( $tag_manager_code ) ) {
			View::load( '/template-parts/analytics/gtm',
				[ 'head' => true, 'tag_manager_code' => $tag_manager_code ] );
		}
		
	}
	
	/**
	 * add GTM after open <body> tag
	 */
	public static function add_gtm_body() {
		$tag_manager_code = Utils::get_option( 'tag_manager_code', '' );
		
		if ( ! empty( $tag_manager_code ) ) {
			View::load( '/template-parts/analytics/gtm',
				[ 'head' => false, 'tag_manager_code' => $tag_manager_code ] );
		}
		
	}
	
	/**
	 * add Google Analytics code to head
	 */
	public static function add_analytics_head() {
		$analytics_code = Utils::get_option( 'analytics_code', '' );
		
		if ( ! empty( $analytics_code ) ) {
			View::load( '/template-parts/analytics/analytics', [ 'analytics_code' => $analytics_code ] );
		}
		
	}
	
}
