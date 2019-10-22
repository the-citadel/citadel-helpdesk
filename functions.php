<?php
/**
 * Citadel Documentation functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Citadel_Documentation
 */

if ( ! function_exists( 'citadel_doc_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function citadel_doc_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Citadel Documentation, use a find and replace
		 * to change 'citadel-doc' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'citadel-doc', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'citadel-doc' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'citadel_doc_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'citadel_doc_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function citadel_doc_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'citadel_doc_content_width', 640 );
}
add_action( 'after_setup_theme', 'citadel_doc_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function citadel_doc_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'citadel-doc' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'citadel-doc' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'citadel_doc_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function citadel_doc_scripts() {
	// Get the theme data
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/style.css' );
	wp_enqueue_style( 'citadel-doc-styles', get_template_directory_uri() . '/style.css', array(), $css_version );
	wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css', array(), $theme_version );
	wp_enqueue_style( 'citadel-fonts', 'https://use.typekit.net/onz2qme.css', array(), $theme_version );

	wp_enqueue_script( 'jquery' );

	$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/scripts.js' );
	wp_enqueue_script( 'citadel-doc-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $js_version, true );
	wp_enqueue_script( 'citadel-doc-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $js_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'citadel_doc_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Citadel Tickets', 'Post Type General Name', 'citadel_doc' ),
		'singular_name'         => _x( 'Citadel Ticket', 'Post Type Singular Name', 'citadel_doc' ),
		'menu_name'             => __( 'Citadel Tickets', 'citadel_doc' ),
		'name_admin_bar'        => __( 'Citadel Tickets', 'citadel_doc' ),
		'archives'              => __( 'Ticket Archives', 'citadel_doc' ),
		'attributes'            => __( 'Ticket Attributes', 'citadel_doc' ),
		'parent_item_colon'     => __( 'Parent Ticket:', 'citadel_doc' ),
		'all_items'             => __( 'All Tickets', 'citadel_doc' ),
		'add_new_item'          => __( 'Add New Ticker', 'citadel_doc' ),
		'add_new'               => __( 'Add Ticket', 'citadel_doc' ),
		'new_item'              => __( 'New Ticket', 'citadel_doc' ),
		'edit_item'             => __( 'Edit Ticket', 'citadel_doc' ),
		'update_item'           => __( 'Update Ticket', 'citadel_doc' ),
		'view_item'             => __( 'View Ticket', 'citadel_doc' ),
		'view_items'            => __( 'View Tickets', 'citadel_doc' ),
		'search_items'          => __( 'Search Tickets', 'citadel_doc' ),
		'not_found'             => __( 'Not found', 'citadel_doc' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'citadel_doc' ),
		'featured_image'        => __( 'Featured Image', 'citadel_doc' ),
		'set_featured_image'    => __( 'Set featured image', 'citadel_doc' ),
		'remove_featured_image' => __( 'Remove featured image', 'citadel_doc' ),
		'use_featured_image'    => __( 'Use as featured image', 'citadel_doc' ),
		'insert_into_item'      => __( 'Insert into ticket', 'citadel_doc' ),
		'uploaded_to_this_item' => __( 'Uploaded to this ticket', 'citadel_doc' ),
		'items_list'            => __( 'Tickets list', 'citadel_doc' ),
		'items_list_navigation' => __( 'Tickets list navigation', 'citadel_doc' ),
		'filter_items_list'     => __( 'Filter tickets list', 'citadel_doc' ),
	);
	$args = array(
		'label'                 => __( 'Citadel Ticket', 'citadel_doc' ),
		'description'           => __( 'Citadel Ticket Description', 'citadel_doc' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'           	=> 'dashicons-tickets-alt',
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'post_type', $args );

}
add_action( 'init', 'custom_post_type', 0 );

