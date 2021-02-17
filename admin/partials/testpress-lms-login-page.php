<div>
    <div class="login-page">
        <div style="text-align:center">
            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/testpress_logo.png'; ?>">
        </div>

        <div class="form">

            <form class="login-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post"
                  id="nds_add_user_meta_form">
                <input type="hidden" name="action" value="nds_form_response">
                <input type="hidden" name="nds_add_user_meta_nonce"
                       value="<?php echo wp_create_nonce( 'nds_add_user_meta_form_nonce' ) ?>"/>
                <div class="form-group">
                    <label for="testpress-subdomain">Enter testpress subdomain</label>
                    <input required id="<?php echo $this->plugin_name; ?>-subdomain" type="text"
                           name="<?php echo "testpress"; ?>-subdomain" value="">
                    <p class="description">For ex: demo</p>
                </div>
                <div class="form-group">
                    <label for="testpress-username">Enter testpress username</label>
                    <input required id="<?php echo $this->plugin_name; ?>-username" type="text"
                           name="<?php echo "testpress"; ?>-username" value=""/>
                </div>
                <div class="form-group">
                    <label for="testpress-username">Enter testpress password</label>
                    <input required id="<?php echo $this->plugin_name; ?>-password" type="password"
                           name="<?php echo "testpress"; ?>-password" value="">
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary"
                       value="Login">
            </form>
        </div>
    </div>
<?php
