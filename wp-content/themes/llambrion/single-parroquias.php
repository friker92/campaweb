<?php
get_header(); 
?>

<div class="fluid-container espacio-arriba-30">
	<div class="row">
		<div class="col-sm-8 col-xs-12">
			
			<div class="col-xs-12">
				<h1 class="page-title"><?php echo get_the_title(); ?></h1>
			</div>

			<div class="col-xs-12">
				<p>Página de parroquia</p>
				<p><?php echo get_field('txt_priest'); ?></p>
				<p><?php echo get_field('txt_locality'); ?></p>
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
