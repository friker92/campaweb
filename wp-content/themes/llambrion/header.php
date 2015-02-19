<!DOCTYPE html>
<html lang="es" >
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Jose Antonio de la Barrera Mayoral">
        <link rel="icon" href="">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
		<?php wp_head(); ?>

		

	</head>

	<body <?php body_class(); ?> >
	<div id="main-wrapper" class="wrapper">
		
		<header id="header">
			<div class="row">
				<div class="col-xs-12">
					<img id="header-featured-img" src="<?php echo get_template_directory_uri(); ?>/img/encabezado.jpg">
				</div>
			</div>
			<div id="header-wrapper" class="wrapper">

				<div class="navbar-header navbar-inverse">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navigation-menu">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <div id="open-menu" class="visible-xs" data-toggle="collapse" data-target=".navigation-menu">
						<span>Menú</span>
					</div>
	            </div>

				<nav id="navigation" class="site-navigation primary-navigation" role="navigation">
					<?php 
						$defaults=array(
							'theme_location'	=> 'menu',
							'menu'				=> 'menu',
							'container'			=> 'div',
							'container_class'	=> 'collapse navbar-inverse navbar-collapse navigation-menu',
							'container_id'		=> '',
							'menu_class'		=> 'nav navbar-nav',
							'menu_id'			=> '',
							'echo'				=> true,
							'before'			=> '',
							'after'				=> '',
							'link_before'		=> '',
							'link_after'		=> '',
							'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'				=> 2,
							'fallback_cb'		=> 'wp_page_menu',
							'walker'			=> new wp_bootstrap_navwalker()
						);

						wp_nav_menu( $defaults );

	          		?>
				</nav>
			</div>

		</header>

