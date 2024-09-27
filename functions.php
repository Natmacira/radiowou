<?php
// Cargar otros estilos adicionales
wp_enqueue_style('skeleton-style', QODE_ASSETS_ROOT . '/css/custom-alt.css');

/// custom ALT

// Register the shortcode
function catastrophe_banner_shortcode($atts)
{
	// Define attributes and set defaults
	$atts = shortcode_atts(array(
		'post_id' => '',    // The post ID to be featured
		'excerpt' => '',    // Optional manual excerpt
		'youtube_url' => '', // YouTube link
	), $atts, 'catastrophe_banner');

	// Get the post object
	if (!empty($atts['post_id'])) {
		$post = get_post($atts['post_id']);
		if ($post) {
			// Get the title, link, image, and date
			$title = get_the_title($post->ID);
			$link = get_permalink($post->ID);
			$image = get_the_post_thumbnail_url($post->ID, 'large');
			$date = get_the_date('F j, Y', $post->ID);

			// Use the provided excerpt or fallback to the post's excerpt
			$excerpt = !empty($atts['excerpt']) ? $atts['excerpt'] : get_the_excerpt($post->ID);

			// Build the banner output
			$output = '<div class="catastrophe-banner">';

			// Image on the left (70%) and linked to the post
			$output .= '<div class="catastrophe-image" style="float: left; width: 70%;">';
			$output .= '<a href="' . esc_url($link) . '">';
			$output .= '<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '">';
			$output .= '</a>';
			$output .= '</div>';

			// Content on the right (30%)
			$output .= '<div class="catastrophe-content" style="float: right; width: 30%;">';

			// YouTube button above the title
			if (!empty($atts['youtube_url'])) {
				$output .= '<a href="' . esc_url($atts['youtube_url']) . '" class="catastrophe-youtube-btn" target="_blank">Watch on YouTube</a>';
			}

			// Title with link
			$output .= '<h2 class="catastrophe-title"><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></h2>';

			// Date
			$output .= '<p class="catastrophe-date">' . esc_html($date) . '</p>';

			// Excerpt
			$output .= '<p class="catastrophe-excerpt">' . esc_html($excerpt) . '</p>';

			$output .= '</div>'; // End content div
			$output .= '<div style="clear: both;"></div>'; // Clear floats
			$output .= '</div>'; // End banner div

			return $output;
		} else {
			return '<p>Post not found.</p>';
		}
	} else {
		return '<p>No post selected.</p>';
	}
}
add_shortcode('catastrophe_banner', 'catastrophe_banner_shortcode');

// example of shortcode to use in the html block
// [catastrophe_banner post_id="123" excerpt="Custom excerpt" youtube_url="https://www.youtube.com/watch?v=example"]