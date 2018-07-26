<?php
/**
 * Template part for displaying posts.
 * @package Ninetyeight Real Estate Group
 */

?>
<div class="blog-post">
<div class="row">
<?php 
$photo_id = get_post_thumbnail_id($post->ID);
$mast_url = wp_get_attachment_url( $photo_id );
if($mast_url!=''){
    $large_array = image_downsize( $photo_id, 'large' ); 
    $mast_url = $large_array[0];
}

if($mast_url){ ?>
<div class="featured-photo col-md-4">
	<img src="<?php echo $mast_url; ?>" class="img-fluid" alt="<?php echo $post->name; ?>" />
</div>
<div class="article col-md-8" >

<?php } else{ ?>
<div class="article col-xs-12" >
<?php } ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
            <?php if ( 'post' == get_post_type() ) : ?>
            <div class="entry-meta">
                <?php ninetyeight_posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->
        <div class="entry">
            <?php the_excerpt(); ?>
            <p class="readmore"><a class="btn btn-info btn-lg" href="<?php echo get_permalink(); ?>" >Read more</a></p>
        </div><!-- .entry-content -->
    
    </article><!-- #post-## -->
</div>
</div>
</div>