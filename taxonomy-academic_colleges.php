<?php
   	// get the currently queried taxonomy term, for use later in the template file
	$term = get_queried_object();

	// Define the query
	$args = array(
	    'post_type' => 'people',
	    'specialty' => $term->slug,
	    'meta_query'	=> array(
			array(
				'key'		=> 'profile_type',
				'value'		=> '"Academic"',
				'compare'	=> 'LIKE'
			)
		)
	);


   	get_header();
   	$sidebar = get_post_meta($post->ID, "sidebar");
   	$breadcrumbs = get_post_meta($post->ID, "breadcrumb");
 ?>
<?php
	function custom_field_excerpt($title) {
			global $post;
			$text = get_field($title);
			if ( '' != $text ) {
				$text = strip_shortcodes( $text );
				$text = apply_filters('the_content', $text);
				$text = str_replace(']]>', ']]>', $text);
				$excerpt_length = 35; // 35 words
				$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
				$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
			}
			return apply_filters('the_excerpt', $text);
		}
	function wpdocs_custom_excerpt_length( $length ) {
	    return 35; // 35 words
	}
	add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

	?>
	<?php get_template_part( 'header', 'image' ); ?>

	<!--<div class="col-md-12 mobile-menu"> <?php get_template_part( 'menu', 'mobile' ); ?> </div>-->
	<div class="container uams-body">

	  <div class="row">

	    <div class="col-md-12 uams-content" role='main'>

	      <?php

		      if((!isset($breadcrumbs[0]) || $breadcrumbs[0]!="on")) {
		      	get_template_part( 'breadcrumbs' );
		      }
		  ?>

	      <div id='main_content' class="uams-body-copy" tabindex="-1">

		      <style>
				    .whiteBackground { background-color: #fff; }
					.grayBackground { background-color: #fafafa; }
				</style>
				<div class="row">
					<div class="col-md-8 facetwp-template">
					    <?php $i = 0; ?>

					    <h1><?php echo single_cat_title( '', false ); ?></h1><hr>

					    <?php echo (term_description( '', false ) ? '<p>' .term_description( '', false ) . '</p>' : '' ); ?>

					    <?php while ( have_posts() ) : the_post(); ?>
					    <?php $class = ($i%2 == 0)? 'whiteBackground': 'grayBackground'; ?>
					    <?php $full_name = get_field('person_first_name') .' ' .(get_field('person_middle_name') ? get_field('person_middle_name') . ' ' : '') . get_field('person_last_name') . (get_field('person_degree') ? ', ' . get_field('person_degree') : '');
						      $profileurl = '/directory/academci/' . $post->post_name .'/';
					    ?>
					    <div class="<?php echo $class; ?>" style="border:1px solid #ececec;padding:10px; margin-bottom: 10px;">
						    <div class="row">
						        <div class="col-md-12">
							        <a href="<?php echo $profileurl; ?>"><h2 style="margin-top: 0;"><?php echo $full_name; ?></h2></a>
									<?php // load all 'colleges' terms for the post
									$colleges = get_field('person_academic_college');

									// we will use the first term to load ACF data from
									if( $colleges ): ?>
										<?php foreach( $colleges as $college ): ?>
											<p><strong>
												<?php $college_name = get_term( $college, 'academic_colleges');
													echo $college_name->name;
												?>
											</strong></p>
										<?php endforeach;
									endif; ?>
						        </div>
					    	</div>
					        <div class="row">
					            <div class="col-md-3" style="margin-top:0px;margin-bottom:20px;">
						            <div style="padding-bottom: 1em;">
		                            	<span style="-moz-box-shadow: 0 0 3px rgba(0,0,0,.3);-webkit-box-shadow: 0 0 3px rgba(0,0,0,.3);box-shadow: 0 0 3px rgba(0,0,0,.3);"><a href="<?php echo $profileurl; ?>" target="_self"><img src="<?php the_field('person_photo'); ?>" alt="<?php echo $full_name; ?>" class="img-responsive"></a></span>
						            </div>
			                        <a class="uams-btn btn-blue btn-sm" target="_self" title="View Profile" href="<?php echo $profileurl; ?>">View Profile</a>
					            </div>
					            <div class="col-md-9" style="margin-top:0px;margin-bottom:0px;">
			                        <a href="<?php echo $profileurl; ?>"><h2><?php echo $full_name; ?></h2></a>
					                    <div class="row" style="margin-top:0px;margin-bottom:0px;">
					                        <div class="col-md-6">
					                            <p><?php echo ( get_field('person_academic_short_bio') ? get_field( 'person_academic_short_bio') : wp_trim_words( get_field( 'person_academic_bio' ), 30, ' &hellip;' ) ); ?></p>
					                            <a class="more" target="_self" title="View Profile" href="<?php echo $profileurl; ?>">View Profile</a>

					                            <p></p>

					                        </div>
					                        <div class="col-md-6">
						                        <?php if( have_rows('person_contact_infomation') ): ?>
					                            	<h3>Contact Infomation</h3>
												    <ul>
												    <?php while( have_rows('person_contact_infomation') ): the_row(); ?>
												    	<?php if (get_sub_field( 'office_contact_type') == 'Text/SMS') : // text/mobile ?>
												    		<li><?php the_sub_field('office_contact_type')['label']; ?>: <a href="sms:<?php the_sub_field('office_contact_value'); ?>"><?php the_sub_field('office_contact_value'); ?></a></li>
												    	<?php elseif (get_sub_field( 'office_contact_type') == 'Phone' || get_sub_field( 'office_contact_type') == 'Mobile') : // Phone ?>
												    		<li><?php the_sub_field('office_contact_type')['label']; ?>: <a href="tel:<?php echo format_phone('base', get_sub_field('office_contact_value')); ?>"><?php echo format_phone('us', get_sub_field('office_contact_value')); ?></a></li>
												    	<?php elseif (get_sub_field( 'office_contact_type') == 'Email') : // Email ?>
												    		<li><?php the_sub_field('office_contact_type')['label']; ?>: <a href="mailto:<?php the_sub_field('office_contact_value'); ?>"><?php the_sub_field('office_contact_value'); ?></a></li>
												    	<?php else : // Others ?>
												        	<li><?php the_sub_field('office_contact_type')['label']; ?>: <?php the_sub_field('office_contact_value'); ?></li>
												        <?php endif; ?>
												    <?php endwhile; ?>
												    </ul>
												<?php endif; ?>
							                    <?php if ( get_field('person_academic_office') ): ?>
							                    <div>
								                    <p><strong>Office:</strong> <?php the_field('person_academic_office'); ?></p>							                    		</div>
							                    <?php endif; ?>

					                        </div><!-- .col-6 -->
					                    </div><!-- .row -->

					            </div><!-- .col-9 -->
					        </div><!-- .row -->
					    </div><!-- .color -->
					    <?php $i++; ?>
						<?php endwhile; ?>


				<?php
					// Format Phone Numbers
					// Usage ex. format_phone('us', '1234567890') => (123) 456-7890
					// Base usage returns in ###-###-#### format
					function format_phone($country, $phone) {
					  $function = 'format_phone_' . $country;
					  if(function_exists($function)) {
					    return $function($phone);
					  }
					  return $phone;
					}

					function format_phone_us($phone) {
					  // note: making sure we have something
					  if(!isset($phone{3})) { return ''; }
					  // note: strip out everything but numbers
					  $phone = preg_replace("/[^0-9]/", "", $phone);
					  $length = strlen($phone);
					  switch($length) {
					  case 7:
					    return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
					  break;
					  case 10:
					   return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
					  break;
					  case 11:
					  return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
					  break;
					  default:
					    return $phone;
					  break;
					  }
					}
					function format_phone_base($phone) {
					  // note: making sure we have something
					  if(!isset($phone{3})) { return ''; }
					  // note: strip out everything but numbers
					  $phone = preg_replace("/[^0-9]/", "", $phone);
					  $length = strlen($phone);
					  switch($length) {
					  case 7:
					    return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
					  break;
					  case 10:
					   return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
					  break;
					  case 11:
					  return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3-$4", $phone);
					  break;
					  default:
					    return $phone;
					  break;
					  }
					}
					?>

<!-- 					<span class="next-page"><?php next_posts_link( 'Next page', '' ); ?></span> -->
<style>
.page-numbers {
	display: inline-block;
	padding: 5px 10px;
	margin: 0 2px 0 0;
	border: 1px solid #eee;
	line-height: 1;
	text-decoration: none;
	border-radius: 2px;
	font-weight: 600;
}
.page-numbers.current,
a.page-numbers:hover {
	background: #f9f9f9;
}
</style>
					<div class="pagination"><?php
global $wp_query;

$big = 999999999; // need an unlikely integer
$translated = __( 'Page', 'mytextdomain' ); // Supply translatable string

echo paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $wp_query->max_num_pages,
        //'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>',
) );
?></div>
					</div><!-- .col -->
					<div class="col-md-4">
			        	<?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=6]' ); ?>
			        	<?php echo do_shortcode( '[accordion]
													    [section title="Advanced Filter"]
														<h4>College Affiliation</h4>
														[facetwp facet="college_affiliation"]
														<h4>Position Type</h4>
														[facetwp facet="academic_position"]
														[/section]
													[/accordion]' ); ?>
		        	</div>
				</div><!-- .row -->
   			</div><!-- main_content -->

    	</div><!-- uams-content -->
    <div id="sidebar"></div>

  </div>

</div>

<?php get_footer(); ?>
