<?php header( "Access-Control-Allow-Origin: *" ); ?>
<div>
    <style>
        .column-thumb {
            width: 52px;
            text-align: center;
            white-space: nowrap;
        }
         .column-thumb img {
            margin: 0;
            width: auto;
            height: auto;
            max-width: 40px;
            max-height: 40px;
            vertical-align: middle;
        }
    </style>
	<?php add_thickbox(); ?>

    <div id="my-content-id" style="display:none;">
        <p>
            This is my hidden content! It will appear in ThickBox when the link is clicked.
        </p>
        <label for="rudr_select2_tags">Tags:</label><br />
        <select class="courses" id="rudr_select2_tags" name="rudr_select2_tags[]" multiple="multiple" style="width:100%">
        </select>
    </div>
    <h2><?php esc_attr_e( 'Products', 'WpAdminStyle' ); ?></h2>
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="nds_add_user_meta_form">

        <input type="hidden" name="action" value="product_form_response">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'nonce' ) ?>"/>

        <table class="widefat wp-list-table">
            <thead>
            <tr>
                <th scope="col" id="thumb" class="manage-column column-thumb"><span class="wc-image tips">Image</span></th>
                <th><?php esc_attr_e( 'Name' ); ?></th>
                <th><?php esc_attr_e( 'Mapped Courses' ); ?></th>
                <th><?php esc_attr_e( 'Input' ); ?></th>
            </tr>
            </thead>
            <tbody>
			<?
			while ( $this->products->have_posts() ) : $this->products->the_post();
				?>
                <tr>
                    <th scope="col" id="thumb" class="manage-column column-thumb">
                        <?php echo woocommerce_get_product_thumbnail(); ?>
                    </th>
                    <td class="row-title"><label for="tablecell">
                        <?php echo get_the_title(); ?>
                        </label>3
                    </td>
                    <td></td>
                    <td>
                        <a href="#TB_inline?width=600&height=550&inlineId=my-content-id" class="thickbox" title="MY TITLE HERE!!!">Add/Remove Course</a>
                    </td>
                </tr>
				<? header("Access-Control-Allow-Origin: *"); ?>
			<? endwhile; ?>
            </tbody>
        </table>
    </form>

    <script>
        jQuery(function($){
            // multiple select with AJAX search
            $('.courses').select2({
                ajax: {
                    // url: "https://testpress.in/api/v2.5/admin/courses/",
                    url: "https://reqres.in/api/users/",
                    type: 'GET',
                    contentType:'application/json',
                    data: function (params) {
                        return {
                            q: params.term,
                        };
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", "JWT <?php echo get_option("testpress_auth_token") ?>");
                    },
                    processResults: function( data ) {
                        var options = [];
                        if ( data ) {
                            console.log("Data: ", data)
                            // data is the array of arrays, and each of them contains ID and the Label of the option
                            $.each(data.data, function( index, text ) { // do not forget that "index" is just auto incremented value
                                options.push( { id: text.id, text: text.first_name  } );
                            });
                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
        });
    </script>
</div>