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
		'menu_icon'             => get_stylesheet_directory_uri() .'/assets/admin-icons/physicians-icon.png',
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
		'menu_icon'             => get_stylesheet_directory_uri() .'/assets/admin-icons/locations-icon.png',
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
			),
			'show_in_rest'       		 => true,
			'rest_base'          		 => 'condition',
			'rest_controller_class' 	 => 'WP_REST_Terms_Controller'
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
		'show_ui'                    => false, //make true to add another
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

// Register Custom Taxonomy
function create_academic_position_taxonomy() {

	$labels = array(
		'name'                       => 'Positions',
		'singular_name'              => 'Position',
		'menu_name'                  => 'Academic Positions',
		'all_items'                  => 'All Positions',
		'parent_item'                => 'Parent Position',
		'parent_item_colon'          => 'Parent Position:',
		'new_item_name'              => 'New Position',
		'add_new_item'               => 'Add New Position',
		'edit_item'                  => 'Edit Position',
		'update_item'                => 'Update Position',
		'view_item'                  => 'View Position',
		'separate_items_with_commas' => 'Separate positions with commas',
		'add_or_remove_items'        => 'Add or remove positions',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Positions',
		'search_items'               => 'Search Positions',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Positions',
		'items_list'                 => 'Positions list',
		'items_list_navigation'      => 'Positions list navigation',
	);
	$rewrite = array(
		'slug'                       => 'academic-position',
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
		'show_ui'                    => false,	//Made true to add / edit
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
	);
	register_taxonomy( 'academic_positions', array( 'people' ), $args );

}
add_action( 'init', 'create_academic_position_taxonomy', 0 );

// Register Custom Taxonomy
function create_academic_college_taxonomy() {

	$labels = array(
		'name'                       => 'Colleges',
		'singular_name'              => 'College',
		'menu_name'                  => 'Colleges',
		'all_items'                  => 'All Colleges',
		'parent_item'                => 'Parent College',
		'parent_item_colon'          => 'Parent College:',
		'new_item_name'              => 'New College',
		'add_new_item'               => 'Add New College',
		'edit_item'                  => 'Edit College',
		'update_item'                => 'Update College',
		'view_item'                  => 'View College',
		'separate_items_with_commas' => 'Separate colleges with commas',
		'add_or_remove_items'        => 'Add or remove colleges',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Colleges',
		'search_items'               => 'Search Colleges',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Colleges',
		'items_list'                 => 'Colleges list',
		'items_list_navigation'      => 'Colleges list navigation',
	);
	$rewrite = array(
		'slug'                       => 'college',
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
		'show_ui'                    => false,  //Made true to add / edit
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
	);
	register_taxonomy( 'academic_colleges', array( 'people' ), $args );

}
add_action( 'init', 'create_academic_college_taxonomy', 0 );

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
    //People
    $data['person_first_name'] = get_post_meta( $postId, 'person_first_name', true );
    $data['person_middle_name'] = get_post_meta( $postId, 'person_middle_name', true );
    $data['person_last_name'] = get_post_meta( $postId, 'person_last_name', true );
    $data['person_degree'] = get_post_meta( $postId, 'person_degree', true );
    //Physician Data
    $data['physician_title'] = get_post_meta( $postId, 'physician_title', true );
    $data['physician_clinical_bio'] = get_post_meta( $postId, 'physician_clinical_bio', true );
    $data['physician_short_clinical_bio'] = wp_trim_words( get_post_meta( $postId, 'physician_short_clinical_bio', true ), 30, ' &hellip;' );
    $data['physician_gender'] = get_post_meta( $postId, 'physician_gender', true );
    $data['physician_youtube_link'] = get_post_meta( $postId, 'physician_youtube_link', true );
    $data['physician_languages'] = get_post_meta( $postId, 'physician_languages', true );
    //$data['physician_locations_id'] = get_post_meta( $postId, 'physician_locations', true );
    //$data['physician_locations']['link'] = get_permalink( get_post_meta( $postId, 'physician_locations', true ) );
    //$data['physician_locations']['title'] = get_the_title( get_post_meta( $postId, 'physician_locations', true ) );
    //$data['physician_locations']['slug'] = get_post_field( 'post_name', get_post_meta( $postId, 'physician_locations', true ) );
    //Locations
    $i = 1;
	foreach (get_post_meta( $postId, 'physician_locations', true ) as $location) {
		$data['physician_locations'][$location]['link'] = get_permalink( $location );
		$data['physician_locations'][$location]['title'] = get_the_title( $location );
		$data['physician_locations'][$location]['slug'] = get_post_field( 'post_name', $location );
		$data['physician_locations'][$location]['address'] = '<p>' . get_post_meta( $location, 'location_address_1', true).'<br/>';
		$data['physician_locations'][$location]['address'] .= ( get_post_meta( $location, 'location_address_2', true ) ? get_post_meta( $location, 'location_address_2', true ) . '<br/>' : '');
		$data['physician_locations'][$location]['address'] .= get_post_meta( $location, 'location_city', true ) .', '. get_post_meta( $location, 'location_state') .' '.  get_post_meta( $location, 'location_zip', true ) . '<br/>';
		$data['physician_locations'][$location]['address'] .= get_post_meta( $location, 'location_phone', true );
		$data['physician_locations'][$location]['address'] .=  ( get_post_meta( $location, 'location_fax', true ) ? '<br/>Fax: ' . get_post_meta( $location, 'location_fax', true ) . '' : '');
		$data['physician_locations'][$location]['address'] .= ( get_post_meta( $location, 'location_email', true ) ? '<br/><a href="mailto:"' .get_post_meta( $location, 'location_email', true ) . '">' . get_post_meta( $location, 'location_email', true ) . '</a>' : ''); 
		$data['physician_locations'][$location]['address'] .=  ( get_post_meta( $location, 'location_web_name', true ) ? '<br/><a href="' . get_post_meta( $location, 'location_url', true ) . '">' . get_post_meta( $location, 'location_web_name', true ) . '</a>' : '');
		$map = get_post_meta( $location, 'location_map', true );
		$data['physician_locations'][$location]['address'] .='<br /><a href="https://www.google.com/maps/dir/Current+Location/' . $map['lat'] .',' .$map['lng'] .'" target="_blank">Directions</a> [Opens in New Window]</p>';
		$data['physician_locations'][$location]['map_marker'] = '<div class="marker" data-lat="'. $map['lat'] .'" data-lng="'. $map['lng'] .'" data-label="'. $i .'"></div>';
		$i++;
		//$data['location_link'][$location] = get_post_permalink( $location );
		//$data['location_title'] .= get_the_title( $location ) . ',';
	}
    $data['physician_affiliation'] = get_post_meta( $postId, 'physician_affiliation', true );
    $data['physician_appointment_link'] = get_post_meta( $postId, 'physician_appointment_link', true );
    $data['physician_primary_care'] = get_post_meta( $postId, 'physician_primary_care', true );
    $data['physician_refferal_required'] = get_post_meta( $postId, 'physician_refferal_required', true );
    $data['physician_accepting_patients'] = get_post_meta( $postId, 'physician_accepting_patients', true );
    $data['physician_second_opinion'] = get_post_meta( $postId, 'physician_second_opinion', true );
    $data['physician_patient_types'] = get_the_terms( $postId, 'patient_type' );
    $data['physician_npi'] = get_post_meta( $postId, 'physician_npi', true );
    $data['medical_specialties'] = get_the_terms( $postId, 'specialty' );
	$data['pphoto'] = wp_get_attachment_url( get_post_meta( $postId, 'person_photo', true ), 'file' );
	$data['physician_conditions'] = get_the_terms( $postId, 'condition' );
	$data['medical_procedures'] = get_the_terms( $postId, 'medical_procedures' );
	$data['physician_boards'] = get_post_meta( $postId, 'physician_boards', true );
	if( get_post_meta( $postId, 'physician_boards', true ) ) :
		for( $i = 0; $i < get_post_meta( $postId, 'physician_boards', true ); $i++ ){
			$data['physician_board_name'][$i] =  get_post_meta( $postId, 'physician_boards_' . $i .'_physician_board_name', true );
		}
	endif;
	//Academic Data
	$data['person_academic_title'] = get_post_meta( $postId, 'person_academic_title', true );
	$data['person_academic_college'] = get_the_terms( $postId, 'academic_colleges' );
	$data['person_academic_position'] = get_the_terms( $postId, 'academic_positions' );
	$data['person_academic_bio'] = get_post_meta( $postId, 'person_academic_bio', true );
	$data['person_academic_short_bio'] = wp_trim_words( get_post_meta( $postId, 'person_academic_short_bio', true ), 30, ' &hellip;' );
	$data['person_academic_office'] = get_post_meta( $postId, 'person_academic_office', true );
	$data['person_academic_map'] = get_post_meta( $postId, 'person_academic_map', true );
	$data['person_research_profiles_link'] = get_post_meta( $postId, 'person_research_profiles_link', true );
	$data['person_pubmed_author_id'] = get_post_meta( $postId, 'person_pubmed_author_id', true );
	$data['pubmed_author_number'] = get_post_meta( $postId, 'pubmed_author_number', true );
	if( get_post_meta( $postId, 'person_publications', true ) ) :
		$i = 0;
		foreach (get_post_meta( $postId, 'person_publications', true ) as $publication) {
			$data['person_publication'][$i] = get_post_meta( $postId, 'person_publications_' . $i .'_publication_pubmed_info', true );
			$i++;
		}
	endif;
	if( get_post_meta( $postId, 'person_contact_infomation', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_contact_infomation', true ); $i++ ){
			$data['office_full'][$i] = get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_type', true ) . ': ' . get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_value', true );
			$data['office_contact_type'][$i] = get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_type', true );
			$data['office_contact_value'][$i] =  get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_value', true );
		}
	endif;
	if( get_post_meta( $postId, 'person_academic_appointment', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_academic_appointment', true ); $i++ ){
			$data['person_academic_appointment'][$i] = get_post_meta( $postId, 'person_academic_appointment_' . $i .'_academic_title', true ) . ': ' . get_post_meta( $postId, 'person_academic_appointment_' . $i .'_academic_department', true );
			//$data['academic_title'][$i] = get_post_meta( $postId, 'person_academic_appointment_' . $i .'_academic_title', true );
			//$data['academic_department'][$i] =  get_post_meta( $postId, 'person_academic_appointment_' . $i .'_academic_department', true );
		}
	endif;
	if( get_post_meta( $postId, 'person_education', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_education', true ); $i++ ){
			$data['person_education'][$i] = get_post_meta( $postId, 'person_education_' . $i .'_person_education_type', true ) . ': ' . get_post_meta( $postId, 'person_education_' . $i .'_person_education_school', true ) . ' ' . get_post_meta( $postId, 'person_education_' . $i .'_person_education_description', true );
			//$data['person_education_type'][$i] = get_post_meta( $postId, 'person_education_' . $i .'_person_education_type', true );
			//$data['person_education_school'][$i] = get_post_meta( $postId, 'person_education_' . $i .'_person_education_school', true );
			//$data['person_education_description'][$i] =  get_post_meta( $postId, 'person_education_' . $i .'_person_education_description', true );
		}
	endif;
	//Research
	$data['person_researcher_bio'] = get_post_meta( $postId, 'person_researcher_bio', true );
	$data['person_research_interests'] = get_post_meta( $postId, 'person_research_interests', true );
	//Additional
	if( get_post_meta( $postId, 'person_awards', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_awards', true ); $i++ ){
			$data['person_awards'][$i] = get_post_meta( $postId, 'person_awards_' . $i .'_award_title', true ) . ' (' . get_post_meta( $postId, 'person_awards_' . $i .'_award_year', true ) . ') ' . get_post_meta( $postId, 'person_awards_' . $i .'_award_infor', true );
			//$data['award_year'][$i] = get_post_meta( $postId, 'person_awards_' . $i .'_award_year', true );
			//$data['award_title'][$i] = get_post_meta( $postId, 'person_awards_' . $i .'_award_title', true );
			//$data['award_infor'][$i] =  get_post_meta( $postId, 'person_awards_' . $i .'_award_infor', true );
		}
	endif;
	$data['person_additional_info'] = get_post_meta( $postId, 'person_additional_info', true );

    return $data;
}
add_action('rest_api_init', 'rest_api_person_meta');

// Add REST API query var filters
add_filter('rest_query_vars', 'people_add_rest_query_vars');
function people_add_rest_query_vars($query_vars) {
    $query_vars = array_merge( $query_vars, array('meta_key', 'meta_value', 'meta_compare') );
    return $query_vars;
}