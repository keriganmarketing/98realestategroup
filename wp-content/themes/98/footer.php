<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ninetyeight Real Estate Group
 */

?>
	<div id="bot">
		<div class="container">
			<div class="row no-gutter">
			<div class="col-md-6 col-lg-3">
				<div class="footer-widget-container">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="footer-widget-container">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="footer-widget-container">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="footer-widget-container">
					<?php dynamic_sidebar( 'footer-4' ); ?>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div id="bot-bot">
		<div class="container no-gutter">
			<div class="row">
				<div class="col-xs-12 col-sm-4">
					<div class="social">
					<?php
						//print_r(getSocialLinks());
						$socialLinks = getSocialLinks();
						foreach($socialLinks as $socialId => $socialLink){
							echo '<a class="'.$socialId.'" href="'.$socialLink.'" target="_blank" ></a>';
						}
					?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4">
					<div class="site-info text-xs-center">
						<p class="copyright">&copy;<?php echo date('Y'); ?> 98 Real Estate Group. All Rights Reserved.</p>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4">
					<div class="site-info text-xs-center">
						<p class="siteby pull-sm-right" style="display: none;"><svg version="1.1" id="kma" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12.5 8.7" style="enable-background:new 0 0 12.5 8.7;" xml:space="preserve">
						<path class="st0" d="M6.4,0.1c0,0,0.1,0.3,0.2,0.9c1,3,3,5.6,5.7,7.2l-0.1,0.5c0,0-0.4-0.2-1-0.4C7.7,7,3.7,7,0.2,8.5L0.1,8.1
							c2.8-1.5,4.8-4.2,5.7-7.2C6,0.4,6.1,0.1,6.1,0.1H6.4L6.4,0.1z"/>
						</svg> Site by <a href="https://keriganmarketing.com">KMA</a>.</p>
					</div><!-- .site-info -->
				</div>
			</div>
		</div>
	</div>
	<portal-target name="modal"></portal-target>
</div>
<?php wp_footer(); ?>

</body>
</html>
