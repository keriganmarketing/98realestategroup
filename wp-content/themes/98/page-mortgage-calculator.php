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

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
            <?php while ( have_posts() ) : the_post(); ?>

                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-10 offset-lg-1" >
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                <div class="entry-content">
                                    <?php the_content(); ?>
                                  
                                  <!--Begin Calculators Script-->

                                    <!--Begin Speed Bump-->
                                    <script language="JavaScript" type="text/javascript">
                                    function SiteMigrationAlert(TVSURL)
                                    {
                                    var Notice = "This website provides these links as a convenience. ";
                                    Notice += "This website has no control over the linked websites or the content therein. ";
                                    Notice += "As such, This website has no liability arising out of linking to these websites ";
                                    Notice += "and the existence of such links does not constitute endorsement by this website.";

                                    if (confirm(Notice)) {window.open(TVSURL);}
                                    else {return false;}
                                    }
                                    </script>
                                    <!--End Speed Bump-->

                                    <div style="float:right;">
                                    <!--Begin Send To Friend-->
                                    <script language="JavaScript" type="text/javascript">
                                    var QS = unescape(document.location.search);
                                    var subject;
                                    var body;
                                    if (QS.indexOf("CALCULATORID") == -1)
                                    {
                                    subject = "financial calculators";
                                    body = "Hello,%0A%0ATake a look at these online financial calculators.%0A%0A" + escape(document.location.href);
                                    }
                                    else
                                    {
                                    subject = "financial calculation";
                                    body = "Hello,%0A%0ATake a look at this online financial calculation.%0A%0A" + escape(document.location.href);
                                    }
                                    var imgsrc = 'https://www.timevaluecalculators.com/timevaluecalculators/images/email_icon.png';
                                    var imgtitle = 'Email this to a friend';
                                    var linktext = '<img src="' + imgsrc + '" title="' + imgtitle + '" alt=\"Email page\" />';
                                    var link = '<a href="mailto:?subject=' + subject + '&body=' + body + '">' + linktext + '</a>';
                                    document.write(link);
                                    </script>
                                    <!--End Send To Friend-->

                                    <!--Begin Print This-->
                                    <a href="javascript:window.print();">
                                    <img src="https://www.timevaluecalculators.com/timevaluecalculators/images/print_icon.png" title="Print this page"  alt="Print page" />
                                    </a>
                                    <!--End Print This-->
                                    </div>


                                    <!--Begin Calculators Content-->
                                    <div class="cTimeValue">
                                    <script type="text/javascript">
                                    // Developers:  If you should have any questions or concerns 
                                    //              regarding the use of this script, please call 
                                    //              TimeValue Software Support at 800-426-4741
                                    TEMPLATE_ID = "WWW.98REALESTATEGROUP.COM_2";
                                    CALCULATORID = "";
                                    PASSTHROUGH = "";
                                    HIDEFORMTAG = "";
                                    TVCMOBILE = "";
                                    ACCORDIANINPUT = "";
                                    if (document.location.href.substring(0,5) == "https") { URL = "https://"; } else { URL = "http://";}
                                    URL += "www.TimeValueCalculators.com/timevaluecalculators/includes/calculators_script.js";
                                    scriptTag = 'SCRIPT ';
                                    languageAttr = 'LANGUAGE="JavaScript" ';
                                    srcAttr = 'SR' + 'C="' + URL + '" '; //split for DNN
                                    typeAttr = 'TYPE="text/javascript" ';
                                    document.write('<' + scriptTag + languageAttr + srcAttr + '></' + scriptTag + '>');
                                    </script>
                                    </div>
                                    <!--End Calculators Content-->


                                    <!--End Calculators Script-->
                                    
                                </div><!-- .entry-content -->

                            </article><!-- #post-## -->
                        </div>
                    </div>
                </div>

            <?php endwhile; // End of the loop. ?>
          
		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();
