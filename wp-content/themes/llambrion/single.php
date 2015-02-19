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
			<div class="col-xs-8">
				<h1 class="page-title">
					<?php echo get_the_title(); ?>
				</h1>
			</div>
			<div class="col-xs-3 pull-rigth">
				<h1 class="pull-rigth">
					<small>Publicado: <?php echo get_the_date(); ?></small>
				</h1>
			</div>

			<div class="col-xs-12">
				<div class="col-xs-12 panel-info">
					<div class="panel-body fondo-blanco">
						<div class="row">
							<div class="col-sm-12">
								<?php the_content(); ?>
							</div>
						</div>
					
					</div>
				</div>
				<br/>
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
