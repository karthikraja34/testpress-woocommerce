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

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

require( dirname( __FILE__ ) . '/../vendor/autoload.php' );

class LoginPage  extends AbstractMenuPage {

	private $plugin_name;
	private $error;

	public function __construct( $name, $plugin_name, $atts = array() ) {
		parent::__construct( $name, $atts );
		$this->plugin_name = $plugin_name;
		$this->error = new WP_Error();
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


		if ( $this->has_valid_nonce() ) {
			// server response

			try {
				$response = $client->request( 'POST', $url, [
					'json' => [ 'username' => $_POST['testpress-username'], 'password' => $_POST['testpress-password'] ],
				] );
			}  catch (ClientException | RequestException $e) {
				$this->error->add('login_error', 'Your login or password is incorrect');
				$this->custom_redirect( "testpress-lms", $this->error->get_error_code(), $_POST );
				exit;
			}
			$admin_notice = $response->getStatusCode();
			$result       = json_decode( $response->getBody()->getContents() );
			update_option( 'testpress_base_url', "https://{$_POST['testpress-subdomain']}.testpress.in/");
			update_option( 'testpress_auth_token', $result->token);
			try {
				$settings_response = $this->get_request("https://{$_POST['testpress-subdomain']}.testpress.in/api/v2.3/admin/settings/");
			}  catch (ClientException | RequestException $e) {
				$this->error->add('login_error', 'This account is not admin account. Please enter admin account details.');
				$this->custom_redirect( "testpress-lms", "login_error", $_POST );
				exit;
			}

			$result       = json_decode( $settings_response->getBody()->getContents() );
			update_option( 'testpress_private_key', $result->private_key);
			$this->custom_redirect( "testpress-products", $admin_notice, $_POST );
			exit;
		} else {
			wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
				'response'  => 403,
				'back_link' => 'admin.php?page=' . $this->plugin_name,
			) );
		}
	}

	function get_request( $endpoint ) {
		$client   = new \GuzzleHttp\Client();
		$response = $client->request( 'GET', $endpoint, [
			'headers' => [
				'Authorization' => 'JWT ' . get_option( 'testpress_auth_token' )
			]
		] );

		return $response;
	}


	/**
	 * Redirect
	 *
	 * @since    1.0.0
	 */
	public function custom_redirect( $page, $admin_notice, $response ) {
		wp_redirect( esc_url_raw( add_query_arg( array(
			'status' => $admin_notice,
			'nds_response'         => $response,
		),
			admin_url( 'admin.php?page='. $page)
		) ) );
	}


	protected function getPageTitle() {
		return __( 'Testpress LMS', 'testpress-lms' );
	}

	protected function getMenuTitle() {
		return __( 'Testpress LMS', 'testpress-lms' );
	}
}