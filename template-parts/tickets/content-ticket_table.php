
<?php
	$post_id = get_the_ID();
	$categories = get_the_terms( $post_id, 'ticket_categories' );
	$types = get_the_terms( $post_id, 'ticket_types' );
?>
<tr class="<?php if ( $categories !== false ) { echo $categories[0]->slug; } ?>" id="<?php echo $post_id; ?>">

	<th scope="row" class="number">#<?php echo str_pad( get_the_ID(), 4, '0', STR_PAD_LEFT ); ?></th>

	<td class="date"><span class="nowrap"><?php echo get_the_date('m/d/Y', $post_id); ?></span> at <span class="nowrap"><?php echo get_the_date('g:i a', $post_id); ?></span></td>

	<?php if ( current_user_can( 'manage_options' ) ) : ?>

	<td class="subject">

		<a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a>

	</td>

	<?php endif; ?>

	<td class="<?php if ( $types !== false ) { echo $types[0]->slug; } ?> type"><?php if ( $types !== false ) { echo $types[0]->name; } ?></td>

	<td class="status">

		<?php if ( current_user_can( 'manage_options' ) ) : ?>

			<select>

			<?php

				$args = array(
						   'taxonomy' 	=> 'ticket_categories',
						   'orderby' 	=> 'name',
						   'order'   	=> 'ASC',
						   'hide_empty' => false,
					   );

				$cats = get_categories($args);

				foreach($cats as $cat) {

					$category_slug = $cat->slug;
					
					if ($category_slug == $categories[0]->slug) :

			?>

				<option value="<?php echo $categories[0]->slug; ?>" selected class="original"><?php echo $cat->name; ?> *</option>

					<?php else : ?>

				<option value="<?php echo $categories[0]->slug; ?>"><?php echo $cat->name; ?></option>

			<?php endif; ?>

			<?php } ?>

			</select>

		<?php else : ?>

			<?php if ( $categories !== false ) { echo $categories[0]->name; } ?>

		<?php endif; ?>

	</td>

	<?php if ( current_user_can( 'manage_options' ) ) : ?>

	<td class="submitter">

		<a href="mailto:<?php echo get_post_meta( get_the_ID(), 'citadel_submitter_key', true ); ?>?subject=Webmaster Ticket [#<?php echo the_ID(); ?>]: <?php echo the_title(); ?>&body=%0D%0A%0D%0A-----%0D%0A%0D%0A[#<?php echo the_ID(); ?>]: <?php echo the_title(); ?>%0D%0A%0D%0A<?php echo wp_strip_all_tags( get_the_content() ); ?>%0D%0A%0D%0A-----" title="<?php echo get_post_meta( get_the_ID(), 'citadel_submitter_name_key', true ); ?>"><?php echo get_post_meta( get_the_ID(), 'citadel_submitter_key', true ); ?></a>

	</td>

	<?php endif; ?>

</tr>