<?php

/**
 * Plugin Name: Article JSON-LD Generator
 * Plugin URI: https://kaminoweb.com/
 * Description: Automatically generates a JSON-LD blog post schema and saves it to a custom field for better SEO.
 * Version: 1.1
 * Author: KAMINOWEB INC
 * Author URI: https://kaminoweb.com/
 * License: GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: article-json-ld-generator
 */

// Hook into the post save action to update the custom field
add_action('save_post', 'add_json_ld_to_custom_field', 10, 3);

function add_json_ld_to_custom_field($post_id, $post, $update) {
    // Prevent infinite loop and revisions
    if (wp_is_post_revision($post_id) || $post->post_type != 'post') {
        return;
    }

    // Gather post data
    $post_title = get_the_title($post_id);
    $post_slug = $post->post_name;
    $post_url = get_permalink($post_id);
    $post_date = get_the_date('Y-m-d', $post_id);
    $post_modified_date = get_the_modified_date('Y-m-d', $post_id);
    $author_name = get_the_author_meta('display_name', $post->post_author);

    // Get the featured image URL
    $featured_image_url = '';
    if (has_post_thumbnail($post_id)) {
        $featured_image_url = get_the_post_thumbnail_url($post_id, 'full');
    }

    // Get the meta description from the custom field "_meta_description"
    $meta_description = get_post_meta($post_id, '_meta_description', true);

    // If no description is found, set it to an empty string
    if (empty($meta_description)) {
        $meta_description = '';  // Leave empty if no description is found
    }

    // Get the "description" custom field for the blog post
    $post_description = get_post_meta($post_id, 'description', true);

    // If a description exists in the "description" custom field, use it
    if (!empty($post_description)) {
        // Clean and sanitize the description
        $post_description = wp_kses_post($post_description);  // Allow only safe HTML
        $post_description = html_entity_decode($post_description, ENT_QUOTES, 'UTF-8');  // Decode any encoded entities

        // Normalize the description to avoid any unwanted characters (e.g., converting `’` to `'`)
        $post_description = str_replace(["\u2019", "’"], "'", $post_description);  // Replace Unicode apostrophe and curly quotes

        // Sanitize the description again before saving to ensure safety
        $meta_description = htmlspecialchars($post_description, ENT_NOQUOTES, 'UTF-8');  // Only encode special chars except quotes
    }

    // Sanitize title and description for JSON-LD compatibility (escape quotes and special chars)
    $post_title = sanitize_text_field($post_title);  // Sanitize title for output
    $meta_description = sanitize_textarea_field($meta_description); // Sanitize description

    // Manually escape any double quotes in the description (for valid JSON)
    $meta_description = str_replace('"', '\"', $meta_description);

    // Construct the JSON-LD data
    $json_ld_data = array(
        "@context" => "https://schema.org",
        "@type" => "BlogPosting",
        "headline" => $post_title,
        "image" => $featured_image_url,
        "publisher" => array(
            "@type" => "Organization",  // Publisher is now an Organization
            "name" => get_bloginfo('name'),  // The organization name
        ),
        "url" => $post_url,
        "datePublished" => $post_date,
        "dateCreated" => $post_date,
        "dateModified" => $post_modified_date,
        "description" => $meta_description, // Use the sanitized meta description
        "author" => array(
            "@type" => "Person",
            "name" => $author_name,
        ),
    );

    // Encode the data to JSON (this handles escaping any characters that could break JSON)
    $json_ld = json_encode($json_ld_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    // Save the custom field to post meta
    update_post_meta($post_id, 'article-JSON-LD', $json_ld);
}

// Add JSON-LD to the <head> section of the post
function add_article_json_ld_to_head() {
    if (is_single()) { // Only run on single posts
        // Retrieve the 'article-JSON-LD' custom field
        $json_ld = get_post_meta(get_the_ID(), 'article-JSON-LD', true);

        // If JSON-LD exists, insert it into the head section
        if ($json_ld) {
            echo '
            <script type="application/ld+json">' . $json_ld . '</script>
            ';
        }
    }
}
add_action('wp_head', 'add_article_json_ld_to_head');

