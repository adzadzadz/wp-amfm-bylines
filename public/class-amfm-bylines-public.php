<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://adzjo.online/adz
 * @since      1.0.0
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/public
 * @author     Adrian T. Saycon <adzbite@gmail.com>
 */
class Amfm_Bylines_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		// wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/amfm-bylines-public.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/amfm-bylines-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		// wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/amfm-bylines-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/amfm-bylines-public.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'amfmLocalize', array(
			'author' => $this->is_tagged('authored-by'),
			'editor' => $this->is_tagged('edited-by'),
			'reviewedBy' => $this->is_tagged('medically-reviewed-by') && $this->is_tagged('medicalwebpage', $precise = true),
		));
	}

	public function init()
	{
		// check if option amfm_use_staff_cpt is enabled or not
		$use_staff_cpt = get_option('amfm_use_staff_cpt');

		if ($use_staff_cpt) {
			$this->manage_bylines_schema_with_staff_cpt();
		} else {
			$this->manage_bylines_schema();
		}
		$this->run_shortcodes();
	}

	/**
	 * Manage bylines schema with staff cpt
	 * Returned data model from cpt and db are very different. Need to handle them differently as well.
	 */
	public function manage_bylines_schema_with_staff_cpt()
	{
		add_filter('rank_math/json_ld', function ($data, $jsonld) {
			if (is_singular('post') || is_page()) {

				// get this post/page author, editor, and reviewedBy tags
				$author_byline = $this->get_byline('author', true);
				$editor_byline = $this->get_byline('editor', true);
				$reviewer_byline = $this->get_byline('reviewedBy', true);
			}
		}, 99, 2);
	}

	public function manage_bylines_schema()
	{
		add_filter('rank_math/json_ld', function ($data, $jsonld) {
			if (is_singular('post') || is_page()) {

				// Get the byline data
				$author_byline = $this->get_byline('author');
				$editor_byline = $this->get_byline('editor');
				$reviewer_byline = $this->get_byline('reviewedBy');

				// Build the author array and should contain bylines with author tags
				$author_schema = array();
				$editor_schema = array();
				$reviewer_schema = array();

				if ($author_byline) {
					$author_data = json_decode($author_byline->data, true);
					$author_schema = array(
						'@type' => 'Person',
						'url' => $author_data['page_url'],
						'image' => $author_byline->profile_image,
						'name' => str_replace("'", "", str_replace("\\", "", $author_byline->byline_name)),
						'honorificSuffix' => $author_data['honorificSuffix'],
						'description' => str_replace("'", "", str_replace("\\", "", $author_byline->description)),
						'jobTitle' => $author_data['jobTitle'],
						'hasCredential' => array(
							'@type' => $author_data['hasCredential']['@type'],
							'name' => $author_data['hasCredential']['name']
						),
						'worksFor' => array(
							// '@type' => $author_data['worksFor']['@type'],
							'@type' => 'Organization',
							'name' => $author_data['worksFor']['name']
						)
					);
				}

				if ($editor_byline) {
					$editor_data = json_decode($editor_byline->data, true);
					$editor_schema = array(
						'@type' => 'Person',
						'url' => $editor_data['page_url'],
						'image' => $editor_byline->profile_image,
						'name' => str_replace("'", "", str_replace("\\", "", $editor_byline->byline_name)),
						'honorificSuffix' => $editor_data['honorificSuffix'],
						'description' => str_replace("'", "", str_replace("\\", "", $editor_byline->description)),
						'jobTitle' => $editor_data['jobTitle'],
						'hasCredential' => array(
							'@type' => $editor_data['hasCredential']['@type'],
							'name' => $editor_data['hasCredential']['name']
						),
						'worksFor' => array(
							// '@type' => $editor_data['worksFor']['@type'],
							'@type' => 'Organization',
							'name' => $editor_data['worksFor']['name']
						)
					);
				}

				if ($reviewer_byline) {
					$reviewer_data = json_decode($reviewer_byline->data, true);
					$reviewer_schema = array(
						'@type' => 'Person',
						'url' => $reviewer_data['page_url'],
						'image' => $reviewer_byline->profile_image,
						'name' => str_replace("'", "", str_replace("\\", "", $reviewer_byline->byline_name)),
						'honorificSuffix' => $reviewer_data['honorificSuffix'],
						'description' => str_replace("'", "", str_replace("\\", "", $reviewer_byline->description)),
						'jobTitle' => $reviewer_data['jobTitle'],
						'hasCredential' => array(
							'@type' => $reviewer_data['hasCredential']['@type'],
							'name' => $reviewer_data['hasCredential']['name']
						),
						'worksFor' => array(
							// '@type' => $reviewer_data['worksFor']['@type'],
							'@type' => 'Organization',
							'name' => $reviewer_data['worksFor']['name']
						)
					);
				}

				foreach ($data as $key => $schema) {
					if (isset($schema['@type']) && ($schema['@type'] === 'Article' || $schema['@type'] === 'MedicalWebPage')) {
						// Remove existing author, editor, and reviewedBy if they exist
						if (isset($data[$key]['author'])) {
							unset($data[$key]['author']);
						}
						if (isset($data[$key]['editor'])) {
							unset($data[$key]['editor']);
						}
						if (isset($data[$key]['reviewedBy'])) {
							unset($data[$key]['reviewedBy']);
						}

						// force schema type to MedicalWebPage if the post is tagged with medicalwebpage
						$is_medical_webpage = has_tag('medicalwebpage', get_queried_object_id());
						if ($is_medical_webpage) {
							$data[$key]['@type'] = 'MedicalWebPage';
						}

						// Add author, editor, and reviewedBy in the desired order
						if (!empty($author_schema)) {
							$data[$key]['author'] = $author_schema;
						}
						if (!empty($editor_schema)) {
							$data[$key]['editor'] = $editor_schema;
						}
						if (!empty($reviewer_schema) && isset($data[$key]['@type']) && $data[$key]['@type'] === 'MedicalWebPage') {
							$data[$key]['reviewedBy'] = $reviewer_schema;
						}
					}
				}

				return $data;
			}
		}, 99, 2);
	}

	/**
	 * Get the byline data from the database
	 * Allows using "Staff CPT" if available
	 * 
	 * @param string $type
	 * @param boolean $use_cpt
	 * @return object|false
	 */
	private function get_byline($type, $use_cpt = false)
	{
		$tags = get_the_tags();

		$is_medical_webpage = has_tag('medicalwebpage', get_queried_object_id());

		if ($use_cpt) {
			if ($tags) {
				foreach ($tags as $tag) {
					if (strpos($tag->slug, 'authored-by') === 0 && $type === 'author') {
						return $this->get_staff($tag->slug);
					}

					if (strpos($tag->slug, 'edited-by') === 0 && $type === 'editor') {
						return $this->get_staff($tag->slug);
					}

					if ($is_medical_webpage && strpos($tag->slug, 'medically-reviewed-by') === 0 && $type === 'reviewedBy') {
						return $this->get_staff($tag->slug);
					}
				}
			}
		} else {
			global $wpdb;
			$table_name = $wpdb->prefix . 'amfm_bylines';

			if ($tags) {
				foreach ($tags as $tag) {
					if (strpos($tag->slug, 'authored-by') === 0 && $type === 'author') {
						return $wpdb->get_row("SELECT * FROM $table_name WHERE authorTag = '$tag->slug'");
					}

					if (strpos($tag->slug, 'edited-by') === 0 && $type === 'editor') {
						return $wpdb->get_row("SELECT * FROM $table_name WHERE editorTag = '$tag->slug'");
					}

					if ($is_medical_webpage && strpos($tag->slug, 'medically-reviewed-by') === 0 && $type === 'reviewedBy') {
						return $wpdb->get_row("SELECT * FROM $table_name WHERE reviewedByTag = '$tag->slug'");
					}
				}
			}
		}

		return false;
	}

	private function get_staff($tag)
	{
		// Get cpt "Staff" post data by given tag
		$staff = get_posts(array(
			'post_type' => 'staff',
			'numberposts' => 1,
			'tag' => $tag
		));

		if (empty($staff)) {
			return false;
		}
		return $staff;
	}

	/**
	 * Get the byline url
	 */
	private function get_byline_url($type)
	{
		$byline = $this->get_byline($type);
		if (!$byline)
			return "No byline found";

		$byline_data = json_decode($byline->data, true);

		return preg_replace('/^https?:\/\//', '', $byline_data['page_url']);
	}

	/**
	 * Check if the post is tagged with the given tag
	 * 
	 * @param string $tag
	 * @param string $type
	 * @return boolean
	 */
	private function is_tagged($tag, $precise = false)
	{
		if ($precise) {
			return has_tag($tag, get_queried_object_id());
		}

		$tags = get_the_tags();

		if (!$precise && $tags) {
			foreach ($tags as $t) {
				if (strpos($t->slug, $tag) === 0) {
					return true;
				}
			}
		}

		return false;
	}

	// create a shortcode to display bylines
	public function run_shortcodes()
	{
		include plugin_dir_path(__FILE__) . 'partials/shortcodes/info.php';

		if (class_exists('ACF')) {
			include plugin_dir_path(__FILE__) . 'partials/shortcodes/acf.php';
		}
	}
}
