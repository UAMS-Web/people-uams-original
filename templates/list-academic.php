<?php
	/**
	 *  Template Name: People
	 *  Designed for people archive, where type != academic && != physician
	 */
 ?>

			    <style>
				    .whiteBackground { background-color: #fff; }
					.grayBackground { background-color: #fafafa; }
				</style>
				<div class="row">
					<div class="col-md-12">
						<div style="margin-bottom: 10px; max-width: 450px;"><?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=1]' ); ?></div>
					</div>
				</div>
				<div class="row">
		        	<div class="col-md-3">
			        	<h3>Search Options go here</h3>
		        	</div>
					<div class="col-md-9">
					    <?php $i = 0; ?>

					    <?php while ( have_posts() ) : the_post(); ?>
					    <?php $class = ($i%2 == 0)? 'whiteBackground': 'grayBackground'; ?>
					    <div class="<?php echo $class; ?>" style="border:1px solid #ececec;padding:10px; margin-bottom: 10px;">
					        <div class="row">
					            <div class="col-md-3" style="margin-top:0px;margin-bottom:20px;">
						            <div style="padding-bottom: 1em;">
		                            	<span style="-moz-box-shadow: 0 0 3px rgba(0,0,0,.3);-webkit-box-shadow: 0 0 3px rgba(0,0,0,.3);box-shadow: 0 0 3px rgba(0,0,0,.3);"><a href="<?php echo ('/directory/academic/' . $post->post_name .'/'); ?>" target="_self"><img src="<?php the_field('person_photo'); ?>" alt="<?php echo get_the_title(); ?>" class="img-responsive"></a></span>
						            </div>
			                        <a class="uams-btn btn-blue btn-sm" target="_self" title="View Profile" href="<?php echo ('/directory/academic/' . $post->post_name .'/'); ?>">View Profile</a>
					            </div>
					            <div class="col-md-9" style="margin-top:0px;margin-bottom:0px;">
			                        <a href="<?php echo ('/directory/academic/' . $post->post_name .'/'); ?>"><h2 class="title-heading-left"><?php the_field('person_first_name') ?> <?php echo (get_field('person_middle_name') ? get_field('person_middle_name') . ' ' : '') ?><?php the_field('person_last_name') ?><?php echo (get_field('person_degree') ? ', ' . get_field('person_degree') : '') ?></h2></a>
			                        <strong><?php (get_field('person_academic_college') ? the_field('person_academic_college') : ''); ?></strong>
					                    <div class="row" style="margin-top:0px;margin-bottom:0px;">
					                        <div class="col-md-6">
					                            <p><?php echo ( get_field('person_academic_short_bio') ? get_field( 'person_academic_short_bio') : wp_trim_words( get_field( 'person_academic_bio' ), 30, ' &hellip;' ) ); ?></p>
					                            <a class="more" target="_self" title="View Profile" href="<?php echo ('/directory/academic/' . $post->post_name .'/'); ?>">View Profile</a>

					                            <p></p>

					                        </div>
					                        <div class="col-md-6">
						                        <?php if( have_rows('person_contact_infomation') ): ?>
					                            	<h3>Contact Infomation</h3>
												    <ul>
												    <?php while( have_rows('person_contact_infomation') ): the_row(); ?>
												        <li><?php the_sub_field('office_contact_type')['label']; ?>: <?php the_sub_field('office_contact_value'); ?></li>
												    <?php endwhile; ?>
												    </ul>
												<?php endif; ?>
							                    <?php if ( get_field('person_academic_office') ): ?>
							                    <div>
								                    <p><strong>Office:</strong> <?php the_field('person_academic_office'); ?></p>							                    </div>
							                    <?php endif; ?>

					                        </div><!-- .col-6 -->
					                    </div><!-- .row -->

					            </div><!-- .col-9 -->
					        </div><!-- .row -->
					    </div><!-- .color -->
					    <?php $i++; ?>
						<?php endwhile; ?>
					</div><!-- .col -->
				</div><!-- .row -->
