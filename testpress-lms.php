<?php

/*  
* Plugin Name: Testpress LMS  
* Plugin URI:  
* Description: Integrate Testpress LMS into your WooCommerce site
* Author: Karthik  
* Version: 1.0.0  
* Author URI:  
* License: GPL3+  
* Text Domain:  
* Domain Path: /languages/  
*/

if (!defined('ABSPATH')) exit;

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    if (!class_exists('WC_Testpress_LMS')) {

        class WC_Testpress_LMS
        {
            public function __construct()
            {
            }
        }
    }
}
