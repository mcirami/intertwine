<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'catalyst-style' for the Catalyst theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script( 'main_js', get_template_directory_uri() . '-child/js/main.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


/**
 *
 *	My CODE
 *
 */


function create_post_type() {

    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

    register_post_type( 'models',
        array(
            'labels' => array(
                'name' => __( 'Models' ),
                'singular_name' => __( 'Model' ),
                'add_new' => ('Add New Model'),
                'add_new_item' => ('Add New Model'),
                'edit_item' => ('Edit Model'),
                'new_item' => ('New Model'),
                'view_item' => ('View Models'),
                'search_items' => ('Search Models'),
                'not_found' => ('No Model found'),
                'not_found_in_trash' => ('No Model found in Trash'),
                'parent_item_colon' => ('Parent Model:'),
                'menu_name' => ('Models'),
            ),
            'public' => true,
            'has_archive' => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_icon' => $actual_link . '/wp-content/themes/catalyst-child/images/models-icon.png',
            'supports' => array( 'title', 'thumbnail', 'author' ),
            'rewrite' => array( 'slug' => 'models' ),
            'show_in_rest' => true
        )
    );
}
add_action( 'init', 'create_post_type' );

function modify_post_type_supports() {
    remove_post_type_support( 'models', 'comments' );
}

add_action( 'init', 'modify_post_type_supports', 11 );

add_action('acf/save_post', 'my_save_post');

function my_save_post( $post_id )
{

    // bail early if not a models post
    if (get_post_type($post_id) !== 'models') {

        return;

    }


    // bail early if editing in admin
    if (is_admin()) {

        return;

    }



    // vars
    $post = get_post($post_id);

    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

    // get custom fields (field group exists for content_form)
    $name = get_field('name', $post_id);
    $email = get_field('email', $post_id);
    $phone = get_field('phone', $post_id);
    $gender = get_field('gender', $post_id);
    $ethnicity = get_field('ethnicity', $post_id);
    $birthday = get_field('birthday', $post_id);
    $height = get_field('height', $post_id);
    $bodyType = get_field('body', $post_id);
    $shoe = get_field('shoe', $post_id);
    $residence = get_field('residence', $post_id);
    $desc = get_field('description', $post_id);

    $modelName = strtolower($post->post_title);
    $modelName = preg_replace('/\s+/', '-', $modelName);

    $to = 'studio@fedelestudio.com';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $subject = $post->post_title . ' just registered';
    $body = $post->post_title . ' just registered.<br><br>To view their profile click here:<br>' . $actual_link .  '/models/' . $modelName;

    wp_mail( $to, $subject, $body, $headers );
}


// array of filters (field key => field name)
$GLOBALS['my_query_filters'] = array(
    'field_59d18ce14bd75'	=> 'gender',
    'field_59d18cfe4bd76'	=> 'ethnicity',
    'field_59d18d2f4bd78'	=> 'height',
    'field_59d18d3d4bd79'   => 'body_type',
    'field_59d18d434bd7a'   => 'shoe_size',
    'field_59d18d554bd7b'   => 'residence'
);


// action
add_action('pre_get_posts', 'my_pre_get_posts', 10, 1);

function my_pre_get_posts( $query ) {

    // bail early if is in admin
    if( is_admin() ) {
        return $query;
    }


    // bail early if not main query
    // - allows custom code / plugins to continue working
    if( !$query->is_main_query() ) return $query;

    // get meta query
    $meta_query = $query->get('meta_query');

    $meta_query = array(
        'relation' => 'AND',
    );

    foreach ($GLOBALS['my_query_filters'] as $key => $name) {

        if (isset($_GET[$name]) && (!empty($_GET[$name]))) {

            $values = explode(',', $_GET[$name]);

            $meta_query[] = array (
                'key'		=> $name,
                'value'		=> $values,
                'compare'	=> 'IN',
            );
        }
    }

    $query->set('meta_query', $meta_query);

    return $query;
}



function delete_post(){
    global $post;

    $deletepostlink= add_query_arg( 'frontend', 'true', get_delete_post_link( get_the_ID() ) );
    if (current_user_can('edit_post', $post->ID)) {
        echo '<span><a class="post-delete-link" onclick="return confirm(\'Are you sure to delete?\')" href="'.$deletepostlink.'">Delete Model</a></span>';
    }
}


add_action( 'parse_request', 'wpse132196_redirect_after_trashing_get' );
function wpse132196_redirect_after_trashing_get() {
    $cookie_name = "redirectLink";

    if ( array_key_exists( 'trashed', $_GET ) && $_GET['trashed'] = '1' ) {
        wp_redirect( $_COOKIE[$cookie_name] );
        exit;
    }
}