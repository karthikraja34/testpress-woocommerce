<?php

//webhook calls after order complete successfully!
add_action( 'woocommerce_thankyou', 'after_order_complete', 10, 1 );

function after_order_complete( $order_id ) {
	$user     = wp_get_current_user();
	delete_user_meta( $user->ID, "testpress_user_id" );

	if ( !is_user_registered( $user )) {
		$url      = get_option( 'testpress_base_url' ) . "api/v2.2/admin/users/?email=" . $user->user_email;
		$response = get_request( $url );
		$result   = json_decode( $response->getBody()->getContents() );

		if ( $result->count == 0 ) {
			$response = create_testpress_user( $user );
			$result   = json_decode( $response->getBody()->getContents() );
			update_user_meta( $user->ID, "testpress_user_id", $result->id );
		} else {
			update_user_meta( $user->ID, "testpress_user_id", $result->results[0]->id );
		}
	}
	assign_courses_to_user($user, $order_id);
}

function assign_courses_to_user($user, $order_id) {
	$testpress_user_id = get_user_meta($user->ID, 'testpress_user_id', true);
	$endpoint = get_option("testpress_base_url") . "api/v2.5/admin/users/${testpress_user_id}/courses/";

	$order      = wc_get_order( $order_id );
	$items      = $order->get_items();
	$course_ids = array();
	foreach ( $items as $item ) {
		$product_id = $item->get_product_id();
		$courses    = get_post_meta( $product_id, "courses", true );
		foreach ( $courses as $course ) {
			$course_ids[] = $course["id"];
		}
	}

	$requestItem                     = new stdClass();
	$requestItem->courses           = $course_ids;
	post_endpoint_request( $requestItem, $endpoint );
}

function create_testpress_user( $user ) {
	$url                       = get_option( 'testpress_base_url' ) . "api/v2.5/admin/users/";
	$user_meta                 = get_user_meta( $user->ID );
	$requestItem               = new stdClass();
	$requestItem->username     = $user->user_email;
	$requestItem->email     = $user->user_email;
	$requestItem->first_name   = $user_meta['first_name'][0];
	$requestItem->last_name    = $user_meta['last_name'][0];
	$requestItem->phone_number = $user_meta['billing_phone'][0];
	$requestItem->password     = generateRandomString( 8 );
	return post_endpoint_request( $requestItem, $url );
}

function generateRandomString( $length = 10 ) {
	return substr( str_shuffle( str_repeat( $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil( $length / strlen( $x ) ) ) ), 1, $length );
}


function is_user_registered( $user ) {
	return get_user_meta( $user->ID, 'testpress_user_id', true );
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

function get_request( $endpoint ) {
	$client   = new \GuzzleHttp\Client();
	$response = $client->request( 'GET', $endpoint, [
		'headers' => [
			'Authorization' => 'JWT ' . get_option( 'testpress_auth_token' )
		]
	] );

	return $response;
}

function post_endpoint_request( $requestItem, $endpoint ) {
	$client   = new \GuzzleHttp\Client();
	$response = $client->request( 'POST', $endpoint, [
		'json'    => $requestItem,
		'headers' => [
			'Authorization' => 'JWT ' . get_option( 'testpress_auth_token' )
		]
	] );

	return $response;
}



