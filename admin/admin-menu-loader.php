
 <?php

 function test_admin_menu() {
    add_menu_page('Test','TestPlugin','manage_options','test-admin-menu','admin_menu_main','dashicons-cart',4);
 }
   add_action('admin_menu','test_admin_menu');


   function admin_menu_main() {

         get_products();

   }

   function get_products() {
    $query = array(
                  'post_type'      => 'product',
                  'posts_per_page' => -1
              );
              $productslist = new WP_Query( $query );
              wp_reset_query();

            if ( empty( $productslist ) ) {
              return;
           } else {
                 product_table($productslist);
           }

   }

      function product_table($productslist) {

       ?>  <div class="wrap">
                 <h2><?php esc_attr_e( 'Products', 'WpAdminStyle' ); ?></h2>
                 <table class="widefat">
                 	<thead>
                 	<tr>
                 		<th class="row-title"><?php esc_attr_e( 'Icon' ); ?></th>
                 		<th><?php esc_attr_e( 'Name' ); ?></th>
                 		<th><?php esc_attr_e( 'SKU' ); ?></th>
                 		<th><?php esc_attr_e( 'Price' ); ?></th>
                 		<th><?php esc_attr_e( 'Stock' ); ?></th>
                 	</tr>
                 	</thead>
                 	<tbody>
                 	<?
                 	while ( $productslist->have_posts() ) : $productslist->the_post();
                                     global $product; ?>
                 	<tr>
                 	<td class="row-title"><label for="tablecell"><span class='wp-post-image'><?php echo woocommerce_get_product_thumbnail(); ?></span></label></td>
                     <td class="row-title"><label for="tablecell"><?php echo get_the_title(); ?></label></td>
                     <td class="row-title"><label for="tablecell"><?php echo  $product->get_sku(); ?></label></td>
                     <td class="row-title"><label for="tablecell"><?php echo  $product->get_regular_price(); ?></label></td>
                     <td class="row-title"><label for="tablecell"><?php echo  $product->get_stock_status(); ?></label></td>
                 	</tr>
                 	 <? endwhile; ?>
                 	</tbody>
                 </table>
                 </div>
      <?
      }

   ?>

