<?php

use Includes\Modules\MLS\AgentListings;
use Includes\Modules\Team\Team;
/**
 * The template for displaying a realtor
 * @package Ninetyeight Real Estate Group
 */

$team          = new Team();
$agent         = $team->getSingle($post->post_title);

// echo '<pre>',print_r($agent),'</pre>';

$agentListings = new AgentListings($post->contact_info_mls_id);
$listings      = $agentListings->getListings();
$solds         = $agentListings->getSoldListings();

// echo '<pre>',print_r($listings),'</pre>';

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">
				<div class="row">
                    <div class="col-sm-12" >
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <div class="entry-content agent">
                                <div class="row">
                                    
                                    <div class="col-md-8">
                                        <div class="agent-info full text-xs-center text-md-left">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <h1 class="agent-name"><?php echo $post->contact_info_name; ?></h1>
                                                    <p class="title"><?php echo $post->contact_info_title; ?></p>
                                                </div>
                                                <div class="col-md-5">
                                                    <?php if($solds){ ?>
                                                        <p class="text-xs-center pull-md-right agent-button"><a href="#sold" class="btn btn-info" >Properties I've Sold</a></p>
                                                    <?php } ?>
                                                    <?php if($listings){ ?>
                                                        <p class="text-xs-center pull-md-right agent-button"><a href="#mylistings" class="btn btn-info" >My Listings</a></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="line"></div>
                                            
                                            <div id="bio">
                                                <?php echo $post->post_content; ?>
                                            </div>
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" >
                                        <div class="agent-medium text-xs-center">
                                            <img src="<?php echo $post->contact_info_photo; ?>" style="width:200px;" class="m-x-auto img-fluid">
                                        </div>
                                        <div class="agent-info photo text-xs-center"> 
                                            <div class="line"></div>
                                            <p class="email"><span class="datalabel">Email:</span> <a href="mailto:<?php echo $post->contact_info_email; ?>" ><?php echo $post->contact_info_email; ?></a></p>
                                            <?php if($post->contact_info_cell_phone != '') { ?>
                                            <p class="phone clicktocall"><span class="datalabel">Cell:</span> <a href="tel:<?php echo $post->contact_info_cell_phone; ?>" ><?php echo $post->contact_info_cell_phone; ?></a></p>
                                            <?php } ?>
                                            <p class="phone clicktocall"><span class="datalabel">Office:</span> <a href="tel:<?php echo $post->contact_info_office_phone; ?>" ><?php echo $post->contact_info_office_phone; ?></a></p>
                                            <?php if($post->contact_info_website!=''){ ?>
                                            <p class="website url"><span class="datalabel">Website:</span> <a href="//<?php echo $post->contact_info_website; ?>" target="_blank" ><?php echo $post->contact_info_website; ?></a></p>
                                            <?php } ?>
                                            <?php if($post->contact_info_blog!=''){ ?>
                                            <p class="website url"><span class="datalabel">Blog:</span> <a href="//<?php echo $post->contact_info_blog; ?>" target="_blank" ><?php echo $post->contact_info_blog; ?></a></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </article>
                    <?php endwhile; // End of the loop. ?>  
                    </div>
                </div>
            </div>

            <div class="container-wide">
                <?php if($listings){ ?>
                <a id="mylistings" class="pad-anchor"></a>
                <h2 class="text-center">My Listings</h2>
                <hr>
                <div class="row justify-content-center">
                    <?php foreach($listings as $listing){ ?>
                        <div class="feat-prop col-md-6 col-xl-3 text-center">
                            <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php if($solds){ ?>
                <a id="sold" class="pad-anchor"></a>
                <h2 class="text-center">Properties I've Sold</h2>
                <p class="text-center"><em>In the last 6 months</em></p>
                <hr>
                <div class="row justify-content-center">
                    <?php foreach($solds as $listing){ ?>
                        <div class="feat-prop col-md-6 col-xl-3 text-center">
                            <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                    <?php include(locate_template('template-parts/partials/disclaimer.php')); ?>
                    </div>
                </div>      
                <?php } ?>
            </div>
            
		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();
