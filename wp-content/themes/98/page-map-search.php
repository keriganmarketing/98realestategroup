<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ninetyeight Real Estate Group
 */
$_SESSION['view'] = 'map';
get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            
			<?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12" >
                                <div class="map-key col-md-4 pull-md-right"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/residential-label.png" alt="Residential"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/land-label.png" alt="Lots/Land"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/commercial-label.png" alt="Commercial"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/contingent-label.png" alt="Contingent/Pending"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/sold-label.png" alt="Sold"></div>
                                <div class="entry-content full-width">
                                    <?php the_content(); ?>
                                </div><!-- .entry-content -->
                            </div>
                        </div>
                    </div>
                </article><!-- #post-## -->

            <?php endwhile; // End of the loop. ?>
			
			<div class="container-fluid">
				<div class="row">
					<?php //getTemplateFile('search-criteria'); ?>
				</div>
				<div class="row">
					<?php //getTemplateFile('map-search'); ?>
				</div>	
                <div class="row">
                    <div class="col-xs-12">
                    <?php include(locate_template('template-parts/partials/disclaimer.php')); ?>
                    </div>
                </div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();