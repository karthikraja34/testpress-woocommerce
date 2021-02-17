<?php

require plugin_dir_path( __FILE__ ) . 'products-menu-page.php';
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codewithkarthik.com
 * @since      1.0.0
 *
 * @package    Testpress_Lms
 * @subpackage Testpress_Lms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Testpress_Lms
 * @subpackage Testpress_Lms/admin
 * @author     Karthik <rajakarthik131@gmail.com>
 */
class Testpress_Lms_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	private $products_menu_page;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;
	/**
	 * @var LoginPage
	 */
	private $login_page;
	/**
	 * @var DemoPage
	 */
	private $demo_page;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->load_dependencies();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-login-page.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-demo-page.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-users-page.php';
	}

	function just_add_cors_http_header($headers){
		$headers['Access-Control-Allow-Origin'] = '*';

		return $headers;
	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Testpress_Lms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Testpress_Lms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/testpress-lms-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'select2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );
		wp_register_script( 'select2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), '4.0.3', true );
		wp_enqueue_script('select2_js');
	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Testpress_Lms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Testpress_Lms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/testpress-lms-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(  $this->plugin_name, 'productAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

	public function initializeAdminPages() {
		if ( !$this->is_logged_in() ) {
			$this->login_page = new LoginPage( 'testpress-lms', $this->plugin_name );
			add_action( 'admin_post_nds_form_response', array( $this->login_page, 'the_form_response' ) );
		} else {
			$this->products_menu_page = new ProductsMenuPage( 'testpress-products');
			add_action( 'wp_ajax_mishagetposts', array($this->products_menu_page, 'rudr_get_posts_ajax_callback') );
			add_action( 'wp_ajax_update_product_courses', array($this->products_menu_page, 'update_product_courses') );
			add_action( 'wp_ajax_delete_product_courses', array($this->products_menu_page, 'delete_product_courses') );
//			$this->users_page = new UsersPage( 'users', ["parent_menu" => "products"]);
//			add_action( 'wp_ajax_get_users', array($this->users_page, 'get_users_ajax_callback') );
//			add_action( 'wp_ajax_update_user', array($this->users_page, 'update_users') );
			$this->demo_page  = new DemoPage( 'testpress-settings', ["parent_menu" => "testpress-products"]);
		}
	}

	public function is_logged_in() {
		return get_option( 'testpress_auth_token' ) && get_option('testpress_private_key');
	}

	public function process_login_form_response() {
		$this->login_page->the_form_response();
	}

	public function handle_settings_form_response() {
		$this->demo_page->handle_form_response();
	}
}
