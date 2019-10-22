<?php get_header(); ?>
<article id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<header class="entry-header">
		<h1 class="entry-title">Citadel Webmaster Tickets</h1>
	</header><!-- .entry-header -->
	<p class="submit-ticket-link"><a href="<?php echo site_url(); ?>/submit-ticket">Submit a Ticket</a></p>
	<div class="entry-content">
	<?php 
		echo the_content();

		if ( have_posts() ) {

			get_template_part( 'template-parts/tickets/content', 'ticket_table_sorting' );
	?>

		<table id="ticketTable">
			<thead>
				<tr>
					<th scope="col" class="number">ID</th>
					<th scope="col" class="date">Created</th>
					<?php if ( current_user_can( 'manage_options' ) ) : ?><th scope="col" class="subject">Subject</th><?php endif; ?>
					<th scope="col" class="type">Type</th>
					<th scope="col" class="status">Status</th>
					<?php if ( current_user_can( 'manage_options' ) ) : ?><th scope="col" class="submitter">Submitter</th><?php endif; ?>
				</tr>
			</thead>
			<tbody>

			<?php

				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/tickets/content', 'ticket_table' );

				endwhile;

			?>

			</tbody>
			<?php if ( current_user_can( 'manage_options' ) ) : ?>
			<tfoot>
				<tr class="edit-tickets">
					<th scope="row" class="number"></th>
					<td class="date"></td>
					<td class="subject"></td>
					<td class="type"></td>
					<td class="status"><button>Save</button></td>
					<td class="submitter"></td>
				</tr>
			</tfoot>
			<?php endif; ?>

		</table>

		<div class="pagination">
		<?php

			the_posts_pagination( array(
				'mid_size'	=> 2,
				'prev_text'	=> 'Prev',
				'next_text'	=> 'Next',
			) );

		?>
		</div>

	<?php } else { ?>

	<p style="text-align: center;">Sorry, there are no tickets to display.</p>

	<?php } ?>

	</div>

	</main>
</article>
<?php get_footer(); ?>