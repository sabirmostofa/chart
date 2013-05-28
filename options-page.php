<?php
global $wpdb;
$growth_page  = get_permalink(get_option('wp_growth_page_number'));


// db update

if(isset($_POST['update_submit'])){
	$this->update_list($this->data_url);
}


//membeship update
if( isset($_POST['membership-submit'] )):
update_option( 'wp_wb_memberships', $_POST['members'] );

endif;


//if setting submited
if (isset($_POST['earlybird-submit'])):
    $_POST = array_map(create_function('$a', 'return trim($a);'), $_POST);
    update_option('wp_wb_earlybird_date',$_POST['earlybird_date']);

endif;

//set earlybird
$earlybird_date = get_option('wp_wb_earlybird_date');



// If new city submitted
if (isset($_POST['city-submit'])):
    $_POST = array_map(create_function('$a', 'return trim($a);'), $_POST);
    extract($_POST);
    if (strlen($city_name) !== 0 && strlen($city_url) !== 0)        
        if( $this -> not_in_table($city_name) )
        $res = $wpdb->query("insert into $this->table (city_name, city_url) values('$city_name', '$city_url')");
   

endif;





?>

<div class="wrap">
    <form action ='' method='post'>
       
<input class='button-primary' type='submit' name ='update_submit' value='update country list'/>
</form>
</div>

<div style="clear:both;width:200px;heigth:20px"></div>
