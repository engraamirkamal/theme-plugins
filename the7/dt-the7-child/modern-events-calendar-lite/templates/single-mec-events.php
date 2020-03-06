<?php
/** no direct access **/
defined('MECEXEC') or die();

/**
 * The Template for displaying all single events
 * 
 * @author Webnus <info@webnus.biz>
 * @package MEC/Templates
 * @version 1.0.0
 */
get_header('mec'); ?>


        <section id="<?php echo apply_filters('mec_single_page_html_id', 'main-content'); ?>" class="<?php echo apply_filters('mec_single_page_html_class', 'mec-container'); ?>">



            <?php do_action('mec_before_main_content'); ?>
            
            <?php while(have_posts()): the_post(); ?>

            <?php
                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
                /* link thumbnail to full size image for use with lightbox*/
                
                echo '<div class="custom-event-single-post-image post-thumbnail layzr-bg-transparent" style="background-image:url('.esc_url($featured_img_url).')" rel="lightbox">'; 
                    echo '<div class="custom-event-single-post-title">'; 
                        wp_title(' ');
                    echo '</div>';


                echo '</div>';
                echo '<div class="custom-event-single-post-breadcrumbs">'; 
                    get_breadcrumb();
                echo '</div>';
                    
            ?>

                <?php $MEC = MEC::instance(); echo $MEC->single(); ?>

            <?php endwhile; // end of the loop. ?>
            <?php comments_template(); ?>
        </section>

    <?php do_action('mec_after_main_content'); ?>

<?php
function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (!is_category() || is_single()) {
        echo "&nbsp;&nbsp;/&nbsp;&nbsp;";
        echo '<a href="'.home_url().'/meetings-list/" rel="nofollow">Meetings</a>'.the_category(' &bull; ');
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

?>
<?php get_footer('mec');