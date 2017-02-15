<?php
// function for transforming urls from http to https
// the function checks if the ssl is activate,
// else returns the original string.
// if the ssl is active it ckecks if the link is https,
// if it is returns it, else it converts the link https,
// and then returns it.

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



//the next snippet of code is for adding custom size for pictures
//take in mind that you will have to regenerate thumbnails for pictures
//that were added before adding this functionality

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

?>