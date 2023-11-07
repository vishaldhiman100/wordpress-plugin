<?php
include( ABSPATH . "wp-includes/pluggable.php" );
include( ABSPATH . "wp-includes/wp-load.php" );
include( ABSPATH . 'wp-admin/includes/image.php' );
if(isset($_POST['submit']))
	{
		/**** Form post data ***/
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$taxid = $_POST['taxid'];
		$fundamount = $_POST['fundamount'];
		$claimer = $_POST['claimer'];
		$schoolname = $_POST['schoolname'];
		$grade = $_POST['grade'];
		$scity = $_POST['scity'];
		$sstate = $_POST['sstate'];
		$title = $_POST['title'];
		$excerpt = $_POST['excerpt'];
		$fdesc = $_POST['fdesc'];
		$impact = $_POST['impact'];
		$income = $_POST['income'];
		$matchfund_item = $_POST['matchfund_item'];
		$matchfund = $_POST['matchfund']; 
		$fbprofile = $_POST['fbprofile']; 
		$twprofile = $_POST['twprofile']; 
		$inprofile = $_POST['inprofile']; 
		
		/** Form Fund value array **/
		$itemandvalue = array();
		$z = 0;
		foreach ($matchfund_item  as $value) {
			$itemandvalue[] = array("item"=> $value,"value"=>$matchfund[$z]) ;
			$z++;
		}
		
		/*** Upload Primary image ***/
		if($_FILES['primphoto'] != null){
			$primphoto = time().$_FILES['primphoto']['name'];
			$target_path_primphoto = ABSPATH. 'wp-content/plugins/fundraising/images/'.$primphoto;
			move_uploaded_file($_FILES['primphoto']['tmp_name'], $target_path_primphoto);
		}
		
		/*** Upload Additional images ***/
		if($_FILES['additphoto'] != null){
			$allimages = array();
			for($i=0; $i < count($_FILES['additphoto']['name']); $i++){
				$additphoto = time().$_FILES['additphoto']['name'][$i];
				$allimages[] = $additphoto; 
				$target_path_additphoto = ABSPATH. 'wp-content/plugins/fundraising/images/'.$additphoto;
				move_uploaded_file($_FILES['additphoto']['tmp_name'][$i], $target_path_additphoto);
			}
		}
		
		/**** Save Basic data to Project post type ***/
		
		$id = wp_insert_post(array('post_title'=>$title, 'post_type'=>'projects', 'post_status'=>'publish','post_content' => $fdesc,'post_excerpt' => $excerpt));
		
		/**** Upload Meta field(extra information) for Project post type ***/
		update_post_meta( $id,  'cust_name', $name );
		update_post_meta( $id,  'cust_email', $email );
		update_post_meta( $id,  'cust_address', $address );
		update_post_meta( $id,  'cust_city', $city );
		update_post_meta( $id,  'cust_state', $state );
		update_post_meta( $id,  'cust_zip', $zip );
		update_post_meta( $id,  'cust_taxid', $taxid );
		update_post_meta( $id,  'cust_fundamount', $fundamount );
		update_post_meta( $id,  'cust_checkclassroom', $claimer );
		update_post_meta( $id,  'cust_schoolname', $schoolname );
		update_post_meta( $id,  'cust_grade', $grade );
		update_post_meta( $id,  'cust_scity', $scity );
		update_post_meta( $id,  'cust_sstate', $sstate );
		update_post_meta( $id,  'cust_item', $matchfund_item );
		update_post_meta( $id,  'cust_amount', json_encode($itemandvalue) );
		update_post_meta( $id,  'cust_impact', $impact );
		update_post_meta( $id,  'cust_income', $income );
		update_post_meta( $id,  'cust_primaryphoto', $primphoto );
		update_post_meta( $id,  'cust_additionalphoto', json_encode($allimages) );
		update_post_meta( $id,  'fb_link', $fbprofile );
		update_post_meta( $id,  'tw_link', $twprofile );
		update_post_meta( $id,  'insta_link', $inprofile );
		if($id)
		{
			echo "success";
		?>
			<script type="text/javascript">
				window.location = window.location.protocol + 
                  '//' +
                  window.location.hostname +
                  window.location.pathname+"thankyou";
				
			</script> 
		<?php	
		}
		else
		{
			echo "failed";
		}
}
function user_form_frontend()
{
	
?>

<form id="userform1" method="post" action="<?php the_permalink();?>"  enctype="multipart/form-data" class="fund_main_form1"> 
	<div class="col-md6"><label>Name</label><input type="text" name="name"  required></div>
	<div class="col-md6"><label>Email Address</label><input type="email" name="email" required></div>
	<div class="col-md6"><label>Address</label><input type="text" name="address" required></div>
	<div class="col-md6"><label>City</label><input type="text" name="city" required></div>
	<div class="col-md6"><label>State</label><input type="text" name="state" required></div>
	<div class="col-md6"><label>Zip</label><input type="text" name="zip" required></div>
	<div class="col-md6"><label>Tax ID</label><input type="text" name="taxid" required></div>
	<div class="col-md6"><label>Fundraising amount needed: $$$</label><input type="text" name="fundamount" id="fundamount" required></div>
	<div class="col-md12 p-txt"><input type="checkbox" name="claimer" required><p>"I certify that this is a public school classroom" </p></div>
	<div class="col-md6"><label>School Name</label><input type="text" name="schoolname" required></div>
	<div class="col-md6 p-txt"><label>What grade?</label><select name="grade" required><option>ComboBox</option></select></div>
	<div class="col-md6"><label>City</label><input type="text" name="scity" required></div>
	<div class="col-md6"><label>State</label><input type="text" name="sstate" required></div>
	<div class="col-md6"><label id="title_lable">Title</label><input type="text" name="title" required id="main_title"><span class="text-danger" id="title_error" style="display:none">Please enter unique title</span></div>
	<div class="col-md6"><label>Excerpt</label><input type="text" name="excerpt" required></div>
	<div class="col-md12"><label>Full Description</label><textarea name="fdesc" required></textarea></div>
	<div class="col-md6"><label>Upload Primary Photo</label><input type="file" name="primphoto" required id="primphoto"> <span class="text-danger" id="primphoto_error" style="display:none">Please upload image only</span></div>
	<div class="col-md6"><label>Additional Photos</label><input type="file" name="additphoto[]" multiple/ required id="additphoto"> <span class="text-danger" id="additphoto_error" style="display:none">Please upload image only</span></div>
	<div class="col-md12 tbl-check">
		<label class=""><table><tr><td>Item</td><td>Amount</td></tr></table>
		</label>
		<label class=""><table><tr><td><input type="text" name="matchfund_item[]" required  class="matchfund_item"></td><td><input type="text" name="matchfund[]" value="" required class="matchfund"> <span id="add"> + </span></td></tr></table>	
			<div id="appenddiv"></div>
		</label>
	</div>
	<div class="col-md6"><label>How many students will this impact?</label><input type="text" name="impact" required></div>
	<div class="col-md6 p-txt"><label>Percentage of students from low-income families</label><select name="income" required><option>ComboBox</option></select></div>
	<div class="col-md6 p-txt"><label>Facebook Profile Link</label><input type="text" name="fbprofile"></div>
	<div class="col-md6 p-txt"><label>Twitter Profile Link</label><input type="text" name="twprofile"></div>
	<div class="col-md6 p-txt"><label>Instagram Profile Link<input type="text" name="Inprofile"></label></div>
	<input type="hidden" name="page_url" value="<?php echo $_SERVER['REQUEST_URI'] ;?>">
	<input type="hidden" id="site_url" value="<?php echo home_url(); ;?>">
	<input type="hidden" id="validation_field" value="0">
	<div class="submit"><input type="submit" name="submit" value="Submit"></div>
</form>
<?php
}
add_shortcode('user_form_frontend','user_form_frontend');
?>