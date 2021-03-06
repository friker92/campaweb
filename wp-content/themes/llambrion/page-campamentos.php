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
					$query=new WP_Query( array ( 'post_type' => 'campamentos', 'order' => 'DESC', 'posts_per_page' => '-1' ) );
					while ( $query->have_posts() ){
						$query->the_post();
						?>
							<div class="col-xs-12 panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">
									  <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
									  <?php $bg_date = DateTime::createFromFormat('Ymd', get_field('txt_date_begin')); ?>
									  <?php $fn_date = DateTime::createFromFormat('Ymd', get_field('txt_date_finish')); ?>
									  <small> Del <?php echo $bg_date->format('d-m-Y'); ?> al <?php echo $fn_date->format('d-m-Y'); ?></small>
									</h3>
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
