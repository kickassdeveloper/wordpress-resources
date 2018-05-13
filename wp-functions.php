<?php
/** function for transforming urls from http to https
 * the function checks if the ssl is activate,
 * else returns the original string.
 * if the ssl is active it ckecks if the link is https,
 * if it is returns it, else it converts the link https,
 * and then returns it.
**/

function set_https($string){// $string is the passing argument
	if (is_ssl()) {
		$test = strpos($string, 'https:');//checks if the link has https in it, if so it returns true
		if($test === false){
			$result = str_replace('http:', 'https:', $string);
			//swaps the http: , with https: (   ":"" is for so i  you can use http://example.org/how-http-works/'
            //without transforming the secon http to https)
			return $result;
		}else{
			return $string;
		}
	}else{
		return $string;
	}
}



/**
 *  the next snippet of code is for adding custom size for pictures
 *   take in mind that you will have to regenerate thumbnails for pictures
 *   that were added before adding this functionality
**/
//check if the function for adding image size exists
if ( function_exists( 'add_image_size' ) ) {
    //add theme support for custom size of images in posts/pages so you can use them in code
    //for more info  https://codex.wordpress.org/post_thumbnails
    add_theme_support( 'post-thumbnails' );

    //define the new custom-size ( you can call it whatever like 'bob-size'
    //( 'name_of_custom_size', 'width_of_custom_size' , 'height_of_custom_size' , 'cropping_of_image')
    //if false (default), images will be scaled, not cropped.
    //if an array in the form of array( x_crop_position, y_crop_position ):
    //    x_crop_position accepts ‘left’ ‘center’, or ‘right’.
    //    y_crop_position accepts ‘top’, ‘center’, or ‘bottom’.
    //    images will be cropped to the specified dimensions within the defined crop area.
    //if true, images will be cropped to the specified dimensions using center positions.
    add_image_size( 'custom-size', 320, 180, true );
}

//adding for the custom_size feature to the backend
//(exp. selecting the size of a image when adding it to a post/page)
add_filter( 'image_size_names_choose', 'custom_sizes' );

//defining the function for adding the custom_size feature to backend
function custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        //the 'custom-size refers to the added size in the if code block above like 'bob-size'
        //'custom size name' is the string for the name of your size that is going to be displayed in the backend
        // like:
        //      small                   250x250
        //      medium                  640x480
        //      orginal                 800x600
        //      custom size name        320x180
        'custom-size' => __( 'custom size name' ),
    ) );
}

/**
 * function for removing wp version parameter from any enqueued scripts
 * @param $src
 * @return string
 */
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
//filter for removeing  version parameter from styles
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
//filter for removeing version parameter from scripts
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

/**
 * Proper way to enqueue scripts and styles
 */
function enqueue_theme_styles() {
//Definition of function in use
//     wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
//          $handle (exp. 'bootstrap')
//          (string) (Required) Name of the stylesheet. Should be unique.

//          $src    (exp. 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')
//          (string) (Optional) Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.

//          $deps   (exp. ['example_deps_url'])
//          (array) (Optional) An array of registered stylesheet handles this stylesheet depends on.
//          Default value: array()

//          $ver    (exp. null , this dons't add version number witch optimizes for page load
//          (string|bool|null) (Optional) String specifying stylesheet version number, if it has one,
//          which is added to the URL as a query string for cache busting purposes.
//          If version is set to false, a version number is automatically added equal to current installed
//          WordPress version. If set to null, no version is added.
//          Default value: false

//          $media  (exp. 'all')
//          (string) (Optional) The media for which this stylesheet has been defined. Accepts media types like 'all',
//          'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
//          Default value: 'all'

//      wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
//      Values as above, additionally:

//          $in_footer (exp. true, best practice in most case to be 'true' so it doesn't block rendering of the page
//          (bool) (Optional) Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
//          Default value: false



    // wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    // wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
    wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', false, null, 'all' );

}
//Hook for activating the function when generating the page.
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );

/**
 * Custom function for getting the post featured image link
 * @param $postID
 * @param $size   (registered image size small,medium,large)
 * @return string ( url of the featured image
 * combine this function with the set_https function if makein custom themes
 */
function get_page_feature_image_url($postID, $size)
{
    //get wp object of featured image
    $feature_image_id = get_post_thumbnail_id($postID);
    //get array of the featured image based on size
    $feature_image_meta = wp_get_attachment_image_src($feature_image_id, $size);
    //the 1st argument of the array is the url of the image  2nd is the width the 3ed is the height
    $link = $feature_image_meta[0];
    //return the first argument
    return $link;
}

/**
 * Simple function for printing out content with character limitations
 * @param $content
 * @param $char_limit
 * @param $end_string
 * exp "You want to limit a excerpt to 220 char and hava ... at the end"
 * call function print_char_limit(get_the_excerpt(), 220, '...');
*/
function print_content_char_limit($content,$char_limit , $end_string){
    echo substr($content, 0,$char_limit).$end_string;
}

/**
 * Generic function for getting all custom posts that are published
 * @param $post_type
 * @return WP_Query values are WP object
 *
 * This function should be used with custom post types  but can be used with core post types
 * ( you don't have to use the  CPT plugin if you registered your own CPT)
 * exp:
 * $return_values = get_custom_posts('post');
 * while( $return_values->have_posts() )$return_values->the_post();
 * echo the_content();
 * endwhile;
 */
function get_custom_posts($post_type){
    //Get the number of all posts that are published
    $count_posts = wp_count_posts( $post_type )->publish;
    //Define the arguments for WP_Query
    $args = array('post_type'=> $post_type,
            'posts_per_page' =>$count_posts,
            'orderby'  => 'post_id',
            'order'    => 'asc'
            );
    //Construct the WP object with the past arguments
    $custom_posts = new WP_Query($args);
    return $custom_posts;
}


//Removes inline styles and other coding junk added by the WYSIWYG editor.
add_filter( 'the_content', 'clean_post_content' );
function clean_post_content($content) {

    // Remove inline styling
    $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);

    // Remove font tag
    $content = preg_replace('/<font[^>]+>/', '', $content);

    // Remove empty tags
    $post_cleaners = array('<p></p>' => '', '<p> </p>' => '', '<p>&nbsp;</p>' => '', '<span></span>' => '', '<span> </span>' => '', '<span>&nbsp;</span>' => '', '<span>' => '', '</span>' => '', '<font>' => '', '</font>' => '');
    $content = strtr($content, $post_cleaners);

    return $content;
}

//register new custom type taxonomy(category)
function add_custom_types_to_tax( $query ) {
	if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
		// Get all your post types
		$post_types = get_post_types();
		$query->set( 'post_type', $post_types );
		return $query;
	}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );


