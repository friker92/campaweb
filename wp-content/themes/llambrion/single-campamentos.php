<?php
get_header(); 
?>

<div class="fluid-container espacio-arriba-30">
	<div class="row">
		<div class="col-sm-8 col-xs-12">
			
			<div class="col-xs-11 col-xs-offset-1">
				<h1 class="page-title"><?php echo get_the_title(); ?></h1>
			</div>

			<div class="col-xs-10 col-xs-offset-2">
				 <?php $bg_date = DateTime::createFromFormat('Ymd', get_field('txt_date_begin')); ?>
				 <?php $fn_date = DateTime::createFromFormat('Ymd', get_field('txt_date_finish')); ?>
			  <p>Del <?php echo $bg_date->format('d-m-Y'); ?> al <?php echo $fn_date->format('d-m-Y'); ?></p>

			  <p>Para: <?php echo get_field('edades'); ?></p>

			  <p><b>Jefe: </b><a href="mailto:<?php echo get_field('email_jefe'); ?>"><?php echo get_field('jefe'); ?></a></p>
			  <p><b>Sacerdote: </b><?php echo get_field('sacerdote'); ?></p>
			  
			  <?php the_excerpt(); ?>

			  <p><b>Parroquias: </b></p>
			  <ul class="list-group">
			    <?php 
			    $parroquias = get_field('rel_parish'); 
			    
			    foreach ($parroquias as $parroquia) {
			    ?>
			      <li class="list-group-item"><h3><a href="<?php echo get_permalink( $parroquia->ID ); ?>"><?php echo $parroquia->post_title; ?> <small>(<?php echo $parroquia->txt_locality; ?>)</small></a></h3></li>
			    <?php
					}
			    ?>
			  </ul>
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
