<?php get_header(); 
global $wpdb;
$post_id = get_the_id();
$image = json_decode(get_post_meta($post_id, 'cust_additionalphoto',1),true);

if (have_posts()) : while (have_posts()) : the_post();

?>
<div class="fund-single-row">
	<div class="fund-single-container">
		<h2>Individual Fund-A-Need</h2>
		<h4><label>Classroom: </label><?php echo get_post_meta($post_id, 'cust_name',1); ?></h4>
		<div class="fund-info"><div class="single-ctm ctm-tm"><span><img title="School" src="<?php echo esc_url( plugins_url( 'images/school.svg', __FILE__ ) ); ?>"> <?php echo get_post_meta($post_id, 'cust_schoolname',1); ?></span><span><img title="classroom" src="<?php echo esc_url( plugins_url( 'images/classroom.svg', __FILE__ ) ); ?>"> <?php echo get_post_meta($post_id, 'cust_grade',1); ?></span> <span><img title="Location" src="<?php echo esc_url( plugins_url( 'images/location.svg', __FILE__ ) ); ?>"> <?php echo get_post_meta($post_id, 'cust_scity',1); ?>, <?php echo get_post_meta($post_id, 'cust_sstate',1); ?></span></div></div>

		<div class="title-meta "><span class="text-pre">Funding Goal: </span><span class="bold-text"><?php echo get_post_meta($post_id, 'cust_fundamount',1); ?></span></div>

		<div class="title-meta ">
			<span class="text-pre">
				<?php 
					$due_ammount = $wpdb->get_var( "SELECT SUM(`amount`) FROM `Donate_user` WHERE `project_id` = ".$post_id ); 
					if ($due_ammount == '')
						$due_ammount = 0;
				?>
				<del>$<?php echo $due_ammount; ?></del> $<?php echo get_post_meta($post_id, 'cust_fundamount',1) - $due_ammount; ?> Needed due to a <div class="text-meta bg-clr adjusted">2x Match</div>
			</span>
		</div>

		<!-- Progress Bar -->
		<div class="project_progress">
			<?php 
			$output .= '<div class="progresdiv">';

				$due_ammount = $wpdb->get_var( "SELECT SUM(`amount`) FROM `Donate_user` WHERE `project_id` = ".get_the_id() );
				$till_that = 0;
				$progress_sensevity = 50;
				if ($due_ammount > 0) {
					$till_that = ($due_ammount / get_post_meta($post_id, 'cust_fundamount',1)) * $progress_sensevity;
				}

				// If under Equality
				if ((($due_ammount / get_post_meta($post_id, 'cust_amount',1)) * $progress_sensevity) <= $progress_sensevity)
					$color = '#ef7979;';
				else
					$color = 'green';

				for($i = 0; $i < $till_that; $i++) {
					if ($i > ($progress_sensevity - 1))
						break;
					$output .= '<div class="innerprogress" style="background-color: '.$color.'"></div>';
				}

				for($i = $till_that; $i < $progress_sensevity; $i++) {
					$output .= '<div class="innerprogress" style=""></div>';
				}

			$output .= '</div>';
			echo $output;
			$project_id_val = get_the_id();
			$wpdb->get_results("SELECT * from Donate_user where project_id=$project_id_val");
			$project_count = $wpdb->num_rows;
			
			?>

			<div class="progress_bar_info three_col_divide">
				<div class="donor_info">
					<span class="green"><?php echo $project_count;?> Donors</span><br>
					<span>$<?php echo $due_ammount; ?> Raised So Far</span>
				</div>
				<div class="criteria">
					<span>Matching criteria<br>$<?php echo ( get_post_meta($post_id, 'cust_fundamount',1) - $due_ammount); ?></span>
				</div>
				<div class="equality">
					Equality.ORG Match $500
				</div>
			</div>
		</div>
		
		<h2 class="featured_info ">You can fully fund this need for $<?php echo get_post_meta($post_id, 'cust_fundamount',1)-$due_ammount; ?> today!<span class="date">Expires May 20, 2019</span></h2>
		
		<div class="single-primeimg"><img src="<?php echo esc_url( plugins_url( 'images/'.get_post_meta($post_id, 'cust_primaryphoto',1), __FILE__ ) ); ?>">
		<?php foreach ($image as $values) { ?>
			<img class="mySlides" src="<?php echo esc_url( plugins_url( 'images/'.$values, __FILE__ ) ); ?>">
		<?php } ?>
		</div>
		
		<div class="content"><?php echo get_the_content(); ?></div>
		
		<center>
			<!-- <a href="#" class="button donate">Donate Now!</a> -->
			<?php echo do_shortcode('[funding_donation_popup]'); ?>

			<div class="socialshare">
				<a href="<?php echo get_post_meta($post_id, 'tw_link',1); ?>" target="_blank" title="Tweet"><img src="<?php echo esc_url( plugins_url( 'images/twitter-logo.svg', __FILE__ ) ); ?>"></a>
				<a href="<?php echo get_post_meta($post_id, 'fb_link',1); ?>" title="Share on Facebook" target="_blank"><img src="<?php echo esc_url( plugins_url( 'images/facebook-logo.svg', __FILE__ ) ); ?>"></a>
				<a href="<?php echo get_post_meta($post_id, 'insta_link',1); ?>" class="instagram"><img src="<?php echo esc_url( plugins_url( 'images/instagram-logo.svg', __FILE__ ) ); ?>"></a>
			</div>
		</center>
		
		<h3>Where does the money go?</h3>
<div class="table-wrapper">
		<table class="money_goes">
			<tr class="mt">
				<th>Item</th>
				<th>Amount</th>
			</tr>
			<?php $amount = get_post_meta($post_id, 'cust_amount',1); 
			$amount = json_decode($amount);
			$count = 1;
			foreach($amount as $amount_val)
			{
				if($count % 2 == 0){ 
					$class = "";
				} 
				else
				{
					$class = "green-cls";
				}
				$output = "<tr class=".$class.">
					<td>".$amount_val->item."</td>
					<td>".$amount_val->value."</td>
				</tr>";
				echo $output;
				$count++;
			}
			?>
		</table>
	</div>
	</div>

<?php endwhile; endif; ?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<?php get_footer(); ?>