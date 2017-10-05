<?php
/*
Plugin Name: Library Book Search Plugin
Plugin URI: #
Description: Plugin For Library Book Search
Version: 1.0.0
Author: Keyur Padaria
Author URI: #
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	//css and script
	
	function lbspcss() {
    wp_register_style( 'bootstrap_css',  plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css' );
	wp_register_style( 'bootstrap-theme-css',  plugin_dir_url( __FILE__ ) . 'css/bootstrap-theme.min.css' );
	wp_register_style( 'jquery-ui_css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
	wp_register_style( 'style_ui', 'https://resources/demos/style.css' );
    wp_enqueue_style( 'bootstrap_css' );
	wp_enqueue_style( 'bootstrap-theme-css');
	wp_enqueue_style( 'jquery-ui_css');
	wp_enqueue_style( 'style_ui');
	wp_enqueue_script( 'jQuery_min','https://code.jquery.com/jquery-3.2.1.min.js','',true);
	wp_enqueue_script( 'jQuery_UI','https://code.jquery.com/ui/1.12.1/jquery-ui.js','',true);
	
	wp_enqueue_script( 'Main_Js',plugin_dir_url( __FILE__ ) . 'js/main.js','',true);
    wp_register_style( 'page-style',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
    wp_enqueue_style( 'page-style');
	//wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
	}
	add_action( 'wp_enqueue_scripts', 'lbspcss' );

	//require files
	add_action('init','register_book_posttype');	
    add_action( 'init', 'create_book_taxonomies', 0 );	
	include_once(dirname(__FILE__).'/ajax_search.php');
	include_once(dirname(__FILE__).'/shortcode.php');

function myplugin_activate() {

    register_book_posttype();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'myplugin_activate' );

// Register post type book
function register_book_posttype() {
	$labels = array(
		'name'               => _x( 'Books', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Book', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Books', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'book', $args );
	//flush_rewrite_rules();
}

// create two taxonomies, Author and Publisher for the post type "book"
function create_book_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Author', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Author', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Author', 'textdomain' ),
		'all_items'         => __( 'All Author', 'textdomain' ),
		'parent_item'       => __( 'Parent Author', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Author:', 'textdomain' ),
		'edit_item'         => __( 'Edit Author', 'textdomain' ),
		'update_item'       => __( 'Update Author', 'textdomain' ),
		'add_new_item'      => __( 'Add New Author', 'textdomain' ),
		'new_item_name'     => __( 'New Author Name', 'textdomain' ),
		'menu_name'         => __( 'Author', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'author' ),
	);

	register_taxonomy( 'author', array( 'book' ), $args );

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Publisher', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Publisher', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Publisher', 'textdomain' ),
		'popular_items'              => __( 'Popular Publisher', 'textdomain' ),
		'all_items'                  => __( 'All Publisher', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Publisher', 'textdomain' ),
		'update_item'                => __( 'Update Publisher', 'textdomain' ),
		'add_new_item'               => __( 'Add New Publisher', 'textdomain' ),
		'new_item_name'              => __( 'New Publisher Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate Publisher with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove Publisher', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used Publisher', 'textdomain' ),
		'not_found'                  => __( 'No Publisher found.', 'textdomain' ),
		'menu_name'                  => __( 'Publisher', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'publisher' ),
	);

	register_taxonomy( 'publisher', 'book', $args );
}


 // Add meta box for book post type
 
 function register_meta_book() {
    add_meta_box( 'book_meta', __( 'Custome Fields', 'textdomain' ), 'book_fields_meta', 'book' );
}
add_action( 'add_meta_boxes', 'register_meta_book' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function book_fields_meta( $post ) {
    // display fields
	$price = '<label for="price" style="width:150px; display:inline-block;">'. esc_html__('Price *', 'text-domain') .'</label>';
    $price_val = get_post_meta( $post->ID, 'price', true );
    $price .= '<input type="number" name="price" id="price_field" class="price_field" required="yes" value="'. esc_attr($price_val) .'" style="width:300px;"/>';
	$fields .='<br><br>';
    $fields .=  '<label for="star_rating" style="width:150px; display:inline-block;">'. esc_html__('Star Rating *', 'text-domain') .'</label>';
	$star_rating_val = get_post_meta($post->ID, 'star_rating', true );
   /* $fields .= "<select name='star_rating' style='width:150px;' required='yes'>
	              <option value=''>Select Rating</option>
				  <option value='1'". selected( $star_rating_val, 1 ).">1</option>
				  <option value='2'". selected( $star_rating_val, 2 ).">2</option>
				  <option value='3'". selected( $star_rating_val, 3 ).">3</option>
				  <option value='4'". selected( $star_rating_val, 4 ).">4</option>
				  <option value='5'". selected( $star_rating_val, 5 ).">5</option>
				</select>"; */
				echo $price;
				echo $fields;
				?>
				<select name='star_rating' style='width:150px;' required='yes'>
	              <option value=''>Select Rating</option>
				  <option value='1'<?php selected( $star_rating_val, 1 );?>>1</option>
				  <option value='2'<?php selected( $star_rating_val, 2 );?>>2</option>
				  <option value='3'<?php selected( $star_rating_val, 3 );?>>3</option>
				  <option value='4'<?php selected( $star_rating_val, 4 );?>>4</option>
				  <option value='5'<?php selected( $star_rating_val, 5 );?>>5</option>
				</select>
				<?php
    
	
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
	function save_meta_data_for_book( $post_id ) {
	   // This will check if post type is book or not
		 global $post;
		if ($post->post_type != 'book'){
			return;
		}
		$price = $_POST['price'];
		$start_rating = $_POST['star_rating'];
		update_post_meta($post_id,'price',$price);
		update_post_meta($post_id,'star_rating',$start_rating);
	}
	add_action( 'save_post', 'save_meta_data_for_book' );
 

function footerScript()
{
	?>
<script type="text/javascript">
			
	$( document ).ready(function(){

  	$("#search_id").click(function()
  	{
	    book   		= $("#book_name").val();
		author 		= $("#author_id").val();
		rating 		= $("#rating_id").val();
		publisher 	= $("#publisher_id").val();
		min_price 	= $("#min_price").html();
		max_price 	= $("#max_price").html();
		ajax_url    =  "<?php echo admin_url( 'admin-ajax.php' );?>";
		data 		= {action:'search_result_fun',book:book,author:author,rating:rating,publisher:publisher,min_price:min_price,max_price:max_price}
		$("#result").html('Loading..');
        $.post(ajax_url,data,function(response){

           		$("#result").html(response);
		});
		return false;
  	});
  	  });

</script>
	<?php
}
 add_action('wp_footer','footerScript');
 
 
 /* Filter the single_template with our custom function*/
add_filter('template_include', 'my_custom_template');

function my_custom_template($template) {

    $post_types = array('book');

    if (is_singular($post_types)) {
        $template = dirname( __FILE__ ) .'/single-book.php';
    }

    return $template;

}

