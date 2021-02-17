<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codewithkarthik.com
 * @since      1.0.0
 *
 * @package    Testpress_Lms
 * @subpackage Testpress_Lms/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Testpress_Lms
 * @subpackage Testpress_Lms/includes
 * @author     Karthik <rajakarthik131@gmail.com>
 */
class Testpress_Lms_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		add_option('testpress_login_label', "My Courses");
		add_option('testpress_login_label', true);
	}

}
