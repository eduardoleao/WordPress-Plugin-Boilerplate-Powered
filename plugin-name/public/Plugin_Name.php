<?php

/**
 * Plugin_Name
 *
 * @package   Plugin_Name
 * @author    {{author_name}} <{{author_email}}>
 * @copyright {{author_copyright}}
 * @license   {{author_license}}
 * @link      {{author_url}}
 */

/**
 * This class should ideally be used to work with the public-facing side of the WordPress site.
 */
class Plugin_Name {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	private static $instance;
	//WPBPGen{{#unless libraries_johnbillion__extended-cpts}}
	/**
	 * Array of cpts of the plugin
	 *
	 * @var array
	 */
	protected $cpts = array( 'demo' );

	//{{/unless}}

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since {{plugin_version}}
	 * 
	 * @return void
	 */
	public static function initialize() {
		//WPBPGen{{#unless frontend_body-class}}
		add_filter( 'body_class', array( __CLASS__, 'add_pn_class' ), 10, 3 );
		//{{/unless}}
		//WPBPGen{{#unless public-assets_css && public-assets_js && frontend_wp-localize-script}}
		require_once( PN_PLUGIN_ROOT . 'public/includes/PN_Enqueue.php' );
		//{{/unless}}
		//WPBPGen{{#unless frontend_template-system}}
		// Override the template hierarchy for load /templates/content-demo.php
		add_filter( 'template_include', array( __CLASS__, 'load_content_demo' ) );
		//{{/unless}}
		//WPBPGen{{#unless libraries_wpbp__widgets-helper}}
		require_once( PN_PLUGIN_ROOT . 'public/widgets/sample.php' );
		//{{/unless}}
	}

	//WPBPGen{{#unless libraries_johnbillion__extended-cpts}}
	/**
	 * Return the cpts
	 *
	 * @since {{plugin_version}}
	 *
	 * @return array
	 */
	public function get_cpts() {
		return $this->cpts;
	}

	//{{/unless}}

	/**
	 * Return an instance of this class.
	 *
	 * @since {{plugin_version}}
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			try {
				self::$instance = new self;
				self::initialize();
			} catch ( Exception $err ) {
				do_action( 'plugin_name_failed', $err );

				if ( WP_DEBUG ) {
					throw $err->getMessage();
				}
			}
		}

		return self::$instance;
	}

	//{{/unless}}
	//WPBPGen{{#unless frontend_body-class}}
	/**
	 * Add class in the body on the frontend
	 * 
	 * @param array $classes THe array with all the classes of the page.
	 *
	 * @since {{plugin_version}}
	 * 
	 * @return array
	 */
	public static function add_pn_class( $classes ) {
		$classes[] = PN_TEXTDOMAIN;
		return $classes;
	}

	//{{/unless}}
	//WPBPGen{{#unless frontend_template-system}}
	/**
	 * Example for override the template system on the frontend
	 * 
	 * @param string $original_template The original templace HTML.
	 *
	 * @since {{plugin_version}}
	 * 
	 * @return string
	 */
	public static function load_content_demo( $original_template ) {
		if ( is_singular( 'demo' ) && in_the_loop() ) {
			return wpbp_get_template_part( PN_TEXTDOMAIN, 'content', 'demo', false );
		}
		return $original_template;
	}

	//{{/unless}}
}

/*
 * @TODO:
 *
 * - 9999 is used for load the plugin as last for resolve some
 *   problems when the plugin use API of other plugins, remove
 *   if you don' want this
 */

add_action( 'plugins_loaded', array( 'Plugin_Name', 'get_instance' ), 9999 );
