<?php
/**
 * Plugin Name: CP Plugin
 * Plugin URI:  https://cp-plugin.com/hello
 * Description: Hello sir, this is description
 * Version:     1.0.0
 * Author:      Sachin Yadav
 * 
*/

// /**
//  * Register the "book" custom post type
//  */
// function pluginprefix_setup_post_type() {
// 	register_post_type( 'book', ['public' => true ] ); 
// } 
// add_action( 'init', 'pluginprefix_setup_post_type' );

if(!defined('ABSPATH')){
    header('Location: /');
    die('sorry');
}

/**
 * Activate the plugin.
 */
function pluginprefix_activate() { 
    global $wpdb;
        $table_name = $wpdb->prefix . 'emp';

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            `e_id` int(255) NOT NULL AUTO_INCREMENT,
            `first_name` varchar(450) NOT NULL,
            `last_name` varchar(450) NOT NULL,
            `status` tinyint(1) NOT NULL,
            PRIMARY KEY (e_id)
          );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
        // dbDelta($sql);
        $success = empty($wpdb->last_error);
    
        return $success;

}
register_activation_hook( __FILE__, 'pluginprefix_activate' );

/**
 * Deactivation hook.
 */
function pluginprefix_deactivate() {
    global $wpdb;
        $table_name = $wpdb->prefix . 'emp';

        $sql = "DROP TABLE IF EXISTS $table_name ;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
        $success = empty($wpdb->last_error);
    
        return $success;
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivate' );

// function wpdocs_selective_js_loading() {
// 	if ( is_page( ['home', 'about', 'contact'] ) ) {
// 		wp_enqueue_script( 'your-script', plugin_dir_url( __FILE__ ). '/js/cp-script.js', array(), '1.0.0', true );
// 	}
// }
// add_action( 'wp_enqueue_scripts', 'wpdocs_selective_js_loading' );

// function enqueue_scripts() {
// 	wp_enqueue_script( 'custom-js', plugin_dir_url( __FILE__ ) . 'js/cp-script.js', array( 'jquery' ), '', true );
// 	wp_enqueue_style( 'style-css', plugin_dir_url( __FILE__ ) . 'css/style.css' );
// }
// add_action( 'wp_enqueue_scripts', 'enqueue_scripts');

function admin_enqueue_scripts() {
    
    wp_register_script( 'bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js' );
    wp_enqueue_script( 'bootstrap_js' );
    // wp_register_script( 'jQuery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js' );
    // wp_enqueue_script( 'jQuery' );
    wp_enqueue_style( 'bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');

    // $inline_script = 'var ajaxAdminUrl = "' . admin_url('admin.php') . '";';
    wp_add_inline_script('jquery', sprintf( 'var ajaxAdminUrl = %s;', wp_json_encode( admin_url('admin.php') ) ), 'before' );
	wp_enqueue_script( 'custom-js', plugin_dir_url( __FILE__ ) . 'js/cp-script.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'style-css', plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'admin_enqueue_scripts', 'admin_enqueue_scripts');


function cp_shortcode(){

   $args = array(
        // 'cat' => 1
        'post_type' => 'post'
    );
    // The Query
    $the_query = new WP_Query( $args );
    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<ul>';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            echo '<li>' . get_the_title() .' --> '. get_the_content() . '</li>';
        }
        echo '</ul>';
    } else {
        // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();
//    wp_reset_postdata();
//    $html = ob_get_clean();
}

add_shortcode('cp-sc', 'cp_shortcode');

/** Step 2 (from text above). */
add_action( 'admin_menu', 'cp_plugin_menu' );

/** Step 1. */
function cp_plugin_menu() {
    add_menu_page('Page title', 'Top-level menu title', 'manage_options', 'my-top-level-handle', 'cp_magic_function');
    add_submenu_page( 'my-top-level-handle', 'Page title', 'Sub-menu title', 'manage_options', 'my-submenu-handle', 'cp_sub_function');
}

/** Step 3. */
function cp_sub_function() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    $results = emp_data();
    include 'admin/emp.php';
}

function cp_magic_function() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}

add_action( 'wp_ajax_my_action', 'my_action' );

function my_action() {
    
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    $results = emp_data($_POST['search']);

    ob_start();
    include('admin/empDataTable.php');
    $file1 = ob_get_clean();
    $response=array();

    //of course below code doesn't work
    $response['html'] = $file1;
    echo json_encode($response);
	wp_die(); // this is required to terminate immediately and return a proper response
}

function emp_data($requestSearchText = '', $emp_id = '') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'emp';
    $sql = "SELECT * FROM $table_name ";
    if(!empty($emp_id)){
        $sql .= "WHERE e_id = '".$emp_id."'";
    }else{
        $sql .= "WHERE concat(first_name,last_name) like '%".$requestSearchText."%'";
    }
    // exit($sql);
    $results = $wpdb->get_results($sql);

    return $results;
	// if ( !current_user_can( 'manage_options' ) )  {
	// 	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	// }
    // // echo $_GET['search'];
    // include 'admin/empDataTable.php';

	wp_die(); // this is required to terminate immediately and return a proper response
}

function edit_employee(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    $result = !empty($_POST['emp_id']) ? emp_data('', $_POST['emp_id']) : [];
    // print_r($_POST);
    $data = [
        'e_id' => $result[0]->e_id ?? '',
        'first_name' => $result[0]->first_name ?? '',
        'last_name' => $result[0]->last_name ?? '',
        'status' => $result[0]->status ?? ''
    ];
// print_r($data);
// exit();
    ob_start();
    include('admin/empInputForm.php');
    $file1 = ob_get_clean();
    $response=array();
    //of course below code doesn't work
    $response['html'] = $file1;
    echo json_encode($response);
	wp_die(); // this is required to terminate immediately and return a proper response
    // admin\empEditEmployee.php
}

add_action( 'wp_ajax_edit_employee', 'edit_employee' );



function store_employee(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'emp';
    // $formData = unserialize($_POST['formData']);
    parse_str($_POST['formData'], $formData);
    // print_r($searcharray);
    $data = [
        'first_name' => $formData['first_name'],
        'last_name'    => $formData['last_name'],
        'status' => ($formData['status'] == 'active') ? 1 : 0,
    ];
// print_r($formData);
    if(!empty($formData['e_id'])){
        $wherecondition=array('e_id'=>$formData['e_id']);
        $wpdb->update($table_name, $data, $wherecondition);
    }else{
        $wpdb->insert($table_name, $data);
    }
    $success = empty($wpdb->last_error);
    echo json_encode(['response' => $success]);
    // return json_encode(['response' => $success]);
    // return my_action();
//     $result = emp_data('', $_POST['emp_id']);
//     $data = [
//         'e_id' => $result[0]->e_id ?? '',
//         'first_name' => $result[0]->first_name ?? '',
//         'last_name' => $result[0]->last_name ?? '',
//         'status' => $result[0]->status ?? ''
//     ];
// // print_r($data);
// // exit();
//     ob_start();
//     include('admin/empInputForm.php');
//     $file1 = ob_get_clean();
//     $response=array();
//     //of course below code doesn't work
//     $response['html'] = $file1;
//     echo json_encode($response);
	wp_die(); // this is required to terminate immediately and return a proper response
    // admin\empEditEmployee.php
}

add_action( 'wp_ajax_store_employee', 'store_employee' );
?>