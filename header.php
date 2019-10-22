<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Citadel_Documentation
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'citadel-doc' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="wrapper">
			<div class="site-branding">
				<?php if ( is_front_page() || is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'citadel-doc' ); ?></button>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<div id="search" class="<?php if ( !is_front_page() && !is_home() ) { echo 'collapsed'; } ?> sticky">

		<div class="wrapper">
			
			<?php if ( !is_front_page() && !is_home() ) : ?>

			<?php if (function_exists('the_breadcrumb')) the_breadcrumb(); ?>

			<?php endif; ?>

			<div class="main-search">
				<?php if ( is_front_page() || is_home() ) : ?>
				<!-- <h2>What can we help with?</h2> -->
				<?php endif; ?>
				<?php echo get_search_form(); ?>
			</div>

		</div>

	</div>

	<div id="content" class="site-content">
		<div class="wrapper">
