<?php
/***** Create metafield ***/
add_action( 'cmb2_admin_init', 'custom_page_metaboxes' );
function custom_page_metaboxes() {
   $prefix = 'custom_pg_';
   $cmb = new_cmb2_box( array(
       'id'            => $prefix . 'metabox',
       'title'         => esc_html__( 'Post a Fund A Need Project Fields', 'cmb2' ),
       'object_types'  => array( 'projects' ), // Post type  
   ) );
	$cmb->add_field( array(
		'name' => 'Approve Projects',
		'id'   => 'cust_approve',
		'type' => 'checkbox',
	) );
   $cmb->add_field( array(
		'name' => 'Name',
		'type' => 'text',
		'id'   => 'cust_name'
	) );
	$cmb->add_field( array(
		'name' => 'Email',
		'id'   => 'cust_email',
		'type' => 'text_email',
	) );
	$cmb->add_field( array(
		'name' => 'Address',
		'id'   => 'cust_address',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'City',
		'id'   => 'cust_city',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'State',
		'id'   => 'cust_state',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Zip',
		'id'   => 'cust_zip',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Tax ID',
		'id'   => 'cust_taxid',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Fundraising Amount',
		'id'   => 'cust_fundamount',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'I certify that this is a public school classroom',
		'id'   => 'cust_checkclassroom',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'School Name',
		'id'   => 'cust_schoolname',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'What grade?',
		'id'   => 'cust_grade',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'School City',
		'id'   => 'cust_scity',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'School State',
		'id'   => 'cust_sstate',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Item Amount',
		'id'   => 'cust_amount',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'How many students will this impact?',
		'id'   => 'cust_impact',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Percentage of students from low-income families',
		'id'   => 'cust_income',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Primary Photo',
		'id'   => 'cust_primaryphoto',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Additional Photos',
		'id'   => 'cust_additionalphoto',
		'type' => 'textarea',
	) );
	$cmb->add_field( array(
		'name' => 'Help My students line',
		'id'   => 'cust_help',
		'type' => 'textarea',
	) );
	$cmb->add_field( array(
		'name' => 'Facebook Link',
		'id'   => 'fb_link',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Twitter Link',
		'id'   => 'tw_link',
		'type' => 'text',
	) );
	$cmb->add_field( array(
		'name' => 'Instagram Link',
		'id'   => 'insta_link',
		'type' => 'text',
	) );

}