<?php
	$today = date('Ymd');
//	echo $today;
	$query=new WP_Query( array ( 
		'post_type' => 'eventos', 
		'order' => 'DESC', 
		
            'meta_query' => array(
				array(
					'key'     => 'end_date',
					'value'   => $today,
					'compare' => '>=',
				),
			),
        
	) );
?> <h3>Próximos eventos:</h3><?php 
	while ( $query->have_posts() ){
		$query->the_post();
		?>
			<div class="col-xs-12 panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">
					  <?php $bg_date = DateTime::createFromFormat('Ymd', get_field('begin_date')); ?>
					  <small><?php echo $bg_date->format('d-m-Y'); ?></small>
					  <?php $url = get_field('url');
					  	if ($url=="") $url = get_permalink();?>
					  <a href="<?php echo $url ?>"><?php echo get_the_title(); ?></a>
					</h3>
				</div>
			</div>
		<?php
	}
	wp_reset_query();
?>
