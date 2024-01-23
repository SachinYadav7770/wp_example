<?php 
/*
Plugin Name: Sachin Plugin
Plugin URI:	https://www.youtube.com/watch?v=Gxw4CHs3hDE&list=PL5WuU0t4Tw-Ub-0B9YPVp-Lk8i_rDNzUK&index=1
Description: This is written by Sachin Yadav
Author: Sachin Yadav
Author URI:https://www.youtube.com/watch?v=Gxw4CHs3hDE&list=PL5WuU0t4Tw-Ub-0B9YPVp-Lk8i_rDNzUK&index=1
Version:1.0
*/

register_activation_hook(__FILE__,'sachin_plugin_activation');
register_deactivation_hook(__FILE__,'sachin_plugin_deactivation');

function sachin_plugin_activation(){
	global $wpdb;
	global $table_prefix;
	$table = $table_prefix.'sachin_plugin';
	$sql = "CREATE TABLE IF NOT EXISTS `$table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
";
	$result=$wpdb->query($sql);
	// if(!empty($result)){
	// 	print_r($result);
	// }else{
	// 	echo "not";
	// }
}
function sachin_plugin_deactivation(){

}

function your_script_enqueue() {
   wp_enqueue_script( 'bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'), NULL, true );
   
   wp_enqueue_style( 'bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css', false, NULL, 'all' );
//    wp_enqueue_style( 'custom_style', get_template_directory_uri() . '/css/your_style.css', array(), '1.0.0', 'all');
 
//    wp_enqueue_script( 'custom_js', get_template_directory_uri() . '/js/custom.js' ); 
}

add_action( 'wp_enqueue_scripts', 'your_script_enqueue' );


add_action('admin_menu','sachin_plugin_menu');

function sachin_plugin_menu(){
	add_menu_page('Sachin Plugin','Sachin Plugin', 'manage_options', __FILE__ ,'sachin_plugin_page','','25');	
}
function sachin_plugin_page(){
	echo '<style>.update-nag {display: none}</style>';
	include('sachin_plugin_page.php'); your_script_enqueue();
}

add_shortcode('sachin_plugin_page_shortcode','sachin_plugin_page_code');
function sachin_plugin_page_code(){
	$message = '';
	global $wpdb;
	global $table_prefix;
	$table = $table_prefix.'sachin_plugin';
	$sql = "Select * from $table";
	$result=$wpdb->get_results($sql); 
	$count = 1 ;
	$message .= "<table id='customers'><tr><th>S.No</th><th>Name</th></tr>";
	foreach ($result as $list) {
		$message .= "<tr><td>".$count."</td><td>".$list->name."</td></tr>";
		$count++;
	}
	$message .= "</table>";

	return $message;
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

 add_action( 'wp_ajax_nopriv_my_php_ajax_function', 'my_php_ajax_function' );
add_action( 'wp_ajax_my_php_ajax_function', 'my_php_ajax_function' );
function my_php_ajax_function(){
	if ( wp_verify_nonce( $_POST['_wpnonce'], 'wp_rest' ) ){
			echo json_encode(
				array(
					'youSent' => $_POST['foo']
				)
			);
			exit;

	} else {
		echo 'nonce check failed';
		exit;
	}
}

add_action('wp_enqueue_scripts', 'my_enqueue2');
function my_enqueue2($hook) {
	wp_enqueue_script( 'ajax-script',
		plugins_url( '/my-jquery.js', __FILE__ ),
		array('jquery'),
		false,
		true
	);
	$rest_nonce = wp_create_nonce( 'wp_rest' );
	wp_localize_script( 'ajax-script', 'my_var', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce' => $rest_nonce,
	));
}
?>