<?php
/**
 * Archive pages.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$config->set( 'template', 'archive' );
$config->set( 'layout', 'masonry' );
$config->set( 'template.layout.type', 'masonry' );

get_header();
?>

	<!-- Content -->
	<div id="content" class="content" role="main">

		<?php
		
		echo '<div class="custom-category-page-breadcrumbs">'; 
			get_breadcrumb();
		echo '</div>';

		the_archive_description( '<div class="taxonomy-description">', '</div>' );

		if ( have_posts() ) {
			the7_archive_loop();
		} else {
			get_template_part( 'no-results', 'search' );
		}
		?>

	</div><!-- #content -->

	<?php do_action( 'presscore_after_content' ); ?>


<?php
function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;/&nbsp;";
        echo the_category('/');
            if (is_single()) {
                echo " &nbsp;&nbsp;/&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;/&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;/&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}

?>
<?php get_footer(); ?>
