<?php

 //webhook calls after order complete successfully!
  add_action('woocommerce_thankyou',  'after_order_complete', 10, 1);

        function after_order_complete($order_id)
       {
           $endpoint =  'https://hookb.in/6JwaZRjaWyfLbb031EQL';

           $order_details = get_order_details($order_id);

            if($order_details) {
                $requestItem = new stdClass();
                $requestItem->order_id = $order_details->get_id();
                $requestItem->order_total = $order_details->get_total();
                $requestItem->order_currency = $order_details->get_currency();

                // call remote endpoint to update
                post_endpoint_request($requestItem, $endpoint);
            }
       }

       function get_order_details($order_id) {
           // get order detail
          $order = wc_get_order($order_id);

          if ( empty( $order ) ) {
              return;
          } else {
              return $order;
          }

      }


        function post_endpoint_request($requestItem, $endpoint) {
              try
              {
                      wp_remote_post(
                          $endpoint, array(
                              'method' => 'POST',
                              'timeout' => 10,
                              'body' => wp_json_encode($requestItem)
                          )
                      );
              } catch (\Exception $e) {

              }
          }



