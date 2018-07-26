<?php
/**
 * Template Name: Facebook Gallery
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
                $albumId = get_field('album_id');
	            require('facebooksdk/src/Facebook/autoload.php');

                if($albumId == 'all'){

	                $albumLoop = array();

	                $fb = new Facebook\Facebook( array(
		                'app_id'               => '131392937353724',
		                'app_secret'           => '06922d1c4845d4e77005047ccba39bb0',
		                'default_access_token' => '131392937353724|zLDOpfQc4AQ-j_Tgqm7oUgAW3IQ'
	                ) );
	                $request = $fb->request( 'GET', '/98RealEstateGroup/albums' );

	                // Send the request to Graph
	                try {
		                $response = $fb->getClient()->sendRequest( $request );
	                } catch ( Facebook\Exceptions\FacebookResponseException $e ) {
		                // When Graph returns an error
		                echo 'Graph returned an error: ' . $e->getMessage();
		                exit;
	                } catch ( Facebook\Exceptions\FacebookSDKException $e ) {
		                // When validation fails or other local issues
		                echo 'Facebook SDK returned an error: ' . $e->getMessage();
		                exit;
	                }

	                $getAlbums = $response->getGraphEdge();

	                foreach($getAlbums as $albumGraph) {
	                    //print_r($albumGraph);
		                $albumLoop[] = array(
                            'id' => $albumGraph['id'],
                            'title' => $albumGraph['name']
                        );
	                }

	                //print_r($albumLoop);

                }else{
                    $albumLoop = array(
	                    array(
                            'id' => $albumId,
                            'title' => ''
                        )
                    );
                }

            endwhile; // End of the loop.

            ?>
                        
            <div class="photo-gallery">
                <div class="container">
                    <div class="row">
                        <?php
                        //SHOW INDIVIDUAL PHOTOS
	                        foreach ( $albumLoop as $album ) {

		                        $fb = new Facebook\Facebook( array(
			                        'app_id'               => '131392937353724',
			                        'app_secret'           => '06922d1c4845d4e77005047ccba39bb0',
			                        'default_access_token' => '131392937353724|zLDOpfQc4AQ-j_Tgqm7oUgAW3IQ'
		                        ) );
		                        $request = $fb->request(
                                    'GET',
                                    '/' . $album['id'] . '/photos'
                                );

		                        // Send the request to Graph
		                        try {
			                        $response = $fb->getClient()->sendRequest( $request );
		                        } catch ( Facebook\Exceptions\FacebookResponseException $e ) {
			                        // When Graph returns an error
			                        echo 'Graph returned an error: ' . $e->getMessage();
			                        exit;
		                        } catch ( Facebook\Exceptions\FacebookSDKException $e ) {
			                        // When validation fails or other local issues
			                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
			                        exit;
		                        }

		                        $getGraphEdge = $response->getGraphEdge();

		                        if(count($albumLoop)==1) {
		                            foreach ( $getGraphEdge as $photo ) {
			                            $prequest = $fb->request( 'GET', '/' . $photo['id'] );

			                            try {
				                            $presponse = $fb->getClient()->sendRequest( $prequest );
			                            } catch ( Facebook\Exceptions\FacebookResponseException $e ) {
				                            // When Graph returns an error
				                            echo 'Graph returned an error: ' . $e->getMessage();
				                            exit;
			                            } catch ( Facebook\Exceptions\FacebookSDKException $e ) {
				                            // When validation fails or other local issues
				                            echo 'Facebook SDK returned an error: ' . $e->getMessage();
				                            exit;
			                            }

			                            $pObject = $presponse->getGraphNode();

			                            ?>
                                        <div class="col-md-4">
                                            <div class="photo-container">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <a href="#" title="<?php echo $album['name']; ?>" class="thumbnail" data-toggle="modal" data-target="#lightbox">
                                                    <img src="http://graph.facebook.com/<?php echo $pObject['id']; ?>/picture?type=normal" class="img-fluid" alt="<?php echo $pObject['name']; ?>"></a>
                                                </div>
                                                <p><?php //echo $pObject['name']; ?></p>
                                                <p></p>
                                            </div>
                                        </div>
                                    <?php }
                                    }else{
                                        $photo = $getGraphEdge[0];

                                        if(isset($photo)){
                                            $prequest = $fb->request( 'GET', '/' . $photo['id'] );

                                            try {
                                                $presponse = $fb->getClient()->sendRequest( $prequest );
                                            } catch ( Facebook\Exceptions\FacebookResponseException $e ) {
                                                // When Graph returns an error
                                                echo 'Graph returned an error: ' . $e->getMessage();
                                                exit;
                                            } catch ( Facebook\Exceptions\FacebookSDKException $e ) {
                                                // When validation fails or other local issues
                                                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                                                exit;
                                            }

                                            $pObject = $presponse->getGraphNode();
                                        ?>
                                        <div class="col-md-4">
                                            <div class="photo-container">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <a target="_blank" title="<?php echo $album['name']; ?>" href="https://www.facebook.com/98RealEstateGroup/photos/?tab=album&album_id=<?php echo $album['id']; ?>" class="thumbnail" >
                                                        <img src="http://graph.facebook.com/<?php echo $pObject['id']; ?>/picture?type=normal" class="img-fluid" alt="<?php echo $album['name']; ?>"></a>
                                                </div>
                                                <p><?php echo $album['title']; ?></p>
                                                <p></p>
                                            </div>
                                        </div>
                                    <?php }
                                     }
	                            } ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt="" />
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
<?php get_footer();
