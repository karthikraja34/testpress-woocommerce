 <?php

 function test_admin_menu() {
    add_menu_page('Test','TestPlugin','manage_options','test-admin-menu','test_admin_menu_main','dashicons-cart',4);
 }
   add_action('admin_menu','test_admin_menu');

   function test_admin_menu_main(){
           echo '<div class ="wrap">Hello Hello</div>';
   }

   ?>