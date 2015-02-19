<?php
/**
 * Single Template
 *
 */

get_header(); 
the_post();
?>

<div class="fluid-container espacio-arriba-20">
	<div class="row">
		<div class="col-sm-8 col-xs-12">

			<div class="col-xs-12 espacio-arriba-30">
				
				<h1 class="panel-title page-title">
					<?php echo get_the_title(); ?>
				</h1>

				<p><?php echo get_the_content(); ?></p>

			</div>

		</div>

		<div class="col-sm-4 col-xs-12 sidebar">
	  <?php 
				get_template_part('modules/eventos');
			?>

		</div>

	</div>
</div>


<?php get_footer(); ?>
