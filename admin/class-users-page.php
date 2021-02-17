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


class UsersPage extends AbstractMenuPage {
	private $users;

	public function __construct( $name, $atts = array() ) {
		parent::__construct( $name, $atts );

	}

	public function onLoad() {
		// TODO: Implement onLoad() method.
	}

	private function get_users() {
		$args = array(
			'order'   => 'ASC'
		);
		return get_users( $args );
	}

	public function render() {
		$this->users = $this->get_users();
		require_once plugin_dir_path( __FILE__ ) . 'partials/users-page.php';
	}


	public function get_users_ajax_callback($query) {
		$client   = new \GuzzleHttp\Client();
		$url = get_option("testpress_base_url")."api/v2.5/admin/users/?q=" . $_GET["q"];
		$response = $client->request( 'GET', $url, [
			'headers' => [ 'Authorization' => 'JWT '. get_option("testpress_auth_token") ],
		] );
		wp_send_json(json_decode($response->getBody()->getContents()));
	}

	public function update_users($data) {
		wp_send_json_success(true);
	}


	protected function getMenuTitle() {
		return __( 'Users', 'testpress-lms' );
	}

	protected function getPageTitle() {
		return __( 'Users', 'testpress-lms' );
	}
}