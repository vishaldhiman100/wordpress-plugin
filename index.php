<?php
/*
Plugin Name: Fundraising
Description: Shown price according to District code
Version: 1.0
*/

/*** CMB2 fields***/
if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}
include( dirname(__FILE__) . '/user-form.php' );
include( dirname(__FILE__) . '/user-listing.php' );
include( dirname(__FILE__) . '/post_metafields.php' );

/* Filter the single_template with our custom function*/
add_filter('single_template', 'my_custom_template');

function my_custom_template($single) {
    global $post;
	define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    /* Checks for single template by post type */
    if ( $post->post_type == 'projects' ) {
        if ( file_exists( MY_PLUGIN_PATH . '/single-project.php' ) ) {
            return MY_PLUGIN_PATH . '/single-project.php';
        }
    }

    return $single;
}
/*** Admin Menu ***/
function wpa_add_menu() {
        add_menu_page( 'Fundraising', 'Fundraising', 'manage_options', 'fundraising-dashboard', 'wpa_page_file_path', plugins_url('images/Fundraising.png', __FILE__),'2.2.9');
		add_submenu_page( 'fundraising-dashboard', 'Fundraising Data' . 'Dashboard', 'Dashboard', 'manage_options', 'fundraising-dashboard', 'wpa_page_file_path');
		
        add_submenu_page( 'fundraising-dashboard', 'Fundraising Data' . 'Fund Users', 'Fund Users', 'manage_options', 'fund-users', 'wpa_page_file_path'); 
        
		add_submenu_page( 'fundraising-dashboard', 'Fundraising Data' . 'User Dashboard', 'User Dashboard', 'manage_options', 'user-dashboard', 'wpa_page_file_path'); 
		
}	
add_action( 'admin_menu', 'wpa_add_menu' );
  function wpa_page_file_path() {
	
		$screen = get_current_screen();
		  if ( strpos( $screen->base, 'fundraising-dashboard' ) !== false ) {
           
            include( dirname(__FILE__) . '/fundraising-dashboard.php' );
        } 
		elseif ( strpos( $screen->base, 'user-dashboard' ) !== false ) {
           
            include( dirname(__FILE__) . '/user-dashboard.php' );
        }elseif ( strpos( $screen->base, 'fund-users' ) !== false ) {
           
            include( dirname(__FILE__) . '/fund-users.php' );
        }
		 
    }
/*** Include Css and js files ***/
function admin_fundraising_scripts_and_styles(){
        wp_enqueue_style('fundraising-admin-styles',  plugin_dir_url( __FILE__ ) . 'css/admin-fundraising-styles.css');
    }
add_action('admin_enqueue_scripts','admin_fundraising_scripts_and_styles');
function fundraising_scripts_and_styles(){
        wp_enqueue_style('fundraising-styles',  plugin_dir_url( __FILE__ ) . 'css/fundraising-styles.css');
        wp_enqueue_style('fund-styles',  plugin_dir_url( __FILE__ ) . 'css/slick.min.css');
        wp_enqueue_style('font-styles',  'https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
		wp_enqueue_script('slick-script',  plugin_dir_url( __FILE__ ) . 'js/slick.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('fund-script_1', "https://js.stripe.com/v2/", array('jquery'), '3.0', true);
		wp_enqueue_script('fundraising-script',  plugin_dir_url( __FILE__ ) . 'js/fundraising.js', array('jquery'), '1.0', true);
    }
add_action('wp_enqueue_scripts','fundraising_scripts_and_styles');

/*** Create tables when plugin activates ***/
function create_fund_database_table() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$table_name = 'fund_users';
	$sql = "CREATE TABLE $table_name (
		`id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
		`name` varchar(255) NOT NULL,
		`email` varchar(255) NOT NULL,
		`address` varchar(255) NOT NULL,
		`city` varchar(255) NOT NULL,
		`state` varchar(255) NOT NULL,
		`zip` varchar(255) NOT NULL,
		`taxid` varchar(255) NOT NULL,
		`fundamount` varchar(255) NOT NULL,
		`claimer` varchar(255) NOT NULL,
		`schoolname` varchar(255) NOT NULL,
		`grade` varchar(255) NOT NULL,
		`citystate` varchar(255) DEFAULT NULL,
		`scity` varchar(255) NOT NULL,
		`sstate` varchar(255) NOT NULL,
		`title` varchar(255) NOT NULL,
		`excerpt` varchar(255) NOT NULL,
		`fdesc` varchar(255) NOT NULL,
		`primphoto` varchar(255) NOT NULL,
		`additphoto` varchar(255) NOT NULL,
		`matchfund` varchar(255) NOT NULL,
		`impact` varchar(255) NOT NULL,
		`income` varchar(255) NOT NULL,
		`status` int(2) DEFAULT '0',
		`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	)";
	dbDelta( $sql );
	$sql2 = "CREATE TABLE `Donate_user` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `project_id` int(11) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `amount` int(11) NOT NULL,
	  `balance_transaction` varchar(255) NOT NULL,
	  `status` varchar(255) NOT NULL,
	  `date` datetime NOT NULL,
	  PRIMARY KEY  (id)
	)";
	dbDelta( $sql2 );
}
register_activation_hook( __FILE__, 'create_fund_database_table' );

/**** Register Custom Post type ****/
add_action( 'init', 'activate_myplugin' );
function activate_myplugin() {
	$args=array(
		'label' => 'Projects',
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => 'projects',
			'with_front' => true
			),
		'query_var' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'trackbacks',
			'custom-fields',
			'revisions',
			'thumbnail',
			'author',
			'page-attributes'
			)
		); 
		register_post_type( 'projects', $args );
	}
	function myplugin_flush_rewrites() {
			activate_myplugin();
			flush_rewrite_rules();
	}
	register_activation_hook( __FILE__, 'myplugin_flush_rewrites' );
	register_uninstall_hook( __FILE__, 'my_plugin_uninstall' );
	function my_plugin_uninstall() {
		 unregister_post_type( 'projects' );
	} 
add_filter( 'manage_edit-projects_columns', 'my_edit_projects_columns' ) ;

/*** Filter to shown extra fields on the project listing in the Admin backend ****/
function my_edit_projects_columns( $columns ) {

	 $columns = array(
		'cb' => '&lt;input type="checkbox" />',
		'title' => __( 'Title' ),
		'author' => __( 'Author' ),
		'status' => __( 'Status' ),
		'date' => __( 'Date' )
	);

	return $columns; 
}
add_action( 'manage_projects_posts_custom_column', 'my_manage_projects_columns', 10, 2 );

function my_manage_projects_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'status' :

			/* Get the post meta. */
			$status = get_post_meta( $post_id, 'cust_approve', true );
			if ( empty( $status ) )
				echo __( 'Inactive' );

			else
				echo __( 'Active' );
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
/***** End register post type ****/
/******* Create thank you page ********/
function the_slug_exists($post_name) {

global $wpdb;
if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
  
} else {
	wp_insert_post( array(
        'post_title' => "Thank you",
        'post_type'     => 'page',
        'post_name'  => 'thankyou',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_content' => 'Thank you for fundraising request',
        'post_status' => 'publish',
        'post_author' => 1,
        'menu_order' => 0
    ));
   
}
}
the_slug_exists("thankyou");

/*** Stripe Payment ***/
add_action('wp_ajax_payment_ajax','payment_ajax');
add_action('wp_ajax_nopriv_payment_ajax','payment_ajax');

function payment_ajax(){
	require_once('stripe-php-master/init.php');
	global $wpdb;
	try {
		if (!isset($_POST['ptoken']))
		  throw new Exception("The Stripe Token was not generated correctly");

		 $stripe = array(
		  "secret_key"      => "sk_test_zj9gKOyEGzjVjstnFugoLiYV",
		  "publishable_key" => "pk_test_XW21QtES40QYeObTZLPpj4Tp"
		);
		\Stripe\Stripe::setApiKey($stripe['secret_key']);
		
		//add customer to stripe
		$customer = \Stripe\Customer::create(array(
			'email' => $_POST['email'],
			'source'  => $_POST['ptoken']
		));
		$charge = \Stripe\Charge::create(array(
			'customer' => $customer->id,
			'amount'   => $_POST['amount']*100,
			'currency' => 'usd',
			'description' => 'donation',
			'metadata' => array(
			'project_id' => $_POST['project']
			)
		));
		$chargeJson = $charge->jsonSerialize();
		
		if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
			$payment_data = array('project_id' => $chargeJson['metadata']['project_id'],'name' => $_POST['name'],'email' => $_POST['email'],'amount' => $chargeJson['amount']/100,'balance_transaction' => $chargeJson['balance_transaction'],'status' => $chargeJson['status'],'comment' => $_POST['pay_comment'],'date' => date("Y-m-d H:i:s") );

			$table_name = "Donate_user";
			$result_insert = $wpdb->insert($table_name, $payment_data );

			if($result_insert){
					$msg = "Payment success. Thank You for Donation";
			}else{
				$msg = "Payment failed.";
			}
		}
	}
	catch (Exception $e) {
		$msg = $e->getMessage();
	}
	echo $msg; exit;
}

/*====== Donation Popup ======*/
add_shortcode( 'funding_donation_popup', 'funding_donation_popup' );
function funding_donation_popup() {
	$return = '';

	$rand = rand(0,999);

	$return .= '<button class="" id="myBtn" onclick="document.getElementById(\'donate'.$rand.'\').style.display=\'block\'">Donate </button>';
	$return .= '<div id="donate'.$rand.'" class="modal_fund">';
	
	  $return .= '<div class="modal_fund-content">';
	 
	    $return .= '<span class="close_fund" onclick="document.getElementById(\'donate'.$rand.'\').style.display=\'none\'">&times;</span>';
	    $return .= '<span class="payment-errors"></span>';

		$return .= '<!-- stripe payment form -->';
		$return .= '<form action="" method="POST" id="paymentFrm">';

		    $return .= '<p>';
		    	$return .= '<label for="pay_amount">Give</label>';
		        
		        $return .= '<input type="radio" name="pay_amount"  value="10"  class="check_pay"/>';
		        $return .= '<label>$10</label>&nbsp;';
		        
		        $return .= '<input type="radio" name="pay_amount" value="25"  class="check_pay"/>';
		        $return .= '<label>$25</label>&nbsp;';
		        
		        $return .= '<input type="radio" name="pay_amount"  value="50"  class="check_pay"/>';
		        $return .= '<label>$50</label>&nbsp;';
		        
		        $return .= '<input type="radio" name="pay_amount"  value="110" class="other_pay_option" />';
		        $return .= '<label>Other</label>&nbsp;';
		         
		        $return .= '<input type="text" class="other_pay_amount" style="display: none" />';
		    $return .= '</p>';

		    $return .= '<p>Or be an equality.org classroom hero and fnish this project for $110</p>';

		     $return .= '<p class="col-md6 ctm">';
		        $return .= '<label>Name</label>';
		        $return .= '<input type="text" name="name" size="50" class="pay_name" placeholder="Name"/>';
		    $return .= '</p>';

		    $return .= '<p class="col-md6 ctm">';
		        $return .= '<label>Email</label>';
		        $return .= '<input type="text" name="email" size="50" class="pay_email" placeholder="Email"/>';
		    $return .= '</p>';
		     $return .= '<p class="col-md6 ctm">';
		        $return .= '<label>Address</label>';
		        $return .= '<input type="text" name="address" size="50" class="pay_address" placeholder="Address" />';
		    $return .= '</p>';
		    $return .= '<p class="col-md6 ctm">';
		        $return .= '<label>Card Number</label>';
		        $return .= '<input type="text" name="card_num" size="20" autocomplete="off" class="card-number" placeholder="Card Number" maxlength="16" />';
		    $return .= '</p>';
		    $return .= '<p class="col-md12 ctm">';
		        $return .= '<label>CVC</label>';
		        $return .= '<input type="text" name="cvc" size="4" autocomplete="off" class="card-cvc" placeholder="CVC"/>';
		    $return .= '</p>';
		    $return .= '<p  class="col-md12 ctm no-padding">';
		        $return .= '<label>Expiration (MM/YY)</label>';
		       
		    $return .= '</p>';
			$return .= '<p  class="col-md6 ctm">';
		        $return .= '<input type="text" name="exp_month" size="2" class="card-expiry-month" placeholder="Month" />';
		    $return .= '</p>';   
			$return .= '<p  class="col-md6 ctm">';
		        $return .= '<input type="text" name="exp_year" size="4" class="card-expiry-year" placeholder="Year"/>';
		    $return .= '</p>';
		    $return .= '<p class="col-md12 ctm">Covers all credit card fees, we won\'t ask you to be any more generous than you already are!</p>';
		    $return .= '<p class="col-md12 ctm">';
		        $return .= '<label>Leave an encouraging comment to the teacher</label>';
		        $return .= '<textarea name="pay_comment" class="pay_comment" placeholder="Comment"></textarea>';
		    $return .= '</p>';
		    $return .= '<input type="hidden" id="site_url" value="'.home_url().'">';
		    $return .= '<input type="hidden" class="project_id" value="'.get_the_id().'">';
		    $return .= '<img src="'.site_url(). '/wp-content/plugins/fundraising/images/loading.gif" id="pay_loader" style="display: none;">';
		    $return .= '<button type="submit" id="payBtn">Donate</button>';
		$return .= '</form>';
		 $return .= '<div class="messages"></div>';
	  $return .= '</div>';
	$return .= '</div>';
	return $return;
}

?>