<?php
get_header(); 
?>

<div class="fluid-container espacio-arriba-30">
	<div class="row">
		<div class="col-sm-8 col-xs-12">
			
			<div class="col-xs-12">
				<h1 class="page-title"><?php echo get_the_title(); ?></h1>
			</div>

			<div class="col-xs-12 espacio-arriba-30">
				<?php 
					$query=new WP_Query( array ( 'post_type' => 'post', 'order' => 'ASC', 'posts_per_page' => $numero_posts ) );
					while ( $query->have_posts() ){
						$query->the_post();
						?>
							<div class="col-xs-12 panel panel-color panel-no-shadow module-no-color module-no-border module-no-padding-but-xs last-post-list">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
										<?php if( function_exists('josebar_post_view_count_get') ){ ?>
											<span class = "badge badge-count-post" title = "Lecturas del post"><?php echo josebar_post_view_count_get(); ?></span>
										<?php } ?>
									</h3>
								</div>
								<div class="panel-body fondo-blanco">
									<div class="row">
										<div class="col-sm-8">
											<?php the_excerpt(); ?>
											<a href="<?php echo get_permalink(); ?>">
												<button class="btn btn-color">Seguir leyendo</button>
											</a>
										</div>
										<div class="col-sm-4">
											<?php if( has_post_thumbnail() ){ ?>
												<?php $laImagen = get_acf_image_object( get_post_thumbnail_id() ); ?>
												<img src="<?php echo $laImagen['url'] ?>" title = "<?php echo $laImagen['title'] ?>" alt="<?php $laImagen['alt'] ?>">
											<?php } ?>
										</div>
									</div>
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
				if( have_rows('flx_sidebar') ){
					get_modules('flx_sidebar');
				}
			?>

		</div>

	</div>
</div>



<?php get_footer(); ?>
