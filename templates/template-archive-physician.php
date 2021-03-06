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
		        	<div class="col-md-4">
			        	<?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=3]' ); ?>
			        	<?php echo do_shortcode( '[accordion]
													    [section title="Advanced Filter"]
														<h4>Primary Care</h4>
														[facetwp facet="primary_care"]
														<h4>Conditions Treated</h4>
														[facetwp facet="conditions"]
														<h4>Patient Types</h4>
														[facetwp facet="patient_types"]
														<h4>Gender</h4>
														[facetwp facet="physician_gender"]
														<h4>Language(s)</h4>
														[facetwp facet="physician_language"]
														[/section]
													[/accordion]' ); ?>
		        	</div>
					<div class="col-md-8 facetwp-template people">
						<style> .people h2, .people h3 { margin-top:0; } </style>
					    <?php $i = 0; ?>
					    <?php while ( have_posts() ) : the_post(); ?>
					    <?php $class = ($i%2 == 0)? 'whiteBackground': 'grayBackground'; ?>
					    <?php $full_name = get_field('person_first_name') .' ' .(get_field('person_middle_name') ? get_field('person_middle_name') . ' ' : '') . get_field('person_last_name') . (get_field('person_degree') ? ', ' . get_field('person_degree') : '');
						      $profileurl = '/directory/physician/' . $post->post_name .'/';
					    ?>
					    <div class="<?php echo $class; ?>" style="border:1px solid #ececec;padding:10px; margin-bottom: 10px;">
					        <div class="row">
						        <div class="col-md-12"><a href="<?php echo $profileurl; ?>"><h2 style="margin-top: 0;"><?php echo $full_name; ?></h2></a></div>
					    	</div>
							<div class="row">
					            <div class="col-md-3" style="margin-top:0px;margin-bottom:20px;">
						            <div style="padding-bottom: 1em;">
		                            	<span style="-moz-box-shadow: 0 0 3px rgba(0,0,0,.3);-webkit-box-shadow: 0 0 3px rgba(0,0,0,.3);box-shadow: 0 0 3px rgba(0,0,0,.3);"><a href="<?php echo $profileurl; ?>" target="_self"><img src="<?php the_field('person_photo'); ?>" alt="<?php echo $full_name; ?>" class="img-responsive"></a></span>
						            </div>
			                        <a class="uams-btn btn-blue btn-sm" target="_self" title="View Profile" href="<?php echo ('/directory/physician/' . $post->post_name .'/'); ?>">View Profile</a>
									<?php if(get_field('physician_youtube_link')) { ?>
			                        <a class="uams-btn btn-red btn-play btn-sm" target="_self" title="View Physician Video" href="<?php the_field('physician_youtube_link'); ?>">View Video</a>
									<?php } ?>
									<?php if(get_field('physician_npi')) { ?>
									<div class="ds-summary" data-ds-id="<?php echo get_field( 'physician_npi' ); ?>"></div>
									<?php } ?>
					            </div>
					            <div class="col-md-9" style="margin-top:0px;margin-bottom:0px;">
					                    <div class="row" style="margin-top:0px;margin-bottom:0px;">
					                        <div class="col-md-6">

					                            <p><?php echo ( get_field('physician_short_clinical_bio') ? get_field( 'physician_short_clinical_bio') : wp_trim_words( get_field( 'physician_clinical_bio' ), 30, ' &hellip;' ) ); ?></p>
					                            <a class="more" target="_self" title="View Profile" href="<?php echo $profileurl; ?>">View Profile</a>

					                            <p></p>

					                        </div>
					                        <div class="col-md-6">

					                            <?php // load all 'specialties' terms for the post
													$specialties = get_field('medical_specialties');

													// we will use the first term to load ACF data from
													if( $specialties ): ?>
													<h3>Specialties</h3>
														<ul>
															<?php foreach( $specialties as $specialty ): ?>
																<li>
																	<a href="<?php echo get_term_link( $specialty ); ?>">
																	<?php $specialty_name = get_term( $specialty, 'specialty');
																		echo $specialty_name->name;
																	?>
																	</a>
																</li>
															<?php endforeach; ?>
														</ul>
												<?php endif; ?>
				                                <?php

												$locations = get_field('physician_locations');

												?>
												<?php if( $locations ): ?>
												<h3> Locations</h3>
													<ul>
													<?php foreach( $locations as $location ): ?>
														<li>
															<a href="<?php echo get_permalink( $location->ID ); ?>">
																<?php echo get_the_title( $location->ID ); ?>
															</a>
														</li>
													<?php endforeach; ?>
													</ul>
												<?php endif; ?>

					                        </div><!-- .col-6 -->
					                    </div><!-- .row -->

					            </div><!-- .col-9 -->
					        </div><!-- .row -->
					    </div><!-- .color -->
					    <?php $i++; ?>
						<?php endwhile; ?>
						<?php if(get_field('physician_npi')) { ?>
						<script src="https://www.docscores.com/widget/v2/uams/npi/lotw.js" async></script>
						<?php } ?>
						<script>
							(function ($, window) {

							var intervals = {};
							var removeListener = function(selector) {

								if (intervals[selector]) {

									window.clearInterval(intervals[selector]);
									intervals[selector] = null;
								}
							};
							var found = 'waitUntilExists.found';

							/**
							 * @function
							 * @property {object} jQuery plugin which runs handler function once specified
							 *           element is inserted into the DOM
							 * @param {function|string} handler
							 *            A function to execute at the time when the element is inserted or
							 *            string "remove" to remove the listener from the given selector
							 * @param {bool} shouldRunHandlerOnce
							 *            Optional: if true, handler is unbound after its first invocation
							 * @example jQuery(selector).waitUntilExists(function);
							 */

							$.fn.waitUntilExists = function(handler, shouldRunHandlerOnce, isChild) {

								var selector = this.selector;
								var $this = $(selector);
								var $elements = $this.not(function() { return $(this).data(found); });

								if (handler === 'remove') {

									// Hijack and remove interval immediately if the code requests
									removeListener(selector);
								}
								else {

									// Run the handler on all found elements and mark as found
									$elements.each(handler).data(found, true);

									if (shouldRunHandlerOnce && $this.length) {

										// Element was found, implying the handler already ran for all
										// matched elements
										removeListener(selector);
									}
									else if (!isChild) {

										// If this is a recurring search or if the target has not yet been
										// found, create an interval to continue searching for the target
										intervals[selector] = window.setInterval(function () {

											$this.waitUntilExists(handler, shouldRunHandlerOnce, true);
										}, 500);
									}
								}

								return $this;
							};

							}(jQuery, window));
						(function($) {
							$(document).ready(function(){
								$('.ds-average').waitUntilExists( function(){

									$('.ds-average').attr('itemprop', 'ratingValue');
									$('.ds-ratingcount').attr('itemprop', 'ratingCount');
									$('.ds-summary').attr('itemtype', 'http://schema.org/AggregateRating');
									$('.ds-summary').attr('itemprop', 'aggregateRating');
									//$('.ds-comments').wrapInner('<a href="#PatientRatings"></a>');
								});
							});
						})(jQuery);
					</script>
					</div><!-- .col -->
				</div><!-- .row -->
