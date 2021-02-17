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


    <h2><?php esc_attr_e( 'Products', 'WpAdminStyle' ); ?></h2>
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="nds_add_user_meta_form">

        <input type="hidden" name="action" value="product_form_response">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'nonce' ) ?>"/>

        <table class="widefat wp-list-table">
            <thead>
            <tr>
                <th scope="col" id="thumb" class="manage-column column-thumb"><span class="wc-image tips">Image</span>
                </th>
                <th><?php esc_attr_e( 'Name' ); ?></th>
                <th><?php esc_attr_e( 'Mapped Courses' ); ?></th>
                <th><?php esc_attr_e( 'Action' ); ?></th>
            </tr>
            </thead>
            <tbody>
			<?
			while ( $this->products->have_posts() ) : $this->products->the_post();
				global $product;
				?>
                <tr>
                    <th scope="col" id="thumb" class="manage-column column-thumb">
						<?php echo woocommerce_get_product_thumbnail(); ?>
                    </th>
                    <td class="row-title"><label for="tablecell">
							<?php echo get_the_title(); ?>
                            <input name="post_id" type="hidden" value="<?php echo get_the_ID() ?>" disabled>
                        </label>
                    </td>
                    <td>
                        <?php echo json_encode(get_post_meta(get_the_ID(), "courses", true)) ?>
                        <div class="edit_form hidden">
                            <label for="rudr_select2_tags">Search for courses:</label><br/>
                            <select class="courses" id="rudr_select2_tags" name="rudr_select2_tags[]"
                                    multiple="multiple"
                                    style="width:100%">
                            </select> <br/>
                            <div style="margin-top:10px;">
                                <span class="spinner"></span>
                                <button type="button" class="button button-primary save alignright">Update</button>
                                <button type="button" class="button button-secondary cancel alignright" style="margin-right:10px">Cancel</button>

                            </div>
                             </div>
                    </td>
                    <td>
                        <a href="#" class="edit">Add/Remove Course</a>
                    </td>
                </tr>
				<? header( "Access-Control-Allow-Origin: *" ); ?>
			<? endwhile; ?>
            </tbody>
        </table>
    </form>

    <script>
        jQuery(function ($) {
            $('.courses').select2({
                ajax: {
                    url: ajaxurl,
                    action: 'mishagetposts',
                    type: 'GET',
                    contentType: 'application/json',
                    data: function (params) {
                        return {
                            q: params.term,
                            action: 'mishagetposts'
                        };
                    },
                    processResults: function (data) {
                        var options = [];
                        if (data) {
                            $.each(data.results, function (index, text) {
                                options.push({id: text.id, text: text.title});
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

            $('.edit').on('click', function () {
                let row = $(this).closest('tr');
                row.find('.edit_form').removeClass('hidden');
            });

            $('.cancel').on('click', function () {
                let row = $(this).closest('tr');
                row.find('.edit_form').addClass('hidden');
            });

            $('.save').on('click', function () {
                let row = $(this).closest('tr');
                let selected_data = $(row).find('.courses').select2('data');
                let post_id = $(row).find('[name="post_id"]').val();
                let selected_courses = []
                selected_data.forEach(function (data) {
                    selected_courses.push({id: data.id, title: data.text});
                })
                $(row).find('.spinner').addClass('is-active')
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {"courses": selected_courses, "post_id": post_id, action: "update_product_courses"},
                    success: function (data) {
                        console.log("Success : ", data)
                        $(row).find('.spinner').removeClass('is-active')
                    },
                    failure: function () {
                        console.log("Failure")
                        $(row).find('.spinner').removeClass('is-active')
                    }
                })
            })
        });
    </script>
</div>