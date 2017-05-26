<?php
/* Custom Theme Functions */

// Fix ACF Support
add_filter('_includes/acf-pro/settings/show_admin', '__return_true');

require( 'setup/class.people.php' );
require( 'setup/class.people-custom-post.php' );

// ACF User Role Filter - Disable Nag
add_filter('remove_hube2_nag', '__return_true');

//Update people type taxonomy based on ACF field.
//Values are hard coded
function change_post_taxonomy( $post_id ) {
    // bail if no ACF data
    if ( empty($_POST['acf']) ) {
        return;
    }

    // Limit to certain post types if needed
    if(get_post_type($post_id) == 'people') {

	    $term_ids = array();

	    // get term id from $post_id
	    $stored_role = wp_get_post_terms($post_id, 'profile_type');

	    // get submitted value from acf form by field key
	    $posted_roles = $_POST['acf']['field_5919d6c75c253'];

	    // get term_id for the submitted value(s)
	    foreach ($posted_roles as $posted_role) {

			$term = get_term_by( 'name', $posted_role, 'profile_type' );
			$term_id = $term->term_id;
			$term_ids[] = $term_id;

		}

	    // if stored value(s) is/are not equal to posted value(s), then update terms
	    if ( $stored_role != $posted_role ) {
	        wp_set_object_terms( $post_id, $term_ids, 'profile_type' );
	    }
    }
}
add_action('acf/save_post', 'change_post_taxonomy', 20);

// rewrite tag for physician
function physician_rewrite_tag() {
	add_rewrite_tag( '%physician%', '([^&]+)' );
}
add_action('init', 'physician_rewrite_tag', 10, 0);

// rewrite tag for academic
function academic_rewrite_tag() {
	add_rewrite_tag( '%academic%', '([^&]+)' );
}

// create slug rules
add_action('init', 'academic_rewrite_tag', 10, 0);
function academic_rewrite_rule() {
	add_rewrite_rule( '^directory/([^/]+)/([^/]+)/?$', 'index.php?post_type=people&profile_type=$matches[1]&people=$matches[2]','top' );
	add_rewrite_rule( '^directory/([^/]+)?$', 'index.php?post_type=people&profile_type=$matches[1]','top' );
}
add_action('init', 'academic_rewrite_rule', 10, 0);

// Ajax Search Pro function
/*
add_filter( “asp_result_image_after_prostproc”, “asp_cf_image”, 1, 1 );

function asp_cf_image( $image ) {
if ($image != “” && strlen($image) < 10) {
	$atts = wp_get_attachment_image_src( $image );
	if (isset($atts[0]))
		return $atts[0];
		return null;
	}
	return $image;
}
*/

// Include only the Physician profile_type
add_filter( 'asp_query_args', 'asp_include_only_term_ids', 2, 2 );

function asp_include_only_term_ids( $args, $id ) {
  /**
   * Enter the desired taxonomy=>terms here.
   * For example, if you want to search category 1 and 2, then:
   *  "category" => "1,2"
   */
  $include = array(
    "profile_type" => "32",
    //"post_tag" => "4,5,6,7"
  );

  // -- !! Do not change anything below this line !! --
  if ( !is_array($args['post_tax_filter']) )
    $args['post_tax_filter'] = array();

  foreach ($include as $tax => $term_string) {
    $terms = explode(",", $term_string);
    foreach ($terms as $tk => &$tv)
      $tv = trim($tv);

    $args['post_tax_filter'][] = array(
      'taxonomy'  => $tax,
      'include'   => $terms
    );
  }

  return $args;
}

// URL modification
add_filter( 'asp_results', 'asp_custom_link_meta_results', 1, 1 );
function asp_custom_link_meta_results( $results ) {

  // Change this variable to whatever meta key you are using
  //$key = 'custom_url';

  // Parse through each result item
  foreach ($results as $k=>$v) {
	  if (($v->content_type == "pagepost") && (get_post_type($v->id) == "people"))
	  	$new_url = '/directory/physician/' . get_post_field( 'post_name', $v->id ) .'/';
    //if ( function_exists('get_field') )
    //    $new_url = get_field( $v->id, $key, true ); // ACF support
    //else
        //$new_url = get_post_meta( $v->id, $key, true );

    // Change only, if the meta is specified
    if ($new_url != '')
      $results[$k]->link  = $new_url;
  }

  return $results;
}


// pubmed finder
new pubmed_field_on_change();

class pubmed_field_on_change {

	public function __construct() {
		// enqueue js extension for acf
		// do this when ACF in enqueuing scripts
		add_action('acf/input/admin_enqueue_scripts', array($this, 'enqueue_script'));
		// ajax action for loading values
		add_action('wp_ajax_load_content_from_pubmed', array($this, 'load_content_from_pubmed'));
	} // end public function __construct

	public function load_content_from_pubmed() {
		// this is the ajax function that gets the related values and returns them

		// check for our other required values
		if (!isset($_POST['pmid'])) {
			echo json_encode(false);
			exit;
		}

		$idstr = intval($_POST['pmid']); //'22703441';

		// make json api call
		$host = 'http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&retmode=json&id={IDS}';
		// insert the pmid
		$url = str_replace( '{IDS}', $idstr, $host );
		// get json data
		$json = file_get_contents( $url );
		// make the data readable
		$obj = json_decode($json);

			// Get values
			$result = $obj -> result -> $idstr;
			$title = $result->title;
			// create authors array, just in case
			$authors = [];
			$authorlist = '';
			$last_author = end(array_keys($result->authors));
			foreach ($result->authors as $author) {
				$name = $author->name;
				array_push($authors, $name);
				$authorlist .= $name;
				if (next($result->authors)===FALSE) {
					$authorlist .= '.';
				} else {
					$authorlist .= ', ';
				}
			}
			$journal = $result->fulljournalname;
			$source = $result->source;
			$volume = $result->volume;
			$issue = $result->issue;
			$pages = $result->pages;
			$date = $result->pubdate;
			$doi = $result->elocationid;

			// create full reference
			$full = $authorlist . ' ' . $title . ' ' . $source . '. ' . $date . '; ';
			$full .= $volume . '('. $issue .'):' . $pages . '. ' . $doi . ' Pubmed PMID: <a href="https://www.ncbi.nlm.nih.gov/pubmed/' . $idstr . '" target="_blank>' . $idstr . '</a>';

			// put all the values into an array and return it as json
			$array = array(
			  'full' => $full,
			  'title' => $title,
			  'authors' => $authors
			  );
			echo json_encode($array);
			exit;
		//}


	} // end public function load_content_from_relationship

	public function enqueue_script() {
		// enqueue acf extenstion

		// only enqueue the script on the post page where it needs to run
		/* *** THIS IS IMPORTANT
		       ACF uses the same scripts as well as the same field identification
		       markup (the data-key attribute) if the ACF field group editor
		       because of this, if you load and run your custom javascript on
		       the field group editor page it can have unintended side effects
		       on this page. It is important to always make sure you're only
		       loading scripts where you need them.
		*/

		global $post;
		if (!$post ||
		    !isset($post->ID) ||
		    get_post_type($post->ID) != 'people') {
			return;
		}


		// the handle should be changed to your own unique handle
		$handle = 'pubmed_field_on_change';

		// I'm using this method to set the src because
		// I don't know where this file will be located
		// you should alter this to use the correct functions
		// to get the theme, template or plugin path
		// to set the src value to point to the javascript file
		$src = '/'.str_replace(ABSPATH, '', dirname(__FILE__)).'/js/acf-pubmed.js';
		// make this script dependent on acf-input
		$depends = array('acf-input');

		wp_register_script($handle, $src, $depends);

		wp_enqueue_script($handle);
	} // end public function enqueue_script

} // end class my_dynmamic_field_on_relationship