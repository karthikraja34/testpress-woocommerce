<?php

/**
 * Creates the submenu page for the plugin.
 *
 * @package Custom_Admin_Settings
 */

/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package Custom_Admin_Settings
 * @subpackage Testpress_Lms/admin
 * @author     Karthik <rajakarthik131@gmail.com>
 */

require( dirname( __FILE__ ) . '/../vendor/autoload.php' );

class LoginPage  extends AbstractMenuPage {

	private $plugin_name;

	public function __construct( $name, $plugin_name, $atts = array() ) {
		parent::__construct( $name, $atts );
		$this->plugin_name = $plugin_name;
	}

	public function onLoad() {
		// TODO: Implement onLoad() method.
	}


	/**
	 * This function renders the contents of the page associated with the Submenu
	 * that invokes the render method. In the context of this plugin, this is the
	 * Submenu class.
	 */
	public function render() {
		require_once( 'partials/testpress-lms-login-page.php' );
	}


	private function has_valid_nonce() {

		if ( ! isset( $_POST['nds_add_user_meta_nonce'] ) ) { // Input var okay.
			return false;
		}

		$field  = wp_unslash( $_POST['nds_add_user_meta_nonce'] );
		$action = 'nds_add_user_meta_form_nonce';

		return wp_verify_nonce( $field, $action );

	}

	public function the_form_response() {
		$client   = new \GuzzleHttp\Client();
		$url = "https://{$_POST['testpress-subdomain']}.testpress.in/api/v2.3/auth-token/";
		$response = $client->request( 'POST', $url, [
			'json' => [ 'username' => $_POST['testpress-username'], 'password' => $_POST['testpress-password'] ],
		] );

		if ( $this->has_valid_nonce() ) {
			// server response
			$admin_notice = "success";
			$result       = json_decode( $response->getBody()->getContents() );
			update_option( 'testpress_base_url', "https://{$_POST['testpress-subdomain']}.testpress.in/");
			update_option( 'testpress_auth_token', $result->token);
			$this->custom_redirect( $admin_notice, $_POST );
			exit;
		} else {
			wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
				'response'  => 403,
				'back_link' => 'admin.php?page=' . $this->plugin_name,
			) );
		}
	}

	public function my_acf_admin_notice() {
		?>
        <div class="notice error my-acf-notice is-dismissible">
            <p><?php _e( 'ACF is not necessary for this plugin, but it will make your experience better, install it now!', 'my-text-domain' ); ?></p>
        </div>


		<?php
	}

	/**
	 * Redirect
	 *
	 * @since    1.0.0
	 */
	public function custom_redirect( $admin_notice, $response ) {
		wp_redirect( esc_url_raw( add_query_arg( array(
			'nds_admin_add_notice' => $admin_notice,
			'nds_response'         => $response,
		),
			admin_url( 'admin.php?page=' . $this->plugin_name )
		) ) );

	}


	/**
	 * Print Admin Notices
	 *
	 * @since    1.0.0
	 */
	public function print_plugin_admin_notices() {
		$html = '<div class="notice notice-success is-dismissible"> 
				<p><strong>The request was successful. </strong></p><br>';
		$html .= '<pre>' . htmlspecialchars( print_r( $_REQUEST['nds_response'], true ) ) . '</pre></div>';
		echo $html;
	}

	protected function getPageTitle() {
		return __( 'Testpress LMS', 'testpress-lms' );
	}

	protected function getMenuTitle() {
		return __( 'Testpress LMS', 'testpress-lms' );
	}
}