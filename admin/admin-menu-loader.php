
 <?php

  add_action('admin_menu','test_admin_menu');

 function test_admin_menu() {
 //webhook function to add plugin in mainmenu
    add_menu_page('Test','TestPlugin','manage_options','test-admin-menu','dispaly_products','dashicons-cart',4);
 }

   function get_products() {
       $request_product_number = -1;

   //request to products from table

    $get_product_query = array(
                  'post_type'      => 'product',
                  'posts_per_page' => $request_product_number
              );
              $productslist = new WP_Query( $get_product_query );

              wp_reset_query();

       return $productslist;

   }

      function dispaly_products() {

          $all_products =   get_products();

          echo  '<div class="wrap">
                 <h2>'.esc_attr_e( 'Products', 'WpAdminStyle' ).'</h2>
                 <table class="widefat">
                 	<thead>
                 	<tr>
                 		<th class="row-title">'. esc_html( 'Icon' ).'</th>
                 		<th>'. esc_html( 'Name' ).'</th>
                 		<th>'. esc_html( 'SKU' ).'</th>
                 		<th>'. esc_html( 'Price' ).'</th>
                 		<th>'. esc_html( 'Stock' ).'</th>
                 	</tr>
                 	</thead>
                 	<tbody>';

          while ( $all_products->have_posts())  : $all_products->the_post();
              global $product;
              echo'<tr>
                 	<td class="row-title"><label for="tablecell"><span>'.woocommerce_get_product_thumbnail().'</span></label></td>
                     <td class="row-title"><label for="tablecell">'.esc_html(get_the_title()).'</label></td>
                     <td class="row-title"><label for="tablecell">'.esc_html($product->get_sku()).'</label></td>
                     <td class="row-title"><label for="tablecell">'.esc_html($product->get_regular_price()).'</label></td>
                     <td class="row-title"><label for="tablecell">'.esc_html($product->get_stock_status()).'</label></td>
                 	</tr>';
          endwhile;
          echo'</tbody>
                 </table>
                 </div>';
      }


