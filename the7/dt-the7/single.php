<?php
/**
 * The Template for displaying all single posts.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

get_header( 'single' );
?>

<?php
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'header-main' );

		if ( presscore_is_content_visible() ) {
			do_action( 'presscore_before_loop' );
			?>

			<div id="content" class="content" role="main">

				<?php if ( post_password_required() ) { ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php
						do_action( 'presscore_before_post_content' );
						the_content();
						do_action( 'presscore_after_post_content' );
						?>

					</article>

					<?php
				} else {


                                        /* grab the url for the full size featured image */
					$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
			
					/* link thumbnail to full size image for use with lightbox*/
					
                                        
					echo '<article id="post-726" class="vertical-fancy-style post-726 post type-post status-publish format-standard has-post-thumbnail category-blog-cat-1 category-13 description-off">';
					echo '<div class="custom-blog-single-post-image mb-0 post-thumbnail layzr-bg-transparent" style="background-image:url('.esc_url($featured_img_url).')" rel="lightbox">'; 
                        echo '<div class="custom-blog-single-post-title">';            
							wp_title('');
						echo '</div>';

					echo '</div>';
                        echo '<div class="custom-blog-single-post-breadcrumbs">';            
							get_breadcrumb();
						echo '</div>';

					echo '</article>';
					

					get_template_part( 'content-single', str_replace( 'dt_', '', get_post_type() ) );
				}

				comments_template( '', true );
				?>

			</div><!-- #content -->

			<?php
			do_action( 'presscore_after_content' );
		}
	}
}


function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;/&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;/&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;/&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;/&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}

get_footer();
?>
