<?php

// registro el menu
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'menu', 'Menú principal' );
}
// Añado navwalker para menu responsive
require_once('wp_bootstrap_navwalker.php');

//Registro styles
function theme_styles() {
	wp_deregister_script( 'jquery' );
	
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', '', '1.0', false );
	wp_enqueue_script( 'jquery-ui-script', get_template_directory_uri() . '/js/jquery-ui.min.js', 'jquery', '1.0', true );
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', 'jquery', '1.0', true );


	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css');
	wp_enqueue_style( 'jquery-ui-style', get_template_directory_uri() . '/css/jquery/jquery-ui.css');

	wp_enqueue_style( 'style-css',  get_template_directory_uri()."/style.css", '', '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'theme_styles' );


// Tamaños de thumbnails
add_theme_support( 'post-thumbnails' );


// Creamos los custom post-type
function create_post_type() {

	$args = array(
		'labels' => array(
			'name' => 'Parroquias',
			'singular_name' => 'Parroquia',
			'add_new' => 'Añadir Parroquia'
		),
		'description' => 'Parroquias de Llambrión',
		'public' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'show_in_menu' => true,
		'hierarchical' => false,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes' ),
		'has_archive' => false,
		'rewrite' => true,
		'query_var' => false
	);
	register_post_type( 'parroquias', $args );


	$args = array(
		'labels' => array(
			'name' => 'Campamentos',
			'singular_name' => 'Campamento',
			'add_new' => 'Añadir Campamento'
		),
		'description' => 'Campamentos de este año',
		'public' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'show_in_menu' => true,
		'hierarchical' => false,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes' ),
		'has_archive' => false,
		'rewrite' => true,
		'query_var' => false
	);
	register_post_type( 'campamentos', $args );


	$args = array(
		'labels' => array(
			'name' => 'Eventos',
			'singular_name' => 'Evento',
			'add_new' => 'Añadir Evento'
		),
		'description' => 'Gestión de eventos',
		'public' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'show_in_menu' => true,
		'hierarchical' => false,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes' ),
		'has_archive' => false,
		'rewrite' => array( 'slug' => 'eventos/'.date('Y') ),
		'query_var' => false
	);
	register_post_type( 'eventos', $args );

}
add_action( 'init', 'create_post_type' );

/**
 * Definición de páginas de opciones del tema
 */
/*function theme_options_page_settings($options) {
	$options['pages'] = array(
		'Datos personales',
		'Conocimientos',
		'Redes sociales'
	);

	return $options;
}
add_filter('acf/options_page/settings','theme_options_page_settings');*/


function get_module($module_name){
	get_template_part('modules/' . $module_name);
}

function get_modules($field_name){
    while ( have_rows($field_name) ) {
    	the_row();
    	get_module(get_row_layout());
	}
}


/*
 * Devuelve un array con los mismos elementos que el objeto imagen que devuelve ACF
 */
function get_acf_image_object( $id, $size = 'full' ){
		
	$attachment = get_post($id);

	$src = wp_get_attachment_image_src( $id, $size );

	$value = array(
			'id' => $attachment->ID,
			'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
			'title' => $attachment->post_title,
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'mime_type'	=> get_post_mime_type( $id ),
			'url' => $src[0],
			'src' => $src[0],
			'width' => $src[1],
			'height' => $src[2],
	);

	return $value;

}


?>
