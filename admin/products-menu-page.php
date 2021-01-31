<?php
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

// require plugin_dir_path( __FILE__ ) . 'abstract-menu-page.php';

class ProductsMenuPage extends AbstractMenuPage {
	private $products;
    private $formsubmit;
	public function __construct( $name, $atts = array() ) {
		$products = [];
		parent::__construct( $name, $atts );

	}

	public function onLoad() {
		// TODO: Implement onLoad() method.
	}

	private function get_products() {
		$request_product_number = - 1;

		//request to products from table

		$get_product_query = array(
			'post_type'      => 'product',
			'posts_per_page' => $request_product_number
		);
		$productslist      = new WP_Query( $get_product_query );

		wp_reset_query();

		return $productslist;

	}

	public function process_form_response(){


		if( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'nonce') ) {


				$admin_notice = "success";

			// redirect the user to the appropriate page
			$this->custom_redirect( $admin_notice, $_POST );
			exit;

			// add the admin notice

		}
		else {
			wp_die( __( 'Invalid nonce specified', $this->name), __( 'Error', $this->name ), array(
				'response' 	=> 403,
				'back_link' => 'admin.php?page=' . $this->name,

			) );
		}

	}

	public function custom_redirect( $admin_notice, $response ) {
		wp_redirect( esc_url_raw( add_query_arg( array(
			'product_admin_add_notice' => $admin_notice,
		),
			admin_url('admin.php?page='. $this->name )
		) ) );

	}

	public function render() {
		$this->products = $this->get_products();
		require_once plugin_dir_path( __FILE__ ) . 'partials/testpress-lms-admin-display.php';
	}

	protected function getMenuTitle() {
		return __( 'Testpress LMS', 'testpress-lms' );
	}

	protected function getPageTitle() {
		return __( 'Testpress LMS', 'testpress-lms' );
	}
}