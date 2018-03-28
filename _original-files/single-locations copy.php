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

			})(jQuery);
			</script>

		    <div style="margin-bottom: 10px; max-width: 450px;"><?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=4]' ); ?></div>
		    <?php while ( have_posts() ) : the_post(); ?>
		    	<h1><?php the_title(); ?></h1>

		    	<div class="row">
			    	<div class="col-md-6">
						<?php
							$map = get_field('location_map');

							if( !empty($map) ):
							?>
							<div class="acf-map">
								<div class="marker" data-lat="<?php echo $map['lat']; ?>" data-lng="<?php echo $map['lng']; ?>"></div>
							</div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								            <p><?php the_field('location_address_1'); ?><br/>
								            <?php echo ( get_field('location_address_2') ? the_field('location_address_2') . '<br/>' : ''); ?>
								            <?php the_field('location_city'); ?>, <?php the_field('location_state'); ?> <?php the_field('location_zip'); ?><br/>
								            <?php the_field('location_phone'); ?>
								            <?php echo ( get_field('location_fax') ? '<br/>Fax: ' . the_field('location_fax') . '' : ''); ?>
								            <?php echo ( get_field('location_email') ? '<br/><a href="mailto:"' .the_field('location_email') . '">' . the_field('location_email') . '</a>' : ''); ?>
								            <?php echo ( get_field('location_web_name') ? '<br/><a href="' . get_field( 'location_url') . '">' . get_field('location_web_name') . '</a>' : ''); ?>
								            <br /><a href="https://www.google.com/maps/dir/Current+Location/<?php echo $map['lat'] ?>,<?php echo $map['lng'] ?>" target="_blank">Directions</a> [Opens in New Window]
								        </p>
							<?php endif; ?>
			    	</div>
			    	<div class="col-md-6">

		    	<h2>Physicians at this location:</h2>
		    	<?php

						/*
						*  Query posts for a relationship value.
						*  This method uses the meta_query LIKE to match the string "123" to the database value a:1:{i:0;s:3:"123";} (serialized array)
						*/

						$physicians = get_posts(array(
							'post_type' => 'people',
							'meta_query' => array(
								'relation'		=> 'AND',
								array(
									'key' => 'physician_locations', // name of custom field
									'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
									'compare' => 'LIKE'
								),
								array(
									'key'		=> 'profile_type',
									'value'		=> '"Physician"',
									'compare'	=> 'LIKE'
								)
							)
						));

						?>
						<?php if( $physicians ): ?>
							<div>
							<?php foreach( $physicians as $physician ): ?>
								<?php

								$photo = get_field('person_photo', $physician->ID);
								$profileurl = '/directory/physician/' .  get_post_field( 'post_name', $physician->ID) .'/';
								$full_name = get_field('person_first_name', $physician->ID) .' ' .(get_field('person_middle_name', $physician->ID) ? get_field('person_middle_name', $physician->ID) . ' ' : '') . get_field('person_last_name', $physician->ID) . (get_field('person_degree', $physician->ID) ? ', ' . get_field('person_degree', $physician->ID) : '');

								?>
								<div class="row" style="border: 1px solid #eee; padding: .5em 0;">
									<div class="col-md-2">
									<a href="<?php echo $profileurl; ?>">
										<img src="<?php echo $photo; ?>" alt="<?php echo $full_name; ?>" width="100%" />
									</a>
									</div>
									<div class="col-md-10">
										<a href="<?php echo $profileurl; ?>"><h4><?php echo $full_name; ?></h4></a>
											<p><?php echo ( get_field('physician_short_clinical_bio', $physician->ID) ? get_field( 'physician_short_clinical_bio', $physician->ID) : wp_trim_words( get_field( 'physician_clinical_bio', $physician->ID ), 30, ' &hellip;' ) ); ?></p>
					                            <a class="more" target="_self" title="View Profile" href="<?php echo $profileurl; ?>">View Profile</a>
					                </div><!-- .col -->
					           </div><!-- .row -->
							<?php endforeach; ?>
							</div>
						<?php endif; ?>

		    <?php endwhile; // end of the loop. ?>
			    	</div><!-- .col -->
			   </div><!-- .row -->
		</div>
<?php wp_reset_query(); ?>
	</div>

    <div id="sidebar"></div>

  </div>

</div>

<?php get_footer(); ?>