<p class="ticket-stats">
<?php 
	$term = get_queried_object();
	$current_cat = $term->slug;
?>

<?php if ( current_user_can( 'manage_options' ) ) : ?>
	<strong>Status: </strong>
<?php endif; ?>

<?php
	$args = array(
		'post_type' => 'citadel_ticket',
		'post_staus'=> 'publish',
		'posts_per_page' => -1
	);

	$query = new WP_Query($args);
?>
	<?php if ( (is_post_type_archive('citadel_ticket')) && !(is_tax()) ) : ?>
	<span><strong>All (<?php echo $query->found_posts; ?>)</strong></span>
	<?php else : ?>
	<span><a href="<?php echo get_post_type_archive_link( 'citadel_ticket' ); ?>">All (<?php echo $query->found_posts; ?>)</a></span>
	<?php endif; ?>
<?php wp_reset_query(); ?>

<?php
	$args = array(
	           'taxonomy' => 'ticket_categories',
	           'orderby' => 'name',
	           'order'   => 'ASC'
	       );

	$cats = get_categories($args);

	foreach($cats as $cat) {
		$category_link = get_category_link( $cat->cat_ID );
		$category_slug = $cat->slug;
?>

	<span>
		<?php if ($category_slug == $current_cat) : ?>
			<strong><?php echo $cat->name; ?> (<?php echo $cat->count; ?>)</strong>
		<?php else : ?>
			<a href="<?php echo $category_link; ?>"><?php echo $cat->name; ?> (<?php echo $cat->count; ?>)</a>
		<?php endif; ?>
	</span>

<?php } ?>
</p>

<?php if ( current_user_can( 'manage_options' ) ) : ?>
<p class="ticket-stats">
<?php 
	$term = get_queried_object();
	$current_cat = $term->name;
?>

<?php if ( current_user_can( 'manage_options' ) ) : ?>
	<strong>Type: </strong>
<?php endif; ?>

<?php
	$args = array(
		'post_type' => 'citadel_ticket',
		'post_staus'=> 'publish',
		'posts_per_page' => -1
	);

	$query = new WP_Query($args);
?>
	<?php if ( (is_post_type_archive('citadel_ticket')) && !(is_tax()) ) : ?>
	<span><strong>All (<?php echo $query->found_posts; ?>)</strong></span>
	<?php else : ?>
	<span><a href="<?php echo get_post_type_archive_link( 'citadel_ticket' ); ?>">All (<?php echo $query->found_posts; ?>)</a></span>
	<?php endif; ?>
<?php wp_reset_query(); ?>

<?php
	$args = array(
	           'taxonomy' => 'ticket_types',
	           'orderby' => 'name',
	           'order'   => 'ASC'
	       );

	$cats = get_categories($args);

	foreach($cats as $cat) {
		$category_link = get_category_link( $cat->cat_ID );
		$category_slug = $cat->slug;
?>

	<span>
		<?php if ($category_slug == $current_cat) : ?>
			<strong><?php echo $cat->name; ?> (<?php echo $cat->count; ?>)</strong>
		<?php else : ?>
			<a href="<?php echo $category_link; ?>"><?php echo $cat->name; ?> (<?php echo $cat->count; ?>)</a>
		<?php endif; ?>
	</span>

<?php } ?>
</p>
<?php endif; ?>