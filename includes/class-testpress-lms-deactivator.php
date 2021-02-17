<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://codewithkarthik.com
 * @since      1.0.0
 *
 * @package    Testpress_Lms
 * @subpackage Testpress_Lms/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Testpress_Lms
 * @subpackage Testpress_Lms/includes
 * @author     Karthik <rajakarthik131@gmail.com>
 */
class Testpress_Lms_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option("testpress_base_url");
		delete_option("testpress_auth_token");
		delete_option("testpress_private_key");
	}

}
