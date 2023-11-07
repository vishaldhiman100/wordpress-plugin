<?php
global $wpdb;
$table_name = 'Donate_user'; 
 $alldata = $wpdb->get_results( "SELECT * FROM $table_name");

?>


<div id="wpbody" role="main">
	<div id="wpbody-content">
		<div class="wrap">
			<h1 class="wp-heading-inline funraising-admin">Fund Users Dashboard</h1>
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
						<th scope="col">Amount</th>
						<th scope="col">Transaction ID</th>
						<th scope="col">Status</th>
						<th scope="col">Comment</th>
						<th scope="col">Project Name</th>
						
					</tr>
				</thead>
				<tbody id="the-list"> 

					<?php foreach ($alldata as $value) {
						 ?>
					<tr>
						<td><?php echo $value->name; ?> </td>
						<td><?php echo $value->email; ?> </td>
						<td><?php echo $value->amount; ?> </td>
						<td><?php echo $value->balance_transaction; ?> </td> 
						<td><?php echo $value->status; ?> </td>
						<td><?php echo $value->comment; ?> </td>
						<td><?php echo get_the_title( $value->project_id ); ?> </td>
						
					</tr>


					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>