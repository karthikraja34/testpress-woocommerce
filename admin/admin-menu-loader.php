
 <?php

 function test_admin_menu() {
    add_menu_page('Test','TestPlugin','manage_options','test-admin-menu','admin_menu_main','dashicons-cart',4);
 }
   add_action('admin_menu','test_admin_menu');


   function admin_menu_main() {
         product_table();

   }

      function product_table() {

       ?>  <div class="wrap">
                 <h2><?php esc_attr_e( 'Products', 'WpAdminStyle' ); ?></h2>
                 <table class="widefat">
                 	<thead>
                 	<tr>
                 		<th class="row-title"><?php esc_attr_e( 'Icon' ); ?></th>
                 		<th><?php esc_attr_e( 'Name' ); ?></th>
                 	</tr>
                 	</thead>
                 	<tbody>
                 	<tr>
                 		<td class="row-title"><label for="tablecell"><?php echo'<img class="wp-post-image" src="https://homepages.cae.wisc.edu/~ece533/images/airplane.png"></img>'; ?></label></td>
                     <td class="row-title"><label for="tablecell"><?php esc_attr_e('Shirt'); ?></label></td>
                 	</tr>
                 	</tbody>
                 </table>
                 </div>
      <?
      }

   ?>

