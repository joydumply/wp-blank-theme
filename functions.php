<?php
define('CUSTOM_THEME_VERSION', '1.0');


add_theme_support('post-thumbnails');
set_post_thumbnail_size(200, 200, true);


if (!function_exists('dd')) {
    function dd($arg)
    {
        printf('<pre>%s</pre>', print_r($arg, true));
        die;
    }
}

function enqueue_global_ajaxurl()
{
    $ajaxurl = admin_url('admin-ajax.php');

    global $wp_scripts;

    foreach ($wp_scripts->queue as $script) {
        wp_localize_script($script, 'ajax_object', 
            array(
            'ajaxurl' => $ajaxurl,
            'nonce' => wp_create_nonce('ajax_nonce')
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_global_ajaxurl');

function custom_theme_enqueue_styles_and_scripts()
{
    if (!is_admin()) {

        wp_enqueue_style('style', get_stylesheet_uri());
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles_and_scripts');

function theme_setup()
{
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_setup');




if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'     => 'Site Options',
        'menu_title'    => 'Site Options',
        'menu_slug'     => 'theme-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false
    ));
}




if (!function_exists('load_more_articles')) {
    function load_more_articles(){
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_articles_nonce')) {
            wp_send_json_error('Invalid nonce');
            wp_die();
        }
        if (!isset($_POST['page']) || !is_numeric($_POST['page'])) {
            wp_send_json_error('Invalid page number');
            wp_die();
        }
        $page = intval($_POST['page']);
        $args = array(
            'post_type' => 'post',
            'paged' => $page,
        );
    
        $query = new WP_Query($args);
    
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                // Get Template Part for article item
            }
            wp_reset_postdata();
            wp_send_json_success('Articles loaded successfully');
        } else {
            wp_send_json_error('No more articles');
        }
    
        wp_die();
    }
    add_action('wp_ajax_load_more_articles', 'load_more_articles');
    add_action('wp_ajax_nopriv_load_more_articles', 'load_more_articles');
}

if (!function_exists('get_acf_image')) {
    function get_acf_image($image = null, $only_url = false)
    {
        $image_url = '';
        $image_alt = '';
        if (is_numeric($image)) {
            $image_url = wp_get_attachment_url($image, 'full');
            $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
        }

        if (is_array($image) && isset($image['url'])) {
            $image_url = $image['url'];
            $image_alt = $image['alt'];
        }

        if (is_string($image)) {
            $image_url = $image;
        }
        if (!empty($image_url)) {
            if ($only_url) {
                return $image_url;
            }
            return '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
        }

        return '';
    }
}

if (!function_exists('theme_string_shortify')) {
    function theme_string_shortify($str = '', $length = 100)
    {
        if (!empty($str) && strlen($str) > $length) {
            if (!is_numeric($length)) {
                $length = 100;
            }
            return substr($str, 0, $length) . '...';
        }
        return $str;
    }
}


if (file_exists(get_stylesheet_directory() . '/inc/custom-post-types.php')) {
    require_once get_stylesheet_directory() . '/inc/custom-post-types.php';
}
