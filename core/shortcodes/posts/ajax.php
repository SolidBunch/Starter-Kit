<?php

namespace ffblank\shortcodes\posts;

add_action( 'wp_ajax_shortcode_load_posts', __NAMESPACE__ . '\\load_posts');
add_action( 'wp_ajax_nopriv_shortcode_load_posts', __NAMESPACE__ . '\\load_posts');

function load_posts() {

	$shortcode_atts = json_decode( stripslashes( $_POST['shortcode_atts'] ), true );
	$shortcode_atts = \ffblank\helper\utils::sanitize_array_text_params( $shortcode_atts );

	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	$query_vars['paged'] = absint( $_POST['paged'] ) + 1;
	$query_vars = \ffblank\helper\utils::sanitize_array_text_params( $query_vars );


	$query = FFBLANK()->model->post->get_posts( $query_vars );

	while( $query->have_posts() ): $query->the_post();

		FFBLANK()->view->load( '/view/loop_item', array(
			'atts' => $shortcode_atts
		), false, dirname( __FILE__ ) );

	endwhile;

	exit;
}