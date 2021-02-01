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
		echo "<h2>Hello world</h2>";
	}

	public function onLoad() {
		// TODO: Implement onLoad() method.
	}

	protected function getPageTitle() {
		return __( 'Settings', 'testpress-lms' );
	}

	protected function getMenuTitle() {
		return __( 'Settings', 'testpress-lms' );
	}
}