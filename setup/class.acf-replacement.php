<?php
/**
 * Retrieves all post meta data according to the structure in the $config
 * array.
 *
 * Provides a convenient and more performant alternative to ACF's
 * `get_field()`.
 *
 * This function is especially useful when working with ACF repeater fields and
 * flexible content layouts.
 *
 * @link    https://www.timjensen.us/acf-get-field-alternative/
 *
 * @version 1.2.2
 *
 * @param integer $post_id Required. Post ID.
 * @param array   $config  Required. An array that represents the structure of
 *                         the custom fields. Follows the same format as the
 *                         ACF export field groups array.
 * @return array
 */
function get_all_custom_field_meta( $post_id, array $config ) {
	$results = array();
	foreach ( $config as $field ) {
		if ( empty( $field['name'] ) ) {
			continue;
		}
		$meta_key = $field['name'];
		if ( isset( $field['meta_key_prefix'] ) ) {
			$meta_key = $field['meta_key_prefix'] . $meta_key;
		}
		$field_value = get_post_meta( $post_id, $meta_key, true );
		if ( isset( $field['layouts'] ) ) { // We're dealing with flexible content layouts.
			// Build a keyed array of possible layout types.
			$layout_types = [];
			foreach ( $field['layouts'] as $key => $layout_type ) {
				$layout_types[ $layout_type['name'] ] = $layout_type;
			}
			foreach ( $field_value as $key => $current_layout_type ) {
				$new_config = $layout_types[ $current_layout_type ]['sub_fields'];
				foreach ( $new_config as &$field_config ) {
					$field_config['meta_key_prefix'] = $meta_key . "_{$key}_";
				}
				$results[ $field['name'] ][] = array_merge(
					[
						'acf_fc_layout' => $current_layout_type,
					],
					get_all_custom_field_meta( $post_id, $new_config )
				);
			}
		} elseif ( isset( $field['sub_fields'] ) ) { // We're dealing with repeater fields.
			for ( $i = 0; $i < $field_value; $i ++ ) {
				$new_config = $field['sub_fields'];
				foreach ( $new_config as &$field_config ) {
					$field_config['meta_key_prefix'] = $meta_key . "_{$i}_";
				}
				$results[ $field['name'] ][] = get_all_custom_field_meta( $post_id, $new_config );
			}
		} else {
			$results[ $field['name'] ] = $field_value;
		} // End if().
	} // End foreach().
	return $results;
}

$config = array(
		array (
			'name' => 'profile_type',
		),
		array (
			'name' => 'person_first_name',
		),
		array (
			'name' => 'person_middle_name',
		),
		array (
			'name' => 'person_last_name',
		),
		array (
			'name' => 'person_degree',
		),
		array (
			'name' => 'person_photo',
		),
		array (
			'name' => 'physician_title',
			'type' => 'text',
			'instructions' => 'Main Title',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'name' => 'physician_clinical_bio',
		),
		array (
			'name' => 'physician_short_clinical_bio',
		),
		array (
			'name' => 'physician_gender',
		),
		array (
			'name' => 'physician_youtube_link',
		),
		array (
			'name' => 'physician_languages',
		),
		array (
			'name' => 'physician_locations',
		),
		array (
			'name' => 'physician_affiliation',
		),
		array (
			'name' => 'physician_appointment_link',
		),
		array (
			'name' => 'physician_primary_care',
		),
		array (
			'name' => 'physician_refferal_required',
		),
		array (
			'name' => 'physician_accepting_patients',
		),
		array (
			'name' => 'physician_second_opinion',
		),
		array (
			'name' => 'physician_patient_types',
		),
		array (
			'name' => 'medical_specialties',
		),
		array (
			'name' => 'physician_conditions',
		),
		array (
			'name' => 'medical_procedures',
		),
		array (
			'name' => 'medical_terms',
		),
		array (
			'name' => 'physician_pid',
		),
		array (
			'name' => 'physician_npi',
		),
		array (
			'name' => 'person_academic_title',
		),
		array (
			'name' => 'person_academic_college',
		),
		array (
			'name' => 'person_academic_position',
		),
		array (
			'name' => 'person_academic_bio',
		),
		array (
			'name' => 'person_academic_short_bio',
		),
		array (
			'name' => 'person_academic_office',
		),
		array (
			'name' => 'person_academic_map',
		),
		array (
			'name' => 'person_contact_infomation',
			'sub_fields' => array (
				array (
					'name' => 'office_contact_type',
				),
				array (
					'name' => 'office_contact_value',
				),
			),
		),
		array (
			'name' => 'person_academic_appointment',
			'sub_fields' => array (
				array (
					'name' => 'academic_title',
				),
				array (
					'name' => 'academic_department',
				),
			),
		),
		array (
			'name' => 'person_education',
			'sub_fields' => array (
				array (
					'name' => 'person_education_type',
				),
				array (
					'name' => 'person_education_school',
				),
				array (
					'name' => 'person_education_description',
				),
			),
		),
		array (
			'name' => 'physician_boards',
			'sub_fields' => array (
				array (
					'name' => 'physician_board_name',
				),
			),
		),
		array (
			'name' => 'person_research_profiles_link',
		),
		array (
		),
		array (
			'name' => 'pubmed_author_number',
		),
		array (
			'name' => 'person_publications',
			'layouts' => array (
				array (
					'name' => 'pubmed',
					'sub_fields' => array (
						array (
							'name' => 'publication_pmid',
						),
						array (
							'name' => 'publication_pubmed_info',
						),
					),
				),
				array (
					'name' => 'book',
					'sub_fields' => array (
						array (
							'name' => 'book_title',
						),
						array (
							'name' => 'book_authors',
						),
						array (
							'name' => 'book_year',
						),
						array (
							'name' => 'book_edition',
						),
						array (
							'name' => 'book_publisher',
						),
						array (
							'name' => 'book_publisher_location',
						),
						array (
							'name' => 'book_pmid',
						),
						array (
							'name' => 'book_pmcid',
						),
					),
				),
				array (
					'name' => 'chapter',
					'sub_fields' => array (
						array (
							'name' => 'chapter_title',
						),
						array (
							'name' => 'chapter_book_title',
						),
						array (
							'name' => 'chapter_authors',
						),
						array (
							'name' => 'chapter_book_editors',
						),
						array (
							'name' => 'chapter_book_year',
						),
						array (
							'name' => 'chapter_book_edition',
						),
						array (
							'name' => 'chapter_book_publisher',
						),
						array (
							'name' => 'chapter_book_publisher_location',
						),
						array (
							'name' => 'chapter_pmid',
						),
						array (
							'name' => 'chapter_pmcid',
						),
					),
				),
				array (
					'name' => 'journal',
					'sub_fields' => array (
						array (
							'name' => 'journal_authors',
						),
						array (
							'name' => 'journal_article_title',
						),
						array (
							'name' => 'journal_name',
						),
						array (
							'name' => 'journal_volume',
						),
						array (
							'name' => 'journal_issue',
						),
						array (
							'name' => 'journal_year',
						),
						array (
							'name' => 'journal_pages',
						),
						array (
							'name' => 'journal_url',
						),
						array (
							'name' => 'journal_pmid',
						),
						array (
							'name' => 'journal_pmcid',
						),
					),
				),
				array (
					'name' => 'magazine',
					'sub_fields' => array (
						array (
							'name' => 'magazine_authors',
						),
						array (
							'name' => 'magazine_article_title',
						),
						array (
							'name' => 'magazine_title',
						),
						array (
							'name' => 'magazine_month',
						),
						array (
							'name' => 'magazine_day',
						),
						array (
							'name' => 'magazine_year',
						),
						array (
							'name' => 'magazine_pages',
						),
						array (
							'name' => 'magazine_pmid',
						),
						array (
							'name' => 'magazine_pmcid',
						),
					),
				),
				array (
					'name' => 'newspaper',
					'sub_fields' => array (
						array (
							'name' => 'newspaper_authors',
						),
						array (
							'name' => 'newspaper_date',
						),
						array (
							'name' => 'newspaper_article_title',
						),
						array (
							'name' => 'newspaper_title',
						),
						array (
							'name' => 'newspaper_pages',
						),
						array (
							'name' => 'newspaper_pmid',
						),
						array (
							'name' => 'newspaper_pmcid',
						),
					),
				),
				array (
					'name' => 'website',
					'sub_fields' => array (
						array (
							'name' => 'website_authors',
						),
						array (
							'name' => 'website_date',
						),
						array (
							'name' => 'website_article_title',
						),
						array (
							'name' => 'website_url',
						),
					),
				),
			),
		),
		array (
			'name' => 'person_researcher_bio',
		),
		array (
			'name' => 'person_research_interests',
		),
		array (
			'name' => 'person_awards',
			'sub_fields' => array (
				array (
					'name' => 'award_year',
				),
				array (
					'name' => 'award_title',
				),
				array (
					'name' => 'award_infor',
				),
			),
		),
		array (
			'name' => 'person_additional_info',
		),
	),
);

