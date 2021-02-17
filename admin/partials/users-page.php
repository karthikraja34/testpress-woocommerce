<?php
?>

<h2><?php esc_attr_e( 'Users', 'WpAdminStyle' ); ?></h2>
<table class="widefat wp-list-table">
	<thead>
	<tr>
		<th><span class="wc-image tips">ID</span></th>
		<th><?php esc_attr_e( 'Name' ); ?></th>
		<th><?php esc_attr_e( 'Email' ); ?></th>
		<th><?php esc_attr_e( 'Testpress Username' ); ?></th>
		<th><?php esc_attr_e( 'Action' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?
	foreach($this->users as $user){
	?>
		<tr>
			<td>
				<label for="tablecell">
					<?php echo esc_html( $user->ID ) ?>
				</label>
			</td>

			<td class="row-title">
				<label for="tablecell">
					<?php echo esc_html( $user->display_name ) ?>
				</label>
			</td>
			<td>
				<label for="tablecell">
					<?php echo esc_html( $user->user_email ) ?>
				</label>
			</td>
            <td>
                <div class="edit_form hidden">
                    <label for="rudr_select2_tags">Search for user:</label><br/>
                    <select class="user" id="rudr_select2_tags" name="rudr_select2_tags[]"

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
		<? header("Access-Control-Allow-Origin: *"); ?>
	<?
	} ?>
	</tbody>
</table>

<script>
    jQuery(function ($) {
        $('.user').select2({
            ajax: {
                url: ajaxurl,
                action: 'get_users',
                type: 'GET',
                contentType: 'application/json',
                data: function (params) {
                    return {
                        q: params.term,
                        action: 'get_users'
                    };
                },
                processResults: function (data) {
                    var options = [];
                    if (data) {
                        $.each(data.results, function (index, text) {
                            options.push({id: text.id, text: text.username});
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
            let selected_data = $(row).find('.user').select2('data');
            let post_id = $(row).find('[name="post_id"]').val();
            $(row).find('.spinner').addClass('is-active')
            jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {"user": {"id": selected_data.id, "username": selected_data.text}, "post_id": post_id, action: "update_user"},
                success: function (data) {
                    console.log("Success : ", data)
                    $(row).find('.spinner').removeClass('is-active')
                },
                failure: function () {
                    $(row).find('.spinner').removeClass('is-active')
                }
            })
        })
    });
</script>
