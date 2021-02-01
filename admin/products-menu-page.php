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


class ProductsMenuPage extends AbstractMenuPage {
	private $products;

	public function __construct( $name, $atts = array() ) {
		$this->products = [];
		parent::__construct( $name, $atts );
	}

	public function onLoad() {
		// TODO: Implement onLoad() method.
	}

	private function get_products() {
		$request_product_number = - 1;
		$get_product_query = array(
			'post_type'      => 'product',
			'posts_per_page' => $request_product_number
		);
		$productslist = new WP_Query( $get_product_query );

		wp_reset_query();
		return $productslist;
	}

	public function rudr_get_posts_ajax_callback() {
		$return = array();

	}

	public function render() {
		$this->products = $this->get_products();
		require_once plugin_dir_path( __FILE__ ) . 'partials/testpress-lms-admin-display.php';
	}

	protected function getMenuTitle() {
		return __( 'Testpress', 'testpress-lms' );
	}

	protected function getPageTitle() {
		return __( 'Testpress', 'testpress-lms' );
	}
}