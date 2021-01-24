<?php

         add_action('woocommerce_thankyou',  'order_completed', 10, 1);

        function order_completed($order_id)
       {

          order_update($order_id, 'https://hookb.in/eKRqmaLE9XteYYRdXW6z');
       }

       function order_update($order_id, $endpoint) {
          $order = wc_get_order($order_id);

          if ( empty( $order ) ) {
              return;
          }

          $requestItem = new stdClass();
          $requestItem->order_id = $order->get_id();
          $requestItem->order_total = $order->get_total();
          $requestItem->order_currency = $order->get_currency();

          // call remote endpoint to update
          remote_post_api($requestItem, $endpoint);
      }


        function remote_post_api($requestItem, $endpoint) {
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



?>