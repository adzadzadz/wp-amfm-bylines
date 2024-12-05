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
		$this->manage_bylines_schema();
		$this->run_shortcodes();
	}

	public function manage_bylines_schema()
	{
		add_filter('rank_math/json_ld', function ($data, $jsonld) {
			if (is_singular('post') || is_page()) {

				// get all bylines from database
				global $wpdb;
				$table_name = $wpdb->prefix . 'amfm_bylines';
				$bylines = $wpdb->get_results("SELECT * FROM $table_name");

				// Build the author array and should contain bylines with author tags
				$author_schema = array();
				$editor_schema = array();
				$reviewedBy_schema = array();

				foreach ($bylines as $byline) {
					$byline_data = json_decode($byline->data, true);

					if (has_tag($byline->authorTag, get_queried_object_id())) {
						$author_schema = array(
							'@type' => 'Person',
							'url' => $byline_data['page_url'],
							'image' => $byline->profile_image,
							'name' => str_replace("'", "", str_replace("\\", "", $byline->byline_name)),
							'honorificSuffix' => $byline_data['honorificSuffix'],
							'description' => str_replace("'", "", str_replace("\\", "", $byline->description)),
							'jobTitle' => $byline_data['jobTitle'],
							'hasCredential' => array(
								'@type' => $byline_data['hasCredential']['@type'],
								'name' => $byline_data['hasCredential']['name']
							),
							'worksFor' => array(
								// '@type' => $byline_data['worksFor']['@type'],
								'@type' => 'Organization',
								'name' => $byline_data['worksFor']['name']
							)
						);
					}

					if (has_tag($byline->editorTag, get_queried_object_id())) {
						$editor_schema = array(
							'@type' => 'Person',
							'url' => $byline_data['page_url'],
							'image' => $byline->profile_image,
							'name' => str_replace("'", "", str_replace("\\", "", $byline->byline_name)),
							'honorificSuffix' => $byline_data['honorificSuffix'],
							'description' => str_replace("'", "", str_replace("\\", "", $byline->description)),
							'jobTitle' => $byline_data['jobTitle'],
							'hasCredential' => array(
								'@type' => $byline_data['hasCredential']['@type'],
								'name' => $byline_data['hasCredential']['name']
							),
							'worksFor' => array(
								// '@type' => $byline_data['worksFor']['@type'],
								'@type' => 'Organization',
								'name' => $byline_data['worksFor']['name']
							)
						);
					}

					if (has_tag($byline->reviewedByTag, get_queried_object_id())) {
						$reviewedBy_schema = array(
							'@type' => 'Person',
							'url' => $byline_data['page_url'],
							'image' => $byline->profile_image,
							'name' => str_replace("'", "", str_replace("\\", "", $byline->byline_name)),
							'honorificSuffix' => $byline_data['honorificSuffix'],
							'description' => str_replace("'", "", str_replace("\\", "", $byline->description)),
							'jobTitle' => $byline_data['jobTitle'],
							'hasCredential' => array(
								'@type' => $byline_data['hasCredential']['@type'],
								'name' => $byline_data['hasCredential']['name']
							),
							'worksFor' => array(
								// '@type' => $byline_data['worksFor']['@type'],
								'@type' => 'Organization',
								'name' => $byline_data['worksFor']['name']
							)
						);
					}
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
						if (!empty($reviewedBy_schema) && isset($data[$key]['@type']) && $data[$key]['@type'] === 'MedicalWebPage') {
							$data[$key]['reviewedBy'] = $reviewedBy_schema;
						}
					}
				}

				return $data;
			}
		}, 99, 2);
	}

	/**
	 * Get the byline data from the database
	 * 
	 * @param string $type
	 * @return object|false
	 */
	private function get_byline($type)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'amfm_bylines';

		$tags = get_the_tags();

		$is_medical_webpage = has_tag('medicalwebpage', get_queried_object_id());

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

		return false;
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
	}
}
