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
						<th scope="col">Fundraising Amount</th>
						<th scope="col">Tax ID</th>
						<!--<th scope="col">Date</th> -->
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="the-list">

					<?php foreach ($alldata as $value) {

						//echo "<pre>"; print_r($value); die;
						 ?>
					<tr>
						<td><?php echo $value->name; ?> </td>
						<td><?php echo $value->email; ?> </td>
						<td><?php echo $value->fundamount; ?> </td>
						<td><?php echo $value->taxid; ?> </td>
					
						<td>
							<form action="" method="post" id="form-active<?php echo  $value->id; ?>">
								<input type="hidden" value="<?php echo  $value->id; ?>" name="main_id" >
								Approve<input name="status" value="1" type="radio" id="radio_button" onclick='myFunction("form-active<?php echo  $value->id; ?>")'  <?php if($value->status == '1' ) echo "checked"; ?> >
								Decline<input name="status" value="0" type="radio" id="radio_button" onclick='myFunction("form-active<?php echo  $value->id; ?>")' <?php if($value->status == '0' ) echo "checked"; ?> >
							</form>

						</td>
						
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