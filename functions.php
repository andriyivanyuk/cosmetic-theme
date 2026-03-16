<?php

if (!defined('ABSPATH')) {
    exit;
}

function de_shop_theme_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'de_shop_theme_setup');

function de_shop_get_catalog_url(): string
{
    $catalog_page = get_page_by_path('catalog');

    if ($catalog_page instanceof WP_Post) {
        return get_permalink($catalog_page);
    }

    $products_archive_url = get_post_type_archive_link('de_product');

    if (is_string($products_archive_url) && $products_archive_url !== '') {
        return $products_archive_url;
    }

    return home_url('/catalog/');
}

function de_shop_get_order_url(): string
{
    $order_page = get_page_by_path('zamovlennya');

    if ($order_page instanceof WP_Post) {
        return get_permalink($order_page);
    }

    $request_page = get_page_by_path('request');

    if ($request_page instanceof WP_Post) {
        return get_permalink($request_page);
    }

    return home_url('/request/');
}

function de_shop_get_thank_you_url(): string
{
    $thank_you_page = get_page_by_path('thank-you');

    if ($thank_you_page instanceof WP_Post) {
        return get_permalink($thank_you_page);
    }

    $thank_you_ua_page = get_page_by_path('dyakuyemo');

    if ($thank_you_ua_page instanceof WP_Post) {
        return get_permalink($thank_you_ua_page);
    }

    return home_url('/thank-you/');
}

function de_shop_theme_enqueue_assets(): void
{
    $theme_uri = get_stylesheet_directory_uri();
    $version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'de-shop-bele-plugins',
        $theme_uri . '/assets/css/plugins.css',
        [],
        $version
    );

    wp_enqueue_style(
        'de-shop-bele-bootstrap',
        $theme_uri . '/assets/css/bootstrap.min.css',
        ['de-shop-bele-plugins'],
        $version
    );

    wp_enqueue_style(
        'de-shop-bele-style',
        $theme_uri . '/assets/css/style.css',
        ['de-shop-bele-bootstrap'],
        $version
    );

    wp_enqueue_style(
        'de-shop-bele-responsive',
        $theme_uri . '/assets/css/responsive.css',
        ['de-shop-bele-style'],
        $version
    );

    wp_enqueue_style(
        'de-shop-theme-style',
        get_stylesheet_uri(),
        ['de-shop-bele-responsive'],
        $version
    );

    wp_enqueue_script(
        'de-shop-bele-modernizr',
        $theme_uri . '/assets/js/vendor/modernizr-3.6.0.min.js',
        [],
        $version,
        false
    );

    wp_enqueue_script(
        'de-shop-bele-cookie',
        $theme_uri . '/assets/js/vendor/jquery.cookie.js',
        ['jquery'],
        $version,
        true
    );

    wp_enqueue_script(
        'de-shop-bele-wow',
        $theme_uri . '/assets/js/vendor/wow.min.js',
        ['jquery'],
        $version,
        true
    );

    wp_enqueue_script(
        'de-shop-bele-popper',
        $theme_uri . '/assets/js/popper.min.js',
        [],
        $version,
        true
    );

    wp_enqueue_script(
        'de-shop-bele-bootstrap',
        $theme_uri . '/assets/js/bootstrap.min.js',
        ['jquery', 'de-shop-bele-popper'],
        $version,
        true
    );

    $plugins_js_path = get_stylesheet_directory() . '/assets/js/plugins.js';
    $plugins_js_version = file_exists($plugins_js_path) ? (string) filemtime($plugins_js_path) : $version;

    wp_enqueue_script(
        'de-shop-bele-plugins',
        $theme_uri . '/assets/js/plugins.js',
        ['jquery', 'de-shop-bele-bootstrap', 'de-shop-bele-wow'],
        $plugins_js_version,
        true
    );

    wp_enqueue_script(
        'de-shop-bele-lazysizes',
        $theme_uri . '/assets/js/lazysizes.js',
        [],
        $version,
        true
    );

    $main_js_path = get_stylesheet_directory() . '/assets/js/main.js';
    $main_js_version = file_exists($main_js_path) ? (string) filemtime($main_js_path) : $version;

    wp_enqueue_script(
        'de-shop-bele-main',
        $theme_uri . '/assets/js/main.js',
        ['jquery', 'de-shop-bele-plugins', 'de-shop-bele-cookie', 'de-shop-bele-lazysizes'],
        $main_js_version,
        true
    );

    $cart_js_path = get_stylesheet_directory() . '/assets/js/de-shop-cart.js';
    $cart_js_version = file_exists($cart_js_path) ? (string) filemtime($cart_js_path) : $version;

    wp_enqueue_script(
        'de-shop-cart-script',
        $theme_uri . '/assets/js/de-shop-cart.js',
        ['jquery', 'de-shop-bele-main'],
        $cart_js_version,
        true
    );

    if (is_singular('de_product')) {
        wp_enqueue_script(
            'de-shop-bele-photoswipe',
            $theme_uri . '/assets/js/vendor/photoswipe.min.js',
            [],
            $version,
            true
        );

        wp_enqueue_script(
            'de-shop-bele-photoswipe-ui',
            $theme_uri . '/assets/js/vendor/photoswipe-ui-default.min.js',
            ['de-shop-bele-photoswipe'],
            $version,
            true
        );
    }

    if (is_front_page()) {
        wp_enqueue_script(
            'de-shop-home-fixes',
            $theme_uri . '/assets/js/de-shop-home-fixes.js',
            ['jquery', 'de-shop-bele-main'],
            $version,
            true
        );
    }

    if (is_page('catalog') || is_page_template('page-catalog.php') || is_post_type_archive('de_product')) {
        $catalog_css_path = get_stylesheet_directory() . '/assets/css/de-shop-catalog.css';
        $catalog_js_path = get_stylesheet_directory() . '/assets/js/de-shop-catalog.js';
        $catalog_css_version = file_exists($catalog_css_path) ? (string) filemtime($catalog_css_path) : $version;
        $catalog_js_version = file_exists($catalog_js_path) ? (string) filemtime($catalog_js_path) : $version;

        wp_enqueue_script('jquery-ui-slider');

        wp_enqueue_style(
            'de-shop-catalog-style',
            $theme_uri . '/assets/css/de-shop-catalog.css',
            ['de-shop-theme-style'],
            $catalog_css_version
        );

        wp_enqueue_script(
            'de-shop-catalog-script',
            $theme_uri . '/assets/js/de-shop-catalog.js',
            ['jquery', 'de-shop-bele-main'],
            $catalog_js_version,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'de_shop_theme_enqueue_assets');

function de_shop_render_virtual_thank_you_page(): void
{
    if (!is_404()) {
        return;
    }

    global $wp;

    $request_path = isset($wp->request) ? trim((string) $wp->request, '/') : '';

    if ($request_path !== 'thank-you' && $request_path !== 'dyakuyemo') {
        return;
    }

    $template_path = get_stylesheet_directory() . '/page-thank-you.php';

    if (!file_exists($template_path)) {
        return;
    }

    status_header(200);
    nocache_headers();
    include $template_path;
    exit;
}
add_action('template_redirect', 'de_shop_render_virtual_thank_you_page', 0);
