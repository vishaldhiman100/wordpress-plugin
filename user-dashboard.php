<?php
global $wpdb;
$table_name = 'fund_users'; 

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		//echo "<pre>"; print_r($_POST); die;

		$wpdb->update( $table_name , array('status'=>$_POST['status']), array('id'=>$_POST['main_id']));

 }

 $alldata = $wpdb->get_results( "SELECT * FROM $table_name");

?>


<div id="wpbody" role="main">
	<div id="wpbody-content">
		<div class="wrap">
			<h1 class="wp-heading-inline funraising-admin">User Dashboard</h1>
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
						<th scope="col">Address</th>
						<th scope="col">City</th>
						<th scope="col">State</th>
						<th scope="col">Fundraising Amount</th>
						
					</tr>
				</thead>
				<tbody id="the-list"> 

					<?php foreach ($alldata as $value) {
						 ?>
					<tr>
						<td><?php echo $value->name; ?> </td>
						<td><?php echo $value->email; ?> </td>
						<td><?php echo $value->address; ?> </td>
						<td><?php echo $value->city; ?> </td> 
						<td><?php echo $value->state; ?> </td>
						<td><?php echo $value->fundamount; ?> </td>
						
					</tr>


					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	
 function myFunction(id) {	
 var form = document.getElementById(id);
 form.submit();
}   

</script>