<?php
?>

<div class="header">
    <h2><?php esc_attr_e( 'Settings', 'WpAdminStyle' ); ?></h2>
</div>


<div class="wrap">
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="nds_add_user_meta_form">

        <input type="hidden" name="action" value="testpress_settings_form">
        <input type="hidden" name="nds_add_user_meta_nonce"
               value="<?php echo wp_create_nonce( 'nds_add_user_meta_form_nonce' ) ?>"/>
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label for="input-text">Enable testpress login for user ?</label>
                </th>
                <td>
                    <input name="enable_testpress_login" type="checkbox" value="1" <?php checked( '1', get_option( 'enable_testpress_login' ) ); ?> />
                </td>
            </tr>
            <tr>
                <th>
                    <label for="input-text">Testpress Login Label</label>
                </th>
                <td>
                    <input type="text" value="<?php echo get_option('testpress_login_label') ?>" name="testpress_login_label" placeholder="Enter the label for testpress login button"><br>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <input type="submit" value="Submit" class="button-primary" />
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>