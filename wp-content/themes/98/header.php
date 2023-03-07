<?php
/**
 * @package Ninetyeight Real Estate Group
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

<style>
	.front-content {
		padding: 1rem 1.5rem 0;
	}

	@media screen and (min-width:768px) {
		.front-content {
			padding: 1rem 5rem 0 3rem;
		}
	}

	@media screen and (min-width:1024px) {
		.front-content {
			padding: 1rem 5rem 0;
		}
	}
</style>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site <?php echo (!is_front_page() ? 'support' : 'front-page'); ?>" :class="{ 'full': footerStuck }" >
	<a style="display:none;" class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ninetyeight' ); ?></a>
    <div id="top">
        <header id="masthead" class="site-header">
			<div class="top-phone mobile" ><a href="tel:850-648-2200">(850) 648-2200</a></div>
			<div class="navbar-static-top navbar-transparent">
				<div class="container no-gutter">
					
					<div class="top-phone desktop" ><a href="tel:850-648-2200">(850) 648-2200</a></div>

					<button class="navbar-toggler hidden-lg-up pull-xs-right" type="button" data-toggle="collapse" data-target="#navbar-header">
						<span class="icon-box">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</span>
						MENU
					</button>

					<div class="navbar-collapse collapse navbar-toggleable-lg" id="navbar-header">
						<?php wp_nav_menu( array( 
	 						'theme_location' => 'primary', 
	 						'menu_id' => 'primary-menu',
	 						'menu_class' => 'menu',
	 						'container' => 'nav',
	 						'container_class' => 'navbar',
	 						'echo' => 'true',
	 						'depth' => 0,
	 						'items_wrap' => '<ul id="%1$s" class="nav navbar-nav navbar-right">%3$s</ul>',
 						) ); ?>
					</div>
					
					<a href="/" class="navbar-brand">
						<img src="/wp-content/themes/98/img/logo.svg" alt="98 Real Estate Group, Mexico Beach Florida" class="img-fluid" style="width:222px;"  >
					</a>

					

				</div>
			</div>
		</header>
		<div id="searchbar">
			<?php if(!is_page(9) && !is_page(43)){ ?>
				<quick-search></quick-search>
			<?php } ?>
		</div>
	</div>

