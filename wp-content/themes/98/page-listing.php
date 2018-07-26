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

if($_GET['mls'] != ''){
	$_SESSION['mls'] = $_GET['mls'];
	$location = '/listing/'.$_GET['mls'].'/';
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
	header("Location: $location");
}

function setogurl(){
	$pathFragments = explode('/',$_SERVER['REQUEST_URI']);
	$end = end(array_filter($pathFragments, function($value) { return $value !== ''; }));
	$mlsNum = $end;
    return $location = 'http://98realestategroup.com/listing/'.$mlsNum.'/';
}

add_filter( 'wpseo_title', 'filter_wp_title' );
add_filter( 'wpseo_opengraph_url', 'setogurl' );
add_filter( 'wpseo_canonical', 'setogurl' );
add_filter( 'wpseo_opengraph_image', 'filter_wp_mainimage');

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<div class="container-fluid">
				<div class="row">
					<?php //getTemplateFile('page-listing'); ?>
                    <div class="col-xs-12 col-lg-10 offset-lg-1">
                    <p class="rets-disclaimer">Property information provided by the REALTOR’S® Association of Franklin and Gulf Counties, Inc.. IDX information is provided exclusively for consumers personal, non-commercial use, and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. This data is deemed reliable but is not guaranteed accurate by the MLS.</p>
                    </div>
				</div>
				<div class="clearfix"></div>
                
			</div>
			
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer();
