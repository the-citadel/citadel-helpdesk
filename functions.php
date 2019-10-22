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
	wp_enqueue_script( 'citadel-doc-navigation', get_template_directory_uri() . '/js/scripts.js', array(), $js_version, true );
	wp_enqueue_script( 'citadel-doc-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $js_version, true );
	wp_enqueue_script( 'citadel-doc-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $js_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'citadel_doc_scripts' );

function the_breadcrumb()
{
	$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter = '&raquo;'; // delimiter between crumbs
	$home = 'Home'; // text for the 'Home' link
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb
	global $post;
	$homeLink = get_bloginfo('url');
	if (is_home() || is_front_page()) {
		if ($showOnHome == 1) {
			echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
		}
	} else {
		echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
		if (is_category()) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				echo get_category_parents($thisCat->parent, true, ' ' . $delimiter . ' ');
			}
			echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
		} elseif (is_search()) {
			echo $before . 'Search results for "' . get_search_query() . '"' . $after;
		} elseif (is_day()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} elseif (is_month()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} elseif (is_year()) {
			echo $before . get_the_time('Y') . $after;
		} elseif (is_single() && !is_attachment()) {
			if (get_post_type() != 'post') {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
				if ($showCurrent == 1) {
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				}
			} else {
				$cat = get_the_category();
				$cat = $cat[0];
				$cats = get_category_parents($cat, true, ' ' . $delimiter . ' ');
				if ($showCurrent == 0) {
					$cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				}
				echo $cats;
				if ($showCurrent == 1) {
					echo $before . get_the_title() . $after;
				}
			}
		} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif (is_attachment()) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID);
			$cat = $cat[0];
			echo get_category_parents($cat, true, ' ' . $delimiter . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			if ($showCurrent == 1) {
				echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			}
		} elseif (is_page() && !$post->post_parent) {
			if ($showCurrent == 1) {
				echo $before . get_the_title() . $after;
			}
		} elseif (is_page() && $post->post_parent) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) {
					echo ' ' . $delimiter . ' ';
				}
			}
			if ($showCurrent == 1) {
				echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			}
		} elseif (is_tag()) {
			echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
		} elseif (is_author()) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . 'Articles posted by ' . $userdata->display_name . $after;
		} elseif (is_404()) {
			echo $before . 'Error 404' . $after;
		}
		if (get_query_var('paged')) {
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
				echo ' (';
			}
			echo __('Page') . ' ' . get_query_var('paged');
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
				echo ')';
			}
		}
		echo '</div>';
	}
} // end the_breadcrumb()

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
function custom_ticket_post_type() {

	$labels = array(
		'name'                  => _x( 'Citadel Tickets', 'Post Type General Name', 'citadel_doc' ),
		'singular_name'         => _x( 'Citadel Ticket', 'Post Type Singular Name', 'citadel_doc' ),
		'menu_name'             => __( 'Citadel Tickets', 'citadel_doc' ),
		'name_admin_bar'        => __( 'Citadel Tickets', 'citadel_doc' ),
		'archives'              => __( 'Ticket Archives', 'citadel_doc' ),
		'attributes'            => __( 'Ticket Attributes', 'citadel_doc' ),
		'parent_item_colon'     => __( 'Parent Ticket:', 'citadel_doc' ),
		'all_items'             => __( 'All Tickets', 'citadel_doc' ),
		'add_new_item'          => __( 'Add New Ticket', 'citadel_doc' ),
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
		'can_export'            => true,
		'capability_type'       => 'post',
		'description'           => __( 'Citadel Ticket Description', 'citadel_doc' ),
		'exclude_from_search'   => true,
		'has_archive'           => true,
		'hierarchical'          => false,
		'label'                 => __( 'Citadel Ticket', 'citadel_doc' ),
		'labels'                => $labels,
		'menu_icon'           	=> 'dashicons-tickets-alt',
		'menu_position'         => 20,
		'public'                => true,
		'publicly_queryable'    => true,
		'query_var' 			=> true,
		'rewrite' 				=> array('slug' => 'tickets','with_front' => false),
		'show_ui'               => true,
		'show_in_admin_bar'     => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_rest' 			=> true,
		'supports' 				=> array( 'title', 'editor', ),
	);
	register_post_type( 'citadel_ticket', $args );

}
add_action( 'init', 'custom_ticket_post_type', 0 );

function create_ticket_taxonomies() {
	register_taxonomy(
		'ticket_categories',
		'citadel_ticket',
		array(
			'label' => __( 'Status' ),
			'rewrite' => array( 'slug' => 'tickets/status' ),
			'hierarchical' => true,
			'show_in_rest' => true,
		)
	);

	register_taxonomy(
		'ticket_types',
		'citadel_ticket',
		array(
			'label' => __( 'Type' ),
			'rewrite' => array( 'slug' => 'tickets/type' ),
			'hierarchical' => true,
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'create_ticket_taxonomies' );

function _post_type_rewrite() {
	global $wp_rewrite;

	// Set the query arguments used by WordPress
	$queryarg = 'post_type=citadel_ticket&p=';

	// Concatenate %cpt_id% to $queryarg (eg.. &p=123)
	$wp_rewrite->add_rewrite_tag( '%cpt_id%', '([^/]+)', $queryarg );

	// Add the permalink structure
	$wp_rewrite->add_permastruct( 'citadel_ticket', '/ticket/%cpt_id%/', false );
}
add_action( 'init', '_post_type_rewrite' );

/**
  * Replace permalink segment with post ID
  *
  */
function _post_type_permalink( $post_link, $id = 0, $leavename ) {
	global $wp_rewrite;
	$post = get_post( $id );
	if ( is_wp_error( $post ) )
		return $post;

		// Get post permalink (should be something like /some-type/%cpt_id%/
		$newlink = $wp_rewrite->get_extra_permastruct( 'citadel_ticket' );

		// Replace %cpt_id% in permalink structure with actual post ID
		$newlink = str_replace( '%cpt_id%', $post->ID, $newlink );
		$newlink = home_url( user_trailingslashit( $newlink ) );
	return $newlink;
}
 add_filter('post_type_link', '_post_type_permalink', 1, 3);


 // Add user metabox
 function citadel_submitter_meta_box() {

	add_meta_box(
		'citadel_ticket_submitter',
		'Submitter Email',
		'citadel_ticket_submitter',
		'citadel_ticket',
		'side',
		'default',
		array(
			'__block_editor_compatible_meta_box' => true,
		)
	);

	add_meta_box(
		'citadel_ticket_submitter_name',
		'Submitter Name',
		'citadel_ticket_submitter_name',
		'citadel_ticket',
		'side',
		'default',
		array(
			'__block_editor_compatible_meta_box' => true,
		)
	);
}
add_action( 'add_meta_boxes', 'citadel_submitter_meta_box' );

function citadel_ticket_submitter($post) {
	$value = get_post_meta($post->ID, 'citadel_submitter_key', true);
	?>
	<label for="ticket_submitter">Ticket Submitter Email</label>
	<input type="text" name="ticket_submitter" value="<?php echo $value; ?>" class="widefat"/>
	<?php
}

function citadel_ticket_submitter_name($post) {
	$value = get_post_meta($post->ID, 'citadel_submitter_name_key', true);
	?>
	<label for="ticket_submitter_name">Ticket Submitter Name</label>
	<input type="text" name="ticket_submitter_name" value="<?php echo $value; ?>" class="widefat"/>
	<?php
}

function citadel_save_postdata($post_id) {
	if (array_key_exists('ticket_submitter', $_POST)) {
		update_post_meta(
			$post_id,
			'citadel_submitter_key',
			$_POST['ticket_submitter']
		);
	}

	if (array_key_exists('ticket_submitter_name', $_POST)) {
		update_post_meta(
			$post_id,
			'citadel_submitter_name_key',
			$_POST['ticket_submitter_name']
		);
	}
}
add_action('save_post', 'citadel_save_postdata');


// Submit Ticket
add_shortcode( 'citadel_ticket_submit', 'citadel_ticket_submit' );
function citadel_ticket_submit() {
	citadel_save_ticket_if_submitted();
	?>
<form method="post" id="submitTicket" name="submitTicket">
	<p class="form-info">* All fields are required</p>
	<p>
		<label for="submitter">Submitter Citadel Username *</label>
		<small>The first part of your default Citadel email.</small>
		<input type="text" name="submitter" id="submitter" required />
	</p>

	<p>
		<label for="submitter_name">Submitter Name *</label>
		<small>Your first and last name.</small>
		<input type="text" name="submitter_name" id="submitter_name" required />
	</p>

	<p>
		<label for="title">Ticket Subject *</label>
		<small>A short title for the request/issue.</small>
		<input type="text" name="title" id="title" required/>
	</p>

	<p>
		<label for="type">Ticket Type *</label>
		<small>Type of request/issue.</small>
		<select name="type" id="type" required>
			<option value="select" disabled>Select</option>
			<?php
				$args = array(
						   'taxonomy' 	=> 'ticket_types',
						   'orderby' 	=> 'name',
						   'order'   	=> 'ASC',
						   'hide_empty'	=> 0,
					   );

				$cats = get_categories($args);

				foreach($cats as $cat) {
					$category_link = get_category_link( $cat->cat_ID );
			?>

			<option value="<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></option>

			<?php } ?>
		</select>
	</p>

	<p>
		<label for="content">Description *</label>
		<small>A description of the request/issue.</small>
		<textarea type="text" name="content" id="content" required></textarea>
	</p>

	<?php wp_nonce_field('submit_ticket'); ?>

	<input type="text" id="website" name="website"/>

	<input type="hidden" name="status" id="status" value="Open" />

	<button type="submit" id="submit" name="submit">Submit Ticket</button>
</form>
<script type="text/javascript">
	if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	}
</script>
	<?php
}

function citadel_save_ticket_if_submitted() {
	// Stop running function if form wasn't submitted
	if ( !isset($_POST['title']) ) {
		return;
	}

	if(!empty($_POST['website'])) {
		return;
	}

	// Check that the nonce was set and valid
	if( !wp_verify_nonce($_POST['_wpnonce'], 'submit_ticket') ) {
		echo '<p style="text-align: center; color: #7D2935;"><strong>Did not save because your form seemed to be invalid. Sorry!</strong></p>';
		return;
	}

	// Do some minor form validation to make sure there is content
	if (strlen($_POST['title']) < 5) {
		echo 'Please enter a subject. Subjects must be at least five characters long.';
		return;
	}

	// Add the content of the form to $post as an array
	$post = array(
		'post_title'    => $_POST['title'],
		'post_content'  => $_POST['content'],
		'meta_input'	=> array(
							'citadel_submitter_key' => $_POST['submitter'] . '@citadel.edu',
							'citadel_submitter_name_key' => $_POST['submitter_name'],
						),
		'post_status'   => 'publish',
		'post_type' 	=> 'citadel_ticket',
	);
	$post_id = wp_insert_post( $post );
	wp_set_object_terms( $post_id, $_POST['status'], 'ticket_categories' );
	wp_set_object_terms( $post_id, $_POST['type'], 'ticket_types' );
	update_post_meta($post_id, 'citadel_submitter_key', $_POST['submitter'] . '@citadel.edu');
	update_post_meta($post_id, 'citadel_submitter_name_key', $_POST['submitter_name']);
	$ticket_link = get_post_type_archive_link( 'citadel_ticket' ) . '#' . $post_id;
	echo '<p style="text-align: center; color: green;"><strong><a href="' . $ticket_link . '">Ticket [#' . $post_id . ']</a> has been created!</strong></p>';
	//wp_redirect( $ticket_link );
}


add_filter( 'manage_citadel_ticket_posts_columns', 'citadel_filter_posts_columns' );
function citadel_filter_posts_columns( $columns ) {

	$columns = array(
		'cb' 		=> $columns['cb'],
		'id' 		=> __( 'ID' ),
		'title' 	=> __( 'Title' ),
		'status' 	=> __( 'Status' ),
		'type' 		=> __( 'Type' ),
		'submitter' => __( 'Submitter Email' ),
		'submitter_name' => __( 'Submitter Name' ),
		'date' 		=> __( 'Date' ),
	);
	return $columns;

}

add_action( 'manage_citadel_ticket_posts_custom_column', 'citadel_ticket_column', 10, 2);
function citadel_ticket_column( $column, $post_id ) {
	
	if ( 'id' === $column ) {
		echo $post_id;
	}

	if ( 'status' === $column ) {
		$status = get_the_terms( $post_id, 'ticket_categories' );

		if ( ! $status ) {
			_e( 'n/a' );  
		} else {
			echo $status[0]->name;
		}
	}

	if ( 'type' === $column ) {
		$type = get_the_terms( $post_id, 'ticket_types' );

		if ( ! $type ) {
			_e( 'n/a' );  
		} else {
			echo $type[0]->name;
		}
	}

	if ( 'submitter' === $column ) {
		$submitter = get_post_meta( $post_id, 'citadel_submitter_key', true );

		if ( ! $submitter ) {
			_e( 'n/a' );  
		} else {
			echo '<a href="mailto:' . $submitter . '?subject=Webmaster Ticket [#' . $post_id . ']: ' . get_the_title($post_id) . '&body=%0D%0A%0D%0A-----%0D%0A%0D%0A[#' . $post_id . ']: ' . get_the_title($post_id) . '%0D%0A%0D%0A' . wp_strip_all_tags( get_the_content($post_id) ) . '%0D%0A%0D%0A-----">' . $submitter . '</a>';
		}
	}

	if ( 'submitter_name' === $column ) {
		$submitter_name = get_post_meta( $post_id, 'citadel_submitter_name_key', true );

		if ( $submitter_name ) {
			echo $submitter_name;
		}
	}
}

add_filter( 'manage_edit-citadel_ticket_sortable_columns', 'citadel_ticket_sortable_columns');
function citadel_ticket_sortable_columns( $columns ) {
	$columns['id'] = 'ID';
	return $columns;
}

add_action( 'admin_menu', 'add_ticket_menu_bubble' );
function add_ticket_menu_bubble() {
	global $menu;

	$closed = get_term_by( 'slug', 'closed', 'ticket_categories' );
	$resolved = get_term_by( 'slug', 'resolved', 'ticket_categories' );
	$closedID = $closed->term_id;
	$resolvedID = $resolved->term_id;

	$exclude = [];

	array_push( $exclude, $resolvedID, $closedID );

	$args = array(
		'taxonomy' => 'ticket_categories',
		'hide_empty' => true,
		'exclude'    => $exclude,
	);

	$cats = get_categories($args);

	$open_count = array();

	foreach ($cats as $cat) {
		$open_count[] = $cat->count;
	}

	$open_count = array_sum($open_count);

	if ( $open_count ) {

		foreach ( $menu as $key => $value ) {

			if ( $menu[$key][2] == 'edit.php?post_type=citadel_ticket' ) {

				$menu[$key][0] .= ' (' . $open_count . ')';

				return;
			}
		}
	}
}

// Table pagination
function my_pagination_rewrite() {
	add_rewrite_rule('tickets/page/?([0-9]{1,})/?$', 'index.php?category_name=tickets&paged=$matches[1]', 'top');
	add_rewrite_rule( '^tickets/status/([^/]+)/page/([0-9]+)?$', 'index.php?post_type=citadel_ticket&ticket_categories=$matches[1]&paged=$matches[2]', 'top' );
	add_rewrite_rule( '^tickets/type/([^/]+)/page/([0-9]+)?$', 'index.php?post_type=citadel_ticket&ticket_types=$matches[1]&paged=$matches[2]', 'top' );
}
add_action('init', 'my_pagination_rewrite');

add_action( 'pre_get_posts', 'dw_handle_posts' );
function dw_handle_posts( $query ) {
    if( ! $query->is_main_query() || is_admin() )
        return;

    if ( $query->is_tax ){
        $post_type = get_query_var('post_type');
        if( ! $post_type ){
            global $wp_taxonomies;
            $taxo = get_queried_object();
            $post_type = ( isset( $wp_taxonomies[$taxo->taxonomy] ) ) ? $wp_taxonomies[$taxo->taxonomy]->object_type : array();
            $query->set('post_type', $post_type);
        }
    }

    return $query;
}


