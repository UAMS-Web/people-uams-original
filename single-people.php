<?php
	/**
	 *  Template Name: People
	 *  Designed for people single
	 */


	get_header();
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
	      <?php

		      	$url = $_SERVER["REQUEST_URI"];

				$isItPhysician = strpos($url, 'physician');
				$isItAcademic = strpos($url, 'academic');

				if ($isItPhysician!==false)
				{
				    //url contains 'physician'
				    get_template_part( 'templates/content-physician' );
				}
				elseif ($isItAcademic!==false)
				{
				    //url contains 'academic'
				    get_template_part('templates/content-academic' );
				}
				else
				{
					//load base
					get_template_part('templates/content-people' );
				}
				?>

			</div><!-- #main_content -->

    	</div><!-- uams-content -->

		<div id="sidebar"></div>

  </div><!-- row -->

</div>

<?php get_footer(); ?>
