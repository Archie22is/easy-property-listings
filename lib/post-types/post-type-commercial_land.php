<?php
/**
 * Register post type :: Commercial Land
 *
 * @package     EPL
 * @subpackage  Meta
 * @copyright   Copyright (c) 2014, Merv Barrett
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
 
/**
 * Registers and sets up the Commercial Land custom post type
 *
 * @since 1.0
 * @return void
 */
function epl_register_custom_post_type_commercial_land() {

	$archives = defined( 'EPL_COMMERCIAL_LAND_DISABLE_ARCHIVE' ) && EPL_COMMERCIAL_LAND_DISABLE_ARCHIVE ? false : true;
	$slug     = defined( 'EPL_COMMERCIAL_LAND_SLUG' ) ? EPL_COMMERCIAL_LAND_SLUG : 'commercial-land';
	$rewrite  = defined( 'EPL_COMMERCIAL_LAND_DISABLE_REWRITE' ) && EPL_COMMERCIAL_LAND_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

	$labels = apply_filters( 'epl_commercial_land_labels', array(
		'name'					=>	__('Commercial Land Listings', 'epl'),
		'singular_name'			=>	__('Commercial Land Listing', 'epl'),
		'menu_name'				=>	__('Commercial Land', 'epl'),
		'add_new'				=>	__('Add New', 'epl'),
		'add_new_item'			=>	__('Add New Commercial Land Listing', 'epl'),
		'edit_item'				=>	__('Edit Commercial Land Listing', 'epl'),
		'new_item'				=>	__('New Commercial Land Listing', 'epl'),
		'update_item'			=>	__('Update Commercial Land Listing', 'epl'),
		'all_items'				=>	__('All Commercial Land Listings', 'epl'),
		'view_item'				=>	__('View Commercial Land Listing', 'epl'),
		'search_items'			=>	__('Search Commercial Land Listing', 'epl'),
		'not_found'				=>	__('Commercial Land Listing Not Found', 'epl'),
		'not_found_in_trash'	=>	__('Commercial Land Listing Not Found in Trash', 'epl'),
		'parent_item_colon'		=>	__('Parent Commercial Land Listing:', 'epl')
	) );
	
	$commercial_land_args = array(
		'labels'				=>	$labels,
		'public'				=>	true,
		'publicly_queryable'	=>	true,
		'show_ui'				=>	true,
		'show_in_menu'			=>	true,
		'query_var'				=>	true,
		'rewrite'				=>	$rewrite,
		'menu_icon'				=>	plugins_url( 'post-types/icons/building.png' , dirname(__FILE__) ),
		'capability_type'		=>	'post',
		'has_archive'			=>	$archives,
		'hierarchical'			=>	false,
		'menu_position'			=>	'26.8',
		'taxonomies'			=>	array( 'location', 'tax_feature' ),
		'supports'				=>	apply_filters( 'epl_commercial_land_supports', array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' , 'comments' ) ),
	);
	epl_register_post_type( 'commercial_land', 'Commercial Land', apply_filters( 'epl_commercial_land_post_type_args', $commercial_land_args ) );
}
add_action( 'init', 'epl_register_custom_post_type_commercial_land', 0 );
 
/**
 * Manage Admin Commercial Land Post Type Columns
 *
 * @since 1.0
 * @return void
 */
if ( is_admin() ) {
	/**
	 * Manage Admin Commercial Land Post Type Columns: Heading
	 *
	 * @since 1.0
	 * @return void
	 */
	function epl_manage_commercial_land_columns_heading( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'property_thumb' => __('Featured Image', 'epl'),
			'title' => __('Address', 'epl'),
			'property_address_suburb' => __('Suburb', 'epl'),
			'property_heading' => __('Heading', 'epl'),
			'property_price' => __('Price', 'epl'),
			'listing_type' => __('Type', 'epl'),
			'under_offer' => __('U/O', 'epl'),
			'geo' => __('Geo', 'epl'),
			'property_price_view' => __('Price View', 'epl'),
			'property_status' => __('Status', 'epl'),
			'author' => __('Agent', 'epl'),
			'date' => __('Date', 'epl'),
		);
		
		$geo_debug = 0;
		global $epl_settings;
		if(!empty($epl_settings) && isset($epl_settings['debug'])) {
			$geo_debug = $epl_settings['debug'];
		}
		if ( $geo_debug != 1 ) {
			unset($columns['geo']);
		}
		return $columns;
	}
	add_filter( 'manage_edit-commercial_land_columns', 'epl_manage_commercial_land_columns_heading' ) ;
	
	/**
	 * Manage Admin Commercial Land Post Type Columns: Row Contents
	 *
	 * @since 1.0
	 */
	function epl_manage_commercial_land_columns_value( $column, $post_id ) {
		global $post;
		switch( $column ) {
		
			/* If displaying the 'Featured' image column. */
			case 'property_thumb' :
				/* Get the featured Image */
				if( function_exists('the_post_thumbnail') )
					echo the_post_thumbnail('admin-list-thumb');
				break;
				
			case 'property_address_suburb' :
				/* Get the post meta. */
				$property_address_suburb = stripslashes(get_post_meta( $post_id, 'property_address_suburb', true ));
				echo $property_address_suburb;
				break;
		
			/* If displaying the 'Heading' column. */
			case 'property_heading' :
				/* Get the post meta. */
				$heading = get_post_meta( $post_id, 'property_heading', true );
				/* If no duration is found, output a default message. */
				if ( empty( $heading) )
					echo '<strong>'.__( 'Important! Set a Heading', 'epl' ).'</strong>';
				/* If there is a duration, append 'minutes' to the text string. */
				else
					 echo $heading;
				break;
				
			/* If displaying the 'Under Offer' column. */
			case 'under_offer' :
				/* Get the post meta. */
				$property_under_offer = get_post_meta( $post_id, 'property_under_offer', true );
				/* If no duration is found, output a default message. */
				if ( empty( $property_under_offer) )
					echo __( '', 'epl' );
				/* If there is a duration, append 'minutes' to the text string. */
				else
					 echo 'Yes';
				break;
			/* If displaying the 'Geocoding Debub' column. */
			case 'geo' :
				/* Get the post meta. */
				$property_address_coordinates = get_post_meta( $post_id, 'property_address_coordinates', true );
				/* If no duration is found, output a default message. */
				if (  $property_address_coordinates == ',' )
					echo 'NO' ;
				/* If there is a duration, append 'minutes' to the text string. */
				else
					// echo 'Yes';
					echo $property_address_coordinates;
				break;	
				
			/* If displaying the 'Price' column. */
			case 'property_price' :
				/* Get the post meta. */
				$price = get_post_meta( $post_id, 'property_price', true );
				/* If no duration is found, output a default message. */
				if ( empty( $price) )
					echo ''; //'<strong>'.__( 'No Price Set', 'epl' ).'</strong>';
				/* If there is a duration, append 'minutes' to the text string. */
				else
					echo epl_currency_formatted_amount( $price );
				break;
			/* If displaying the 'Price View' column. */
			case 'property_price_view' :
				/* Get the post meta. */
				$view = get_post_meta( $post_id, 'property_price_view', true );
				/* If no duration is found, output a default message. */
				if ( empty( $view) )
					echo ''; //'<strong>'.__( 'No Rent Set', 'epl' ).'</strong>';
				/* If there is a duration, append 'minutes' to the text string. */
				else
					 echo $view;
				break;
				
			/* If displaying the 'Commercial Land Listing Type' column. */
			case 'listing_type' :
				/* Get the post meta. */
				$listing_type = get_post_meta( $post_id, 'property_com_listing_type', true );
				/* If no duration is found, output a default message. */
				if ( empty( $listing_type) )
					echo ''; //'<strong>'.__( 'No Price Set', 'epl' ).'</strong>';
				/* If there is a duration, append 'minutes' to the text string. */
				else
					 echo $listing_type;
				break;
				
			/* If displaying the 'real-estate' column. */
			case 'property_status' :
				/* Get the genres for the post. */
				$property_status = ucfirst( get_post_meta( $post_id, 'property_status', true ) );
				echo '<span class="type_'.strtolower($property_status).'">'.$property_status.'</span>';
				break;
			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}
	add_action( 'manage_commercial_land_posts_custom_column', 'epl_manage_commercial_land_columns_value', 10, 2 );

	/**
	 * Manage Commercial Land Columns Sorting
	 *
	 * @since 1.0
	 */
	function epl_manage_commercial_land_sortable_columns( $columns ) {
		$columns['property_status'] = 'property_status';
		$columns['property_address_suburb'] = 'property_address_suburb';
		return $columns;
	}
	add_filter( 'manage_edit-commercial_land_sortable_columns', 'epl_manage_commercial_land_sortable_columns' );
}