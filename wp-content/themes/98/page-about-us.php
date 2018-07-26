<?php

use Includes\Modules\Team\Team;

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

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            <?php
            while ( have_posts() ) : the_post();

                get_template_part( 'template-parts/content', 'page' );

            endwhile; // End of the loop.
            ?>
			<div class="container">
                <div class="row">
                    <?php 
                        
                        $team = new Team();
                                                
                        foreach($team->getTeam() as $agent){ ?>
                        
                        <div class="col-sm-6 col-lg-4 col-xl-3" >
                            <div class="agent-container">
                                <div class="agent-thumb text-xs-center">
                                <img src="<?php echo $agent['images']['thumbnail']; ?>" class="m-x-auto img-fluid">
                                </div>
                                <div class="agent-info text-xs-center">
                                    <h3 class="agent-name"><?php echo $agent['name']; ?></h3>
                                    <p class="title"><?php echo $agent['title']; ?></p>
                                    <div class="line"></div>
                                    <p class="email"><a href="mailto:<?php echo $agent['email']; ?>" ><?php echo $agent['email']; ?></a></p>
                                    <p class="phone clicktocall"><a href="tel:<?php echo $agent['cell_phone']; ?>" ><?php echo $agent['cell_phone']; ?></a></p>
                                    <a href="<?php echo $agent['link']; ?>" class="btn btn-primary agent-button" >more info</a>
                                </div>
                            </div>
                        </div>
                            
                    <?php } ?>
                </div> 
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();
