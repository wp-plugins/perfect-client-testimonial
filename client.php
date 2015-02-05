<?php
/**
 * Plugin Name: Perfect Client Testimonial
 * Plugin URI: http://nakshighor.com/testimonial
 * Description: Perfect Client Testimonial is one of the best custom plugin to publish your unlimited clients testimonial with your clients image. Anybody can able to use this plugin easily. You can add clients testimonial by using this plugin anywhere in your websites like Pages,Posts, Widgets etc. with its lots of amazing features. 
 * Version:  1.0.0
 * Author: Theme Road
 * Author URI: http://nakshighor.com/testimonial
 * License:  GPL2
 *Text Domain: tmrd
 *  Copyright 2015 GIN_AUTHOR_NAME  (email : BestThemeRoad@gmail.com
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License, version 2, as
 *	published by the Free Software Foundation.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

if(!defined('ABSPATH')) exit;      // Prevent Direct Browsing


/*
*************************************************************************
* Css and Js include
***************************************************************************
**/
/*
 * Enqueue Bootstrap According JS and Styleseets
 */



// function my_init_method() {
//     wp_deregister_script( 'jquery' );
//     wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
// }    

// add_action('init', 'my_init_method');

function trmd_incl_script_style() {
    wp_enqueue_script('jquery' );
    wp_enqueue_style( 'trmd-owl-style', plugins_url('/assets/css/owl.carousel.css', __FILE__) );
    wp_enqueue_style( 'trmd-owl-thme-style', plugins_url('/assets/css/owl.theme.css', __FILE__) );
    wp_enqueue_style( 'trmd-font-awesome-style', plugins_url('/assets/css/font-awesome.min.css', __FILE__) );
    wp_enqueue_style( 'trmd-owl-style', plugins_url('/assets/css/style.css', __FILE__));
    wp_enqueue_script( 'trmd-owl.carousel-js', plugins_url('/assets/js/owl.carousel.js', __FILE__) ,array('jquery'));
    wp_enqueue_script( 'trmd-main-js', plugins_url('/assets/js/main.js', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'trmd_incl_script_style' );



/*
*************************************************************************
* Testimonial Custom Post Icon
***************************************************************************
**/
function trmd_testimonials_dashboard_icon(){
?>
 <style>
/*Testimonials Dashboard Icons*/
#adminmenu .menu-icon-testimonials div.wp-menu-image:before {
  content: "\f205";
}
</style>
<?php
}
add_action( 'admin_head', 'trmd_testimonials_dashboard_icon' );





/*
*************************************************************************
* Testimonial Custom Post Type
***************************************************************************
**/


function tmrd_custom_post_type(){

    $labels = array(
        'name'                => _x( 'Testimonials', 'tmrd' ),
        'singular_name'       => _x( 'Testimonial', 'tmrd' ),
        'menu_name'           => __( 'Testimonials', 'tmrd' ),
        'parent_item_colon'   => __( 'Parent Testimonials:', 'tmrd' ),
        'all_items'           => __( 'All Testimonials', 'tmrd' ),
        'view_item'           => __( 'View Testimonial', 'tmrd' ),
        'add_new_item'        => __( 'Add New Testimonial', 'tmrd' ),
        'add_new'             => __( 'New Testimonial', 'tmrd' ),
        'edit_item'           => __( 'Edit Testimonial', 'tmrd' ),
        'update_item'         => __( 'Update Testimonial', 'tmrd' ),
        'search_items'        => __( 'Search Testimonials', 'tmrd' ),
        'not_found'           => __( 'No Testimonials found', 'tmrd' ),
        'not_found_in_trash'  => __( 'No Testimonials found in Trash', 'tmrd' ),
    );
    $args = array(

        'labels'              => $labels,
        'description'         => __( 'Theme Road Testimonials Post Type', 'tmrd' ),
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => '',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'testimonials', $args );


}

add_action('init' , 'tmrd_custom_post_type');



/*
*************************************************************************
* Testimonial Meta Box
***************************************************************************
**/

function trmd_testimonial_add_meta_box(){

// add meta Box
    add_meta_box(
        'trmd_testimonial_meta_id', 					// ID
        __( 'Client Information', 'trmd' ), 			// Testimonial Meta Box Title
        'trmd_meta_callback', 						// Call Back Funtion
        'testimonials',								//Post Type
        'side'

    );

}
add_action('add_meta_boxes' , 'trmd_testimonial_add_meta_box');


/*
*************************************************************************
* Testimonial Meta Box Call Back Funtion
***************************************************************************
**/


function trmd_meta_callback($post){

    wp_nonce_field( basename( __FILE__ ), 'trmd_nonce' );
    $trmd_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <label for="trmd_testimonial_meta_name" class="trmd_testimonial_meta_name"><?php _e( 'Name', 'trmd' )?></label>
        <input class="widefat" type="text" name="trmd_testimonial_meta_name" id="trmd_testimonial_meta_name" value="<?php if ( isset ( $trmd_stored_meta['trmd_testimonial_meta_name'] ) ) echo $trmd_stored_meta['trmd_testimonial_meta_name'][0]; ?>" />
    </p>

    <p>
        <label for="trmd_testimonial_meta_destignation" class="trmd_testimonial_meta_destignation"><?php _e( 'Designation', 'trmd' )?></label>
        <input class="widefat" type="text" name="trmd_testimonial_meta_destignation" id="trmd_testimonial_meta_destignation" value="<?php if ( isset ( $trmd_stored_meta['trmd_testimonial_meta_destignation'] ) ) echo $trmd_stored_meta['trmd_testimonial_meta_destignation'][0]; ?>" />
    </p>

<?php

}


/*
*************************************************************************
* Testimonial Save Meta Box 
***************************************************************************
**/
function trmd_testimonial_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'trmd_nonce' ] ) && wp_verify_nonce( $_POST[ 'trmd_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'trmd_testimonial_meta_name' ] ) ) {
        update_post_meta( $post_id, 'trmd_testimonial_meta_name', sanitize_text_field( $_POST[ 'trmd_testimonial_meta_name' ] ) );
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'trmd_testimonial_meta_destignation' ] ) ) {
        update_post_meta( $post_id, 'trmd_testimonial_meta_destignation', sanitize_text_field( $_POST[ 'trmd_testimonial_meta_destignation' ] ) );
    }

}
add_action( 'save_post', 'trmd_testimonial_meta_save' );


/*
*************************************************************************
*Client Testimonial Shortcode 
***************************************************************************
**/


add_shortcode( 'tmrd-testimonial', 'trmd_client_testimonial_shortcode' );
function trmd_client_testimonial_shortcode( $atts ) {
    ob_start();
    extract( shortcode_atts( array (
        'type' => 'testimonials',
        'order' => 'date',
        'orderby' => 'title',
        'posts' => -1,
    
    ), $atts ) );
    $options = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
  		
    );
    $query = new WP_Query( $options );?>
    <div id="owl-demo" class="owl-carousel owl-theme">

   <?php if ( $query->have_posts() ) { ?>
        

            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="item" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <div class="client-description"> <?php the_content() ;?></div>
                <div class="client-photo"><?php the_post_thumbnail('thumbnail'); ?></div> 
                <span class="client-name"><?php echo  get_post_meta( get_the_ID(), 'trmd_testimonial_meta_name', true );?> </span> ,
    
  				 <span class="client-designation"><?php echo  get_post_meta( get_the_ID(), 'trmd_testimonial_meta_destignation', true );?></span>

            </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }   
}

/*
*************************************************************************
*Client Testimonial Shortcode For Widget
***************************************************************************
**/

add_filter('widget_text', 'do_shortcode');


