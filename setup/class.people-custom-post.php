<?php

	// Register 'People' Custom Post Type
function people() {

	$labels = array(
		'name'                  => 'People',
		'singular_name'         => 'Person',
		'menu_name'             => 'People',
		'name_admin_bar'        => 'Person',
		'archives'              => 'Person Archives',
		'attributes'            => 'Person Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All People',
		'add_new_item'          => 'Add New Person',
		'add_new'               => 'Add New',
		'new_item'              => 'New Person',
		'edit_item'             => 'Edit Person',
		'update_item'           => 'Update Person',
		'view_item'             => 'View Person',
		'view_items'            => 'View People',
		'search_items'          => 'Search People',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'People list',
		'items_list_navigation' => 'People list navigation',
		'filter_items_list'     => 'Filter People list',
	);
	$capabilities = array(
		'edit_post'             => 'edit_person',
		'read_post'             => 'read_person',
		'delete_post'           => 'delete_person',
		'edit_posts'            => 'edit_people',
		'edit_others_posts'     => 'edit_others_people',
		'publish_posts'         => 'publish_people',
		'read_private_posts'    => 'read_private_people',
	);
	$args = array(
		'label'                 => 'Person',
		'description'           => 'Post Type Description',
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', ),
		'taxonomies'            => array( 'specialties', 'department', 'patient_type', 'medical_procedures', 'medical_terms' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'https://doc.uamsonlinedev.wpengine.com/wp-content/uploads/sites/7/2016/05/physicians-icons-e1463773225684.png',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'slug'					=> 'people',
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capabilities'          => $capabilities,
		'show_in_rest'          => true,
		'rest_base'             => 'people',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);
	register_post_type( 'people', $args );

}
add_action( 'init', 'people', 0 );

if ( ! function_exists('locations') ) {

// Register Custom Post Type
function locations() {

	$labels = array(
		'name'                  => 'Locations',
		'singular_name'         => 'Location',
		'menu_name'             => 'Locations',
		'name_admin_bar'        => 'Location',
		'archives'              => 'Location Archives',
		'attributes'            => 'Location Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Locations',
		'add_new_item'          => 'Add New Location',
		'add_new'               => 'Add New',
		'new_item'              => 'New Location',
		'edit_item'             => 'Edit Location',
		'update_item'           => 'Update Location',
		'view_item'             => 'View Location',
		'view_items'            => 'View Locations',
		'search_items'          => 'Search Locations',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Locations list',
		'items_list_navigation' => 'Locations list navigation',
		'filter_items_list'     => 'Filter Locations list',
	);
	$capabilities = array(
		'edit_post'             => 'edit_location',
		'read_post'             => 'read_location',
		'delete_post'           => 'delete_location',
		'edit_posts'            => 'edit_locations',
		'edit_others_posts'     => 'edit_others_locations',
		'publish_posts'         => 'publish_locations',
		'read_private_posts'    => 'read_private_locations',
	);
	$args = array(
		'label'                 => 'Location',
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'https://doc.uamsonlinedev.wpengine.com/wp-content/uploads/sites/7/2016/05/locations-icons-e1463773294811.png',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capabilities'          => $capabilities,
		'show_in_rest'          => true,
		'rest_base'             => 'locations',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);
	register_post_type( 'locations', $args );

}
add_action( 'init', 'locations', 0 );

}

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_clinical_conditions_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts

function create_clinical_conditions_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
// first do the translations part for GUI

  $labels = array(
		'name'                           => 'Conditions',
		'singular_name'                  => 'Condition',
		'search_items'                   => 'Search Conditions',
		'all_items'                      => 'All Conditions',
		'edit_item'                      => 'Edit Condition',
		'update_item'                    => 'Update Condition',
		'add_new_item'                   => 'Add New Condition',
		'new_item_name'                  => 'New Condition',
		'menu_name'                      => 'Conditions',
		'view_item'                      => 'View Condition',
		'popular_items'                  => 'Popular Condition',
		'separate_items_with_commas'     => 'Separate conditions with commas',
		'add_or_remove_items'            => 'Add or remove conditions',
		'choose_from_most_used'          => 'Choose from the most used conditions',
		'not_found'                      => 'No conditions found'
	);

// Now register the taxonomy

  	register_taxonomy(
  		'condition',
		'people',
		array(
			'label' => __( 'Condition' ),
			'hierarchical' => true,
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'capabilities'=>array(
				'manage_terms' => 'manage_options',//or some other capability your clients don't have
				'edit_terms' => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' =>'edit_people'),
			'rewrite' => array(
				'slug' => 'conditions'
			)
		)
	);

}

// Register Custom Taxonomy
function create_medical_specialties_taxonomy() {

	$labels = array(
		'name'                       => 'Medical Specialties',
		'singular_name'              => 'Medical Specialty',
		'menu_name'                  => 'Medical Specialty',
		'all_items'                  => 'All Specialties',
		'parent_item'                => 'Parent Specialty',
		'parent_item_colon'          => 'Parent Specialty:',
		'new_item_name'              => 'New Specialty',
		'add_new_item'               => 'Add New Specialty',
		'edit_item'                  => 'Edit Specialty',
		'update_item'                => 'Update Specialty',
		'view_item'                  => 'View Specialty',
		'separate_items_with_commas' => 'Separate specialties with commas',
		'add_or_remove_items'        => 'Add or remove specialties',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Specialties',
		'search_items'               => 'Search Specialties',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Specialties',
		'items_list'                 => 'Specialties list',
		'items_list_navigation'      => 'Specialties list navigation',
	);
	$rewrite = array(
		'slug'                       => 'specialties',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$capabilities = array(
		'manage_terms'               => 'manage_options',
		'edit_terms'                 => 'manage_options',
		'delete_terms'               => 'manage_options',
		'assign_terms'               => 'edit_people',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
		'show_in_rest'       		 => true,
  		'rest_base'          		 => 'specialties',
  		'rest_controller_class' 	 => 'WP_REST_Terms_Controller',
	);
	register_taxonomy( 'specialty', array( 'people' ), $args );

}
add_action( 'init', 'create_medical_specialties_taxonomy', 0 );

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_departments_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts
function create_departments_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
// first do the translations part for GUI

  $labels = array(
		'name'                           => 'Medical Departments',
		'singular_name'                  => 'Medical Departments',
		'search_items'                   => 'Search Departments',
		'all_items'                      => 'All Departments',
		'edit_item'                      => 'Edit Department',
		'update_item'                    => 'Update Department',
		'add_new_item'                   => 'Add New Department',
		'new_item_name'                  => 'New Department',
		'menu_name'                      => 'Medical Departments',
		'view_item'                      => 'View Department',
		'popular_items'                  => 'Popular Department',
		'separate_items_with_commas'     => 'Separate departments with commas',
		'add_or_remove_items'            => 'Add or remove departments',
		'choose_from_most_used'          => 'Choose from the most used departments',
		'not_found'                      => 'No departments found'
	);

// Now register the taxonomy

  	register_taxonomy(
  		'department',
		'people',
		array(
			'label' => __( 'Medical Departments' ),
			'hierarchical' => true,
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'capabilities'=>array(
				'manage_terms' => 'manage_options',//or some other capability your clients don't have
				'edit_terms' => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' =>'edit_people'),
				'rewrite' => array(
				'slug' => 'department'
			)
		)
	);

}
//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_patient_type_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts
function create_patient_type_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
// first do the translations part for GUI

  $labels = array(
		'name'                           => 'Patient Types',
		'singular_name'                  => 'Patient Types',
		'search_items'                   => 'Search Types',
		'all_items'                      => 'All Types',
		'edit_item'                      => 'Edit Type',
		'update_item'                    => 'Update Type',
		'add_new_item'                   => 'Add New Type',
		'new_item_name'                  => 'New Type',
		'menu_name'                      => 'Patient Types',
		'view_item'                      => 'View Type',
		'popular_items'                  => 'Popular Type',
		'separate_items_with_commas'     => 'Separate types with commas',
		'add_or_remove_items'            => 'Add or remove types',
		'choose_from_most_used'          => 'Choose from the most used types',
		'not_found'                      => 'No types found'
	);

// Now register the taxonomy

  	register_taxonomy(
  		'patient_type',
		'people',
		array(
			'label' => __( 'Patient Types' ),
			'hierarchical' => true,
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'capabilities'=>array(
				'manage_terms' => 'manage_options',//or some other capability your clients don't have
				'edit_terms' => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' =>'edit_people'),
				'rewrite' => array(
				'slug' => 'patient_type'
			)
		)
	);

}
//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_medical_procedures_taxonomy', 0 );

// Register Custom Taxonomy
function profile_type() {

	$labels = array(
		'name'                       => _x( 'Profile Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Profile Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Profile Type', 'text_domain' ),
		'all_items'                  => __( 'All Profile Types', 'text_domain' ),
		'parent_item'                => __( 'Parent Profile Type', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Profile Type:', 'text_domain' ),
		'new_item_name'              => __( 'New Profile Type', 'text_domain' ),
		'add_new_item'               => __( 'Add New Profile Type', 'text_domain' ),
		'edit_item'                  => __( 'Edit Profile Type', 'text_domain' ),
		'update_item'                => __( 'Update Profile Type', 'text_domain' ),
		'view_item'                  => __( 'View Profile Type', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$capabilities = array(
		'manage_terms'               => 'manage_categories',
		'edit_terms'                 => 'manage_categories',
		'delete_terms'               => 'manage_categories',
		'assign_terms'               => 'edit_posts',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true, //make true to add another
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
// 		'rewrite'                    => array( 'slug' => '%profile_type%' ),
		'capabilities'               => $capabilities,
		'show_in_rest'               => true,
		'rest_base'                  => 'profile_type',
		'rest_controller_class'      => 'WP_REST_Terms_Controller',
	);
	register_taxonomy( 'profile_type', array( 'people' ), $args );

}
add_action( 'init', 'profile_type', 0 );

//create a custom taxonomy name it topics for your posts
function create_medical_procedures_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
// first do the translations part for GUI

  $labels = array(
		'name'                           => 'Medical Procedures',
		'singular_name'                  => 'Medical Procedures',
		'search_items'                   => 'Search Procedures',
		'all_items'                      => 'All Procedures',
		'edit_item'                      => 'Edit Procedure',
		'update_item'                    => 'Update Procedure',
		'add_new_item'                   => 'Add New Procedure',
		'new_item_name'                  => 'New Procedure',
		'menu_name'                      => 'Medical Procedures',
		'view_item'                      => 'View Procedure',
		'popular_items'                  => 'Popular Procedure',
		'separate_items_with_commas'     => 'Separate procedures with commas',
		'add_or_remove_items'            => 'Add or remove procedures',
		'choose_from_most_used'          => 'Choose from the most used procedures',
		'not_found'                      => 'No procedures found'
	);

// Now register the taxonomy

  	register_taxonomy(
  		'medical_procedures',
		'people',
		array(
			'label' => __( 'Medical Procedures' ),
			'hierarchical' => false,
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'capabilities'=>array(
				'manage_terms' => 'manage_options',//or some other capability your clients don't have
				'edit_terms' => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' =>'edit_people'),
			'rewrite' => array(
				'slug' => 'medical_procedures'
			)
		)
	);

}
// Register Custom Taxonomy
function create_medical_terms_taxonomy() {

	$labels = array(
		'name'                       => 'Medical Terms',
		'singular_name'              => 'Medical Term',
		'menu_name'                  => 'Medical Terms',
		'all_items'                  => 'All Terms',
		'parent_item'                => 'Parent Term',
		'parent_item_colon'          => 'Parent Term:',
		'new_item_name'              => 'New Term',
		'add_new_item'               => 'Add New Term',
		'edit_item'                  => 'Edit Term',
		'update_item'                => 'Update Term',
		'view_item'                  => 'View Term',
		'separate_items_with_commas' => 'Separate terms with commas',
		'add_or_remove_items'        => 'Add or remove terms',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Terms',
		'search_items'               => 'Search Terms',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Terms',
		'items_list'                 => 'Terms list',
		'items_list_navigation'      => 'Terms list navigation',
	);
	$rewrite = array(
		'slug'                       => 'medical-terms',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$capabilities = array(
		'manage_terms'               => 'manage_options',
		'edit_terms'                 => 'manage_options',
		'delete_terms'               => 'manage_options',
		'assign_terms'               => 'edit_people',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
	);
	register_taxonomy( 'medical_terms', array( 'people' ), $args );

}
add_action( 'init', 'create_medical_terms_taxonomy', 0 );

function add_roles_on_plugin_activation() {
       add_role( 'doc_editor', 'Doc Profile Editor', array( 'read' => true, 'read_person' => true, 'edit_people' => true, 'edit_published_people' => true, 'read_location' => true, 'read_private_locations' => true, 'edit_locations' => true, 'edit_published_locations' => true,  'upload_files' => true, 'edit_files' => true ) );
   }
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

function add_theme_caps() {
    // gets the author role
    $role = get_role( 'administrator' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'edit_others_posts' );
    $role->add_cap( 'edit_person' );
	$role->add_cap( 'read_person');
	$role->add_cap( 'delete_person');
	$role->add_cap( 'edit_people');
	$role->add_cap( 'edit_others_people');
	$role->add_cap( 'publish_people');
	$role->add_cap( 'read_private_people');
    $role->add_cap( 'edit_location');
	$role->add_cap( 'read_location');
	$role->add_cap( 'delete_location');
	$role->add_cap( 'edit_locations');
	$role->add_cap( 'edit_others_locations');
	$role->add_cap( 'publish_locations');
	$role->add_cap( 'read_private_locations');
}
add_action( 'admin_init', 'add_theme_caps');

// Remove the taxonomy metabox [slugnamediv]
function remove_person_meta() {
	remove_meta_box( 'conditiondiv', 'people', 'side' );
	remove_meta_box( 'specialtydiv', 'people', 'side' );
	remove_meta_box( 'departmentdiv', 'people', 'side' );
	remove_meta_box( 'patient_typediv', 'people', 'side' );
	remove_meta_box( 'tagsdiv-medical_procedures', 'people', 'side' );
	remove_meta_box( 'medical_termsdiv', 'people', 'side' );
	remove_meta_box('custom-post-type-onomies-locations', 'people', 'side');
}

add_action( 'admin_menu' , 'remove_person_meta' );

add_action('admin_head', 'acf_hide_title');

function acf_hide_title() {
  echo '<style>
    .acf-field.hide-acf-title {
    border: none;
    padding: 6px 12px;
	}
	.hide-acf-title .acf-label {
	    display: none;
	}
	.acf-field.pbn { padding-bottom:0; }
  </style>';
}

/**
 * Add REST API support to Teams Meta.
 */
function rest_api_person_meta() {
    register_rest_field('people', 'person_meta', array(
            'get_callback' => 'get_person_meta',
            'update_callback' => null,
            'schema' => null,
        )
    );
}
function get_person_meta($object) {
    $postId = $object['id'];
    //$data = get_post_meta($postId); //Returns All
    //$data = array();
    $data['pexcerpt'] = wp_trim_words( get_post_meta( $postId, 'person_short_bio', true ), 30, ' &hellip;' );
    $data['pcontent'] = get_post_meta( $postId, 'person_clinical_bio', true );
    $data['ptitle'] = get_post_meta( $postId, 'person_title', true );
	$data['pphoto'] = wp_get_attachment_url( get_post_meta( $postId, 'person_photo', true ), 'file' );
	$data['pyoutube'] = get_post_meta( $postId, 'person_youtube_link', true );
	$data['pspecialties'] = get_the_terms( $postId, 'specialty' );
	//$data['tsuser'] = get_post_meta( $postId, '_tsuser', true );
	//$data['tsfreehtml'] = get_post_meta( $postId, '_tsfreehtml', true );
	//$data['tspersonal'] = get_post_meta( $postId, '_tspersonal', true );
	//$data['tspersonalanchor'] = get_post_meta( $postId, '_tspersonalanchor', true );
	//$data['tslocation'] = get_post_meta( $postId, '_tslocation', true );
    return $data;
}
add_action('rest_api_init', 'rest_api_person_meta');