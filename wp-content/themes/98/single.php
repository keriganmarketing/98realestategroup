<?php
/**
 * The template for displaying all single posts.
 * @package Ninetyeight Real Estate Group
 */

get_header(); 

$photo_id = get_post_thumbnail_id($post->ID);
$mast_url = wp_get_attachment_url( $photo_id );
if($mast_url!=''){
    $large_array = image_downsize( $photo_id, 'large' );
    $mast_url = $large_array[0];
}
 
?>

<div id="mid" class="site-content page">
	<div class="container">
        <div class="entry-content">
        <div class="row">

            <?php if($mast_url){ ?>
            <div class="featured-photo col-md-4">
                <img src="<?php echo $mast_url; ?>" class="img-fluid" alt="<?php echo $post->name; ?>" />
            </div> 
            <div class="article col-md-8" >
                
            <?php } else{ ?>
            <div class="article col-xs-12" >
            <?php } ?>

                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'template-parts/content', 'single' ); ?>

                    <?php endwhile; // End of the loop. ?>

                    </main><!-- #main -->
                </div><!-- #primary -->
            </div>
        </div>
        </div>
	</div>
</div>

<?php get_footer(); ?>

