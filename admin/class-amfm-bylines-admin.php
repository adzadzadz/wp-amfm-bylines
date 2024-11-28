<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://adzjo.online/adz
 * @since      1.0.0
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/admin
 * @author     Adrian T. Saycon <adzbite@gmail.com>
 */
class Amfm_Bylines_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Amfm_Bylines_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Amfm_Bylines_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', array(), '5.2.3', 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/amfm-bylines-admin.css', array(), random_int(000, 999), 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Amfm_Bylines_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Amfm_Bylines_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_media();
		wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.2.3', true);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/amfm-bylines-admin.js', array('jquery'), random_int(000, 999), false);
		wp_localize_script($this->plugin_name, 'amfmLocalize', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'pageSelectorNonce' => wp_create_nonce('amfm_page_selector_nonce'),
			'saveBylineNonce' => wp_create_nonce('amfm_save_byline_nonce'),
			'deleteBylineNonce' => wp_create_nonce('amfm_delete_byline_nonce')
		));
	}

	/**
	 * Register the admin menu.
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menu()
	{
		add_menu_page(
			__('AMFM Bylines', 'amfm-bylines'), // Page title
			__('AMFM Bylines', 'amfm-bylines'), // Menu title
			'manage_options', // Capability
			'amfm-bylines', // Menu slug
			array($this, 'display_admin_page'), // Callback function
			'dashicons-admin-generic', // Icon
			2 // Position
		);
	}

	/**
	 * Display the admin page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_page()
	{
		include plugin_dir_path(__FILE__) . 'partials/amfm-bylines-admin-display.php';
	}

	public function fetch_pages()
	{
		check_ajax_referer('amfm_page_selector_nonce', 'nonce');

		$pages = get_pages(array(
			'post_type' => 'page',
			'post_status' => 'publish'
		));

		$response = array();
		foreach ($pages as $page) {
			$response[] = array(
				'ID' => $page->ID,
				'title' => $page->post_title,
				'link' => get_permalink($page->ID)
			);
		}

		wp_send_json_success($response);
	}

	public function save_amfm_bylines()
	{
		if (!isset($_POST['nonce'])) {
			wp_send_json_error('Nonce not set', 403);
			wp_die();
		}

		if (!wp_verify_nonce($_POST['nonce'], 'amfm_save_byline_nonce')) {
			wp_send_json_error('Nonce verification failed', 403);
			wp_die();
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'amfm_bylines';

		parse_str($_POST['form_data'], $form_data);

		// Sanitize and collect the inputs
		$byline_id = isset($form_data['byline_id']) ? intval($form_data['byline_id']) : 0;
		$byline_name = sanitize_text_field($form_data['name']);
		$profile_image = esc_url_raw($form_data['image_url']);
		$description = sanitize_textarea_field($form_data['description']);
		$type = 'Default';
		$authorTag = sanitize_text_field($form_data['authorTag']);
		$editorTag = sanitize_text_field($form_data['editorTag']);
		$reviewedByTag = sanitize_text_field($form_data['reviewedByTag']);

		// Collect other inputs
		$other_data = array(
			'page_url' => esc_url_raw($form_data['page_url']),
			'honorificSuffix' => sanitize_text_field($form_data['honorificSuffix']),
			'jobTitle' => sanitize_text_field($form_data['jobTitle']),
			'hasCredential' => [
				'@type' => sanitize_text_field($form_data['credentialType']),
				'name' => sanitize_text_field($form_data['credentialName']),
			],
			'worksFor' => [
				'@type' => sanitize_text_field($form_data['worksForType']),
				'name' => sanitize_text_field($form_data['worksForName']),
			],
			'authorTag' => sanitize_text_field($form_data['authorTag']),
			'editorTag' => sanitize_text_field($form_data['editorTag']),
			'reviewedByTag' => sanitize_text_field($form_data['reviewedByTag']),
		);

		// Convert other inputs to JSON
		$other_data_json = wp_json_encode($other_data);

		if ($byline_id > 0) {
			// Update existing byline
			$wpdb->update(
				$table_name,
				array(
					'byline_name' => $byline_name,
					'profile_image' => $profile_image,
					'description' => $description,
					'data' => $other_data_json,
					'type' => $type,
					'authorTag' => $authorTag,
					'editorTag' => $editorTag,
					'reviewedByTag' => $reviewedByTag,
				),
				array('id' => $byline_id),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				),
				array('%d')
			);
		} else {
			// Insert new byline
			$wpdb->insert(
				$table_name,
				array(
					'byline_name' => $byline_name,
					'profile_image' => $profile_image,
					'description' => $description,
					'data' => $other_data_json,
					'type' => $type,
					'authorTag' => $authorTag,
					'editorTag' => $editorTag,
					'reviewedByTag' => $reviewedByTag,
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				)
			);
		}

		// Check for errors
		if ($wpdb->last_error) {
			wp_send_json_error('Error saving data: ' . $wpdb->last_error, 403);
		} else {
			// Store all tags in their respective categories
			$tags = array(
				'author_tags' => array($other_data['authorTag']),
				'editor_tags' => array($other_data['editorTag']),
				'reviewed_by_tags' => array($other_data['reviewedByTag'])
			);

			// Filter out empty tags
			$tags['author_tags'] = array_filter($tags['author_tags']);
			$tags['editor_tags'] = array_filter($tags['editor_tags']);
			$tags['reviewed_by_tags'] = array_filter($tags['reviewed_by_tags']);

			// Get existing tags from the option
			$existing_tags = get_option('amfm_bylines_tags', array(
				'author_tags' => array(),
				'editor_tags' => array(),
				'reviewed_by_tags' => array()
			));

			if (!is_array($existing_tags) || !isset($existing_tags['author_tags']) || !isset($existing_tags['editor_tags']) || !isset($existing_tags['reviewed_by_tags'])) {
				$existing_tags = array(
					'author_tags' => array(),
					'editor_tags' => array(),
					'reviewed_by_tags' => array()
				);
			}

			// Merge new tags with existing tags
			$existing_tags['author_tags'] = array_unique(array_merge($existing_tags['author_tags'], $tags['author_tags']));
			$existing_tags['editor_tags'] = array_unique(array_merge($existing_tags['editor_tags'], $tags['editor_tags']));
			$existing_tags['reviewed_by_tags'] = array_unique(array_merge($existing_tags['reviewed_by_tags'], $tags['reviewed_by_tags']));

			// Update the option with the merged tags
			update_option('amfm_bylines_tags', $existing_tags);

			// Return success message
			wp_send_json_success('Data saved successfully!');
		}
	}

	public function delete_amfm_byline()
	{
		check_ajax_referer('amfm_delete_byline_nonce', 'nonce');

		global $wpdb;
		$table_name = $wpdb->prefix . 'amfm_bylines';
		$id = intval($_POST['id']);

		$deleted = $wpdb->delete($table_name, array('id' => $id), array('%d'));

		if ($deleted) {
			wp_send_json_success();
		} else {
			wp_send_json_error('Error deleting byline.');
		}
	}
}
