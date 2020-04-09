<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Catalyst-child
 * @since 1.0
 * @version 1.0
 */



get_header(); ?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php if ( current_user_can( 'manage_options' ) )  : ?>
                    <header class="page-header">
                        <h1>Models</h1>
                        <?php
                        /*                the_archive_title( '<h1 class="page-title">', '</h1>' );
                                        the_archive_description( '<div class="taxonomy-description">', '</div>' );
                                        */?>
                    </header><!-- .page-header -->
                    <div class="model_results_wrapper">
                    <div id="archive-filters">

                        <h3>Filter Results</h3>

                        <?php foreach( $GLOBALS['my_query_filters'] as $key => $name ):

                            $field = get_field_object($key);

                            // set value if available
                            if( isset($_GET[ $name ]) ) {

                                $values = explode(',', $_GET[$name]);
                            }


                            $labelName = preg_replace('/[^a-z0-9 ]/i', ' ', $name);

                            ?>

                            <ul class="filter <?php echo $name; ?>" data-filter="<?php echo $name; ?>">
                                <?php /*echo print_r($field['choices']);*/?>
                                <h4><?php echo $labelName; ?></h4>
                                <div class="box">
                                    <?php /*if (is_array($field) || is_object($field)) : */?>
                                        <?php foreach($field['choices'] as $choice_value => $choice_label) :
                                                $choice_value = preg_replace('/\s+/', '',$choice_value);
                                            ?>
                                            <li>
                                                <input type="checkbox" data-filter="<?php echo $name; ?>" value="<?php echo $choice_value; ?>" <?php if(isset($_GET[ $name ]) && $values != null && in_array($choice_value, $values )) : ?> checked <?php endif; ?>>

                                                <label><?php echo $choice_label; ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php /*endif; */?>
                                </div>

                            </ul>
                        <?php endforeach; ?>

                    </div>

                    <script type="text/javascript">
                        (function($) {

                            // change
                            $('#archive-filters').on('change', 'input[type="checkbox"]', function(){

                                // vars
                                var url = '<?php echo home_url('models'); ?>';
                                args = {};


                                // loop over filters
                                $('#archive-filters .filter').each(function(){

                                    // vars
                                    var filter = $(this).data('filter'),
                                        vals = [];

                                    // find checked inputs
                                    $(this).find('input:checked').each(function(){

                                        vals.push( $(this).val() );

                                    });

                                    /* /!*var $ul = $(this).closest('ul'),
                                         vals = [];

                                     $ul.find('input:checked').each(function(){

                                         vals.push( $(this).val() );*!/

                                     });*/


                                    // append to args
                                    args[ filter ] = vals.join(',');

                                    /*vals = vals.join(",");*/

                                });


                                // update url
                                url += '?';


                                // loop over args
                                $.each(args, function( name, value ){
                                    if(value !== "") {
                                        url += name + '=' + value + '&';
                                    }

                                });

                                // remove last &
                                url = url.slice(0, -1);

                                var cookie = '?' + url.split('?')[1];


                                createCookie("results", cookie, 1);


                                // reload page
                                window.location.replace( url );

                            });

                            if(window.location.href.indexOf("?") < 1) {
                                createCookie("results", "", 1);
                            }

                        })(jQuery);

                        function createCookie(name, value, days) {
                            var expires;
                            if (days) {
                                var date = new Date();
                                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                                expires = "; expires=" + date.toGMTString();
                            }
                            else {
                                expires = "";
                            }
                            document.cookie = name + "=" + value + expires + "; path=/";
                        }

                    </script>


                    <?php
                    if ( have_posts() ) : ?>

                        <div class="content_wrap">
                    <?php
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();


                           // get_template_part( 'content', get_post_format() );

                                $headShot = get_field('head_shot');
                                $url = $headShot['url'];
                                $alt = $headShot['alt'];

                                // thumbnail
                                $size = 'thumbnail';
                                $thumb = $headShot['sizes'][ $size ];
                            ?>

                            <div class="model_content">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title( '<h3>', '</h3>' ); ?>
                                    <div class="image_wrap">
                                        <?php if ($headShot) : ?>

                                            <img src="<?php echo $thumb ?>" alt="<?php echo $alt; ?>">

                                        <?php else : ?>
                                            <img src="<?php echo bloginfo('template_url'); ?>-child/images/placeholder.png" />
                                        <?php endif; ?>
                                    </div><!-- image_wrap -->
                                </a>

                            </div><!-- model_content -->



                            <?php
                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */

                            //catalyst_post_preview();
                        endwhile;


                        /*the_posts_pagination( array(
                            'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
                        ) );*/

                        catalyst_pagination();

                    echo "</div>";

                    echo "</div>";

                    else :

                        get_template_part( 'content', 'none' );

                    endif;  ?>

            <?php else : ?>

                <div class="no_perm">
                    <h3>You Do Not Have Permissions to View this Page </h3>
                </div>

            <?php endif; ?>



            </main><!-- #main -->


        </div><!-- #primary -->
        <?php //get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
