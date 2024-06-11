<?php
/**
 * Extended Functions - Custom WordPress Excerpts and Taxonomies
 * Author: Christopher Spradlin
 * Description: Custom functions to modify excerpts for specific post types and create custom taxonomies.
 */

 function my_custom_food_excerpt($excerpt) {
    global $post;
    
    // Ensure we are working with the 'food' post type
    if ($post->post_type !== 'food') {
        return $excerpt;
    }

    // Get all custom fields for the current post
    $custom_fields = get_fields($post->ID);

    if ($custom_fields) {
        foreach ($custom_fields as $key => $value) {
            if (is_array($value)) {
                // Handle arrays (e.g., repeaters or flexible content)
                $value = implode(', ', $value);
            }
            // Append the value with inline CSS for color, size, and centering
            $excerpt .= '<span style="color:#E7E6E8; font-size:1.2rem; display:block; text-align:center;">' . esc_html($value) . '</span>';
        }
        // Add a divider after the custom fields
        $excerpt .= '<hr style="border: 1.5px solid #E7E6E8; margin: 15px 0;">';
    }

    return $excerpt;
}

// Hook the function to the 'the_excerpt' filter
add_filter('the_excerpt', 'my_custom_food_excerpt');




function my_custom_shelter_excerpt($excerpt) {
    global $post;
    
    // Ensure we are working with the 'shelter' post type
    if ($post->post_type !== 'shelter') {
        return $excerpt;
    }

    // Get all custom fields for the current post
    $custom_fields = get_fields($post->ID);

    if ($custom_fields) {
        foreach ($custom_fields as $key => $value) {
            if (is_array($value)) {
                // Handle arrays (e.g., repeaters or flexible content)
                $value = implode(', ', $value);
            }
            // Append the value with inline CSS for color, size, and centering
            $excerpt .= '<span style="color:#E7E6E8; font-size:1.2rem; display:block; text-align:center;">' . esc_html($value) . '</span>';
        }
        // Add a divider after the custom fields
        $excerpt .= '<hr style="border: 1.5px solid #E7E6E8; margin: 15px 0;">';
    }

    return $excerpt;
}

// Hook the function to the 'the_excerpt' filter
add_filter('the_excerpt', 'my_custom_shelter_excerpt');




function my_custom_clothing_excerpt($excerpt) {
    global $post;
    
    // Ensure we are working with the 'clothing' post type
    if ($post->post_type !== 'clothing') {
        return $excerpt;
    }

    // Get all custom fields for the current post
    $custom_fields = get_fields($post->ID);

    if ($custom_fields) {
        foreach ($custom_fields as   $key => $value) {
            if (is_array($value)) {
                // Handle arrays (e.g., repeaters or flexible content)
                $value = implode(', ', $value);
            }
            // Append the value with inline CSS for color, size, and centering
            $excerpt .= '<span style="color:#E7E6E8; font-size:1.2rem; display:block; text-align:center;">' . esc_html($value) . '</span>';
        }
        // Add a divider after the custom fields
        $excerpt .= '<hr style="border: 1.5px solid #E7E6E8; margin: 15px 0;">';
    }

    return $excerpt;
}

// Hook the function to the 'the_excerpt' filter
add_filter('the_excerpt', 'my_custom_clothing_excerpt');





function create_food_taxonomies() {
    // Register Food Days taxonomy
    $labels_days = array(
        'name'              => _x('Food Days', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Food Day', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Food Days', 'textdomain'),
        'all_items'         => __('All Food Days', 'textdomain'),
        'parent_item'       => __('Parent Food Day', 'textdomain'),
        'parent_item_colon' => __('Parent Food Day:', 'textdomain'),
        'edit_item'         => __('Edit Food Day', 'textdomain'),
        'update_item'       => __('Update Food Day', 'textdomain'),
        'add_new_item'      => __('Add New Food Day', 'textdomain'),
        'new_item_name'     => __('New Food Day Name', 'textdomain'),
        'menu_name'         => __('Food Days', 'textdomain'),
    );

    $args_days = array(
        'hierarchical'      => true,
        'labels'            => $labels_days,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'food-day'),
    );

    register_taxonomy('food_day', array('food'), $args_days);

    // Register Food Locations taxonomy
    $labels_locations = array(
        'name'              => _x('Food Locations', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Food Location', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Food Locations', 'textdomain'),
        'all_items'         => __('All Food Locations', 'textdomain'),
        'parent_item'       => __('Parent Food Location', 'textdomain'),
        'parent_item_colon' => __('Parent Food Location:', 'textdomain'),
        'edit_item'         => __('Edit Food Location', 'textdomain'),
        'update_item'       => __('Update Food Location', 'textdomain'),
        'add_new_item'      => __('Add New Food Location', 'textdomain'),
        'new_item_name'     => __('New Food Location Name', 'textdomain'),
        'menu_name'         => __('Food Locations', 'textdomain'),
    );

    $args_locations = array(
        'hierarchical'      => true,
        'labels'            => $labels_locations,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'food-location'),
    );

    register_taxonomy('food_location', array('food'), $args_locations);
}

add_action('init', 'create_food_taxonomies', 0);


function custom_food_meta_boxes() {
    // Remove default meta boxes
    remove_meta_box('tagsdiv-food_location', 'food', 'side');
    remove_meta_box('categorydiv', 'food', 'side');

    // Add custom meta boxes for Food Days
    add_meta_box(
        'food_daydiv',
        __('Food Days', 'textdomain'),
        'post_categories_meta_box',
        'food',
        'side',
        'default',
        array('taxonomy' => 'food_day')
    );

    // Add custom meta boxes for Food Locations
    add_meta_box(
        'food_locationdiv',
        __('Food Locations', 'textdomain'),
        'post_categories_meta_box',
        'food',
        'side',
        'default',
        array('taxonomy' => 'food_location')
    );
}

add_action('add_meta_boxes', 'custom_food_meta_boxes');
