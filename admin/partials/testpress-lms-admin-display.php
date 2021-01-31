<div>
    <h2><?php esc_attr_e( 'Products', 'WpAdminStyle' ); ?></h2>
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="nds_add_user_meta_form">

        <input type="hidden" name="action" value="product_form_response">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'nonce' ) ?>"/>

        <table class="widefat">
            <thead>
            <tr>
                <th class="row-title"><?php esc_attr_e( 'Icon' ); ?></th>
                <th><?php esc_attr_e( 'Name' ); ?></th>
                <th><?php esc_attr_e( 'Input' ); ?></th>
            </tr>
            </thead>
            <tbody>
			<?
			while ( $this->products->have_posts() ) : $this->products->the_post();
				?>
                <tr>
                    <td class="row-title"><label for="tablecell"><span
                                    class='wp-post-image'><?php echo woocommerce_get_product_thumbnail(); ?></span></label>
                    </td>
                    <td class="row-title"><label for="tablecell">
                            <post_id
                            ?php echo get_the_title(); ?></label></td>
                    <td><input id="" type="text" name="input" value="" placeholder=""/></td>
                </tr>
			<? endwhile; ?>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                 value="Submit Form"></p>
    </form>
</div>