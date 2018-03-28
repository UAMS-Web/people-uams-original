<?php get_header();
   $sidebar = get_post_meta($post->ID, "sidebar");
   $breadcrumbs = get_post_meta($post->ID, "breadcrumb");
 ?>
	<?php get_template_part( 'header', 'image' ); ?>

	<!--<div class="col-md-12 mobile-menu"> <?php get_template_part( 'menu', 'mobile' ); ?> </div>-->
	<div class="container uams-body">

	  <div class="row">

	    <div class="col-md-12 uams-content" role='main'>

	      <?php //uams_page_title(); ?>

	      <?php //get_template_part( 'menu', 'mobile' ); ?>

	      <?php
		      if((!isset($breadcrumbs[0]) || $breadcrumbs[0]!="on")) {
		      	get_template_part( 'breadcrumbs' );
		      }
		  ?>

	      <div id='main_content' class="uams-body-copy" tabindex="-1">
		   <style type="text/css">

			.acf-map {
				width: 100%;
				height: 400px;
				border: #ccc solid 1px;
				margin: 20px 0;
			}

			/* fixes potential theme css conflict */
			.acf-map img {
			   max-width: inherit !important;
			}

			</style>
			<script src="<?php echo get_template_directory_uri(); ?>/js/uams.tabsmodule.js" type="text/javascript"></script>
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
			<script type="text/javascript">
			(function($) {

			/*
			*  new_map
			*
			*  This function will render a Google Map onto the selected jQuery element
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	$el (jQuery element)
			*  @return	n/a
			*/

			function new_map( $el ) {

				// var
				var $markers = $el.find('.marker');


				// vars
				var args = {
					zoom		: 16,
					center		: new google.maps.LatLng(0, 0),
					mapTypeId	: google.maps.MapTypeId.ROADMAP
				};


				// create map
				var map = new google.maps.Map( $el[0], args);


				// add a markers reference
				map.markers = [];


				// add markers
				$markers.each(function(){

			    	add_marker( $(this), map );

				});


				// center map
				center_map( map );


				// return
				return map;

			}

			/*
			*  add_marker
			*
			*  This function will add a marker to the selected Google Map
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	$marker (jQuery element)
			*  @param	map (Google Map object)
			*  @return	n/a
			*/

			function add_marker( $marker, map ) {

				// var
				var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

				// create marker
				var marker = new google.maps.Marker({
					position	: latlng,
					label		: $marker.attr('data-label'),
					map			: map
				});

				// add to array
				map.markers.push( marker );

				// if marker contains HTML, add it to an infoWindow
				if( $marker.html() )
				{
					// create info window
					var infowindow = new google.maps.InfoWindow({
						content		: $marker.html()
					});

					// show info window when marker is clicked
					google.maps.event.addListener(marker, 'click', function() {

						infowindow.open( map, marker );

					});
				}

			}

			/*
			*  center_map
			*
			*  This function will center the map, showing all markers attached to this map
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	map (Google Map object)
			*  @return	n/a
			*/

			function center_map( map ) {

				// vars
				var bounds = new google.maps.LatLngBounds();

				// loop through all markers and create bounds
				$.each( map.markers, function( i, marker ){

					var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

					bounds.extend( latlng );

				});

				// only 1 marker?
				if( map.markers.length == 1 )
				{
					// set center of map
				    map.setCenter( bounds.getCenter() );
				    map.setZoom( 16 );
				}
				else
				{
					// fit to bounds
					map.fitBounds( bounds );
				}

			}

			/*
			*  document ready
			*
			*  This function will render each map when the document is ready (page has loaded)
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	5.0.0
			*
			*  @param	n/a
			*  @return	n/a
			*/
			// global var
			var map = null;

			$(document).ready(function(){

				$('.acf-map').each(function(){

					// create map
					map = new_map( $(this) );

				});

			});

			$(document).ready(function(){

			  $( 'a#label_tab-location' ).on( "shown.bs.tab", function() {

			  		google.maps.event.trigger(map, 'resize');
			  		center_map(map);

               });

			  $( '#label_tab-location' ).focus( function() {

			  		google.maps.event.trigger(map, 'resize');
			  		center_map(map);

               });

			});

			})(jQuery);
			</script>
			<div style="margin-bottom: 10px; max-width: 450px;"><?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=1]' ); ?></div>
	        <div class="row">
		        <div class="col-md-8">
	                <h1 class="title-heading-left" data-fontsize="34" data-lineheight="48"><?php the_field('physician_first_name'); ?> <?php echo (get_field('physician_middle_name') ? get_field('physician_middle_name') : ''); ?> <?php the_field('physician_last_name'); ?><?php echo (get_field('physician_degree') ? ', ' . get_field('physician_degree') : ''); ?></h1>
	                    <?php echo (get_field('physician_title') ? '<h4>' . get_field('physician_title') .'</h4>' : ''); ?>
	            </div>
				<div class="col-md-4">
	                <div class="fusion-button-wrapper">
	                    <a class="fusion-button button-flat button-round button-medium button-custom button-1" target="_self" title="Make an Appointment" href="<?php the_field('physician_appointment_link'); ?>"><i class="fa fa-calendar-o button-icon-left"></i><span class="fusion-button-text">Make an Appointment</span></a>
	                </div>
	            </div>
	        </div>
			<div class="row">
				<div class="col-md-3">
	                <div class="imageframe-align-center">
	                    <span class="fusion-imageframe imageframe-none imageframe-1 hover-type-none"><img src="<?php the_field('physician_photo'); ?>" alt="<?php echo get_the_title(); ?>" class="img-responsive"></span>
	                </div>
<?php if(get_field('physician_youtube_link')) { ?>
	                <div class="fusion-button-wrapper">
	                    <a class="fusion-button button-flat button-round button-medium button-custom button-2" target="_self" title="Watch Video" href="<?php the_field('physician_youtube_link'); ?>"><i class="fa fa-youtube-play button-icon-left"></i><span class="fusion-button-text">Watch Video</span></a>
	                </div>
<?php } ?>
	                <div class="fusion-button-wrapper">
	                    <a class="fusion-button button-flat button-round button-medium button-custom button-3" target="_self" title="Visit MyChart" href="https://mychart.uamshealth.com/"><i class="fa fa-folder-open button-icon-left"></i><span class="fusion-button-text">MyChart</span></a>
	                </div>

	                <p style="text-align: center;"><strong>Patient Rating</strong><br>
	                stars<br>
	                # out of 5<br>
	                # Ratings<br>
	                <a href="#comments"># Comments</a></p>

	                <div class="fusion-sep-clear"></div>

	                <div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:10px;margin-bottom:10px;"></div>
						<?php

						$locations = get_field('physician_locations');

						?>
						<?php if( $locations ): ?>
						<h3 data-fontsize="16" data-lineheight="24"><i class="fa fa-medkit"></i> Clinic(s)</h3>
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
	            </div>
				<div class="col-md-9">
	                <div class="js-tabs tabs__uams">
		                <ul class="js-tablist tabs__uams_ul" data-hx="h2">
	                    	<li class="js-tablist__item tabs__uams__li">
	                    		<a href="#tab-overview" id="label_tab-overview" class="js-tablist__link tabs__uams__a" data-toggle="tab">
	                            	<i class="fa fontawesome-icon fa-book"></i>Overview
	                            </a>
	                        </li>
	                        <li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-academics" id="label_tab-academics" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            <i class="fa fontawesome-icon fa-graduation-cap"></i>Academics
		                        </a>
	                        </li>
	                        <li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-location" id="label_tab-location" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            <i class="fa fontawesome-icon fa-map-marker"></i>Location
		                        </a>
	                        </li>
	                    <?php if(have_rows('physician_awards')||get_field('physician_additional_info')): ?>
	                    	<li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-info" id="label_tab-info" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            <i class="fa fontawesome-icon fa-info-circle"></i>Additional Info
		                        </a>
	                        </li>
	                    <?php endif; ?>
                        </ul>
                        <div class="uams-tab-content">
	                        <div id="tab-overview" class="js-tabcontent tabs__uams__tabcontent">
			                    <?php the_content();//the_field('physician_bio'); ?>
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
								<?php // load all 'specialties' terms for the post
									$conditions = get_field('physician-conditions');

									// we will use the first term to load ACF data from
									if( $conditions ): ?>
									<h3>Conditions/Diseases Treated</h3>
									<p><em>UAMS doctors treat a broad range of conditions some of which may not be listed below.</em></p>
										<ul>
											<?php foreach( $conditions as $condition ): ?>
												<li>
													<?php $condition_name = get_term( $condition, 'condition');
														echo $condition_name->name;
													?>
												</li>
											<?php endforeach; ?>
										</ul>
								<?php endif; ?>
								<?php // load all 'specialties' terms for the post
									$procedures = get_field('medical_procedures');

									// we will use the first term to load ACF data from
									if( $procedures ): ?>
									<h3>Tests/Procedures Performed</h3>
									<p><em>The following list represents some, but not all, of the procedures offered by this doctor.</em></p>
										<ul>
											<?php foreach( $procedures as $procedure ): ?>
												<li>
													<?php $procedure_name = get_term( $procedure, 'medical_procedures');
														echo $procedure_name->name;
													?>
												</li>
											<?php endforeach; ?>
										</ul>
								<?php endif; ?>
							</div>
	                        <div id="tab-academics" class="js-tabcontent tabs__uams__tabcontent">
	                            <?php if( have_rows('academic_appointment') ): ?>
	                            	<h3>Academic Appointments</h3>
								    <ul>
								    <?php while( have_rows('academic_appointment') ): the_row(); ?>
								        <li><?php the_sub_field('academic_title'); ?>, <?php the_sub_field('academic_department'); ?></li>
								    <?php endwhile; ?>
								    </ul>
								<?php endif; ?>
								<?php if( have_rows('physician_education') ): ?>
	                            	<h3>Education</h3>
								    <ul>
								    <?php while( have_rows('physician_education') ): the_row(); ?>
								        <li><?php the_sub_field('physician-education-type'); ?> - <?php echo (get_sub_field('physician_education_description') ? '' . get_sub_field('physician_education_description') .'<br/>' : ''); ?><?php the_sub_field('physician-education-school'); ?></li>
								    <?php endwhile; ?>
								    </ul>
								<?php endif; ?>
								<?php if( have_rows('physician_boards') ): ?>
	                            	<h3>Professional Certifications</h3>
								    <ul>
								    <?php while( have_rows('physician_boards') ): the_row(); ?>
								        <li><?php the_sub_field('physician_board_name'); ?></li>
								    <?php endwhile; ?>
								    </ul>
								<?php endif; ?>
								<?php if( have_rows('physician_publications') ): ?>
	                            	<h3>Selected Publications</h3>
								    <ul>
								    <?php while( have_rows('physician_publications') ): the_row(); ?>
								        <li><?php the_sub_field('pub_authors'); ?> (<?php the_sub_field('pub_published'); ?>) <?php the_sub_field('pub_title'); ?> <em><?php the_sub_field('pub_periodical'); ?> <?php echo ( get_sub_field('pub_volume') ? the_sub_field('pub_volume') : ''); ?></em><?php echo ( get_sub_field( 'pub_issue') ? '(' . the_sub_field('pub_issue') .')' : ''); ?> <?php the_sub_field('pub_pmid'); ?> <?php the_sub_field('pub_pmcid'); ?> </li>
								    <?php endwhile; ?>
								    </ul>
								<?php endif; ?>
	                        </div>
	                        <div id="tab-location" class="js-tabcontent tabs__uams__tabcontent">
	                            <?php

								$physician_locations = get_field('physician_locations');

								if( $physician_locations ): ?>
									<div class="acf-map">
									<?php $i = 1; ?>
                                    <?php foreach( $physician_locations as $post): // variable must be called $post (IMPORTANT) ?>
                                        <?php setup_postdata($post); ?>

                                        <?php $map = get_field('location_map'); ?>
                                        <div class="marker" data-lat="<?php echo $map['lat']; ?>" data-lng="<?php echo $map['lng']; ?>" data-label="<?php echo $i ?>"></div>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
                                    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                    </div>
                                    <ol>
                                        <?php foreach ($physician_locations as $post): setup_postdata($post); ?>
                                        <li>
								        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								            <p><?php the_field('location_address_1'); ?><br/>
								            <?php echo ( get_field('location_address_2') ? the_field('location_address_2') . '<br/>' : ''); ?>
								            <?php the_field('location_city'); ?>, <?php the_field('location_state'); ?> <?php the_field('location_zip'); ?><br/>
								            <?php the_field('location_phone'); ?>
								            <?php echo ( get_field('location_fax') ? '<br/>Fax: ' . the_field('location_fax') . '' : ''); ?>
								            <?php echo ( get_field('location_email') ? '<br/><a href="mailto:"' .the_field('location_email') . '">' . the_field('location_email') . '</a>' : ''); ?>
								            <?php echo ( get_field('location_web_name') ? '<br/><a href="' . get_field( 'location_url') . '">' . get_field('location_web_name') . '</a>' : ''); ?>
								        </p>
                                        </li>
								    <?php endforeach; ?>
                                    </ol>
								    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
								<?php endif; ?>
	                        </div>
						<?php if(have_rows('physician_awards')||get_field('physician_additional_info')): ?>
	                        <div id="tab-info" class="js-tabcontent tabs__uams__tabcontent">
	                            <?php if( have_rows('physician_awards') ): ?>
	                            	<h3>Awards</h3>
								    <ul>
								    <?php while( have_rows('physician_awards') ): the_row(); ?>
								        <li><?php the_sub_field('award_infor'); ?> (<?php the_sub_field('award_year'); ?>)</li>
								    <?php endwhile; ?>
								    </ul>
								<?php endif; ?>
								<?php
									if(get_field('physician_additional_info'))
									{
										echo get_field('physician_additional_info');
									}
								?>
	                        </div>
	                    <?php endif; ?>
	            		</div><!-- uams-tab-content -->
	                </div><!-- js-tabs -->
	    		</div><!-- col-md-9 -->
				<?php wp_reset_query(); ?>
			</div><!-- row -->
			</div><!-- uams-content -->

    	</div><!-- row -->

		<div id="sidebar"></div>

  </div>

</div>

<?php get_footer(); ?>
