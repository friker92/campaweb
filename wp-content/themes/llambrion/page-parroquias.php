<?php
get_header(); 
?>

<div class="fluid-container espacio-arriba-30">
	<div class="row">
		<div class="col-sm-8 col-xs-12">
			
			<div class="col-xs-12">
			  <h1 class="page-title"><?php echo get_the_title(); ?></h1><br/>
			</div>

			<div class="col-xs-12">
				<?php 
					$query=new WP_Query( array ( 'post_type' => 'parroquias', 'order' => 'DESC', 'posts_per_page' => '-1' ) );
					while ( $query->have_posts() ){
						$query->the_post();
						?>
							<div class="col-xs-12 panel-info">
								<div class="panel-heading">
									<a href="<?php echo get_permalink(); ?>"><h3 class="panel-title">
									  <?php echo get_the_title(); ?> <small>(<?php echo get_field('txt_locality'); ?>)</small>
									</h3></a>
								</div>

							</div>
						<?php
					}
					wp_reset_query();
				?>

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
