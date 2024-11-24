<?php
function theme_create_custom_post_type()
{

	// search-replace CPT to a custom post type name

	$labels = array(
		'name'               => 'CPT NAME',
		'singular_name'      => 'CPT NAME',
		'menu_name'          => 'CPT NAME',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New CPT NAME',
		'edit_item'          => 'Edit CPT NAME',
		'new_item'           => 'New CPT NAME',
		'view_item'          => 'View CPT NAME',
		'search_items'       => 'Search CPT NAME',
		'not_found'          => 'No CPT NAME found',
		'not_found_in_trash' => 'No CPT NAME found in Trash',
		'parent_item_colon'  => '',
		'all_items'          => 'All CPT NAME'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'menu_icon'             => 'dashicons-universal-access-alt',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array('title', 'thumbnail', 'custom-fields', 'author', 'editor')
	);

	register_post_type('cpt', $args);
}
// add_action('init', 'theme_create_custom_post_type');


function theme_create_custom_taxonomy()
{
	$labels = array(
		'name'              => 'Taxonomy Name',
		'singular_name'     => 'Taxonomy Name',
		'search_items'      => 'Search Taxonomy Name',
		'all_items'         => 'All Taxonomy Name',
		'parent_item'       => 'Parent Taxonomy Name',
		'parent_item_colon' => 'Parent Taxonomy Name:',
		'edit_item'         => 'Edit Taxonomy Name',
		'update_item'       => 'Update Taxonomy Name',
		'add_new_item'      => 'Add New Taxonomy Name',
		'new_item_name'     => 'New Taxonomy Name Name',
		'menu_name'         => 'Taxonomy Name',
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		// 'rewrite'           => array('slug' => 'resource-tag'),
	);

	register_taxonomy('taxonomy_name', array('cpt'), $args);
}
// add_action('init', 'theme_create_custom_taxonomy');