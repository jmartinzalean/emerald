<?php
/*
Template Name: Ranking General
*/

get_header(); ?>
<?php wp_enqueue_style('ttg_styles', plugin_dir_url( __DIR__ ).'assets/css/ttg_p_styles.css',array(),time()); ?>
<?php wp_enqueue_script('bootstrap_js', plugin_dir_url( __DIR__ ) .'assets/js/bootstrap.js', array('jquery'), time(), true);?>
<?php
//Specific class for post listing */
if ( kleo_postmeta_enabled() ) {
	$meta_status = ' with-meta';
	if ( sq_option( 'blog_single_meta', 'left' ) == 'inline' ) {
		$meta_status .= ' inline-meta';
	}
	add_filter( 'kleo_main_template_classes', create_function( '$cls', '$cls .= "' . $meta_status . '"; return $cls;' ) );
}

/* Related posts logic */
$related = sq_option( 'related_posts', 1 );
if ( ! is_singular( 'post' ) ) {
	$related = sq_option( 'related_custom_posts', 0 );
}
//post setting
if ( get_cfield( 'related_posts' ) != '' ) {
	$related = get_cfield( 'related_posts' );
}
?>

<?php get_template_part( 'page-parts/general-title-section' ); ?>

<?php

global $wp; // may be required to bring into scope

$slug = $post->post_name;

if($slug == 'general'){
    include('rankings-template-general.php');
}else{
    include('rankings-template-jugadores.php');
}

?>

<?php get_footer(); ?>
