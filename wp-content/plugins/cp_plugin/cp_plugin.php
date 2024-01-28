<?php
/**
 * Plugin Name: CP Plugin
 * Plugin URI:  https://cp-plugin.com/hello
 * Description: Hello sir, this is description
 * Version:     1.0.0
 * Author:      Sachin Yadav
 * 
*/


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
    
    wp_register_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js' );
    wp_enqueue_script( 'jQuery' );

    wp_register_script( 'toastify_js', 'https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.js' );
    wp_enqueue_script( 'toastify_js' );
    // <!-- TOASTIFY -->
    // <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    // <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    wp_enqueue_style( 'bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
    wp_enqueue_style( 'toastify_css', 'https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css');

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

    $results = $wpdb->get_results($sql);
    return $results;
	wp_die();
}

function edit_employee(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    $result = !empty($_POST['emp_id']) ? emp_data('', $_POST['emp_id']) : [];
    
    $data = [
        'e_id' => $result[0]->e_id ?? '',
        'first_name' => $result[0]->first_name ?? '',
        'last_name' => $result[0]->last_name ?? '',
        'status' => $result[0]->status ?? ''
    ];

    ob_start();
    include('admin/empInputForm.php');
    $file1 = ob_get_clean();
    $response=array();
    $response['html'] = $file1;
    echo json_encode($response);
	wp_die();
}

add_action( 'wp_ajax_edit_employee', 'edit_employee' );



function store_employee(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'emp';
    parse_str($_POST['formData'], $formData);

    $data = [
        'first_name' => $formData['first_name'],
        'last_name'    => $formData['last_name'],
        'status' => ($formData['status'] == 'active') ? 1 : 0,
    ];

    $message = '';
    if(!empty($formData['e_id'])){
        $wherecondition=array('e_id'=>$formData['e_id']);
        $wpdb->update($table_name, $data, $wherecondition);
        $message = 'Record modified in table';
    }else{
        $wpdb->insert($table_name, $data);
        $message = 'Record insert in table';
    }
    $success = empty($wpdb->last_error);
    $response = ['status' => $success, 'message' => $wpdb->last_error];
    if($success){
        $response['message'] = $message;
    }
    echo json_encode($response);
	wp_die();
}

add_action( 'wp_ajax_store_employee', 'store_employee' );



function delete_employee(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'emp';
    if(!empty($_POST['emp_id'])){
        $wherecondition=array('e_id'=>$_POST['emp_id']);
        $wpdb->delete( $table_name, $wherecondition);
    }
    $success = empty($wpdb->last_error) ?? 'false';
    $response = ['status' => $success, 'message' => $wpdb->last_error];
    if($success){
        $response['message'] = 'Record deleted from the table';
    }
    echo json_encode($response);
	wp_die();
}
add_action( 'wp_ajax_delete_employee', 'delete_employee' );


/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function cp_custom_init() {
	$labels = array(
		'name'                  => _x( 'Custom posts', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'Custom post', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'Custom posts', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'Custom post', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add New', 'textdomain' ),
		'add_new_item'          => __( 'Add New Custom post', 'textdomain' ),
		'new_item'              => __( 'New Custom post', 'textdomain' ),
		'edit_item'             => __( 'Edit Custom post', 'textdomain' ),
		'view_item'             => __( 'View Custom post', 'textdomain' ),
		'all_items'             => __( 'All Custom posts', 'textdomain' ),
		'search_items'          => __( 'Search custom posts', 'textdomain' ),
		'parent_item_colon'     => __( 'Parent custom posts:', 'textdomain' ),
		'not_found'             => __( 'No custom posts found.', 'textdomain' ),
		'not_found_in_trash'    => __( 'No custom posts found in Trash.', 'textdomain' ),
		'featured_image'        => _x( 'Custom post Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'archives'              => _x( 'Custom post archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
		'insert_into_item'      => _x( 'Insert into custom post', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this custom post', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
		'filter_items_list'     => _x( 'Filter custom posts list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
		'items_list_navigation' => _x( 'Custom posts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
		'items_list'            => _x( 'Custom posts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'cp_post' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies'         => array()
	);

	register_post_type( 'custom_post', $args );
}

add_action( 'init', 'cp_custom_init' );


/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 */
function add_custom_taxonomies() {
    // Add new "Locations" taxonomy to Posts
    register_taxonomy('location', 'custom_post', array(
      // Hierarchical taxonomy (like categories)
      'hierarchical' => true,
      // This array of options controls the labels displayed in the WordPress Admin UI
      'labels' => array(
        'name' => _x( 'Locations', 'taxonomy general name' ),
        'singular_name' => _x( 'Location', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Locations' ),
        'all_items' => __( 'All Locations' ),
        'parent_item' => __( 'Parent Location' ),
        'parent_item_colon' => __( 'Parent Location:' ),
        'edit_item' => __( 'Edit Location' ),
        'update_item' => __( 'Update Location' ),
        'add_new_item' => __( 'Add New Location' ),
        'new_item_name' => __( 'New Location Name' ),
        'menu_name' => __( 'Locations' ),
      ),
      // Control the slugs used for this taxonomy
      'rewrite' => array(
        'slug' => 'locations', // This controls the base slug that will display before each term
        'with_front' => false, // Don't display the category base before "/locations/"
        'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
      ),
    ));
  }
  add_action( 'init', 'add_custom_taxonomies', 0 );



  function cp_user_registration_shortcode(){

    if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    ob_start();
    include('public/userRegistrationForm.php');
    return ob_get_clean();
    
	wp_die();
 }
 
 add_shortcode('cp-user-registration-form', 'cp_user_registration_shortcode');
?>