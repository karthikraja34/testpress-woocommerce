<?php


class DemoPage extends AbstractMenuPage {

	private $plugin_name;

	public function __construct( $name, $atts = array() ) {
		parent::__construct( $name, $atts );
	}

	/**
	 * This function renders the contents of the page associated with the Submenu
	 * that invokes the render method. In the context of this plugin, this is the
	 * Submenu class.
	 */
	public function render() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/settings-page.php';
	}

	public function onLoad() {
		// TODO: Implement onLoad() method.
	}

	private function has_valid_nonce() {

		if ( ! isset( $_POST['nds_add_user_meta_nonce'] ) ) { // Input var okay.
			return false;
		}

		$field  = wp_unslash( $_POST['nds_add_user_meta_nonce'] );
		$action = 'nds_add_user_meta_form_nonce';

		return wp_verify_nonce( $field, $action );

	}


	public function handle_form_response() {
		if ( $this->has_valid_nonce() ) {
			$admin_notice = "success";
			if (isset($_POST["enable_testpress_login"])) {
				update_option( 'enable_testpress_login', 1);
			} else {
				update_option( 'enable_testpress_login', 0);
			}
			update_option( 'testpress_login_label', $_POST["testpress_login_label"] );
			$this->custom_redirect( $admin_notice, $_POST );
			exit;
		} else {
			wp_die( __( 'Invalid nonce specified', $this->name ), __( 'Error', $this->name ), array(
				'response'  => 403,
				'back_link' => 'admin.php?page=' . $this->name,
			) );
		}
	}

	public function custom_redirect( $admin_notice, $response ) {
		wp_redirect( esc_url_raw( add_query_arg( array(
			'nds_admin_add_notice' => $admin_notice,
			'nds_response'         => $response,
		),
			admin_url( 'admin.php?page=' . $this->name )
		) ) );

	}

	protected function getPageTitle() {
		return __( 'Settings', 'testpress-lms' );
	}

	protected function getMenuTitle() {
		return __( 'Settings', 'testpress-lms' );
	}
}