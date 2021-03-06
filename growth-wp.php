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
        $this->csv_dir = WP_PLUGIN_DIR.'/growth/csv/';
       
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
	$c == include 'front_end.php';
	
	return $c;

	
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
        if ($post->ID == get_option('wp_growth_page_number') ) {
            wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-datepicker');
			wp_enqueue_style('datepicker', plugins_url('css/ui-lightness/jquery-ui-1.8.16.custom.css', __FILE__));
            if (!(is_admin())) {
                // wp_enqueue_script('wpvr_boxy_script', plugins_url('/' , __FILE__).'js/boxy/src/javascripts/jquery.boxy.js');
                
                wp_enqueue_script('wpgrowth_validate_script', plugins_url('/', __FILE__) . 'js/jquery.validate.min.js');
                wp_enqueue_script('wpgrowth_front_script', plugins_url('/', __FILE__) . 'js/script_front.js');
                wp_localize_script('wpgrowth_front_script', 'wpvrSettings', array(
                    'ajaxurl' => home_url('/').'wp-admin/admin-ajax.php',
                    'pluginurl' => plugins_url('/', __FILE__),
                 
                ));
            }
        }
    }

    function front_css() {
		global $post;
        if ($post->ID != get_option('wp_growth_page_number') ) return;
        if (!(is_admin())):
            wp_enqueue_style('wpgrowth_front_css', plugins_url('/', __FILE__) . 'css/style_front.css');
        endif;
    }



    

// end of create_table



function list_files($src='cdc'){
	$files= array();
	$f = array();
	if ($handle = opendir($this->csv_dir . "$src/boys")) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $files[] = substr($entry, 0, -4);
        }
    }
    closedir($handle);
}

foreach($files as $k=> $file):
	$file = explode('_', $file);
	$typ=explode('-',$file[0]);
	$f[$k]['type'][]=$typ[0];	
	$f[$k]['type'][]=$typ[1];
		
	$unit=explode('-',$file[1]);
	$f[$k]['unit'][]=$unit[0];	
	$f[$k]['unit'][]=$unit[1];	

	$f[$k]['age_unit']= $file[2];

	$age = explode('-', $file[3] );
	$f[$k]['age'][]=$age[0];	
	$f[$k]['age'][]=$age[1];
endforeach;	

return $f;
	
}

// make dataset for the graph

function build_dataset($data){
	
	foreach($data as $d){
		
	}
	
	}




 

    function deactivation_tasks() {

        wp_clear_scheduled_hook('wp_rental_cron');
    }

}
