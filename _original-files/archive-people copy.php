<?php get_header();
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

		      <?php
			      $url = $_SERVER["REQUEST_URI"];

				$isItPhysician = strpos($url, 'physician');
				$isItAcademic = strpos($url, 'academic');

				if ($isItPhysician!==false)
				{
				    //url contains 'physician'
				    //echo "<h4>Physician</h4>";
				    get_template_part( 'templates/template-archive-physician' );
				}
				elseif ($isItAcademic!==false)
				{
				    //url contains 'academic'
				    //echo "<h4>Academic Profiles</h4>";
				    get_template_part('templates/template-archive-academic' );
				}
				else
				{
					//load base
					echo "<h4>Base Profiles</h4>";
					get_template_part('templates/template-archive-people' );
				}
				?>

   			</div><!-- main_content -->

    	</div><!-- uams-content -->
    <div id="sidebar"></div>

  </div>

</div>

<?php get_footer(); ?>
