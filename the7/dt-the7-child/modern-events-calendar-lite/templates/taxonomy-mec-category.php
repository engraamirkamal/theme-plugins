<?php
/** no direct access **/
defined('MECEXEC') or die();

/**
 * The Template for displaying mec-category taxonomy events
 * 
 * @author Webnus <info@webnus.biz>
 * @package MEC/Templates
 * @version 1.0.0
 */
get_header('mec'); ?>
    
	
		<section id="<?php echo apply_filters('mec_category_page_html_id', 'main-content'); ?>" class="<?php echo apply_filters('mec_category_page_html_class', 'container'); ?>">
		
		<?php do_action('mec_before_main_content'); ?>
		
			<?php do_action('mec_before_events_loop');
			print apply_filters( 'taxonomy-images-queried-term-image', '', array(
    'image_size' => 'medium'
) );?>
                
                <h1><?php echo single_term_title(''); ?></h1>
				<?php $MEC = MEC::instance(); echo $MEC->category(); ?>

			<?php do_action('mec_after_events_loop'); ?>

        </section>

    <?php do_action('mec_after_main_content'); ?>
	<?php do_action( 'presscore_after_content' ); ?>




<?php add_action( 'get_footer', 'wpdocs_my_save_post');
function wpdocs_my_save_post(){

$footer_sidebar = presscore_validate_footer_sidebar( presscore_config()->get( 'footer_widgetarea_id' ) );
?>
</div>
</div>
<footer id="footer" class="footer solid-bg">
<div class="wf-wrap">
	<div class="wf-container-footer">
		<div class="wf-container">
			<?php
			do_action( 'presscore_before_footer_widgets' );
			dynamic_sidebar( $footer_sidebar );
			?>
		</div><!-- .wf-container -->
	</div><!-- .wf-container-footer -->
</div><!-- .wf-wrap -->
</footer>
<?php 
}
  get_footer();