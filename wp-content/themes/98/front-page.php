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

get_header(); ?>
    <div id="mast">
        <div class="fluid-container">
            <div class="row">
                <div class="new-listings huge-button col-sm-6"
                     style="background-image: url('<?php echo get_template_directory_uri() . '/img/for-sale.jpg'; ?>');">
                    <a href="/properties/" class="huge-button-link"><h2>All MLS Listings</h2>
                        <p class="btn-intro">View the latest properties</p>
                        <div class="line"></div>
                        <p class="view">View</p></a>
                </div>

                <div class="waterfront huge-button col-sm-6"
                     style="background-image: url('<?php echo get_template_directory_uri() . '/img/waterfront.jpg'; ?>');">
                    <a href="/properties/sellers-guide/" class="huge-button-link"><h2>Home Value</h2>
                        <p class="btn-intro">What's my property worth?</p>
                        <div class="line"></div>
                        <p class="view">View</p></a>
                </div>
                <div class="company-listings huge-button col-sm-6 col-md-4"
                     style="background-image: url('<?php echo get_template_directory_uri() . '/img/interior.jpg'; ?>');">
                    <a href="/properties/our-listings/" class="huge-button-link"><h2>98 Living</h2>
                        <p class="btn-intro">View our properties</p>
                        <div class="line"></div>
                        <p class="view">View</p></a>
                </div>
                <div class="map-search huge-button col-sm-6 col-md-4"
                     style="background-image: url('<?php echo get_template_directory_uri() . '/img/mb-aerial.jpg'; ?>');">
                    <a href="/properties/map-search/" class="huge-button-link"><h2>Map Search</h2>
                        <p class="btn-intro">Explore neighborhoods</p>
                        <div class="line"></div>
                        <p class="view">View</p></a>
                </div>
                <div class="just-sold huge-button col-sm-12 col-md-4"
                     style="background-image: url('<?php echo get_template_directory_uri() . '/img/just-sold.jpg'; ?>');">
                    <a href="/properties/whats-selling/" class="huge-button-link"><h2>Just Sold</h2>
                        <p class="btn-intro">See what's selling</p>
                        <div class="line"></div>
                        <p class="view">View</p></a>
                </div>
            </div>
        </div>
    </div>
    <div id="featured-properties">

        <?php include(locate_template('template-parts/partials/featured-properties.php')); ?>

    </div>

    <div id="mid">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" >

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="container-wide">
                            <div class="row">
                                <div class="col-md-7 col-lg-6" style="padding: 1rem 5rem 0;" >
                                    <div class="entry-content">
                                        <?php the_content(); ?>
                                    </div><!-- .entry-content -->
                                </div>
                            </div>
                        </div>
                    </article><!-- #post-## -->

                <?php endwhile; // End of the loop. ?>

            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
    <div id="building">
        <div class="building-photo"><img src="<?php echo get_template_directory_uri() . '/img/building.png'; ?>" alt="98 Real Estate Group, Mexico Beach" /></div>
    </div>

    <div id="news-contact">
        <div class="container">
            <div class="col-sm-6">
                <h2>Market News</h2>
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'offset' => 0,
                    'post_status' => 'publish',
                );

                $blog = query_posts($args);
                //foreach ( $blog as $article ){
                while (have_posts()) : the_post();

                    $id = $post->ID;
                    $title = get_the_title($id);
                    $dateposted = date('M j, Y', get_the_time('U', $id));
                    $content = apply_filters('the_content', get_post_field('post_content', $id));
                    $link = get_permalink($id);

                    echo '<h3><a href="' . $link . '" class="news-title">' . $title . '</a></h3>';
                    echo ninetyeight_posted_on();

                endwhile;
                ?>
                <a href="<?php echo get_home_url(); ?>" class="btn btn-info">MORE NEWS</a>
            </div>
            <div class="col-sm-6">
                <h2>Quick Contact</h2>
                <?php include(locate_template('template-parts/forms/quick-contact.php')); ?>
            </div>
        </div>
    </div>
<?php get_footer();
