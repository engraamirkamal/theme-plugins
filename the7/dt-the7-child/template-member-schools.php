<?php
/**
 * Template Name: Member Schools
 *
 * The Template for displaying all Member School posts.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */
?>


<?php get_header(); ?>

	<?php
		$args = array(
		'post_type' => 'member_school',
		);
		$member_school = new WP_Query( $args );

                if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
		<?php endif;


		if( $member_school->have_posts() ) {
		while( $member_school->have_posts() ) {
			$member_school->the_post();

			$city = get_post_meta( get_the_ID(), 'city', true );
			$state = get_post_meta( get_the_ID(), 'state', true );
			$contact = get_post_meta( get_the_ID(), 'contact', true );
			$email = get_post_meta( get_the_ID(), 'email', true );
			$members_designation = get_post_meta( get_the_ID(), 'members_designation', true );
			$members_name = get_post_meta( get_the_ID(), 'members_name', true );
			$member_picture = get_post_meta( get_the_ID(), 'member_picture', true );

		?>

		<!-- Content -->
		<div class="member-schools">
			<div class="inner-container">
				<div class="left-sec">
					<?php the_post_thumbnail()?>
				</div>
				<div class="right-sec">
					<h3 class="h3-style"><?php the_title()?></h3>
					<div class="info-sec">
						<div class="info">
							<ul class="ul-style">
								<li><i class="fa fa-map-marker" aria-hidden="true"></i><span><b>CITY:</b> <?php echo $city; ?></span></li>
								<li><i class="fa fa-location-arrow" aria-hidden="true"></i><span><b>STATE:</b> <?php echo $state; ?></span></li>
								<li><i class="fa fa-phone" aria-hidden="true"></i><span><b>CONTACT:</b> <a href="callto:<?php echo $contact; ?>"><?php echo $contact; ?></a></span></li>
								<li><i class="fa fa-envelope" aria-hidden="true"></i><span><b>Email:</b> <a href="mailto:<?php echo $email?>"><?php echo $email?></a></span></li>
							</ul>
						</div>
						<div class="info1">
							<img src="<?php echo $member_picture['guid']?>">
							<p class="author-name-style"><?php echo $members_name; ?><br><?php echo $members_designation?></p>
						</div>
					</div>
					<div class="descrip-sec">
						<h5>DESCRIPTION:</h5>
						<p><?php the_content()?></p>
					</div>
				</div>
			</div>
		</div>
		<!-- #content -->
			
	<?php
	
		}
		}
		else {
			echo 'No member school details found!';
		}
?>
<?php get_footer(); ?>