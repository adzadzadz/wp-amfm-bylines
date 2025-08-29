<?php

/**
 * The shortcode parser class.
 *
 * Handles parsing of shortcodes in custom schema JSON.
 *
 * @link       https://adzjo.online/adz
 * @since      3.1.0
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/public/schema
 */

class Amfm_Shortcode_Parser {

    /**
     * The plugin name.
     *
     * @since    3.1.0
     * @access   private
     * @var      string    $plugin_name    The plugin name.
     */
    private $plugin_name;

    /**
     * The plugin version.
     *
     * @since    3.1.0
     * @access   private
     * @var      string    $version    The plugin version.
     */
    private $version;

    /**
     * The location handler.
     *
     * @since    3.1.0
     * @access   private
     * @var      Amfm_Location_Handler    $location_handler    The location handler.
     */
    private $location_handler;

    /**
     * Initialize the class and set its properties.
     *
     * @since    3.1.0
     * @param    string                   $plugin_name        The plugin name.
     * @param    string                   $version            The plugin version.
     * @param    Amfm_Location_Handler    $location_handler   The location handler.
     */
    public function __construct($plugin_name, $version, $location_handler) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->location_handler = $location_handler;
    }

    /**
     * Parse shortcodes in schema JSON.
     *
     * @since    3.1.0
     * @param    string    $schema_json    The schema JSON with shortcodes.
     * @return   mixed                     The parsed schema array or false on error.
     */
    public function parse($schema_json) {
        if (empty($schema_json)) {
            return false;
        }

        $parsed_json = $this->parse_shortcodes($schema_json);
        
        $schema = json_decode($parsed_json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('AMFM Schema Parser: JSON decode error - ' . json_last_error_msg());
            return false;
        }
        
        return $schema;
    }

    /**
     * Parse shortcodes in schema JSON and return as JSON string.
     *
     * @since    3.1.0
     * @param    string    $schema_json    The schema JSON with shortcodes.
     * @return   string                    The parsed schema JSON string or empty string on error.
     */
    public function parse_to_json($schema_json) {
        if (empty($schema_json)) {
            return '';
        }

        return $this->parse_shortcodes($schema_json);
    }

    /**
     * Parse shortcodes in the JSON string.
     *
     * @since    3.1.0
     * @param    string    $json_string    The JSON string with shortcodes.
     * @return   string                    The JSON string with shortcodes replaced.
     */
    private function parse_shortcodes($json_string) {
        $pattern = '/{{([^}]+)}}/';
        
        return preg_replace_callback($pattern, array($this, 'process_shortcode'), $json_string);
    }

    /**
     * Process individual shortcode.
     *
     * @since    3.1.0
     * @param    array    $matches    Regex matches.
     * @return   string               The replacement JSON.
     */
    private function process_shortcode($matches) {
        $shortcode_content = trim($matches[1]);
        
        $parts = $this->parse_shortcode_attributes($shortcode_content);
        
        $shortcode_type = $parts['type'];
        $attributes = $parts['attributes'];
        
        switch ($shortcode_type) {
            case 'location':
                return $this->process_location_shortcode($attributes);
            
            case 'breadcrumbs':
                return $this->process_breadcrumbs_shortcode($attributes);
            
            default:
                error_log('AMFM Schema Parser: Unknown shortcode type - ' . $shortcode_type);
                return '""';
        }
    }

    /**
     * Parse shortcode attributes.
     *
     * @since    3.1.0
     * @param    string    $shortcode_content    The shortcode content.
     * @return   array                           Array with 'type' and 'attributes'.
     */
    private function parse_shortcode_attributes($shortcode_content) {
        $parts = explode(' ', $shortcode_content, 2);
        $type = $parts[0];
        $attributes = array();
        
        if (isset($parts[1])) {
            $attr_string = $parts[1];
            
            preg_match_all('/(\w+)=["\']([^"\']*)["\']/', $attr_string, $matches, PREG_SET_ORDER);
            
            foreach ($matches as $match) {
                $attributes[$match[1]] = $match[2];
            }
        }
        
        return array(
            'type' => $type,
            'attributes' => $attributes
        );
    }

    /**
     * Process location shortcode.
     *
     * @since    3.1.0
     * @param    array    $attributes    Shortcode attributes.
     * @return   string                  The JSON for location schema.
     */
    private function process_location_shortcode($attributes) {
        $brand = isset($attributes['brand']) ? $attributes['brand'] : null;
        $region = isset($attributes['region']) ? $attributes['region'] : null;
        $state = isset($attributes['state']) ? $attributes['state'] : null;
        
        $filters = array();
        if ($brand) $filters['brand'] = $brand;
        if ($region) $filters['region'] = $region;
        if ($state) $filters['state'] = $state;
        
        $location_schema = $this->location_handler->generate_location_schema($filters);
        
        if ($location_schema) {
            return wp_json_encode($location_schema, JSON_UNESCAPED_SLASHES);
        }
        
        return '""';
    }

    /**
     * Process breadcrumbs shortcode.
     *
     * @since    3.1.0
     * @param    array    $attributes    Shortcode attributes.
     * @return   string                  The JSON for breadcrumbs schema.
     */
    private function process_breadcrumbs_shortcode($attributes) {
        return $this->generate_breadcrumbs_schema();
    }

    /**
     * Generate breadcrumbs schema similar to byline module.
     *
     * @since    3.1.0
     * @return   string    The JSON for breadcrumbs schema.
     */
    private function generate_breadcrumbs_schema() {
        global $post;
        
        if (!$post) {
            return '""';
        }

        $breadcrumbs = array(
            '@type' => 'BreadcrumbList',
            '@id' => get_permalink($post->ID) . '#breadcrumbs',
            'itemListElement' => array()
        );

        $breadcrumb_items = array();
        
        $breadcrumb_items[] = array(
            '@type' => 'ListItem',
            'position' => 1,
            'name' => get_bloginfo('name'),
            'item' => home_url('/')
        );

        if ($post->post_type === 'post') {
            $categories = get_the_category($post->ID);
            if (!empty($categories)) {
                $main_category = $categories[0];
                $breadcrumb_items[] = array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $main_category->name,
                    'item' => get_category_link($main_category->term_id)
                );
            }
        } elseif ($post->post_type === 'page') {
            if ($post->post_parent) {
                $parent_pages = array();
                $parent_id = $post->post_parent;
                
                while ($parent_id) {
                    $parent = get_post($parent_id);
                    if ($parent) {
                        array_unshift($parent_pages, $parent);
                        $parent_id = $parent->post_parent;
                    } else {
                        break;
                    }
                }
                
                $position = 2;
                foreach ($parent_pages as $parent_page) {
                    $breadcrumb_items[] = array(
                        '@type' => 'ListItem',
                        'position' => $position++,
                        'name' => $parent_page->post_title,
                        'item' => get_permalink($parent_page->ID)
                    );
                }
            }
        }

        $final_position = count($breadcrumb_items) + 1;
        $breadcrumb_items[] = array(
            '@type' => 'ListItem',
            'position' => $final_position,
            'name' => get_the_title($post->ID),
            'item' => get_permalink($post->ID)
        );

        $breadcrumbs['itemListElement'] = $breadcrumb_items;
        
        return wp_json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get supported shortcode types.
     *
     * @since    3.1.0
     * @return   array    Array of supported shortcode types.
     */
    public function get_supported_shortcodes() {
        return array(
            'location' => array(
                'description' => 'Generates medical organization and clinic location schema',
                'attributes' => array(
                    'brand' => 'Filter by brand shortname (e.g., "mc")',
                    'region' => 'Filter by region (e.g., "northwest")',
                    'state' => 'Filter by state (e.g., "CA", "WA")'
                ),
                'examples' => array(
                    '{{location}}' => 'All locations',
                    '{{location brand="mc"}}' => 'All Mission Connection locations',
                    '{{location region="northwest"}}' => 'Northwest region locations',
                    '{{location state="CA"}}' => 'California locations',
                    '{{location brand="mc" state="WA"}}' => 'Mission Connection WA locations'
                )
            ),
            'breadcrumbs' => array(
                'description' => 'Generates breadcrumb navigation schema',
                'attributes' => array(),
                'examples' => array(
                    '{{breadcrumbs}}' => 'Current page breadcrumbs'
                )
            )
        );
    }
}