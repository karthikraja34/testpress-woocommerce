<?php
?>

<h2><?php esc_attr_e( 'Users', 'WpAdminStyle' ); ?></h2>
<table class="widefat wp-list-table">
	<thead>
	<tr>
		<th><span class="wc-image tips">ID</span></th>
		<th><?php esc_attr_e( 'Name' ); ?></th>
		<th><?php esc_attr_e( 'Email' ); ?></th>
		<th><?php esc_attr_e( 'Input' ); ?></th>
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
				<a href="#TB_inline?width=600&height=550&inlineId=my-content-id" class="thickbox" title="MY TITLE HERE!!!">Add/Remove Course</a>
			</td>
		</tr>
		<? header("Access-Control-Allow-Origin: *"); ?>
	<?
	} ?>
	</tbody>
</table>
