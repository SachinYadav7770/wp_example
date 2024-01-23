<?php

function main_heads(){
	wp_enqueue_script('main_js_file', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
	wp_enqueue_script('ajax_js_file', get_theme_file_uri('/js/ajax_js.js'), NULL, '1.0', true);
	wp_enqueue_style('fonts_family', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('social_icon', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('main_style', get_stylesheet_uri());
	wp_register_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js', null, null, true );
	wp_enqueue_script('jQuery');
	wp_localize_script('ajax_js_file','ajaxHelpData', array(
		'nonce' => wp_create_nonce('wp_rest')
	));
}

add_action('wp_enqueue_scripts', 'main_heads');

function ex_theme_setup() {
	add_theme_support('title-tag');
}

add_action('after_setup_theme', 'ex_theme_setup');

add_action('wp_ajax_contact_us', 'ajax_contact_us');
function ajax_contact_us(){
	// wp_send_json_success('test');
	$arr = [];
	wp_parse_str($_POST['contact_us'],$arr);
	global $wpdb;
	global $table_prefix;
	$table=$table_prefix.'contact_us';
	$result=$wpdb->insert($table,[
		"name"=>$arr['name'],
		"email"=>$arr['email']
	]);
	// $result=0;
	if($result>0){
		wp_send_json_success("Data inserted");
	}else{
		wp_send_json_error("Please try again");
	}

}

add_action('wp_ajax_sachin_plugin_delete_btn', 'plugin_delete_btn');
function plugin_delete_btn(){
	global $wpdb;
	global $table_prefix;
	$table=$table_prefix.'sachin_plugin';
	if($wpdb->query("DELETE FROM $table WHERE id in(".$_GET['s_id'].")")){
		wp_send_json_success("Data Deleted Successfully");
	}else{
		wp_send_json_error("Please try again");
	}

}

add_action('wp_ajax_sachin_plugin_edit_btn', 'sachin_plugin_edit_btn');
function sachin_plugin_edit_btn(){
	global $wpdb;
	global $table_prefix;
	$table=$table_prefix.'sachin_plugin';
	$sql = "Select * from $table WHERE id = ".$_POST['e_id'];
	$result=$wpdb->get_results($sql); 
	$count = 1 ;
	$message .= "<form name='searchdata' id='search_form' action='?page=Sachin_Plugin%2FSachin_Plugin.php' method='post'><table border='0' width='100%' class='model-table'>";
	foreach ($result as $list) {
		$message .= "<tr><td>Name : </td><td><input type='hidden' name='id' value='".$list->id."'><input type='text' name='name' value='".$list->name."' id='name'></tr>";
		$count++;
	}
	$message .= "</table></form>";
	wp_send_json_success($message);

}

add_action('wp_ajax_sachin_plugin_add_btn', 'sachin_plugin_add_btn');
function sachin_plugin_add_btn(){
	// $message .= "<form name='searchdata' id='search_form' action='?page=Sachin_Plugin%2FSachin_Plugin.php' method='post'><table border='0' width='100%' class='model-table'>";
	// $message .= "<tr><td>Name : </td><td><input type='hidden' name='id' value='0'><input type='text' name='name' value='' id='name'></tr>";

	// $message .= "</table></form>";
	wp_send_json_success('fsfsfgs');

}

function get_info() {

   // The $_REQUEST contains all the data sent via ajax 
   if ( isset($_REQUEST) ) {

       $infos = json_encode($_REQUEST['my_info']);

       // Now we'll return it to the javascript function
       // Anything outputted will be returned in the response
       echo $infos;

       // If you're debugging, it might be useful to see what was sent in the $_REQUEST
       print_r($_REQUEST);

   }

   // Always die in functions echoing ajax content or it will display 0 or another word
  die();
}

add_action( 'wp_ajax_crawler_info', 'get_info' );
add_action( 'wp_ajax_nopriv_crawler_info', 'get_info' );

?>