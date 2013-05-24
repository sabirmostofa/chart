<?php

/*
  Plugin Name: WP-growth-chart
  Description: Generate Growth charts
  Version: 1.0
  Author: Sabirul Mostofa
  Author URI: mailto:sabirmostofa@gmail.com
 */

$wpGrowthChart = new wpGrowthChart();

class wpGrowthChart {

    public $table = '';
    public $image_dir = '';
    public $meta_box = array();

    function __construct() {

        $this->image_dir = plugins_url('/', __FILE__) . 'images/';
        $this->xml_file = plugins_url('/', __FILE__) . 'countries.xml';
        $this->data_url = 'http://api.worldbank.org/countries?per_page=400';
        //add_action('init', array($this, 'add_post_type'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'front_scripts'));
        add_action('wp_print_styles', array($this, 'front_css'));
        add_action('admin_menu', array($this, 'CreateMenu'), 50);

        add_filter('the_content', array($this, 'generate_content') );

        register_activation_hook(__FILE__, array($this, 'create_page'));
       // register_activation_hook(__FILE__, array($this, 'set_memberships'));
       // register_deactivation_hook(__FILE__, array($this, 'deactivation_tasks'));
    }

    function CreateMenu() {
        add_submenu_page('options-general.php', 'Growth Chart Settings', 'Growth Chart Settings', 'activate_plugins', 'wpGrowthChart', array($this, 'OptionsPage'));
    }
    
    function create_page(){		
		$page = array(
		'post_type' => 'page',
		'post_content' => '',
		'post_title' => 'Growth Chart',
		'post_author' => 1,
		'post_status' => 'publish'
		
		);
		
		if(!get_option('wp_growth_page_number')){
			$page_no = wp_insert_post($page);
			update_option('wp_growth_page_number', $page_no);
		}
	}
	
	function generate_content($content){
	global $post, $wpdb;
	$mem_page = get_option('wp_growth_page_number');
	if($post->ID != $mem_page)
		return $content;
	
	$mems = get_option('wp_wb_memberships');
	$countries = $wpdb->get_results(
	" select * from $this->table order by country ASC"
	);

/*
	$all_countries = array();
	foreach($countries as $single){
		$key = $single->country_id;
		$all_countries[$key] = $single->country;
	}	
	
	sort($all_countries);
*/
	$extra="<br/>Membership type: <select name='membership_types' id='mem_type'> ";
	foreach($mems as $key=>$val){
		$extra .= "<option value='$key'> {$val[name]} </option>";
	}
	
	$extra .= '</select><br/>';
	$extra .="Select a Country: <select name='country_name' id='wb_country'> ";
	
	foreach($countries as $single){
		$extra .= "<option value='{$single->country_id}'> {$single->country} </option>";
	}
		
	$extra .= "</select><br/><input type='button' id='get-due' value='Submit'/> <br/> <div id='mem_output'></div><br/>";
	return $content.$extra;
		
	
	}
	
	
	
    function OptionsPage() {
        include 'options-page.php';
    }



   

    function admin_scripts() {
		wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('datepicker', plugins_url('css/ui-lightness/jquery-ui-1.8.16.custom.css', __FILE__));
        wp_enqueue_script('wpgrowth_admin_script', plugins_url('/', __FILE__) . 'js/script_admin.js');
        wp_register_style('wpgrowth_admin_css', plugins_url('/', __FILE__) . 'css/style_admin.css', false, '1.0.0');
        wp_enqueue_style('wpgrowth_admin_css');

    }

    function front_scripts() {
        global $post;
        if (is_page() || is_single()) {
            wp_enqueue_script('jquery');
            if (!(is_admin())) {
                // wp_enqueue_script('wpvr_boxy_script', plugins_url('/' , __FILE__).'js/boxy/src/javascripts/jquery.boxy.js');
                wp_enqueue_script('wpgrowth_front_script', plugins_url('/', __FILE__) . 'js/script_front.js');
                wp_localize_script('wpgrowth_front_script', 'wpvrSettings', array(
                    'ajaxurl' => home_url('/').'wp-admin/admin-ajax.php',
                    'pluginurl' => plugins_url('/', __FILE__),
                 
                ));
            }
        }
    }

    function front_css() {
        if (!(is_admin())):
            wp_enqueue_style('wpgrowth_front_css', plugins_url('/', __FILE__) . 'css/style_front.css');
        endif;
    }



    

// end of create_table








 

    function deactivation_tasks() {

        wp_clear_scheduled_hook('wp_rental_cron');
    }

}
