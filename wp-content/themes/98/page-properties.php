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
$_SESSION['view'] = 'gallery';
get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post(); 
            
            get_template_part( 'template-parts/content', 'page' );
            
            endwhile; // End of the loop. ?>

                <div class="container">
                    <search-bar :search-terms='<?php echo json_encode($_POST); ?>'></search-bar>
                </div>
                <div class="properties grid pb-4">
                    <div class="container-wide mx-auto">

                    </div>
                </div>
			
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer();
