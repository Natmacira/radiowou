<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php
	/**
	 * ebullient_qodef_header_meta hook
	 *
	 * @see ebullient_qodef_header_meta() - hooked with 10
	 * @see ebullient_qodef_user_scalable_meta - hooked with 10
	 * @see qodef_core_set_open_graph_meta - hooked with 10
	 */
	do_action( 'ebullient_qodef_header_meta' );
	
	wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	<?php
	/**
	 * ebullient_qodef_after_body_tag hook
	 *
	 * @see ebullient_qodef_get_side_area() - hooked with 10
	 * @see ebullient_qodef_smooth_page_transitions() - hooked with 10
	 */
	do_action( 'ebullient_qodef_after_body_tag' ); ?>
	
	<div class="qodef-wrapper qodef-404-page">
		<div class="qodef-wrapper-inner">
            <?php
            /**
             * ebullient_qodef_after_wrapper_inner hook
             *
             * @see ebullient_qodef_get_header() - hooked with 10
             * @see ebullient_qodef_get_mobile_header() - hooked with 20
             * @see ebullient_qodef_back_to_top_button() - hooked with 30
             * @see ebullient_qodef_get_header_minimal_full_screen_menu() - hooked with 40
             * @see ebullient_qodef_get_header_bottom_navigation() - hooked with 40
             */
            do_action( 'ebullient_qodef_after_wrapper_inner' );

            do_action('ebullient_qodef_before_main_content'); ?>
			
			<div class="qodef-content" <?php ebullient_qodef_content_elem_style_attr(); ?>>
				<div class="qodef-content-inner">
						<div class="qodef-page-not-found">
							<div class="qodef-page-not-found-wrapper">
							
							<h1>404</h1>
							<p class="we-are-sorry">Lo sentimos. No pudimos encontrar la página</p>
							<a href="https://wou.com.ar/" class="go-back">Volver a la página de inicio</a>

							<section>
								
							<?php echo do_shortcode('[latest_local_posts]'); ?>


							</section>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 

get_footer(); ?> </body>
</html>