<?php
/*
Plugin Name: MediaWiki Links
Description: Allows the creation of links with MediaWiki syntax for links to pages within a Wordpress install. 
Version: 1.0
Author: Michael
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Hook into the content filter
add_filter('the_content', 'mw_style_links_parse_content');

/**
 * Parses the content for MediaWiki style links and replaces them with HTML links.
 *
 * @param string $content The content of the post.
 * @return string The processed content.
 */
function mw_style_links_parse_content($content) {
    // The regular expression to match MediaWiki style links [[Slug|Text]]
    $pattern = '/\[\[(.*?)\|(.*?)\]\]/';

    // Replacement pattern
    $replacement = '<a href="' . esc_url(home_url('/$1')) . '">$2</a>';

    // Process the content
    $content = preg_replace_callback($pattern, function ($matches) {
        // Ensure the URL is safe and properly formatted
        $url = esc_url(home_url('/' . sanitize_title($matches[1])));
        $text = esc_html($matches[2]);
        return "<a href='{$url}'>{$text}</a>";
    }, $content);

    return $content;
}
