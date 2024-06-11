
<?php
/**
 * Resource Wrangler - User Resctrictions
 * Author: Christopher Spradlin
 * Description: Extended functions to remove various options for the custom Resource Wrangler user type. 
 */

// Hide specific menu items for the 'wrangler' user group
function hide_menu_items_for_wrangler() {
    // Check if the current user is in the 'wrangler' user group
    $current_user = wp_get_current_user();
    if (in_array('wrangler', $current_user->roles)) {
        // Array of menu items to hide
        $items_to_hide = array(
            'edit.php', // Posts
            'upload.php', // Media
            'edit-comments.php', // Comments
            'tools.php', // Tools
            'profile.php', // Profile
            'index.php', // Dashboard
            'edit.php?post_type=elementor_library' // Elementor Library
        );

        // Loop through the menu items and hide them
        foreach ($items_to_hide as $item) {
            remove_menu_page($item);
        }
    }
}
add_action('admin_menu', 'hide_menu_items_for_wrangler');



// Hide publish options for the 'wrangler' user group
function hide_publish_options_for_wrangler() {
    // Check if the current user is in the 'wrangler' user group
    $current_user = wp_get_current_user();
    if (in_array('wrangler', $current_user->roles)) {
        ?>
        <style>
            /* Hide Status, Visibility, and Publish options */
            #misc-publishing-actions .misc-pub-section {
                display: none;
            }
        </style>
        <?php
    }
}
add_action('post_submitbox_misc_actions', 'hide_publish_options_for_wrangler');


// Hide "Save Draft" and "Preview" buttons for the 'wrangler' user group
function hide_save_draft_preview_buttons_for_wrangler() {
    // Check if the current user is in the 'wrangler' user group
    $current_user = wp_get_current_user();
    if (in_array('wrangler', $current_user->roles)) {
        ?>
        <style>
            /* Hide Save Draft and Preview buttons */
            #save-post,
            #post-preview {
                display: none !important;
            }
        </style>
        <?php
    }
}
add_action('admin_head-post.php', 'hide_save_draft_preview_buttons_for_wrangler');
add_action('admin_head-post-new.php', 'hide_save_draft_preview_buttons_for_wrangler');
