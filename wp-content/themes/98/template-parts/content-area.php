<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ninetyeight Real Estate Group
 */


$hero_image = get_field('hero_image');
$image1 = get_field('image_1');
$image2 = get_field('image_2');
$image3 = get_field('image_3');
$image4 = get_field('image_4');
$photos =[
    $image1,
    $image2,
    $image3,
    $image4 
]; 

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container-fluid">
        <div class="row">
            <div class="property-left col-md-4 no-gutter area-info-pictures">
                <div class="row" >
                    <div class="col-xs-12">
                        <div class="embed-responsive embed-responsive-16by9" style="margin:0;">
                            <div class="main-prop-photo">
                                <img src="<?php echo $hero_image; ?>" data-src="<?php echo $hero_image; ?>" class="img-responsive" alt="Area Photo" />
                            </div>
                        </div>
                    </div>
                    <?php foreach($photos as $photo){ ?>
                        <div class="hidden-sm-down col-md-6">
                            <div class="embed-responsive embed-responsive-16by9" style="margin:0;">
                            <div class="sub-photo-container area-sub-photos">
                                <a href="#" class="thumbnail" data-toggle="modal" data-target="#lightbox">
                                    <img src="<?php echo $photo; ?>" data-src="<?php echo $photo; ?>" class="img-fluid" alt="Area Photo" />
                                </a>
                            </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div id="TA_selfserveprop860" class="TA_selfserveprop offset-sm-1 col-sm-11" style="margin-bottom:20px;">
                        <ul id="DikDXAD3cl" class="TA_links 9NehdOp5JAA">
                            <li id="U8ZH6Jh4x" class="V2TeMLaESdzO">
                                <a target="_blank" href="https://www.tripadvisor.com/"><img src="https://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a>
                            </li>
                        </ul>
                    </div>
                    <?php
                    $locationId = $post->ID;                    
                    $areaArray = array(
                        49 => '34437',
                        51 => '34578',
                        55 => '34578',
                        47 => '1483771',
                        45 => '1483771',
                        53 => '1483771'
                    );
                    ?> 
                    <script src="https://www.jscache.com/wejs?wtype=selfserveprop&uniq=860&locationId=<?php echo $areaArray[$locationId]; ?>&lang=en_US&rating=true&nreviews=4&writereviewlink=true&popIdx=false&iswide=true&border=false&display_version=2"></script>
                  
                </div>
            </div>
            <div class="col-md-7">
                <div class="entry-content area-content">
                    <a id="btn-view-area-listing" class="btn btn-primary pull-md-right" href="#area-listings" >View Area Listings</a>
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </div>
        </div>
    </div>
</article><!-- #post-## -->
<div class="area-listings">
    <div class="container-fluid" >
        
         
    </div>
</div>
<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true" style="padding: 0 8px 3px;" >×</button>
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt="" style="min-width: 615px;" />
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var $lightbox = $('#lightbox');
    
    $('[data-target="#lightbox"]').on('click', function(event) {
        var $img = $(this).find('img'), 
            src = $img.attr('src'),
            alt = $img.attr('alt'),
            css = {
                'width': '100%',
                'maxWidth': $(window).width() - 0,
                'maxHeight': $(window).height() - 0
            };
    
        $lightbox.find('.close').addClass('hidden');
        $lightbox.find('img').attr('src', src);
        $lightbox.find('img').attr('alt', alt);
        $lightbox.find('img').css(css);
    });
    
    $lightbox.on('shown.bs.modal', function (e) {
        var $img = $lightbox.find('img');
            
        $lightbox.find('.modal-dialog').css({
            //'width': '100%',
            //'maxWidth': '90%'
        });
        $lightbox.find('.close').removeClass('hidden');
    });
});
</script>
