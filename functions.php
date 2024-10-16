<?php
// Cargar otros estilos adicionales
// wp_enqueue_style('skeleton-style', QODE_ASSETS_ROOT . '/css/custom-alt.css');
function dhd_enqueue_styles() {	
	wp_enqueue_style('customalt-style', get_stylesheet_directory_uri() . '/custom-alt.css');
}
add_action('wp_enqueue_scripts', 'dhd_enqueue_styles');

function agregar_shortcode_al_header() {
    echo '<div style="text-align: center; width: 100%;" id="player-header">';
    echo '<h4 class="qodef-widget-title">Escuchá WOU RADIO en vivo!</h4>';
    echo '<h4 class="qodef-widget-title">';
    echo do_shortcode('[radio_player id="58996"]');
    echo '</h4></div>'; 
}
add_action('wp_head', 'agregar_shortcode_al_header');

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

			// Image on the left and linked to the post
			$output .= '<div class="catastrophe-image" style="float: left;">';
			$output .= '<a href="' . esc_url($link) . '">';
			$output .= '<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '">';
			$output .= '</a>';
			$output .= '</div>';

			// Content on the right 
			$output .= '<div class="catastrophe-content">';

			if (!empty($atts['youtube_url'])) {
				$output .= '<a href="' . esc_url($atts['youtube_url']) . '" class="catastrophe-youtube-btn" target="_blank">';
				$output .= '<img src="' . esc_url(get_stylesheet_directory_uri() . '/img/play-btn.png') . '" alt="Watch on YouTube">';
				$output .= '</a>';
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
		return ' ';
	}
}
add_shortcode('catastrophe_banner', 'catastrophe_banner_shortcode');

// example of shortcode to use in the html block
// [catastrophe_banner post_id="123" excerpt="Custom excerpt" youtube_url="https://www.youtube.com/watch?v=example"]

function latest_three_local_posts() {
    // Argumentos para la consulta de los últimos 3 posts de la categoría 'local'
    $args = array(
        'category_name' => 'locales',
        'posts_per_page' => 3,
    );

    // Realizar la consulta
    $query = new WP_Query($args);

    // Comenzar el buffer de salida
    ob_start();

    // Verificar si hay posts
    if ($query->have_posts()) {

        echo '<div class="div-latest-local-posts-container">';
        echo '<p>Las noticias del día</p>';
        echo '<div class="latest-local-posts">';
        while ($query->have_posts()) {
            $query->the_post();

            // Obtener la imagen destacada
            $background_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
            
            echo '<a href="' . get_permalink() . '" class="post" style="background-image: url(' . esc_url($background_image) . ');">';
            echo '<div class="post-content">';
            echo '<h3>' . get_the_title() . '</h3>';
            echo '</div>'; // Cerrar .post-content
            echo '</a>'; // Cerrar el enlace <a>
        }
        echo '</div>'; // Cerrar .latest-local-posts
        echo '</div>'; // Cerrar .latest-local-posts
    } else {
        echo '<p>No recent posts in the Local category.</p>';
    }

    // Restaurar los datos originales del post
    wp_reset_postdata();

    // Retornar el contenido
    return ob_get_clean();
}

// Registrar el shortcode
add_shortcode('latest_local_posts', 'latest_three_local_posts');

// // Register the shortcode ORIGINAL
// function custom_banner_shortcode($atts)
// {
//     // Define attributes and set defaults
//     $atts = shortcode_atts(array(
//         'title' => '',        // The title entered by the client
//         'link' => '',         // The URL to link to
//         'image' => '',        // The image URL
//         'date' => '',         // The date (optional)
//         'excerpt' => '',      // Manual excerpt
//         'youtube_url' => '',  // YouTube link
//     ), $atts, 'custom_banner');

//     // Build the banner output
//     $output = '<div class="catastrophe-banner last-program">';
            
//     // Image on the left  and linked to the provided link
//     if (!empty($atts['image'])) {
//         $output .= '<div class="catastrophe-image" style="float: left;">';
//         $output .= '<p>Último programa</p>';
//         $output .= '<a href="' . esc_url($atts['link']) . '">';
//         $output .= '<img src="' . esc_url($atts['image']) . '" alt="' . esc_attr($atts['title']) . '">';
//         $output .= '</a>';
//         $output .= '</div>';
//     }

//     // Content on the right 
//     $output .= '<div class="catastrophe-content">';

//     // YouTube button
//     if (!empty($atts['youtube_url'])) {
//         $output .= '<a href="' . esc_url($atts['youtube_url']) . '" class="catastrophe-youtube-btn" target="_blank">';
//         $output .= '<img src="' . esc_url(get_stylesheet_directory_uri() . '/img/play-btn.png') . '" alt="Watch on YouTube">';
//         $output .= '</a>';
//     }

//     // Title with link
//     if (!empty($atts['title'])) {
//         $output .= '<h2 class="catastrophe-title"><a href="' . esc_url($atts['link']) . '">' . esc_html($atts['title']) . '</a></h2>';
//     }

//     // Date (optional)
//     if (!empty($atts['date'])) {
//         $output .= '<p class="catastrophe-date">' . esc_html($atts['date']) . '</p>';
//     }

//     // Excerpt
//     if (!empty($atts['excerpt'])) {
//         $output .= '<p class="catastrophe-excerpt">' . esc_html($atts['excerpt']) . '</p>';
//     }

//     $output .= '</div>'; // End content div
//     $output .= '<div style="clear: both;"></div>'; // Clear floats
//     $output .= '</div>'; // End banner div

//     return $output;
// }
// add_shortcode('custom_banner', 'custom_banner_shortcode');


// Register the shortcode
function custom_banner_shortcode($atts)
{
    // Define attributes and set defaults
    $atts = shortcode_atts(array(
        'title' => '',        // The title entered by the client
        'link' => '',         // Optional link for the image
        'image' => '',        // The image URL
        'date' => '',         // The date (optional)
        'excerpt' => '',      // Manual excerpt
        'youtube_id' => '',   // YouTube video ID (optional)
    ), $atts, 'custom_banner');

    // Generate the YouTube link using the YouTube ID
    $youtube_url = !empty($atts['youtube_id']) ? 'https://www.youtube.com/watch?v=' . esc_attr($atts['youtube_id']) : '';

    // Build the banner output
    $output = '<div class="catastrophe-banner last-program">';

    // If YouTube ID is provided, display iframe; if not, show image
    if (!empty($atts['youtube_id'])) {
        $output .= '<div class="catastrophe-image">';
        $output .= '<p>Último programa</p>';
        $output .= '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' . esc_attr($atts['youtube_id']) . '" frameborder="0" allowfullscreen></iframe>';
        $output .= '</div>';
    } elseif (!empty($atts['image'])) {
        $output .= '<div class="catastrophe-image">';
        $output .= '<p>Último programa</p>';
        $output .= '<a href="' . esc_url($atts['link']) . '">';
        $output .= '<img src="' . esc_url($atts['image']) . '" alt="' . esc_attr($atts['title']) . '">';
        $output .= '</a>';
        $output .= '</div>';
    }

    // Content on the right side
    $output .= '<div class="catastrophe-content">';

    // YouTube button
    if (!empty($atts['youtube_id'])) {
        $output .= '<a href="' . esc_url($youtube_url) . '" class="catastrophe-youtube-btn" target="_blank">';
        $output .= '<img src="' . esc_url(get_stylesheet_directory_uri() . '/img/play-btn.png') . '" alt="Watch on YouTube">';
        $output .= '</a>';
    } elseif (empty($atts['youtube_id']) && (!empty($atts['link'])) ) {
        $output .= '<a href="' . esc_url($atts['link']) . '" class="catastrophe-youtube-btn" target="_blank">';
        $output .= '<img src="' . esc_url(get_stylesheet_directory_uri() . '/img/play-btn.png') . '" alt="Watch on YouTube">';
        $output .= '</a>';
    }

    // Title with YouTube link
    if (!empty($atts['title']) && !empty($atts['youtube_id'])) {
        $output .= '<h2 class="catastrophe-title"><a href="' . esc_url($youtube_url) . '">' . esc_html($atts['title']) . '</a></h2>';
    } elseif (!empty($atts['title'])) {
        $output .= '<h2 class="catastrophe-title"><a href="' . esc_url($atts['link']) . '">' . esc_html($atts['title']) . '</a></h2>';
    }

    // Date (optional)
    if (!empty($atts['date'])) {
        $output .= '<p class="catastrophe-date">' . esc_html($atts['date']) . '</p>';
    }

    // Excerpt
    if (!empty($atts['excerpt'])) {
        $output .= '<p class="catastrophe-excerpt">' . esc_html($atts['excerpt']) . '</p>';
    }

    $output .= '</div>'; // End content div
    $output .= '<div style="clear: both;"></div>'; // Clear floats (if any)
    $output .= '</div>'; // End banner div

    return $output;
}
add_shortcode('custom_banner', 'custom_banner_shortcode');

// [custom_banner 
//     title="Título del programa" 
//     link="" 
//     image="https://example.com/image.jpg" 
//     date="15 de Octubre, 2024" 
//     excerpt="Este es un resumen del programa." 
//     youtube_id="dQw4w9WgXcQ"]


// [custom_banner 
//     title="Custom Title" 
//     link="https://example.com" 
//     image="https://example.com/image.jpg" 
//     date="September 25, 2024" 
//     excerpt="This is a custom excerpt for the banner." 
//     youtube_url="https://youtube.com/watch?v=example"]



// Ocultar warnings en WordPress
// add_action('wp_loaded', function() {
//     // Ajusta el nivel de reporting para evitar warnings
//     error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
//     ini_set('display_errors', 0); // Desactiva la impresión de errores en pantalla
// });

add_action( 'ebullient_qodef_before_top_navigation', function() {
    get_search_form();
}, 10, 2);