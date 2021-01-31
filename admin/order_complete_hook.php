<?php

//webhook calls after order complete successfully!
add_action( 'woocommerce_thankyou', 'after_order_complete', 10, 1 );

function after_order_complete( $order_id ) {
	check_user( $order_id );
}

function send_order_details( $order_id ) {
	$endpoint = 'https://hookb.in/8Pw3XOre8QFBWWYjD0xM';
	$order    = get_order( $order_id );
	if ( $order ) {
		$requestItem                 = new stdClass();
		$requestItem->order_id       = $order->get_id();
		$requestItem->order_total    = $order->get_total();
		$requestItem->order_currency = $order->get_currency();
		// call remote endpoint to update
		post_endpoint_request( $requestItem, $endpoint );
	}
}

function update_user() {
	$endpoint = 'https://hookbin.com/xYPrkQxGRXc7zzYJe81E';
	$user     = wp_get_current_user();
	update_user_meta( $user->ID, 'user_type', 'testpress', '' );
	if ( $user ) {
		$requestItem                 = new stdClass();
		$requestItem->user_id        = $user->ID;
		$requestItem->user_email     = $user->user_email;
		$requestItem->user_firstname = $user->first_name;
		$requestItem->user_last_name = $user->last_name;
		// call remote endpoint to update
		post_endpoint_request( $requestItem, $endpoint );
	}
}

function check_user( $order_id ) {
	$user      = wp_get_current_user();
	$user_type = $user->user_type;
	if ( ! empty( $user_type ) ) {
		update_user_details();
		send_order_details( $order_id );
	} else {
		send_order_details( $order_id );
	}

}

function get_order( $order_id ) {
	// get order detail
	$order = wc_get_order( $order_id );

	if ( empty( $order ) ) {
		return;
	} else {
		return $order;
	}

}


function post_endpoint_request( $requestItem, $endpoint ) {
	try {
		wp_remote_post(
			$endpoint, array(
				'method'  => 'POST',
				'timeout' => 20,
				'body'    => wp_json_encode( $requestItem )
			)
		);
	} catch ( \Exception $e ) {

	}
}



