<div>
    <h2><?php esc_attr_e( 'Products', 'WpAdminStyle' ); ?></h2>
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="nds_add_user_meta_form">

        <input type="hidden" name="action" value="product_form_response">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'nonce' ) ?>"/>

    <h2><?php _e( 'WordPress HTML form POST request via wp-admin/admin-post.php', $this->plugin_name ); ?></h2>
    <div class="nds_add_user_meta_form">

		<?php if ( isset( $_GET['nds_admin_add_notice'] ) ) : ?>
            <div class="notice notice-success is-dismissible"><p><?php _e( 'Something happened!' ); ?>.</p></div>
		<?php endif; ?>
		<?php echo get_option( 'testpress_auth_token' ) ?>
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post"
              id="nds_add_user_meta_form">
            <input type="hidden" name="action" value="nds_form_response">
            <input type="hidden" name="nds_add_user_meta_nonce"
                   value="<?php echo wp_create_nonce( 'nds_add_user_meta_form_nonce' ) ?>"/>
            <div>
                <label for="<?php echo $this->plugin_name; ?>-subdomain"> <?php _e( 'Enter testpress subdomain', $this->plugin_name ); ?> </label><br>
                <input required id="<?php echo $this->plugin_name; ?>-subdomain" type="text"
                       name="<?php echo "testpress"; ?>-subdomain" value=""
                       placeholder="<?php _e( 'Enter Testpress Subdomain', $this->plugin_name ); ?>"/><br>
            </div>
            <div>
                <label for="<?php echo $this->plugin_name; ?>-username"> <?php _e( 'Username', $this->plugin_name ); ?> </label><br>
                <input required id="<?php echo $this->plugin_name; ?>-username" type="text"
                       name="<?php echo "testpress"; ?>-username" value=""
                       placeholder="<?php _e( 'Enter testpress admin username', $this->plugin_name ); ?>"/><br>
            </div>
            <div>
                <label for="<?php echo $this->plugin_name; ?>-password"> <?php _e( 'password', $this->plugin_name ); ?> </label><br>
                <input required id="<?php echo $this->plugin_name; ?>-password" type="password"
                       name="<?php echo "testpress"; ?>-password" value=""
                       placeholder="<?php _e( 'Enter testpress admin password', $this->plugin_name ); ?>"/><br>
            </div>
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                     value="Submit Form"></p>
        </form>
        <br/><br/>
        <div id="nds_form_feedback"></div>
        <br/><br/>
    </div>
<?php
