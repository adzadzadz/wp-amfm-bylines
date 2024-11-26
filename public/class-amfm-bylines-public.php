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
class Amfm_Bylines_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/amfm-bylines-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/amfm-bylines-public.js', array( 'jquery' ), $this->version, false );

	}

	public function manage_bylines_schema()
	{
		add_filter('rank_math/json_ld', function ($data, $jsonld) {
			if (is_singular('post')) {

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

					if (has_tag($byline_data['authorTag'])) {
						$author_schema = array(
							'@type' => 'Person',
							'url' => $byline_data['page_url'],
							'image' => $byline->profile_image,
							'name' => $byline->byline_name,
							'honorificSuffix' => $byline_data['honorificSuffix'],
							'description' => $byline->description,
							'jobTitle' => $byline_data['jobTitle'],
							'hasCredential' => array(
								'@type' => $byline_data['hasCredential']['@type'],
								'name' => $byline_data['hasCredential']['name']
							),
							'worksFor' => array(
								'@type' => $byline_data['worksFor']['@type'],
								'name' => $byline_data['worksFor']['name']
							)
						);
					}

					if (has_tag($byline_data['editorTag'])) {
						$editor_schema = array(
							'@type' => 'Person',
							'url' => $byline_data['page_url'],
							'image' => $byline->profile_image,
							'name' => $byline->byline_name,
							'honorificSuffix' => $byline_data['honorificSuffix'],
							'description' => $byline->description,
							'jobTitle' => $byline_data['jobTitle'],
							'hasCredential' => array(
								'@type' => $byline_data['hasCredential']['@type'],
								'name' => $byline_data['hasCredential']['name']
							),
							'worksFor' => array(
								'@type' => $byline_data['worksFor']['@type'],
								'name' => $byline_data['worksFor']['name']
							)
						);
					}
				}

				foreach ($data as $key => $schema) {
					if (isset($schema['@type']) && ($schema['@type'] === 'Article' || $schema['@type'] === 'MedicalWebPage')) {
						if (isset($data[$key]['author'])) {
							unset($data[$key]['author']);
						}

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

}
