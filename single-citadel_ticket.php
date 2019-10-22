<?php get_header(); ?>
 
	<article id="primary" class="content-area">
		<main id="main" class="site-main ticket" role="main">
 		<?php if ( current_user_can( 'manage_options' ) ) : ?>
 			
			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				$statuses = get_the_terms( get_the_ID(), 'ticket_categories' );
				$types = get_the_terms( get_the_ID(), 'ticket_types' );
			?>
			<p class="all-tickets"><a href="<?php echo get_post_type_archive_link( 'citadel_ticket' ); ?>"><i class="fas fa-angle-left"></i> All Tickets</a></p>
			<p class="ticket-id">Ticket #<?php echo the_ID(); ?></p>
			<h1 class="entry-title"><?php echo the_title(); ?></h1>

			<aside class="ticket-details">
				<table>
					<tr>
						<th scope="row">Submitter</th>
						<td><?php echo get_post_meta( get_the_ID(), 'citadel_submitter_name_key', true ); ?></td>
					</tr>
					<tr>
						<th scope="row">Submitter Email</th>
						<td>
							<a href="mailto:<?php echo get_post_meta( get_the_ID(), 'citadel_submitter_key', true ); ?>?subject=Webmaster Ticket [#<?php echo the_ID(); ?>]: <?php echo the_title(); ?>&body=-----%0D%0A%0D%0A[#<?php echo the_ID(); ?>]: <?php echo the_title(); ?>%0D%0A%0D%0A<?php echo wp_strip_all_tags( get_the_content() ); ?>%0D%0A-----"><?php echo get_post_meta( get_the_ID(), 'citadel_submitter_key', true ); ?></a>
						</td>
					</tr>
					<tr>
						<th scope="row">Submitted</th>
						<td><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></td>
					</tr>
					<tr>
						<th scope="row">Status</th>
						<td class="<?php echo $statuses[0]->slug; ?>"><?php echo $statuses[0]->name; ?></td>
					</tr>
					<tr>
						<th scope="row">Type</th>
						<td class="<?php echo $types[0]->slug; ?>"><?php echo $types[0]->name; ?></td>
					</tr>
					<tr>
						<th scope="row">Created</th>
						<td><span class="nowrap"><?php echo get_the_date('m/d/Y', $post_id); ?></span> at <span class="nowrap"><?php echo get_the_date('g:i a', $post_id); ?></span></td>
					</tr>

					<?php if ( get_the_modified_date() != get_the_date() ) : ?>
					<tr>
						<th scope="row">Last Modified</th>
						<td><span class="nowrap"><?php echo the_modified_date('m/d/Y'); ?></span> at <span class="nowrap"><?php echo the_modified_date('g:i a'); ?></span></td>
					</tr>
					<?php endif; ?>

				</table>
			</aside>

			<div class="entry-content ticket"><?php echo the_content(); ?></div>


			<?php
				$submitter = get_post_meta( get_the_ID(), 'citadel_submitter_key', true );
				$currentID = get_the_ID();
				$args = array(
				    'posts_per_page'    => -1,
				    'post_type'         => 'citadel_ticket',
				    'orderby' 			=> 'date',
					'order' 			=> 'DESC',
				    'post_status'       => 'publish',
				    'meta_key' 			=> 'citadel_submitter_key',
				    'meta_value' 		=> $submitter,
				    'post__not_in'		=> array($currentID),
				);
				$the_query = new WP_Query( $args );

				if ($the_query->found_posts > 0) :
			?>

			<div class="submitter-count">
				<h4>[<?php echo $the_query->found_posts; ?>] other ticket<?php if ($the_query->found_posts != 1) : ?>s<?php endif; ?> from <?php echo get_post_meta( get_the_ID(), 'citadel_submitter_key', true ); ?></h4>
				<?php if ( $the_query->have_posts() ) : ?>
				<div class="table-container">
					<table id="ticketTable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Submitted</th>
								<th>Subject</th>
								<th>Status</th>
								<th>Type</th>
							</tr>
						</thead>
						<tbody>

						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
							<?php
								$post_id = get_the_ID();
								$categories = get_the_terms( get_the_ID(), 'ticket_categories' );
								$cat_name = $categories[0]->name;
								$cat_slug = $categories[0]->slug;
								$user = wp_get_current_user();
								$types = get_the_terms( get_the_ID(), 'ticket_types' );
							?>
							<tr class="<?php echo $cat_slug; ?>">
								<td class="number" id="<?php echo get_the_ID(); ?>">#<?php echo get_the_ID(); ?></td>
								<td><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></td>
								<td class="subject"><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></td>
								<td class="status"><?php echo $cat_name; ?></td>
								<td class="<?php echo $types[0]->slug; ?>"><?php echo $types[0]->name; ?></td>
							</tr>
						<?php endwhile; ?>

						</tbody>
					</table>
				</div>
				<?php else: ?>

				<p style="text-align: center;">Sorry, there are no tickets to display.</p>

				<?php endif; ?>
			</div>

			<?php endif; ?>

			<?php wp_reset_query(); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<h1 style="text-align: center;">You do not have persmission to view individual tickets!</h1>
			<p style="text-align: center;">If you are an administrator please <a href="<?php echo site_url() ?>/admin">log in.</p>

		<?php endif; ?>
 
		</main><!-- .site-main -->
	</article><!-- .content-area -->
 
<?php get_footer(); ?>