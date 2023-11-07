<?php
include( ABSPATH . "wp-includes/wp-load.php" );
function user_listing_frontend(){
	global $wpdb;
	$args = array(
		"post_type" => "projects",
		"post_status" => "publish",
		//"posts_per_page" => 2
	);
	$the_query = new WP_Query( $args );

	$output .= "";	
	$output .= '<div class="fund-row">';	
	$output .= '<div class="title-meta textcenter"><h2>All Fund-A-Need Projects</h2></div>';
	$output .= '<div class="three-col-section-inner">';
	
	if ( $the_query->have_posts() ) : 
	while ( $the_query->have_posts() ) : $the_query->the_post(); 
	
		$post_id = get_the_ID();
		$approve_val = get_post_meta($post_id, 'cust_approve',1);
		if($approve_val == "on")
		{
			$image = json_decode(get_post_meta($post_id, 'cust_additionalphoto',1),true);
			$output .= '<div class="three-col-section">';
			$output .= '<div class="three-col-inner">';
			$output .= '<div class="title-meta ctm-tm"><img title="Help" src="'.esc_url( plugins_url( 'images/help.svg', __FILE__ ) ).'">'.get_post_meta($post_id, 'cust_name',1).'</div>';
			$output .= '<div class="title-meta ctm-tm"><img title="School" src="'.esc_url( plugins_url( 'images/school.svg', __FILE__ ) ).'">'.get_post_meta($post_id, 'cust_schoolname',1).'</div>';
			$output .= '<div class="title-meta ctm-tm"><img title="Classroom" src="'.esc_url( plugins_url( 'images/classroom.svg', __FILE__ ) ).'">'.get_post_meta($post_id, 'cust_grade',1).'</div>';
			$output .= '<div class="title-meta ctm-tm"><img title="location" src="'.esc_url( plugins_url( 'images/location.svg', __FILE__ ) ).'">'.get_post_meta($post_id, 'cust_scity',1).',<span>'.get_post_meta($post_id, 'cust_sstate',1).'</span></div>';
			$output .= '<div class="date-expire">Expires May 20, 2019 </div>';
			$output .= '<div class="primeimg"><img src="'. esc_url( plugins_url( 'images/'.get_post_meta($post_id, 'cust_primaryphoto',1), __FILE__ ) ) .'">';
			foreach ($image as $values) { 
			  $output .= '<img class="mySlides" src="'. esc_url( plugins_url( 'images/'.$values, __FILE__ ) ) .'" style="width:50%">';
			 }
			$output .= '</div>';
			$output .= '<div class="intortext">'.get_post_meta($post_id, 'cust_help',1).'</div>';
			$output .= '<div class="title-meta-bottom  textcenter"><span class="text-pre">Funding Goal: </span><span class="bold-text">'.get_post_meta($post_id, 'cust_fundamount',1).'</span></div>';

			$due_ammount = $wpdb->get_var( "SELECT SUM(`amount`) FROM `Donate_user` WHERE `project_id` = ".$post_id );
			if(get_post_meta($post_id, 'cust_fundamount',1) > 0){

				$output .= '<div class="text-meta textcenter line-stroke">$'.( get_post_meta($post_id, 'cust_fundamount',1) - $due_ammount).' Still Needed</div>';
			}

			if(get_post_meta($post_id, 'cust_amount',1) > 0){
				$due_ammount = $wpdb->get_var( "SELECT SUM(`amount`) FROM `Donate_user` WHERE `project_id` = ".$post_id );

				if ($due_ammount <  get_post_meta($post_id, 'cust_amount',1)) {
					$output .= '<div class="text-meta textcenter">$'.( get_post_meta($post_id, 'cust_amount',1) - $due_ammount).' Needed due to a match from Equality.ORG</div>';
				}else{
					$output .= '<div class="text-meta textcenter">$'.$due_ammount.' Raised So Far. Reached Equality.ORG Goal</div>';
				}
			}

			$output .= '<div class="text-meta bg-clr">2x Match</div>';
			$output .= '<div class="text-meta textcenter">Equality.ORG Match: $500</div>';

			$till_that = 0;
			$progress_sensevity = 50;
			if ($due_ammount > 0) {
				$till_that = ($due_ammount / get_post_meta($post_id, 'cust_fundamount',1)) * $progress_sensevity;
			}

			$output .= '<div class="progresdiv">';

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

			if ($due_ammount <= get_post_meta($post_id, 'cust_amount',1)) {
				if ($due_ammount == '')
					$due_ammount = 0;
				$output .= '<div class="text-meta textcenter">$'.$due_ammount.' Raised So Far $'.( get_post_meta($post_id, 'cust_fundamount',1) - $due_ammount).' Needed To qualify for Matched fund</div>';
			}

			$output .= '<div class="action_buttons"><a class="view_detail button" href="'.get_the_permalink().'">View More Details</a>'.do_shortcode("[funding_donation_popup]").'</div>';

			$output .= '<div class="socialshare textcenter">';
				$output .= '<a href="'.get_post_meta($post_id, 'tw_link',1).'" target="_blank" title="Tweet"><img src="'.esc_url( plugins_url( 'images/twitter-logo.svg', __FILE__ ) ).'"></a>';
				$output .= '<a href="'.get_post_meta($post_id, 'fb_link',1).'" title="Share on Facebook" target="_blank"><img src="'.esc_url( plugins_url( 'images/facebook-logo.svg', __FILE__ ) ).'"></a>';
				$output .= '<a href="'.get_post_meta($post_id, 'insta_link',1).'" class="instagram"><img src="'.esc_url( plugins_url( 'images/instagram-logo.svg', __FILE__ ) ).'"></a>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';	
		}
	endwhile;
	endif;  
	$output .= '</div></div><script type="text/javascript" src="https://js.stripe.com/v2/"></script>';
	return $output;	
}
add_shortcode("user_listing_frontend","user_listing_frontend");
?>